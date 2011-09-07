=== Timthumb Vulnerability Scanner ===
Contributors: peterebutler
Tags: security, scanning, timthumb, hack
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: trunk

Scans your wp-content directory for vulnerable instances of timthumb.php, and optionally upgrades them to a safe version.

== Description ==

The recent Timthumb.php vulnerability (discussed [here](http://markmaunder.com/2011/08/02/technical-details-and-scripts-of-the-wordpress-timthumb-php-hack/)) has left scores of unsuspecting bloggers hacked. It's the perfect combination of not so easy to fix for the technically disinclined, and easy to find and exploit for the malicious - resulting in a disastrous number of compromised sites.

The Timthumb Vulnerability Scanner plugin will scan your entire wp-content directory for instances of any outdated and insecure version of the timthumb script, and give you the option to automatically upgrade them with a single click.  Doing so will protect you fromhackers looking to exploit this particular vulnerability.

More info at [CodeGarage](http://codegarage.com/blog/2011/09/wordpress-timthumb-vulnerability-scanner-plugin/).

Special thanks to [Jacob Gillespie](http://jacobwg.com/) for help with the bulk upgrade feature.
== Installation ==

1. Upload the `timthumb-vulnerability-scanner to the `/wp-content/plugins/` directory (alternatively, you could use the backend WordPress plugin installer, or install directly from the repository)
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Visit the "Timthumb Scanner" page under the "Tools" Menu

== Frequently Asked Questions ==

= What does this look for specifically? =

The scanner checks for instances of timthumb that are older than version 2.0.

= Where does it look for them? =

The entire wp-content directory (even if it's not called wp-content) is scanned, including plugins, themes, and uploads.

= I think I've already been hacked - will this clean it up? =

No.  This plugin exists to make sure your door is locked, not drag the burglers out of your house.  If you've already been hacked, all is not lost - there are people out there who will clean up your site for a fee.  Look one up instead of just assuming the site is a loss!


== Screenshots ==

1. After clicking "Scan!", you'll be presented with a list of safe files found, and unsafe files found.  Clicking "Fix" on any unsafe file will replace it with a safe version of timthumb.

== Changelog ==

= 1.3 =
* Updated formatting to conform with WP coding standards, added bulk upgrade feature (Thanks to [Jacob Gillespie](http://jacobwg.com/)!).

= 1.2 =
* Updated scanner to more reliably find versions of timthumb - avoids conflict with plugin "Category Icons".

= 1.1 =
* Updated scanner to find *really* old versions of timthumb.

= 1.0 =
* Initial Commit.
