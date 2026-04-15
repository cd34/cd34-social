=== Plugin Name ===
Plugin Name: Async Social Media Buttons (Twitter/X, Facebook, Pinterest)
Contributors: cd34
Tags: facebook, twitter, pinterest, social, sharing
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.0

Twitter/X, Facebook, and Pinterest sharing buttons loaded via async JavaScript for fast page loads.

== Description ==

Twitter/X, Facebook, and Pinterest sharing buttons loaded via async JavaScript, minimal presentation. See screenshots tab to see what the icons look like at the bottom of your posts.

Why do I want Async Javascript?

When someone loads your site, every synchronous script include causes loading to 'block'. By loading the JavaScript for the buttons asynchronously, we wait until the page is loaded, then our script runs and modifies the page. This does make the icons appear to be the last to load, but it does not prevent your page from being rendered and displayed.

== Installation ==

1. Activate the plugin through the 'Plugins' menu in WordPress
2. If desired, Settings, cd34 Social Buttons, disable or enable each of the
social media buttons as desired.

The default option is to display the buttons on each post both on the front page of the site and each of the individual posts. You have the option of disabling the display on the posts on the front page, and disabling each of the Social Media Buttons independently.

== Frequently Asked Questions ==

= Why do the icons load last? =

The HTML placeholders for the buttons are loaded on pageload. Until the entire page is loaded, the async JavaScript isn't loaded. Once the page has loaded and is fully rendered, the JavaScript updates the DOMs and the buttons appear.

= It doesn't work =

If your template does not call wp_footer() and wp_enqueue_scripts properly, the JavaScript may not load. You can verify by checking if the sharing links appear but the buttons don't render.

= Pinterest only picks the first image from my post =

The Pinterest button uses the featured image if set, otherwise the first image found in the post content. It does not currently read galleries.

== Screenshots ==

1. Social Bar at bottom of post

== Changelog ==

= 1.0 =
* Removed Google+ (service shut down in 2019)
* Updated Facebook SDK from deprecated all.js to sdk.js
* Updated Twitter to X branding and modern share intents
* Fixed XSS vulnerabilities — all output is now properly escaped
* Use wp_enqueue_script instead of inline script injection
* Only load scripts for enabled buttons
* Use has_post_thumbnail for Pinterest image detection
* Modernized settings registration with proper sanitize callbacks
* Added ABSPATH guard
* Code cleanup and WordPress coding standards

= 0.7 =
* Add the buttons to display on excerpts

= 0.6 =
* Reversed default to show social buttons on homepage and posts

= 0.5 =
* Added ability to disable social button display on homepage
* Added media selection for pinterest (does not handle galleries currently)

= 0.4 =
* Default on new install/upgrade didn't show buttons until options were saved.
* Documentation update

= 0.3 =
* Added Pinterest
* Options page to select which buttons to include

= 0.2 =
* Fixed XFBML Javascript include
* Hide Javascript to allow HTML validation

= 0.1 =
* Initial release

== Upgrade Notice ==

= 1.0 =
Major update: Google+ removed (dead service), security fixes, modernized APIs for Facebook/Twitter/Pinterest. Please verify your settings after upgrade.
