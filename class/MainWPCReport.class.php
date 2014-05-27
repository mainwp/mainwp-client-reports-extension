<?php
class MainWPCReport
{    
    private $clientReportExt;
    private static $format_tokens;
    
    public function __construct($ext) {    
        $this->clientReportExt = $ext;
        self::$format_tokens = array("WordPress" => array(),
            "plugins"=>array(array("name" => "plugin.name", "desc" => "Token Description"),
                            array("name" => "plugin.oldversion", "desc" => "Token Description"),
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
            "posts"=>array(array("name" => "post.title", "desc" => "Token Description"),
                           array("name" => "post.add.date", "desc" => "Token Description"),
                           array("name" => "post.add.count", "desc" => "Token Description")),
            "pages"=>array(array("name" => "page.title", "desc" => "Token Description"),
                            array("name" => "page.add.date", "desc" => "Token Description"),
                            array("name" => "page.add.count", "desc" => "Token Description")),
            "backups"=>array(),
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
            $do_save = true;
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $report['id'] = $_POST['id'];
            }
            
            if(isset($_POST['mwp_creport_title']) && ($title = trim($_POST['mwp_creport_title'])) != "")
                $report['title'] = $title;                
            else {
                $errors[] = "Report Title can not be empty.";
                $do_save = false;
            }
            $start_time = $end_time = 0;
            if(isset($_POST['mwp_creport_startdate']) && ($start_date = trim($_POST['mwp_creport_startdate'])) != "") {
                $start_time = strtotime($start_date);                
            } 
           
            if(isset($_POST['mwp_creport_enddate']) && ($end_date = trim($_POST['mwp_creport_enddate'])) != "") {
                $end_time = strtotime($end_date);                
            } 
            
            if (($start_time != 0 && $end_time != 0) && ($start_time > $end_time)) {
                $tmp = $start_time;
                $start_time = $end_time;
                $end_time = $tmp;                
            }
            
            $report['startdate'] = $start_time;
            $report['enddate'] = $end_time;                
            
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
           
            if ($do_save) {
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
            }
            
            $selected_wp = $selected_group = array(); 
            if (isset($_POST['select_by'])) {                            
                if (isset($_POST['selected_sites']) && is_array($_POST['selected_sites'])) {                    
                    foreach ($_POST['selected_sites'] as $selected) {
                        $selected_wp[] = $selected;
                    }                    
                }                                                
                if (isset($_POST['selected_groups']) && is_array($_POST['selected_groups'])) {                    
                    foreach ($_POST['selected_groups'] as $selected) {
                        $selected_group[] = $selected;
                    }                    
                }
            }                
            $report['sites'] = serialize($selected_wp);
            $report['groups']  = serialize($selected_group);            
            
            $return = array();
            if ($do_save) {
                if($result = MainWPCReportDB::Instance()->updateReport($report)) {                    
                    $return['id'] = $result->id;                    
                    $messages[] = 'Report saved.';  
                } else {
                    $messages[] = "Report not change.";            
                }
                $return['updated'] = true;
            }             
            
            if (count($errors) > 0) 
                $return['error'] = $errors;  
            
            if (count($messages) > 0) 
                $return['message'] = $messages;
            
            return $return;
        }
        return null;
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
        $report = null;
        
        // update report if requested
        $result = self::saveReport();        
        if (is_array($result)) {
            if (isset($result['message'])) {
                $report = MainWPCReportDB::Instance()->getReportBy('id', $result['id']);  
                $messages = $result['message'];
            } 
            if (isset($result['error'])) {
                $errors = $result['error'];
            }
        } 
        
        $str_error = (count($errors) > 0) ? implode("<br/>", $errors) : "";
        $str_message = (count($messages) > 0) ? implode("<br/>", $messages) : "";
        
        $style_tab_report = $style_tab_new = $style_tab_token = ' style="display: none" ';
                
        
        if (isset($_REQUEST['action'])) {                
            if ($_REQUEST['action'] == "token") {            
                $style_tab_token = '';                
            } else if ($_REQUEST['action'] == "editreport") {
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $report = MainWPCReportDB::Instance()->getReportBy('id', $_GET['id']);  
                }
                $style_tab_new = '';            
            } 
        } else {
            $style_tab_report = "";
        }
        
        $selected_websites = $selected_groups = array();          
        if ($report && is_object($report)) {
            $selected_websites = unserialize($report->sites);
            $selected_groups = unserialize($report->groups);
        } else  {
            if (isset($_POST['select_by'])) {                            
                if (isset($_POST['selected_sites']) && is_array($_POST['selected_sites'])) {                    
                    foreach ($_POST['selected_sites'] as $selected) {
                        $selected_websites[] = $selected;
                    }                    
                }                                                
                if (isset($_POST['selected_groups']) && is_array($_POST['selected_groups'])) {                    
                    foreach ($_POST['selected_groups'] as $selected) {
                        $selected_groups[] = $selected;
                    }                    
                }
            }
        }
       
