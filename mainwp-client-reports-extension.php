<?php
/** MainWP Client Reports Extension */

/*
  Plugin Name: MainWP Client Reports Extension
  Plugin URI: https://mainwp.com
  Description: MainWP Client Reports Extension allows you to generate activity reports for your clients sites. Requires MainWP Dashboard.
  Version: 4.0.5.1
  Author: MainWP
  Author URI: https://mainwp.com
  Documentation URI: https://mainwp.com/help/docs/category/mainwp-extensions/client-reports/
 */

if ( ! defined( 'MAINWP_CLIENT_REPORTS_PLUGIN_FILE' ) ) {

    /**
     * Define MAINWP_CLIENT_REPORTS_PLUGIN_FILE with MainWP client reports extension.
     */
    define( 'MAINWP_CLIENT_REPORTS_PLUGIN_FILE', __FILE__ );
}

/**
 * Class MainWP_CReport_Extension
 */
class MainWP_CReport_Extension {

    /**
     * Method instance()
     *
     * Create a public static instance.
     *
     * @return mixed Class instance.
     */
    public static $instance = null;

    /** @var string Hold the extension handle. */
    public $plugin_handle = 'mainwp-wpcreport-extension';

    /** @var string Hold the entension URL. */
    public static $plugin_url;

    /** @var string Holds the extension's slug. */
    public $plugin_slug;

    /** @var string Hold the extension's directory location. */
    public $plugin_dir;

    /** @var string Hold extension option. */
    protected $option;

    /** @var string Holds option handle. */
    protected $option_handle = 'mainwp_wpcreport_extension';

    /** @var string Extension version. */
    public $version = '1.6';

