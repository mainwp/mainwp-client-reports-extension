<?php

class MainWP_CReport_Stream {

	private $option_handle = 'mainwp_creport_branding_option';
	private $option = array();
	private static $order = '';
	private static $orderby = '';
	//Singleton
	private static $instance = null;

	static function get_instance() {
		if ( null == MainWP_CReport_Stream::$instance ) {
			MainWP_CReport_Stream::$instance = new MainWP_CReport_Stream();
		}
		return MainWP_CReport_Stream::$instance;
	}

	public function __construct() {
		$this->option = get_option( $this->option_handle );
	}

	public function admin_init() {
		add_action( 'wp_ajax_mainwp_creport_upgrade_noti_dismiss', array( $this, 'ajax_dismiss_notice' ) );
		add_action( 'wp_ajax_mainwp_creport_active_plugin', array( $this, 'ajax_active_plugin' ) );
		add_action( 'wp_ajax_mainwp_creport_upgrade_plugin', array( $this, 'ajax_upgrade_plugin' ) );
		add_action( 'wp_ajax_mainwp_creport_showhide_stream', array( $this, 'ajax_showhide_stream' ) );
	}

	public function get_option( $key = null, $default = '' ) {
		if ( isset( $this->option[ $key ] ) ) {
			return $this->option[ $key ]; }
		return $default;
	}

	public function set_option( $key, $value ) {
		$this->option[ $key ] = $value;
		return update_option( $this->option_handle, $this->option );
	}

