WP Newsletter Subscription Plugin
=================================

This WordPress plugin enables website owners to collect names and email addresses from users who wish to subscribe to a newsletter. The plugin inserts a modal on all frontend pages for user subscriptions and manages the data through a custom MySQL table. An admin page is included for easy management and viewing of subscriber data.

It is primarily intended for use by developers who wish to customize the plugin's appearance and behavior. The plugin is designed to be easily modified and extended.

Features
--------

-   **Subscription Modal:** A user-friendly modal on the frontend for newsletter subscription.
-   **Custom MySQL Table:** Securely stores subscription data in a dedicated table.
-   **Admin Management Page:** View and manage subscriber data within the WordPress admin area.
-   **Compliance with TOS & Privacy Policy:** Includes a checkbox for users to agree to Terms of Service and Privacy Policy.
-   **Responsive Design:** Ensures the modal looks good on all devices.

Installation
------------

1.  **Upload the Plugin:** Upload the plugin files to the `/wp-content/plugins/` directory.
2.  **Activate the Plugin:** Activate the plugin through the 'Plugins' menu in WordPress.
3.  **Plugin Setup:** The plugin automatically creates the necessary database table upon activation.

Usage
-----

-   **Frontend Subscription Modal:** The modal is triggered by clicking an element with a special HTML class: `open-newsletter-modal`. Customize this class in the plugin's JavaScript file.
-   **View Subscribers:** Access the subscriber list from the admin menu under 'Newsletter Subscribers'.

Customization
-------------

-   **JavaScript and CSS Files:** Easily customize the modal's appearance and behavior.
-   **Extendable Codebase:** Designed for easy modifications and extensions.

About
-----

This plugin was created using the WP Plugin Architect GPT. For more information, visit: [WP Plugin Architect GPT](https://chat.openai.com/g/g-6cqBCrKTn-wp-plugin-architect)

License
-------

This plugin is open source and licensed under the GPL v2 or later.