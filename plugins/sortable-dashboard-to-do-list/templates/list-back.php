<?php if (!defined('ABSPATH')) {
    exit;
}
/* @var $args */
$user_id = $args['args']['user_id'];
$to_do_data = $args['args']['items']['own'] ?? [];
$affected_to_do_data = $args['args']['items']['affected'] ?? [];
$to_do_items_options = $args['args']['option']['data'] ?? [];
$to_do_items_options = array_column($to_do_items_options, null, 'id');
$order = array_keys($to_do_items_options);
$affected_order = $args['args']['option']['affected'] ?? [];
$affected_order = array_column($affected_order, null, 'id');
$affected_order = array_keys($affected_order);
self::sort_items($to_do_data, $order);
self::sort_items($affected_to_do_data, $affected_order);
$to_do_options = $args['args']['option']['extra'] ?? [];
$is_network_admin = $args['args']['is_network_admin'];
$user_can_affect_to_roles = $args['args']['user_can_affect_to_roles'];
$users_cannot_be_affected_to=$args['args']['users_cannot_be_affected_to'];
$date_format = $args['args']['date_time_format'];
$lists = ['sdtdl-list' => $to_do_data];
if ($affected_to_do_data) {
    $lists['sdtdl-affected-list'] = $affected_to_do_data;
}
$count = 0;
?>
<style class="sdtdl-inline-styles">
    :root {
        --sdtdl-bg-color: <?php echo $to_do_options['accent'].'85';?>;
        --sdtdl-color: <?php echo $to_do_options['accent'];?>;
    }
