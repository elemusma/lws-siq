<?php

/**
 * Plugin Name: Sortable Dashboard To-Do List
 * Description: The plugin adds a sortable to-do list to your WP dashboard. This can be useful for developers, or even for content writers.With the possibility to affect tasks to other users, it's like having your own mini Trello directly on your dashboard!
 * Version:     2.2.1
 * Author:      JFG Media
 * Author URI:  https://jfgmedia.com
 * Text Domain: sortable-dashboard-to-do-list
 * Domain Path: /lang
 * License: GPLv2 or later
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define('SDTDL_PLUGIN_FILE', __FILE__);

require_once __DIR__ .'/classes/sdtdl.php';

add_action('init', ['SDTDL\SDTDL', 'init']);
register_uninstall_hook(__FILE__, ['SDTDL\SDTDL','uninstall_plugin']);