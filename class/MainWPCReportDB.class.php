<?php
class MainWPCReportDB
{    
    private $mainwp_wpcreport_db_version = '1.0';
    //Singleton
    private static $instance = null;
    private $table_prefix;
    
    static function Instance()
    {
        if (MainWPCReportDB::$instance == null) {
            MainWPCReportDB::$instance = new MainWPCReportDB();
        }
        return MainWPCReportDB::$instance;
    }
    //Constructor
    function __construct()
    {
        global $wpdb;
        $this->table_prefix = $wpdb->prefix . "mainwp_"; 
        $this->default_tokens = array(  "client.name" => "Display Client Name",
                                        "client.contact.name" => "Display Client Contact Name",
                                        "client.contact.address.1" => "Display Client Contact Address 1",
                                        "client.contact.address.2" => "Display Client Contact Address 2",
                                        "client.city" => "Display Client City",
                                        "client.state" => "Display Client State",
                                        "client.zip" => "Display Client Zip",
                                        "client.phone" => "Display Client Phone",
                                        "client.email" => "Display Client Email");
    }
	
    function tableName($suffix)
    {
        return $this->table_prefix . $suffix;
    }
		
    //Support old & new versions of wordpress (3.9+)
    public static function use_mysqli()
    {
        /** @var $wpdb wpdb */
        if (!function_exists( 'mysqli_connect' ) ) return false;

        global $wpdb;
        return ($wpdb->dbh instanceof mysqli);
    }
	
    //Installs new DB
    function install()
    {
        global $wpdb;
        $currentVersion = get_site_option('mainwp_wpcreport_db_version');
        if ($currentVersion == $this->mainwp_wpcreport_db_version) return;        
        $charset_collate = $wpdb->get_charset_collate();        
        $sql = array();
        
        $tbl = 'CREATE TABLE `' . $this->tableName('client_report_token') . '` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`token_name` varchar(512) NOT NULL DEFAULT "",
`token_description` text NOT NULL,
`type` tinyint(1) NOT NULL DEFAULT 0';
        if ($currentVersion == '')
                    $tbl .= ',
PRIMARY KEY  (`id`)  ';
        $tbl .= ') ' . $charset_collate;
        $sql[] = $tbl;
        
        $tbl = 'CREATE TABLE `' . $this->tableName('client_report_site_token') . '` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_url` varchar(255) NOT NULL,
`token_id` int(12) NOT NULL,
`token_value` varchar(512) NOT NULL';
        if ($currentVersion == '')
                    $tbl .= ',
PRIMARY KEY  (`id`)  ';
        $tbl .= ') ' . $charset_collate;
        $sql[] = $tbl;   
        
        $tbl = 'CREATE TABLE `' . $this->tableName('client_report') . '` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` text NOT NULL,
`date_from` int(11) NOT NULL,
`date_to` int(11) NOT NULL,
`fname` VARCHAR(512),
`fcompany` VARCHAR(512),
`femail` VARCHAR(128),
`name` VARCHAR(512),
`company` VARCHAR(512),
`email` VARCHAR(128),
`header` text NOT NULL,
`body` text NOT NULL,
`footer` text NOT NULL,
`logo_file` VARCHAR(512),
`lastsend` int(11) NOT NULL,
`nextsend` int(11) NOT NULL,
`selected_site` int(11) NOT NULL';
        if ($currentVersion == '')
                    $tbl .= ',
PRIMARY KEY  (`id`)  ';
        $tbl .= ') ' . $charset_collate;
        $sql[] = $tbl;
        
        error_reporting(0); // make sure to disable any error output
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        foreach ($sql as $query)
        {
            dbDelta($query);
        }
//        global $wpdb;
//        echo $wpdb->last_error;
//        exit(); 
        foreach($this->default_tokens as $token_name => $token_description) {
            $token = array('type' => 1, 
                            'token_name' => $token_name, 
                            'token_description' => $token_description
                            );            
            if ($current = $this->getTokensBy('token_name', $token_name)) {                  
                $this->updateToken($current->id, $token);
            } else 
            {
                $this->addToken($token);
            }
        }
        update_option('mainwp_wpcreport_db_version', $this->mainwp_wpcreport_db_version);
    }
 
    public function addToken($token)
    {
        /** @var $wpdb wpdb */
        global $wpdb;        
        if (!empty($token['token_name']) && !empty($token['token_description'])) {
            if ($current  = $this->getTokensBy('token_name', $token['token_name'])) 
                return false;    
            if ($wpdb->insert($this->tableName('client_report_token'), $token)) {
                return $this->getTokensBy('id', $wpdb->insert_id);
            }
        }
        return false;
    }
    