	public static function gen_stream_dashboard_tab( $websites ) {

		$orderby = 'name';
		$_order = 'desc';
		if ( isset( $_GET['stream_orderby'] ) && ! empty( $_GET['stream_orderby'] ) ) {
			$orderby = $_GET['stream_orderby'];
		}
		if ( isset( $_GET['stream_order'] ) && ! empty( $_GET['stream_order'] ) ) {
			$_order = $_GET['stream_order'];
		}

		$name_order = $version_order = $temp_order = $time_order = $url_order = $hidden_order = '';
		if ( isset( $_GET['stream_orderby'] ) && 'name' == $_GET['stream_orderby'] ) {
			$name_order = ('desc' == $_order) ? 'asc' : 'desc';
		} else if ( isset( $_GET['stream_orderby'] ) && 'version' == $_GET['stream_orderby'] ) {
			$version_order = ('desc' == $_order) ? 'asc' : 'desc';
		} else if ( isset( $_GET['stream_orderby'] ) && 'template' == $_GET['stream_orderby'] ) {
			$temp_order = ('desc' == $_order) ? 'asc' : 'desc';
		} else if ( isset( $_GET['stream_orderby'] ) && 'time' == $_GET['stream_orderby'] ) {
			$time_order = ('desc' == $_order) ? 'asc' : 'desc';
		} else if ( isset( $_GET['stream_orderby'] ) && 'url' == $_GET['stream_orderby'] ) {
			$url_order = ('desc' == $_order) ? 'asc' : 'desc';
		} else if ( isset( $_GET['stream_orderby'] ) && 'hidden' == $_GET['stream_orderby'] ) {
			$hidden_order = ('descget_stream_dashboard_table_row' == $_order) ? 'asc' : 'desc';
		}

		self::$order = $_order;
		self::$orderby = $orderby;
		usort( $websites, array( 'MainWP_CReport_Stream', 'stream_data_sort' ) );
		?>
        <table id="mainwp-table-plugins" class="wp-list-table widefat plugins" cellspacing="0">
            <thead>
                <tr>
                    <th class="check-column">
                        <input type="checkbox"  id="cb-select-all-1" >
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=name&stream_order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Site', 'mainwp-client-reports-extension' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $url_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=url&stream_order=<?php echo (empty( $url_order ) ? 'asc' : $url_order); ?>"><span><?php _e( 'URL', 'mainwp-client-reports-extension' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $version_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=version&stream_order=<?php echo (empty( $version_order ) ? 'asc' : $version_order); ?>"><span><?php _e( 'Plugin Version', 'mainwp-client-reports-extension' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column <?php echo $hidden_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=hidden&stream_order=<?php echo (empty( $hidden_order ) ? 'asc' : $hidden_order); ?>"><span><?php _e( 'Plugin Hidden', 'mainwp-client-reports-extension' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="check-column">
                        <input type="checkbox"  id="cb-select-all-2" >
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=name&stream_order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Site', 'mainwp-client-reports-extension' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $url_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=url&stream_order=<?php echo (empty( $url_order ) ? 'asc' : $url_order); ?>"><span><?php _e( 'URL', 'mainwp-client-reports-extension' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $version_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=version&stream_order=<?php echo (empty( $version_order ) ? 'asc' : $version_order); ?>"><span><?php _e( 'Plugin Version', 'mainwp-client-reports-extension' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>     
					<th scope="col" class="manage-column <?php echo $hidden_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=hidden&stream_order=<?php echo (empty( $hidden_order ) ? 'asc' : $hidden_order); ?>"><span><?php _e( 'Plugin Hidden', 'mainwp-client-reports-extension' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                </tr>
            </tfoot>
            <tbody id="the-wp-stream-list" class="list:sites">
				<?php
				if ( is_array( $websites ) && count( $websites ) > 0 ) {
					self::get_stream_dashboard_table_row( $websites );
				} else {
					_e( '<tr><td colspan="6">No websites were found with the Stream plugin installed.</td></tr>' );
				}
				?>
            </tbody>
        </table>
		<?php
	}

	public static function get_stream_dashboard_table_row( $websites ) {
		$dismiss = array();
		if ( session_id() == '' ) {
			session_start(); }
		if ( isset( $_SESSION['mainwp_creport_dismiss_upgrade_stream_notis'] ) ) {
			$dismiss = $_SESSION['mainwp_creport_dismiss_upgrade_stream_notis'];
		}

		if ( ! is_array( $dismiss ) ) {
			$dismiss = array(); }

		$url_loader = plugins_url( 'images/loader.gif', dirname( __FILE__ ) );

		foreach ( $websites as $website ) {
			$website_id = $website['id'];
			$template_title = empty( $website['template_title'] ) ? '&nbsp;' : $website['template_title'];
			$cls_active = (isset( $website['the_plugin_activated'] ) && ! empty( $website['the_plugin_activated'] )) ? 'active' : 'inactive';
			$cls_update = (isset( $website['stream_upgrade'] )) ? 'update' : '';
			$cls_update = ('inactive' == $cls_active) ? 'update' : $cls_update;
			$showhide_action = (1 == $website['hide_stream']) ? 'show' : 'hide';
			$is_stream = $website['is_stream'] ? true : false;
			if ( $is_stream ) {
				if ( 'show' === $showhide_action ) {
					$showhide_title = __( 'Show Stream plugin', 'mainwp-client-reports-extension' );
				} else {
					$showhide_title = __( 'Hide Stream plugin', 'mainwp-client-reports-extension' ); }
				$openlink_title = __( 'Open Stream', 'mainwp-client-reports-extension' );
				$location = 'admin.php?page=wp_stream';
			} else {
				if ( 'show' === $showhide_action ) {
					$showhide_title = __( 'Show MainWP Child Reports plugin', 'mainwp-client-reports-extension' );
				} else {
					$showhide_title = __( 'Hide MainWP Child Reports plugin', 'mainwp-client-reports-extension' ); }
				$openlink_title = __( 'Open MainWP Child Reports', 'mainwp-client-reports-extension' );
				$location = 'admin.php?page=mainwp_wp_stream';
			}

			$showhide_link = '<a href="#" class="creport_showhide_plugin" showhide="' . $showhide_action . '">' . $showhide_title . '</a>';
			?>
			<tr class="<?php echo $cls_active . ' ' . $cls_update; ?>" website-id="<?php echo $website_id; ?>" is-stream="<?php echo ($is_stream ? 1 : 0); ?>">
                <th class="check-column">
                    <input type="checkbox"  name="checked[]">
                </th>
                <td>
					<a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><?php echo stripslashes( $website['name'] ); ?></a><br/>
					<div class="row-actions"><span class="dashboard"><a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><?php _e( 'Dashboard' ); ?></a></span> |  <span class="edit"><a href="admin.php?page=managesites&id=<?php echo $website_id; ?>"><?php _e( 'Edit' ); ?></a> | <?php echo $showhide_link; ?></span></div>                    
					<div class="creport-action-working"><span class="status" style="display:none;"></span><span class="loading" style="display:none;"><img src="<?php echo $url_loader; ?>"> <?php _e( 'Please wait...', 'mainwp-client-reports-extension' ); ?></span></div>
                </td>
                <td>
					<a href="<?php echo $website['url']; ?>" target="_blank"><?php echo $website['url']; ?></a><br/>
					<div class="row-actions"><span class="edit"><a target="_blank" href="admin.php?page=SiteOpen&newWindow=yes&websiteid=<?php echo $website_id; ?>"><?php _e( 'Open WP-Admin', 'mainwp-client-reports-extension' ); ?></a></span> | <span class="edit"><a href="admin.php?page=SiteOpen&newWindow=yes&websiteid=<?php echo $website_id; ?>&location=<?php echo base64_encode( $location ); ?>" target="_blank"><?php echo $openlink_title; ?></a></span></div>                    
                </td>
                <td>
					<?php
					if ( isset( $website['stream_plugin_version'] ) ) {
						echo $website['stream_plugin_version']; } else {
						echo '&nbsp;'; }
					?>
                </td>     
                <td>
					<span class="stream_hidden_title"><?php
						echo (1 == $website['hide_stream']) ? __( 'Yes' ) : __( 'No' );
						?>
                    </span>
                </td>
            </tr>        
			<?php
			if ( ! isset( $dismiss[ $website_id ] ) ) {
				$active_link = $update_link = '';
				$version = '';
				if ( $is_stream ) {
					$plugin_slug = 'stream/stream.php';
				} else {
					$plugin_slug = 'mainwp-child-reports/mainwp-child-reports.php'; }

				if ( isset( $website['the_plugin_activated'] ) && empty( $website['the_plugin_activated'] ) ) {
					$active_link = '<a href="#" class="creport_active_plugin" >' . ($is_stream ? __( 'Activate Stream plugin', 'mainwp-client-reports-extension' ) : __( 'Activate MainWP Child Reports plugin', 'mainwp-client-reports-extension' )) . '</a>';
				}

				if ( isset( $website['reports_upgrade'] ) ) {
					if ( isset( $website['reports_upgrade']['new_version'] ) ) {
						$version = $website['reports_upgrade']['new_version']; }
					$update_link = '<a href="#" class="creport_upgrade_plugin" >' . __( 'Update MainWP Child Reports plugin', 'mainwp-client-reports-extension' ) . '</a>';
				} else if ( isset( $website['stream_upgrade'] ) ) {
					if ( isset( $website['stream_upgrade']['new_version'] ) ) {
						$version = $website['stream_upgrade']['new_version']; }
					$update_link = '<a href="#" class="creport_upgrade_plugin" >' . __( 'Update Stream plugin', 'mainwp-client-reports-extension' ) . '</a>';
				}

				if ( ! empty( $active_link ) || ! empty( $update_link ) ) {
					$location = 'plugins.php';
					$link_row = $active_link . ' | ' . $update_link;
					$link_row = rtrim( $link_row, ' | ' );
					$link_row = ltrim( $link_row, ' | ' );
					?>
					<tr class="plugin-update-tr" is-stream="<?php echo ($is_stream ? 1 : 0); ?>">
                        <td colspan="6" class="plugin-update">
							<div class="ext-upgrade-noti update-message" plugin-slug="<?php echo $plugin_slug; ?>" website-id="<?php echo $website_id; ?>" version="<?php echo $version; ?>">
								<span style="float:right"><a href="#" class="creport-stream-upgrade-noti-dismiss"><?php _e( 'Dismiss' ); ?></a></span>                    
								<?php echo $link_row; ?>
								<span class="creport-stream-row-working"><span class="status"></span><img class="hidden-field" src="<?php echo plugins_url( 'images/loader.gif', dirname( __FILE__ ) ); ?>"/></span>
                            </div>
                        </td>
                    </tr>
					<?php
				}
			}
		}
	}

	public static function stream_data_sort( $a, $b ) {
		if ( 'version' == self::$orderby ) {
			$a = $a['stream_plugin_version'];
			$b = $b['stream_plugin_version'];
			$cmp = version_compare( $a, $b );
		} else if ( 'url' == self::$orderby ) {
			$a = $a['url'];
			$b = $b['url'];
			$cmp = strcmp( $a, $b );
		} else if ( 'hidden' == self::$orderby ) {
			$a = $a['hide_stream'];
			$b = $b['hide_stream'];
			$cmp = $a - $b;
		} else {
			$a = $a['name'];
			$b = $b['name'];
			$cmp = strcmp( $a, $b );
		}
		if ( 0 == $cmp ) {
			return 0; }

		if ( 'desc' == self::$order ) {
			return ($cmp > 0) ? -1 : 1; } else {
			return ($cmp > 0) ? 1 : -1; }
	}

	public function get_websites_stream( $websites, $selected_group = 0 ) {
		$websites_stream = array();

		$streamHide = $this->get_option( 'hide_stream_plugin' );

		if ( ! is_array( $streamHide ) ) {
			$streamHide = array(); }

		if ( is_array( $websites ) && count( $websites ) ) {
			if ( empty( $selected_group ) ) {
				foreach ( $websites as $website ) {
					if ( $website && $website->plugins != '' ) {
						$plugins = json_decode( $website->plugins, 1 );
						if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
							$is_stream = false;
							foreach ( $plugins as $plugin ) {
								if ( 'stream/stream.php' == $plugin['slug'] || 'mainwp-child-reports/mainwp-child-reports.php' == $plugin['slug'] ) {
									if ( 'stream/stream.php' == $plugin['slug'] ) {
										$is_stream = true; }
									$site = MainWP_CReport_Utility::map_site( $website, array( 'id', 'name', 'url' ) );
									if ( $plugin['active'] ) {
										$site['the_plugin_activated'] = 1; } else {
										$site['the_plugin_activated'] = 0; }
										// get upgrade info
										$site['stream_plugin_version'] = $plugin['version'];
										$plugin_upgrades = json_decode( $website->plugin_upgrades, 1 );
										if ( is_array( $plugin_upgrades ) && count( $plugin_upgrades ) > 0 ) {
											if ( ! $is_stream && isset( $plugin_upgrades['mainwp-child-reports/mainwp-child-reports.php'] ) ) {
												$upgrade = $plugin_upgrades['mainwp-child-reports/mainwp-child-reports.php'];
												if ( isset( $upgrade['update'] ) ) {
													$site['reports_upgrade'] = $upgrade['update'];
												}
											} else if ( $is_stream && isset( $plugin_upgrades['stream/stream.php'] ) ) {
												$upgrade = $plugin_upgrades['stream/stream.php'];
												if ( isset( $upgrade['update'] ) ) {
													$site['stream_upgrade'] = $upgrade['update'];
												}
											}
										}

										$site['hide_stream'] = 0;
										$site['is_stream'] = $is_stream;
										if ( isset( $streamHide[ $website->id ] ) && $streamHide[ $website->id ] ) {
											$site['hide_stream'] = 1;
										}
										$websites_stream[] = $site;
										break;
								}
							}
						}
					}
				}
			} else {
				global $mainWPCReportExtensionActivator;

				$group_websites = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), array(), array( $selected_group ) );
				$sites = array();
				foreach ( $group_websites as $site ) {
					$sites[] = $site->id;
				}
				foreach ( $websites as $website ) {
					if ( $website && $website->plugins != '' && in_array( $website->id, $sites ) ) {
						$plugins = json_decode( $website->plugins, 1 );
						if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
							foreach ( $plugins as $plugin ) {
								if ( 'stream/stream.php' == $plugin['slug'] || false !== strpos( $plugin['slug'], '/stream.php' ) ) {
									$site = MainWP_CReport_Utility::map_site( $website, array( 'id', 'name', 'url' ) );
									if ( $plugin['active'] ) {
										$site['the_plugin_activated'] = 1; } else {
										$site['the_plugin_activated'] = 0; }
										$site['stream_plugin_version'] = $plugin['version'];

										// get upgrade info
										$plugin_upgrades = json_decode( $website->plugin_upgrades, 1 );
										if ( is_array( $plugin_upgrades ) && count( $plugin_upgrades ) > 0 ) {
											if ( isset( $plugin_upgrades['mainwp-child-reports/mainwp-child-reports.php'] ) ) {
												$upgrade = $plugin_upgrades['mainwp-child-reports/mainwp-child-reports.php'];
												if ( isset( $upgrade['update'] ) ) {
													$site['reports_upgrade'] = $upgrade['update'];
												}
											}
											if ( isset( $plugin_upgrades['stream/stream.php'] ) ) {
												$upgrade = $plugin_upgrades['stream/stream.php'];
												if ( isset( $upgrade['update'] ) ) {
													$site['stream_upgrade'] = $upgrade['update'];
												}
											}
										}

										$site['hide_stream'] = 0;
										if ( isset( $streamHide[ $website->id ] ) && $streamHide[ $website->id ] ) {
											$site['hide_stream'] = 1;
										}
										$websites_stream[] = $site;
										break;
								}
							}
						}
					}
				}
			}
		}

		// if search action
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

	public static function gen_select_sites( $websites, $selected_group ) {
		global $mainWPCReportExtensionActivator;
		//$websites = apply_filters('mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), null);
		$groups = apply_filters( 'mainwp-getgroups', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), null );
		$search = (isset( $_GET['s'] ) && ! empty( $_GET['s'] )) ? trim( $_GET['s'] ) : '';
		?> 

        <div class="alignleft actions bulkactions">
            <select id="creport_stream_action">
				<option selected="selected" value="-1"><?php _e( 'Bulk Actions', 'mainwp-client-reports-extension' ); ?></option>
				<option value="activate-selected"><?php _e( 'Active' ); ?></option>
				<option value="update-selected"><?php _e( 'Update' ); ?></option>
				<option value="hide-selected"><?php _e( 'Hide' ); ?></option>
				<option value="show-selected"><?php _e( 'Show' ); ?></option>
            </select>
			<input type="button" value="<?php _e( 'Apply' ); ?>" class="button action" id="creport_stream_doaction_btn" name="">
        </div>

        <div class="alignleft actions">
            <form action="" method="GET">
                <input type="hidden" name="page" value="Extensions-Mainwp-Client-Reports-Extension">
				<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"><?php _e( 'No search results.', 'mainwp-client-reports-extension' ); ?></span>
				<input type="text" class="mainwp_autocomplete ui-autocomplete-input" name="s" autocompletelist="sites" value="<?php echo stripslashes( $search ); ?>" autocomplete="off">
                <datalist id="sites">
					<?php
					if ( is_array( $websites ) && count( $websites ) > 0 ) {
						foreach ( $websites as $website ) {
							echo '<option>' . stripslashes( $website['name'] ) . '</option>';
						}
					}
					?>                
                </datalist>
                <input type="submit" name="" class="button" value="Search Sites">
            </form>
        </div>    
        <div class="alignleft actions">
            <form method="post" action="admin.php?page=Extensions-Mainwp-Client-Reports-Extension">
                <select name="mainwp_creport_stream_groups_select">
					<option value="0"><?php _e( 'Select a group', 'mainwp-client-reports-extension' ); ?></option>
					<?php
					if ( is_array( $groups ) && count( $groups ) > 0 ) {
						foreach ( $groups as $group ) {
							$_select = '';
							if ( $selected_group == $group['id'] ) {
								$_select = 'selected '; }
							echo '<option value="' . $group['id'] . '" ' . $_select . '>' . $group['name'] . '</option>';
						}
					}
					?>
                </select>&nbsp;&nbsp;                     
				<input class="button" type="button" name="creport_stream_btn_display" id="creport_stream_btn_display"value="<?php _e( 'Display', 'mainwp-client-reports-extension' ); ?>">
            </form>  
        </div>    
		<?php
		return;
	}

	public function ajax_dismiss_notice() {
		$website_id = $_POST['siteId'];
		$version = $_POST['new_version'];
		if ( $website_id ) {
			session_start();
			$dismiss = $_SESSION['mainwp_creport_dismiss_upgrade_stream_notis'];
			if ( is_array( $dismiss ) && count( $dismiss ) > 0 ) {
				$dismiss[ $website_id ] = 1;
			} else {
				$dismiss = array();
				$dismiss[ $website_id ] = 1;
			}
			$_SESSION['mainwp_creport_dismiss_upgrade_stream_notis'] = $dismiss;
			die( 'updated' );
		}
		die( 'nochange' );
	}

	public function ajax_active_plugin() {
		do_action( 'mainwp_activePlugin' );
		die();
	}

	public function ajax_upgrade_plugin() {
		do_action( 'mainwp_upgradePluginTheme' );
		die();
	}

	public function ajax_showhide_stream() {

		$siteid = isset( $_POST['websiteId'] ) ? $_POST['websiteId'] : null;
		$showhide = isset( $_POST['showhide'] ) ? $_POST['showhide'] : null;
		if ( null !== $siteid && null !== $showhide ) {
			global $mainWPCReportExtensionActivator;
			$post_data = array(
			'mwp_action' => 'set_showhide',
				'showhide' => $showhide,
			);
			$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $siteid, 'client_report', $post_data );

			if ( is_array( $information ) && isset( $information['result'] ) && 'SUCCESS' === $information['result'] ) {
				$hide_stream = $this->get_option( 'hide_stream_plugin' );
				if ( ! is_array( $hide_stream ) ) {
					$hide_stream = array(); }
				$hide_stream[ $siteid ] = ('hide' === $showhide) ? 1 : 0;
				$this->set_option( 'hide_stream_plugin', $hide_stream );
			}

			die( json_encode( $information ) );
		}
		die();
	}
}
