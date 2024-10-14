<?php if (!defined('ABSPATH')) {
    exit;
}
$to_do_data = array_column($this->_user_option['data'], null, 'id');
$order = array_keys($to_do_data);
$to_do_items = $this->_to_do_items['own'];
$affected_to_do_items = $this->_to_do_items['affected'];
$affected_order = array_column($this->_user_option['affected'] ?? [], null, 'id');
$affected_order = array_keys($affected_order);
if ($affected_to_do_items) {
    foreach ($affected_to_do_items as $key => $affected_to_do_item) {
        $completed_by = maybe_unserialize($affected_to_do_item['completed_by']);
        if ($completed_by && isset($completed_by[$this->_user_id])) {
            unset($affected_to_do_items[$key]);
        }
    }
}
self::sort_items($to_do_items, $order);
self::sort_items($affected_to_do_items, $affected_order);
$to_do_options = $this->_user_option['extra'];
$date_format = $this->_date_time_format;
$cookie = sanitize_text_field($_COOKIE['sdtdl_front_state_' . $this->_user_id . '_' . get_current_blog_id()] ?? []);
if ($cookie) {
    $cookie = json_decode(stripslashes($cookie), true);
}
$previous_state = $cookie['list_state'] ?? 'collapsed';
$class = '';
if ($previous_state == 'open') {
    $class = " sdtdl-open";
}
if ($this->_user_option['extra']['side'] === 'right') {
    $class .= " sdtdl-right";
}
$lists = ['sdtdl-list' => $to_do_items];
if ($affected_to_do_items) {
    $lists['sdtdl-affected-list'] = $affected_to_do_items;
}
?>
<style>
    .sdtdl-dialog, .sdtdl-front, .sdtdl-collapsed {
        --sdtdl-bg-color: <?php echo $to_do_options['accent'].'85';?>;
        --sdtdl-color: <?php echo $to_do_options['accent'];?>;
    }
