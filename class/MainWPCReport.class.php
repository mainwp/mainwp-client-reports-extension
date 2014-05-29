<?php
class MainWPCReport
{    
    private $clientReportExt;
    private static $stream_tokens = array();
    
    public function __construct($ext) {    
        $this->clientReportExt = $ext;
        self::$stream_tokens = array(            
            "Post Sections" => array(array("name" => "section.post.updated", "desc" => "Token Description"),
                                array("name" => "section.post.added", "desc" => "Token Description")),
            "Theme Sections" => array(array("name" => "section.theme.updated", "desc" => "Token Description"),
                                array("name" => "section.theme.added", "desc" => "Token Description")),
            "WordPress" => array(),
            "plugins"=>array(array("name" => "plugin.name", "desc" => "Token Description"),
                            array("name" => "plugins.activated", "desc" => "Token Description"),
                            array("name" => "plugins.activated.date", "desc" => "Token Description"),
                            array("name" => "plugins.installed", "desc" => "Token Description"),
                            array("name" => "plugins.installed.date", "desc" => "Token Description"),                
                            array("name" => "plugins.oldversion", "desc" => "Token Description"),
                            array("name" => "plugin.currentversion", "desc" => "Token Description"),
                            array("name" => "plugin.upgrade.date", "desc" => "Token Description"),
                            array("name" => "plugin.add.date", "desc" => "Token Description"),
                            array("name" => "plugin.add.count", "desc" => "Token Description")),                                    
            "themes"=>array(array("name" => "theme.name", "desc" => "Token Description"),
                            array("name" => "theme.oldversion", "desc" => "Token Description"),
                            array("name" => "theme.currentversion", "desc" => "Token Description"),
                            array("name" => "theme.upgrade.date", "desc" => "Token Description"),
                            array("name" => "theme.upgrade.count", "desc" => "Token Description"),
                            array("name" => "theme.add.date", "desc" => "Token Description"),
                            array("name" => "theme.add.count", "desc" => "Token Description")),
            "users"=>array(),
            "posts"=>array(array("name" => "post.updated", "desc" => "Token Description"),                
                           array("name" => "post.updated.date", "desc" => "Token Description"),                
                           array("name" => "post.add.count", "desc" => "Token Description")),
            "pages"=>array(array("name" => "page.title", "desc" => "Token Description"),
                            array("name" => "page.add.date", "desc" => "Token Description"),
                            array("name" => "page.add.count", "desc" => "Token Description")),
            "backups"=>array(),
            "settings"=>array(array("name" => "settings.updated", "desc" => "Setting Updated")),
            "security_scan"=>array() );
    }
    
    
    public function init() {
       
    }
    
    public function admin_init() {
        add_action('mainwp-extension-sites-edit', array(&$this, 'site_token'),9,1);                
        add_action('wp_ajax_mainwp_creport_load_tokens', array(&$this, 'load_tokens'));
        add_action('wp_ajax_mainwp_creport_delete_token', array(&$this, 'delete_token')); 
        add_action('wp_ajax_mainwp_creport_save_token', array(&$this, 'save_token'));
        add_action('wp_ajax_mainwp_creport_delete_report', array(&$this, 'delete_report')); 
        
        add_action('mainwp_update_site', array(&$this, 'update_site_update_tokens'), 8, 1);
        add_action('mainwp_delete_site', array(&$this, 'delete_site_delete_tokens'), 8, 1);
        
    }     
    
    public function initMenu() {
        
    }
 
    public static function saveReport() {
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'editreport' && isset($_REQUEST['nonce']) &&  wp_verify_nonce($_REQUEST['nonce'], 'mwp_creport_nonce')) {
            $messages = $errors = array();
            $report = array();
            
            if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
                $report['id'] = $_REQUEST['id'];
            }
            
            if(isset($_POST['mwp_creport_title']) && ($title = trim($_POST['mwp_creport_title'])) != "")
                $report['title'] = $title;                
            
            $start_time = $end_time = 0;
            if(isset($_POST['mwp_creport_date_from']) && ($start_date = trim($_POST['mwp_creport_date_from'])) != "") {
                $start_time = strtotime($start_date);                
            } 
           
            if(isset($_POST['mwp_creport_date_to']) && ($end_date = trim($_POST['mwp_creport_date_to'])) != "") {
                $end_time = strtotime($end_date);                
            } 
            
            if ($end_time == 0) {
                $current = time();
                $end_time = mktime(0,0,0, date("m", $current), date("d", $current), date("Y", $current));
            }
            
            if (($start_time != 0 && $end_time != 0) && ($start_time > $end_time)) {
                $tmp = $start_time;
                $start_time = $end_time;
                $end_time = $tmp;                
            }
            
            $report['date_from'] = $start_time;
            $report['date_to'] = $end_time + 24 * 3600  - 1;  // end of day              
            
            if(isset($_POST['mwp_creport_fname'])) {
                $report['fname'] = trim($_POST['mwp_creport_fname']);                
            }
            
            if(isset($_POST['mwp_creport_fcompany'])) {
                $report['fcompany'] = trim($_POST['mwp_creport_fcompany']);                
            }
            