    public function updateToken($id, $token)
    {
         /** @var $wpdb wpdb */
        global $wpdb;        
        if (MainWPCReportUtility::ctype_digit($id) && !empty($token['token_name']) && !empty($token['token_description'])) {            
            if ($wpdb->update($this->tableName('client_report_token'), $token, array('id' => intval($id))))
              return $this->getTokensBy('id', $id);      
        }
        return false;
    }
    
    public function getTokensBy($by = 'id', $value = null, $site_url = "") {
        global $wpdb;
        
        if (empty($by) || empty($value))
            return null;
        
        $sql = "";
        if ($by == 'id') {
            $sql = $wpdb->prepare("SELECT * FROM " . $this->tableName('client_report_token') . " WHERE `id`=%d ", $value);
        } else if ($by == 'token_name') {
            $sql = $wpdb->prepare("SELECT * FROM " . $this->tableName('client_report_token') . " WHERE `token_name` = '%s' ", $value);
        }         
        
        $token = null;
        if (!empty($sql))
            $token = $wpdb->get_row($sql);        
        
        $site_url = trim($site_url);
        
        if (empty($site_url))
            return $token;
        
        if ($token && !empty($site_url)) {            
            $sql = "SELECT * FROM " . $this->tableName('client_report_site_token') . 
                    " WHERE site_url = '" . $this->escape($site_url). "' AND token_id = " . $token->id;
            $site_token = $wpdb->get_row($sql);                    
            if ($site_token) {
                $token->site_token = $site_token; 
                return $token;
            }       
            else
                return null;
        }        
        return null;
    }
    
    public function getTokens() {
        global $wpdb;        
        return $wpdb->get_results("SELECT * FROM " . $this->tableName('client_report_token') . " WHERE 1 = 1 ORDER BY type DESC, token_name ASC");                
    }
    
    public function getSiteTokens($site_url) {
        global $wpdb;           
        $site_url = trim($site_url);
        if (empty($site_url))
            return false;
        $qry = " SELECT st.* FROM " . $this->tableName('client_report_site_token') . " st " .        
                " WHERE st.site_url = '" . $site_url . "' ";
        //echo $qry;
        $site_tokens = $wpdb->get_results($qry);              
        $return = array();
        if (is_array($site_tokens)) {
            foreach($site_tokens as $token) {                
                $return[$token->token_id] = $token;
            }
        }
        // get default token value if empty
        $tokens = $this->getTokens();
        if (is_array($tokens)) {
            foreach($tokens as $token) {
                // check default tokens if it is empty
                if (is_object($token)) {
                    if ($token->type == 1 && (!isset($return[$token->id]) || empty($return[$token->id]))) {
                        if (!isset($return[$token->id]))
                            $return[$token->id] = new stdClass();
                        $return[$token->id]->token_value = $this->_getDefaultTokenSite($token->token_name, $site_url);
                    }
                }
            }
        }
        return $return;
    }    
    
    public function _getDefaultTokenSite($token_name, $site_url) {    
		$website = apply_filters('mainwp_getwebsitesbyurl', $site_url);    
        if (empty($this->default_tokens[$token_name]) || !$website)
            return false;
        $website = current($website);
        if (is_object($website)) {
            $url_site = $website->url;
            $name_site = $website->name;
        } else 
            return false;
        
        switch ($token_name) {
            case 'url.site':
                $token_value = $url_site;
                break;
            case 'name.site':
                $token_value = $name_site;
                break;
            default:
                $token_value = "";
                break;
        }
        return $token_value;
    }    
    
    public function addTokenSite($token_id, $token_value, $site_url)
    {
        /** @var $wpdb wpdb */
        global $wpdb;            
        
        if (empty($token_id))                
            return false;        
        
        $website = apply_filters('mainwp_getwebsitesbyurl', $site_url);
        if (empty($website))
            return false;        
        
        if ($wpdb->insert($this->tableName('client_report_site_token'), array('token_id' => $token_id, 
                                                                            'token_value' => $token_value, 
                                                                            'site_url' => $site_url))) {
            return $this->getTokensBy('id', $token_id, $site_url); 
        }
        
        return false;
    }
    
    public function updateTokenSite($token_id, $token_value, $site_url)
    {
        /** @var $wpdb wpdb */
        global $wpdb;            
        
        if (empty($token_id))                
            return false;                
        
        $website = apply_filters('mainwp_getwebsitesbyurl', $site_url);        
        if (empty($website))
            return false;        
        
        $sql = "UPDATE " . $this->tableName('client_report_site_token') . 
                " SET token_value = '" .$this->escape($token_value) . "' " .
                " WHERE token_id = " . intval($token_id) . 
                " AND site_url = '" . $this->escape($site_url) . "'";
        //echo $sql."<br />"; 
        if ($wpdb->query($sql)) {
            return $this->getTokensBy('id', $token_id, $site_url); 
        }        
        
        return false;
    }
    
