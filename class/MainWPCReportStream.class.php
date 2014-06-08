<?php
class MainWPCReportStream
{    
    private $option_handle = 'mainwp_creport_branding_option';
    private $option = array();
   
    private static $order = "";
    private static $orderby = "";
    
    //Singleton
    private static $instance = null;    
    static function Instance()
    {
        if (MainWPCReportStream::$instance == null) {
            MainWPCReportStream::$instance = new MainWPCReportStream();
        }
        return MainWPCReportStream::$instance;
    }
    
    public function __construct() {
        $this->option = get_option($this->option_handle);
    }
    
    public function admin_init() {       
        add_action('wp_ajax_mainwp_creport_upgrade_noti_dismiss', array($this,'dismissNoti'));
        add_action('wp_ajax_mainwp_creport_active_plugin', array($this,'active_plugin'));
        add_action('wp_ajax_mainwp_creport_upgrade_plugin', array($this,'upgrade_plugin')); 
        add_action('wp_ajax_mainwp_creport_showhide_stream', array($this,'showhide_stream')); 
    }
    
    public function get_option($key = null, $default = '') {
        if (isset($this->option[$key]))
            return $this->option[$key];
        return $default;
    }
    
    public function set_option($key, $value) {
        $this->option[$key] = $value;
        return update_option($this->option_handle, $this->option);
    }
    
    public static function gen_stream_dashboard_tab($websites) {

       $orderby = "name";    
       $_order = "desc";
       if (isset($_GET['stream_orderby']) && !empty($_GET['stream_orderby'])) {            
           $orderby = $_GET['stream_orderby'];
       }    
       if (isset($_GET['stream_order']) && !empty($_GET['stream_order'])) {            
           $_order = $_GET['stream_order'];
       }        

       $name_order = $version_order = $temp_order = $time_order = $url_order = "";     
       if (isset($_GET['stream_orderby']) && $_GET['stream_orderby'] == "name") {            
           $name_order = ($_order == "desc") ? "asc" : "desc";                     
       } else if (isset($_GET['stream_orderby']) && $_GET['stream_orderby'] == "version") {            
           $version_order = ($_order == "desc") ? "asc" : "desc";                     
       } else if (isset($_GET['stream_orderby']) && $_GET['stream_orderby'] == "template") {
           $temp_order = ($_order == "desc") ? "asc" : "desc";                     
       } else if (isset($_GET['stream_orderby']) && $_GET['stream_orderby'] == "time") {
           $time_order = ($_order == "desc") ? "asc" : "desc";                     
       } else if (isset($_GET['stream_orderby']) && $_GET['stream_orderby'] == "url") {
           $url_order = ($_order == "desc") ? "asc" : "desc";                     
       } 

//        echo $_GET['orderby']. "===" . $_order ."<br/>";
//        echo  $name_order . "=====" . $version_order . "=====" . $temp_order ;

       self::$order = $_order;
       self::$orderby = $orderby;        
       usort($websites, array('MainWPCReportStream', "stream_data_sort"));          
   ?>
       <table id="mainwp-table-plugins" class="wp-list-table widefat plugins" cellspacing="0">
         <thead>
         <tr>
           <th class="check-column">
               <input type="checkbox"  id="cb-select-all-1" >
           </th>
           <th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
               <a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=name&stream_order=<?php echo (empty($name_order) ? 'asc' : $name_order); ?>"><span><?php _e('Site','mainwp'); ?></span><span class="sorting-indicator"></span></a>
           </th>
           <th scope="col" class="manage-column sortable <?php echo $url_order; ?>">
               <a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=url&stream_order=<?php echo (empty($url_order) ? 'asc' : $url_order); ?>"><span><?php _e('URL','mainwp'); ?></span><span class="sorting-indicator"></span></a>
           </th>
           <th scope="col" class="manage-column sortable <?php echo $version_order; ?>">
               <a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=version&stream_order=<?php echo (empty($version_order) ? 'asc' : $version_order); ?>"><span><?php _e('Plugin Version','mainwp'); ?></span><span class="sorting-indicator"></span></a>
           </th>           
         </tr>
         </thead>
         <tfoot>
         <tr>
           <th class="check-column">
               <input type="checkbox"  id="cb-select-all-2" >
           </th>
           <th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
               <a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=name&stream_order=<?php echo (empty($name_order) ? 'asc' : $name_order); ?>"><span><?php _e('Site','mainwp'); ?></span><span class="sorting-indicator"></span></a>
           </th>
           <th scope="col" class="manage-column sortable <?php echo $url_order; ?>">
               <a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=url&stream_order=<?php echo (empty($url_order) ? 'asc' : $url_order); ?>"><span><?php _e('URL','mainwp'); ?></span><span class="sorting-indicator"></span></a>
           </th>
           <th scope="col" class="manage-column sortable <?php echo $version_order; ?>">
               <a href="?page=Extensions-Mainwp-Client-Reports-Extension&stream_orderby=version&stream_order=<?php echo (empty($version_order) ? 'asc' : $version_order); ?>"><span><?php _e('Plugin Version','mainwp'); ?></span><span class="sorting-indicator"></span></a>
           </th>            
         </tr>
         </tfoot>
           <tbody id="the-wp-stream-list" class="list:sites">
            <?php 
            if (is_array($websites) && count($websites) > 0) {                
               self::getStreamDashboardTableRow($websites);                  
            } else {
               _e("<tr><td colspan=\"6\">No websites were found with the Stream plugin installed.</td></tr>");
            }
            ?>
           </tbody>
     </table>
   <?php
   }

