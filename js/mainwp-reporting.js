jQuery( document ).ready(function ($) {

	jQuery( '.mainwp_creport_datepicker' ).datepicker( {dateFormat: "yy-mm-dd"} );

	$( '#wpcr_report_tab_lnk' ).on('click', function () {             
            return showCReportTab( this, true, false, false, false, false, false );		
	});

	$( '#wpcr_edit_tab_lnk' ).on('click', function () {               
            return showCReportTab( this, false, true, false, false, false, false );		
	});

	$( '#wpcr_token_tab_lnk' ).on('click', function () {               
            return showCReportTab( this, false, false, true, false, false, false );
	});

	$( '#wpcr_stream_tab_lnk' ).on('click', function () {              
            return showCReportTab( this, false, false, false, true, false, false );		
	});

	$( '#wpcr_edit_global_tab_lnk' ).on('click', function () {               
            return showCReportTab( this, false, false, false, false, true, false );		
	});
        
	$( '#mainwp_creport_schedule_send_email_auto' ).change(function () {
		if ($( this ).is( ':checked' )) {
			$( '#mainwp_creport_schedule_bbc_me_email' ).removeAttr( "disabled" );
		} else {
			$( '#mainwp_creport_schedule_bbc_me_email' ).attr( "disabled", "disabled" );
			$( '#mainwp_creport_schedule_bbc_me_email' ).removeAttr( "checked" );
		}
	});

	$( '#mainwp_creport_type' ).change(function () {
                if ( $( this ).val() == 1 ) {                        
                    $( '#mwp_creport_settings_tbl' ).addClass('scheduled_creport');			
                    $( '#mwp-creport-send-btn' ).hide();   
                    $( '#mwp-creport-schedule-btn' ).show();
		} else {
                    $( '#mwp_creport_settings_tbl' ).removeClass('scheduled_creport');			
                    $( '#mwp-creport-send-btn' ).show();   
                    $( '#mwp-creport-schedule-btn' ).hide();
		}                
	});
        
        $( '#mainwp_creport_recurring_schedule' ).change(function () {
            var val = $( this ).val();
            $( '.show_if_monthly' ).hide();
            if ( val == 'weekly' || val == 'monthly' || val == 'yearly' ) {                      
                if (val == 'weekly') {
                    $( '#scheduled_send_on_day_of_week_wrap' ).show(); 
                    $( '#scheduled_send_on_day_of_month_wrap' ).hide();
                    $( '#scheduled_send_on_month_wrap' ).hide();
                } else if (val == 'monthly') {
                    $( '#scheduled_send_on_day_of_week_wrap' ).hide(); 
                    $( '#scheduled_send_on_day_of_month_wrap' ).show();                     
                    $( '#scheduled_send_on_month_wrap' ).hide();                    
                    $( '.show_if_monthly' ).show();                    
                } else {
                    $( '#scheduled_send_on_day_of_week_wrap' ).hide(); 
                    $( '#scheduled_send_on_day_of_month_wrap' ).show();
                    $( '#scheduled_send_on_month_wrap' ).show();
                }
                $( '#mainwp_creport_send_on_wrap' ).show();                
            } else {                    			
                $( '#mainwp_creport_send_on_wrap' ).hide();
            }
            mainwp_creport_recurring_select_date_init();
	});
        
        
        $( '#mainwp_creport_schedule_month' ).change(function () {
            mainwp_creport_recurring_select_date_init();             
	});        
        
        $( '#mainwp_creport_schedule_send_email_me_review' ).change(function () {
		if ($( this ).is( ':checked' )) {
			$( '#mainwp_creport_schedule_bbc_me_email' ).attr( "disabled", "disabled" );
			$( '#mainwp_creport_schedule_bbc_me_email' ).removeAttr( "checked" );

		} else {
			$( '#mainwp_creport_schedule_bbc_me_email' ).removeAttr( "disabled" );
		}
	});

	$( '#creport_managetoken_btn_add_token' ).live('click', function ()
		{
		var parent = jQuery( this ).parents( '.managetoken-item' );
		$( '#mwp-creport-error-box' ).hide();
		$( '#mwp-creport-info-box' ).hide();
		var errors = [];
		if (parent.find( 'input[name="token_name"]' ).val().trim() == '') {
			errors.push( __( 'Error: Token Name can not be empty.' ) ); }

		if (parent.find( 'input[name="token_description"]' ).val().trim() == '') {
			errors.push( __( 'Error: Token Description can not be empty.' ) ); }

		if (errors.length > 0) {
			$( '#mwp-creport-error-box' ).html( '<p>' + errors.join( '<br />' ) + '</p>' ).show();
			return false;
		}
		
                var fields = {
                    token_name: parent.find( 'input[name="token_name"]' ).val(),
                    token_description: parent.find( 'input[name="token_description"]' ).val(),
                    action: 'mainwp_creport_save_token',
                    nonce: mainwp_clientreport_loc.nonce
		};
                
		parent.find( '.mainwp_more_loading' ).show();
		$.post(ajaxurl, fields, function (response) {
			parent.find( '.mainwp_more_loading' ).hide();
			if (response) {
				if (response['success']) {
					$( '#mwp-creport-info-box' ).html( __( 'New Token added successfully.' ) ).show();
					parent.before( response['row_data'] );
					parent.find( 'input[type=text]' ).val( '' );
				} else {
					if (response['error']) {
						$( '#mwp-creport-error-box' ).html( '<p>' + response['error'] + '</p>' ).show(); } else {
						$( '#mwp-creport-error-box' ).html( '<p>Undefined Error.</p>' ).show(); }
				}
			} else {
				$( '#mwp-creport-error-box' ).html( '<p>' + __( 'Undefined Error.' ) + '</p>' ).show();
			}

		}, 'json');
		return false;
	});

	$( '.creport_managetoken-edit' ).live('click', function ()
		{
		var parent = jQuery( this ).closest( '.managetoken-item' );
		parent.find( '.text' ).hide();
		parent.find( '.actions-text' ).hide();
		parent.find( '.input' ).show();
		parent.find( '.actions-input' ).show();
		return false;
	});

	$( '.creport_managetoken-cancel' ).live('click', function ()
		{
		var parent = jQuery( this ).closest( '.managetoken-item' );
		parent.find( '.input' ).hide();
		parent.find( '.actions-input' ).hide();
		parent.find( '.token-name input[name=token_name]' ).val( parent.find( '.token-name span.text' ).attr( 'value' ) );
		parent.find( '.token-description input[name=token_description]' ).val( parent.find( '.token-description span.text' ).attr( 'value' ) );
		parent.find( '.text' ).show();
		parent.find( '.actions-text' ).show();
		return false;
	});

	$( '.creport_managetoken-save' ).live('click', function ()
		{
		var parent = jQuery( this ).closest( '.managetoken-item' );
		$( '#mwp-creport-error-box' ).hide();
		$( '#mwp-creport-info-box' ).hide();
		var errors = [];
		if (parent.find( 'input[name="token_name"]' ).val().trim() == '') {
			errors.push( __( 'Error: Token Name can not be empty.' ) ); }

		if (parent.find( 'input[name="token_description"]' ).val().trim() == '') {
			errors.push( __( 'Error: Token Description can not be empty.' ) ); }

		if (errors.length > 0) {
			$( '#mwp-creport-error-box' ).html( '<p>' + errors.join( '<br />' ) + '</p>' ).show();
			return false;
		}
		parent.find( '.mainwp_more_loading' ).show();
		var fields = {token_name: parent.find( 'input[name="token_name"]' ).val(),
			token_description: parent.find( 'input[name="token_description"]' ).val(),
			token_id: parent.attr( 'token_id' ),
			action: 'mainwp_creport_save_token',
                        nonce: mainwp_clientreport_loc.nonce
		};

		$.post(ajaxurl, fields, function (response) {
			parent.find( '.mainwp_more_loading' ).hide();
			if (response) {
				if (response['success']) {
					if (response['message']) {
						$( '#mwp-creport-info-box' ).html( response['message'] ).show(); } else {
						$( '#mwp-creport-info-box' ).html( __( 'Token has been updated successfully' ) ).show(); }
						parent.html( response['row_data'] );
				} else {
					if (response['error']) {
						$( '#mwp-creport-error-box' ).html( '<p>' + response['error'] + '</p>' ).show(); } else {
						$( '#mwp-creport-error-box' ).html( '<p>Undefined Error.</p>' ).show(); }
				}
			} else {
				$( '#mwp-creport-error-box' ).html( '<p>' + __( 'Undefined Error.' ) + '</p>' ).show();
			}

		}, 'json');

		return false;
	});

	$( '.creport_managetoken-delete' ).live('click', function () {
		$( '#mwp-creport-error-box' ).hide();
		$( '#mwp-creport-info-box' ).hide();
		if (confirm( __( 'Are you sure?' ) )) {
			var parent = $( this ).closest( '.managetoken-item' );
			parent.find( '.mainwp_more_loading' ).show();
			jQuery.post(ajaxurl, {
				action: 'mainwp_creport_delete_token',
				token_id: parent.attr( 'token_id' ),
                                nonce: mainwp_clientreport_loc.nonce
				}, function (data) {
					parent.find( '.mainwp_more_loading' ).hide();
					if (data && data.success) {
						parent.html( '<td><span class="text">' + __( 'Token has been deleted successfully.' ) + '</span></td>' ).fadeOut( 2000 );
					} else {
						jQuery( '#mwp-creport-info-box' ).html( __( 'Token can not be deleted.' ) ).show();
					}
				}, 'json');
			return false;
		}
		return false;
	});

	$( '.creport_nav_group_lnk' ).on('click', function () {
		var parent = $( this ).closest( '.creport_format_insert_tokens_box' );
		var gr = $( this ).attr( 'group' );
		var gr_title = $( this ).attr( 'group-title' );
		parent.find( '.creport_nav_group_lnk' ).removeClass( 'current' );
		$( this ).addClass( 'current' );
		if ($( this ).hasClass( 'disabled' )) {
			parent.find( '.creport_format_group_data_tokens' ).removeClass( 'current' );
			parent.find( '.creport_format_group_data_tokens[group="' + gr + '"]' ).addClass( 'current' );
			parent.find( '.creport_format_group_nav.bottom' ).removeClass( 'current' );
			mainwp_creport_insert_token_set_breadcrumb( parent, gr_title, '' );
			return false;
		}

//		var gr2 = '';
//		var gr2_title = '';
//		if (gr == 'client') {
//			gr2 = 'tokens';			
//		} else {
                    gr2 = $( this ).attr( 'first-group' );;
                    gr2_title = $( this ).attr( 'first-title' );
//		}

		parent.find( '.creport_format_group_data_tokens' ).removeClass( 'current' );
		parent.find( '.creport_format_group_data_tokens[group="' + gr + '_' + gr2 + '"]' ).addClass( 'current' );
		parent.find( '.creport_format_group_nav.bottom' ).removeClass( 'current' );
		parent.find( '.creport_format_group_nav.bottom[group="' + gr + '"]' ).addClass( 'current' );
		parent.find( '.creport_nav_bottom_group_lnk' ).removeClass( 'current' );
		parent.find( '.creport_nav_bottom_group_lnk[group="' + gr + '_' + gr2 + '"]' ).addClass( 'current' );
		mainwp_creport_insert_token_set_breadcrumb( parent, gr_title, gr2_title );
		return false;
	})

	$( '.creport_nav_bottom_group_lnk ' ).on('click', function () {
		var parent = $( this ).closest( '.creport_format_insert_tokens_box' );
		var gr = $( this ).attr( 'group' );
		var gr_title = $( this ).attr( 'group-title' );
		var gr2_title = $( this ).attr( 'group2-title' );
		parent.find( '.creport_nav_bottom_group_lnk' ).removeClass( 'current' );
		$( this ).addClass( 'current' );
		parent.find( '.creport_format_group_data_tokens' ).removeClass( 'current' );
		parent.find( '.creport_format_group_data_tokens[group="' + gr + '"]' ).addClass( 'current' );
		mainwp_creport_insert_token_set_breadcrumb( parent, gr_title, gr2_title );
		return false;
	})

	mainwp_creport_insert_token_set_breadcrumb = function (parent, group, group2) {
		parent.find( '.creport_format_nav_bottom_breadcrumb .group' ).text( group );
		if (group2 == '') {
			parent.find( '.creport_format_nav_bottom_breadcrumb .crp_content_group2' ).hide();
		} else {
			parent.find( '.creport_format_nav_bottom_breadcrumb .group2' ).text( group2 );
			parent.find( '.creport_format_nav_bottom_breadcrumb .crp_content_group2' ).show();
		}
	}

	$( '.mainwp_creport_show_insert_tokens_book_lnk' ).on('click', function () {
		var box = $( this ).closest( 'tr' ).find( '.creport_format_insert_tokens_box' );
		if (box.hasClass( 'hidden-field' )) {
			box.removeClass( 'hidden-field' );
			$( this ).text( __( "Hide Available Tokens" ) );
		} else {
			box.addClass( 'hidden-field' );
			$( this ).text( __( "Show Available Tokens" ) );
		}
		return false;
	})

	$( 'a.creport_format_add_token' ).live('click', function (e) {
		var parent = $( this ).closest( '.creport_format_insert_tokens_box' );
		var replace_text = jQuery( this ).html();
		//        var token_value = jQuery(this).attr('token-value');
		//        if (token_value !== '')
		//            replace_text = token_value;
		var name = parent.attr( 'editor' );
		var editor = tinyMCE.get( 'mainwp_creport_report_' + name );
		var set_new_pos = replace_text.length;
		if (editor != null && typeof (editor) !== "undefined" && editor.isHidden() == false) {
			if (replace_text.indexOf( "[section." ) !== -1) {
				var end_section = replace_text.replace( "[section.", "[/section." );
				replace_text = replace_text + '<br/><span id="crp_ed_cursor"></span><br/>' + end_section;
			}
			editor.execCommand( 'mceInsertContent', false, replace_text );
			var cursor = editor.dom.select( 'span#crp_ed_cursor' );
			if (cursor != null && typeof (cursor[0]) !== "undefined") {
				editor.selection.select( cursor[0] ).remove();
			}
		} else {
			if (replace_text.indexOf( "[section." ) !== -1) {
				var end_section = replace_text.replace( "[section.", "[/section." );
				set_new_pos++;
				replace_text = replace_text + '\n\n' + end_section;
			}
			var obj = $( '#mainwp_creport_report_' + name );
			var str = obj.val();
			var pos = creport_getPos( obj[0] );
			str = str.substring( 0, pos ) + replace_text + str.substring( pos, str.length )
			obj.val( str );
			set_new_pos += pos;
			creport_setPos( obj[0], set_new_pos, set_new_pos );
		}
		return false;
	});

	function creport_getPos(obj) {
		var pos = 0;	// IE Support
		if (document.selection) {
			obj.focus();
			var range = document.selection.createRange();
			range.moveStart( 'character', -obj.value.length );
			pos = range.text.length;
		} // Firefox support
		else if (obj.selectionStart || obj.selectionStart == '0') {
			pos = obj.selectionStart; }
		return (pos);
	}

	function creport_setPos(obj, selectionStart, selectionEnd) {
		if (document.selection) {
			obj.focus();
			var range = document.selection.createRange();
			range.collapse( true );
			range.moveEnd( 'character', selectionEnd );
			range.moveStart( 'character', selectionStart );
			range.select();
		} // Firefox support
		else {
			obj.focus();
			obj.setSelectionRange( selectionStart, selectionEnd );
		}
	}
        
	$( '.creport_action_row_lnk' ).on('click', function () {
                var actionObj = jQuery(this).closest('.row-actions');
                var what = jQuery(this).attr('action');
                mainwp_creport_do_action_start_specific(actionObj, what, false);		
		return false;
	});

	mainwp_creport_valid_report_data = function (action) {
		$( '#mwp_creport_title' ).removeClass( 'form-invalid' );
		$( '#mwp_creport_date_from' ).removeClass( 'form-invalid' );
		$( '#mwp_creport_date_to' ).removeClass( 'form-invalid' );
		$( '#selected_sites' ).removeClass( 'form-invalid' );
		$( '#mwp_creport_email' ).removeClass( 'form-invalid' );
                $( '#mwp_creport_femail' ).removeClass( 'form-invalid' );
		$( '#mainwp_creport_recurring_schedule' ).removeClass( 'form-invalid' );

		var errors = [];
		var selected_sites = [];
		var selected_groups = [];

		if ($.trim( $( '#mwp_creport_title' ).val() ) == '') {
			errors.push( __( 'Title is required.' ) );
			$( '#mwp_creport_title' ).addClass( 'form-invalid' );
		}

		if (action !== 'save') {
                        
                        if ($( '#mainwp_creport_type' ).val() == 0) {
                            if ($.trim( $( '#mwp_creport_date_from' ).val() ) == '') {
                                    errors.push( __( 'Date From is required.' ) );
                                    $( '#mwp_creport_date_from' ).addClass( 'form-invalid' );
                            }

                            if ($.trim( $( '#mwp_creport_date_to' ).val() ) == '') {
                                    errors.push( __( 'Date To is required.' ) );
                                    $( '#mwp_creport_date_to' ).addClass( 'form-invalid' );
                            }
                        }
			
                        if (jQuery( '#select_by' ).val() == 'site') {
                                jQuery( "input[name='selected_sites[]']:checked" ).each(function (i) {
                                        selected_sites.push( jQuery( this ).val() );
                                });
                                if (selected_sites.length == 0) {
                                        errors.push( __( 'Please select websites or groups.' ) );
                                        $( '#selected_sites' ).addClass( 'form-invalid' );
                                }
                        } else {
                                jQuery( "input[name='selected_groups[]']:checked" ).each(function (i) {
                                        selected_groups.push( jQuery( this ).val() );
                                });
                                if (selected_groups.length == 0) {
                                        errors.push( __( 'Please select websites or groups.' ) );
                                        $( '#selected_sites' ).addClass( 'form-invalid' );
                                }
                        }
			
                        
		}
                
		if (action == 'schedule') {
			if ($.trim( $( '#mainwp_creport_recurring_schedule :selected' ).val() ) == '') {
				errors.push( __( 'Recurring Schedule is required.' ) );
				$( '#mainwp_creport_recurring_schedule' ).addClass( 'form-invalid' );
			}
		}

		if (action == 'sendreport' || action == 'save') {
                        if ($.trim( $( '#mwp_creport_femail' ).val() ) == '') {
                                errors.push( __( 'Send From email is required.' ) );
                                $( '#mwp_creport_femail' ).addClass( 'form-invalid' );
                        }
                
			if ($.trim( $( '#mwp_creport_email' ).val() ) == '') {
				errors.push( __( 'Send To email is required.' ) );
				$( '#mwp_creport_email' ).addClass( 'form-invalid' );
			}
		}

		if (errors.length > 0) {
			show_error( 'mwp-creport-error-box', errors.join( '<br />' ) );
			return false;
		} else {
			jQuery( '#mwp-creport-error-box' ).html( "" );
			jQuery( '#mwp-creport-error-box' ).hide();
		}
		return true;
	}

	$( '#mwp-creport-send-btn' ).on('click', function () {
		if (mainwp_creport_valid_report_data( 'sendreport' ) === false) {
                    return false; 
                }
		if ( ! confirm( "Are you sure?" )) {
			return false; 
                }
		$( '#mwp_creport_report_submit_action' ).val( 'sendreport' );
	});
        
        $( '#mwp-creport-schedule-btn' ).live('click', function () {
		if (mainwp_creport_valid_report_data( 'schedule' ) === false) {
			return false; 
                }
		$( '#mwp_creport_report_submit_action' ).val( 'save' );
	});
               
	$( '#mwp-creport-preview-btn' ).on('click', function () {
		if (mainwp_creport_valid_report_data() === false) {
			return false; 
                }
		$( '#mwp_creport_report_submit_action' ).val( 'preview' );
	});

	$( '#mwp-creport-send-test-email-btn' ).on('click', function () {
		if (mainwp_creport_valid_report_data() === false) {
			return false; }
		$( '#mwp_creport_report_submit_action' ).val( 'send_test_email' );
	});

	$( '#mwp-creport-save-btn' ).live('click', function () {
		if (mainwp_creport_valid_report_data( 'save' ) === false) {
			return false; }
		$( '#mwp_creport_report_submit_action' ).val( 'save' );
	});


	$( '#mwp-creport-save-pdf-btn' ).live('click', function () {
		if (mainwp_creport_valid_report_data() === false) {
			return false; 
                }
		$( '#mwp_creport_report_submit_action' ).val( 'save_pdf' );
	});

	$( '#mwp-creport-archive-report-btn' ).on('click', function () {
		if (mainwp_creport_valid_report_data() === false) {
			return false; }
		$( '#mwp_creport_report_submit_action' ).val( 'archive_report' );
	});

        $( '#mwp-creport-unarchive-report-btn' ).on('click', function () {
                $( '#mwp_creport_report_submit_action' ).val( 'unarchive_report' );		
	});
        
	$( '#mwp-creport-preview-btn-close' ).on('click', function () {
		jQuery( '#mwp-creport-preview-box' ).dialog( 'destroy' );
	})

	$( '#mwp-creport-preview-btn-send' ).on('click', function () {
		jQuery( '#mwp-creport-preview-box' ).dialog( 'destroy' );
		jQuery( '#mwp-creport-send-btn' ).click();
	})

	$( '#mainwp_creport_select_client_btn_display' ).on('click', function () {
		var client = $( '#mainwp_creport_select_client' ).val();
		location.href = 'admin.php?page=Extensions-Mainwp-Client-Reports-Extension&client=' + client;
	})

	$( '#mainwp_creport_select_site_btn_display' ).on('click', function () {
		var site = $( '#mainwp_creport_select_site' ).val();
		location.href = 'admin.php?page=Extensions-Mainwp-Client-Reports-Extension&site=' + site;
	})

	$( '#mwp_creport_edit_form .mainwp_selected_sites_item input[type="radio"]' ).on('click', function () {
		var site_Id = $( this ).attr( 'siteid' );
		var data = {
			action: 'mainwp_creport_load_site_tokens',
			siteId: site_Id,
                        nonce: mainwp_clientreport_loc.nonce
		}
                jQuery( '#mainwp_creport_client_loading i' ).show();
		$.post(ajaxurl, data, function (response) {
                        jQuery( '#mainwp_creport_client_loading i' ).hide();
			if (response && response !== 'EMPTY') {
				if (response.html_tokens) {
					$( '.creport_format_group_data_tokens[group="client_tokens"] table tbody' ).html( response.html_tokens );
					$( '.mwp_creport_edit_client_tokens' ).html( '<a href="admin.php?page=managesites&id=' + site_Id + '">' + __( "Edit Client Tokens" ) + '</a>' );
				}
				if (response.tokens) {
					$( 'input[name="mwp_creport_client"]' ).val( '' );
					$( 'input[name="mwp_creport_name"]' ).val( '' );
					$( 'input[name="mwp_creport_company"]' ).val( '' );
					$( 'input[name="mwp_creport_email"]' ).val( '' );
					$( 'input[name="mwp_creport_client_id"]' ).val( 0 );

					if (response.tokens['client.name']) {
						$( 'input[name="mwp_creport_client"]' ).val( response.tokens['client.name'] ); }
					if (response.tokens['client.contact.name']) {
						$( 'input[name="mwp_creport_name"]' ).val( response.tokens['client.contact.name'] ); }
					if (response.tokens['client.company']) {
						$( 'input[name="mwp_creport_company"]' ).val( response.tokens['client.company'] ); }
					if (response.tokens['client.email']) {
						$( 'input[name="mwp_creport_email"]' ).val( response.tokens['client.email'] ); }
				}
			}
		}, 'json');
	})

	mainwp_creport_set_show_format_section = function (linkObj, show) {
		var pr = linkObj.parent();
		var section = pr.attr( 'section' );
		if (show) {
			pr.removeClass( 'closed' );
			linkObj.text( __( "Hide" ) );
			pr.closest( 'tr' ).next( 'tr.mainwp_creport_format_section' ).show();
			mainwp_setCookie( 'mainwp_creport_showhide_section_' + section, 'show' );
		} else {
			pr.addClass( 'closed' );
			linkObj.text( __( "Show" ) );
			pr.closest( 'tr' ).next( 'tr.mainwp_creport_format_section' ).hide();
			mainwp_setCookie( 'mainwp_creport_showhide_section_' + section, '' );
		}
	}

	mainwp_creport_check_show_format_section = function () {
		var link_header = $( 'tr .mainwp_creport_format_section_header[section="header"] .handlelnk' );
		var link_body = $( 'tr .mainwp_creport_format_section_header[section="body"] .handlelnk' );
		var link_footer = $( 'tr .mainwp_creport_format_section_header[section="footer"] .handlelnk' );

		if (mainwp_getCookie( 'mainwp_creport_showhide_section_header' ) == 'show') {
			mainwp_creport_set_show_format_section( link_header, true );
		} else {
			mainwp_creport_set_show_format_section( link_header, false );
		}

		if (mainwp_getCookie( 'mainwp_creport_showhide_section_body' ) == 'show') {
			mainwp_creport_set_show_format_section( link_body, true );
		} else {
			mainwp_creport_set_show_format_section( link_body, false );
		}

		if (mainwp_getCookie( 'mainwp_creport_showhide_section_footer' ) == 'show') {
			mainwp_creport_set_show_format_section( link_footer, true );
		} else {
			mainwp_creport_set_show_format_section( link_footer, false );
		}
	}

	mainwp_creport_check_show_format_section();

	$( '.mainwp_creport_format_section_header .handlelnk' ).live('click', function () {
		var pr = $( this ).parent();
		if (pr.hasClass( 'closed' )) {
			mainwp_creport_set_show_format_section( $( this ), true );
		} else {
			mainwp_creport_set_show_format_section( $( this ), false );
		}
	});

	$( '.mainwp_creport_report_save_format_btn' ).on('click', function () {
		var pr = $( this ).closest( '.inner' );
		var titleEl = pr.find( 'input[type="text"]' );
		var statusEl = pr.find( '.status' );
		statusEl.hide();
		titleEl.removeClass( 'form-invalid' );

		if (titleEl.val() == "") {
			titleEl.addClass( 'form-invalid' );
			statusEl.css( 'color', 'red' );
			statusEl.html( 'Error' ).show();
			return false;
		}
		var content = creport_get_content_format( $( this ).attr( 'ed-name' ) );
		var data = {
			action: 'mainwp_creport_save_format',
			type: $( this ).attr( 'format' ),
			title: titleEl.val(),
			content: content,
                        nonce: mainwp_clientreport_loc.nonce
		}

		var loader = pr.find( '.loading i' );
		loader.show();
		$.post(ajaxurl, data, function (response) {
			loader.hide();
			if (response && response == 'success') {
				statusEl.css( 'color', '#21759B' );
				statusEl.html( 'Saved' ).show();
				statusEl.fadeOut( 3000 );
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Error' ).show();
			}
		})
		return false;
	});

	function creport_get_content_format(name) {
		var content = "";
		var editor_name = 'mainwp_creport_report_' + name;
		var editor = tinyMCE.get( editor_name );

		if (editor != null && typeof (editor) !== "undefined" && editor.isHidden() == false) {
			content = editor.getContent();
		} else {
			content = $( '#' + editor_name ).val();
		}
		return content;
	}

	$( '.mainwp_creport_report_delete_format_btn' ).on('click', function () {

		var pr = $( this ).closest( '.inner' );
		var selectEl = pr.find( 'select' );
		var statusEl = pr.find( '.status' );
		statusEl.hide();

		if (selectEl.val() == 0) {
			return false; }
		var content = creport_get_content_format( $( this ).attr( 'ed-name' ) );
		var fid = selectEl.val();
		if (fid == 0) {
			return false; }

		if ( ! confirm( "Are you sure?" )) {
			return false; }

		var data = {
			action: 'mainwp_creport_delete_format',
			formatId: fid,
                        nonce: mainwp_clientreport_loc.nonce
		}
		var name = $( this ).attr( 'ed-name' );
		var loader = pr.find( '.loading i' );
		loader.show();
		$.post(ajaxurl, data, function (response) {
			loader.hide();
			if (response && response['success']) {
				pr.find( 'select[name="mainwp_creport_report_insert_header_sle"] option[value="' + fid + '"]' ).remove();
				statusEl.css( 'color', '#21759B' );
				statusEl.html( 'Deleted' ).show();
				statusEl.fadeOut( 3000 );
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Error' ).show();
			}
		}, 'json')
		return false;

	});

	$( '.mainwp_creport_report_insert_format_btn' ).on('click', function () {
		var pr = $( this ).closest( '.inner' );
		var selectEl = pr.find( 'select' );
		var statusEl = pr.find( '.status' );
		statusEl.hide();

		if (selectEl.val() == 0) {
			return false; }
		var content = creport_get_content_format( $( this ).attr( 'ed-name' ) );
		var data = {
			action: 'mainwp_creport_get_format',
			formatId: selectEl.val(),
                        nonce: mainwp_clientreport_loc.nonce
		}
		var name = $( this ).attr( 'ed-name' );
		var loader = pr.find( '.loading i' );
		loader.show();
		$.post(ajaxurl, data, function (response) {
			loader.hide();
			if (response && response['success']) {
				creport_insert_content_format( name, response['content'] );
				statusEl.css( 'color', '#21759B' );
				statusEl.html( 'Inserted' ).show();
				statusEl.fadeOut( 3000 );
			} else {
				statusEl.css( 'color', 'red' );
				statusEl.html( 'Error' ).show();
			}
		}, 'json')
		return false;

	});

	function creport_insert_content_format(name, content) {
		var editor_name = 'mainwp_creport_report_' + name;
		var editor = tinyMCE.get( editor_name );
		if (editor != null && typeof (editor) !== "undefined" && editor.isHidden() == false) {
			content = content.replace( /\n/ig, "<br>" );
			editor.setContent( content );
		} else {
			$( '#' + editor_name ).val( content );
		}
		return true;
	}

	$( '#creport_stream_btn_display' ).live('click', function () {
		$( this ).closest( 'form' ).submit();
	});

	$( '.creport-stream-upgrade-noti-dismiss' ).live('click', function () {
		var parent = $( this ).closest( '.ext-upgrade-noti' );
		parent.hide();
		var data = {
			action: 'mainwp_creport_upgrade_noti_dismiss',
			siteId: parent.attr( 'id' ),
			new_version: parent.attr( 'version' ),
                        nonce: mainwp_clientreport_loc.nonce
		}
		jQuery.post(ajaxurl, data, function (response) {

		});
		return false;
	});

	$( '.creport_active_plugin' ).on('click', function () {
		mainwp_creport_stream_active_start_specific( $( this ), false );
		return false;
	});

	$( '.creport_upgrade_plugin' ).on('click', function () {
		mainwp_creport_stream_upgrade_start_specific( $( this ), false );
		return false;
	});

	$( '.creport_showhide_plugin' ).on('click', function () {
		mainwp_creport_stream_showhide_start_specific( $( this ), false );
		return false;
	});

	$( '#creport_stream_doaction_btn' ).on('click', function () {
		var bulk_act = $( '#creport_stream_action' ).val();
		mainwp_creport_do_bulk_action( bulk_act );
	});
        
        $( '#creport_global_bulk_ations_btn' ).on('click', function () {
                if ( ! confirm( "Are you sure?" )) {
                    return false; 
                }
		var bulk_act = $( '#creport_global_bulk_ations' ).val();
		mainwp_creport_table_do_bulk_action( bulk_act );
	});        
});

