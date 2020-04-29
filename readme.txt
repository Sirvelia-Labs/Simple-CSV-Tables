=== Simple CSV Tables ===
Contributors: sirvelia
Donate link: https://sirvelia.com/
Tags: csv, table, shortcode, datatables
Requires at least: 4.0
Tested up to: 5.4
Requires PHP: 7.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Register and Generate tables from .csv files with a shortcode.

== Description ==

With Simple CSV Tables you will be able to register unlimited CSV files. Those files will be associated to a shortcode that prints a dynamic table anywhere on your site.

== Installation ==

This plugins creates a Custom Post called 'CSV Table', so we recommend updating the permalinks after activation.

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin
3. Update permalinks under 'Settings'.

== Frequently Asked Questions ==

= Can I use multiple CSV files? =

Absolutely. You can import and show as many tables as you like. Every time you import a CSV file, the plugin creates a ‘CSV Table’ post. You will then be able to show that table anywhere on your site using a simple shortcode.

== Screenshots ==
 
1. You can create a New CSV Table, upload the .csv file, and specify the delimeter char.
2. A shortcode will be generated.
3. Use the sortcode to print the table on Posts and Pages.
4. The table is shown.

== Changelog ==

= 1.0.2 =
* Translatable strings

= 1.0.1 =
* Input sanitization && validation
* Local version of datatables instead of using CDN

= 1.0 =
* Initial
