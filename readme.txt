=== Admin bar languages ===
Contributors: simison
Donate link: http://www.mikaelkorpela.fi/volunteering/
Tags: admin, i18n, l10n, localization, admin bar, adminbar, toolbar, menu, my sites, network, multi-site, multisite, MU, flags, flag, icon, icons
Requires at least: 3.6
Tested up to: 4.0
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Show language flags at "My sites" list in WordPress admin bar.


== Description ==

Show language flags at "My sites" list in WordPress admin bar. Handy with multisite installation when you have blogs with the same name but their locale would be different. With this plugin you'll be able to see the difference between them.

[Donations](http://www.mikaelkorpela.fi/volunteering/) are totally welcome, I'm spending most of my working time on open source and volunteer projects.

Plugin uses [GoSquared's Flag Icon Set](https://github.com/gosquared/flags) ([MIT License](https://github.com/gosquared/flags/blob/master/LICENSE.txt)). Hooray for them!

Plugin source code at [WordPress repository](http://wordpress.org/extend/plugins/admin-bar-languages/) and at [GitHub](https://github.com/simison/WP-admin-bar-languages).

== Installation ==

1. Unzip plugin and upload `admin-bar-blog-languages` folder to the `/wp-content/plugins/` directory
2. 'Network Activate' the plugin through the 'Network admin' -> 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Will I be able to change the locale of my blog?  =

No, this plugin just shows the locale of your site for admins.

= Does this plugin work with WP 3.x?  =

Yes! It's tested down to 3.6.

== Screenshots ==

1. Before, after

== Changelog ==

= 1.1 =
2014-10-20
* Transform plugin code into a Class to make sure we have WP's core functionality loaded before this plugin.

= 1.0 =
2014-09-10
* Yay, first version!
