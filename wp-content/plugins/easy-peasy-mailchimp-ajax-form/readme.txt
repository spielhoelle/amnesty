=== Easy Peasy MailChimp Ajax Form ===
Contributors: alessandro.tesoro
Tags: email, mailchimp, marketing, newsletter, plugin, signup, MailChimp form, MailChimp Newsletter form, MailChimp plugin, ajax mailchimp, mailchimp ajax form
Requires at least: 3.8
Tested up to: 4.1
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Easy Peasy MailChimp plugin allows you to easily add an ajax powered MailChimp newsletter subscribe form in any page of your WordPress site.

== Description ==
The Easy Peasy MailChimp plugin allows you to easily add an ajax powered MailChimp newsletter subscribe form in any page of your WordPress site. You can add forms to posts or pages with a shortcode or to template files with PHP tags. Simply copy and paste your MailChimp API Key and list ID into the plugin admin settings and you're good to go. 

Using some fancy Ajax technology your users can sign up without the page refreshing, making the process fast, and unobtrusive to the browsing experience. The form also comes with plenty of css selectors that allow you to customize the layout of the signup form. 

In addition, the plugin comes with an intelligent templating system that allow you to easily customize the markup of the form if you need to, read the faq section for more information.

After Installation, the setup page will guide you through entering your API key and MailChimp list id number as well as few other settings. Having a fully functional form on your site should take less than 5 minutes - everything can be done via the plugin settings panel.

= Features List =

1. Ajax powered newsletter registration form
1. Extremely easy to setup
1. Plenty of css selectors to customize the layout
1. No additional css or js files are added to your website.
1. Lightweight plugin
1. Intelligent templating system to customize the markup of the form.

> **Want More?**
> Take a look at some of my other products:
> [Free WordPress plugins](http://profiles.wordpress.org/alessandrotesoro/) | [Premium WordPress Themes](http://themeforest.net/user/ThemesDepot/portfolio) | [Follow Me On Twitter](https://twitter.com/themesdepot)

== Installation ==
1. Upload "easy-peasy-mailchimp" folder to the "/wp-content/plugins/" directory. 
1. Activate the plugin through the "Plugins" menu in WordPress.
1. Navigate to "Settings" -> "MailChimp Settings" of your WordPress admin panel.
1. Enter your MailChimp settings.
1. Save the changes.
1. Add the **[epm_mailchimp]** shortcode to any page or widget(if your theme supports shortcodes in widgets) to display a mailchimp signup form.

Alternatively more specific instruction are available into the settings page of the plugin.

== Frequently Asked Questions ==
= Where can I find my api key? =
[Where can I find my api key?](http://kb.mailchimp.com/article/where-can-i-find-my-api-key).

= Where can I find my list ID? =
[Where can I find my list ID?](http://kb.mailchimp.com/article/how-can-i-find-my-list-id).

= How can i add the form into a page or post or widget? =
Use the following shortcode to display a form anywhere you want
'[epm_mailchimp]'

= How can i customize the markup of the form? =
1. Open your custom theme folder and create an empty folder and call it "epm" (without quotes)
1. Navigate to folder wp-content/plugins/easy-peasy-mailchimp/templates
1. Copy file mailchimp-form.php
1. Paste the file into the "epm" subfolder that you created into your theme folder 

= How can i disable the validation error message? =
If you wish to disable the validation message, add the following code into your theme's function.php file

`function epm_disable_validation_error() {
	return 'disabled';
}
add_filter('epm_filter_validation', 'epm_disable_validation_error');`

= How can i disable the success message? =
If you wish to disable the success message, add the following code into your theme's function.php file

`function epm_disable_success_message() {
	return 'disabled';
}
add_filter('epm_filter_success', 'epm_disable_success_message');`

== Screenshots ==
1. Plugin Settings panel
1. Shortcode in a page

== Changelog ==
= 1.0.5 =
* Fixed: php notices displaying when debug mode enabled.  

= 1.0.4 =
* Added: plugin will not activate if your web host is living in the stone age. Plugin requires PHP 5.3 or greater to work.  

= 1.0.3 =
* Added: Ability to display multiple forms in the same page.
* Added: The email field will automatically fill itself with the current logged in user email address if the user is already logged into your website.

= 1.0.2 =
* Fixed: Issue with validation messages not displaying correct validation message if name and first name field are enabled.

= 1.0.1 =
* Fixed: Name and last name fields validation message still being displayed even if fields are disabled.

= 1.0.0 =
* Initial release.