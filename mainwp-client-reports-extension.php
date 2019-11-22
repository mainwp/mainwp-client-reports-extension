<?php
/*
  Plugin Name: MainWP Client Reports Extension
  Plugin URI: https://mainwp.com
  Description: MainWP Client Reports Extension allows you to generate activity reports for your clients sites. Requires MainWP Dashboard.
  Version: 4.0.1
  Author: MainWP
  Author URI: https://mainwp.com
  Documentation URI: https://mainwp.com/help/category/mainwp-extensions/client-reports/
 */
if ( ! defined( 'MAINWP_CLIENT_REPORTS_PLUGIN_FILE' ) ) {
	define( 'MAINWP_CLIENT_REPORTS_PLUGIN_FILE', __FILE__ );
}

class MainWP_CReport_Extension {

	public static $instance = null;
	public $plugin_handle = 'mainwp-wpcreport-extension';
	public static $plugin_url;
	public $plugin_slug;
	public $plugin_dir;
	protected $option;
	protected $option_handle = 'mainwp_wpcreport_extension';
	public $version = '1.6';

    static function get_instance() {
		if ( null == MainWP_CReport_Extension::$instance ) {
			MainWP_CReport_Extension::$instance = new MainWP_CReport_Extension();
		}
		return MainWP_CReport_Extension::$instance;
	}

	public function __construct() {

		$this->plugin_dir = plugin_dir_path( __FILE__ );
		self::$plugin_url = plugin_dir_url( __FILE__ );
		$this->plugin_slug = plugin_basename( __FILE__ );
		$this->option = get_option( $this->option_handle );
		add_action( 'init', array( &$this, 'localization' ) );
		add_action( 'init', array( &$this, 'init' ) );
		add_filter( 'plugin_row_meta', array( &$this, 'plugin_row_meta' ), 10, 2 );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_filter( 'mainwp-sync-extensions-options', array( &$this, 'mainwp_sync_extensions_options' ), 10, 1 );
    add_filter( 'mainwp-sync-others-data', array( $this, 'sync_others_data' ), 10, 2 );
		add_action( 'mainwp-site-synced', array( &$this, 'site_synced' ), 10, 2 );
    add_action( 'mainwp_delete_site', array( &$this, 'on_delete_site' ), 10, 1 );
    add_action( 'mainwp_sucuri_scan_done', array( &$this, 'sucuri_scan_done' ), 10, 3 ); // to fix action for wp cli

    /**
		 * This hook allows you to generate report content via the 'mainwp_client_report_generate' filter.
		 *
     * @see \MainWP_CReport::hook_generate_report();
		 */
    add_filter( 'mainwp_client_report_generate', array( 'MainWP_CReport', 'hook_generate_report' ), 10, 5 );

    if ( isset( $_GET['page'] ) && ('Extensions-Mainwp-Client-Reports-Extension' == $_GET['page']) && isset($_GET['tab']) && $_GET['page'] == 'report' ) {
	    require_once 'includes/functions.php';
	    add_action( 'admin_print_footer_scripts', 'mainwp_creport_admin_print_footer_scripts');
    }

		MainWP_CReport_DB::get_instance()->install();

		add_filter( 'cron_schedules', array( $this, 'getCronSchedules' ) );
	}

