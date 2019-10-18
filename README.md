# Standout Fortnox Integration for WooCommerce

**** Currently in beta – send an mail to support@standout.se if you want to participate ****

## Do you want to simplify your accounting?
Automate your e-commerce accounting by integrating WooCommerce for your incoming orders directly to Fortnox. Quick, easy and hassle-free!

Features included:
* New orders in WooCommerce create the corresponding invoice in Fortnox
* Orders paid in WooCommerce are linked to payment in Fortnox
* Handling of canceled orders
* VAT and other settings on the order synced over to Fortnox

## Installation

The plugin will automatically create a woocommerce api key when user clicks "Connect to Fortnox" button.
This will send the credentials to our integration.
If you want more information, do not hasitate to contact our support.

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
12. Your site will now be connected to Fortnox within 2 workdays.

## Development

"Woocommerce-Fortnox-Integration" has been translated into 2 locales.

## Changelog
**1.1.1 - 2019-09-12**

**Added**
* Added support to connect (add an API key).
* Added support to disconnect (delete an API key).
* Added support to get the users id that clicks on the button connect or disconnect.
* Added support to check if there is an existing API key in the database before creation or deletion.
* Added the options page in Woocommerce Settings. New field Fortnox API key and Your ID key.
* Added connect and disconnect button. If there is an existing API key, the disconnect button will show.
* Added support to hide the connect button if Fortnox API key and Your ID key field is empty.
* Added support to call for a function on button click with AJAX.
* Added support for translation. At present, the plugin is available in English and Swedish.

**1.1.2 - 2019-09-14**

**Added**
* Creation of API keys also stores the key_id field in the options table 
* Deletetion of the API keys is now based on the key_id field
* Prepare function to send json data to a Fortnox endpoint
* Added .gitignore file

**1.1.3 - 2019-18-10**

**Added**
* Added functionality to automatically send the credentials to our integration via email.