    public static function getStreamDashboardTableRow($websites) {   
       $dismiss = array();
       if (session_id() == '') session_start();        
       if (isset($_SESSION['mainwp_creport_dismiss_upgrade_stream_notis'])) {
           $dismiss = $_SESSION['mainwp_creport_dismiss_upgrade_stream_notis'];
       }                

       if (!is_array($dismiss))
           $dismiss = array();       
       
       $url_loader = plugins_url('images/loader.gif', dirname(__FILE__));
       
       foreach ($websites as $website) {
           $location = "admin.php?page=wp_stream";             
           $website_id = $website['id'];
           $template_title = empty($website['template_title']) ? "&nbsp;" : $website['template_title'];    
           $cls_active = (isset($website['stream_active']) && !empty($website['stream_active'])) ? "active" : "inactive";
           $cls_update = (isset($website['stream_upgrade'])) ? "update" : "";
           $cls_update = ($cls_active == "inactive") ? "update" : $cls_update;
           $showhide_action = ($website['hide_stream'] == 1) ? 'show' : 'hide';
           $showhide_link = '<a href="#" class="creport_showhide_plugin" showhide="' . $showhide_action . '">'. ($showhide_action === "show" ? __('Show Stream plugin') : __('Hide Stream plugin')) . '</a>';

           ?>
           <tr class="<?php echo $cls_active . " " . $cls_update; ?>" website-id="<?php echo $website_id; ?>">
               <th class="check-column">
                   <input type="checkbox"  name="checked[]">
               </th>
               <td>
                   <a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><?php echo $website['name']; ?></a><br/>
                   <div class="row-actions"><span class="dashboard"><a href="admin.php?page=managesites&dashboard=<?php echo $website_id; ?>"><?php _e("Dashboard");?></a></span> |  <span class="edit"><a href="admin.php?page=managesites&id=<?php echo $website_id; ?>"><?php _e("Edit");?></a> | <?php echo $showhide_link; ?></span></div>                    
                   <div class="creport-action-working"><span class="status" style="display:none;"></span><span class="loading" style="display:none;"><img src="<?php echo $url_loader; ?>"> <?php _e("Please wait..."); ?></span></div>
               </td>
               <td>
                   <a href="<?php echo $website['url']; ?>" target="_blank"><?php echo $website['url']; ?></a><br/>
                   <div class="row-actions"><span class="edit"><a target="_blank" href="admin.php?page=SiteOpen&newWindow=yes&websiteid=<?php echo $website_id; ?>"><?php _e("Open WP-Admin");?></a></span> | <span class="edit"><a href="admin.php?page=SiteOpen&newWindow=yes&websiteid=<?php echo $website_id; ?>&location=<?php echo base64_encode($location); ?>" target="_blank"><?php _e("Open Stream");?></a></span></div>                    
               </td>
               <td>
               <?php 
                   if (isset($website['stream_plugin_version']))
                       echo $website['stream_plugin_version'];
                   else 
                       echo "&nbsp;";
               ?>
               </td>               
           </tr>        
            <?php    
           if (!isset($dismiss[$website_id])) {  
               $active_link = $update_link = "";    
               $version = ""; 
               $plugin_slug = "stream/stream.php";
               if (isset($website['stream_active']) && empty($website['stream_active']))
                   $active_link = '<a href="#" class="creport_active_plugin" >' . __('Activate Stream plugin') . '</a>';


               if (isset($website['stream_upgrade'])) { 
                   if (isset($website['stream_upgrade']['new_version']))
                       $version = $website['stream_upgrade']['new_version'];
                   $update_link = '<a href="#" class="creport_upgrade_plugin" >' . __('Update Stream plugin'). '</a>';
                   if (isset($website['stream_upgrade']['plugin']))
                       $plugin_slug = $website['stream_upgrade']['plugin'];
               }

               if (!empty($active_link) || !empty($update_link)) {
                   $location = "plugins.php";                    
                   $link_row = $active_link .  ' | ' . $update_link;
                   $link_row = rtrim($link_row, ' | ');
                   $link_row = ltrim($link_row, ' | ');                    
                   ?>
                   <tr class="plugin-update-tr">
                       <td colspan="6" class="plugin-update">
                           <div class="ext-upgrade-noti update-message" plugin-slug="<?php echo $plugin_slug; ?>" website-id="<?php echo $website_id; ?>" version="<?php echo $version; ?>">
                               <span style="float:right"><a href="#" class="creport-stream-upgrade-noti-dismiss"><?php _e("Dismiss"); ?></a></span>                    
                               <?php echo $link_row; ?>
                               <span class="creport-stream-row-working"><span class="status"></span><img class="hidden-field" src="<?php echo plugins_url('images/loader.gif', dirname(__FILE__)); ?>"/></span>
                           </div>
                       </td>
                   </tr>
                   <?php  
               }
           }                
       }
   }

