<?php

namespace SDTDL;
if (!defined('ABSPATH')) {
    exit;
}
define('SDTDL_VERSION', '2.1.3');

class SDTDL
{

    private $_path;
    private $_user_id;
    private $_options;
    private $_to_do_items = ['own' => [], 'affected' => []];
    private $_db_version = 4;
    private $_user_option;
    private $_is_network_admin;
    private $_user_can_affect_to_roles;
    private $_users_cannot_be_affected_to = [];
    private $_date_time_format;

    public const option_name = 'sdtdl_todo_list_items';

    public function __construct()
    {
        $this->_init_user();
        $this->_init_settings();
        $this->_path = plugins_url('', SDTDL_PLUGIN_FILE);
        $dashboard_setup_hook = 'wp_dashboard_setup';
        if ($this->_is_network_admin) {
            $dashboard_setup_hook = 'wp_network_dashboard_setup';
        }
        add_action($dashboard_setup_hook, [$this, 'widget_setup']);
        add_action('wp_footer', [$this, 'front_list']);
        add_action("wp_ajax_sdtdl_add_item", [$this, "add_item"]);
        add_action("wp_ajax_sdtdl_edit_item", [$this, "edit_item"]);
        add_action("wp_ajax_sdtdl_delete_item", [$this, "delete_item"]);
        add_action("wp_ajax_sdtdl_update_order", [$this, "update_order"]);
        add_action("wp_ajax_sdtdl_save_settings", [$this, "save_settings"]);
        add_action("wp_ajax_sdtdl_mark_complete", [$this, "mark_complete"]);
        add_action('deleted_user', [$this, "clear_affectations"]);
        add_action("init", [$this, 'load_text_domain']);
    }

    public function front_list(): void
    {
        if (is_admin() || $this->_user_option['extra']['front'] === 'false') {
            return;
        }
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_style('sdtdl', $this->_path . '/css/sdtdl-front.css', ['wp-jquery-ui-dialog'], SDTDL_VERSION);
        wp_enqueue_script('sdtdl', $this->_path . '/js/sdtdl-front.min.js', ['jquery-ui-dialog'], SDTDL_VERSION);
        $this->_localize_strings();
        //Make sure we use the user's language preferences on the front
        unload_textdomain('sortable-dashboard-to-do-list');
        switch_to_locale(get_user_locale());
        $this->load_text_domain();
        ob_start();
        require_once __DIR__ . '/../templates/list-front.php';
        echo ob_get_clean();
        restore_current_locale();
    }

    public function load_text_domain(): void
    {
        load_plugin_textdomain('sortable-dashboard-to-do-list', false, dirname(plugin_basename(SDTDL_PLUGIN_FILE)) . '/lang');
    }

    private function _init_user(): void
    {
        $this->_is_network_admin = is_network_admin();
        $this->_user_id = get_current_user_id();
        $this->_options = $this->_get_option();
        $this->_maybe_upgrade_db();
        $user = wp_get_current_user();
        $user_role = $user->roles[0];
        if (is_multisite() || in_array($this->_user_id, apply_filters('sdtdl_users_not_allowed_to_affect', []))) {
            $this->_user_can_affect_to_roles = ['nobody'];
        } elseif (current_user_can('administrator')) {
            $roles = wp_roles();
            $admin_roles = [];
            $min_user_capability = apply_filters('sdtdl_min_user_capability', 'edit_posts');
            foreach ($roles->roles as $role_name => $role_data) {
                if (isset($role_data['capabilities'][$min_user_capability]) && $role_data['capabilities'][$min_user_capability] === true) {
                    $admin_roles[] = $role_name;
                }
            }
            $this->_user_can_affect_to_roles = apply_filters('sdtdl_administrator_can_affect_to', $admin_roles);
        } elseif (current_user_can('editor')) {
            $this->_user_can_affect_to_roles = apply_filters('sdtdl_editor_can_affect_to', ['editor', 'author', 'contributor']);
        } else {
            $this->_user_can_affect_to_roles = apply_filters('sdtdl_' . $user_role . '_can_affect_to', [$user_role]);
        }
        $this->_users_cannot_be_affected_to = array_merge([$this->_user_id], apply_filters('sdtdl_' . $user_role . '_cannot_affect_to_users', [], $this->_user_id));
        $this->_users_cannot_be_affected_to = array_merge($this->_users_cannot_be_affected_to, apply_filters('sdtdl_never_affect_task_to_users', []));
        $this->_user_option = $this->_options[$this->_user_id] ?? [];
        $this->_set_to_do_items();
        $this->_get_affected_items();
        $this->_date_time_format = get_option('date_format') . ' ' . get_option('time_format');
    }

