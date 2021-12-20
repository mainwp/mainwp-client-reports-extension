=== MainWP Client Repors Extension ===
Plugin Name: MainWP Client Reports Extension
Plugin URI: https://mainwp.com
Description: MainWP Client Reports Extension allows you to generate activity reports for your clients sites. Requires MainWP Dashboard.
Version: 4.0.10
Author: MainWP
Author URI: https://mainwp.com

== Installation ==

1. Please install plugin "MainWP Dashboard" and active it before install MainWP Client Reports Extension plugin (get the MainWP Dashboard plugin from url:https://mainwp.com/)
2. Upload the `mainwp-client-reports-extension` folder to the `/wp-content/plugins/` directory
3. Activate the Mainwp Client Reports Extension plugin through the 'Plugins' menu in WordPress

== Screenshots ==
1. Enable or Disable extension on the "Extensions" page in the dashboard

== Changelog ==

= 4.0.10 - 12-20-2021 =
* Updated: DOMPDF library
* Updated: PHP 8 compatibility
* Updated: Support for the Lighthouse extension tokens

= 4.0.9 - 6-11-2021 =
* Updated: General performance improvements

= 4.0.8 - 4-28-2021 =
* Fixed: An issue with sending reports for specific setups
* Added: Support for Virusdie tokens
* Updated: General performance improvements

= 4.0.7 - 1-15-2021 =
* Fixed: An issue with sending scheduled reports
* Updated: Support for default WP datepicker

= 4.0.6 - 12-11-2020 =
* Fixed: An issue with sending scheduled reports
* Fixed: An issue with selecting a date range
* Added: PHP Docs blocks

= 4.0.5.1 - 9-10-2020 =
* Fixed: jQuery version compatibility issues
* Updated: MainWP Dashboard 4.1 compatiblity

= 4.0.5 - 8-28-2020 =
* Fixed: An issue with displaying WooCommerce Top Seller product in reports

= 4.0.4 - 7-28-2020 =
* Fixed: an error with sending scheduled reports
* Added: mainwp_client_reports_generate_report_content hook to support tokens in MainWP Dashboard notifications
* Added: mainwp_client_reports_get_site_tokens hook to support tokens in MainWP Dashboard notifications
* Added: mainwp_client_reports_generate_content hook to support tokens in MainWP Dashboard notifications
* Added: mainwp_client_reports_pdf_filename filter to allow setting custom report file names
* Added: mainwp_pro_reports_send_local_time hook to allow sending reports in loca
* Updated: send report process to send reports at localtime.
* Updated: DOMPDF library version

= 4.0.3 - 1-22-2020 =
* Updated: compatibility for the Child Reports plugin 2.0.2

= 4.0.2 - 11-22-2019 =
* Fixed: a problem with creating custom tokens
* Fixed: a problem with saving report date range
* Fixed: multiple usability problems

= 4.0.1 - 9-6-2019 =
* Fixed: an issue with saving report changes
* Fixed: an issue with sending reports
* Fixed: an issue with incorrect [backup.created.count] token value
* Fixed: multiple time and date format issues

= 4.0 - 8-27-2019 =
* Updated: extension UI/UX redesign
* Updated: support for the MainWP 4.0

= 2.3 - 8-2-2018 =
* Fixed: an issue with sending scheduled reports on a specific setups
* Fixed: an issue with inserting tokens from the tokens menu
* Added: new PDF library
* Added: support for chaning date format in the GA chart
* Added: mainwp_client_report_generate hook

= 2.2 - 1-12-2018 =
* Fixed: an issue with sending multiple reports at once
* Fixed: typo
* Updated: scheduling process to send reports at local time

= 2.1.2 - 12-15-2017 =
* Fixed: an issue with reviewing reports
* Fixed: an issue with sending the same report twice
* Fixed: an issue with displaying report date range
* Added: support for the new aum.stats token (Advanced Uptime Monitor 4.2 required)
* Updated: translation support for the Sucuri scan results

Updated: date range for preview scheduled report

= 2.1.1 - 6-23-2017 =
* Fixed: missing class error
* Fixed: an issue with displayin report date range
* Fixed: an issue with creating tables on fresh installs
* Updated: scheduling system
* Updated: the mainwp_client_reports_custom_tokens filter - added the $website parameter

= 2.1 - 5-12-2017 =
* Fixed: an issue with scheduling reports
* Fixed: an issue with syncing site on new installations
* Fixed: an issue with incorrect date range on scheduled reports
* Fixed: an issue with sending reports to BCC email address
* Fixed: multiple PHP warnings
* Fixed: an issue with saving reports
* Updated: report.daterange token to display only date
* Updated: various CSS improvements
* Updated: MainWP Child version requirement to 3.4
* Updated: MainWP Child Reports version requirement to 1.7

= 2.0.2 - 3-31-2017 =
* Fixed: an issue with saving reports caused by a database error
* Fixed: multiple typos
* Fixed: an issue with using the [report.daterange] token in the email subject field
* Added: a new [report.send.date] token

= 2.0.1 - 3-24-2017 =
* Fixed: an issue with saving reports caused by a database error
* Fixed: CSS conflict issue
* Updated: date format for Google Analytics data

= 2.0 - 3-9-2017 =
* Fixed: an issue with displaying client tokens
* Fixed: an issue with updating scheduled reports
* Fixed: an issue with displaying correct days in reports
* Fixed: an issue with un-checking the BCC option
* Fixed: multiple issues with sending email reports
* Fixed: an issue with updating and creating client tokens
* Fixed: an issue with moving the Client Tokens option box on the site Edit page
* Fixed: multiple PHP Warnings and Notices
* Added: support for the Wordfence tokens
* Added: support for the Maintenance tokens
* Added: support for the Page Speed tokens
* Added: support for the Broken Links tokens
* Added: the Insert Tokens menu in the content editors
* Added: the Insert Sections menu in the content editors
* Added: the BCC option for sending emails
* Added: new "MainWP Client Report" as default report
* Added: "MainWP Client Report" header, body and footer fragments in insert option
* Added: the "First Installation" column in the MainWP Child Reports Dashboard table
* Added: 'mainwp_client_reports_tokens_groups' hook to support custom tokens
* Added: 'mainwp_client_reports_tokens_nav_top' hook to allow custom tokens in token navigation
* Added: 'client_reports_custom_tokens' hook to support custom token values
* Added: the Help tab
* Added: new help documentation links
* Added: extension help tour
* Added: all formatting options to the report editor
* Updated: merged single site and global reports
* Updated: Select2 library implemented
* Updated: scheduling system has been refactored and moved to the Report Settings option box
* Updated: various CSS updates
* Updated: various Layout improvements
* Removed: default report HTML formatting
* Removed: redundant scheduling options
* Removed: client information prediction mechanism from the Report Settings option box
* Removed: Stream plugin references
* Removed: unnecessary tips

= 1.1 - 4-8-2016 =
* Fixed: Bug with saving report header and footer templates
* Fixed: Bug with saving report settings
* Fixed: Bug with displaying local time for Last Run and Next Run values

= 1.0 - 2-17-2016 =
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

= 0.1.2 - 8-3-2015 =
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
