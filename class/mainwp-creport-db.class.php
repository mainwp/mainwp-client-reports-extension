<?php
/** MainWP Client Reports Database class. */

/**
* Class MainWP_CReport_DB
*/
class MainWP_CReport_DB {

	/** @var string MainWP Client Reports DB version. */
	private $mainwp_wpcreport_db_version = '6.2';
  
	/** @var string Database table prefix. */
	private $table_prefix;
      
	/**
	* Public static variable to hold the single instance of the class.
	*
	* @var mixed Default null
	*/
	private static $instance = null;
      
	/** @var object Holds WordPress Database instance. */
	private $wpdb;

	/**
	* MainWP_CReport_DB constructor.
	*/
	function __construct() {
    
		/** @global object Holds WordPress Database instance. */
		global $wpdb;

		$this->table_prefix = $wpdb->prefix . 'mainwp_';
		$this->init_default_data();
		$this->wpdb = &$wpdb;
	}

	/**
	 * Get table name suffix.
	 *
	 * @param string $suffix Hold table name suffix.
	 *
	 * @return string Return table name suffix.
	 */
    function table_name( $suffix ) {
		return $this->table_prefix . $suffix;
	}

	/**
	* Support old & new versions of wordpress (3.9+).
	*
	* @return bool
	*/
	public static function use_mysqli() {
		
		if ( ! function_exists( 'mysqli_connect' ) ) {
			return false;
		}

		/** @global object $wpdb WordPress Database instance. */
		global $wpdb;
		return ( $wpdb->dbh instanceof mysqli );
	}

