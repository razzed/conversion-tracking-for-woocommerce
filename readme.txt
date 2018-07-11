=== Conversion Tracking for WooCommerce ===
Contributors: marketacumen
Tags: woocommerce, ecommerce, e-commerce, commerce, tracking, javascript, analytics, custom, wcpayload, conversion
Requires at least: 4.0
Tested up to: 4.9.4
Stable tag: 1.0
License: GPLv3
Requires PHP: 5.3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Outputs WooCommerce variables on the cart, checkout, and order confirmation pages as a global named WCPAYLOAD to make integration with analytics and conversion tracking simpler.

== Description ==

**This plugin requires WooCommerce to operate.** Instrumenting analytics for your cart should be straightforward and use standard JavaScript. This plugin aims to solve this to allow you to use your own JavaScript or a tag management solution to integrate your analytics tracking. The idea is that the page outputs the variables you need, sanitized and ready to consume in JavaScript, and you simply pass them along to the analytics packages.

This plugin does not do anything except publish the values you need as JavaScript variables; to make it useful you need to incorporate it into an analytics package and refer to the variables.

Currently, it populates the global variable `window.WCPAYLOAD` with an object structure which, at a minimum, has a member `type` which determines the structure.

The possible values for `type` are:

* `cart`
* `checkout`
* `order-confirmation`

`cart` and `checkout` are nearly identical and place the majority of the values in the `cart` member. `order-confirmation` is similar, but places the majority of the values in the `order` member. 

You can view the source file `output-samples.php` in the plugin directory to see samples of the structure that is output. Values and types should be self-explanatory, they are output directly using **[WooCommerce API](https://docs.woocommerce.com/wc-apidocs/package-WooCommerce.Classes.html)** calls.

= Contribute =

[Github](https://github.com/razzed/conversion-tracking-for-woocommerce)

= Author =

[Kent Davidson](https://github.com/razzed)

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the plugin from Plugins page.

There is currently no configuration of this plugin, but to confirm it's working you can view the source of the cart, checkout, and order confirmation page and look for a global variable called WCPAYLOAD on the page. If you find it, it's working.

= Minimum Requirements =

* WooCommerce 2.0
* PHP version 5.3 or greater

== Frequently Asked Questions ==

= Does it work with WooCommerce 2 and WooCommerce 3? =

Yes, there are compatibility code written which detects what's available and then does the right thing. Testing with WooCommerce 2 has not been extensive so if you find issues, please contact us and report any bugs. We like to be responsive.

= I installed it but it doesn't seem to do anything? =

It doesn't do anything on its own; it simply updates your page state so that a global variable `WCPAYLOAD` is set to the current cart state, or order confirmation state. You need to then connect this to your preferred analytics package to add the events as you wish. 

= Would you add a feature which does X? =

Yes, probably. If you don't ask you don't get.

= I notice you don't have any advertising or anything, what's that about? =

No one actually asks this question, but I found the other plugins out there which have advertising and "Pro" upgrade plans to be annoying. So I wrote this. Enjoy.

== Changelog ==

= Version 1.0 (10-July-2018) =

* Initial release

== Upgrade Notice ==

N/A