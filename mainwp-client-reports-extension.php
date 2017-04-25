<?php
/*
  Plugin Name: MainWP Client Reports Extension
  Plugin URI: https://mainwp.com
  Description: MainWP Client Reports Extension allows you to generate activity reports for your clients sites. Requires MainWP Dashboard.
  Version: 2.0.2
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
        public $version = '1.3';
        
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
                add_action( 'in_admin_header', array( &$this, 'in_admin_head' ) ); // Adds Help Tab in admin header
		add_filter( 'mainwp-sync-extensions-options', array( &$this, 'mainwp_sync_extensions_options' ), 10, 1 );		
                add_filter( 'mainwp-sync-others-data', array( $this, 'sync_others_data' ), 10, 2 );
		add_action( 'mainwp-site-synced', array( &$this, 'site_synced' ), 10, 2 );
                add_action( 'mainwp_delete_site', array( &$this, 'on_delete_site' ), 10, 1 );
              
                if ( isset( $_GET['page'] ) && ('Extensions-Mainwp-Client-Reports-Extension' == $_GET['page'])) {
                    require_once 'includes/functions.php';
                    add_action( 'admin_print_footer_scripts', 'mainwp_creport_admin_print_footer_scripts');
                }
                
		MainWP_CReport_DB::get_instance()->install();
                
		if ( isset( $_GET['page'] ) && ('Extensions-Mainwp-Client-Reports-Extension' == $_GET['page']) &&
				isset( $_GET['action'] ) && ('savepdf' == $_GET['action']) &&
				isset( $_GET['id'] ) && !empty($_GET['id']) ) {
			require_once $this->plugin_dir . '/includes/save-as-pdf.php';
			exit();
		}
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
	
	public function admin_init() {

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
		$schedules['30minutely'] = array(
			'interval' => 30 * 60, // 30 minutes in seconds
			'display'  => __( 'Once every 30 minutes', 'mainwp' ),
		);
		$schedules['15minutely']  = array(
			'interval' => 15 * 60, // 15 minute in seconds
			'display'  => __( 'Once every 15 minutes', 'mainwp' ),
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
        
        /**
	 * This function check if current page is Client Reports Extension page.
	 * @return void
	 */
	function in_admin_head() {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'Extensions-Mainwp-Client-Reports-Extension' ) {
			self::addHelpTabs(); // If page is Client Reports Extension then call this 'addHelpTabs' function
		}
	}

	/**
	 * This function add help tabs in header.
	 * @return void
	 */
	public static function addHelpTabs() {
		$screen = get_current_screen(); //This function returns an object that includes the screen's ID, base, post type, and taxonomy, among other data points.
		$i      = 1;

		$screen->add_help_tab( array(
			'id'      => 'mainwp_creport_helptabs_' . $i ++,
			'title'   => __( 'First Steps with Extensions', 'mainwp-client-reports-extension' ),
			'content' => self::getHelpContent( 1 ),
		) );
		$screen->add_help_tab( array(
			'id'      => 'mainwp_creport_helptabs_' . $i ++,
			'title'   => __( 'Client Reports Extension', 'mainwp-client-reports-extension' ),
			'content' => self::getHelpContent( 2 ),
		) );
	}

	/**
	 * Get help tab content.
	 *
	 * @param int $tabId
	 *
	 * @return string|bool
	 */
	public static function getHelpContent( $tabId ) {
		ob_start();
		if ( 1 == $tabId ) {
			?>
			<h3><?php echo __( 'First Steps with Extensions', 'mainwp-client-reports-extension' ); ?></h3>
			<p><?php echo __( 'If you are having issues with getting started with the MainWP extensions, please review following help documents', 'mainwp-client-reports-extension' ); ?></p>
			<a href="https://mainwp.com/help/docs/what-are-mainwp-extensions/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'What are the MainWP Extensions', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/what-are-mainwp-extensions/order-extensions/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Order Extension(s)', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/what-are-mainwp-extensions/my-downloads-and-api-keys/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'My Downloads and API Keys', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/what-are-mainwp-extensions/install-extensions/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Install Extension(s)', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/what-are-mainwp-extensions/activate-extensions-api/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Activate Extension(s) API', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/what-are-mainwp-extensions/updating-extensions/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Updating Extension(s)', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/what-are-mainwp-extensions/remove-extensions/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Remove Extension(s)', 'mainwp-client-reports-extension' ); ?></a><br/><br/>
			<a href="https://mainwp.com/help/category/mainwp-extensions/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Help Documenation for all MainWP Extensions', 'mainwp-client-reports-extension' ); ?></a>
		<?php } else if ( 2 == $tabId ) { ?>
			<h3><?php echo __( 'MainWP Client Reports Extension', 'mainwp-client-reports-extension' ); ?></h3>
			<a href="https://mainwp.com/help/docs/client-reports-extension/" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Client Reports Extension', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/install-and-set-mainwp-client-reports-extension" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Install and Set the MainWP Client Reports Extension', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/mainwp-child-reports-dashboard" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'MainWP Child Reports Dashboard', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/mainwp-child-reports-dashboard/mainwp-child-reports" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'MainWP Child Reports', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/manage-reports" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Manage Reports', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/manage-reports/create-report" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Create Report', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/manage-reports/schedule-report" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Schedule Report', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/manage-reports/edit-report" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Edit Report', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/manage-reports/delete-report" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Delete Report', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/client-report-tokens" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Client Report Tokens', 'mainwp-client-reports-extension' ); ?></a><br/>
			<a href="https://mainwp.com/help/docs/client-reports-extension/client-report-tokens/available-client-report-tokens" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Available Client Report Tokens', 'mainwp-client-reports-extension' ); ?></a><br/>
		<?php }
		$output = ob_get_clean();

		return $output;
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
	protected $software_version = '2.0.2';

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
                
                add_action('mainwp_postboxes_on_load_site_page', array( &$this, 'on_load_site_page_callback'), 10, 1);
		new MainWP_CReport_Extension();
	}
        
        function on_load_site_page_callback($websiteid) {
		$i = 1;	
		if (!empty($websiteid)){
			add_meta_box(
				'creport-contentbox-' . $i++,
				'<i class="fa fa-cog"></i> ' . __( 'Client Settings', 'mainwp-client-reports-extension' ),
				array( 'MainWP_CReport', 'renderClientReportsSiteTokens' ),
				'mainwp_postboxes_managesites_edit',
				'normal',
				'core',
				array( 'websiteid' => $websiteid )
			);	
		}
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