  /**
   * Create a public static instance.
   *
   * @return mixed Class instance.
   */
	static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new MainWP_CReport_Extension();
		}
		return self::$instance;
	}

    /**
     * MainWP_CReport_Extension constructor.
     */
    public function __construct() {

		$this->plugin_dir  = plugin_dir_path( __FILE__ );
		self::$plugin_url  = plugin_dir_url( __FILE__ );
		$this->plugin_slug = plugin_basename( __FILE__ );
		$this->option      = get_option( $this->option_handle );
		add_action( 'init', array( &$this, 'localization' ) );
		add_action( 'init', array( &$this, 'init' ) );
		add_filter( 'plugin_row_meta', array( &$this, 'plugin_row_meta' ), 10, 2 );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_filter( 'mainwp_sync_extensions_options', array( &$this, 'mainwp_sync_extensions_options' ), 10, 1 );
		add_filter( 'mainwp_sync_others_data', array( $this, 'sync_others_data' ), 10, 2 );
		add_action( 'mainwp_site_synced', array( &$this, 'site_synced' ), 10, 2 );
		add_action( 'mainwp_delete_site', array( &$this, 'on_delete_site' ), 10, 1 );

    // to fix action for wp cli.
		add_action( 'mainwp_sucuri_scan_done', array( &$this, 'sucuri_scan_done' ), 10, 3 );

    /**
     * This hook allows you to generate report content via the 'mainwp_client_report_generate' filter.
     *
     * @see \MainWP_CReport::hook_generate_report();
     */
    add_filter( 'mainwp_client_report_generate', array( 'MainWP_CReport', 'hook_generate_report' ), 10, 5 );

		add_filter( 'mainwp_client_report_get_site_tokens', array( 'MainWP_CReport', 'hook_get_site_tokens' ), 10, 2 );
		add_filter( 'mainwp_client_report_generate_content', array( 'MainWP_CReport', 'hook_generate_content' ), 10, 5 );


		if ( isset( $_GET['page'] ) && ( 'Extensions-Mainwp-Client-Reports-Extension' == $_GET['page'] ) && isset( $_GET['tab'] ) && $_GET['page'] == 'report' ) {
			require_once 'includes/functions.php';
			add_action( 'admin_print_footer_scripts', 'mainwp_creport_admin_print_footer_scripts' );
		}

		MainWP_CReport_DB::get_instance()->install();

		add_filter( 'cron_schedules', array( $this, 'getCronSchedules' ) );
	}

  /**
   * Initiate extension localization.
   */
	public function localization() {
		load_plugin_textdomain( 'mainwp-client-reports-extension', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

    /**
     * Initiate MainWP Client reports instance.
     */
    public function init() {

		$mwp_creport = new MainWP_CReport();
		$mwp_creport->init_cron();
	}

    /**
     * Plugin meta row.
     *
     * @param array $plugin_meta Plugin Meta data.
     * @param string $plugin_file Plugin file.
     *
     * @return array Return plugin meta array.
     */
    public function plugin_row_meta( $plugin_meta, $plugin_file ) {

		if ( $this->plugin_slug != $plugin_file ) {
			return $plugin_meta;
		}

		$slug     = basename( $plugin_file, '.php' );
		$api_data = get_option( $slug . '_APIManAdder' );
		if ( ! is_array( $api_data ) || ! isset( $api_data['activated_key'] ) || $api_data['activated_key'] != 'Activated' || ! isset( $api_data['api_key'] ) || empty( $api_data['api_key'] ) ) {
			return $plugin_meta;
		}

		$plugin_meta[] = '<a href="?do=checkUpgrade" title="Check for updates.">Check for updates now</a>';
		return $plugin_meta;
	}

  /**
   * Sync client reports data.
   *
   * @param array $data Client reports data.
   * @param array $pWebsite Child Site data.
   *
   * @return array Return client reports data.
   */
	public function sync_others_data( $data, $pWebsite = null ) {
		if ( ! is_array( $data ) ) {
					$data = array();
		}
		$data['syncClientReportData'] = 1;
		return $data;
	}

  /**
   * Sync Client reports data.
   *
   * @param array $website Child site data.
   * @param array $information Information data.
   */
	public function site_synced( $website, $information = array() ) {
		$website_id = $website->id;
		if ( is_array( $information ) && isset( $information['syncClientReportData'] ) && is_array( $information['syncClientReportData'] ) ) {
			$data = $information['syncClientReportData'];
			if ( isset( $data['firsttime_activated'] ) ) {
				$creportSettings = MainWP_CReport_Stream::get_instance()->get_option( 'settings' );
				if ( ! is_array( $creportSettings ) ) {
					$creportSettings = array();
				}
				$creportSettings[ $website_id ]['first_time'] = $data['firsttime_activated'];
				MainWP_CReport_Stream::get_instance()->set_option( 'settings', $creportSettings );
			}
		}
	}

  /**
   * On delete site.
   *
   * @param array $website Child site array.
   */
	public function on_delete_site( $website ) {
		if ( $website ) {
			MainWP_CReport_DB::get_instance()->delete_group_report_content( 0, $website->id );
		}
	}

    /**
     * Sucuri scan done.
     *
     * @param string $website_id Child Site ID.
     * @param string $scan_status Scan status.
     * @param array $data Return scan data.
     */
    public function sucuri_scan_done( $website_id, $scan_status, $data ) {
		$scan_result = array();
		if ( is_array( $data ) ) {
			$blacklisted    = isset( $data['BLACKLIST']['WARN'] ) ? true : false;
			$malware_exists = isset( $data['MALWARE']['WARN'] ) ? true : false;

			$status = array();
			if ( $blacklisted ) {
				$status[] = __( 'Site Blacklisted', 'mainwp-client-reports-extension' ); }
			if ( $malware_exists ) {
				$status[] = __( 'Site With Warnings', 'mainwp-client-reports-extension' ); }

			$scan_result['status']   = count( $status ) > 0 ? implode( ', ', $status ) : __( 'Verified Clear', 'mainwp-client-reports-extension' );
			$scan_result['webtrust'] = $blacklisted ? __( 'Site Blacklisted', 'mainwp-client-reports-extension' ) : __( 'Trusted', 'mainwp-client-reports-extension' );
		}

		$scan_data = array(
			'blacklisted'    => $blacklisted,
			'malware_exists' => $malware_exists,
		);

		// save results to child site stream.
		$post_data = array(
			'mwp_action'  => 'save_sucuri_stream',
			'result'      => base64_encode( serialize( $scan_result ) ),
			'scan_status' => $scan_status,
			'scan_data'   => base64_encode( serialize( $scan_data ) ),
		);

		/** @global object $mainWPCReportExtensionActivator Instance of MainWP CReports Extension Activator. */
		global $mainWPCReportExtensionActivator;

		apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website_id, 'client_report', $post_data );
	}

  /**
   * Initiate Admin page.
   */
	public function admin_init() {

		if ( isset( $_GET['page'] ) && ( 'Extensions-Mainwp-Client-Reports-Extension' == $_GET['page'] ) &&
				isset( $_GET['action'] ) && ( 'savepdf' == $_GET['action'] )
				&& isset( $_GET['_noncesave'] ) && wp_verify_nonce( $_REQUEST['_noncesave'], '_noncesave' )
				&& isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
			require_once $this->plugin_dir . '/libs/save-as-pdf.php';
			exit();
		}

		wp_enqueue_style( 'mainwp-creport-extension', self::$plugin_url . 'css/mainwp-reporting.css', array(), $this->version );
		wp_enqueue_script( 'mainwp-creport-extension', self::$plugin_url . 'js/mainwp-reporting.js', array(), $this->version );

		wp_localize_script(
			'mainwp-creport-extension',
			'mainwp_clientreport_loc',
			array(
				'nonce' => wp_create_nonce( '_wpnonce_creport' ),
			)
		);

		MainWP_CReport::init();
		$mwp_creport = new MainWP_CReport();
		$mwp_creport->admin_init();
		$mwp_creport_stream = new MainWP_CReport_Stream();
		$mwp_creport_stream->admin_init();
	}

  /**
   * Set cron schedules to once every 5 minuets.
   *
   * @param array $schedules Holds the Cron job schedules.
   * @return array Return array of cron jobs schedules.
   */
	public static function getCronSchedules( $schedules ) {

		$schedules['5minutely'] = array(
			'interval' => 5 * 60, // 5 minute in seconds
			'display'  => __( 'Once every 5 minutes', 'mainwp' ),
		);

		return $schedules;
	}


  /**
   * Sync extensions options.
   *
   * @param array $values Option values array.
   * @return array Return option values array.
   */
	function mainwp_sync_extensions_options( $values = array() ) {
		$values['mainwp-client-reports-extension'] = array(
			'plugin_name' => 'MainWP Child Reports',
			'plugin_slug' => 'mainwp-child-reports/mainwp-child-reports.php',
			'no_setting'  => true,
		);
		return $values;
	}

    /**
     * Get option value by given key.
     *
     * @param string $key Option array key.
     * @param string $default Default option key.
     * @return string Return option string.
     */
    public function get_option( $key, $default = '' ) {
		if ( isset( $this->option[ $key ] ) ) {
			return $this->option[ $key ];
		}
		return $default;
	}

    /**
     * Set options by given key.
     *
     * @param string $key Option array key.
     * @param string $value New option value.
     * @return bool True if the value was updated, false otherwise.
     */
    public function set_option( $key, $value ) {
		$this->option[ $key ] = $value;
		return update_option( $this->option_handle, $this->option );
	}


}

