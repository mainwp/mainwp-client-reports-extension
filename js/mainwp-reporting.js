
jQuery(document).ready(function($) {  
    
    jQuery('.mainwp_creport_datepicker').datepicker({dateFormat:"yy-mm-dd"});
    
    $('#wpcr_report_tab_lnk').on('click', function () {   
        showCReportTab(true, false, false);
        return false;
    });
    
    $('#wpcr_new_tab_lnk').on('click', function () {  
        showCReportTab(false, true, false);
        return false;
    });
    
    $('#wpcr_token_tab_lnk').on('click', function () {  
        showCReportTab(false, false, true);
        return false;
    });
    
     $('#creport_managetoken_btn_add_token').live('click', function()
        {   
            var parent = jQuery(this).parents('.managetoken-item');                            
            $('#mwp-creport-error-box').hide();
            $('#mwp-creport-info-box').hide();            
            var errors = [];            
            if (parent.find('input[name="token_name"]').val().trim() == '')
                errors.push(__('Error: Token Name can not be empty.'));
            
            if (parent.find('input[name="token_description"]').val().trim() == '')
                errors.push(__('Error: Token Description can not be empty.'));     
            
            if (errors.length > 0) {
                $('#mwp-creport-error-box').html('<p>' + errors.join('<br />') + '</p>').show();
                return false;
            }            
            var fields = {  token_name: parent.find('input[name="token_name"]').val(),            
                            token_description: parent.find('input[name="token_description"]').val(),            
                            action: 'mainwp_creport_save_token'                                                        
                         };                      
            parent.find('.mainwp_more_loading').show();
            $.post(ajaxurl, fields, function(response) {     
                parent.find('.mainwp_more_loading').hide();                
                if (response) {
                    if (response['success'])
                    {   
                        $('#mwp-creport-info-box').html(__('New Token added successfully.')).show();                        
                        parent.before(response['row_data']);
                        parent.find('input[type=text]').val('');                        
                    }
                    else
                    {                        
                        if (response['error'])                            
                            $('#mwp-creport-error-box').html('<p>' + response['error'] + '</p>').show();                                        
                        else                            
                            $('#mwp-creport-error-box').html('<p>Undefined Error.</p>').show();                                        
                    }
                }
                else
                {
                    $('#mwp-creport-error-box').html('<p>' + __('Undefined Error.') + '</p>').show();                                        
                }
                
            }, 'json');
            return false;            
        });
        
        $('.creport_managetoken-edit').live('click', function()
        {            
            var parent = jQuery(this).closest('.managetoken-item');
            parent.find('.text').hide();
            parent.find('.actions-text').hide();
            parent.find('.input').show();
            parent.find('.actions-input').show();
            return false;
        });
        
        $('.creport_managetoken-cancel').live('click', function()
        {            
            var parent = jQuery(this).closest('.managetoken-item');
            parent.find('.input').hide();
            parent.find('.actions-input').hide();
            parent.find('.token-name input[name=token_name]').val(parent.find('.token-name span.text').attr('value'));
            parent.find('.token-description input[name=token_description]').val(parent.find('.token-description span.text').attr('value'));            
            parent.find('.text').show();
            parent.find('.actions-text').show();            
            return false;
        });
        
        
        $('.creport_managetoken-save').live('click', function()
        {            
            var parent = jQuery(this).closest('.managetoken-item');
            $('#mwp-creport-error-box').hide();
            $('#mwp-creport-info-box').hide();          
            var errors = [];
            if (parent.find('input[name="token_name"]').val().trim() == '')
                errors.push(__('Error: Token Name can not be empty.'));
            
            if (parent.find('input[name="token_description"]').val().trim() == '')
                errors.push(__('Error: Token Description can not be empty.'));     
            
            if (errors.length > 0) {
                $('#mwp-creport-error-box').html('<p>' + errors.join('<br />') + '</p>').show();
                return false;
            }            
            parent.find('.mainwp_more_loading').show();
            var fields = {  token_name: parent.find('input[name="token_name"]').val(),            
                         token_description: parent.find('input[name="token_description"]').val(),            
                         token_id: parent.attr('token_id'),
                         action: 'mainwp_creport_save_token'                            
                      };  
                         
            $.post(ajaxurl, fields, function(response) {                
                parent.find('.mainwp_more_loading').hide();
                if (response) {
                    if (response['success']) {                        
                        if (response['message']) 
                            $('#mwp-creport-info-box').html(response['message']).show();   
                        else
                            $('#mwp-creport-info-box').html(__('Token has been updated successfully')).show();                                                
                        parent.html(response['row_data']);                        
                    } else
                    {                        
                        if (response['error'])                            
                            $('#mwp-creport-error-box').html('<p>' + response['error'] + '</p>').show();                                        
                        else                            
                            $('#mwp-creport-error-box').html('<p>Undefined Error.</p>').show();                                        
                    }
                }
                else
                {
                    $('#mwp-creport-error-box').html('<p>' + __('Undefined Error.') + '</p>').show();                                        
                }
                
            }, 'json');   
            
            return false;
        });
        
    $('.creport_managetoken-delete').live('click' ,function(){
        $('#mwp-creport-error-box').hide();
        $('#mwp-creport-info-box').hide();   
        if (confirm(__('Are you sure?'))) {
            var parent = $(this).closest('.managetoken-item');
            parent.find('.mainwp_more_loading').show();
            jQuery.post(ajaxurl, {
                action: 'mainwp_creport_delete_token',
                token_id: parent.attr('token_id')
            }, function(data) {
                parent.find('.mainwp_more_loading').hide();
                if (data && data.success) {
                    parent.html('<td><span class="text">' + __('Token has been deleted successfully.') + '</span></td>').fadeOut(2000);                    
                }
                else 
                {
                    jQuery('#mwp-creport-info-box').html(__('Token can not be deleted.')).show();
                }
            }, 'json');
            return false;    
        }
        return false;        
    });

    $('.creport_nav_group_lnk').on('click' ,function(){
        var parent = $(this).closest('.creport_format_insert_tokens_box');
        var gr = $(this).attr('group');
        var gr_title = $(this).attr('group-title');       
        parent.find('.creport_nav_group_lnk').removeClass('current');
        $(this).addClass('current');        
        var gr2 = 'sections';
        var gr2_title = 'Sections';        
        if (gr == 'client') {
            gr2 = 'tokens';
            gr2_title = '';
        }        
        parent.find('.creport_format_group_data_tokens').removeClass('current');
        parent.find('.creport_format_group_data_tokens[group="' + gr + '_' + gr2 + '"]').addClass('current');
        parent.find('.creport_format_group_nav.bottom').removeClass('current');
        parent.find('.creport_format_group_nav.bottom[group="' + gr + '"]').addClass('current');       
        parent.find('.creport_nav_bottom_group_lnk').removeClass('current');
        parent.find('.creport_nav_bottom_group_lnk[group="' + gr + '_' + gr2 + '"]').addClass('current');
        mainwp_creport_insert_token_set_breadcrumb(parent, gr_title, gr2_title);
        return false;        
    })
    
    $('.creport_nav_bottom_group_lnk ').on('click' ,function(){
        var parent = $(this).closest('.creport_format_insert_tokens_box');
        var gr = $(this).attr('group');
        var gr_title = $(this).attr('group-title');
        var gr2_title = $(this).attr('group2-title');        
        parent.find('.creport_nav_bottom_group_lnk').removeClass('current');
        $(this).addClass('current');
        parent.find('.creport_format_group_data_tokens').removeClass('current');
        parent.find('.creport_format_group_data_tokens[group="' + gr + '"]').addClass('current');
        mainwp_creport_insert_token_set_breadcrumb(parent, gr_title, gr2_title);
        return false;        
    })
    
    mainwp_creport_insert_token_set_breadcrumb = function(parent, group, group2) {
        parent.find('.creport_format_nav_bottom_breadcrumb .group').text(group);
        if (group2 == '') {
            parent.find('.creport_format_nav_bottom_breadcrumb .crp_content_group2').hide();
        } else {
            parent.find('.creport_format_nav_bottom_breadcrumb .group2').text(group2);
            parent.find('.creport_format_nav_bottom_breadcrumb .crp_content_group2').show();            
        }
    }
    
    $('.mainwp_creport_show_insert_tokens_book_lnk').on('click', function() {        
        var box = $(this).closest('tr').find('.creport_format_insert_tokens_box');
        if (box.hasClass('hidden-field')) {
            box.removeClass('hidden-field');
            $(this).text(__("Hide Available Tokens"));
        } else {
            box.addClass('hidden-field');
            $(this).text(__("Show Available Tokens"));
        }
        return false;
    })
    
    $( 'a.creport_format_add_token' ).live( 'click', function( e ) {   
        var parent = $(this).closest('.creport_format_insert_tokens_box');
        var replace_text = jQuery(this).html();  
        var token_value = jQuery(this).attr('token-value');
        if (token_value !== '')
            replace_text = token_value;
        var name = parent.attr('editor');
        var editor = tinyMCE.get('mainwp_creport_report_' + name);
        var set_new_pos = replace_text.length;
        if (editor != null && typeof(editor) !== "undefined" && editor.isHidden() == false) {
            if (replace_text.indexOf("[section.") !== -1) {
                var end_section =  replace_text.replace("[section.", "[/section.");
                replace_text = replace_text + '<br/><span id="crp_ed_cursor"></span><br/>' + end_section;
            }
            editor.execCommand('mceInsertContent', false, replace_text);        
            var cursor = editor.dom.select('span#crp_ed_cursor');
            if (cursor != null && typeof(cursor[0]) !== "undefined") {                               
                editor.selection.select(cursor[0]).remove();                                      
            }
        } else {            
            if (replace_text.indexOf("[section.") !== -1) {
                var end_section =  replace_text.replace("[section.", "[/section.");
                set_new_pos++;
                replace_text = replace_text + '\n\n' + end_section;             
            }
            var obj = $('#mainwp_creport_report_' + name);
            var str = obj.val();  
            var pos = creport_getPos(obj[0]);
            str = str.substring(0,pos) + replace_text + str.substring(pos, str.length)
            obj.val(str);       
            set_new_pos += pos;
            creport_setPos(obj[0], set_new_pos, set_new_pos);            
        }
        return false;
    });
       
    function creport_getPos(obj) {
            var pos = 0;	// IE Support
            if (document.selection) {
                obj.focus();
                var range = document.selection.createRange ();
                range.moveStart ('character', -obj.value.length);
                pos = range.text.length;
            }
            // Firefox support
            else if (obj.selectionStart || obj.selectionStart == '0')
                pos = obj.selectionStart;
            return (pos);
    }
    
    function creport_setPos(obj, selectionStart, selectionEnd) {           
        if (document.selection) {           
            obj.focus();
            var range = document.selection.createRange();
            range.collapse(true);
            range.moveEnd('character', selectionEnd);
            range.moveStart('character', selectionStart);
            range.select();                
        }
        // Firefox support
        else {                
            obj.focus();            
            obj.setSelectionRange(selectionStart, selectionEnd);
        }        
    }
    
    $('.mwp-creport-report-item-delete-lnk').on('click' ,function(){        
        if (!confirm("Are you sure?"))
            return false;
        
        var row = $(this).closest('tr');
        var loaderEl = row.find('.loading img');
        var statusEl = row.find('.loading .status');
                
        var data = {
            action: 'mainwp_creport_delete_report',
            reportId: row.attr('id')            
        };      
        loaderEl.show();
        $.post(ajaxurl, data, function(response) { 
            loaderEl.hide();
            if (response && response['status'] == 'success') {
                row.html('<td colspan="4">' + __('Report has been deleted.') + '</td>');
            } else {
                statusEl.html(__('Delete failed.')).fadeIn();
                statusEl.css('color', 'red');
            }                                 
        }, 'json'); 
        return false;
    });    
    
    
    $('#mwp-creport-send-btn').on('click' ,function(){
        
        $('#mwp_creport_title').removeClass('form-invalid');
        $('#mwp_creport_date_from').removeClass('form-invalid');
        $('#selected_sites').removeClass('form-invalid');
        
        var errors = []; 
        var selected_sites = [];
        
        if ($.trim($('#mwp_creport_title').val()) == '') {
            errors.push(__('Title is required.'));
            $('#mwp_creport_title').addClass('form-invalid');
        } 
        
        
        if ($.trim($('#mwp_creport_date_from').val()) == '') {
            errors.push(__('Date From is required.'));
            $('#mwp_creport_date_from').addClass('form-invalid');
        }
            
        jQuery("#selected_sites input[name='selected_site']:checked").each(function (i) {
            selected_sites.push(jQuery(this).val());                       
        });  
        
        if (selected_sites.length == 0) {
            errors.push(__("Please select a website."));  
            $('#selected_sites').addClass('form-invalid'); 
        }
        
        if (errors.length > 0) {
            show_error('mwp-creport-error-box', errors.join('<br />'));                    
            return false;
        } else {
            jQuery('#mwp-creport-error-box').html("");
            jQuery('#mwp-creport-error-box').hide();
        }
        
        $('#mwp_creport_report_submit_action').val('send');        
    });
    
    $('#mwp-creport-preview-btn').on('click' ,function(){
        
        $('#mwp_creport_title').removeClass('form-invalid');
        $('#mwp_creport_date_from').removeClass('form-invalid');
        $('#selected_sites').removeClass('form-invalid');
        
        var errors = []; 
        var selected_sites = [];
                
        if ($.trim($('#mwp_creport_title').val()) == '') {
            errors.push(__('Title is required.'));
            $('#mwp_creport_title').addClass('form-invalid');
        } 
        
        if ($.trim($('#mwp_creport_date_from').val()) == '') {
            errors.push(__('Date From is required.'));
            $('#mwp_creport_date_from').addClass('form-invalid');
        }
            
        jQuery("#selected_sites input[name='selected_site']:checked").each(function (i) {
            selected_sites.push(jQuery(this).val());                       
        });  
        
        if (selected_sites.length == 0) {
            errors.push(__("Please select a website."));  
            $('#selected_sites').addClass('form-invalid'); 
        }
        
        if (errors.length > 0) {
            show_error('mwp-creport-error-box', errors.join('<br />'));                    
            return false;
        } else {
            jQuery('#mwp-creport-error-box').html("");
            jQuery('#mwp-creport-error-box').hide();
        }
        $('#mwp_creport_report_submit_action').val('preview');        
    });    
    
    $('#mwp-creport-save-btn').live('click' ,function(){
        
        $('#mwp_creport_title').removeClass('form-invalid');
        $('#mwp_creport_date_from').removeClass('form-invalid');
        
        var errors = []; 
                
        if ($.trim($('#mwp_creport_title').val()) == '') {
            errors.push(__('Title is required.'));
            $('#mwp_creport_title').addClass('form-invalid');
        } 
        
        if ($.trim($('#mwp_creport_date_from').val()) == '') {
            errors.push(__('Date From is required.'));
            $('#mwp_creport_date_from').addClass('form-invalid');
        }
        
        if (errors.length > 0) {
            show_error('mwp-creport-error-box', errors.join('<br />'));                     
            return false;
        } else {
            jQuery('#mwp-creport-error-box').html("");
            jQuery('#mwp-creport-error-box').hide();
        }   
        $('#mwp_creport_report_submit_action').val('save');
    });    
    
    $('#mwp-creport-preview-btn-close').on('click' ,function(){
        jQuery('#mwp-creport-preview-box').dialog('destroy');        
    })
    
    $('#mwp-creport-preview-btn-send').on('click' ,function(){
        jQuery('#mwp-creport-preview-box').dialog('destroy');                 
        jQuery('#mwp-creport-send-btn').click();                 
    })
    
    $('#mainwp_creport_select_client_btn_display').on('click' ,function(){
        var client = $('#mainwp_creport_select_client').val();
        location.href = 'admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&client=' + client;
    })
    
    $('#mwp_creport_edit_form .mainwp_selected_sites_item input[type="radio"]').on('click',function(){
        var data = {
            action: 'mainwp_creport_load_site_tokens',
            siteId: $(this).attr('siteid')
        }
        $.post(ajaxurl, data, function(response) { 
           if (response && response !== 'EMPTY') {
               $('.creport_format_group_data_tokens[group="client_tokens"] table tbody').html(response);
           }                                 
        }); 
    })    
});