jQuery( document ).on('change', '#mainwp_creport_select_client', function ()
	{
	var clientId = jQuery( this ).val();
	if (clientId > 0) {
		jQuery( '#mainwp_cr_remove_client' ).show();
	} else {
		jQuery( '#mainwp_cr_remove_client' ).hide();
	}

});

jQuery( document ).ready(function ($) {
	$( '#mainwp_cr_remove_client' ).on('click', function () {
		var clientId = jQuery( '#mainwp_creport_select_client' ).val();
		if (clientId) {
			if ( ! confirm( "Are you sure?" )) {
				return false; }
			var data = {
				action: 'mainwp_creport_delete_client',
				client_id: clientId,
                                nonce: mainwp_clientreport_loc.nonce
			}
			var me = jQuery( this );
			var loadingEl = $( '.wpcr_report_tab_nav_action_working' ).find( 'i' );
			var statusEl = $( '.wpcr_report_tab_nav_action_working' ).find( '.status' );
			loadingEl.show();
			statusEl.hide();
			jQuery.post(ajaxurl, data, function (response) {
				loadingEl.hide();
				statusEl.css( 'color', '#21759B' );
				if (response == 'SUCCESS') {
					me.hide();
					$( '#mainwp_creport_select_client option:selected' ).remove();
					statusEl.html( "Client has been removed." ).show();
					setTimeout(function () {
						statusEl.fadeOut( 1000 );
					}, 2000);
				} else {
					//statusEl.css('color', 'red');
					statusEl.html( "Error: Client are not removed." ).show();
				}
			});

		}
		return false;
	});
})

