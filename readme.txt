=== MainWP Client Repors Extension ===
Plugin Name: MainWP Client Reports Extension
Plugin URI: https://mainwp.com
Description: MainWP Client Reports Extension allows you to generate activity reports for your clients sites. Requires MainWP Dashboard.
Version: 1.1
Author: MainWP
Author URI: https://mainwp.com
Icon URI:

== Installation ==

1. Please install plugin "MainWP Dashboard" and active it before install MainWP Client Reports Extension plugin (get the MainWP Dashboard plugin from url:http://mainwp.com/)
2. Upload the `mainwp-client-reports-extension` folder to the `/wp-content/plugins/` directory
3. Activate the Mainwp Client Reports Extension plugin through the 'Plugins' menu in WordPress

== Screenshots ==
1. Enable or Disable extension on the "Extensions" page in the dashboard

== Changelog ==

= 1.1 = 4-8-2016
* Fixed: Bug with saving report header and footer templates
* Fixed: Bug with saving report settings
* Fixed: Bug with displaying local time for Last Run and Next Run values

= 1.0 = 2-17-2016
* Fixed: Bug with generating PDF file
* Fixed: Bug with sending report caused by empty Client field
* Fixed: Translation issue
* Fixed: Issue with attaching PDF files
* Added: Support for the new Add Site process
* Added: An auto update warning if the extension is not activated
* Added: Support for the new API management
* Added: Support for WP-CLI
* Updated: Refactored code to meet WordPress coding standards
* Updated: "Check for updates now" link is not vidible if extension is not activated
* Updated: tcpdf library
* Updated: Ability to send report to multiple emails

= 0.1.2 = 8-3-2015
* Added: Support for the MainWP Child Reports plugin
* Added: Additional schedule options (Quarterly, Twice a Year, Yearly)

= 0.1.1 = 
* Fixed: An issue with displaying GA tokens

= 0.1.0 = 
* Updated: Quick start guide layout

= 0.0.9=
Added: Google Analytics chart token
Added: Report Data range token

= 0.0.8=
Fixed: Issue with clearing data for deleted sites
Fixed: Issue with first sending of a scheduled reoprt

= 0.0.7=
Fixed: Google Analytics not showing in scheduled reports
Fixed: Advanced Uptime Monitor tokens not showing in sheduled reports
Fixed: Scheduled gloabl reports not being sent
Tweaked: First scheduled report sending time

= 0.0.5=
Fixed: [plugin.current.version] and [theme.current.version] token values

= 0.0.4=
Added: WooCommerce Status Tokens
Added: Advanced Uptime Monitor Tokens
Added: Un-Archive Feature
Fixed: Usability Issue where scheduled reports are automatically archived after 30 days

= 0.0.3=
Added: Backup Tokens
Added: Sucuri Tokens
Added: Piwik Tokens
Added: GA Tokens
Added: Global Reports
Added: Tokens in Report Settings Section
Added: Redirection to the extensions page after activating
Added: Aditional plugin info
Fixed: PHP Warning

= 0.0.2 =
* New Feature Added: Email attachment
* New Feature Added: Report scheduling

= 0.0.1 =
* First version