            $from_email = "";            
            if(!empty($_POST['mwp_creport_femail'])) {                
                $from_email = trim($_POST['mwp_creport_femail']);								
                if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $from_email))				
                {    
                    $from_email = "";
                    $errors[] = "Incorrect Send From email address.";
                }                    
            }
            $report['femail'] = $from_email;
            
            if(isset($_POST['mwp_creport_name'])) {
                $report['name'] = trim($_POST['mwp_creport_name']);                
            }
            
            if(isset($_POST['mwp_creport_company'])) {
                $report['company'] = trim($_POST['mwp_creport_company']);                
            }
            
            $to_email = "";
            if(!empty($_POST['mwp_creport_email'])) {                
                $to_email = trim($_POST['mwp_creport_email']);								
                if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $from_email))				
                {
                    $to_email = "";
                    $errors[] = "Incorrect Send To email address.";
                }              
            }
            $report['email'] = $to_email;
            
            if(isset($_POST['mainwp_creport_report_header'])) {
                $report['header'] = trim($_POST['mainwp_creport_report_header']);                
            }
            
            if(isset($_POST['mainwp_creport_report_body'])) {
                $report['body'] = trim($_POST['mainwp_creport_report_body']);                
            }
            
            if(isset($_POST['mainwp_creport_report_footer'])) {
                $report['footer'] = trim($_POST['mainwp_creport_report_footer']);                
            }  
            
            $creport_dir = apply_filters('mainwp_getspecificdir',"client_report/");
            if (!file_exists($creport_dir)) {
                @mkdir($creport_dir, 0777, true);
            }
            if (!file_exists($creport_dir . '/index.php'))
            {
                @touch($creport_dir . '/index.php');
            }
            
            $old_logo = "";
            if (isset($_POST['id']) && $_POST['id']) {
                $current_report = MainWPCReportDB::Instance()->getReportBy('id', $_POST['id']);
                if ($current_report && is_object($current_report) && !empty($current_report->logo_file)) {
                    $old_logo = $creport_dir . $current_report->logo_file;                    
                }
            }
           
            
            $image_logo = "NOTCHANGE";  
            $del_logo = false;
            if (isset($_POST['mainwp_creport_delete_logo_image']) && $_POST['mainwp_creport_delete_logo_image'] == "1") {
                $image_logo = "";
                $del_logo = true;
            }     

            if($_FILES && $_FILES['mainwp_creport_logo_file']['error'] == UPLOAD_ERR_OK) {                          
                $del_logo = true;
                $output = self::handleUploadImage($_FILES['mainwp_creport_logo_file'], $creport_dir);
                if (is_array($output) && isset($output['filename']) && !empty($output['filename'])) {                    
                    $image_logo = $output['filename'];                    
                } else if (isset($output['error'])) {
                    foreach ($output['error'] as $e) {
                        $errors[] = $e;
                    }
                }
            }

            if ($del_logo && file_exists($old_logo)) {
                @unlink($old_logo);
            }

            if ($image_logo !== "NOTCHANGE") {
                $report['logo_file'] = $image_logo;
            }
            
            
            $selected_site = 0; 
            if (isset($_POST['select_by'])) {                            
                if (isset($_POST['selected_site'])) {                                        
                    $selected_site = intval($_POST['selected_site']);                    
                }                                                
            }               
            $report['selected_site'] = $selected_site;
            
            $return = array();            
            
            if($result = MainWPCReportDB::Instance()->updateReport($report)) {                    
                $return['id'] = $result->id;                    
                $messages[] = 'Report saved.';  
            } else {
                $messages[] = "Report not change.";            
            }
            
            if (!isset($return['id']) && isset($report['id'])) {
                $return['id'] = $report['id'];
            }
            
            $return['updated'] = true;
            if (isset($_POST['mwp_creport_preview']) && !empty($_POST['mwp_creport_preview'])) {
                $return['do_preview'] = true;
            }     
            
            if (count($errors) > 0) 
                $return['error'] = $errors;  
            
            if (count($messages) > 0) 
                $return['message'] = $messages;
            
            return $return;
        }
        return null;
    }
    
    public static function send_report_mail($report)
    {
        if (!is_object($report))
            return false;
        
        $email = $report->email;
        $content = self::gen_email_content($report);
        $from = "";
        if (!empty($report->fname)) {
            $from = "From: " . $report->fname;
            if (!empty($report->femail))
                $from .= " <" . $report->femail . ">";
        } else if (!empty($report->femail))
            $from = "From: " . $report->femail;
     
        if (!empty($content) && !empty($email))
        {   
            if (wp_mail($email, 'Website Report', $content, array($from, 'content-type: text/html'))) ;
                return true;
        }
        return false;
    }
    
    public static function handleUploadImage($file_input, $dest_dir) {              
        $output = array();         
        $processed_file = "";
        if($file_input['error'] == UPLOAD_ERR_OK) {                          
            $tmp_file = $file_input['tmp_name'];
            if (is_uploaded_file($tmp_file))
            {                    
                $file_size = $file_input['size'];
                $file_type = $file_input['type'];
                $file_name = $file_input['name'];

                if (($file_size > 500 * 1025)){   
                    $output["error"][] = "File size too big."; 
                }                    
                elseif (                          
                    ($file_type != "image/jpeg") &&
                    ($file_type != "image/jpg") &&
                    ($file_type != "image/gif") &&
                    ($file_type != "image/png")    
                ){                        
                    $output["error"][] = "File type are not allowed."; 
                }    
                else {   
                    $dest_file = $dest_dir . $file_name;                     
                    $dest_file = dirname( $dest_file ) . '/' . wp_unique_filename( dirname( $dest_file ), basename( $dest_file ) );
                    
                    if (move_uploaded_file($tmp_file, $dest_file)) {  
                        $output["filename"] = basename($dest_file);                        
                    } else                         
                        $output["error"][] = "Can not copy file.";
                }
            }
        }        
        return $output;
    }
    
    public static function render() {     
        self::renderTabs();
    }
   
    public static function renderTabs() {
        global $current_user;              
        
        $messages = $errors = array();               
        $do_preview = false;              
        $report_id = 0;
        
        // if send report from preview screen do not need to save report
        if (empty($_POST['mwp_creport_do_not_save'])) {
            $result = self::saveReport();           
            if (is_array($result)) {
                $report_id = isset($result['id']) ? $result['id'] : 0;             
                if (isset($result['message']))                 
                    $messages = $result['message'];

                if (isset($result['error'])) 
                    $errors = $result['error'];

                if (isset($result['do_preview']) && $result['do_preview']) {
                    $do_preview = true;
                } 
            } 
        }
        
        if (empty($report_id))
            $report_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        $report = null;
        if ($report_id) {
            $report = MainWPCReportDB::Instance()->getReportBy('id', $report_id);  
            if ((isset($_GET['action']) && $_GET['action'] == 'sendreport') || (isset($_POST['mwp_creport_send']) && !empty($_POST['mwp_creport_send']))) {                                
                if (self::send_report_mail($report)) {                        
                    $messages[] = 'Send Report successful.';  
                } else {
                    $errors[] = 'Send Report failed.';  
                }                
            }   
        }
           
        $str_error = (count($errors) > 0) ? implode("<br/>", $errors) : "";
        $str_message = (count($messages) > 0) ? implode("<br/>", $messages) : "";
        
        $style_tab_report = $style_tab_new = $style_tab_token = ' style="display: none" ';                
        
        if (isset($_REQUEST['action'])) {                
            if ($_REQUEST['action'] == "token") {            
                $style_tab_token = '';                
            } else if ($_REQUEST['action'] == "editreport") {               
                $style_tab_new = '';            
            } else if ($_GET['action'] == 'sendreport') {
                $style_tab_report = "";
            }
        } else {
            $style_tab_report = "";
        }
        
        $selected_site = 0;          
        if ($report && is_object($report)) {
            $selected_site = $report->selected_site;            
        } else  {
            if (isset($_POST['select_by'])) {                            
                if (isset($_POST['selected_site'])) {                                        
                    $selected_site = intval($_POST['selected_site']);                    
                }                                                
            }
        }
        
//        if ($report && is_object($report)) {
//            $args = array(  
//                            'date_from' => date("Y-m-d H:i:s", $report->date_from),
//                            'date_to' => date("Y-m-d H:i:s", $report->date_to));          
//            $records = wp_stream_query( $args );
//            print_r($records);
//        }
        ?>
            <div class="wrap" id="mainwp-ap-option">
            <div class="clearfix"></div>           
            <div class="inside">   
                <div  class="mainwp_error" id="mwp-creport-error-box" <?php echo !empty($str_error) ? "style=\"display:block;\"" : ""; ?>><?php echo !empty($str_error) ? "<p>" . $str_error . "</p>" : ""; ?></div>
                <div  class="mainwp_info-box-yellow" id="mwp-creport-info-box"  <?php echo (empty($str_message) ? ' style="display: none" ' : ""); ?>><?php echo $str_message?></div>
                <h3><?php _e("Client Reports Extension"); ?></h3>
                <div id="mainwp_wpcr_option">
                    <div class="mainwp_error" id="wpcr_error_box"></div>
                    <div class="clear">
                        <br />
                        <a id="wpcr_report_tab_lnk" href="#" class="mainwp_action left <?php  echo (empty($style_tab_report) ? "mainwp_action_down" : ""); ?>"><?php _e("Client Reports"); ?></a><a id="wpcr_new_tab_lnk" href="#" class="mainwp_action mid <?php  echo (empty($style_tab_new) ? "mainwp_action_down" : ""); ?>"><?php _e("New Report"); ?></a><a id="wpcr_token_tab_lnk" href="#" class="mainwp_action right <?php  echo (empty($style_tab_token) ? "mainwp_action_down" : ""); ?>"><?php _e("Report Tokens"); ?></a>
                        <br /><br />                              
                        <div id="wpcr_report_tab" <?php echo $style_tab_report; ?>>                          
                            <?php self::reportTab(); ?>                            
                        </div>
                        <form method="post" enctype="multipart/form-data" id="mwp_creport_edit_form" action="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=editreport<?php echo !empty($report_id) ? "&id=" . $report_id : ""; ?>">
                            <div id="creport_select_sites_box" class="mainwp_config_box_right" <?php echo $style_tab_new; ?>>
                            <?php do_action('mainwp_select_sites_box', __("Select Sites", 'mainwp'), 'radio', false, false, 'mainwp_select_sites_box_right', "", array($selected_site), array()); ?>
                            </div>
                            <div id="wpcr_new_tab"  <?php echo $style_tab_new; ?>>
                                <?php self::newReportTab($report); ?>  
                                <p class="submit">                                    
                                    <span style="float:left;">
                                        <input type="submit" value="<?php _e("Preview Report"); ?>" class="button-primary" id="mwp-creport-preview-btn" name="button_preview">                                        
                                    </span>
                                    <span style="float:right;">
                                        <input type="submit" value="<?php _e("Save Report"); ?>" class="button" id="mwp-creport-save-btn" name="button_save">
                                        <input type="submit" value="<?php _e("Send Report"); ?>" class="button-primary" id="mwp-creport-send-btn" name="submit">
                                    </span>
                                </p>
                            </div>   
                            <input type="hidden" name="mwp_creport_send" id="mwp_creport_send" value="0">
                            <input type="hidden" name="mwp_creport_preview" id="mwp_creport_preview" value="0">
                            <input type="hidden" name="mwp_creport_do_not_save" id="mwp_creport_do_not_save" value="0">
                            <input type="hidden" name="id" value="<?php echo (is_object($report) && $report->id) ? $report->id : "0"; ?>">
                            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('mwp_creport_nonce') ?>">
                        </form>
                        <div id="wpcr_token_tab"  <?php echo $style_tab_token; ?>>
                            <div id="creport_list_tokens" class="postbox"></div>                                                                       
                        </div>   
                    </div>
                <div class="clear"></div>
                </div>
            </div>
        </div>        
        <div id="mwp-creport-preview-box" title="<?php _e("Preview Report"); ?>" style="display: none; text-align: center">
            <div style="height: auto; overflow: auto; margin-top: 20px; margin-bottom: 10px; text-align: left" id="mwp-creport-preview-content">
              <?php                
                if ($do_preview && is_object($report)) {
                    echo self::gen_preview_report($report);
                }
            ?>  
            </div>
            <input type="button" value="<?php _e("Close"); ?>" class="button-primary" id="mwp-creport-preview-btn-close"/>
            <input type="button" value="<?php _e("Send Report"); ?>" class="button-primary" id="mwp-creport-preview-btn-send"/>
        </div>
        
        <script>
            jQuery(document).ready(function($){    
                mainwp_creport_load_tokens();    
                <?php if ($do_preview) { ?>
                        mainwp_creport_preview_report();
                <?php } ?>
            });
        </script>        
    <?php
    }
    
    public static function gen_preview_report($report) {      
        if (is_object($report)) {                
            ob_start();
            $str_message = "";
            try {
                $filtered_report = self::filter_report($report);
                //print_r($filtered_report);
                $report = $filtered_report;
            } catch (Exception $e) 
            {
                $str_message = $e->getMessage(); 
            }            
            if (!empty($str_message)) {
                ?> <div class="mainwp_info-box-yellow"><?php echo $str_message;?></div> <?php                
            }            
            echo self::gen_report_content($report);            
        } else {
        ?>
            <div class="mainwp_info-box-yellow"><?php _e("Report is null.");?></div>                    
        <?php
        }
        $output = ob_get_clean();
        return $output;        
    }
    
    public static function gen_email_content($report) {      
        if (is_object($report)) {                
            try {
                $filtered_report = self::filter_report($report);                
                $report = $filtered_report;
            } catch (Exception $e) 
            {                
            }                        
            return self::gen_report_content($report);            
        }        
        return false;        
    }
    
    public static function gen_report_content($report) {  
        $logo_url = "";
        if (!empty($report->logo_file)) {
            $creport_url = apply_filters('mainwp_getspecificurl',"client_report/");
            $logo_url = $creport_url.$report->logo_file;
        } 
        ob_start();                    
    ?>
        <br>
        <div>
            <br>
            <div style="background:#ffffff;padding:0 1.618em;font:13px/20px Helvetica,Arial,Sans-serif;padding-bottom:50px!important">
                <div style="width:600px;background:#fff;margin-left:auto;margin-right:auto;margin-top:10px;margin-bottom:25px;padding:0!important;border:10px Solid #fff;border-radius:10px;overflow:hidden">
                    <div style="display: block; width: 100% ; ">
                      <div style="display: block; width: 100% ; padding: .5em 0 ;">
                          <div style="float: left;">
                              <?php echo nl2br($report->header); ?>
                          </div>
                          <?php 
                          if (!empty($logo_url)) {
                            ?>                                      
                            <div style="float: right; margin-top: .6em ;">                                        
                               <img src="<?php echo $logo_url ?>" alt="Logo" height="80"/>
                            </div>
                            <?php
                          }
                          ?>
                        <div style="clear: both;"></div>
                      </div>
                    </div>
                    <br><br><br>
                    <div>
                        <?php echo nl2br($report->body); ?>
                    </div>
                    <br><br><br>
                    <div style="display: block; width: 100% ;">
                        <?php echo nl2br($report->footer); ?>
                   </div>                                
                    <br><br><br>
                    <?php
                        $preriod = !empty($report->date_from) ? date("m/d/Y", $report->date_from) : "";
                        $preriod .= !empty($report->date_to) ? " to " . date("m/d/Y", $report->date_to) : "";
                    ?>
                    <div style="color:#858585;font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:150%;padding-bottom:5px;text-align:left">
                        <?php echo (!empty($report->name)) ? stripslashes($report->fname) . "<br>" : ""; ?>
                        <?php echo (!empty($report->name)) ? stripslashes($report->fcompany) . "<br>" : ""; ?>
                        <?php echo (!empty($report->name)) ? stripslashes($report->femail) . "<br>" : ""; ?>
                        <?php echo _e("Report Created on") . " " . date("m/d/Y").  "<br>"; ?>
                        <?php echo _e("For Period from ") . " " . $preriod . "<br>"; ?>                                    
                        <br>
                        <br>
                    </div>                               
                    <?php
                    $report
                    ?>
                </div>                            
            </div>
        </div>               
    <?php
        $output = ob_get_clean();
        return $output; 
    }
    
    public static function filter_report($report) {         
        global $mainWPCReportExtensionActivator;
        $website = null;
        if ($report->selected_site) {
            global $mainWPCReportExtensionActivator;
            $website = apply_filters('mainwp-getsites', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), $report->selected_site);            
            if ($website && is_array($website)) {
                $website = current($website);
            }  
        }
        
        if (!is_array($website) || empty($website['id']))
            return $report;
        
        $tokens = MainWPCReportDB::Instance()->getTokens();
        $site_tokens = MainWPCReportDB::Instance()->getSiteTokens($website['url']);        
        $search_tokens = $replace_values = array();
        foreach ($tokens as $token) {            
            $search_tokens[] = '[' . $token->token_name . ']';            
            $replace_values[] = isset($site_tokens[$token->id]) ? $site_tokens[$token->id]->token_value : "";            
        }    
        $report->header = self::replace_content($report->header, $search_tokens, $replace_values);        
        $report->body = self::replace_content($report->body, $search_tokens, $replace_values);        
        $report->footer = self::replace_content($report->footer, $search_tokens, $replace_values);        

        $all_tokens = array();
        foreach (self::$stream_tokens as $group => $tokens) {
            foreach($tokens as $token) {                
                $all_tokens[] = '[' . $token['name'] . ']';
            }                 
        } 

        $report_tokens = self::get_report_stream_tokens($report, $all_tokens);
        
        if (is_array($report_tokens) && count($report_tokens) > 0)
            $report = self::filter_stream_tokens($report, $report_tokens, $website);        

        return $report;
    } 
    
    public static function replace_content($content, $tokens, $replace_tokens) {
        return str_replace($tokens, $replace_tokens, $content);                
    }
    
    public static function get_report_stream_tokens($report, $all_tokens) {
        $matches = array();
        $report_tokens = array();
//        if(preg_match_all("/\[[^\]]+\]/is" , $report->header, $matches)) {
//            if (isset($matches[0]) && is_array($matches[0]) && count($matches[0]) > 0) {
//                $report_tokens = $matches[0];
//            }
//        }
        
        $matches = array();        
        $report->body = self::remove_section_tokens($report->body);        
        if(preg_match_all("/\[[^\]]+\]/is" , $report->body, $matches)) {
            if (isset($matches[0]) && is_array($matches[0]) && count($matches[0]) >0 ) {
                $report_tokens = array_merge($report_tokens, $matches[0]);
            }
        }
        
//        $matches = array();        
//        if(preg_match_all("/\[[^\]]+\]/is" , $report->footer, $matches)) {
//            if (isset($matches[0]) && is_array($matches[0]) && count($matches[0]) > 0) {
//                $report_tokens = array_merge($report_tokens, $matches[0]);
//            }
//        }
            
        $valid_tokens = array();
        foreach($report_tokens as $token) {
            if (in_array($token, $all_tokens))
                $valid_tokens[] = $token;
        }         
        return $valid_tokens;        
    }    
    
    public static function remove_section_tokens($content) {        
        $matches = array(); 
        $section_tokens = array();
        if(preg_match_all("/\[\/?section\.[^\]]+\]/is" , $content, $matches)) {
            $section_tokens = $matches[0];
        }
        return str_replace($section_tokens, "", $content);                
    }

    public static function filter_stream_tokens($report, $tokens, $website) {    
        global $mainWPCReportExtensionActivator;
        $post_data = array( 'mwp_action' => 'get_stream',
                            'stream_tokens' => base64_encode(serialize($tokens)),
                            'date_from' => date("Y-m-d H:i:s", $report->date_from),
                            'date_to' => date("Y-m-d H:i:s", $report->date_to));
        
        $information = apply_filters('mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), $website['id'], 'client_report', $post_data);			                             
//        print_r($information);
        if (is_array($information) && isset($information['token_values'])) {            
            $token_values = $information['token_values'];
            if (is_array($token_values) && count($token_values) > 0) {
                $search_tokens = $replace_values = array();
                foreach ($tokens as $token) {                   
                    $search_tokens[] = $token;       
                    $replace = "";
                    $values = isset($token_values[$token]) ? $token_values[$token] : array();                    
                    foreach ($values as $value) {
                        $replace .= $website['name'] . " - " . $value ."<br>";
                    }   
                    $replace_values[] = $replace;            
                }                  
                //$report->header = self::replace_content($report->header, $search_tokens, $replace_values);        
                $report->body = self::replace_content($report->body, $search_tokens, $replace_values);        
                //$report->footer = self::replace_content($report->footer, $search_tokens, $replace_values);        
            }
        } else {
            $error = is_array($information) ? @implode("<br>", $information) : $information;
            throw new Exception($error);
        }       
        return $report;
    }
    
    public static function reportTab() {
        $orderby = "title";    
        $order = "asc";
        
        if (isset($_GET['orderby']) && !empty($_GET['orderby'])) {            
            $orderby = $_GET['orderby'];
        }    
        if (isset($_GET['order']) && !empty($_GET['order'])) {            
            $order = $_GET['order'];
        }        
        
        $title_order = $name_order = $lastsend_order = $nextsend_order = "";                     
        if (isset($_GET['orderby']) && $_GET['orderby'] == "title") {            
            $title_order = ($order == "desc") ? "asc" : "desc";                     
        } else if (isset($_GET['orderby']) && $_GET['orderby'] == "name") {            
            $name_order = ($order == "desc") ? "asc" : "desc";                     
        } else if (isset($_GET['orderby']) && $_GET['orderby'] == "lastsend") {
            $lastsend_order = ($order == "desc") ? "asc" : "desc";                     
        } else if (isset($_GET['orderby']) && $_GET['orderby'] == "nextsend") {
            $nextsend_order = ($order == "desc") ? "asc" : "desc";                     
        } 
        
        $reports = MainWPCReportDB::Instance()->getReportBy('all', null, $orderby, $order);
    ?>
         <table id="mainwp-table" class="wp-list-table widefat" cellspacing="0">
            <thead>
                <tr> 
                    <th scope="col" class="manage-column sortable <?php echo $title_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=title&order=<?php echo (empty($title_order) ? 'asc' : $title_order); ?>"><span><?php _e('Title','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=name&order=<?php echo (empty($name_order) ? 'asc' : $name_order); ?>"><span><?php _e('Send To','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>                
                    <th scope="col" class="manage-column sortable <?php echo $lastsend_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=lastsend&order=<?php echo (empty($lastsend_order) ? 'asc' : $lastsend_order); ?>"><span><?php _e('Last Report Send','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column sortable <?php echo $nextsend_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=nextsend&order=<?php echo (empty($nextsend_order) ? 'asc' : $nextsend_order); ?>"><span><?php _e('Next Report','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                </tr>
            </thead>
            <tfoot>
               <tr> 
                    <th scope="col" class="manage-column sortable <?php echo $title_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=title&order=<?php echo (empty($title_order) ? 'asc' : $title_order); ?>"><span><?php _e('Title','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=send&order=<?php echo (empty($name_order) ? 'asc' : $name_order); ?>"><span><?php _e('Send To','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>                
                    <th scope="col" class="manage-column sortable <?php echo $lastsend_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=lastsend&order=<?php echo (empty($lastsend_order) ? 'asc' : $lastsend_order); ?>"><span><?php _e('Last Report Send','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column sortable <?php echo $nextsend_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=nextsend&order=<?php echo (empty($nextsend_order) ? 'asc' : $nextsend_order); ?>"><span><?php _e('Next Report','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                </tr>
            </tfoot>
            <tbody>
             <?php                             
                self::reportTableContent($reports);                               
             ?>
            </tbody>
        </table>     
    <?php
    }
    
    
    public static function reportTableContent($reports) {
        
        if (!is_array($reports) || count($reports) == 0)
        { 
        ?>
            <tr><td colspan="4"><?php _e("No reports were found.");?></td></tr>
        <?php
            return;            
        }   
        $url_loader = plugins_url('images/loader.gif', dirname(__FILE__));
        foreach ($reports as $report) {
    ?>   
        <tr id="<?php echo $report->id; ?>">            
            <td>
                <a href="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=editreport&id=<?php echo $report->id; ?>"><strong><?php echo stripslashes($report->title); ?></strong></a>
                <div class="row-actions"><a href="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=editreport&id=<?php echo $report->id; ?>"><?php _e("Edit");?></a></span> |  
                    <a href="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=sendreport&id=<?php echo $report->id; ?>"><?php _e("Send");?></a> | 
                    <span class="delete"><a href="#" class="mwp-creport-report-item-delete-lnk"><?php _e("Delete");?></a></span> 
                </div>                     
                <span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>
            </td> 
            <td>
                <?php echo $report->name . " - " . $report->company ."<br>" . (!empty($report->email) ? "<a href=\"mailto:" . $report->email ."\">" . $report->email . "</a>" : ""); ?>
            </td> 
            <td> 
                <?php echo !empty($report->lastsend) ? MainWPCReportUtility::formatTimestamp($report->lastsend) : ""; ?>
            </td>
            <td> 
                <?php echo !empty($report->nextsend) ? MainWPCReportUtility::formatTimestamp($report->nextsend) : ""; ?>
            </td>
        </tr>
    <?php
        }    
    }       
        
    public static function newReportTab($report = null) {
        self::newReportSetting($report);
        self::newReportFormat($report);
    }
    
    public static function newReportSetting($report = null) {
    ?>
        <fieldset class="mainwp-creport-report-setting-box">
            <table class="wp-list-table widefat" cellspacing="0">
                <thead>
                <tr>          
                    <th scope="col" colspan="2">
                        <?php _e('Client Report Settings','mainwp'); ?>
                    </th>
                </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="border:none !important" colspan="2">&nbsp;</th>
                    </tr>
                </tfoot>
                <tbody>
                 <?php                             
                    self::newReportSettingTableContent($report);                               
                 ?>
                </tbody>
            </table>         
        </fieldset>
     <?php
    }
    
    public static function newReportFormat($report) {
    ?>        
        <table class="wp-list-table widefat" cellspacing="0">
            <thead>
            <tr>          
                <th scope="col" colspan="2">
                    <?php _e('Report Format','mainwp'); ?>
                </th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th style="border:none !important;" colspan="2">&nbsp;</th>
                </tr>
            </tfoot>
            <tbody>
             <?php                             
                self::newReportFormatTableContent($report);                               
             ?>
            </tbody>
        </table>
     <?php
    }
    
    public static function newReportSettingTableContent($report = null) {
        $title = $date_from = $date_to = "";
        $from_name = $from_company = $from_email = "";
        $to_name = $to_company = $to_email = "";
        
        if ($report && is_object($report)) {
            $title = $report->title;
            $date_from = !empty($report->date_from) ? date("Y-m-d", $report->date_from) : "";
            $date_to = !empty($report->date_to) ? date("Y-m-d", $report->date_to) : "";
            $from_name = $report->fname;
            $from_company = $report->fcompany;
            $from_email = $report->femail;            
            $to_name = $report->name;
            $to_company = $report->company;
            $to_email = $report->email;
        } else if (isset($_POST['submit'])){
            $title =  isset($_POST['mwp_creport_title']) ? trim($_POST['mwp_creport_title']) : "";
            $date_from =  isset($_POST['mwp_creport_date_from']) ? trim($_POST['mwp_creport_date_from']) : "";
            $date_to =  isset($_POST['mwp_creport_date_to']) ? trim($_POST['mwp_creport_date_to']) : "";
            $from_name =  isset($_POST['mwp_creport_fname']) ? trim($_POST['mwp_creport_fname']) : "";
            $from_company =  isset($_POST['mwp_creport_fcompany']) ? trim($_POST['mwp_creport_fcompany']) : "";
            $from_email =  isset($_POST['mwp_creport_femail']) ? trim($_POST['mwp_creport_femail']) : "";
            $to_name =  isset($_POST['mwp_creport_name']) ? trim($_POST['mwp_creport_name']) : "";
            $to_company =  isset($_POST['mwp_creport_company']) ? trim($_POST['mwp_creport_company']) : "";
            $to_email =  isset($_POST['mwp_creport_email']) ? trim($_POST['mwp_creport_email']) : "";
        }
            
    ?>  
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <th><span><?php _e("Title"); ?> <span class="desc-light"><?php _e("(required)"); ?></span></span></th>
            <td class="title">
                <input type="text" name="mwp_creport_title" id="mwp_creport_title" value="<?php echo stripslashes($title); ?>" />
            </td>
        </tr>
        <tr>
            <th><span><?php _e("Date Range"); ?></span></th>
            <td class="date">
                <input type="text" name="mwp_creport_date_from" id="mwp_creport_date_from" class="mainwp_creport_datepicker" value="<?php echo $date_from; ?>"/>&nbsp;&nbsp;To&nbsp;&nbsp;<input type="text" class="mainwp_creport_datepicker" name="mwp_creport_date_to" id="mwp_creport_date_to" value="<?php echo $date_to; ?>" />
            </td>           
        </tr>
        <tr>
            <th><span><?php _e("Send From"); ?></span></th>
            <td>
                <input type="text" name="mwp_creport_fname" placeholder="Name" value="<?php echo stripslashes($from_name); ?>" />&nbsp;&nbsp;
                <input type="text" name="mwp_creport_fcompany" placeholder="Company" value="<?php echo stripslashes($from_company); ?>" />&nbsp;&nbsp;
                <input type="text" name="mwp_creport_femail" placeholder="Email" value="<?php echo stripslashes($from_email); ?>" />
            </td>
        </tr>
        <tr>
            <th><span><?php _e("Send To"); ?></span></th>
            <td>
                <input type="text" name="mwp_creport_name" placeholder="Name" value="<?php echo stripslashes($to_name); ?>" />&nbsp;&nbsp;
                <input type="text" name="mwp_creport_company" placeholder="Company" value="<?php echo stripslashes($to_company); ?>" />&nbsp;&nbsp;
                <input type="text" name="mwp_creport_email" placeholder="Email" value="<?php echo stripslashes($to_email); ?>" />
            </td>
        </tr>
    <?php
    }            
    
    public static function newReportFormatTableContent($report = null) {
        $header = $body = $footer = $file_logo = "";
        
        if ($report && is_object($report)) {
            $header = $report->header;
            $body = $report->body;
            $footer = $report->footer;
            $file_logo = $report->logo_file;            
        } else if (isset($_POST['submit'])){
            $header = $_POST['mainwp_creport_report_header'];
            $body = $_POST['mainwp_creport_report_body'];
            $footer = $_POST['mainwp_creport_report_footer'];            
        }
            
    ?>  
        <tr>
            <th><span><?php _e("Report Header"); ?></span></th>
            <td>
            <?php 
                remove_editor_styles(); // stop custom theme styling interfering with the editor
                wp_editor( stripslashes($header), 'mainwp_creport_report_header', array(
                        'textarea_name' => 'mainwp_creport_report_header',
                        'textarea_rows' => 5,
                        'teeny' => true,
                        'media_buttons' => false,
                    )
                );                
            ?>
            </td> 
        </tr>    
        <tr>
            <th><span><?php _e("Report Body"); ?></span></th>
            <td>
            <?php 
                remove_editor_styles(); // stop custom theme styling interfering with the editor
                wp_editor( stripslashes($body), 'mainwp_creport_report_body', array(
                        'textarea_name' => 'mainwp_creport_report_body',
                        'textarea_rows' => 5,
                        'teeny' => true,
                        'media_buttons' => false,
                    )
                );                
            ?>
                <br/>
                <div class="creport_format_data_tokens">
                <?php
                    $visible = "Plugin Sections";
                    foreach (self::$stream_tokens as $group => $tokens) {
                        ?>
                        <div class="creport_format_group_data_tokens <?php echo ($visible == $group) ? "current" : ""; ?>" group="<?php echo $group; ?>">
                            <table>
                            <?php                            
                            foreach($tokens as $token) {
                               echo "<tr><td><a href=\"#\" class=\"creport_format_add_token\">[" . $token["name"] . "]</a></td>"
                                       . "<td class=\"creport_stream_token_desc\">" . $token["desc"] ."</td>"
                                       . "</tr>";
                            }
                            ?>
                            </table>
                        </div>
                        <?php
                    }                
                ?>                
                    <div class="creport_format_group_nav">
                        <?php
                            $nav_group = "";
                            foreach (self::$stream_tokens as $group => $tokens) {
                                $gname = str_replace("_", " ", $group);
                                $gname = ucwords($gname);
                                $current = ($visible == $group) ? "current" : "";
                                $nav_group .= '<a href="#" group="' . $group . '" class="creport_nav_group_lnk ' . $current . '">' . $gname . '</a> | ';                                
                            }  
                            $nav_group = rtrim($nav_group, ' | ');
                            echo $nav_group;
                        ?>                
                    </div>
                </div>
                
            </td> 
        </tr>   
        <tr>
            <th><span><?php _e("Report Footer"); ?></span></th>
            <td>
            <?php 
                remove_editor_styles(); // stop custom theme styling interfering with the editor
                wp_editor( stripslashes($footer), 'mainwp_creport_report_footer', array(
                        'textarea_name' => 'mainwp_creport_report_footer',
                        'textarea_rows' => 5,
                        'teeny' => true,
                        'media_buttons' => false,
                    )
                );                
            ?>
            </td> 
        </tr> 
        <tr>
            <th><span><?php _e("Logo"); ?></span></th>
            <td>  
                <?php 
                if (!empty($file_logo)) {           
                    $imageurl = apply_filters('mainwp_getspecificurl',"client_report") . $file_logo;
                    ?>
                    <p class="mwp_creport_logo_image"><img class="brd_login_img" src="<?php echo $imageurl ?>"/></p>                                
                    <p>
                        <input type="checkbox" class="mainwp-checkbox2" value="1" id="mainwp_creport_delete_logo_image" name="mainwp_creport_delete_logo_image">
                        <label class="mainwp-label2" for="mainwp_creport_delete_logo_image"><?php _e("Delete Logo", "mainwp");?></label>
                    </p><br/>
                <?php                      
                }
                ?>                                
                <input type="file" name="mainwp_creport_logo_file" accept="image/*" />
            </td>
        </tr>
    <?php
    
    }       
    
    public function site_token($website) {          
        global $wpdb;         
        $tokens = MainWPCReportDB::Instance()->getTokens();

        $site_tokens = array();
        if ($website)
            $site_tokens = MainWPCReportDB::Instance()->getSiteTokens($website->url);

        $html = '<fieldset class="mainwp-fieldset-box"> 
                            <legend>Client Report Settings</legend>';          
        if (is_array($tokens) && count($tokens) > 0) {
            $html .= '<table class="form-table" style="width: 100%">';
             foreach ($tokens as $token) { 
                    if (!$token)
                            continue;
                    $token_value = "";
                    if (isset($site_tokens[$token->id]) && $site_tokens[$token->id])
                        $token_value = htmlspecialchars(stripslashes($site_tokens[$token->id]->token_value)); 

                    $input_name = "creport_token_" . str_replace(array('.', " ", "-"), '_', $token->token_name);
                    $html .= '<tr>						
                            <th scope="row" class="token-name" >[' . stripslashes($token->token_name) . ']</th>        
                            <td>										
                            <input type="text" value="' . $token_value . '" class="regular-text" name="' . $input_name  . '"/>	
                            </td>					   		
                    </tr>';
             }
             $html .= '</table>';                
        }
        else
        {
            $html .= "Not found tokens.";
        }
        $html .= '<div class="mainwp_info-box"><strong><b>Note</b>: <i>Add or Edit Client Report Tokens in the <a target="_blank" href="' . admin_url('admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=token') . '">Client Report Extension Settings</a></i>.</strong></div>									
                </fieldset>';
        echo $html;      
    }
    
     public function update_site_update_tokens($websiteId) 
    {
        global $wpdb, $mainWPCReportExtensionActivator;      
        if (isset($_POST['submit'])) {                          
            $website = apply_filters('mainwp-getsites', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), $websiteId);            
            if ($website && is_array($website)) {
                $website = current($website);
            }    
            
            if (!is_array($website))
                return;
            
            $tokens = MainWPCReportDB::Instance()->getTokens();               
            foreach ($tokens as $token) {               
                $input_name = "creport_token_" . str_replace(array('.', " ", "-"), '_', $token->token_name);                
                if (isset($_POST[$input_name])) {                                        
                    $token_value = $_POST[$input_name];
                    
                    // default token
//                    if ($token->type == 1 && empty($token_value)) 
//                        continue;
                        
                    $current = MainWPCReportDB::Instance()->getTokensBy('id', $token->id, $website['url']);                    
                    if($current){                    
                        MainWPCReportDB::Instance()->updateTokenSite($token->id, $token_value, $website['url']);                                                
                    } else {
                        MainWPCReportDB::Instance()->addTokenSite($token->id, $token_value, $website['url']);                                                   
                    }                        
                }
            }            
        }
    }
    
    public function delete_site_delete_tokens($website) 
    {
        global $wpdb;
        if (isset($_POST['submit'])) {            
            if ($website) {                
                MainWPCReportDB::Instance()->deleteSiteTokens($website->url);             
            }
        }
    }
    
    public function load_tokens() {
        $tokens = MainWPCReportDB::Instance()->getTokens();  
        ?>
        <div class="creport_list_tokens">
        <table width="100%">
            <tbody> 
                <?php  
                if (is_array($tokens) && count($tokens) > 0) {            
                    foreach ( (array)$tokens as $token ){
                        if ( ! $token )
                                continue;
                        echo $this->createTokenItem($token);
                    }
                }
                ?>
                <tr class= "managetoken-item">
                     <td class="token-name">                            
                        <span class="actions-input input"><input type="text" value=""  name="token_name" placeholder="Enter a Token"></span>
                    </td>        
                    <td class="token-description">                            
                        <span class="actions-input input">
                            <input type="text" value="" class="token_description" name="token_description" placeholder="Enter a Token Description">                            
                        </span>
                        <span class="mainwp_more_loading"><img src="<?php echo $this->clientReportExt->plugin_url.'images/loader.gif'; ?>"/></span>
                    </td>
                    <td class="token-option"><input type="button" value="Save" class="button-primary right" id="creport_managetoken_btn_add_token"></td>       
                </tr>       

            </tbody>
        </table> 
        </div>
         <?php        
        exit; 
    }
    
     public function delete_token() {
        global $wpdb;
        $ret = array('success' => false);        
        $token_id = intval($_POST['token_id']);
        if (MainWPCReportDB::Instance()->deleteTokenBy("id", $token_id)) {                
            $ret['success'] = true;
        } 
        echo json_encode($ret);
        exit;
    }
	
    public function save_token() {
        global $wpdb;
        $return = array('success' => false, 'error' => '', 'message' => '');      
        $token_name = sanitize_text_field($_POST['token_name']);
        $token_description = sanitize_text_field($_POST['token_description']);
        
        // update
        if (isset($_POST['token_id']) && $token_id = intval($_POST['token_id'])) {             
            $current = MainWPCReportDB::Instance()->getTokensBy('id', $token_id);
            if ($current && $current->token_name == $token_name && $current->token_description == $token_description){
                $return['success'] = true;   
                $return['message'] = __('The token does not change.');                
                $return['row_data'] = $this->createTokenItem($current, false);   
            } else  if (($current = MainWPCReportDB::Instance()->getTokensBy('token_name', $token_name)) && $current->id != $token_id){
                $return['error'] = __('The token name existed.');
            } else if ($token = MainWPCReportDB::Instance()->updateToken($token_id, array('token_name' => $token_name, 'token_description' => $token_description, ))) { 
                $return['success'] = true;   
                $return['row_data'] = $this->createTokenItem($token, false);   
            }
        } else { // add new
            if ($current = MainWPCReportDB::Instance()->getTokensBy('token_name', $token_name)){
                $return['error'] = __('The token name existed.');
            } else {
                if ($token = MainWPCReportDB::Instance()->addToken(array('token_name' => $token_name, 'token_description' => $token_description, 'type' => 0))) { 
                    $return['success'] = true;   
                    $return['row_data'] = $this->createTokenItem($token);   
                } else
                    $return['error'] = __('Error: Add token failed.');
            }
        }        
        echo json_encode($return);
        exit;
    }
    
    private function createTokenItem($token, $with_tr = true)
    {
        $colspan = $html = "";
        if ($token->type == 1)
            $colspan = ' colspan="2" ';
        if ($with_tr)
            $html =  '<tr class="managetoken-item" token_id="' . $token->id . '">';
        
        $html .= '<td class="token-name">                            
                    <span class="text" ' . (($token->type == 1) ? '' : 'value="' . $token->token_name) . '">[' . stripslashes($token->token_name) . ']</span>' .
                        (($token->type == 1) ? '' : '<span class="input hidden"><input type="text" value="' . htmlspecialchars(stripslashes($token->token_name)) . '" name="token_name"></span>') .
                '</td>        
                <td class="token-description" ' . $colspan . '>                            
                    <span class="text" ' . (($token->type == 1) ? '' : 'value="' . stripslashes($token->token_description)) . '">' . stripslashes($token->token_description) . '</span>';
         if ($token->type != 1) { 
            $html .= '<span class="input hidden"><input type="text" value="' . htmlspecialchars(stripslashes($token->token_description)) . '" name="token_description"></span>
                        <span class="mainwp_more_loading"><img src="' . $this->clientReportExt->plugin_url . 'images/loader.gif"/></span>';                        
            } 
        $html .= '</td>';
        
        if($token->type == 0) {                            
            $html .= '<td class="token-option">
                    <span class="mainwp_group-actions actions-text" ><a class="creport_managetoken-edit" href="#">' .__('Edit','mainwp') .'</a> | <a class="creport_managetoken-delete" href="#">' . __('Delete','mainwp') . '</a></span>
                    <span class="mainwp_group-actions actions-input hidden" ><a class="creport_managetoken-save" href="#">' . __('Save','mainwp') . '</a> | <a class="creport_managetoken-cancel" href="#">' . __('Cancel','mainwp') . '</a></span>
                </td>'; 
        }      
        if ($with_tr)
            $html .= '</tr>';      
        
        return $html;
    }
    
    public function delete_report() {
        global $wpdb;
        $ret = array();        
        $id = intval($_POST['reportId']);
        if ($id && MainWPCReportDB::Instance()->deleteReportBy('id', $id))                 
            $ret['status'] = 'success';        
        echo json_encode($ret);
        exit;
    }
    
}