    private function _init_settings(): void
    {
        $user_settings = $this->_user_option['extra'] ?? [];
        if (!isset($user_settings['front'])) {
            $user_settings['front'] = 'false';
        }
        if (!isset($user_settings['side'])) {
            $user_settings['side'] = 'left';
        }
        if (!isset($user_settings['accent'])) {
            $user_settings['accent'] = '#2196F3';
        }
        $this->_user_option['extra'] = $user_settings;
    }

    private function _get_option($force_site = false): array
    {
        if ($this->_is_network_admin || $force_site === true) {
            return array_filter((array)get_site_option(self::option_name));
        }
        return array_filter((array)get_option(self::option_name));
    }

    private function _set_to_do_items(): void
    {
        $items = array_column($this->_user_option['data'] ?? [], 'id');
        if ($items) {
            global $wpdb;
            $sql = 'SELECT * FROM ' . $wpdb->prefix . 'sdtdl WHERE uniq_id IN (\'' . implode('\',\'', $items) . '\')';
            $results = $wpdb->get_results($sql, ARRAY_A);
            $this->_to_do_items['own'] = $results;
        }
    }

    private function _get_affected_items(): void
    {
        global $wpdb;
        $sql = 'SELECT * FROM ' . $wpdb->prefix . 'sdtdl WHERE affected_to LIKE \'%{' . $this->_user_id . '}%\'';
        $results = $wpdb->get_results($sql, ARRAY_A);
        $this->_to_do_items['affected'] = $results;
    }

    private function _update_option($data, $force_site = false): void
    {
        if ($this->_is_network_admin || $force_site === true) {
            update_site_option(self::option_name, $data);
        } else {
            update_option(self::option_name, $data);
        }
    }

    public function widget_setup(): void
    {
        wp_add_dashboard_widget('sdtdl_to_do_widget', esc_html__('To-Do List', 'sortable-dashboard-to-do-list'), ['SDTDL\SDTDL', 'widget'], null, [
            'option' => $this->_user_option,
            'items' => $this->_to_do_items,
            'date_time_format' => $this->_date_time_format,
            'is_network_admin' => $this->_is_network_admin,
            'user_can_affect_to_roles' => $this->_user_can_affect_to_roles,
            'users_cannot_be_affected_to' => $this->_users_cannot_be_affected_to,
            'user_id' => $this->_user_id
        ]);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }

    public function enqueue_admin_scripts(): void
    {
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_style('sdtdl', $this->_path . '/css/sdtdl-admin.css', ['wp-jquery-ui-dialog'], SDTDL_VERSION);
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('sdtdl', $this->_path . '/js/sdtdl-admin.min.js', ['jquery-ui-sortable', 'jquery-ui-dialog'], SDTDL_VERSION);
        $this->_localize_strings();
    }