    public function deleteSiteTokens($token_id = null, $site_url = null)
    {
        global $wpdb; 
        if (!empty($token_id))
            return $wpdb->query($wpdb->prepare("DELETE FROM " . $this->tableName('client_report_site_token') . " WHERE token_id = %d ", $token_id));                
        else if (!empty($site_url))
            return $wpdb->query($wpdb->prepare("DELETE FROM " . $this->tableName('client_report_site_token') . " WHERE site_url = %s ", $site_url));                
        return false;
    }
    
    public function deleteTokenBy($by = 'id', $value = null) {
        global $wpdb;        
        if ($by == "id") {
            if ($wpdb->query($wpdb->prepare("DELETE FROM " . $this->tableName('client_report_token') . " WHERE id=%d ", $value))) {
                $this->deleteSiteTokens($value);
                return true;
            }                    
        }
        return false;        
    }
    
    public function updateReport($report)
    {
         /** @var $wpdb wpdb */
        global $wpdb;  
        $id = isset($report['id']) ? $report['id'] : 0;
        
        if (!isset($report['title']) || empty($report['title'])) {
            return false;
        }
        
        if (!empty($id)) {
            if ($wpdb->update($this->tableName('client_report'), $report, array('id' => intval($id))))
                return $this->getReportBy('id', $id); 
        } else {
            if ($wpdb->insert($this->tableName('client_report'), $report)) 
            {
                return $this->getReportBy('id', $wpdb->insert_id); 
            }
        }              
        return false;
    }
    
    public function getReportBy($by = 'id', $value = null, $orderby = null, $order = null) {
        global $wpdb;
        
        if (empty($by) || ($by !== 'all' && empty($value)))
            return false;
        
        $_order_by = "";
        if (!empty($orderby)) {
            $_order_by = " ORDER BY " . $orderby;        
            if (!empty($order))
                $_order_by .= " " . $order;
        }
        
        $sql = "";
        if ($by == 'id') {
            $sql = $wpdb->prepare("SELECT * FROM " . $this->tableName('client_report') . " WHERE `id`=%d " . $_order_by , $value);
        } else if ($by == 'all') {
            $sql = "SELECT * FROM " . $this->tableName('client_report') . " WHERE 1 = 1 " . $_order_by;
            return $wpdb->get_results($sql);  
        }         
        
        if (!empty($sql))
            return $wpdb->get_row($sql);        
           
        return false;
    }
    
    public function deleteReportBy($by = 'id', $value = null) {
        global $wpdb;        
        if ($by == "id") {
            if ($wpdb->query($wpdb->prepare("DELETE FROM " . $this->tableName('client_report') . " WHERE id=%d ", $value))) {                
                return true;
            }                    
        }
        return false;        
    }
    
    protected function escape($data)
    {
        /** @var $wpdb wpdb */
        global $wpdb;
        if (function_exists('esc_sql')) return esc_sql($data);
        else return $wpdb->escape($data);
    }    
    
    public function query($sql)
    {
        if ($sql == null) return false;
        /** @var $wpdb wpdb */
        global $wpdb;
        $result = @self::_query($sql, $wpdb->dbh);

        if (!$result || (@self::num_rows($result) == 0)) return false;
        return $result;
    }	
	
    public static function _query($query, $link)
    {
        if (self::use_mysqli())
        {
            return mysqli_query($link, $query);
        }
        else
        {
            return mysql_query($query, $link);
        }
    }

    public static function fetch_object($result)
    {
        if (self::use_mysqli())
        {
            return mysqli_fetch_object($result);
        }
        else
        {
            return mysql_fetch_object($result);
        }
    }

    public static function free_result($result)
    {
        if (self::use_mysqli())
        {
            return mysqli_free_result($result);
        }
        else
        {
            return mysql_free_result($result);
        }
    }

    public static function data_seek($result, $offset)
    {
        if (self::use_mysqli())
        {
            return mysqli_data_seek($result, $offset);
        }
        else
        {
            return mysql_data_seek($result, $offset);
        }
    }

    public static function fetch_array($result, $result_type = null)
    {
        if (self::use_mysqli())
        {
            return mysqli_fetch_array($result, ($result_type == null ? MYSQLI_BOTH : $result_type));
        }
        else
        {
            return mysql_fetch_array($result, ($result_type == null ? MYSQL_BOTH : $result_type));
        }
    }

    public static function num_rows($result)
    {
        if (self::use_mysqli())
        {
            return mysqli_num_rows($result);
        }
        else
        {
            return mysql_num_rows($result);
        }
    }

    public static function is_result($result)
    {
        if (self::use_mysqli())
        {
            return ($result instanceof mysqli_result);
        }
        else
        {
            return is_resource($result);
        }
    }
	
    public function getResultsResult($sql)
    {
        if ($sql == null) return null;
        /** @var $wpdb wpdb */
        global $wpdb;
        return $wpdb->get_results($sql, OBJECT_K);
    }
}