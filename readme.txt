=== ConquerLocal Platform ===
Contributors:      Vendasta
Tags:              block
Tested up to:      6.0
Requires PHP:      5.6.20
Stable tag:        1.5.9
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

ConquerLocal Platform helps site builders & developers add Help center search, CL 2.0 page gutenberg blocks, CL banners and more to your Wordpress website

= Documentation =

- [Figma Design](https://www.figma.com/file/TKwzwqNxZxnCkNk6vEO23U/Conquer-Local-Landing-Page)
- [Github](https://github.com/vendasta/conquer-local-academy-platform)

== Requirements ==

To run ConquerLocal Platform, we recommend your host supports:

* PHP version 7.2 or greater.
* MySQL version 5.6 or greater.
* HTTPS support.

== Installation ==

1. Make sure you have the Vender folder installed using `composer install`. The Vendor folder is needed for this plugin not to crash and work properly.
2. Upload the plugin files to the `/wp-content/plugins/conquerlocal-platform` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress
4. Activate 'ConquerLocal Platform' from your Plugins page.

If you are using FIlezilla just drag this folder locally into the `/wp-content/plugins/block-library`

== Setup ==

This section describes any settings the admin will initially need to set in the dashboard for this plugin.

== Frequently Asked Questions ==

= My site crashed after i installed this plugin :( =

Check to see if you have your PHP Vendor folder. If not run `composer install` locally have this folder ready them re-install the plugin

== Changelog ==

= 1.0.0 =
* Release

= 1.1.1 =
* Added ConquerLocal Banners to WP admin menu
* Added custom post type for banners
* Added shortcode to display the banners in the UI using get_posts method
* Added Custom Columns to Banner List at the Banner Admin menu

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above. This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation." Arbitrary sections will be shown below the built-in sections outlined above.
