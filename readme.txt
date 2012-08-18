=== Plugin Name ===
Contributors: tomauger
Tags: WP_Query, filters, hooks, learning, demonstration, not-for-production
Requires at least: 3.0.0
Tested up to: 3.5-alpha-21466
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This demonstration plugin identifies the primary filters that are used by WordPress as it parses your queries.

== Description ==

This plugin, once activated, spits out the information passed by each filter used in manipulating database queries, as a learning tool.

The code itself is heavily documented and demonstrates best practices for working with those filters and actions to view / manipulate the query.

It is very important to note that **this plugin is not meant for a production environment** as it will insert a lot of really ugly HTML throughout your page. You'll get the most use out of this plugin by looking at its code, and maybe previewing one or two pages on a sandbox, vanilla WordPress site.

== Installation ==

1. Download from wordpress.org/extend/plugins
1. Upload `valz_display_query_filters` to your site's `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

Or just use the onboard plugin downloader like you normally would.

== Frequently Asked Questions ==

= Why did you write this plugin? =

The objective for writing this plugin was to provide a comprehensive, working demonstration of all the filters and action hooks that a query will pass through on its way to being displayed on your page. Note that this plugin does not attempt to only address the main_query, but will spit out its output for each and every query run on that page. That can be a lot of queries if you have a bunch of plugins and whatnot installed. You have been warned.



== Changelog ==

= 0.2 =
* parse_query is actually and action. Updated accordingly.

= 0.1 =
* Initial release prior to WordCamp Montreal 2012
* Oh, it's pretty ugly, I'm not going to deny it.
* But the inline documentation is pretty comprehensive.