</style>
<div class="sdtdl-front<?php echo $class; ?>" data-close="<?php esc_attr_e('Close'); ?>">
    <h3><?php esc_html_e('To-Do List', 'sortable-dashboard-to-do-list'); ?>
        <span class="dashicons dashicons-arrow-down-alt2" title="<?php esc_attr_e('Collapse list', 'sortable-dashboard-to-do-list'); ?>"></span>
    </h3>
    <?php
    $count = 0;
    foreach ($lists as $list_id => $list_data) {
        if ($list_id == 'sdtdl-affected-list') {
            echo '<div class="sdtdl-affected-intro">' . esc_html__('The items below were affected to you by other users', 'sortable-dashboard-to-do-list') . '</div>';
        }
        ?>
        <ul id="<?php echo $list_id; ?>" class="sdtdl-list">
            <?php
            foreach ($list_data as $key => $to_do_item) {
                $date_added = wp_date($date_format, $to_do_item['added']);
                $affected_by = $to_do_item['created_by'];
                $extra_class = '';
                if ($list_id == 'sdtdl-list') {
                    if ($to_do_data[$to_do_item['uniq_id']]['front'] === 'false') {
                        continue;
                    }
                    $title = sprintf(__("Added %s", 'sortable-dashboard-to-do-list'), $date_added);
                    $affected_to = array_filter(explode(',', str_replace(['{', '}'], '', $to_do_item['affected_to'])));
                    $completed_by = maybe_unserialize($to_do_item['completed_by']);
                    if (!$completed_by) {
                        $completed_by = [];
                    } else {
                        $completed_by = array_keys($completed_by);
                    }
                    $completed = true;
                    foreach ($affected_to as $affected_to_user) {
                        if (!in_array($affected_to_user, $completed_by)) {
                            $completed = false;
                            break;
                        }
                    }
                    if ($completed && $affected_to) {
                        $extra_class = ' sdtdl-affected-task-complete';
                    }
                } else {
                    $affected_by_name = get_userdata($affected_by);
                    if (!$affected_by_name) {
                        $affected_by_name=esc_html__('Unknown user', 'sortable-dashboard-to-do-list');
                    }else{
                        $affected_by_name = $affected_by_name->display_name;
                    }
                    $title = sprintf(__("Affected to you by %s", 'sortable-dashboard-to-do-list'), $affected_by_name);
                }
                $count++;
                ?>
                <li class="sdtdl-item<?php echo $extra_class; ?>" data-key="<?php echo (int)$key; ?>" data-added="<?php echo (int)$to_do_item['added']; ?>"
                    data-edited="<?php echo (int)$to_do_item['last_edited']; ?>"
                    data-id="<?php echo esc_attr($to_do_item['uniq_id']); ?>">
                    <?php if ($list_id == 'sdtdl-list' && $affected_by == $this->_user_id && $affected_to) { ?>
                        <div class="sdtdl-affectation-icons">
                            <span class="dashicons dashicons-migrate in-title" title="<?php esc_attr_e('Affected', 'sortable-dashboard-to-do-list'); ?>"></span>
                            <?php if (!$completed) { ?>
                                <span class="dashicons dashicons-clock"
                                      title="<?php esc_attr_e('Pending completion', 'sortable-dashboard-to-do-list'); ?>"></span>
                            <?php } else { ?>
                                <span class="dashicons dashicons-yes"
                                      title="<?php esc_attr_e('Completed', 'sortable-dashboard-to-do-list'); ?>"></span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="sdtdl-item-title" title="<?php echo esc_attr($title); ?>">
                        <?php echo esc_html($to_do_item['title']); ?>
                    </div>
                    <div class="sdtdl-dialog-content sdtdl-view-item sdtdl-<?php echo esc_attr($to_do_item['uniq_id']); ?>" data-id="<?php echo esc_attr($to_do_item['uniq_id']); ?>"
                         title="<?php echo esc_attr($to_do_item['title']); ?>">
                        <div class="sdtdl-content-text"><?php if (!stripslashes($to_do_item['content'])) {
                                esc_html_e('No additional content was provided.', 'sortable-dashboard-to-do-list');
                            } else {
                                $content = preg_replace('/(?<=<ul>|<\/li>)\s*?(?=<\/ul>|<li>)/is', '', $to_do_item['content']);
                                $content = preg_replace('/(?<=<ol>|<\/li>)\s*?(?=<\/ol>|<li>)/is', '', $content);
                                echo self::sanitize_item_content(stripslashes($content));
                            } ?>
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
                            <?php if ($affected_to) { ?>
                                <div class="sdtdl-affected-task-info">
                                    <span class="dashicons dashicons-migrate"></span><?php esc_html_e('You affected this item to:', 'sortable-dashboard-to-do-list'); ?>
                                    <ul>
                                        <?php
                                        foreach ($affected_to as $affected_user) {
                                            $user_data = get_userdata($affected_user);
                                            $icon = 'clock';
                                            $title = __('Pending completion', 'sortable-dashboard-to-do-list');
                                            if (in_array($affected_user,$completed_by)) {
                                                $icon = 'yes';
                                                $title = __('Completed', 'sortable-dashboard-to-do-list');
                                            }
                                            ?>
                                            <li><span class="dashicons dashicons-<?php echo $icon; ?>" title="<?php echo esc_attr($title); ?>"></span><?php echo $user_data->data->display_name; ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="sdtdl-affected-task-info">
                                <span class="dashicons dashicons-migrate"></span>
                                <?php printf(esc_html__('This item was affected to you by %s', 'sortable-dashboard-to-do-list'), $affected_by_name); ?>
                            </div>
                        <?php } ?>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
<div class="sdtdl-collapsed<?php echo $class; ?>" title="<?php esc_attr_e('Show list', 'sortable-dashboard-to-do-list'); ?>">
    <span class="dashicons dashicons-editor-ul"></span>
    <span class="sdtdl-counter"><?php echo $count; ?></span>
</div>