mainwp_creport_recurring_select_date_init = function () {
    var recurring = jQuery('#mainwp_creport_recurring_schedule').val();
    var selected_month = jQuery('#mainwp_creport_schedule_month').val();        
    jQuery( '#mainwp_creport_schedule_day_of_month option').show(); // show all days of month
    if (recurring == 'yearly') {        
        if (selected_month == 2) { // Feb
            jQuery( '#mainwp_creport_schedule_day_of_month option').filter(function(){ return (this.value == 31 || this.value == 30 || this.value == 29); }).hide();
        } else if (selected_month == 4 || selected_month == 6 || selected_month == 9 || selected_month == 11 ) {
            jQuery( '#mainwp_creport_schedule_day_of_month option').filter(function(){ console.log(this.value); return (this.value == 31 ); }).hide();
        } 
    }
}
        

jQuery( document ).tooltip({
	items: ".mwp_creport_token_tooltip",
	track: true,
	content: function () {
		var element = jQuery( this );
		return element.parents( '.mwp_creport_tooltip_container' ).children( '.mwp_creport_tooltip_content' ).html();
	}
});


var creport_bulkMaxThreads = 3;
var creport_bulkTotalThreads = 0;
var creport_bulkCurrentThreads = 0;
var creport_bulkFinishedThreads = 0;

