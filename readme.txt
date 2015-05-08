=== Admin Menu Class by 010Pixel ===
Contributors: 010pixel
Donate link: https://pledgie.com/campaigns/28628
Tags: admin menu, class, 010pixel, dev
Requires at least: 3.1
Tested up to: 4.1.1
Stable tag: 1.2.0
License: GNU General Public License, version 3 (GPL-3.0)
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Admin Menu PHP Class helps developer easily create menus and submenus in WordPress Admin Panel


== Description ==

This plugin is for Theme Developers to create menu on left navigation in wordpress admin panel. It simplifies code for creating menus/submenus.
Supports including files for each page if necessary.


== Installation ==
1. Unpack the download-package
2. Upload folder include all files to the `/wp-content/plugins/` directory. The final directory tree should look like `/wp-content/plugins/010pixel-admin-menu-class/admin_menu_class_by_010pixel.php`
3. Activate the plugin through the `Plugins` menu in WordPress
4. That's it, you can start using use this class in your theme to make menus in admin panel.

* or use the automatic install via backend of WordPress


== Frequently Asked Questions ==

= How to use this class? =

The plugin file contains a sample code which explains how to use this class to create menus.

= How to include file for the page? =

Add a parameter called `'include' => 'file_path'` for any menu/submenu item you want to include file for.

== Use ==

Create arguments array (as shown in sample code in plugin file) and call the class, it will handle everything.

For any query, you can contact me at [010 Pixel](http://www.010pixel.com/)

== Changelog ==

= v1.0.0 =
* Initial release.

= v1.1.0 =
* Added support for including files for each menu/submenu item

= v1.1.1 =
* Removed bug in converting users to array of users [line: 213, 244]

= v1.2.0 =
* Create only those menu/submenu item which are necessary for logged-in user roles