=== Conversion Tracking for WooCommerce ===

Contributors: marketacumen
Tags: woocommerce, ecommerce, e-commerce, commerce, tracking, javascript, analytics, custom, tracking-pixel, wcpayload, conversion
Requires at least: 4.0
Tested up to: 4.9.4
Stable tag: 1.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Outputs JavaScript variables on the page as a global named WCPAYLOAD on the cart and order confirmation page. You can then use these variables in your analytics tracking code as you wish. This is intended for developers or for marketing professionals who know how to incorporate these values into external tag management solutions.

== Description ==

Instrumenting analytics for your cart should be straightforward and use standard JavaScript. This plugin aims to solve this to allow you to use your own JavaScript or a tag management solution to integrate your analytics tracking. The idea is that the page outputs the variables you need, sanitized and ready to consume in JavaScript, and you simply pass them along to the analytics packages.

This plugin does not do anything except publish the values you need as JavaScript variables; to make it useful you need to incorporate it into an analytics package and refer to the variables.

= Contribute =

[Github](https://github.com/razzed/conversion-tracking-for-woocommerce)

= Author =

[Kent Davidson](https://marketacumen.com/?crcat=wp-plugin&crsource=conversion-tracking-for-woocommerce&crcpn=readme&crkw=author)

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the plugin from Plugins page.

= Minimum Requirements =

* WooCommerce 2.0
* PHP version 5.3 or greater

== Frequently Asked Questions ==

= Does it work with WooCommerce 2.x and 3.x? =

Yes, the plugin should work with both with the latest v3.x and the older 2.x versions.

= I installed it but it doesn't seem to do anything? =

It doesn't do anything on its own; it simply updates your page state so that a global variable `WCPAYLOAD` is set to the current cart state, or order confirmation state. You need to then connect this to your preferred analytics package to add the events as you wish. 

== Changelog ==

= Version 1.0 (10-July-2018) =

* Initial release

== Upgrade Notice ==

N/A