        if (!is_array($selected_websites))
            $selected_websites = array();
        if (!is_array($selected_groups))
            $selected_groups = array();
        
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
                        <form method="post" enctype="multipart/form-data" action="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=editreport">
                            <div id="creport_select_sites_box" class="mainwp_config_box_right" <?php echo $style_tab_new; ?>>
                            <?php do_action('mainwp_select_sites_box', __("Select Sites", 'mainwp'), 'radio', true, true, 'mainwp_select_sites_box_right', "", $selected_websites, $selected_groups); ?>
                            </div>
                            <div id="wpcr_new_tab"  <?php echo $style_tab_new; ?>>
                                <?php self::newReportTab($report); ?>  
                                <p class="submit" style="float:right;">
                                    <input type="button" value="<?php _e("Preview Report"); ?>" class="button" id="button" name="button">
                                    <input type="submit" value="<?php _e("Send Report"); ?>" class="button-primary" id="submit" name="submit">
                                </p>
                            </div>   
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

        <script>
            jQuery(document).ready(function($){    
                mainwp_creport_load_tokens();    
            });
        </script>        
    <?php
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
                    <a href="#" class="mwp-creport-report-item-send-lnk"><?php _e("Send");?></a> | 
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
        $title = $startdate = $enddate = "";
        $from_name = $from_company = $from_email = "";
        $to_name = $to_company = $to_email = "";
        
        if ($report && is_object($report)) {
            $title = $report->title;
            $startdate = !empty($report->startdate) ? date("Y-m-d", $report->startdate) : "";
            $enddate = !empty($report->enddate) ? date("Y-m-d", $report->enddate) : "";
            $from_name = $report->fname;
            $from_company = $report->fcompany;
            $from_email = $report->femail;            
            $to_name = $report->name;
            $to_company = $report->company;
            $to_email = $report->email;
        } else if (isset($_POST['submit'])){
            $title =  isset($_POST['mwp_creport_title']) ? trim($_POST['mwp_creport_title']) : "";
            $startdate =  isset($_POST['mwp_creport_startdate']) ? trim($_POST['mwp_creport_startdate']) : "";
            $enddate =  isset($_POST['mwp_creport_enddate']) ? trim($_POST['mwp_creport_enddate']) : "";
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
            <th><span>Title <span class="desc-light">(required)</span></span></th>
            <td class="title">
                <input type="text" name="mwp_creport_title" value="<?php echo stripslashes($title); ?>" />
            </td>
        </tr>
        <tr>
            <th><span>Date Range</span></th>
            <td class="date">
                <input type="text" name="mwp_creport_startdate" class="mainwp_creport_datepicker" value="<?php echo $startdate; ?>"/>&nbsp;&nbsp;To&nbsp;&nbsp;<input type="text" class="mainwp_creport_datepicker" name="mwp_creport_enddate" value="<?php echo $enddate; ?>" />
            </td>           
        </tr>
        <tr>
            <th><span>Send From</span></th>
            <td>
                <input type="text" name="mwp_creport_fname" placeholder="Name" value="<?php echo stripslashes($from_name); ?>" />&nbsp;&nbsp;
                <input type="text" name="mwp_creport_fcompany" placeholder="Company" value="<?php echo stripslashes($from_company); ?>" />&nbsp;&nbsp;
                <input type="text" name="mwp_creport_femail" placeholder="Email" value="<?php echo stripslashes($from_email); ?>" />
            </td>
        </tr>
        <tr>
            <th><span>Send To</span></th>
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
            <th><span>Report Header</span></th>
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
            <th><span>Report Body</span></th>
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
                    $visible = "plugins";
                    foreach (self::$format_tokens as $group => $tokens) {
                        ?>
                        <div class="creport_format_group_data_tokens <?php echo ($visible == $group) ? "current" : ""; ?>" group="<?php echo $group; ?>">
                            <table>
                            <?php                            
                            foreach($tokens as $token) {
                               echo "<tr><td><a href=\"#\" class=\"creport_format_add_token\">[" . $token["name"] . "]</a></td>"
                                       . "<td class=\"creport_format_token_desc\">" . $token["desc"] ."</td>"
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
                            foreach (self::$format_tokens as $group => $tokens) {
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
            <th><span>Report Footer</span></th>
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
            <th><span>Logo</span></th>
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
            
            if (!$website)
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