    public static function stream_data_sort($a, $b) {        
        if (self::$orderby == "version") {
            $a = $a['stream_plugin_version'];
            $b = $b['stream_plugin_version'];
            $cmp = version_compare($a, $b);            
        } else if (self::$orderby == "url"){
            $a = $a['url'];
            $b = $b['url'];   
            $cmp = strcmp($a, $b); 
        } else {
            $a = $a['name'];
            $b = $b['name'];   
            $cmp = strcmp($a, $b); 
        }     
        if ($cmp == 0)
            return 0;
        if (self::$order == 'desc')
            return ($cmp > 0) ? -1 : 1;
        else 
            return ($cmp > 0) ? 1 : -1;                        
    }

    public function get_websites_stream($websites, $selected_group = 0) {                       
        $websites_stream = array();        
        
        $streamHide = $this->get_option('hide_stream_plugin');
        
        if (!is_array($streamHide))
            $streamHide = array();
        
        if (is_array($websites) && count($websites)) {
            if (empty($selected_group)) {            
                foreach($websites as $website) {
                    if ($website && $website->plugins != '')  { 
                        $plugins = json_decode($website->plugins, 1);                           
                        if (is_array($plugins) && count($plugins) != 0) {                            
                            foreach ($plugins as $plugin)
                            {                            
                                if ($plugin['slug'] == "stream/stream.php" || strpos($plugin['slug'], "/stream.php") !== false) {                                    
                                    $site = MainWPCReportUtility::mapSite($website, array('id', 'name' , 'url'));
                                    if ($plugin['active'])
                                        $site['stream_active'] = 1;
                                    else 
                                        $site['stream_active'] = 0;     
                                    // get upgrade info
                                    $site['stream_plugin_version'] = $plugin['version'];
                                    $plugin_upgrades = json_decode($website->plugin_upgrades, 1);                                     
                                    if (is_array($plugin_upgrades) && count($plugin_upgrades) > 0) {                                        
                                        if (isset($plugin_upgrades["stream/stream.php"])) {
                                            $upgrade = $plugin_upgrades["stream/stream.php"];
                                            if (isset($upgrade['update'])) {                                                
                                                $site['stream_upgrade'] = $upgrade['update'];                                                
                                            }
                                        }
                                    }
                                    
                                    $site['hide_stream'] = 0;
                                    if (isset($streamHide[$website->id]) && $streamHide[$website->id]) {
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
                
                $group_websites = apply_filters('mainwp-getdbsites', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), array(), array($selected_group));  
                $sites = array();
                foreach($group_websites as $site) {
                    $sites[] = $site->id;
                }                 
                foreach($websites as $website) {
                    if ($website && $website->plugins != '' && in_array($website->id, $sites))  { 
                        $plugins = json_decode($website->plugins, 1);                       
                        if (is_array($plugins) && count($plugins) != 0) {
                            foreach ($plugins as $plugin)
                            {                            
                                if ($plugin['slug'] == "stream/stream.php" || strpos($plugin['slug'], "/stream.php") !== false) {
                                    $site = MainWPCReportUtility::mapSite($website, array('id', 'name' , 'url'));
                                    // get upgrade info
                                    $plugin_upgrades = json_decode($website->plugin_upgrades, 1); 
                                    if (is_array($plugin_upgrades) && count($plugin_upgrades) > 0) {                                        
                                        if (isset($plugin_upgrades["stream/stream.php"])) {
                                            $upgrade = $plugin_upgrades["stream/stream.php"];
                                            if (isset($upgrade['update'])) {                                                
                                                $site['stream_upgrade'] = $upgrade['update'];                                                
                                            }
                                        }
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
        if (isset($_GET['s']) && !empty($_GET['s'])) {
            $find = trim($_GET['s']);
            foreach($websites_stream as $website ) {                
                if (stripos($website['name'], $find) !== false || stripos($website['url'], $find) !== false) {
                    $search_sites[] = $website;
                }
            }
            $websites_stream = $search_sites;
        }
        unset($search_sites);        
       
        return $websites_stream;
    } 
          
    public static function gen_select_sites($websites, $selected_group) {
        global $mainWPCReportExtensionActivator;
        //$websites = apply_filters('mainwp-getsites', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), null);              
        $groups = apply_filters('mainwp-getgroups', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), null);        
        $search = (isset($_GET['s']) && !empty($_GET['s'])) ? trim($_GET['s']) : "";
        ?> 
                   
        <div class="alignleft actions bulkactions">
            <select id="creport_stream_action">
                <option selected="selected" value="-1"><?php _e("Bulk Actions"); ?></option>
                <option value="activate-selected"><?php _e("Active"); ?></option>
                <option value="update-selected"><?php _e("Update"); ?></option>
                <option value="hide-selected"><?php _e("Hide"); ?></option>
                <option value="show-selected"><?php _e("Show"); ?></option>
            </select>
            <input type="button" value="<?php _e("Apply"); ?>" class="button action" id="creport_stream_doaction_btn" name="">
        </div>
                   
        <div class="alignleft actions">
            <form action="" method="GET">
                <input type="hidden" name="page" value="Extensions-Mainwp-Client-Reports-Extension">
                <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"><?php _e('No search results.','mainwp'); ?></span>
                <input type="text" class="mainwp_autocomplete ui-autocomplete-input" name="s" autocompletelist="sites" value="<?php echo stripslashes($search); ?>" autocomplete="off">
                <datalist id="sites">
                    <?php
                    if (is_array($websites) && count($websites) > 0) {
                        foreach ($websites as $website) {                    
                            echo "<option>" . $website['name']. "</option>";                    
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
                <option value="0"><?php _e("Select a group"); ?></option>
                <?php
                if (is_array($groups) && count($groups) > 0) {
                    foreach ($groups as $group) {
                        $_select = "";
                        if ($selected_group == $group['id'])
                            $_select = 'selected ';                    
                        echo '<option value="' . $group['id'] . '" ' . $_select . '>' . $group['name'] . '</option>';
                    }     
                }
                ?>
                </select>&nbsp;&nbsp;                     
                <input class="button" type="button" name="creport_stream_btn_display" id="creport_stream_btn_display"value="<?php _e("Display", "mainwp"); ?>">
            </form>  
        </div>    
        <?php       
        return;
    }
    
        
    public function dismissNoti() {
        $website_id = $_POST['siteId'];
        $version = $_POST['new_version'];
        if ($website_id) {    
            session_start();
            $dismiss = $_SESSION['mainwp_creport_dismiss_upgrade_stream_notis'];
            if (is_array($dismiss) && count($dismiss) > 0) {
                $dismiss[$website_id] = 1;
            } else {
                $dismiss = array();
                $dismiss[$website_id] = 1;
            }
            $_SESSION['mainwp_creport_dismiss_upgrade_stream_notis'] = $dismiss;
            die('updated');
        }
        die('nochange');
    }
    
    public function active_plugin() {
        do_action('mainwp_activePlugin');
        die();
    }
    
    public function upgrade_plugin() {
        do_action('mainwp_upgradePluginTheme');
        die();
    }
    
    public function showhide_stream() {        
        
        $siteid = isset($_POST['websiteId']) ? $_POST['websiteId'] : null;
        $showhide = isset($_POST['showhide']) ? $_POST['showhide'] : null;
        if ($siteid !== null && $showhide !== null) {            
            global $mainWPCReportExtensionActivator;
            $post_data = array( 'mwp_action' => 'set_showhide',
                                'showhide' => $showhide
                            );
            $information = apply_filters('mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), $siteid, 'client_report', $post_data);			
            
            if (is_array($information) && isset($information['result']) && $information['result'] === "SUCCESS") {
                $hide_stream = $this->get_option('hide_stream_plugin');
                if (!is_array($hide_stream))
                    $hide_stream = array();
                $hide_stream[$siteid] = ($showhide === "hide") ? 1 : 0;
                $this->set_option('hide_stream_plugin', $hide_stream);
            }
            
            die(json_encode($information)); 
        }
        die();
    }
    
   
}
