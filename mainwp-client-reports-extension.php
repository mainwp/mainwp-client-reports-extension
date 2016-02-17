<?php
/*
  Plugin Name: MainWP Client Reports Extension
  Plugin URI: https://mainwp.com
  Description: MainWP Client Reports Extension allows you to generate activity reports for your clients sites. Requires MainWP Dashboard.
  Version: 1.0
  Author: MainWP
  Author URI: https://mainwp.com
  Support Forum URI: https://mainwp.com/forum/forumdisplay.php?100-Client-Reports
  Documentation URI: http://docs.mainwp.com/category/mainwp-extensions/mainwp-client-reports/
  Icon URI:
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
		add_action( 'after_plugin_row', array( &$this, 'after_plugin_row' ), 10, 3 );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_filter( 'mainwp-sync-extensions-options', array( &$this, 'mainwp_sync_extensions_options' ), 10, 1 );		
		
		MainWP_CReport_DB::get_instance()->install();

		if ( isset( $_GET['page'] ) && ('Extensions-Mainwp-Client-Reports-Extension' == $_GET['page']) &&
				isset( $_GET['action'] ) && ('savepdf' == $_GET['action']) &&
				isset( $_GET['id'] ) && $_GET['id'] ) {
			require_once $this->plugin_dir . '/includes/save-as-pdf.php';
			exit();
		}
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
	
	public function after_plugin_row( $plugin_file, $plugin_data, $status ) {	
		if ( $this->plugin_slug != $plugin_file ) {
			return ;
		}	
		$slug = basename($plugin_file, ".php");
		$api_data = get_option( $slug. '_APIManAdder');
		
		if (!is_array($api_data) || !isset($api_data['activated_key']) || $api_data['activated_key'] != 'Activated'){
			if (!isset($api_data['api_key']) || empty($api_data['api_key'])) {
				?>
				<style type="text/css">
					tr#<?php echo $slug;?> td, tr#<?php echo $slug;?> th{
						box-shadow: none;
					}
				</style>
				<tr class="plugin-update-tr active"><td colspan="3" class="plugin-update colspanchange"><div class="update-message api-deactivate">
				<?php echo (sprintf(__("API not activated check your %sMainWP account%s for updates. For automatic update notification please activate the API.", "mainwp"), '<a href="https://mainwp.com/my-account" target="_blank">', '</a>')); ?>
				</div></td></tr>
				<?php
			}
		}		
	}	

	public function admin_init() {

		wp_enqueue_style( 'mainwp-creport-extension', self::$plugin_url . 'css/mainwp-reporting.css' );
		wp_enqueue_script( 'mainwp-creport-extension', self::$plugin_url . 'js/mainwp-reporting.js' );
		$translation_array = array( 'dashboard_sitename' => get_bloginfo( 'name' ) );
		MainWP_CReport::init();
		$mwp_creport = new MainWP_CReport();
		$mwp_creport->admin_init();
		$mwp_creport_stream = new MainWP_CReport_Stream();
		$mwp_creport_stream->admin_init();
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

function mainwp_wpcreport_extension_autoload( $class_name ) {
	$allowedLoadingTypes = array( 'class' );
	$class_name = str_replace( '_', '-', strtolower( $class_name ) );
	foreach ( $allowedLoadingTypes as $allowedLoadingType ) {
		$class_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) . $allowedLoadingType . DIRECTORY_SEPARATOR . $class_name . '.' . $allowedLoadingType . '.php';
		if ( file_exists( $class_file ) ) {
			require_once( $class_file );
		}
	}
}

if ( function_exists( 'spl_autoload_register' ) ) {
	spl_autoload_register( 'mainwp_wpcreport_extension_autoload' );
} else {

	function __autoload( $class_name ) {

		mainwp_wpcreport_extension_autoload( $class_name );
	}
}

register_activation_hook( __FILE__, 'wpcreport_extension_activate' );
register_deactivation_hook( __FILE__, 'wpcreport_extension_deactivate' );

function wpcreport_extension_activate() {
	update_option( 'mainwp_client_reports_activated', 'yes' );
	$extensionActivator = new MainWP_CReport_Extension_Activator();
	$extensionActivator->activate();	
}

function wpcreport_extension_deactivate() {

	$extensionActivator = new MainWP_CReport_Extension_Activator();
	$extensionActivator->deactivate();
}

class MainWP_CReport_Extension_Activator {

	protected $mainwpMainActivated = false;
	protected $childEnabled = false;
	protected $childKey = false;
	protected $childFile;
	protected $plugin_handle = 'mainwp-client-reports-extension';
	protected $product_id = 'MainWP Client Reports Extension';
	protected $software_version = '1.0';

	public function __construct() {

		$this->childFile = __FILE__;
		add_filter( 'mainwp-getextensions', array( &$this, 'get_this_extension' ) );
		$this->mainwpMainActivated = apply_filters( 'mainwp-activated-check', false );

		if ( $this->mainwpMainActivated !== false ) {
			$this->activate_this_plugin();
		} else {
			add_action( 'mainwp-activated', array( &$this, 'activate_this_plugin' ) );
		}
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'admin_notices', array( &$this, 'mainwp_error_notice' ) );
		add_action( 'mainwp_cronload_action', array( $this, 'load_cron_actions' ) );
	}

	function load_cron_actions() {
		add_action( 'mainwp_managesite_schedule_backup', array( 'MainWP_CReport', 'managesite_schedule_backup' ), 10, 3 );
	}

	function admin_init() {
		if ( get_option( 'mainwp_client_reports_activated' ) == 'yes' ) {
			delete_option( 'mainwp_client_reports_activated' );
			wp_redirect( admin_url( 'admin.php?page=Extensions' ) );
			return;
		}
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

	public function update_option( $option_name, $option_value ) {

		$success = add_option( $option_name, $option_value, '', 'no' );

		if ( ! $success ) {
			$success = update_option( $option_name, $option_value );
		}

		return $success;
	}

	public function activate() {
		$options = array(
			'product_id' => $this->product_id,
			'activated_key' => 'Deactivated',
			'instance_id' => apply_filters( 'mainwp-extensions-apigeneratepassword', 12, false ),
			'software_version' => $this->software_version,
		);
		$this->update_option( $this->plugin_handle . '_APIManAdder', $options );
	}

	public function deactivate() {
		$this->update_option( $this->plugin_handle . '_APIManAdder', '' );
	}
}

global $mainWPCReportExtensionActivator;
$mainWPCReportExtensionActivator = new MainWP_CReport_Extension_Activator();