showCReportTab = function(report, new_report, token) {
    var report_tab_lnk = jQuery("#wpcr_report_tab_lnk");
    if (report)  report_tab_lnk.addClass('mainwp_action_down');
    else report_tab_lnk.removeClass('mainwp_action_down'); 

    var new_report_tab_lnk = jQuery("#wpcr_new_tab_lnk");
    if (new_report) new_report_tab_lnk.addClass('mainwp_action_down');
    else new_report_tab_lnk.removeClass('mainwp_action_down');
   
    var token_tab_lnk = jQuery("#wpcr_token_tab_lnk");
    if (token) token_tab_lnk.addClass('mainwp_action_down');
    else token_tab_lnk.removeClass('mainwp_action_down');
    
    var report_tab = jQuery("#wpcr_report_tab");
    var new_tab = jQuery("#wpcr_new_tab");
    var token_tab = jQuery("#wpcr_token_tab");
    var select_sites_box = jQuery("#creport_select_sites_box");
    
    if (report) {
        report_tab.show();
        new_tab.hide();
        token_tab.hide();
        select_sites_box.hide();
    } else if (new_report) {
        report_tab.hide();
        new_tab.show();
        token_tab.hide();
        select_sites_box.show();
    } else if (token) {
        report_tab.hide();
        new_tab.hide();
        token_tab.show();
        select_sites_box.hide();
    }   
};