mainwp_creport_do_bulk_action = function (act) {
	var selector = '';
	switch (act) {
		case 'activate-selected':
			selector = '#the-wp-stream-list tr.plugin-update-tr .creport_active_plugin';
			jQuery( selector ).addClass( 'queue' );
			mainwp_creport_stream_active_start_next( selector );
			break;
		case 'update-selected':
			selector = '#the-wp-stream-list tr.plugin-update-tr .creport_upgrade_plugin';
			jQuery( selector ).addClass( 'queue' );
			mainwp_creport_stream_upgrade_start_next( selector );
			break;
		case 'hide-selected':
			selector = '#the-wp-stream-list tr .creport_showhide_plugin[showhide="hide"]';
			jQuery( selector ).addClass( 'queue' );
			mainwp_creport_stream_showhide_start_next( selector );
			break;
		case 'show-selected':
			selector = '#the-wp-stream-list tr .creport_showhide_plugin[showhide="show"]';
			jQuery( selector ).addClass( 'queue' );
			mainwp_creport_stream_showhide_start_next( selector );
			break;
	}
}

mainwp_creport_stream_showhide_start_next = function (selector) {
	while ((objProcess = jQuery( selector + '.queue:first' )) && (objProcess.length > 0) && (creport_bulkCurrentThreads < creport_bulkMaxThreads)) {
		objProcess.removeClass( 'queue' );
		if (objProcess.closest( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length == 0) {
			continue;
		}
		mainwp_creport_stream_showhide_start_specific( objProcess, true, selector );
	}
}

mainwp_creport_stream_showhide_start_specific = function (pObj, bulk, selector) {
	var parent = pObj.closest( 'tr' );
	var loader = parent.find( '.creport-action-working .loading' );
	var statusEl = parent.find( '.creport-action-working .status' );
	var showhide = pObj.attr( 'showhide' );	
        
	if (bulk) {
            creport_bulkCurrentThreads++; 
        }

	var data = {
		action: 'mainwp_creport_showhide_stream',
		websiteId: parent.attr( 'website-id' ),
		showhide: showhide,
                nonce: mainwp_clientreport_loc.nonce
	}
	statusEl.hide();
	loader.show();
	jQuery.post(ajaxurl, data, function (response) {
		loader.hide();
		pObj.removeClass( 'queue' );
		if (response && response['error']) {
			statusEl.css( 'color', 'red' );
			statusEl.html( response['error'] ).show();
		} else if (response && response['result'] == 'SUCCESS') {
                        if (showhide == 'show') {
                                pObj.text( __( "Hide MainWP Child Reports Plugin" ) ); 
                        } else {
                                pObj.text( __( "Show MainWP Child Reports Plugin" ) ); 
                        }
			

			if (showhide == 'show') {
				pObj.attr( 'showhide', 'hide' );
				parent.find( '.stream_hidden_title' ).html( __( 'No' ) );
			} else {
				pObj.attr( 'showhide', 'show' );
				parent.find( '.stream_hidden_title' ).html( __( 'Yes' ) );
			}

			statusEl.css( 'color', '#21759B' );
			statusEl.html( __( 'Successful' ) ).show();
			statusEl.fadeOut( 3000 );
		} else {
			statusEl.css( 'color', 'red' );
			statusEl.html( __( "Undefined error" ) ).show();
		}

		if (bulk) {
			creport_bulkCurrentThreads--;
			creport_bulkFinishedThreads++;
			mainwp_creport_stream_showhide_start_next( selector );
		}

	}, 'json');
	return false;
}

mainwp_creport_stream_upgrade_start_next = function (selector) {
    while ((objProcess = jQuery( selector + '.queue:first' )) && (objProcess.length > 0) && (objProcess.closest( 'tr' ).prev( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length > 0) && (creport_bulkCurrentThreads < creport_bulkMaxThreads)) {
        objProcess.removeClass( 'queue' );
        if (objProcess.closest( 'tr' ).prev( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length == 0) {
                continue;
        }
        mainwp_creport_stream_upgrade_start_specific( objProcess, true, selector );
    }
}

mainwp_creport_stream_upgrade_start_specific = function (pObj, bulk, selector) {
	var parent = pObj.closest( '.ext-upgrade-noti' );
	var workingRow = parent.find( '.creport-stream-row-working' );
	var slug = parent.attr( 'plugin-slug' );	
	var data = {
		action: 'mainwp_creport_upgrade_plugin',
		websiteId: parent.attr( 'website-id' ),
		type: 'plugin',
		'slugs[]': [slug],
                nonce: mainwp_clientreport_loc.nonce
	}

	if (bulk) {
		creport_bulkCurrentThreads++; }

	workingRow.find( 'i' ).show();
	jQuery.post(ajaxurl, data, function (response) {
		workingRow.find( 'i' ).hide();
		pObj.removeClass( 'queue' );
		if (response && response['error']) {
			workingRow.find( '.status' ).html( '<font color="red">' + response['error'] + '</font>' );
		} else if (response && response['upgrades'][slug]) {
                    pObj.after( 'MainWP Child Reports plugin has been updated' );
                    pObj.remove();
		} else {
                    workingRow.find( '.status' ).html( '<font color="red">' + __( "Undefined error" ) + '</font>' );
		}

		if (bulk) {
			creport_bulkCurrentThreads--;
			creport_bulkFinishedThreads++;
			mainwp_creport_stream_upgrade_start_next( selector );
		}

	}, 'json');
	return false;
}


mainwp_creport_stream_active_start_next = function (selector) {
	while ((objProcess = jQuery( selector + '.queue:first' )) && (objProcess.length > 0) && (objProcess.closest( 'tr' ).prev( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length > 0) && (creport_bulkCurrentThreads < creport_bulkMaxThreads)) {
		objProcess.removeClass( 'queue' );
		if (objProcess.closest( 'tr' ).prev( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length == 0) {
			continue;
		}
		mainwp_creport_stream_active_start_specific( objProcess, true, selector );
	}
}

mainwp_creport_stream_active_start_specific = function (pObj, bulk, selector) {
	var parent = pObj.closest( '.ext-upgrade-noti' );
	var workingRow = parent.find( '.creport-stream-row-working' );
	var slug = parent.attr( 'plugin-slug' );	
	var data = {
		action: 'mainwp_creport_active_plugin',
		websiteId: parent.attr( 'website-id' ),
		'plugins[]': [slug],
                nonce: mainwp_clientreport_loc.nonce
	}

	if (bulk) {
		creport_bulkCurrentThreads++; }

	workingRow.find( 'i' ).show();
	jQuery.post(ajaxurl, data, function (response) {
		workingRow.find( 'i' ).hide();
		pObj.removeClass( 'queue' );
		if (response && response['error']) {
			workingRow.find( '.status' ).html( '<font color="red">' + response['error'] + '</font>' );
		} else if (response && response['result']) {			
                        pObj.after( 'MainWP Child Reports plugin has been activated' );			
			pObj.remove();
		}
		if (bulk) {
			creport_bulkCurrentThreads--;
			creport_bulkFinishedThreads++;
			mainwp_creport_stream_active_start_next( selector );
		}

	}, 'json');
	return false;
}

showCReportTab = function (thisObj, report, edit_report, token, tream, edit_global_report, settings) {
        
        if (jQuery(thisObj).attr('href') !== '#') {
            return true;
        }
                
	var report_tab_lnk = jQuery( "#wpcr_report_tab_lnk" );
	if (report) {
            report_tab_lnk.addClass( 'mainwp_action_down' ); 
        } else {
            report_tab_lnk.removeClass( 'mainwp_action_down' ); 
        }
        
        var edit_report_tab_lnk = jQuery( "#wpcr_edit_tab_lnk" );
        if (edit_report_tab_lnk.attr( 'report-id' ) > 0) {
            edit_report_tab_lnk.remove(); 
        } else {
            if (edit_report) {
                edit_report_tab_lnk.addClass( 'mainwp_action_down' ); 
            } else {
                edit_report_tab_lnk.removeClass( 'mainwp_action_down' ); 
            }
        }

        var edit_global_report_tab_lnk = jQuery( "#wpcr_edit_global_tab_lnk" );
        if (edit_global_report_tab_lnk.attr( 'report-id' ) > 0) {
            edit_global_report_tab_lnk.remove(); 
        } else {
            if (edit_global_report) {
                edit_global_report_tab_lnk.addClass( 'mainwp_action_down' ); 
            } else {
                edit_global_report_tab_lnk.removeClass( 'mainwp_action_down' ); 
            }
        }

        var token_tab_lnk = jQuery( "#wpcr_token_tab_lnk" );
        if (token) {
            token_tab_lnk.addClass( 'mainwp_action_down' ); 
        } else {
            token_tab_lnk.removeClass( 'mainwp_action_down' ); 
        }

        var stream_tab_lnk = jQuery( "#wpcr_stream_tab_lnk" );
        if (tream) {
            stream_tab_lnk.addClass( 'mainwp_action_down' ); 
        } else {
            stream_tab_lnk.removeClass( 'mainwp_action_down' ); 
        }
                
        var report_tab = jQuery( "#wpcr_report_tab" );
        var edit_tab = jQuery( "#wpcr_edit_tab" );
        var token_tab = jQuery( "#wpcr_token_tab" );
        var tream_tab = jQuery( "#wpcr_stream_tab" );        
        var select_sites_box = jQuery( "#creport_select_sites_box" );
        
        if (report) {
                report_tab.show();
                edit_tab.hide();
                token_tab.hide();
                tream_tab.hide();                
                select_sites_box.hide();
        } else if (edit_report || edit_global_report) {
                report_tab.hide();
                edit_tab.show();
                token_tab.hide();
                tream_tab.hide();                
                select_sites_box.show();                   
        } else if (token) {
                report_tab.hide();
                edit_tab.hide();
                token_tab.show();
                tream_tab.hide();                
                select_sites_box.hide();
        } else if (tream) {
                report_tab.hide();
                edit_tab.hide();
                token_tab.hide();
                tream_tab.show();                
                select_sites_box.hide();
        } 
        return false;
};

function mainwp_creport_load_tokens()
{
	jQuery( '#creport_list_tokens' ).html( '<i class="fa fa-spinner fa-pulse" style=""></i> ' );
	jQuery.get(
            ajaxurl, 
            {
                action: 'mainwp_creport_load_tokens',
                nonce: mainwp_clientreport_loc.nonce 
            }, 
            function (data) {
                jQuery( '#creport_list_tokens' ).html( data );
            }
        );
}

mainwp_creport_remove_sites_without_creports = function (str_ids) {
	var ids = str_ids.split( "," );
        jQuery( '#creport_select_sites_box #selected_sites .mainwp_selected_sites_item' ).each(function () {
                var site_id = jQuery( this ).find( 'input[type="checkbox"]' ).attr( 'siteid' );
                if (jQuery.inArray( site_id, ids ) == -1) {
                        jQuery( this ).remove(); }
        });
}

mainwp_creport_preview_report = function () {
	jQuery( '#mwp-creport-preview-box' ).dialog({
		resizable: false,
		height: "auto",
		width: 800,
		maxWidth: 800,
		modal: true,
		close: function (event, ui) {
			jQuery( '#mwp-creport-preview-box' ).dialog( 'destroy' );
		}});
}

mainwp_client_report_load_sites = function (pWhat, pReportId) {
    var data = {
            action:'mainwp_creport_group_load_sites',
            what: pWhat,  
            report_id: pReportId,
            nonce: mainwp_clientreport_loc.nonce                
    };        
    
    jQuery('#mainwp_creport_edit_tab_wrap').html('<h2><i class="fa fa-spinner fa-pulse" style=""></i> Loading sites...<h2>').show();    
    jQuery.post(ajaxurl, data, function (response) {         
            if (response) {
                    jQuery('#mainwp_creport_edit_tab_wrap').html(response);  
                    creport_bulkTotalThreads = jQuery('.siteItemProcess[status=queue]').length;
                    if (creport_bulkTotalThreads > 0) {
                        if (pWhat == 'send_test_email' || pWhat == 'sendreport') {
                            creport_bulkMaxThreads = 1; // send one email per time
                        }
                        mainwp_creport_perform_group_report_start_next(pWhat, pReportId);
                    }
            } else {
                    jQuery('#mainwp_creport_edit_tab_wrap').html('<div class="mainwp_info-box-red">' + __("Undefined error.") + '</div>');

            }
    })
}	

mainwp_creport_perform_group_report_start_next = function(pWhat, pReportId) {
	while ((objProcess = jQuery( '.siteItemProcess[status=queue]:first' )) && (objProcess.length > 0) && (creport_bulkCurrentThreads < creport_bulkMaxThreads)) {
            objProcess.attr( 'status', 'processed' );            
            mainwp_creport_generate_group_report_start_specific( objProcess , pWhat, pReportId );             
	}
	if (creport_bulkFinishedThreads > 0 && creport_bulkFinishedThreads == creport_bulkTotalThreads) {          
            jQuery( '#mainwp_creport_edit_tab_wrap' ).append( '<div class="mainwp_info-box">' + __( "Finished." ) + '</div>' + '<p><a class="button-primary" href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=editreport&id=' + pReportId + '">Return the Report</a></p>' );
            mainwp_creport_generate_group_report_done(pWhat, pReportId);            
	} 
}

mainwp_creport_generate_group_report_start_specific = function(objProcess, pWhat, pReportId) {
	var loadingEl = objProcess.find( 'i' );
	var statusEl = objProcess.find( '.status' );
        
	creport_bulkCurrentThreads++;
	var data = {
		action: 'mainwp_creport_generate_report',               
                site_id: objProcess.attr( 'site-id' ),
                what: pWhat,
                report_id: pReportId,
                nonce: mainwp_clientreport_loc.nonce
	};
            
	statusEl.html( '' );
	loadingEl.show();
	jQuery.post( ajaxurl, data, function ( response ) {
			loadingEl.hide();
                        if ( response) {                               
                                if (response.error) {
                                        statusEl.css( 'color', 'red' );
                                        statusEl.html( '<i class="fa fa-exclamation-circle"></i> ERROR: ' + response.error );
                                } else if (response.result == 'success') {                                                                                         
                                        statusEl.html( '<span style="color:#0073aa"><i class="fa fa-check-circle"></i> ' + __( 'Successful.' ) + '</span>' );
                                } else {
                                        statusEl.css( 'color', 'red' );
                                        statusEl.html( '<i class="fa fa-exclamation-circle"></i>  ERROR: ' + 'Undefined error' );
                                }
                        } else {
                                statusEl.css( 'color', 'red' );
                                statusEl.html( '<i class="fa fa-exclamation-circle"></i>  ERROR: ' + 'Undefined error' );
                        }
			creport_bulkCurrentThreads--;
			creport_bulkFinishedThreads++;
			mainwp_creport_perform_group_report_start_next( pWhat, pReportId );
	}, 'json' );
}

mainwp_creport_generate_group_report_done = function(pWhat, pReportId) {
    var loadingEl = jQuery('#mainwp_creport_group_working').find( 'i' );
    var statusEl = jQuery('#mainwp_creport_group_working').find( '.status' );
        
        
    if (pWhat == 'preview') {
        location.href = 'admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=show_preview_group&id=' + pReportId;
    } else if (pWhat == 'archive_report') {
            var data = {
                    action: 'mainwp_creport_archive_report',                                   
                    report_id: pReportId,
                    nonce: mainwp_clientreport_loc.nonce
            };
            statusEl.html('Archiving report ...').show();
            loadingEl.show();
            jQuery.post( ajaxurl, data, function ( response ) {
                    loadingEl.hide();
                    if ( response) {                               
                            if (response.error) {
                                    statusEl.css( 'color', 'red' );
                                    statusEl.html( '<i class="fa fa-exclamation-circle"></i> ERROR: ' + response.error );
                            } else if (response.result == 'success') {                                                                                         
                                    statusEl.html( '<div class="mainwp_info-box-yellow">' + __( 'Report has been archived.' ) + '</div>' );
                            } else {
                                    statusEl.css( 'color', 'red' );
                                    statusEl.html( '<i class="fa fa-exclamation-circle"></i>  ERROR: ' + 'Undefined error' );
                            }
                    } else {
                            statusEl.css( 'color', 'red' );
                            statusEl.html( '<i class="fa fa-exclamation-circle"></i>  ERROR: ' + 'Undefined error' );
                    }
                           
            }, 'json' );
    } else if (pWhat == 'save_pdf') {
        location.href = 'admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=download_pdf_group&id=' + pReportId;
    }  
}

jQuery( document ).ready(function ($) {
	jQuery( '.mainwp-show-tut' ).on('click', function () {
		jQuery( '.mainwp-cr-tut' ).hide();
		var num = jQuery( this ).attr( 'number' );
		console.log( num );
		jQuery( '.mainwp-cr-tut[number="' + num + '"]' ).show();
		cr_setCookie( 'cr_quick_tut_number', jQuery( this ).attr( 'number' ) );
		return false;
	});

	jQuery( '#mainwp-cr-quick-start-guide' ).on('click', function () {
		if (cr_getCookie( 'cr_quick_guide' ) == 'on') {
			cr_setCookie( 'cr_quick_guide', '' ); } else {
			cr_setCookie( 'cr_quick_guide', 'on' ); }
			cr_showhide_quick_guide();
			return false;
	});
	jQuery( '#mainwp-cr-tips-dismiss' ).on('click', function () {
		cr_setCookie( 'cr_quick_guide', '' );
		cr_showhide_quick_guide();
		return false;
	});

	cr_showhide_quick_guide();

	jQuery( '#mainwp-cr-dashboard-tips-dismiss' ).on('click', function () {
		$( this ).closest( '.mainwp_info-box-yellow' ).hide();
		cr_setCookie( 'cr_dashboard_notice', 'hide', 2 );
		return false;
	});

});

cr_showhide_quick_guide = function (show, tut) {
	var show = cr_getCookie( 'cr_quick_guide' );
	var tut = cr_getCookie( 'cr_quick_tut_number' );

	if (show == 'on') {
		jQuery( '#mainwp-cr-tips' ).show();
		jQuery( '#mainwp-cr-quick-start-guide' ).hide();
		cr_showhide_quick_tut();
	} else {
		jQuery( '#mainwp-cr-tips' ).hide();
		jQuery( '#mainwp-cr-quick-start-guide' ).show();
	}

	if ('hide' == cr_getCookie( 'cr_dashboard_notice' )) {
		jQuery( '#mainwp-cr-dashboard-tips-dismiss' ).closest( '.mainwp_info-box-yellow' ).hide();
	}
}

cr_showhide_quick_tut = function () {
	var tut = cr_getCookie( 'cr_quick_tut_number' );
	jQuery( '.mainwp-cr-tut' ).hide();
	jQuery( '.mainwp-cr-tut[number="' + tut + '"]' ).show();
}

function cr_setCookie(c_name, value, expiredays)
{
	var exdate = new Date();
	exdate.setDate( exdate.getDate() + expiredays );
	document.cookie = c_name + "=" + escape( value ) + ((expiredays == null) ? "" : ";expires=" + exdate.toUTCString());
}
function cr_getCookie(c_name)
{
	if (document.cookie.length > 0) {
		var c_start = document.cookie.indexOf( c_name + "=" );
		if (c_start != -1) {
			c_start = c_start + c_name.length + 1;
			var c_end = document.cookie.indexOf( ";", c_start );
			if (c_end == -1) {
				c_end = document.cookie.length; }
			return unescape( document.cookie.substring( c_start, c_end ) );
		}
	}
	return "";
}


mainwp_creport_table_do_bulk_action = function ( act ) {                
    	var selector = '#creport_global_tbody .row-report-actions';          
        jQuery( '#creport_global_tbody .working .status' ).hide();   // hide all status 
        jQuery( selector ).addClass( 'queue' );        
        mainwp_creport_bulk_start_next( act, selector );        
}



mainwp_creport_bulk_start_next = function (pWhat, selector) {       
    while ( (objProcess = jQuery( selector + '.queue:first' )) && (objProcess.length > 0) && (creport_bulkCurrentThreads < creport_bulkMaxThreads) ) {
        objProcess.removeClass( 'queue' );
        if (objProcess.closest( 'tr' ).find( '.check-column input[type="checkbox"]:checked' ).length == 0) {    
            continue;
        }
        mainwp_creport_do_action_start_specific( objProcess, pWhat, true, selector );        
    }
}

mainwp_creport_do_action_start_specific = function (pObj, pWhat, pBulk, pSelector ) {
        
        var row = jQuery( pObj ).closest( 'tr' );
        var rowtd = jQuery( pObj ).closest( 'td' );
        var loaderEl = rowtd.find( '.working i' );
        var statusEl = rowtd.find( '.working .status' );
        var reportId = row.attr('id');
        
        statusEl.css( 'color', '#21759B' );
        statusEl.hide();
        
        var already = false;
        switch (pWhat) {                
		case 'unarchive':
                        if (pObj.hasClass('noarchived')) {
                            already = true;
                            statusEl.html( __( 'Un-archived already' ) ).fadeIn();
                        }
			break;
                case 'cancelschedule':
                        if (pObj.hasClass('noscheduled')) {
                            already = true;
                            statusEl.html( __( 'Schedule cancelled already' ) ).fadeIn();
                        }
			break;
	}
        
        if (already) {
            if (pBulk) {
               mainwp_creport_bulk_start_next( pWhat, pSelector ); 
            }
            return;
        }
        
        if (pBulk) {
            creport_bulkCurrentThreads++;
        }
        
        var data = {
                action: 'mainwp_creport_do_action_report',
                what: pWhat,
                reportId: reportId,
                nonce: mainwp_clientreport_loc.nonce
        };
        
        
        loaderEl.show();
        jQuery.post(ajaxurl, data, function (response) {
                if (pBulk) {
                    creport_bulkCurrentThreads--;
                }
                loaderEl.hide();
                if (response && response['status'] == 'success') {          
                    if (pWhat == 'delete') {     
                        row.html( '<td colspan="7">' + __( 'Report has been deleted.' ) + '</td>' );
                    }  else if (pWhat == 'unarchive') {
                        jQuery( pObj ).find( 'span.unarchive' ).html( __( 'Report has been un-archived' ) );                                            
                    }  else if (pWhat == 'cancelschedule') {
                        jQuery( pObj ).find( 'span.schedule' ).html( __( 'Schedule Cancelled' ) );
                        row.find( '.creport_sche_column' ).html( __( "No" ) );                        
                    } 
                    
                } else if (response && response['error']) {
                        statusEl.html( response['error'] ).fadeIn();
                        statusEl.css( 'color', 'red' );
                } else {
                        statusEl.html( __( 'Failed.' ) ).fadeIn();
                        statusEl.css( 'color', 'red' );
                }
                
                if (pBulk) {                                      
                    mainwp_creport_bulk_start_next( pWhat, pSelector );
		}
                
        }, 'json');

	return false;
}