/**
 * Class MainWP_CReport_Extension_Activator.
 */
class MainWP_CReport_Extension_Activator {

    /** @var bool Whether MainWP is active or not. */
    protected $mainwpMainActivated = false;

    /** @var bool Whether MainWP Child Plugin is activated. */
    protected $childEnabled = false;

    /** @var bool Whether or not there is a Child Key. */
    protected $childKey = false;

    /** @var string Holds the Child File. */
    protected $childFile;

    /** @var string Plugin handle. */
    protected $plugin_handle = 'mainwp-client-reports-extension';

    /** @var string MainWP extension name. */
    protected $product_id = 'MainWP Client Reports Extension';

    /** @var string MainWP extension version. */
    protected $software_version = '4.0.5.1';

    /**
     * MainWP_CReport_Extension_Activator constructor.
     */
    public function __construct() {

		$this->childFile = __FILE__;

		spl_autoload_register( array( $this, 'autoload' ) );
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		add_filter( 'mainwp_getextensions', array( &$this, 'get_this_extension' ) );
		$this->mainwpMainActivated = apply_filters( 'mainwp_activated_check', false );

		if ( $this->mainwpMainActivated !== false ) {
			$this->activate_this_plugin();
		} else {
			add_action( 'mainwp_activated', array( &$this, 'activate_this_plugin' ) );
		}

		add_action( 'admin_notices', array( &$this, 'mainwp_error_notice' ) );
		add_action( 'mainwp_cronload_action', array( $this, 'load_cron_actions' ) );
	}

