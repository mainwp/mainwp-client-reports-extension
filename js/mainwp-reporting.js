
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
    
     $('#creport_managetoken_btn_add_token').on('click', function()
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
        
        $('.creport_managetoken-edit').on('click', function()
        {            
            var parent = jQuery(this).closest('.managetoken-item');
            parent.find('.text').hide();
            parent.find('.actions-text').hide();
            parent.find('.input').show();
            parent.find('.actions-input').show();
            return false;
        });
        
        $('.creport_managetoken-cancel').on('click', function()
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
        
        
        $('.creport_managetoken-save').on('click', function()
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
        
    $('.creport_managetoken-delete').on('click' ,function(){
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

    $('.creport_nav_group_lnk ').on('click' ,function(){
        var gr = $(this).attr('group');
        $('.creport_nav_group_lnk').removeClass('current');
        $(this).addClass('current');
        $('.creport_format_group_data_tokens').removeClass('current');
        $('.creport_format_group_data_tokens[group="' + gr + '"]').addClass('current');
        return false;        
    })
    
    $( 'a.creport_format_add_token' ).on( 'click', function( e ) {   
        var replace_text = jQuery(this).html();       
        var editor = tinyMCE.get('mainwp_creport_report_body');
        if (typeof(editor) != "undefined")
            editor.execCommand('mceInsertContent', false, replace_text);        
        return false;
    });
    
    $('.mwp-creport-report-item-delete-lnk').on('click' ,function(){
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
        
        var errors = []; 
                
        if ($.trim($('#mwp_creport_title').val()) == '') {
            errors.push(__('Title is required.'));
            $('#mwp_creport_title').addClass('form-invalid');
        } 
        
        
        if (errors.length > 0) {
            show_error('mwp-creport-error-box', errors.join('<br />'));        
            return false;
        } else {
            jQuery('#mwp-creport-error-box').html("");
            jQuery('#mwp-creport-error-box').hide();
        }
        $('#mwp_creport_send').val(1);        
    });
    
    $('#mwp-creport-preview-btn').on('click' ,function(){
        
        $('#mwp_creport_title').removeClass('form-invalid');
        $('#selected_sites').removeClass('form-invalid');
        
        var errors = []; 
        var selected_sites = [];
                
        if ($.trim($('#mwp_creport_title').val()) == '') {
            errors.push(__('Title is required.'));
            $('#mwp_creport_title').addClass('form-invalid');
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
            //jQuery('#mwp-creport-error-box').show();           
            return false;
        } else {
            jQuery('#mwp-creport-error-box').html("");
            jQuery('#mwp-creport-error-box').hide();
        }
        $('#mwp_creport_preview').val(1);        
    });    
    
    $('#mwp-creport-preview-btn-close').on('click' ,function(){
        jQuery('#mwp-creport-preview-box').dialog('destroy')
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
