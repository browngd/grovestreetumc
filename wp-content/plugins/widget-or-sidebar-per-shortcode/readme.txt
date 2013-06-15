=== Plugin Name ===
Contributors:f.staude)
Donate link: http://example.com/
Tags: widgets, page, post, sidebar, shortcode
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: 0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Use widgets or sidebars per shortcode in the content area from pages/posts

== Description ==

This plugin implements 2 new shortcodes.

[widget name="" instance=""] to use a widget per shortcode in the content area from a page/post.

name is the name of the widget, e.g.  Calendar.
instance are the attributs of the widget. e.g.  title=Hello,World!  so the complete shortcode is
[widget name="Calendar" instance="title=Hello,World!"]

For the instance list of the Wordpress builtin Widgets look at http://codex.wordpress.org/Function_Reference/the_widget
For other Widgets look at the source code from the widget or ask the widget author.


[sidebar name=""] to use a sidebar (with all widgets) in the content area from a page/post.

name is the name of the sidebar e.g. Showcase Sidebar so the complete shortcode is
[sidebar name="Showcase Sidebar"]


For own css styling, the plugin wraps the widgets in < div id="Widget_Name" class="widget_shortcode"> and the sidebar in < div id="Sidebar_Name" class="sidebar_shortcode">

== Installation ==

1. Install the plugin from within the Dashboard or upload the directory `widget-or-sidebar-per-shortcode` and all its contents to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use the shortcodes.

== Frequently Asked Questions ==

= What is the instance parameter? =

instance are the attributs of the widget. e.g.  title=Hello,World!  so the complete shortcode is
[widget name="Calendar" instance="title=Hello,World!"]

For the instance list of the Wordpress builtin Widgets look at http://codex.wordpress.org/Function_Reference/the_widget
For other Widgets look at the source code from the widget or ask the widget author.



== Screenshots ==
1. Using the shortcode in the content area of an post.

2. The output from the shortcode at Screenshot 1


== Changelog ==

= 0.2 =
- typo in readme
- filenames changed to repository name ("fs-" removed)
- fix: wrong directory name in installation part of readme

= 0.1 =
First version.