	public function localization() {
		load_plugin_textdomain( 'mainwp-client-reports-extension', false,  dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public function init() {

		$mwp_creport = new MainWP_CReport();
		$mwp_creport->init_cron();
	}

	public function plugin_row_meta( $plugin_meta, $plugin_file ) {

		if ( $this->plugin_slug != $plugin_file ) {
			return $plugin_meta;
		}

		$slug = basename($plugin_file, ".php");
		$api_data = get_option( $slug. '_APIManAdder');
		if (!is_array($api_data) || !isset($api_data['activated_key']) || $api_data['activated_key'] != 'Activated' || !isset($api_data['api_key']) || empty($api_data['api_key']) ) {
			return $plugin_meta;
		}

		$plugin_meta[] = '<a href="?do=checkUpgrade" title="Check for updates.">Check for updates now</a>';
		return $plugin_meta;
	}

    public function sync_others_data( $data, $pWebsite = null ) {
		if ( ! is_array( $data ) ) {
                    $data = array();
                }
		$data['syncClientReportData'] = 1;
		return $data;
	}

	public function site_synced( $website, $information = array()) {
		$website_id = $website->id;
                if ( is_array( $information ) && isset( $information['syncClientReportData'] ) && is_array( $information['syncClientReportData'] ) ) {
                    $data = $information['syncClientReportData'];
                    if (isset($data['firsttime_activated'])) {
                        $creportSettings = MainWP_CReport_Stream::get_instance()->get_option( 'settings' );
                        if (!is_array($creportSettings))
                            $creportSettings = array();
                        $creportSettings[$website_id]['first_time'] = $data['firsttime_activated'];
                        MainWP_CReport_Stream::get_instance()->set_option( 'settings', $creportSettings );
                    }
                }
	}

    public function on_delete_site( $website ) {
		if ( $website ) {
			MainWP_CReport_DB::get_instance()->delete_group_report_content( 0, $website->id );
		}
	}

	public function sucuri_scan_done( $website_id, $scan_status, $data ) {
		$scan_result = array();
		if ( is_array( $data ) ) {
			$blacklisted = isset( $data['BLACKLIST']['WARN'] ) ? true : false;
			$malware_exists = isset( $data['MALWARE']['WARN'] ) ? true : false;

			$status = array();
			if ( $blacklisted ) {
				$status[] = __( 'Site Blacklisted', 'mainwp-client-reports-extension' ); }
			if ( $malware_exists ) {
				$status[] = __( 'Site With Warnings', 'mainwp-client-reports-extension' ); }

			$scan_result['status'] = count( $status ) > 0 ? implode( ', ', $status ) : __( 'Verified Clear', 'mainwp-client-reports-extension' );
			$scan_result['webtrust'] = $blacklisted ? __( 'Site Blacklisted', 'mainwp-client-reports-extension' ) : __( 'Trusted', 'mainwp-client-reports-extension' );
		}

        $scan_data = array(
            'blacklisted' => $blacklisted,
            'malware_exists' => $malware_exists
        );

		// save results to child site stream
		$post_data = array(
            'mwp_action' => 'save_sucuri_stream',
			'result' => base64_encode( serialize( $scan_result ) ),
			'scan_status' => $scan_status,
            'scan_data' => base64_encode( serialize( $scan_data ) )
		);
		global $mainWPCReportExtensionActivator;
		apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website_id, 'client_report', $post_data );
	}

    public function admin_init() {

        if ( isset( $_GET['page'] ) && ('Extensions-Mainwp-Client-Reports-Extension' == $_GET['page']) &&
				isset( $_GET['action'] ) && ('savepdf' == $_GET['action'])
                && isset($_GET['_noncesave']) && wp_verify_nonce( $_REQUEST['_noncesave'], '_noncesave' )
				&& isset( $_GET['id'] ) && !empty($_GET['id']) ) {
			require_once $this->plugin_dir . '/libs/save-as-pdf.php';
			exit();
		}

		wp_enqueue_style( 'mainwp-creport-extension', self::$plugin_url . 'css/mainwp-reporting.css', array(), $this->version);
		wp_enqueue_script( 'mainwp-creport-extension', self::$plugin_url . 'js/mainwp-reporting.js', array(), $this->version );
		
		wp_localize_script(
			'mainwp-creport-extension', 'mainwp_clientreport_loc', array(
			'nonce' => wp_create_nonce( '_wpnonce_creport' ),
			)
		);

		MainWP_CReport::init();
		$mwp_creport = new MainWP_CReport();
		$mwp_creport->admin_init();
		$mwp_creport_stream = new MainWP_CReport_Stream();
		$mwp_creport_stream->admin_init();
	}

    public static function getCronSchedules( $schedules ) {

		$schedules['5minutely']  = array(
			'interval' => 5 * 60, // 5 minute in seconds
			'display'  => __( 'Once every 5 minutes', 'mainwp' ),
		);

		return $schedules;
	}

	function mainwp_sync_extensions_options($values = array()) {
		$values['mainwp-client-reports-extension'] = array(
			'plugin_name' => 'MainWP Child Reports',
			'plugin_slug' => 'mainwp-child-reports/mainwp-child-reports.php',
			'no_setting' => true
		);
		return $values;
	}

	public function get_option( $key, $default = '' ) {
		if ( isset( $this->option[ $key ] ) ) {
			return $this->option[ $key ];
		}
		return $default;
	}

	public function set_option( $key, $value ) {
		$this->option[ $key ] = $value;
		return update_option( $this->option_handle, $this->option );
	}


}

class MainWP_CReport_Extension_Activator {

