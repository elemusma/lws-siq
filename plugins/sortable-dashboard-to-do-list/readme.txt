=== Sortable Dashboard To-Do List ===
Contributors: Jeffinho2016,jfgmedia
Tags: dashboard, to-do, task, list, admin
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 2.0
Requires PHP: 7.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a to-do list to the WordPress dashboard.

== Description ==

The plugin adds a sortable to-do list to your WP dashboard. This can be useful for developers, or even for content writers.
With the possibility to affect tasks to other users, it's like having your own mini Trello directly on your dashboard!

### NEW! Task Affectation ###
<ul>
<li>
To-do list items can be affected to other users
</li>
<li>
Users with affected items can easily see by whom they were affected, and easily flag the items as completed
</li>
<li>
Users who affect items can easily see which users have completed them, and which still haven't
</li>
<li>
Affectation ability depends on the user role
</li>
<li>
By default:
<ul>
<li>
Administrators can affect items to all users with the "edit_posts" capability
</li>
<li>
Editors can affect items to editors, contributors, and authors
</li>
<li>
Other user roles can only affect items to other users with the same role
</li>
</ul>
</li>
<li>
This feature is currently not activated for multisite setups
</li>
<li>
4 new WP filters to provide further control on affectation rights
</li>
</ul>

### Item Creation ###
<ul>
<li>
To-do list item creation, edition and deletion via ajax. No page reload.
</li>
<li>
To-do items are timestamped. You'll never forget when they were created, or when you last edited them.
</li>
<li>
The list is individual. Each user has their own list.
</li>
<li>
For multisite, it's one list per user and per site.
</li>
</ul>

### Front-end Display ###
<ul>
<li>
Option to display the to-do list on the website (for the current logged-in user only).
</li>
<li>
Website list can be collapsed and expanded. But website items can currently NOT be edited or sorted.
</li>
<li>
Website list remembers its last display state (showed or collapsed)
</li>
<li>
Website list remembers the size, position and state of opened to-do items
</li>
<li>
Website list can be displayed on the left or right side of the window
</li>
<li>
Possibility to decide to not show some to-do items on the website.
</li>
</ul>

### WP Filters ###

**Manage affectation rights:**

"sdtdl_users_not_allowed_to_affect" to prevent some users to be able to affect items, by returning an array of user IDs: `add_filter('sdtdl_users_not_allowed_to_affect',function(){return['3','6','8'];})`

"sdtdl_[user_role]_can_affect_to" to allow a specific user role to affect items to other roles, by returning an array of roles: `add_filter('sdtdl_editor_can_affect_to',function(){return['administrator','editor'];})`

"sdtdl_[user_role]_cannot_affect_to_users" to prevent specific roles from affecting tasks to specific users, by returning an array of user IDs: `add_filter('sdtdl_[user_role]_cannot_affect_to_users',function($current_user_id){return['2','4'];})`

"sdtdl_never_affect_task_to_users" to prevent specific users from ever being affected any tasks, by return an array of user IDs: `add_filter('sdtdl_never_affect_task_to_users',function(){return['1'];})`

Administrators can affect tasks to all user roles with the "edit_posts" capability, but this can also be altered with the previous 3 filters.

**Manage list creation rights:**

By default, users with the "edit_posts" capability can create a to-do-list
"sdtdl_min_user_capability" to override this minimum capability: `add_filter('sdtdl_min_user_capability',function(){return 'publish_posts';})`

== Installation ==

1. Visit the Plugins page within your dashboard and select "Add New"
2. Search for "Sortable Dashboard To-Do List"
3. Click "Install"

== Screenshots ==

1. The To-Do List dashboard widget
2. The website list, in its collapsed (left) and expanded (right) forms
3. The website list, with a bunch of tasks opened for consultation

== Upgrade Notice ==
Not available at the moment

== Frequently Asked Questions ==

= Will this plugin slow down my site? =

It will have no impact on site speed whatsoever. The plugin only launches for users that have the ability to edit posts.

== Changelog ==

= 2.0 =
* It is now possible to affect items to other users. Read the description tab for more info

= 1.3.1 =
* Fix: Potential crash for new users

= 1.3 =
* Min capability can be overridden via the "sdtdl_min_user_capability" filter.
* The "rate our plugin" prompt can be removed by returning true through the "sdtdl_remove_rating_reminder" filter.
* To-do items are no longer stored in the WP options db table, but in their own table.

= 1.2.1 =
* Fix: encoding of special HTML characters in the Edit screen

= 1.2 =
* Settings now automatically save
* It is now possible to choose the accent color of the to-do list

= 1.1 =
* It is now possible to choose on which side of the window the list should be displayed

= 1.0.5 =
* Tested up to WordPress 6.6
* Bumped minimum PHP version to 7.2

= 1.0.4 =
* CSS Fix: improved display of &lt;ul&gt; and &lt;ol&gt; lists

= 1.0.3 =
* Fix: Some translatable strings were not on the correct text domain

= 1.0.2 =
* Added an uninstall hook to remove all plugin traces from database on uninstall

= 1.0.1 =
* Added JFG Media as author and contributor

= 1.0 =
* Initial Release