	// Installs new DB
	function install() {
    
		/** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		$currentVersion = get_site_option( 'mainwp_wpcreport_db_version' );

		if ( $currentVersion == $this->mainwp_wpcreport_db_version ) {
			return;
		}

		$charset_collate = $wpdb->get_charset_collate();
		$sql             = array();

		$rslt          = $this->query( "SHOW TABLES LIKE '" . $this->table_name( 'client_report_token' ) . "'" );
		$table_existed = ! empty( $rslt ) ? true : false;

		$tbl = 'CREATE TABLE `' . $this->table_name( 'client_report_token' ) . '` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`token_name` varchar(512) NOT NULL DEFAULT "",
`token_description` text NOT NULL,
`type` tinyint(1) NOT NULL DEFAULT 0';
		if ( '' == $currentVersion || ! $table_existed ) {
			$tbl .= ',
PRIMARY KEY  (`id`)  ';
		}

		$tbl  .= ') ' . $charset_collate;
		$sql[] = $tbl;

		$rslt          = $this->query( "SHOW TABLES LIKE '" . $this->table_name( 'client_report_site_token' ) . "'" );
		$table_existed = ! empty( $rslt ) ? true : false;

		$tbl = 'CREATE TABLE `' . $this->table_name( 'client_report_site_token' ) . '` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_url` varchar(255) NOT NULL,
`site_id` int(11) NOT NULL,
`token_id` int(12) NOT NULL,
`token_value` varchar(512) NOT NULL';
		if ( '' == $currentVersion || ! $table_existed ) {
			$tbl .= ',
PRIMARY KEY  (`id`)  ';
		}

		$tbl  .= ') ' . $charset_collate;
		$sql[] = $tbl;

		$rslt          = $this->query( "SHOW TABLES LIKE '" . $this->table_name( 'client_report' ) . "'" );
		$table_existed = ! empty( $rslt ) ? true : false;

		$tbl = 'CREATE TABLE `' . $this->table_name( 'client_report' ) . '` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` text NOT NULL,
`date_from` int(11) NOT NULL,
`date_to` int(11) NOT NULL,
`date_from_nextsend` int(11) NOT NULL,
`date_to_nextsend` int(11) NOT NULL,
`fname` VARCHAR(512),
`fcompany` VARCHAR(512),
`femail` VARCHAR(128),
`bcc_email` VARCHAR(128),
`client_id` int(11) NOT NULL,
`header` longtext NOT NULL,
`body` longtext NOT NULL,
`footer` longtext NOT NULL,
`attach_files` text NOT NULL,
`lastsend` int(11) NOT NULL,
`subject` text NOT NULL,
`recurring_schedule` VARCHAR(32) NOT NULL DEFAULT "",
`recurring_day` VARCHAR(10) DEFAULT NULL,
`schedule_send_email` VARCHAR(32) NOT NULL,
`schedule_bcc_me` tinyint(1) NOT NULL DEFAULT 0,
`scheduled` tinyint(1) NOT NULL DEFAULT 0,
`schedule_nextsend` int(11) NOT NULL,
`schedule_lastsend` int(11) NOT NULL,
`completed` int(11) NOT NULL,
`completed_sites` text NOT NULL,
`sending_errors` text NOT NULL,
`is_archived` tinyint(1) NOT NULL DEFAULT 0,
`sites` text NOT NULL,
`groups` text NOT NULL';

		if ( '' == $currentVersion || ! $table_existed ) {
			$tbl .= ',
PRIMARY KEY  (`id`)  ';
		}

		$tbl  .= ') ' . $charset_collate;
		$sql[] = $tbl;

		$rslt          = $this->query( "SHOW TABLES LIKE '" . $this->table_name( 'client_report_client' ) . "'" );
		$table_existed = ! empty( $rslt ) ? true : false;

		$tbl = 'CREATE TABLE `' . $this->table_name( 'client_report_client' ) . '` (
`clientid` int(11) NOT NULL AUTO_INCREMENT,
`client` text NOT NULL,
`name` VARCHAR(512),
`company` VARCHAR(512),
`email` text NOT NULL';
		if ( '' == $currentVersion || ! $table_existed ) {
			$tbl .= ',
PRIMARY KEY  (`clientid`)  ';
		}

		$tbl  .= ') ' . $charset_collate;
		$sql[] = $tbl;

		$rslt          = $this->query( "SHOW TABLES LIKE '" . $this->table_name( 'client_report_format' ) . "'" );
		$table_existed = ! empty( $rslt ) ? true : false;

		$tbl = 'CREATE TABLE `' . $this->table_name( 'client_report_format' ) . '` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` VARCHAR(512),
`content` longtext NOT NULL,
`type` CHAR(1)';
		if ( '' == $currentVersion || ! $table_existed ) {
			$tbl .= ',
PRIMARY KEY  (`id`)  ';
		}

		$tbl .= ') ' . $charset_collate;

		$sql[] = $tbl;

		$rslt          = $this->query( "SHOW TABLES LIKE '" . $this->table_name( 'client_group_report_content' ) . "'" );
		$table_existed = ! empty( $rslt ) ? true : false;

				$tbl = 'CREATE TABLE `' . $this->table_name( 'client_group_report_content' ) . '` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`report_id` int(11) NOT NULL,
`site_id` int(11) NOT NULL,
`report_content` longtext NOT NULL,
`report_content_pdf` longtext NOT NULL';
		if ( '' == $currentVersion || ! $table_existed ) {
			$tbl .= ',
PRIMARY KEY  (`id`)  ';
		}

		$tbl .= ') ' . $charset_collate;

		$sql[] = $tbl;

        // make sure to disable any error output.
		error_reporting( 0 );

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		foreach ( $sql as $query ) {
			dbDelta( $query );
		}

		// create default client.
		$client_tokens = $this->get_client_by( 'email', '[client.email]' );
		if ( empty( $client_tokens ) ) {
			$update_client = array(
				'client'  => '[client.name]',
				'name'    => '[client.name]',
				'company' => '[client.company]	',
				'email'   => '[client.email]',
			);
      
      // create client with tokens
			$this->update_client( $update_client );
		}

		// create or update default token.
		foreach ( $this->default_tokens as $token_name => $token_description ) {
			$token = array(
				'type'              => 1,
				'token_name'        => $token_name,
				'token_description' => $token_description,
			);
			if ( $current = $this->get_tokens_by( 'token_name', $token_name ) ) {
				$this->update_token( $current->id, $token );
			} else {
				$this->add_token( $token );
			}
		}
    
		// Create or update default reports.
		foreach ( $this->default_reports as $report ) {
			// update values
			$report['client']  = '[client.name]';
			$report['name']    = '[client.name]';
			$report['company'] = '[client.company]';
			$report['email']   = '[client.email]';
			if ( $current = $this->get_report_by( 'title', $report['title'] ) ) {
				$current               = current( $current );
				$report['id']          = $current->id;
				$report['is_archived'] = 0;
				$this->update_report( $report );
			} else {
				$this->update_report( $report );
			}
		}

		// create or update default format.
		foreach ( $this->default_formats as $format ) {
			if ( $current = $this->get_format_by( 'title', $format['title'], $format['type'] ) ) {
				$format['id'] = $current->id;
				$this->update_format( $format );
			} else {
				$this->update_format( $format );
			}
		}

		update_option( 'mainwp_wpcreport_db_version', $this->mainwp_wpcreport_db_version );

		$this->check_update( $currentVersion );

	}

	/**
	* Create a public static instance of MainWP_CReport_DB.
	*
	* @return MainWP_CReport_DB|null
	*/
	static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new MainWP_CReport_DB();

		}
		return self::$instance;
	}

	/**
	* Check extension version.
	*
	* @param string $check_version Extension version.
	*/
	function check_update( $check_version ) {
  
        /** @global object $wpdb WordPress Database instance. */
        global $wpdb;

		if ( empty( $check_version ) ) {
			return;
		}

		if ( version_compare( $check_version, '6.2' ) < 0 ) {
			$tokens = $wpdb->get_results( ' SELECT st.* FROM ' . $this->table_name( 'client_report_site_token' ) . ' st WHERE 1 = 1 ' );
			foreach ( $tokens as $item ) {
				$site_url = $item->site_url;
				$website  = apply_filters( 'mainwp_getwebsitesbyurl', $site_url );
				if ( $website ) {
					$website = current( $website );
					$sql     = 'UPDATE ' . $this->table_name( 'client_report_site_token' ) . '
								SET site_id = ' . $this->escape( $website->id ) . ' 
								WHERE id = ' . $item->id;
					$wpdb->query( $sql );
				}
			}
		}

	}
      
	/**
	* Initiate default data.
	*/
	public function init_default_data() {

		$this->default_tokens = array(
			'client.site.name'         => 'Displays the Site Name',
			'client.site.url'          => 'Displays the Site Url',
			'client.name'              => 'Displays the Client Name',
			'client.contact.name'      => 'Displays the Client Contact Name',
			'client.contact.address.1' => 'Displays the Client Contact Address 1',
			'client.contact.address.2' => 'Displays the Client Contact Address 2',
			'client.company'           => 'Displays the Client Company',
			'client.city'              => 'Displays the Client City',
			'client.state'             => 'Displays the Client State',
			'client.zip'               => 'Displays the Client Zip',
			'client.phone'             => 'Displays the Client Phone',
			'client.email'             => 'Displays the Client Email',
		);

		$header_img = plugins_url( 'images/templateMWP.jpg', dirname( __FILE__ ) );
		$analytics_img  = plugins_url( 'images/Analytics.jpg', dirname( __FILE__ ) );
		$backups_img    = plugins_url( 'images/Backups.jpg', dirname( __FILE__ ) );
		$security_img   = plugins_url( 'images/Security.jpg', dirname( __FILE__ ) );
		$uptime_img     = plugins_url( 'images/UPtime.jpg', dirname( __FILE__ ) );
		$updates_img    = plugins_url( 'images/Updates.jpg', dirname( __FILE__ ) );

		$this->default_reports[] = array(
			'title'  => 'MainWP Report (Basic)',
			'header' => '<div id="report-header" style="width: 600px; margin-left: auto; margin-right: auto;">
<img class="aligncenter wp-image-24" src="' . $header_img . '" alt="templatemwp" width="600" height="381" />
<p style="text-align: center; font-weight: 200; font-size: 2em; padding: 0px; margin: 0px;">Website Care Report</p>
<p style="text-align: center; font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px;"> [client.site.name]</p>
<p style="text-align: center; font-size: 1em; color: #000; font-weight: 200; padding: 0px; margin: 0px;">[report.daterange]</p>
</div>',
			'body'   => '<div id="report-body" style="width: 600px; margin-left: auto; margin-right: auto;">
<p style="page-break-before: always; text-align: left; font-weight: 200; font-size: 18px; padding: 0px; margin: 0px;">Dear [client.name]</p>
<p style="text-align: left; font-weight: 200; font-size: 1.2em; padding: 0px; margin: 0px;">Thank you for trusting your website to us.
We hope you find this report useful.
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p style="text-align: left; font-weight: 200; font-size: 1.2em; padding: 0px; margin: 0px;">Kind Regards
#Your Company#</p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Overview</p>
<p style="padding: 0px; margin: 0px; font-size: 1.5em;"><span style="color: #7fb100; font-size: 1em;">✔</span> Core Updates » <span style="color: #7fb100;">[wordpress.updated.count]</span></p>
<p style="padding: 0px; margin: 0px; font-size: 1.5em;"><span style="color: #7fb100; font-size: 1em;">✔</span> Backups » <span style="color: #7fb100;">[backup.created.count]</span></p>
<p style="page-break-before: always; font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;"><img class="aligncenter wp-image-17" src="' . $backups_img . '" alt="backups" width="600" height="211" /></p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Backups Completed</p>
<p style="font-size: 1.2em; color: #000; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">We have created [backup.created.count] backup(s) of your website during the report period and safely stored them away giving you peace of mind!</p>
[section.backups.created]
<span style="font-weight: 100; padding: 0px; margin: 0px; text-align: left;"> [backup.created.type] on [backup.created.date]</span>
[/section.backups.created]
<p style="page-break-before: always; font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;"><img class="aligncenter wp-image-20" src="' . $updates_img . '" alt="updates" width="600" height="212" /></p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Theme &amp; Plugin Updates</p>
<p style="font-size: 1.2em; color: #000; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">We have updated [plugin.updated.count] plugin(s) and [theme.updated.count] theme(s) ensuring your website says up to date &amp; secure.</p>
<p style="font-size: 1.2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Plugins</p>
[section.plugins.updated]
<span style="font-weight: 200;">[plugin.name] updated from [plugin.old.version] to [plugin.current.version]</span>
[/section.plugins.updated]
<p style="font-size: 1.2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Themes</p>
[section.themes.updated]
<span style="font-weight: 200;">[theme.name] updated from [theme.old.version] to [theme.current.version]</span>
[/section.themes.updated]

</div>',
			'footer' => '<p style="page-break-before: always;text-align: left; font-weight: 200; font-size: 1.2em; padding: 0px; margin: 0px;">Thank you for trusting your website to us.
We hope that this report was useful and we look forward to managing your website for another month.</p>
<p style="text-align: left; font-weight: 200; font-size: 1.2em; padding: 0px; margin: 0px;">Kind Regards
#Your Company#</p>',
		);

			$this->default_reports[] = array(
				'title'  => 'MainWP Report (Full)',
				'header' => '<div id="report-header" style="width: 600px; margin-left: auto; margin-right: auto;">
<img class="aligncenter wp-image-24" src="' . $header_img . '" alt="templatemwp" width="600" height="381" />
<p style="text-align: center; font-weight: 200; font-size: 2em; padding: 0px; margin: 0px;">Website Care Report</p>
<p style="text-align: center; font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px;"> [client.site.name]</p>
<p style="text-align: center; font-size: 1em; color: #000; font-weight: 200; padding: 0px; margin: 0px;">[report.daterange]</p>
</div>',
				'body'   => '<div id="report-body" style="width: 600px; margin-left: auto; margin-right: auto;">
<p style="page-break-before: always; text-align: left; font-weight: 200; font-size: 18px; padding: 0px; margin: 0px;">Dear [client.name]</p>
<p style="text-align: left; font-weight: 200; font-size: 1.2em; padding: 0px; margin: 0px;">Thank you for trusting your website to us.
We hope you find this report useful.
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<p style="text-align: left; font-weight: 200; font-size: 1.2em; padding: 0px; margin: 0px;">Kind Regards
#Your Company#</p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Overview</p>
<p style="padding: 0px; margin: 0px; font-size: 1.5em;"><span style="color: #7fb100; font-size: 1em;">✔</span> Core Updates » <span style="color: #7fb100;">[wordpress.updated.count]</span></p>
<p style="padding: 0px; margin: 0px; font-size: 1.5em;"><span style="color: #7fb100; font-size: 1em;">✔</span> Backups » <span style="color: #7fb100;">[backup.created.count]</span></p>
<p style="padding: 0px; margin: 0px; font-size: 1.5em;"><span style="color: #7fb100; font-size: 1em;">✔</span> Uptime » <span style="color: #7fb100;">[aum.uptime30]</span></p>
<p style="padding: 0px; margin: 0px; font-size: 1.5em;"><span style="color: #7fb100; font-size: 1em;">✔</span> Security Checks » <span style="color: #7fb100;">[sucuri.checks.count]</span></p>
<p style="page-break-before: always; font-size: 40px; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;"><img class="aligncenter wp-image-19" src="' . $analytics_img . '" alt="analytics" width="600" height="212" /></p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Google Analytics Statistics</p>
<span style="font-weight: 200;"> [ga.visits.chart]</span>
<span style="font-weight: 200;"> From [ga.startdate] to [ga.enddate]</span>
<span style="font-weight: 200;"> Visits to website: [ga.visits]</span>
<span style="font-weight: 200;"> Pageviews: [ga.pageviews]</span>

&nbsp;

&nbsp;
<p style="page-break-before: always; font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;"><img class="aligncenter wp-image-17" src="' . $backups_img . '" alt="backups" width="600" height="211" /></p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Backups Completed</p>
<p style="font-size: 1.2em; color: #000; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">We have created [backup.created.count] backup(s) of your website during the report period and safely stored them away giving you peace of mind!</p>
[section.backups.created]
<span style="font-weight: 100; padding: 0px; margin: 0px; text-align: left;"> [backup.created.type] on [backup.created.date]</span>
[/section.backups.created]

&nbsp;

&nbsp;
<p style="page-break-before: always; font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;"><img class="aligncenter wp-image-16" src="' . $security_img . '" alt="security" width="600" height="212" /></p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Security Checks Completed</p>
<p style="font-size: 1.2em; color: #000; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">We have scanned your website [sucuri.checks.count] time(s) to check for malicious software or malware ensuring your site stays in tip top condition.</p>
[section.sucuri.checks]
<span style="font-weight: 200;"> Status: [sucuri.check.status] | Webtrust: [sucuri.check.webtrust] on [sucuri.check.date]</span>
[/section.sucuri.checks]

&nbsp;

&nbsp;
<p style="page-break-before: always; font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;"><img class="aligncenter wp-image-18" src="' . $uptime_img . '" alt="uptime" width="600" height="211" /></p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Uptime</p>
<p style="font-size: 1.2em; color: #000; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">We check your website to make sure it is up &amp; running every 5 minutes. It can be offline for a number of reasons such as when we update &amp; test it or sometimes there may be a delay on the server - We are notified of all downtime and investigate to put this right.</p>
<span style="font-weight: 200;"> Overall uptime - [aum.alltimeuptimeratio]</span>
<span style="font-weight: 200;"> Last 30 days - [aum.uptime30]</span>

&nbsp;

&nbsp;
<p style="page-break-before: always; font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;"><img class="aligncenter wp-image-20" src="' . $updates_img . '" alt="updates" width="600" height="212" /></p>
<p style="font-size: 2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Theme &amp; Plugin Updates</p>
<p style="font-size: 1.2em; color: #000; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">We have updated [plugin.updated.count] plugin(s) and [theme.updated.count] theme(s) ensuring your website says up to date &amp; secure.</p>
<p style="font-size: 1.2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Plugins</p>
[section.plugins.updated]
<span style="font-weight: 200;">[plugin.name] updated from [plugin.old.version] to [plugin.current.version]</span>
[/section.plugins.updated]
<p style="font-size: 1.2em; color: #7fb100; font-weight: 200; padding: 0px; margin: 0px; text-align: left;">Themes</p>
[section.themes.updated]
<span style="font-weight: 200;">[theme.name] updated from [theme.old.version] to [theme.current.version]</span>
[/section.themes.updated]

</div>',
				'footer' => '<div id="report-footer" style="width: 600px; margin-left: auto; margin-right: auto;">
<p style="page-break-before: always; text-align: left; font-weight: 200; font-size: 1.2em; padding: 0px; margin: 0px;">Thank you for trusting your website to us.
We hope that this report was useful and we look forward to managing your website for another month.</p>
<p style="text-align: left; font-weight: 200; font-size: 1.2em; padding: 0px; margin: 0px;">Kind Regards
#Your Company#</p>

</div>',
			);

			$this->default_formats = array(
				array(
					'title'   => 'MainWP Report (Basic) Header',
					'type'    => 'H',
					'content' => $this->default_reports[0]['header'],
				),
				array(
					'title'   => 'MainWP Report (Basic)',
					'type'    => 'B',
					'content' => $this->default_reports[0]['body'],
				),
				array(
					'title'   => 'MainWP Report (Basic) Footer',
					'type'    => 'F',
					'content' => $this->default_reports[0]['footer'],
				),
				array(
					'title'   => 'MainWP Report (Full) Header',
					'type'    => 'H',
					'content' => $this->default_reports[1]['header'],
				),
				array(
					'title'   => 'MainWP Report (Full)',
					'type'    => 'B',
					'content' => $this->default_reports[1]['body'],
				),
				array(
					'title'   => 'MainWP Report (Full) Footer',
					'type'    => 'F',
					'content' => $this->default_reports[1]['footer'],
				),
			);

	}

    /**
     * Add Client Report Token.
     *
     * @param string $token Client report token.
     *
     * @return false|null Return FALSE on failure.
     */
    public function add_token( $token ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( ! empty( $token['token_name'] ) && ! empty( $token['token_description'] ) ) {
			if ( $current = $this->get_tokens_by( 'token_name', $token['token_name'] ) ) {
				return false; }
			if ( $wpdb->insert( $this->table_name( 'client_report_token' ), $token ) ) {
				return $this->get_tokens_by( 'id', $wpdb->insert_id );
			}
		}
		return false;
	}

    /**
     * Update Client Report Token.
     *
     * @param int $id Client Report ID.
     * @param string $token Client report token.
     * @return false|null Return FALSE on failure.
     */
    public function update_token( $id, $token ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( MainWP_CReport_Utility::ctype_digit( $id ) && ! empty( $token['token_name'] ) && ! empty( $token['token_description'] ) ) {
			if ( $wpdb->update( $this->table_name( 'client_report_token' ), $token, array( 'id' => intval( $id ) ) ) ) {
				return $this->get_tokens_by( 'id', $id );
			}
		}
		return false;
	}

	/**
	* Get client report token by 'token_name' or 'id'.
	*
	* @param string $by Get by 'token_name' or 'id'.
	* @param string $value Holds token value. Default: null.
	* @param string $site_url Child Site URL.
	*
	* @return string|null return Client report token or NULL on failure.
	*/
	public function get_tokens_by( $by = 'id', $value = null, $site_id = false ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $by ) || empty( $value ) ) {
			return null;
		}

		if ( 'token_name' == $by ) {
			$value = str_replace( array( '[', ']' ), '', $value );
		}

		$sql = '';

		if ( 'id' == $by ) {
			$sql = $wpdb->prepare( 'SELECT * FROM ' . $this->table_name( 'client_report_token' ) . ' WHERE `id`=%d ', $value );
		} elseif ( 'token_name' == $by ) {
			$sql = $wpdb->prepare( 'SELECT * FROM ' . $this->table_name( 'client_report_token' ) . " WHERE `token_name` = '%s' ", $value );
		}

		$token = null;
		if ( ! empty( $sql ) ) {
			$token = $wpdb->get_row( $sql );
		}

		if ( empty( $site_id ) ) {
			return $token;
		}

		if ( $token && ! empty( $site_id ) ) {
			$sql = 'SELECT * FROM ' .
					$this->table_name( 'client_report_site_token' ) . " 
					WHERE site_id = '" . $this->escape( $site_id ) . "' 
					AND token_id = " . $token->id;

			$site_token = $wpdb->get_row( $sql );
			if ( $site_token ) {
				$token->site_token = $site_token;
				return $token;
			} else {
				return null;
			}
		}

		return null;
	}

	/**
	 * Get client report tokens.
	 *
	 * @return mixed Return client report token.
	 */
	public function get_tokens() {

	    /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		return $wpdb->get_results( 'SELECT * FROM ' . $this->table_name( 'client_report_token' ) . ' WHERE 1 = 1 ORDER BY type DESC, token_name ASC' );
	}

	/**
	 * Get Child Site token values.
	 *
	 * @param int $id Child Site ID.
	 *
	 * @return string|false Return token or FALSE on failure.
	 */
    public function get_site_token_values( $id ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $id ) ) {
			return false; }
		$qry = ' SELECT st.* FROM ' . $this->table_name( 'client_report_site_token' ) . ' st ' .
				" WHERE st.token_id = '" . $id . "' ";
		return $wpdb->get_results( $qry );
	}

	/**
	* Get Child Site tokens.
	*
	* @param string $site_url Child Sit URL.
	* @param string $index DB index.
	*
	* @return array|false Return query results or FALSE on failure.
	*/
	public function get_site_tokens_by_site( $website ) {
    
        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $website ) || ! is_array( $website ) ) {
			return array();
		}

		$site_url  = $website['url'];
		$site_name = $website['name'];
		$site_id   = $website['id'];

		$default_tokens = array(
			'client.site.url'  => $site_url,
			'client.site.name' => $site_name,
		);

		$qry = ' SELECT st.*, t.token_name FROM ' .
					$this->table_name( 'client_report_site_token' ) . ' st , ' .
					$this->table_name( 'client_report_token' ) . ' t ' . " 
					WHERE ( st.site_url = '" . $site_url . "' OR st.site_id = '" . $site_id . "' )  
					AND st.token_id = t.id "; // st.site_url for compatible data.

		$site_tokens = $wpdb->get_results( $qry );

		$return = array();

		if ( is_array( $site_tokens ) ) {
			foreach ( $site_tokens as $token ) {
				$return[ $token->token_name ] = $token;
			}
		}

		// get default token value if empty.
		$tokens = $this->get_tokens();
		if ( is_array( $tokens ) ) {
			foreach ( $tokens as $token ) {
        
				// check default tokens if it is empty.
				if ( is_object( $token ) ) {
					if ( $token->type == 1 && ( ! isset( $return[ $token->token_name ] ) || empty( $return[ $token->token_name ] ) ) ) {
						if ( ! isset( $return[ $token->token_name ] ) ) {
							$return[ $token->token_name ] = new stdClass();
						}
						$return[ $token->token_name ]->token_value = isset( $default_tokens[ $token->token_name ] ) ? $default_tokens[ $token->token_name ] : '';
					}
				}
			}
		}

		return $return;
	}

	/**
	 * Get default site token.
	 *
	 * @param string $token_name Default token name.
	 * @param string $site_url Child Site URL.
	 *
	 * @return false|string Return defult token or FALSE on failure.
	 */
    public function _get_default_token_site($token_name, $site_url ) {
		$website = apply_filters( 'mainwp_getwebsitesbyurl', $site_url );
		if ( empty( $this->default_tokens[ $token_name ] ) || ! $website ) {
			return false;
		}
		$website = current( $website );
		if ( is_object( $website ) ) {
			$url_site  = $website->url;
			$name_site = $website->name;
		} else {
			return false;
		}

		switch ( $token_name ) {
			case 'client.site.url':
				$token_value = $url_site;
				break;
			case 'client.site.name':
				$token_value = $name_site;
				break;
			default:
				$token_value = '';
				break;
		}
		return $token_value;
	}

	/**
	* Add site token.
	*
	* @param $token_id Token ID.
	* @param $token_value Token value.
	* @param $site_url Child Site URL.
	*
	* @return false|null Return FALSE on failure.
	*/
	public function add_token_site( $token_id, $token_value, $site_id ) {
    
		/** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( $wpdb->insert(
			$this->table_name( 'client_report_site_token' ),
			array(
				'token_id'    => $token_id,
				'token_value' => $token_value,
				'site_id'     => $site_id,
			)
		) ) {
			return true;
		}

		return false;
	}

	/**
	* Update site token.
	*
	* @param int $token_id Token ID.
	* @param string $token_value Token value.
	* @param string $site_url Child Site URL.
	*
	* @return false|null Return FALSE on failure.
	*/
	public function update_token_site( $token_id, $token_value, $site_id ) {
    
		/** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		$sql = 'UPDATE ' . $this->table_name( 'client_report_site_token' ) .
				" SET token_value = '" . $this->escape( $token_value ) . "' " .
				' WHERE token_id = ' . intval( $token_id ) .
				" AND site_id = '" . $this->escape( $site_id ) . "'";

		// to fix empty data.
		$wpdb->query( 'DELETE FROM ' . $this->table_name( 'client_report_site_token' ) . ' WHERE site_id = 0 ' );

		if ( $wpdb->query( $sql ) ) {
			return true;
		}
		return false;
	}

	/**
	* Delete site tokens.
	*
	* @param int $token_id Token ID.
	* @param int $site_url Child Site URL.
	* @return false Return FALSE on failure.
	*/
	public function delete_site_tokens( $token_id = null, $site_id = null ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( ! empty( $token_id ) ) {
			return $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $this->table_name( 'client_report_site_token' ) . ' WHERE token_id = %d ', $token_id ) );
		} elseif ( ! empty( $site_id ) ) {
			return $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $this->table_name( 'client_report_site_token' ) . ' WHERE site_id = %s ', $site_id ) );
		}
		return false;
	}

	/**
	* Delete token by ID.
	*
	* @param string $by By ID.
	* @param string $value Token value.
	* @return bool Return TRUE|FALSE.
	*/
    public function delete_token_by($by = 'id', $value = null ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( 'id' == $by ) {
			if ( $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $this->table_name( 'client_report_token' ) . ' WHERE id=%d ', $value ) ) ) {
				$this->delete_site_tokens( $value );
				return true;
			}
		}
		return false;
	}

	/**
	* Update report.
	*
	* @param array $report Report array.
	*
	* @return false Return FALSE on failure.
	*/
    public function update_report($report ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		$id            = isset( $report['id'] ) ? $report['id'] : 0;
		$updatedClient = false;

		/**
		 * THIS IS SMART create or update client.
		 * client may be content tokens.
		 */
		if ( ! empty( $report['email'] ) ) { // client may be content tokens

				$update_client = array(
					'client'  => isset( $report['client'] ) ? $report['client'] : '',
					'name'    => isset( $report['name'] ) ? $report['name'] : '',
					'company' => isset( $report['company'] ) ? $report['company'] : '',
					'email'   => isset( $report['email'] ) ? $report['email'] : '',
				);

				$client_id = ( isset( $report['client_id'] ) && ! empty( $report['client_id'] ) ) ? intval( $report['client_id'] ) : 0;
				// update client.
				if ( $client_id ) {
					$client_tokens = $this->get_client_by( 'email', '[client.email]' );
					// check if trying update default client with tokens in email
					if ( $client_tokens && $client_tokens->clientid == $client_id ) {
						$client_id = 0; // do not override client with email is [client.email], new client will created below if needed
					} else {
						if ( $update_client['email'] == '[client.email]' ) {
							if ( $client_tokens ) {
								$client_id = $client_tokens->clientid; // do not override client with email is [client.email]
							} else {
								$client_id = 0; // to create new
							}
						} else {
							$existed_client = $this->get_client_by( 'email', $update_client['email'] );
							if ( $existed_client ) {
								$update_client['clientid'] = $client_id = $existed_client->clientid; // found the existed client
								$this->update_client( $update_client ); // update client info
							} else {
								$client_id = 0;
							}
						}
					}
				}

				// create new client.
				if ( empty( $client_id ) ) {
					// check client with tokens
					if ( $update_client['email'] == '[client.email]' ) {
						$client_tokens = $this->get_client_by( 'email', '[client.email]' );
						if ( $client_tokens ) {
							$client_id = $client_tokens->clientid; // do not override client with email is [client.email]
						}
					} elseif ( $updatedClient = $this->update_client( $update_client ) ) { // create new client
							$client_id = $updatedClient->clientid;
					}
				}

				$report['client_id'] = $client_id;
		} else {
			if ( isset( $report['client_id'] ) ) {
				$report['client_id'] = 0;
			}
		}

		$report_fields = array(
			'id',
			'title',
			'date_from',
			'date_to',
			'date_from_nextsend',
			'date_to_nextsend',
			'fname',
			'fcompany',
			'femail',
			'bcc_email',
			'client_id',
			'header',
			'body',
			'footer',
			'logo_file',
			'lastsend',
			'subject',
			'recurring_schedule',
			'recurring_day',
			'schedule_send_email',
			'schedule_bcc_me',
			'is_archived',
			'attach_files',
			'scheduled',
			'schedule_lastsend',
			'schedule_nextsend',
			'sites',
			'groups',
			'completed',
			'completed_sites',
		);

		$update_report = array();
		foreach ( $report as $key => $value ) {
			if ( in_array( $key, $report_fields ) ) {
				$update_report[ $key ] = $value;
			}
		}

		if ( ! empty( $id ) ) {
			$wpdb->update( $this->table_name( 'client_report' ), $update_report, array( 'id' => intval( $id ) ) );
		} else {
			if ( ! isset( $update_report['title'] ) || empty( $update_report['title'] ) ) {
				return false;
			}
			if ( $wpdb->insert( $this->table_name( 'client_report' ), $update_report ) ) {
				 $id = $wpdb->insert_id;
			}
		}

		if ( $id ) {
			return $this->get_report_by( 'id', $id );
		} else {
			return false;
		}

	}

	/**
	* Udate group report content.
	*
	* @param array $report Report array.
	*
	* @return false Return FALSE on failure.
	*/
	public function update_group_report_content( $report ) {
    
		/** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		$report_id = isset( $report['report_id'] ) ? $report['report_id'] : 0;
		$site_id   = isset( $report['site_id'] ) ? $report['site_id'] : 0;

		if ( empty( $report_id ) && empty( $site_id ) ) {
			return false;
		}

		$current = $this->get_group_report_content( $report_id, $site_id );
		if ( $current ) {
			$wpdb->update( $this->table_name( 'client_group_report_content' ), $report, array( 'id' => intval( $current->id ) ) );
			return $this->get_group_report_content( $report_id, $site_id );
		} else {
			return $wpdb->insert( $this->table_name( 'client_group_report_content' ), $report );
		}

		return false;
	}

	/**
	* Get group report content.
	*
	* @param int $report_id Report ID.
	* @param int $site_id Child Site ID.
	*
	* @return false Return FALSE on failure.
	*/
	public function get_group_report_content( $report_id, $site_id = null ) {
    
        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $report_id ) ) {
			return false;
		}

		if ( ! empty( $site_id ) ) {
			$sql = $wpdb->prepare(
				'SELECT * FROM ' . $this->table_name( 'client_group_report_content' )
					. ' WHERE `report_id` = %d AND `site_id` = %d ',
				$report_id,
				$site_id
			);
			return $wpdb->get_row( $sql );
		} else {
			$sql = $wpdb->prepare(
				'SELECT * FROM ' . $this->table_name( 'client_group_report_content' )
					. ' WHERE `report_id` = %d ',
				$report_id
			);
			return $wpdb->get_results( $sql );
		}

	}

	/**
	* Delete group report content.
	*
	* @param int $report_id Report ID.
	* @param int $site_id Child Site ID.
	*
	* @return mixed Return query results.
	*/
	public function delete_group_report_content( $report_id = null, $site_id = null ) {
  
        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;
  
		if ( ! empty( $report_id ) && ! empty( $site_id ) ) {
			$sql = $wpdb->prepare(
				'DELETE FROM ' . $this->table_name( 'client_group_report_content' )
					. ' WHERE `report_id` = %d AND `site_id` = %d ',
				$report_id,
				$site_id
			);
			return $wpdb->get_row( $sql );
		} elseif ( ! empty( $report_id ) ) {
			$sql = $wpdb->prepare(
				'DELETE FROM ' . $this->table_name( 'client_group_report_content' )
					. ' WHERE `report_id` = %d ',
				$report_id
			);
			return $wpdb->get_results( $sql );
		} elseif ( ! empty( $site_id ) ) {
			$sql = $wpdb->prepare(
				'DELETE FROM ' . $this->table_name( 'client_group_report_content' )
					. ' WHERE `site_id` = %d ',
				$site_id
			);
			return $wpdb->get_results( $sql );
		}
	}

    /**
     * Get report by.
     *
     * @param string $by Get by id, client, site_id or title. Default: id.
     * @param string $value If not empty then checking by value.
     * @param string $orderby Order by client, name, ORDER BY.
     * @param string $order Default order.
     * @param string $output Query output type.
     *
     * @return array|false Return Client report or FALSE on failure.
     */
    public function get_report_by( $by = 'id', $value = null, $orderby = null, $order = null, $output = OBJECT ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $by ) || ( 'all' !== $by && empty( $value ) ) ) {
			return false; }

		$_order_by = '';
		if ( ! empty( $orderby ) ) {
			if ( 'client' === $orderby || 'name' === $orderby ) {
				$orderby = 'c.' . $orderby;
			} else {
				$orderby = 'rp.' . $orderby;
			}
			$_order_by = ' ORDER BY ' . $orderby;
			if ( ! empty( $order ) ) {
				$_order_by .= ' ' . $order; }
		}

		$sql = '';
		if ( 'id' == $by ) {
			$sql = $wpdb->prepare(
				'SELECT rp.*, c.* FROM ' . $this->table_name( 'client_report' ) . ' rp '
				. ' LEFT JOIN ' . $this->table_name( 'client_report_client' ) . ' c '
				. ' ON rp.client_id = c.clientid '
				. ' WHERE `id`=%d ' . $_order_by,
				$value
			);
		} elseif ( 'client' == $by ) {
			$sql = $wpdb->prepare(
				'SELECT rp.*, c.* FROM ' . $this->table_name( 'client_report' ) . ' rp '
				. ' LEFT JOIN ' . $this->table_name( 'client_report_client' ) . ' c '
				. ' ON rp.client_id = c.clientid '
				. ' WHERE `client_id` = %d ' . $_order_by,
				$value
			);
			return $wpdb->get_results( $sql, $output );
		} elseif ( 'site_id' == $by ) {

			$sql_all        = 'SELECT * FROM ' . $this->table_name( 'client_report' ) . ' WHERE 1 = 1 ';
			$all_reports    = $wpdb->get_results( $sql_all );

			$sql_report_ids = array( -1 );

			foreach ( $all_reports as $report ) {
				if ( $report->sites != '' || $report->groups != '' ) {

					$sites = unserialize( base64_decode( $report->sites ) );
					if ( ! is_array( $sites ) ) {
						$sites = array();
					}

					if ( in_array( $value, $sites ) ) {
						if ( ! in_array( $report->id, $sql_report_ids ) ) {
							$sql_report_ids[] = $report->id;
						}
					} elseif ( $report->groups != '' ) {
						$groups = unserialize( base64_decode( $report->groups ) );
						if ( ! is_array( $groups ) ) {
							$groups = array();
						}

						/**
						 * MainWP CReport Extension Activator instance.
						 *
						 * @global object $mainWPCReportExtensionActivator
						 */
						global $mainWPCReportExtensionActivator;
            
						$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), array(), $groups );

						foreach ( $dbwebsites as $pSite ) {
							if ( $pSite->id == $value ) {
								if ( ! in_array( $report->id, $sql_report_ids ) ) {
									$sql_report_ids[] = $report->id;
								}
								break;
							}
						}
					}
				}
			}

						$sql_report_ids = implode( ',', $sql_report_ids );

						$sql = 'SELECT rp.*, c.* FROM ' . $this->table_name( 'client_report' ) . ' rp '
				. ' LEFT JOIN ' . $this->table_name( 'client_report_client' ) . ' c '
				. ' ON rp.client_id = c.clientid '
			. ' WHERE rp.id IN (' . $sql_report_ids . ') ' . $_order_by;

			return $wpdb->get_results( $sql, $output );

		} elseif ( 'title' == $by ) {
			$sql = $wpdb->prepare(
				'SELECT rp.*, c.* FROM ' . $this->table_name( 'client_report' ) . ' rp '
				. ' LEFT JOIN ' . $this->table_name( 'client_report_client' ) . ' c '
				. ' ON rp.client_id = c.clientid '
				. ' WHERE `title` = %s ' . $_order_by,
				$value
			);
			return $wpdb->get_results( $sql, $output );
		} elseif ( 'all' == $by ) {
			$sql = 'SELECT * FROM ' . $this->table_name( 'client_report' ) . ' rp '
					. 'LEFT JOIN ' . $this->table_name( 'client_report_client' ) . ' c '
					. ' ON rp.client_id = c.clientid '
					. ' WHERE 1 = 1 ' . $_order_by;
			return $wpdb->get_results( $sql, $output );
		}

		// echo $sql;

		if ( ! empty( $sql ) ) {
					return $wpdb->get_row( $sql, $output ); }

		return false;
	}

	/**
	 * Check if Child Site has report.
	 *
	 * @param int $site_id Child Site ID.
	 *
	 * @return bool Return TRUE|FALSE.
	 */
	public function checked_if_site_have_report( $site_id ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $site_id ) ) {
			return false;
		}

		$sql_all        = 'SELECT * FROM ' . $this->table_name( 'client_report' ) . ' WHERE 1 = 1 ';
		$all_reports    = $wpdb->get_results( $sql_all );
		$sql_report_ids = array();

		$found = false;
		if ( is_array( $all_reports ) && count( $all_reports ) > 0 ) {
			foreach ( $all_reports as $report ) {
				if ( $report->sites != '' || $report->groups != '' ) {

					$sites = unserialize( base64_decode( $report->sites ) );
					if ( ! is_array( $sites ) ) {
						$sites = array();
					}

					if ( in_array( $site_id, $sites ) ) {
						if ( ! in_array( $report->id, $sql_report_ids ) ) {
							$found = true;
							break;
						}
					} elseif ( $report->groups != '' ) {
						$groups = unserialize( base64_decode( $report->groups ) );
						if ( ! is_array( $groups ) ) {
							$groups = array();
						}

						/**
						 * MainWP CReport Extension Activator instance.
						 *
						 * @global object $mainWPCReportExtensionActivator
						 */
						global $mainWPCReportExtensionActivator;

						$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), array(), $groups );

						foreach ( $dbwebsites as $pSite ) {
							if ( $pSite->id == $site_id ) {
								 $found = true;
								 break;
							}
						}
					}

					if ( $found ) {
						break;
					}
				}
			}
		}

		return $found;
	}

	/**
	 * Update Website Option.
	 *
	 * @param int $website_id Child Site ID.
	 * @param string $option Website option.
	 * @param string $value Option value.
	 */
	public function updateWebsiteOption( $website_id, $option, $value ) {

		$rslt = $this->wpdb->get_results( 'SELECT name FROM ' . $this->table_name( 'wp_options' ) . ' WHERE wpid = ' . $website_id . ' AND name = "' . $this->escape( $option ) . '"' );
		if ( count( $rslt ) > 0 ) {
			$this->wpdb->delete(
				$this->table_name( 'wp_options' ),
				array(
					'wpid' => $website_id,
					'name' => $this->escape( $option ),
				)
			);
			$rslt = $this->wpdb->get_results( 'SELECT name FROM ' . $this->table_name( 'wp_options' ) . ' WHERE wpid = ' . $website_id . ' AND name = "' . $this->escape( $option ) . '"' );
		}

		if ( count( $rslt ) == 0 ) {
			$this->wpdb->insert(
				$this->table_name( 'wp_options' ),
				array(
					'wpid'  => $website_id,
					'name'  => $option,
					'value' => $value,
				)
			);
		} else {
			$this->wpdb->update(
				$this->table_name( 'wp_options' ),
				array( 'value' => $value ),
				array(
					'wpid' => $website_id,
					'name' => $option,
				)
			);
		}
	}

	/**
	 * Get Website value.
	 *
	 * @param array $website Child Site array.
	 * @param $option Wbsit option.
	 *
	 * @return mixed Return website value.
	 */
	public function getWebsiteOption( $website, $option ) {

		if ( property_exists( $website, $option ) ) {
			return $website->{$option};
		}

		return $this->wpdb->get_var( 'SELECT value FROM ' . $this->table_name( 'wp_options' ) . ' WHERE wpid = ' . $website->id . ' AND name = "' . $this->escape( $option ) . '"' );
	}

	/**
	 * Get Child Site wp_options.
	 *
	 * @param array $websiteIds Child site IDs.
	 * @param string $option Option to get.
	 *
	 * @return array Return array of options.
	 */
	public function getOptionOfWebsites( $websiteIds, $option ) {
		if ( ! is_array( $websiteIds ) || count( $websiteIds ) == 0 ) {
			return array();
		}
		return $this->wpdb->get_results( 'SELECT wpid, value FROM ' . $this->table_name( 'wp_options' ) . ' WHERE wpid IN (' . implode( ',', $websiteIds ) . ') AND name = "' . $this->escape( $option ) . '"' );
	}
	/**
	 * Get Child Site wp_options.
	 *
	 * @param array $websiteIds Child site IDs.
	 * @param string $option Option to get.
	 *
	 * @return array Return array of options.
	 */
	public function get_scheduled_reports_to_send( $timestamp_offset ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		 /**
		 * For testing, to force the schedule reports start run.
		 * Reset values: `schedule_nextsend`, `schedule_lastsend` and option 'mainwp_creport_sendcheck_last',
		 * to corresponding values ( values one day ago, for example )
		 * cron job will update 'schedule_lastsend' to current time, and 'completed_sites' to empty array().
		 *
		 */
		$sql = 'SELECT rp.*, c.* FROM ' . $this->table_name( 'client_report' ) . ' rp '
				. ' LEFT JOIN ' . $this->table_name( 'client_report_client' ) . ' c '
				. ' ON rp.client_id = c.clientid '
				. " WHERE rp.recurring_schedule != '' AND rp.scheduled = 1 "
				. ' AND rp.schedule_nextsend < ' . ( time() + $timestamp_offset ); // this conditional to check time to send scheduled reports,  support send report at local time.
		return $wpdb->get_results( $sql );
	}

	/**
	 * Get scheduled reports to continue to send.
	 *
	 * @param int $limit Interval limit.
	 *
	 * @return mixed Return query results.
	 */
	public function get_scheduled_reports_to_continue_send( $limit = 1 ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		$sql = 'SELECT rp.*, c.* FROM ' . $this->table_name( 'client_report' ) . ' rp '
				. ' LEFT JOIN ' . $this->table_name( 'client_report_client' ) . ' c '
				. ' ON rp.client_id = c.clientid '
				. " WHERE rp.recurring_schedule != '' AND rp.scheduled = 1 "
				. ' AND rp.completed < rp.schedule_lastsend LIMIT 0, ' . intval( $limit ); // do not send if completed > schedule_lastsend
		// echo $sql;

		return $wpdb->get_results( $sql );
	}

    /**
     * Get completed sites.
     *
     * @param int $id Client report ID.
     *
     * @return array|mixed Return completed sites.
     */
    public function get_completed_sites( $id ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $id ) ) {
			return array();
		}

		$qry = ' SELECT completed_sites FROM ' . $this->table_name( 'client_report' ) . ' WHERE id = ' . intval( $id ) . ' ';

		$com_sites = $wpdb->get_var( $qry );

		if ( $com_sites != '' ) {
			$com_sites = json_decode( $com_sites, true );
		}
		if ( ! is_array( $com_sites ) ) {
			$com_sites = array();
		}
		return $com_sites;
	}

	/**
	 * Update report with values.
	 *
	 * @param int $id Client report ID.
	 * @param array $values Array of values to update.
	 *
	 * @return false Return FALSE on failure.
	 */
	public function update_reports_with_values( $id, $values ) {

		if ( ! is_array( $values ) ) {
			return false;
		}

        /** @global object $wpdb WordPress Database instance. */
        global $wpdb;
    
		return $wpdb->update( $this->table_name( 'client_report' ), $values, array( 'id' => $id ) );
	}

	/**
	 * Update reports last sent.
	 *
	 * @param $id Client report ID.
	 *
	 * @return false Return FALSE on failure.
	 */
	public function update_reports_send( $id ) {
  
        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		return $wpdb->update(
			$this->table_name( 'client_report' ),
			array(
				'schedule_lastsend' => time(),
				'completed_sites'   => json_encode( array() ),
			),
			array( 'id' => $id )
		);
		return false;
	}

	/**
	* Update reports completed.
	*
	* @param $id Client Reports ID.
	*
	* @return mixed Return query results.
	*/
	public function update_reports_completed( $id ) {
  
		/** @global object $wpdb WordPress Database instance. */
		global $wpdb;
		return $wpdb->update( $this->table_name( 'client_report' ), array( 'completed' => time() ), array( 'id' => $id ) );
	}
      
	/**
	 * Update reports completed sites.
	 *
	 * @param int $id Client reports ID.
	 * @param array $pCompletedSites Completed sites array.
	 *
	 * @return mixed Return query results.
	 */
	public function update_reports_completed_sites( $id, $pCompletedSites ) {
    
        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		return $wpdb->update( $this->table_name( 'client_report' ), array( 'completed_sites' => json_encode( $pCompletedSites ) ), array( 'id' => $id ) );

	}

    /**
     * Delete report by ID.
     *
     * @param string $by Delete by ID.
     * @param int $report_id Client report ID.
     * @return bool Return TRUE|FALSE.
     */
    public function delete_report_by( $by = 'id', $report_id = null ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( 'id' == $by ) {
			if ( $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $this->table_name( 'client_report' ) . ' WHERE id=%d ', $report_id ) ) ) {
								$this->delete_group_report_content( $report_id );
				return true;
			}
		}
		return false;
	}

    /**
     * Get list of clients.
     *
     * @return mixed Return list ordered by clients.
     */
    public function get_clients() {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		return $wpdb->get_results( 'SELECT * FROM ' . $this->table_name( 'client_report_client' ) . ' WHERE 1 = 1 ORDER BY client ASC' );
	}

    /**
     * Get client by clientid, client, email.
     *
     * @param string $by By clientid, client, email.
     * @param string $value Holds return value.
     *
     * @return false Return query or FALSE if empty.
     */
    public function get_client_by( $by = 'clientid', $value = null ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $value ) ) {
			return false; }

		$sql = '';
		if ( 'clientid' == $by ) {
			$sql = $wpdb->prepare(
				'SELECT * FROM ' . $this->table_name( 'client_report_client' )
				. ' WHERE `clientid` =%d ',
				$value
			);
		} elseif ( 'client' == $by ) {
			$sql = $wpdb->prepare(
				'SELECT * FROM ' . $this->table_name( 'client_report_client' )
				. ' WHERE `client` = %s ',
				$value
			);
		} elseif ( 'email' == $by ) {
			$sql = $wpdb->prepare(
				'SELECT * FROM ' . $this->table_name( 'client_report_client' )
				. ' WHERE `email` = %s ',
				$value
			);
		}

		if ( ! empty( $sql ) ) {
			return $wpdb->get_row( $sql ); }

		return false;
	}

    /**
     * Update Client.
     *
     * @param array $client Client array.
     *
     * @return false Return FASLE on failure.
     */
    public function update_client( $client ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		$id = isset( $client['clientid'] ) ? $client['clientid'] : 0;

		if ( ! empty( $id ) ) {
			if ( $wpdb->update( $this->table_name( 'client_report_client' ), $client, array( 'clientid' => intval( $id ) ) ) ) {
				return $this->get_client_by( 'clientid', $id );
			}
		} else {
			if ( $wpdb->insert( $this->table_name( 'client_report_client' ), $client ) ) {
				// echo $wpdb->last_error;
				return $this->get_client_by( 'clientid', $wpdb->insert_id );
			}
			// echo $wpdb->last_error;
		}
		return false;
	}

    /**
     * Delete client.
     *
     * @param int $by By client ID.
     * @param string $value Value to delete.
     *
     * @return bool TRUE|FALSE.
     */
    public function delete_client( $by, $value ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( 'clientid' == $by ) {
			if ( $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $this->table_name( 'client_report_client' ) . ' WHERE clientid=%d ', $value ) ) ) {
				return true;
			}
		}
		return false;
	}

    /**
     * Get report format.
     *
     * @param null $type Reprot type.
     *
     * @return mixed Return query result.
     */
    public function get_formats( $type = null ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		return $wpdb->get_results( 'SELECT * FROM ' . $this->table_name( 'client_report_format' ) . " WHERE type = '" . $type . "' ORDER BY title" );
	}

    /**
     * Get format by id or title.
     *
     * @param mixed $by Get by id or title.
     * @param string $value Format value.
     * @param string $type Reort type.
     *
     * @return false Return FALSE on failure.
     */
    public function get_format_by( $by, $value, $type = null ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( empty( $value ) ) {
			return false; }
		$sql = '';
		if ( 'id' == $by ) {
			$sql = $wpdb->prepare(
				'SELECT * FROM ' . $this->table_name( 'client_report_format' )
				. ' WHERE `id` =%d ',
				$value
			);
		} elseif ( 'title' == $by ) {
			$sql = $wpdb->prepare(
				'SELECT * FROM ' . $this->table_name( 'client_report_format' )
				. ' WHERE `title` =%s AND type = %s',
				$value,
				$type
			);
		}
		// echo $sql;
		if ( ! empty( $sql ) ) {
			return $wpdb->get_row( $sql ); }
		return false;
	}

    /**
     * Update format.
     *
     * @param array $format Report format.
     *
     * @return false Return FALSE on failure.
     */
    public function update_format( $format ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		$id = isset( $format['id'] ) ? $format['id'] : 0;

		if ( ! empty( $id ) ) {
			if ( $wpdb->update( $this->table_name( 'client_report_format' ), $format, array( 'id' => intval( $id ) ) ) ) {
				return $this->get_format_by( 'id', $id ); }
		} else {
			if ( $wpdb->insert( $this->table_name( 'client_report_format' ), $format ) ) {
				// echo $wpdb->last_error;
				return $this->get_format_by( 'id', $wpdb->insert_id );
			}
			// echo $wpdb->last_error;
		}
		return false;
	}

    /**
     * Delete format by id.
     * @param string $by Delete by ID.
     * @param null $value optional argument.
     * @return bool Return TRUE|FALSE.
     */
    public function delete_format_by( $by = 'id', $value = null ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( 'id' == $by ) {
			if ( $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $this->table_name( 'client_report_format' ) . ' WHERE id=%d ', $value ) ) ) {
				return true;
			}
		}
		return false;
	}

    /**
     * Escape data.
     *
     * @param string $data Data to escape.
     *
     * @return string Return escaped data.
     */
    protected function escape( $data ) {

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		if ( function_exists( 'esc_sql' ) ) {
			return esc_sql( $data );
		} else {
			return $wpdb->escape( $data );
		}
	}

    /**
     * Database query.
     *
     * @param string $sql SQL Query.
     *
     * @return bool|resource|mysqli_result Return FALSE on failure, or Resource & mysqli_result object on success.
     */
    public function query( $sql ) {
		if ( null == $sql ) {
			return false; }

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		$result = @self::_query( $sql, $wpdb->dbh );

		if ( ! $result || ( @self::num_rows( $result ) == 0 ) ) {
			return false;
		}
		return $result;
	}

    /**
     * MySQLi Query.
     *
     * @param string $query Query string.
     * @param string $link Query link.
     *
     * @return bool|mysqli_result|resource Return mysql query results or FALSE on failure.
     */
    public static function _query( $query, $link ) {
		if ( self::use_mysqli() ) {
			return mysqli_query( $link, $query );
		} else {
			return mysql_query( $query, $link );
		}
	}

    /**
     * Fetch object.
     *
     * @param string $result Holds query results.
     *
     * @return object|stdClass|null Return object, stdClass or NULL on failure.
     */
    public static function fetch_object($result ) {
		if ( self::use_mysqli() ) {
			return mysqli_fetch_object( $result );
		} else {
			return mysql_fetch_object( $result );
		}
	}

    /**
     * Free up query results.
     *
     * @param $result Holds query result.
     *
     * @return bool|void Return mysqli results or FALSE on failure.
     */
    public static function free_result( $result ) {
		if ( self::use_mysqli() ) {
			return mysqli_free_result( $result );
		} else {
			return mysql_free_result( $result );
		}
	}

    /**
     * Mysqli data seek.
     *
     * @param $result Holds query result.
     * @param $offset Query offset.
     *
     * @return bool Return TRUE|FALSE.
     */
    public static function data_seek( $result, $offset ) {
		if ( self::use_mysqli() ) {
			return mysqli_data_seek( $result, $offset );
		} else {
			return mysql_data_seek( $result, $offset );
		}
	}

    /**
     * Fetch array.
     *
     * @param string $result Holds query result.
     * @param null $result_type Result type.
     *
     * @return array|false|null Return query result or FALSE on failure.
     */
    public static function fetch_array( $result, $result_type = null ) {
		if ( self::use_mysqli() ) {
			return mysqli_fetch_array( $result, ( null == $result_type ? MYSQLI_BOTH : $result_type ) );
		} else {
			return mysql_fetch_array( $result, ( null == $result_type ? MYSQL_BOTH : $result_type ) );
		}
	}

    /**
     * Count rows.
     *
     * @param int $result Query result.
     *
     * @return false|int Return number of rows of FALSE on failure.
     */
    public static function num_rows( $result ) {
		if ( self::use_mysqli() ) {
			return mysqli_num_rows( $result );
		} else {
			return mysql_num_rows( $result );
		}
	}

    /**
     * Check if there is a query result.
     *
     * @param string $result Holds query result.
     *
     * @return bool Return TRUE|FALSE.
     */
    public static function is_result( $result ) {
		if ( self::use_mysqli() ) {
			return ( $result instanceof mysqli_result );
		} else {
			return is_resource( $result );
		}
	}

    /**
     * Get myslq query results result.
     *
     * @param string $sql Query string.
     *
     * @return string|null Return query result or NULL on failure.
     */
    public function get_results_result( $sql ) {
		if ( null == $sql ) {
			return null; }

        /** @global object $wpdb WordPress Database instance. */
		global $wpdb;

		return $wpdb->get_results( $sql, OBJECT_K );
	}
}