	protected $mainwpMainActivated = false;
	protected $childEnabled = false;
	protected $childKey = false;
	protected $childFile;
	protected $plugin_handle = 'mainwp-client-reports-extension';
	protected $product_id = 'MainWP Client Reports Extension';
	protected $software_version = '4.0.1';

	public function __construct() {

		$this->childFile = __FILE__;

        spl_autoload_register( array( $this, 'autoload' ) );
        register_activation_hook( __FILE__, array($this, 'activate') );
        register_deactivation_hook( __FILE__, array($this, 'deactivate') );

		add_filter( 'mainwp-getextensions', array( &$this, 'get_this_extension' ) );
		$this->mainwpMainActivated = apply_filters( 'mainwp-activated-check', false );

		if ( $this->mainwpMainActivated !== false ) {
			$this->activate_this_plugin();
		} else {
			add_action( 'mainwp-activated', array( &$this, 'activate_this_plugin' ) );
		}

		add_action( 'admin_notices', array( &$this, 'mainwp_error_notice' ) );
		add_action( 'mainwp_cronload_action', array( $this, 'load_cron_actions' ) );
	}

    function autoload( $class_name ) {
        $allowedLoadingTypes = array( 'class' );
        $class_name = str_replace( '_', '-', strtolower( $class_name ) );
        foreach ( $allowedLoadingTypes as $allowedLoadingType ) {
            $class_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . $allowedLoadingType . DIRECTORY_SEPARATOR . $class_name . '.' . $allowedLoadingType . '.php';
            if ( file_exists( $class_file ) ) {
                require_once( $class_file );
            }
        }
    }

	function load_cron_actions() {
		add_action( 'mainwp_managesite_schedule_backup', array( 'MainWP_CReport', 'managesite_schedule_backup' ), 10, 3 );
	}

	function get_this_extension( $pArray ) {

		$pArray[] = array( 'plugin' => __FILE__, 'api' => $this->plugin_handle, 'mainwp' => true, 'callback' => array( &$this, 'settings' ), 'apiManager' => true );
		return $pArray;
	}

	function settings() {
		do_action( 'mainwp-pageheader-extensions', __FILE__ );
		MainWP_CReport::render();
		do_action( 'mainwp-pagefooter-extensions', __FILE__ );
	}

	function activate_this_plugin() {

		$this->mainwpMainActivated = apply_filters( 'mainwp-activated-check', $this->mainwpMainActivated );
		$this->childEnabled = apply_filters( 'mainwp-extension-enabled-check', __FILE__ );
		$this->childKey = $this->childEnabled['key'];

		if ( function_exists( 'mainwp_current_user_can' ) && ! mainwp_current_user_can( 'extension', 'mainwp-client-reports-extension' ) ) {
			return;
		}

		add_action( 'mainwp_extension_sites_edit_tablerow', array( 'MainWP_CReport', 'renderClientReportsSiteTokens'), 10, 1); // to do change to: mainwp-manage-sites-edit

		new MainWP_CReport_Extension();
	}

    public function get_child_key() {

		return $this->childKey;
	}

	public function get_child_file() {

		return $this->childFile;
	}

	function mainwp_error_notice() {

		global $current_screen;
		if ( $current_screen->parent_base == 'plugins' && $this->mainwpMainActivated == false ) {
			echo '<div class="error"><p>MainWP Client Reports Extension ' . __( 'requires <a href="http://mainwp.com/" target="_blank">MainWP Dashboard Plugin</a> to be activated in order to work. Please install and activate <a href="http://mainwp.com/" target="_blank">MainWP Dashboard Plugin</a> first.' ) . '</p></div>';
		}
	}

	public function activate() {
	    $options = array(
            'product_id' => $this->product_id,
			'software_version' => $this->software_version,
		);
        do_action( 'mainwp_activate_extention', $this->plugin_handle , $options );
	}

	public function deactivate() {
        do_action( 'mainwp_deactivate_extention', $this->plugin_handle );
	}
}

global $mainWPCReportExtensionActivator;
$mainWPCReportExtensionActivator = new MainWP_CReport_Extension_Activator();
