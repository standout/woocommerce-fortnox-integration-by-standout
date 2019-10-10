=== Standout Fortnox Integration for WooCommerce ===
Contributors: standoutab
Tags: woocommerce, fortnox
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 4.3
Requires PHP: 5.2.4
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Automate your e-commerce accounting by integrating WooCommerce for your incoming orders directly to Fortnox. Quick, easy and hassle-free!

== Description ==

'Currently in beta – send an mail to support@standout.se if you want to participate'

Do you want to simplify your accounting?
Automate your e-commerce accounting by integrating WooCommerce for your incoming orders directly to Fortnox. Quick, easy and hassle-free!

Features included:
* New orders in WooCommerce create the corresponding invoice in Fortnox
* Orders paid in WooCommerce are linked to payment in Fortnox
* Handling of canceled orders
* VAT and other settings on the order synced over to Fortnox

Installation

1. Locate and add the plugin in wordpress by searching for “WooCommerce-Fortnox-Integration by Standout”.
2. Activate the plugin through the “Plugins” menu in WordPress.
3. Login to Fortnox and click on your username in the upper right corner and selct “Administer users”.
4. Click on “Add integration” in the lower right side.
5. Type “Woocommerce-Fortnox-Integration by Standout” in the searchbox and select “Woocommerce-Fortnox-Integration by Standout” as integration and click “Approve”.
6. Click in the key symbol in the “API Code” field to copy the code.
7. Navigate to WooCommerce->Settings->Fortnox Integration.
8. Paste the code into the "Fortnox API-key" field.
9. Fill in field "ID-key" with the key you received in connection with the purchase
10. Click “Save Changes”.
11. Then click on "Connect".
12. Your plugin is now connected to Fortnox.

Development

"Woocommerce-Fortnox-Integration" has been translated into 2 locales.

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

== Screenshots ==

1. /assets/screenshot1.png
2. /assets/screenshot2.png

== Changelog ==

= 1.1.2 =
* Added creation of API keys also stores the key_id field in the options table
* Added deletetion of the API keys is now based on the key_id field
* Prepare function to send json data to a Fortnox endpoint
* Added .gitignore file

= 1.1.1 =
* Added support to connect (add an API key).
* Added support to disconnect (delete an API key).
* Added support to get the users id that clicks on the button connect or disconnect.
* Added support to check if there is an existing API key in the database before creation or deletion.
* Added the options page in Woocommerce Settings. New field Fortnox API key and Your ID key.
* Added connect and disconnect button. If there is an existing API key, the disconnect button will show.
* Added support to hide the connect button if Fortnox API key and Your ID key field is empty.
* Added support to call for a function on button click with AJAX.
* Added support for translation. At present, the plugin is available in English and Swedish.

== Upgrade Notice ==

= 1.1.2 =
Added functionality to send api keys to endpoint and deletion of the api keys.

= 1.1.1 =
Added functionality to connect and disconnect from the integration. Main plugin.
