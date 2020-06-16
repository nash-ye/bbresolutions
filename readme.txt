=== bbResolutions ===
Contributors: alex-ye
Tags: bbpress, buddypress, support, helpdesk
Requires at least: 5.0
Tested up to: 5.4.2
Requires PHP: 5.3
Stable tag: 0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.patreon.com/nash1ye

A bbPress plugin to set your forum's topic resolutions.

== Description ==

bbResolutions is a robust plugin that lets you set a predefined resolution with your bbPress forums topics.

The bbPress forum owners usually use bbResolutions to improve their support forums moderation and follow up workflows as the plugin makes it so easy for moderators and topics authors to mark their topic as Resolved, Not Resolved or Not a Question.

The plugin is easy to use and requires minimal configuration. It will merely add a dropdown on the topic page that lets the user change the topic's resolution directly from the front-end. For any topic marked as resolved, a simple sticker will be added before the topic title to distinguish them easily.

The plugin is also flexible and developer-friendly. Resolutions list can be modified, added, or removed using the plugin's API. It also has multiple hooks that developers can utilize to improve the default functionally.

Here is a list that highlights the main features of bbResolutions:
- A robust and straightforward implementation.
- **Resolutions Manager**: A simple API to register new resolutions with custom keys, labels, stickers, and values or unregister default ones.
- **Front-end Form**:  A simple, customizable form that lets the topic's author easily and securely update the topic's resolution from the site front-end.
- **Topics Stickers**: The plugin automatically adds a simple, customizable sticker to the topic title on the archive pages to easily distinguish topics with different resolutions.
- **Widgets**: A simple widget to list topics with a predefined resolution such as "Issues To Be Resolved" or "Recently Resolved Issues"...etc.
- **Developer-friendly**: The plugin has dozens of actions and organized functions that can be utilized to integrate the plugin into a broad set of projects and use-cases.
- **Compatibility**: The plugin is fully compatible with the latest version of bbPress, WordPress, and PHP.
- **Performance**: High performance with minimal footprint, optimized, and regularly checked codebase.
- **Multilingual**: The plugin is ready to be translated into your language!

= Contributing =
Developers can contribute to the source code on the [Github Repository](https://github.com/nash-ye/bbresolutions).

== Installation ==

* Upload bbResolutions folder to the plugins directory.
* Activate the plugin through the 'Plugins' menu in WordPress.
* Enjoy! :-)

== Changelog ==

= 0.7 =
* Enhance the codebase
* Integrate Freemius

= 0.6 =
* Hotfix for Recent Topics widget.

= 0.5 =
* Hotfix for Recent Topics widget.

= 0.4 =
* Better code organizations.
* Smarter classes files loading.

= 0.3 =
* Change the plugin textdomain to 'bbresolutions'.
* Better code style formatting.

= 0.2.4 =
* Add new WP filters "bbr_show_topic_resolution_form" and "bbr_show_topic_resolution_feedback".

= 0.2.3 =
* Change the plugin textdomain to 'bbResolutions'.
* Add a new widget to display a list of recent topics with an option to set the resolution.

= 0.2.2 =
* Fix Bug: bbPress or BuddyPress codes didn't loaded in some cases.

= 0.2 =
* Add the Arabic language.
* Display the topic-resolution sticker.

= 0.1 =
* Initial version.