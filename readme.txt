=== Plugin Name ===
Plugin Name: Async Social Media Buttons (Google+, Twitter, Facebook, Pinterest)
Contributors: cd34
Tags: google, facebook, twitter, pinterest
Requires at least: 2.7
Tested up to: 3.4-RC1
Stable tag: 0.7

Google+, Twitter, Facebook, and Pinterest Buttons loaded via Async Javascript, minimal presentation.

== Description ==

Google+, Twitter, Facebook and Pinterest Buttons loaded via Async Javascript, minimal presentation. See screenshots tab to see what the icons look like at the bottom of your posts.

Why do I want Async Javascript?

When someone loads your site, every &lt;script src="http://someurl.com/"&gt;&lt;/script&gt; causes loading to 'block'. If the browser doesn't have an available connection to load the css stylesheet or included javascript, it must wait until another file request completes to load the next one. On pages with dozens of css files and javascript includes, it can cause a site to appear to be slow, even if the site uses caching and comes up quickly.

By loading the javascript for the buttons asynchronously, we wait until the page is loaded, then, our script runs and modifies the page. This does make the icons appear to be the last to load, but, it does not prevent your page from being rendered and displayed - shaving a few hundred milliseconds from the pageload time. If any of the remote javascripts load slowly, your site is not stalled until they load.

== Installation ==

1. Activate the plugin through the 'Plugins' menu in WordPress
2. If desired, Settings, cd34 Social Buttons, disable or enable each of the
social media buttons as desired.

The default option is to display the buttons on each post both on the front page of the site and each of the individual posts. You have the option of disabling the display on the posts on the front page, and, disabling each of the Social
Media Buttons independently.

== Frequently Asked Questions ==

= Why do the icons load last? =

The HTML placeholders for the buttons is loaded on pageload. Until the entire page is loaded, the async javascript isn't loaded. Once the page has loaded and is fully rendered, the javascript updates the DOMs and the buttons appear. Google counts the pageload to conclude when the page is rendered, therefore, the page completion time is counted prior to the async javascript loading.

= It doesn't work =

If your template is not 3.x compatible, it may not call the two hooks that we use to insert the javascript, or, to insert the buttons. You can tell if the wp_footer() call is not properly supported if you see Tweet as a link under each post and the buttons don't load.

If the buttons don't display, the template may have disabled the filter, or, has another filter plugin that is ending the request early - not allowing our plugin to modify the page.

= Pinterest only picks the first image from my post =

The Pinterest button doesn't allow us to specify more than one image. We pick the first image that we can find. However, we do not currently read a gallery. It also doesn't pull an image from the site if one is not found in the post.

== Screenshots ==

1. Social Bar at bottom of post

== Changelog ==

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

* Now will display on templates that show excerpts
* Reversed default to show social buttons on homepage and posts
* Added ability to disable social button display on homepage
* Added media selection for pinterest (does not handle galleries currently)