    private function _check_nonce(): void
    {
        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['nonce'])), 'sdtdl_update')) {
            wp_send_json_error();
        }
    }

    private function _localize_strings(): void
    {
        $SDTDL = [
            "strings" => [
                'RecentlyAdded' => esc_html__('Recently added', 'sortable-dashboard-to-do-list'),
                'RecentlyEdited' => esc_html__('Recently edited', 'sortable-dashboard-to-do-list'),
                'MarkComplete' => esc_html__('Mark As Completed', 'sortable-dashboard-to-do-list'),
                'Pending' => esc_html__('Pending completion', 'sortable-dashboard-to-do-list'),
                'Completed' => esc_html__('Completed', 'sortable-dashboard-to-do-list'),
                'Affected' => esc_attr__('Affected', 'sortable-dashboard-to-do-list'),
                'YouAffectedTo' => esc_html__('You affected this item to:', 'sortable-dashboard-to-do-list'),
                'DragToSort' => esc_attr__("Drag to sort", 'sortable-dashboard-to-do-list'),
                'Close' => esc_html__('Close'),
                'Edit' => esc_html__('Edit'),
                'Save' => esc_html__('Save'),
                'SaveEdits' => esc_html__('Save Edits'),
                'Cancel' => esc_html__('Cancel'),
                'Delete' => esc_html__('Delete'),
                'nonce' => wp_create_nonce('sdtdl_update'),
                'UserID' => $this->_user_id,
                'BlogID' => get_current_blog_id()
            ]
        ];
        wp_localize_script('sdtdl', 'sdtdl', $SDTDL);
    }


    public static function widget($var, $args): void
    {
        ob_start();
        require_once __DIR__ . '/../templates/list-back.php';
        echo ob_get_clean();
    }

    public function mark_complete(): void
    {
        $this->_check_nonce();
        $id = sanitize_text_field($_REQUEST['id']);
        $time = (int)$_REQUEST['timestamp'];
        global $wpdb;
        $sql = "SELECT completed_by FROM " . $wpdb->prefix . "sdtdl WHERE uniq_id=%s";
        $results = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A);
        $completed_by = maybe_unserialize($results[0]['completed_by']);
        if (!$completed_by) {
            $completed_by = [];
        }
        $completed_by[$this->_user_id] = $time;
        $completed_by = serialize($completed_by);
        $updated = $wpdb->update($wpdb->prefix . 'sdtdl', ["completed_by" => $completed_by], ["uniq_id" => $id]);
        if ($updated) {
            //Does the user who affected the task still exist? If not, we need to remove the task from the submitting user list
            //If the task is fully completed, it needs to be removed from the db
            $sql = "SELECT created_by, affected_to, completed_by FROM " . $wpdb->prefix . "sdtdl WHERE uniq_id=%s";
            $remove_item = false;
            $results = $wpdb->get_results($wpdb->prepare($sql, $id), ARRAY_A)[0];
            if (!get_userdata($results['created_by'])) {
                $remove_item = true;
                $affected_to = self::get_affected_to_user_ids_array($results['affected_to']);
                $completed_by = unserialize($results['completed_by']);
                $completed_by = array_keys($completed_by);
                $diff = array_diff($affected_to, $completed_by);
                if (!$diff) {
                    $wpdb->delete($wpdb->prefix . 'sdtdl', ['uniq_id' => $id], []);
                } else {//Remove the affected user from the affected list
                    $key = array_search($this->_user_id, $affected_to);
                    unset($affected_to[$key]);
                    $affected_to = self::get_affected_to_user_ids_string($affected_to);
                    $data = ['affected_to' => $affected_to];
                    $wpdb->update($wpdb->prefix . 'sdtdl', $data, ["uniq_id" => $id]);
                }
            }
            wp_send_json_success($remove_item);
        }
    }

    public function update_order(): void
    {
        $this->_check_nonce();
        $options = $this->_options;
        $items = $_REQUEST['data'] ?? [];
        foreach ($items as $index => $item) {
            foreach ($item as $name => $value) {
                $items[$index][$name] = sanitize_text_field($value);
            }
        }
        $list = sanitize_text_field($_REQUEST['list']);
        if ($list == 'own') {
            $options[$this->_user_id]['data'] = $items;
        } else {
            $options[$this->_user_id]['affected'] = $items;
        }
        $this->_update_option($options);
        wp_send_json_success();
    }

    public function add_item(): void
    {
        $this->_check_nonce();
        $response['time'] = $this->_get_formatted_date("add");
        global $wpdb;
        $timestamp = (int)$_REQUEST['data']['content']['added'];
        $title = sanitize_text_field($_REQUEST['data']['content']['title']);
        $id = sanitize_text_field($_REQUEST['data']['content']['id']);
        $content = self::sanitize_item_content($_REQUEST['data']['content']['content']);
        $data = ["added" => $timestamp, "title" => $title, "uniq_id" => $id, "content" => $content, "created_by" => $this->_user_id];
        $data = $this->_maybe_add_affected_data($data,$this->_user_id);
        $inserted = $wpdb->insert($wpdb->prefix . 'sdtdl', $data);
        if ($inserted) {
            $this->_update_item_option($id);
            wp_send_json_success($response);
        }
        wp_send_json_error();
    }

    public function edit_item(): void
    {
        $this->_check_nonce();
        global $wpdb;
        $id = sanitize_text_field($_REQUEST['data']['content']['id']);
        $changed = sanitize_text_field($_REQUEST['data']['content']['changed']);
        $title = sanitize_text_field($_REQUEST['data']['content']['title']);
        $content = self::sanitize_item_content($_REQUEST['data']['content']['content']);
        $edited = (int)$_REQUEST['data']['content']['last_edited'];
        $data = ["title" => $title, "content" => $content, "last_edited" => $edited];
        $response['time'] = $this->_get_formatted_date("edit");
        $where = ["uniq_id" => $id, "created_by" => $this->_user_id];
        if ($changed !== 'false') {
            $data['last_edited'] = $edited;
            $user_data = get_userdata($this->_user_id);
            $data['last_edited_by'] = $user_data->display_name;
        }
        //Are other people allowed to edit it?
        $sql = "SELECT edition_allowed, affected_to, created_by FROM " . $wpdb->prefix . "sdtdl WHERE uniq_id='$id'";
        $results = $wpdb->get_results($sql, ARRAY_A)[0];
        $affected_to = self::get_affected_to_user_ids_array($results['affected_to']);
        if ($results['edition_allowed'] == 1 && $results['created_by'] != $this->_user_id) {
            if (!in_array($this->_user_id, $affected_to)) {
                wp_send_json_error();;
            }
            unset($where['created_by']);
            //do not allow to edit the title
            unset($data['title']);
        }
        $data = $this->_maybe_add_affected_data($data, $results['created_by']);
        $updated = $wpdb->update($wpdb->prefix . 'sdtdl', $data, $where);
        if ($updated) {
            if ($results['created_by'] == $this->_user_id) {
                $this->_update_item_option($id, "update");
            }
            wp_send_json_success($response);
        }
        wp_send_json_error();
    }

    private function _maybe_add_affected_data($data, $created_by): array
    {
        if ($created_by != $this->_user_id) {
            return $data;
        }
        $affected_to = sanitize_text_field($_REQUEST['data']['content']['affected']['to'] ?? '');
        //We need to make sure the current user has the ability to affect to all the other users (prevent passing unwanted user ids from ajax call)
        $data['affected_to'] = $this->_users_authorized_to_affect_to($affected_to);
        $data['edition_allowed'] = (bool)$_REQUEST['data']['content']['affected']['edition_allowed'];
        $id = sanitize_text_field($_REQUEST['data']['content']['id']);
        //If we unaffect someone that had completed the task, we need to remove it from completion, to allow for reaffectation.
        $this->_maybe_update_completed_by($affected_to, $id);
        return $data;
    }

    private static function get_affected_to_user_ids_array($affected_to): array
    {
        return explode(',', str_replace(['{', '}'], '', $affected_to));
    }

    private static function get_affected_to_user_ids_string($affected_to): string
    {
        if (!$affected_to) {
            return '';
        }
        return '{' . implode('},{', $affected_to) . '}';
    }

    private function _users_authorized_to_affect_to($affected_to): string
    {
        //We can safely the assume admins are not messing with that
        if (current_user_can('administrator')) {
            return $affected_to;
        }
        $affected_to = self::get_affected_to_user_ids_array($affected_to);
        $allowed_roles = $this->_user_can_affect_to_roles;
        $forbidden_users = $this->_users_cannot_be_affected_to;
        foreach ($affected_to as $key => $user_id) {
            if (in_array($user_id, $forbidden_users)) {
                unset($affected_to[$key]);
                continue;
            }
            $user_meta = get_userdata($user_id);
            $user_roles = $user_meta->roles;
            $has_allowed_role = false;
            foreach ($user_roles as $user_role) {
                if (in_array($user_role, $allowed_roles)) {
                    $has_allowed_role = true;
                    break;
                }
            }
            if (!$has_allowed_role) {
                unset($affected_to[$key]);
            }
        }
        return self::get_affected_to_user_ids_string($affected_to);
    }

    private function _maybe_update_completed_by($affected_to, $id): void
    {
        $affected_to = self::get_affected_to_user_ids_array($affected_to);
        global $wpdb;
        $sql = 'SELECT completed_by FROM ' . $wpdb->prefix . 'sdtdl WHERE uniq_id=\'' . $id . '\'';
        $results = $wpdb->get_results($sql, ARRAY_A);
        if (isset($results[0]['completed_by']) && $results[0]['completed_by']) {
            $completed_by = unserialize($results[0]['completed_by']);
            foreach ($completed_by as $user_id => $timestamp) {
                if (!in_array($user_id, $affected_to)) {
                    unset($completed_by[$user_id]);
                }
            }
            if ($completed_by) {
                $completed_by = serialize($completed_by);
            } else {
                $completed_by = '';
            }
            if ($completed_by != $results[0]['completed_by']) {
                $data = ['completed_by' => $completed_by];
                $wpdb->update($wpdb->prefix . 'sdtdl', $data, ["uniq_id" => $id, "created_by" => $this->_user_id]);
            }
        }
    }

    private function _update_item_option($id, $type = 'add'): void
    {
        $front = sanitize_text_field($_REQUEST['data']['options']['front']);
        $option = ["front" => $front, "id" => $id];
        if ($type == 'add') {
            $this->_user_option['data'][] = $option;
        } else {
            $key = array_search($id, array_column($this->_user_option['data'], "id"));
            $this->_user_option['data'][$key] = $option;
        }
        $options = $this->_options;
        $options[$this->_user_id] = $this->_user_option;
        $this->_update_option($options);
    }

    public function delete_item(): void
    {
        $this->_check_nonce();
        $id = sanitize_text_field($_REQUEST['item']);
        global $wpdb;
        $delete = $wpdb->delete($wpdb->prefix . 'sdtdl', ['uniq_id' => $id, 'created_by' => $this->_user_id], []);
        if ($delete) {
            wp_send_json_success();
        }
        wp_send_json_error();
    }


    public function save_settings(): void
    {
        $this->_check_nonce();
        $data = $this->_options;
        $settings = $_REQUEST['settings'] ?? [];
        $settings = $this->_sanitize_settings($settings);
        $data[$this->_user_id]['extra'] = $settings;
        $this->_update_option($data);
        wp_send_json_success();
    }

    private function _get_formatted_date($type): array
    {
        $timestamp = (int)$_REQUEST['date_data']['timestamp'];
        $date = wp_date($this->_date_time_format, $timestamp);
        if ($type == 'add') {
            $icon_class = "dashicons-plus";
            $formatted_date = sprintf(esc_html__("Added %s", 'sortable-dashboard-to-do-list'), $date);
        } else {
            $icon_class = "dashicons-edit";
            $user_data=get_userdata($this->_user_id);
            $formatted_date = sprintf(esc_html__("Last edit %s by %s", 'sortable-dashboard-to-do-list'), $date,$user_data->display_name);
        }
        return ["full" => '<span class="dashicons ' . $icon_class . '"></span>' . $formatted_date, "short" => $formatted_date];
    }

    private function _sanitize_settings($settings): array
    {
        foreach ($settings as $key => $setting) {
            if ($key === 'front') {
                if (in_array($setting, ['true', 'false'])) {
                    $settings[$key] = $setting;
                } else {
                    $settings[$key] = 'false';
                }
            } elseif (in_array($key, ['side', 'accent'])) {
                $settings[$key] = sanitize_text_field($setting);
            } else {
                unset($settings[$key]);
            }
        }
        return $settings;
    }

    public static function sanitize_item_content($content): string
    {
        $content = str_replace(['<br>', '<br/>', '<br />'], PHP_EOL, $content);
        return wp_kses($content, [
            'a' => [
                'href' => [],
                'target' => [],
                'title' => []
            ],
            'strong' => [],
            'em' => [],
            'u' => [],
            'ul' => [],
            'p' => [],
            'ol' => [],
            'li' => [],
            'span' => [
                'style' => []
            ]
        ]);
    }

    public static function init(): void
    {
        //Make sure user may need this feature (at least blog author)
        if (!is_user_logged_in() || !current_user_can(apply_filters('sdtdl_min_user_capability', 'edit_posts'))) {
            return;
        }
        new self();
    }

    public static function uninstall_plugin(): void
    {
        global $wpdb;
        $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'sdtdl');
        delete_site_option(self::option_name);
        if (is_network_admin()) {
            $sites = get_sites();
            foreach ($sites as $site) {
                delete_blog_option($site->blog_id, self::option_name);
            }
        }
    }

    public static function clear_affectations($user_id)
    {
        global $wpdb;
        $sql = 'SELECT * FROM ' . $wpdb->prefix . 'sdtdl WHERE affected_to LIKE \'%{' . $user_id . '}%\'';
        $results = $wpdb->get_results($sql, ARRAY_A);
        foreach ($results as $result) {
            $affected_to = self::get_affected_to_user_ids_array($result['affected_to']);
            $key = array_search($user_id, $affected_to);
            unset($affected_to[$key]);
            $affected_to = self::get_affected_to_user_ids_string($affected_to);
            $completed_by = maybe_unserialize($result['completed_by']);
            if ($completed_by) {
                unset($completed_by[$user_id]);
                if ($completed_by) {
                    $completed_by = serialize($completed_by);
                } else {
                    $completed_by = '';
                }
            }
            $data = ['affected_to' => $affected_to, 'completed_by' => $completed_by];
            $wpdb->update($wpdb->prefix . 'sdtdl', $data, ["uniq_id" => $result['uniq_id']]);
        }
    }

    private static function sort_items(&$items, $order): void
    {
        usort($items, function ($a, $b) use ($order) {
            $pos_a = array_search($a['uniq_id'], $order);
            $pos_b = array_search($b['uniq_id'], $order);
            return $pos_a - $pos_b;
        });
    }

    private function _maybe_upgrade_db(): void
    {
        if ($this->_get_db_version() == 0) {
            $this->_create_db_table();
        }
        if ($this->_get_db_version() < 2) {
            $this->_upgrade_db('2');
        }
        if ($this->_get_db_version()<4){
            $this->_upgrade_db('4');
        }
        if ($this->_get_db_version()!=$this->_db_version) {
            $this->_update_db_version();
        }
    }

    private function _get_db_version()
    {
        $options = $this->_get_option(true);
        return $options['db_version'] ?? 0;
    }

    private function _update_db_version(): void
    {
        $options = $this->_get_option(true);
        $options['db_version'] = $this->_db_version;
        $this->_update_option($options, true);
    }


    private function _create_db_table(): void
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        $tablename = 'sdtdl';
        $sql = 'CREATE TABLE ' . $wpdb->prefix . $tablename . ' (ID int NOT NULL auto_increment, uniq_id varchar(10), title varchar(255),content longtext,added int,last_edited int,created_by int,affected_to varchar(255),completed_by varchar(255), PRIMARY KEY (ID));';
        $result = maybe_create_table($wpdb->prefix . $tablename, $sql);
        if ($result) {
            $this->_migrate_to_db();
        }
    }

    private function _upgrade_db($version)
    {
        global $wpdb;
        if ($version == '2') {
            $wpdb->query("ALTER TABLE " . $wpdb->prefix . "sdtdl ADD affected_to VARCHAR(255) NOT NULL, ADD completed_by VARCHAR(255) NOT NULL");
            return;
        }
        if ($version=='4'){
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            $sql="ALTER TABLE " . $wpdb->prefix . "sdtdl ADD last_edited_by VARCHAR(255)";
            maybe_add_column($wpdb->prefix . "sdtdl","last_edited_by",$sql);
            $sql="ALTER TABLE " . $wpdb->prefix . "sdtdl ADD edition_allowed TINYINT(1) DEFAULT 0";
            maybe_add_column($wpdb->prefix . "sdtdl","edition_allowed",$sql);
            $sql="SELECT * FROM ".$wpdb->prefix."sdtdl";
            $results = $wpdb->get_results($sql, ARRAY_A);
            foreach ($results as $result) {
                $user=get_userdata($result['created_by']);
                $wpdb->update($wpdb->prefix . 'sdtdl', ["last_edited_by" => $user->display_name], ["uniq_id" => $result['uniq_id']]);
            }
        }
    }

    private function _migrate_to_db(): void
    {
        global $wpdb;
        $users = get_users();
        if (is_multisite()) {
            $sites = get_sites();
        } else {
            $site = new \stdClass();
            $site->blog_id = get_current_blog_id();
            $sites = [$site];
        }
        foreach ($sites as $site) {
            if (is_multisite()) {
                $items = get_blog_option($site->blog_id, self::option_name);
            } else {
                $items = get_option(self::option_name);
            }
            foreach ($users as $user) {
                if (!isset($items[$user->ID]['data'])) {
                    continue;
                }
                foreach ($items[$user->ID]['data'] as $key => $item) {
                    $title = $item['title'];
                    $content = $item['content'];
                    $added = $item['added'];
                    $last_edited = $item['last_edited'];
                    $id = $item['id'];
                    $wpdb->insert($wpdb->prefix . "sdtdl", ["uniq_id" => $id, "title" => $title, "content" => $content, "added" => $added, "last_edited" => $last_edited, "created_by" => $user->ID]);
                    unset($items[$user->ID]['data'][$key]['title']);
                    unset($items[$user->ID]['data'][$key]['content']);
                    unset($items[$user->ID]['data'][$key]['added']);
                    unset($items[$user->ID]['data'][$key]['last_edited']);
                }
            }
            if (is_multisite()) {
                update_blog_option($site->blog_id, self::option_name, $items);
            } else {
                update_option(self::option_name, $items);
            }
        }
    }
}


