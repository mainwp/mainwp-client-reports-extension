<?php
/** MainWP Client Reports Stream. */

/**
 * Class MainWP_CReport_Stream
 */
class MainWP_CReport_Stream {

    /** @var string MainWP Client Reports brnading option handle. */
    private $option_handle = 'mainwp_creport_branding_option';

    /** @var array Options array. */
    private $option = array();

    /** @var string Order. */
    private static $order = '';

    /** @var string Order by. */
    private static $orderby = '';

    /**
     * Create public static instance for MainWP_CReport_Stream.
     *
     * @return MainWP_CReport_Stream|null
     */
    private static $instance = null;

    /**
     * Method get_instance()
     *
     * Create a public static instance.
     *
     * @return mixed Class instance.
     *
     * @uses MainWP_CReport_Stream()
     */
    static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new MainWP_CReport_Stream();
		}
		return self::$instance;
	}

    /**
     * MainWP_CReport_Stream constructor.
     *
     * Run each time the class is called.
     */
    public function __construct() {
		$this->option = get_option( $this->option_handle );
	}

    /**
     * Initiate admin.
     */
    public function admin_init() {
		add_action( 'wp_ajax_mainwp_creport_active_plugin', array( $this, 'ajax_active_plugin' ) );
		add_action( 'wp_ajax_mainwp_creport_upgrade_plugin', array( $this, 'ajax_upgrade_plugin' ) );
		add_action( 'wp_ajax_mainwp_creport_showhide_stream', array( $this, 'ajax_showhide_stream' ) );
	}

    /**
     * Get option.
     *
     * @param null|string $key Option key.
     * @param string $default Holds the default option.
     *
     * @return mixed|string Return default option.
     */
    public function get_option($key = null, $default = '' ) {
		if ( isset( $this->option[ $key ] ) ) {
			return $this->option[ $key ]; }
		return $default;
	}

    /**
     * Set option.
     *
     * @param string $key Option key.
     * @param $value Option value.
     *
     * @return mixed Return FALSE if value was not updated and TRUE if value was updated.
     */
    public function set_option( $key, $value ) {
		$this->option[ $key ] = $value;
		return update_option( $this->option_handle, $this->option );
	}

    /**
     * Render dashboard tab.
     *
     * @param array $websites Child Sites array.
     */
    public static function gen_dashboard_tab( $websites ) {
		?>
		<div class="ui segment">
			<table id="mainwp-client-reports-sites-table" class="ui single line table" style="width: 100%">
				<thead>
					<tr>
						<th class="no-sort collapsing check-column"><span class="ui checkbox"><input type="checkbox"></span></th>
						<th><?php _e( 'Site', 'mainwp-client-reports-extension' ); ?></th>
						<th class="no-sort collapsing"><i class="sign in icon"></i></th>
						<th><?php _e( 'URL', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Version', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Hidden', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Last Report', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Activation', 'mainwp-client-reports-extension' ); ?></th>
						<th class="no-sort collapsing"><?php _e( '', 'mainwp-client-reports-extension' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ( is_array( $websites ) && count( $websites ) > 0 ) {
						self::gen_dashboard_table_rows( $websites );
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th class="no-sort collapsing check-column"><span class="ui checkbox"><input type="checkbox"></span></th>
						<th><?php _e( 'Site', 'mainwp-client-reports-extension' ); ?></th>
						<th class="no-sort collapsing"><i class="sign in icon"></i></th>
						<th><?php _e( 'URL', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Version', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Hidden', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Last Report', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Activation', 'mainwp-client-reports-extension' ); ?></th>
						<th class="no-sort collapsing"><?php _e( '', 'mainwp-client-reports-extension' ); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<script type="text/javascript">
			jQuery( document ).ready( function () {
				jQuery( '#mainwp-client-reports-sites-table' ).DataTable( {
					"stateSave": true,
					"stateDuration": 0, // forever
					"scrollX": true,
					"colReorder" : true,
					"columnDefs": [ { "orderable": false, "targets": "no-sort" } ],
					"order": [ [ 1, "asc" ] ],
					"language": { "emptyTable": "No websites were found with the MainWP Child Reports plugin installed." },
					"drawCallback": function( settings ) {
						jQuery('#mainwp-client-reports-sites-table .ui.checkbox').checkbox();
						jQuery( '#mainwp-client-reports-sites-table .ui.dropdown').dropdown();
						if ( typeof mainwp_datatable_fix_menu_overflow != 'undefined' ) {
							mainwp_datatable_fix_menu_overflow();
						}
					},
				} );
			});
			if ( typeof mainwp_datatable_fix_menu_overflow != 'undefined' ) {
				mainwp_datatable_fix_menu_overflow();
			}
		</script>
		<?php
	}

  /**
   * Render dashboard table rows.
   *
   * @param array $websites Child Sites array.
   *
   * @uses MainWP_CReport_Utility::get_timestamp()
   */
	public static function gen_dashboard_table_rows( $websites ) {
		$location    = 'options-general.php?page=mainwp-reports-page';
		$plugin_slug = 'mainwp-child-reports/mainwp-child-reports.php';
		$plugin_name = 'MainWP Child Reports';

		foreach ( $websites as $website ) {
			$website_id = $website['id'];

			$class_active = ( isset( $website['plugin_activated'] ) && ! empty( $website['plugin_activated'] ) ) ? '' : 'negative';
			$class_update = ( isset( $website['reports_upgrade'] ) ) ? 'warning' : '';
			$class_update = ( 'negative' == $class_active ) ? 'negative' : $class_update;

			$version = '';
			if ( isset( $website['reports_upgrade'] ) ) {
				if ( isset( $website['reports_upgrade']['new_version'] ) ) {
					$version = $website['reports_upgrade']['new_version'];
				}
			}
			// echo var_dump( $website );
			?>
			<tr class="<?php echo $class_active . ' ' . $class_update; ?>" website-id="<?php echo $website_id; ?>" plugin-name="<?php echo $plugin_name; ?>" plugin-slug="<?php echo $plugin_slug; ?>" version="<?php echo ( isset( $website['plugin_version'] ) ) ? $website['plugin_version'] : 'N/A'; ?>">
		<td class="check-column"><span class="ui checkbox"><input type="checkbox" name="checked[]"></span></td>
				<td class="website-name"><a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><?php echo stripslashes( $website['name'] ); ?></a></td>
				<td><a target="_blank" href="admin.php?page=SiteOpen&newWindow=yes&websiteid=<?php echo $website_id; ?>"><i class="sign in icon"></i></a></td>
				<td><a href="<?php echo $website['url']; ?>" target="_blank"><?php echo $website['url']; ?></a></td>
				<td><span class="updating"></span> <?php echo ( isset( $website['reports_upgrade'] ) ) ? '<i class="exclamation circle icon"></i>' : ''; ?> <?php echo ( isset( $website['plugin_version'] ) ) ? $website['plugin_version'] : 'N/A'; ?></td>
				<td class="wp-reports-visibility"><span class="visibility"></span> <?php echo ( 1 == $website['hide_stream'] ) ? __( 'Yes', 'mainwp-client-reports-extension' ) : __( 'No', 'mainwp-client-reports-extension' ); ?></td>
				<td>
					<?php if ( $website['last_report'] ) : ?>
						<?php echo MainWP_CReport_Utility::format_timestamp( MainWP_CReport_Utility::get_timestamp( $website['last_report'] ) ); ?>
			<?php endif; ?>
				</td>
				<td>
					<?php if ( isset( $website['first_time'] ) && ! empty( $website['first_time'] ) ) : ?>
						<?php echo MainWP_CReport_Utility::format_timestamp( MainWP_CReport_Utility::get_timestamp( $website['first_time'] ) ); ?>
			<?php endif; ?>
				</td>
				<td>
					<div class="ui left pointing dropdown icon mini basic green button" style="z-index:999">
						<a href="javascript:void(0)"><i class="ellipsis horizontal icon"></i></a>
						<div class="menu">
							<a class="item" href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><?php _e( 'Overview', 'mainwp-client-reports-extension' ); ?></a>
							<a class="item" href="admin.php?page=managesites&id=<?php echo $website_id; ?>"><?php _e( 'Edit', 'mainwp-client-reports-extension' ); ?></a>
							<a class="item" href="admin.php?page=SiteOpen&newWindow=yes&websiteid=<?php echo $website_id; ?>&location=<?php echo base64_encode( $location ); ?>" target="_blank"><?php _e( 'Open Child Reports', 'mainwp-client-reports-extension' ); ?></a>
							<?php if ( 1 == $website['hide_stream'] ) : ?>
							<a class="item creport_showhide_plugin" href="#" showhide="show"><?php _e( 'Unhide Plugin', 'mainwp-client-reports-extension' ); ?></a>
							<?php else : ?>
							<a class="item creport_showhide_plugin" href="#" showhide="hide"><?php _e( 'Hide Plugin', 'mainwp-client-reports-extension' ); ?></a>
							<?php endif; ?>
							<?php if ( isset( $website['plugin_activated'] ) && empty( $website['plugin_activated'] ) ) : ?>
							<a class="item creport_active_plugin" href="#"><?php _e( 'Activate Plugin', 'mainwp-client-reports-extension' ); ?></a>
							<?php endif; ?>
							<?php if ( isset( $website['reports_upgrade'] ) ) : ?>
							<a class="item creport_upgrade_plugin" href="#"><?php _e( 'Update Plugin', 'mainwp-client-reports-extension' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
		</td>
	  </tr>
			<?php
		}
	}

    /**
     * Get Child Sites Stream.
     *
     * @param array $websites Child Sites array.
     * @param int $selected_group Selected sites group.
     * @param array $lastReportsSites Last reported sites array.
     *
     * @return array Child Sites Stream.
     *
     * @uses MainWP_CReport_Utility::map_site()
     */
    public function get_websites_stream( $websites, $selected_group = 0, $lastReportsSites = array() ) {
		$websites_stream = array();
		$streamHide      = $this->get_option( 'hide_stream_plugin' );
		if ( ! is_array( $streamHide ) ) {
			$streamHide = array();
		}

				$creportSettings = $this->get_option( 'settings' );
		if ( ! is_array( $creportSettings ) ) {
			$creportSettings = array();
		}

		if ( is_array( $websites ) && count( $websites ) ) {
			if ( empty( $selected_group ) ) {
				foreach ( $websites as $website ) {
					if ( $website && $website->plugins != '' ) {
						$plugins = json_decode( $website->plugins, 1 );
						if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
														$creportSiteSettings = array();

							if ( isset( $creportSettings[ $website->id ] ) ) {
								$creportSiteSettings = $creportSettings[ $website->id ];
							}

							if ( ! is_array( $creportSiteSettings ) ) {
								$creportSiteSettings = array();
							}

							foreach ( $plugins as $plugin ) {
								if ( 'mainwp-child-reports/mainwp-child-reports.php' == $plugin['slug'] ) {

									$site = MainWP_CReport_Utility::map_site( $website, array( 'id', 'name', 'url' ) );
									if ( $plugin['active'] ) {
										$site['plugin_activated'] = 1;
									} else {
										$site['plugin_activated'] = 0;

									}
                  // get upgrade info
                  $site['plugin_version'] = $plugin['version'];
                  $plugin_upgrades        = json_decode( $website->plugin_upgrades, 1 );
									if ( is_array( $plugin_upgrades ) && count( $plugin_upgrades ) > 0 ) {
										if ( isset( $plugin_upgrades['mainwp-child-reports/mainwp-child-reports.php'] ) ) {
																			$upgrade = $plugin_upgrades['mainwp-child-reports/mainwp-child-reports.php'];
											if ( isset( $upgrade['update'] ) ) {
												$site['reports_upgrade'] = $upgrade['update'];
											}
										}
									}

																		$site['hide_stream'] = 0;
									if ( isset( $streamHide[ $website->id ] ) && $streamHide[ $website->id ] ) {
											$site['hide_stream'] = 1;
									}

									if ( isset( $creportSiteSettings['first_time'] ) ) {
											$site['first_time'] = $creportSiteSettings['first_time'];
									}
                  $site['last_report'] = isset( $lastReportsSites[ $website->id ] ) ? $lastReportsSites[ $website->id ] : 0;
                  $websites_stream[]   = $site;
                  break;
								}
							}
						}
					}
				}
			} else {

				/**
				 * MainWP Client Reports Extension Activator instance.
                 *
				 * @global object $mainWPCReportExtensionActivator
				 */
				global $mainWPCReportExtensionActivator;

				$group_websites = apply_filters( 'mainwp_getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), array(), array( $selected_group ) );
				$sites          = array();
				foreach ( $group_websites as $site ) {
					$sites[] = $site->id;
				}
				foreach ( $websites as $website ) {
					if ( $website && $website->plugins != '' && in_array( $website->id, $sites ) ) {
						$plugins = json_decode( $website->plugins, 1 );
						if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
														$creportSiteSettings = array();

							if ( isset( $creportSettings[ $website->id ] ) ) {
								$creportSiteSettings = $creportSettings[ $website->id ];
							}

							if ( ! is_array( $creportSiteSettings ) ) {
								$creportSiteSettings = array();
							}

							foreach ( $plugins as $plugin ) {
								if ( 'mainwp-child-reports/mainwp-child-reports.php' == $plugin['slug'] ) {

																		$site = MainWP_CReport_Utility::map_site( $website, array( 'id', 'name', 'url' ) );

									if ( $plugin['active'] ) {
										$site['plugin_activated'] = 1;
									} else {
										$site['plugin_activated'] = 0;

									}

                  $site['plugin_version'] = $plugin['version'];

                  // get upgrade info
                  $plugin_upgrades = json_decode( $website->plugin_upgrades, 1 );
									if ( is_array( $plugin_upgrades ) && count( $plugin_upgrades ) > 0 ) {
										if ( isset( $plugin_upgrades['mainwp-child-reports/mainwp-child-reports.php'] ) ) {
																				$upgrade = $plugin_upgrades['mainwp-child-reports/mainwp-child-reports.php'];
											if ( isset( $upgrade['update'] ) ) {
												$site['reports_upgrade'] = $upgrade['update'];
											}
										}
									}

																		$site['hide_stream'] = 0;
									if ( isset( $streamHide[ $website->id ] ) && $streamHide[ $website->id ] ) {
											$site['hide_stream'] = 1;
									}
									if ( isset( $creportSiteSettings['first_time'] ) ) {
											$site['first_time'] = $creportSiteSettings['first_time'];
									}
                  $site['last_report'] = isset( $lastReportsSites[ $website->id ] ) ? $lastReportsSites[ $website->id ] : 0;
                  $websites_stream[]   = $site;
                  break;
								}
							}
						}
					}
				}
			}
		}

		// if search action.
		$search_sites = array();
		if ( isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) {
			$find = trim( $_GET['s'] );
			foreach ( $websites_stream as $website ) {
				if ( stripos( $website['name'], $find ) !== false || stripos( $website['url'], $find ) !== false ) {
					$search_sites[] = $website;
				}
			}
			$websites_stream = $search_sites;
		}
		unset( $search_sites );

		return $websites_stream;
	}

    /**
     * Generate action rows.
     */
    public static function gen_actions_rows() {
		?>
		<div class="mainwp-actions-bar">
			<div class="ui grid">
				<div class="ui two column row">
					<div class="column">
						<select class="ui dropdown" id="creport_stream_action">
							<option value="-1"><?php _e( 'Bulk Actions', 'mainwp-backupwordpress-extension' ); ?></option>
							<option value="activate-selected"><?php _e( 'Activate', 'mainwp-backupwordpress-extension' ); ?></option>
							<option value="update-selected"><?php _e( 'Update', 'mainwp-backupwordpress-extension' ); ?></option>
							<option value="hide-selected"><?php _e( 'Hide', 'mainwp-backupwordpress-extension' ); ?></option>
							<option value="show-selected"><?php _e( 'Unhide', 'mainwp-backupwordpress-extension' ); ?></option>
			</select>
						<input type="button" value="<?php _e( 'Apply' ); ?>" class="ui basic button action" id="creport_stream_doaction_btn" name="creport_stream_doaction_btn">
						<?php do_action( 'mainwp_client_reports_actions_bar_left' ); ?>
			</div>
					<div class="right aligned column">
						<?php do_action( 'mainwp_client_reports_actions_bar_right' ); ?>
			</div>
		</div>
			</div>
		</div>
		<?php
	}

  /**
   * Ajax activate plugin.
   *
   * @uses MainWP_CReport::verify_nonce()
   */
	public function ajax_active_plugin() {
		MainWP_CReport::verify_nonce();
		do_action( 'mainwp_activePlugin' );
		die();
	}

  /**
   * Ajax upgrade plugin.
   *
   * @uses MainWP_CReport::verify_nonce()
   */
	public function ajax_upgrade_plugin() {
		MainWP_CReport::verify_nonce();
		do_action( 'mainwp_upgradePluginTheme' );
		die();
	}

  /**
   * Ajax show|hide stream.
   *
   * @uses MainWP_CReport::verify_nonce()
   */
	public function ajax_showhide_stream() {
		MainWP_CReport::verify_nonce();
		$siteid   = isset( $_POST['websiteId'] ) ? $_POST['websiteId'] : null;
		$showhide = isset( $_POST['showhide'] ) ? $_POST['showhide'] : null;
		if ( null !== $siteid && null !== $showhide ) {


			/**
			 * MainWP Client Reports Extension Activator instance.
			 *
			 * @global object $mainWPCReportExtensionActivator
			 */
			global $mainWPCReportExtensionActivator;

			$post_data   = array(
				'mwp_action' => 'set_showhide',
				'showhide'   => $showhide,
			);
			$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $siteid, 'client_report', $post_data );

			if ( is_array( $information ) && isset( $information['result'] ) && 'SUCCESS' === $information['result'] ) {
				$hide_stream = $this->get_option( 'hide_stream_plugin' );
				if ( ! is_array( $hide_stream ) ) {
					$hide_stream = array(); }
				$hide_stream[ $siteid ] = ( 'hide' === $showhide ) ? 1 : 0;
				$this->set_option( 'hide_stream_plugin', $hide_stream );
			}

			die( json_encode( $information ) );
		}
		die();
	}
}