function mainwp_creport_load_tokens()
{
    jQuery('#creport_list_tokens').html('<img src="' + mainwpParams['image_url'] + 'loader.gif"> ');    
    jQuery.get(ajaxurl, {
        'action': 'mainwp_creport_load_tokens'        
    }, function(data) {
        jQuery('#creport_list_tokens').html(data);
    });
}

mainwp_creport_preview_report = function() {   
   jQuery('#mwp-creport-preview-box').dialog({
        resizable: false,
        height: "auto",
        width: 800,
        maxWidth: 800,
        modal: true,
        close: function(event, ui) {jQuery('#mwp-creport-preview-box').dialog('destroy');}});   
}

mainwp_creport_client_change = function() {
    var data = {
        action: 'mainwp_creport_load_client',
        client: jQuery('#mainwp_creport_autocomplete_client').val()
    }
    jQuery('#mainwp_creport_client_loading').find('img').show();
    jQuery.post(ajaxurl, data , function(response) {
        jQuery('#mainwp_creport_client_loading').find('img').hide();
        jQuery('input[name="mwp_creport_name"]').val('');
        jQuery('input[name="mwp_creport_company"]').val('');
        jQuery('input[name="mwp_creport_email"]').val('');  
        jQuery('input[name="mwp_creport_client_id"]').val(0);
        if (response && response.clientid) {                        
            jQuery('input[name="mwp_creport_client_id"]').val(response.clientid);
            if (response.name)
                jQuery('input[name="mwp_creport_name"]').val(response.name);
            if (response.name)
                jQuery('input[name="mwp_creport_company"]').val(response.company);
            if (response.name)
                jQuery('input[name="mwp_creport_email"]').val(response.email);                        
        } 
    }, 'json');
} 
            