  /**
   * Class Autoloader.
   *
   * @param string $class_name Class name to load.
   */
	function autoload( $class_name ) {
		$allowedLoadingTypes = array( 'class' );
		$class_name          = str_replace( '_', '-', strtolower( $class_name ) );
		foreach ( $allowedLoadingTypes as $allowedLoadingType ) {
			$class_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . $allowedLoadingType . DIRECTORY_SEPARATOR . $class_name . '.' . $allowedLoadingType . '.php';
			if ( file_exists( $class_file ) ) {
				require_once $class_file;
			}
		}
	}

    /**
     * Load cron actions.
     */
    function load_cron_actions() {
		add_action( 'mainwp_managesite_schedule_backup', array( 'MainWP_CReport', 'managesite_schedule_backup' ), 10, 3 );
	}

    /**
     * Get this extension array.
     *
     * @param array $pArray Hold the extension array.
     *
     * @return array Return this extension array.
     */
    function get_this_extension( $pArray ) {

		$pArray[] = array(
			'plugin'     => __FILE__,
			'api'        => $this->plugin_handle,
			'mainwp'     => true,
			'callback'   => array( &$this, 'settings' ),
			'apiManager' => true,
		);
		return $pArray;
	}

    /**
     * MainWP Client Report settings.
     */
    function settings() {
		do_action( 'mainwp_pageheader_extensions', __FILE__ );
		MainWP_CReport::render();
		do_action( 'mainwp_pagefooter_extensions', __FILE__ );
	}

    /**
     * Activate MainWP Client Reports Plugin.
     */
    function activate_this_plugin() {

		$this->mainwpMainActivated = apply_filters( 'mainwp_activated_check', $this->mainwpMainActivated );
		$this->childEnabled        = apply_filters( 'mainwp_extension_enabled_check', __FILE__ );
		$this->childKey            = $this->childEnabled['key'];

		if ( function_exists( 'mainwp_current_user_can' ) && ! mainwp_current_user_can( 'extension', 'mainwp-client-reports-extension' ) ) {
			return;
		}

		add_action( 'mainwp_extension_sites_edit_tablerow', array( 'MainWP_CReport', 'renderClientReportsSiteTokens' ), 10, 1 ); // to do change to: mainwp-manage-sites-edit

		new MainWP_CReport_Extension();
	}

  /**
   * Get Child key.
   *
   * @return string|bool Return Child Key or FALSE on failure.
   */
	public function get_child_key() {
		return $this->childKey;
	}

    /**
     * Get child file.
     *
     * @return string Return child file.
     */
    public function get_child_file() {

		return $this->childFile;
	}

    /**
     * MainWP error notices.
     */
    function mainwp_error_notice() {

        /** @global string $current_screen Current page. */
		global $current_screen;

		if ( $current_screen->parent_base == 'plugins' && $this->mainwpMainActivated == false ) {
			echo '<div class="error"><p>MainWP Client Reports Extension ' . __( 'requires <a href="http://mainwp.com/" target="_blank">MainWP Dashboard Plugin</a> to be activated in order to work. Please install and activate <a href="http://mainwp.com/" target="_blank">MainWP Dashboard Plugin</a> first.' ) . '</p></div>';
		}
	}

  /**
   * Activate MainWP Extension.
   */
	public function activate() {
		$options = array(
			'product_id'       => $this->product_id,

			'software_version' => $this->software_version,
		);
		do_action( 'mainwp_activate_extention', $this->plugin_handle, $options );
	}

  /**
   * Deactivate MainWP Extension.
   */
	public function deactivate() {
		do_action( 'mainwp_deactivate_extention', $this->plugin_handle );
	}
}

/** @global object $mainWPCReportExtensionActivator Extension activator class instance. */
global $mainWPCReportExtensionActivator;

$mainWPCReportExtensionActivator = new MainWP_CReport_Extension_Activator();