</style>
<?php foreach ($lists as $list_id => $list_data) {
    if ($list_id == 'sdtdl-affected-list') {
        esc_html_e('The items below were affected to you by other users', 'sortable-dashboard-to-do-list');
    }
    ?>
    <ul id="<?php echo $list_id; ?>" class="sdtdl-list">
        <?php
        foreach ($list_data as $key => $to_do_item) {
            $count++;
            $date_added = wp_date($date_format, $to_do_item['added']);
            $affected_by = $to_do_item['created_by'];
            $affected_to = str_replace(['{', '}'], '', $to_do_item['affected_to']);
            $affected_to_data = '';
            $affected_by_name = '';
            $completed_by = maybe_unserialize($to_do_item['completed_by']);
            if (!$completed_by) {
                $completed_by = [];
            }
            if ($affected_by != $user_id) {
                $affected_by_name = get_userdata($affected_by);
                if (!$affected_by_name) {
                    $affected_by_name=esc_html__('Unknown user', 'sortable-dashboard-to-do-list');
                }else{
                    $affected_by_name = $affected_by_name->display_name;
                }
            } elseif ($affected_to != $user_id) {
                $affected_to_data = $affected_to;
            }
            ?>
            <li class="sdtdl-item<?php
            $title = sprintf(esc_html__("Added %s", 'sortable-dashboard-to-do-list'), $date_added);
            if ($list_id == 'sdtdl-affected-list') {
                $title = sprintf(esc_html__("Affected to you by %s", 'sortable-dashboard-to-do-list'), $affected_by_name);
                $completed_by = maybe_unserialize($to_do_item['completed_by']);
                if (isset($completed_by[$user_id])) {
                    echo ' complete';
                }
            } elseif ($affected_to_data) {
                echo ' affected';
                if (count($completed_by) == count(array_filter(explode(',', $affected_to)))) {
                    echo ' complete';
                } else {
                    echo ' pending';
                }
            }
            ?>" data-key="<?php echo (int)$key; ?>" data-added="<?php echo (int)$to_do_item['added']; ?>" data-edited="<?php echo (int)$to_do_item['last_edited']; ?>"
                data-id="<?php echo esc_attr($to_do_item['uniq_id']); ?>" data-affected-by="<?php echo (int)$affected_by; ?>"
                <?php if ($affected_by_name) {
                    echo ' data-affected-by-name="' . esc_attr($affected_by_name) . '"';
                }
                if ($affected_to_data && $to_do_item['created_by'] == $user_id) {
                    echo ' data-affected-to="' . esc_attr($affected_to_data) . '"';
                    if ($completed_by) {
                        echo ' data-completed-by="' . esc_attr(implode(',', array_keys($completed_by))) . '"';
                    }
                }
                if ($list_id != 'sdtdl-affected-list') {
                    echo ' data-front="' . esc_attr($to_do_items_options[$to_do_item['uniq_id']]['front']) . '"';
                } ?>>
                <span class="dashicons dashicons-sort" title="<?php esc_attr_e("Drag to sort", 'sortable-dashboard-to-do-list'); ?>"></span>
                <div class="sdtdl-affectation-icons">
                    <span class="dashicons dashicons-migrate in-title" title="<?php esc_attr_e('Affected', 'sortable-dashboard-to-do-list'); ?>"></span>
                    <span class="dashicons dashicons-clock"
                          title="<?php esc_attr_e('Pending completion', 'sortable-dashboard-to-do-list'); ?>"></span>
                    <span class="dashicons dashicons-yes"
                          title="<?php esc_attr_e('Completed', 'sortable-dashboard-to-do-list'); ?>"></span>
                </div>
                <div class="sdtdl-item-title" title="<?php echo esc_attr($title); ?>">
                    <?php echo esc_html($to_do_item['title']); ?>
                </div>
                <div class="sdtdl-content-container">
                    <div class="sdtdl-content-text">
                        <?php echo self::sanitize_item_content(stripslashes($to_do_item['content'])); ?>
                    </div>
                    <?php if ($list_id != 'sdtdl-affected-list') { ?>
                        <div class="sdtdl-dates">
                            <div class="sdtdl-date-added">
                                <?php echo '<span class="dashicons dashicons-plus"></span>' . sprintf(esc_html__("Added %s", 'sortable-dashboard-to-do-list'), $date_added); ?>
                            </div>
                            <div class="sdtdl-date-edited">
                                <?php if ($to_do_item['last_edited']) {
                                    $date_edited = wp_date($date_format, $to_do_item['last_edited']);
                                    echo '<span class="dashicons dashicons-edit"></span>' . sprintf(esc_html__("Last edit %s", 'sortable-dashboard-to-do-list'), $date_edited);
                                } ?>
                            </div>
                        </div>
                        <div class="sdtdl-affected-task-info">
                        <span class="dashicons dashicons-migrate"></span><?php esc_html_e('You affected this item to:', 'sortable-dashboard-to-do-list'); ?>
                        <ul>
                        <?php if ($affected_to_data) { ?>
                                <?php $affected_users = explode(',', $affected_to_data);
                                foreach ($affected_users as $affected_user) {
                                    $user_data = get_userdata($affected_user);
                                    $icon = 'clock';
                                    $title = __('Pending completion', 'sortable-dashboard-to-do-list');
                                    if (isset($completed_by[$user_data->data->ID])) {
                                        $icon = 'yes';
                                        $title = __('Completed', 'sortable-dashboard-to-do-list');
                                    }
                                    ?>
                                    <li><span class="dashicons dashicons-<?php echo $icon; ?>" title="<?php echo esc_attr($title); ?>"></span><?php echo $user_data->data->display_name; ?></li>
                                <?php } ?>
                        <?php } ?>
                        </ul>
                        </div>
                    <?php } else { ?>
                        <div class="sdtdl-affected-task-info">
                            <span class="dashicons dashicons-migrate"></span>
                            <?php esc_html_e('This item was affected to you by %s', 'sortable-dashboard-to-do-list'); ?>
                        </div>
                    <?php } ?>
                </div>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<div class="sdtdl-dialog-content sdtdl-view-item">
    <div class="sdtdl-content-text"></div>
    <div class="sdtdl-dates"></div>
    <div class="sdtdl-affected-task-info"></div>
</div>
<div class="sdtdl-dialog-content sdtdl-affected-item">
    <div class="sdtdl-content-text"></div>
    <div class="sdtdl-affected-task-info"></div>
    <div class="sdtdl-affected-task-complete"><span class="dashicons dashicons-yes"></span><?php esc_html_e('You marked this item as completed', 'sortable-dashboard-to-do-list'); ?></div>
</div>
<div class="sdtdl-no-content-container">
    <div class="sdtdl-no-content">
        <?php esc_html_e('No additional content was provided.', 'sortable-dashboard-to-do-list'); ?>
    </div>
</div>
<?php if (!$is_network_admin) { ?>
    <div class="sdtdl-settings-button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" aria-labelledby="title"
             role="button" xmlns:xlink="http://www.w3.org/1999/xlink">
            <title><?php esc_html_e('Settings'); ?></title>
            <path data-name="layer1"
                  d="M58.906 27a3.127 3.127 0 0 1-2.977-2.258 24.834 24.834 0 0 0-1.875-4.519 3.131 3.131 0 0 1 .505-3.71 3.1 3.1 0 0 0 0-4.376l-2.693-2.698a3.1 3.1 0 0 0-4.376 0 3.131 3.131 0 0 1-3.71.505 24.834 24.834 0 0 0-4.519-1.875A3.127 3.127 0 0 1 37 5.094 3.1 3.1 0 0 0 33.906 2h-3.812A3.1 3.1 0 0 0 27 5.094a3.127 3.127 0 0 1-2.258 2.977 24.834 24.834 0 0 0-4.519 1.875 3.131 3.131 0 0 1-3.71-.505 3.1 3.1 0 0 0-4.376 0l-2.695 2.7a3.1 3.1 0 0 0 0 4.376 3.131 3.131 0 0 1 .505 3.71 24.834 24.834 0 0 0-1.875 4.519A3.127 3.127 0 0 1 5.094 27 3.1 3.1 0 0 0 2 30.094v3.811A3.1 3.1 0 0 0 5.094 37a3.127 3.127 0 0 1 2.977 2.258 24.833 24.833 0 0 0 1.875 4.519 3.131 3.131 0 0 1-.505 3.71 3.1 3.1 0 0 0 0 4.376l2.7 2.7a3.1 3.1 0 0 0 4.376 0 3.131 3.131 0 0 1 3.71-.505 24.834 24.834 0 0 0 4.519 1.875A3.127 3.127 0 0 1 27 58.906 3.1 3.1 0 0 0 30.094 62h3.811A3.1 3.1 0 0 0 37 58.906a3.127 3.127 0 0 1 2.258-2.977 24.834 24.834 0 0 0 4.519-1.875 3.131 3.131 0 0 1 3.71.505 3.1 3.1 0 0 0 4.376 0l2.7-2.695a3.1 3.1 0 0 0 0-4.376 3.131 3.131 0 0 1-.505-3.71 24.833 24.833 0 0 0 1.875-4.519A3.127 3.127 0 0 1 58.906 37 3.1 3.1 0 0 0 62 33.906v-3.812A3.1 3.1 0 0 0 58.906 27z"
                  fill="#000" stroke="#202020" stroke-linecap="round" stroke-miterlimit="10"
                  stroke-width="2" stroke-linejoin="round"></path>
            <circle data-name="layer2"
                    cx="32" cy="32" r="14" fill="#fff" stroke="#202020" stroke-linecap="round"
                    stroke-miterlimit="10" stroke-width="2" stroke-linejoin="round"></circle>
        </svg>
    </div>
<?php } ?>
<div class="sdtdl-add-button" data-action="add">
    <?php esc_html_e('Add'); ?>
</div>
<?php if ($count && current_user_can('install_plugins') && !apply_filters('sdtdl-remove-rating-reminder', false)) { ?>
    <div class="sdtdl-please-rate clearfix">
        <?php printf(wp_kses(__('Please <a href="%s" target="_blank" rel="noopener">rate the plugin ★★★★★</a> to help keep it up-to-date & maintained. Thank you!', 'sortable-dashboard-to-do-list'), ['a' => ['href' => [], 'target' => []]]), 'https://wordpress.org/support/plugin/sortable-dashboard-to-do-list/reviews/?filter=5#new-post'); ?>
    </div>
<?php } ?>
<div class="sdtdl-dialog-content sdtdl-settings" title="<?php esc_attr_e('Settings'); ?>">
    <div class="sdtdl-settings-container">
        <div class="sdtdl-setting">
            <label for="option-show-front"><input type="checkbox" id="option-show-front" <?php if ($to_do_options['front'] === 'true') {
                    echo ' checked';
                } ?>/><?php esc_html_e('Show list on website (current user only)', 'sortable-dashboard-to-do-list'); ?></label>
        </div>
        <div class="sdtdl-setting sdtdl-cond-show-front"<?php if ($to_do_options['front'] !== 'true') {
            echo ' style="display:none"';
        } ?>>
            <label for="option-front-side"><?php esc_html_e('Position:', 'sortable-dashboard-to-do-list'); ?></label>
            <select name="side" id="option-front-side">
                <option value="left"<?php if ($to_do_options['side'] === 'left') {
                    echo ' selected="selected"';
                } ?>><?php esc_html_e('Left side of window', 'sortable-dashboard-to-do-list'); ?></option>
                <option value="right"<?php if ($to_do_options['side'] === 'right') {
                    echo 'selected="selected"';
                } ?>><?php esc_html_e('Right side of window', 'sortable-dashboard-to-do-list'); ?></option>
            </select>
        </div>
        <div class="sdtdl-setting">
            <label for="option-accent"><?php esc_html_e('Accent:', 'sortable-dashboard-to-do-list'); ?></label><input type="color" id="option-accent"
                                                                                                                      value="<?php echo esc_html($to_do_options['accent']); ?>"/>
        </div>
    </div>
</div>
<div class="sdtdl-dialog-content sdtdl-new-item" title="<?php esc_attr_e('Add New To-Do Item', 'sortable-dashboard-to-do-list'); ?>">
    <div class="sdtdl-new-container">
        <label for="new-sdtdl-title" class="screen-reader-text"><?php esc_html_e('Title (required)', 'sortable-dashboard-to-do-list'); ?></label><input type="text" id="new-sdtdl-title"
                                                                                                                                                        placeholder="<?php esc_attr_e('Title (required)', 'sortable-dashboard-to-do-list'); ?>"/>
        <label for="new-sdtdl-text" class="screen-reader-text"><?php esc_html_e('Description (optional)', 'sortable-dashboard-to-do-list'); ?></label><textarea id="new-sdtdl-text" rows="4"
                                                                                                                                                                placeholder="<?php esc_attr_e('Description (optional)', 'sortable-dashboard-to-do-list'); ?>"></textarea>
        <label for="new-show-front" class="show-front-option<?php if ($to_do_options['front'] === 'false') {
            echo ' hidden-setting';
        } ?>"><input type="checkbox" id="new-show-front"/ checked><?php esc_html_e('Show on website (current user only)', 'sortable-dashboard-to-do-list'); ?></label>
        <?php
        $users = get_users([
            'exclude' => $users_cannot_be_affected_to,
            'role__in' => $user_can_affect_to_roles
        ]);
        if ($users) { ?>
            <p class="sdtdl-affect"><?php esc_html_e('Affect item to:', 'sortable-dashboard-to-do-list'); ?></p>
            <?php foreach ($users as $user) {
                ?>
                <label for="sdtdl-new-affect-user-<?php echo $user->ID; ?>" title="<?php echo translate_user_role(wp_roles()->roles[$user->roles[0]]['name']); ?>">
                    <input class="sdtdl-affect-user" id="sdtdl-new-affect-user-<?php echo $user->ID; ?>" type="checkbox" name="users" value="<?php echo $user->ID; ?>"/>
                    <?php echo esc_html($user->data->display_name); ?>
                </label>
            <?php }
        } ?>
    </div>
</div>
<div class="sdtdl-dialog-content sdtdl-edit-item" title="<?php esc_attr_e('Edit To-Do Item', 'sortable-dashboard-to-do-list'); ?>">
    <div class="sdtdl-edit-container">
        <label for="edit-sdtdl-title" class="screen-reader-text"></label><input type="text" id="edit-sdtdl-title"
                                                                                placeholder="<?php esc_attr_e('Title (required)', 'sortable-dashboard-to-do-list'); ?>"/>
        <label for="edit-sdtdl-text" class="screen-reader-text"></label><textarea id="edit-sdtdl-text" rows="4"
                                                                                  placeholder="<?php esc_attr_e('Description (optional)', 'sortable-dashboard-to-do-list'); ?>"></textarea>
        <label for="edit-show-front" class="show-front-option<?php if ($to_do_options['front'] === 'false') {
            echo ' hidden-setting';
        } ?>"><input type="checkbox" id="edit-show-front"/><?php esc_html_e('Show on website (current user only)', 'sortable-dashboard-to-do-list'); ?></label>
        <?php
        if ($users) { ?>
            <p class="sdtdl-affect"><?php esc_html_e('Affect item to:', 'sortable-dashboard-to-do-list'); ?></p>
            <?php foreach ($users as $user) {
                ?>
                <label for="sdtdl-edit-affect-user-<?php echo $user->ID; ?>" title="<?php echo translate_user_role(wp_roles()->roles[$user->roles[0]]['name']); ?>">
                    <input class="sdtdl-affect-user" id="sdtdl-edit-affect-user-<?php echo $user->ID; ?>" type="checkbox" name="users" value="<?php echo $user->ID; ?>"/>
                    <?php echo esc_html($user->data->display_name); ?>
                </label>
            <?php }
        } ?>
    </div>
</div>
<div class="sdtdl-dialog-content sdtdl-delete-item" title="<?php esc_attr_e('Delete To-Do Item', 'sortable-dashboard-to-do-list'); ?>">
    <p><span class="dashicons dashicons-warning"></span><?php esc_html_e('This item will be permanently deleted and cannot be recovered. Are you sure?', 'sortable-dashboard-to-do-list'); ?></p>
</div>
<?php if ($affected_to_do_data){ ?>
<div class="sdtdl-dialog-content sdtdl-confirm-complete-item" title="<?php esc_attr_e('Mark As Completed', 'sortable-dashboard-to-do-list'); ?>">
    <p><span class="dashicons dashicons-warning"></span><?php esc_html_e('Are you sure you want to mark the item as completed?', 'sortable-dashboard-to-do-list'); ?></p>
</div>
<?php } ?>