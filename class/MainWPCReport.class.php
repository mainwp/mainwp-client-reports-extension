<?php
class MainWPCReport
{    
    private $clientReportExt;
    private static $stream_tokens = array();
    private static $tokens_nav_top = array();    
    private static $buffer = array();
    
    public function __construct($ext) {    
        $this->clientReportExt = $ext;
        self::$stream_tokens = array(                        
            "plugins"=>array(   "sections" => array(
                                                array("name" => "section.plugins.installed", "desc" => "Token Description"),
                                                array("name" => "section.plugins.activated", "desc" => "Token Description"),
                                                array("name" => "section.plugins.edited", "desc" => "Token Description"),
                                                array("name" => "section.plugins.deactivated", "desc" => "Token Description"),
                                                array("name" => "section.plugins.updated", "desc" => "Token Description"),
                                                array("name" => "section.plugins.deleted", "desc" => "Token Description")
                                            ),
                                'nav_group_tokens' => array("sections" => "Sections",
                                                            "installed" => "Installed",
                                                            "activated" => "Activated",
                                                            "edited" => "Edited",
                                                            "deactivated" => "Deactivated",
                                                            "updated" => "Updated",
                                                            "deleted" => "Deleted",
                                                            "additional" => "Additional",
                                                    ),   
                                "installed" => array(
                                                array("name" => "plugin.name", "desc" => "Token Description"),
                                                array("name" => "plugin.installed.date", "desc" => "Token Description"),
                                                array("name" => "plugin.installed.author", "desc" => "Token Description")                                               
                                            ),
                                "activated" => array(
                                                array("name" => "plugin.name", "desc" => "Token Description"),
                                                array("name" => "plugin.activated.date", "desc" => "Token Description"),
                                                array("name" => "plugin.activated.author", "desc" => "Token Description")                                               
                                            ),
                                "edited" => array(
                                                array("name" => "plugin.name", "desc" => "Token Description"),
                                                array("name" => "plugin.edited.date", "desc" => "Token Description"),
                                                array("name" => "plugin.edited.author", "desc" => "Token Description")                                               
                                            ),
                                "deactivated" => array(
                                                array("name" => "plugin.name", "desc" => "Token Description"),
                                                array("name" => "plugin.deactivated.date", "desc" => "Token Description"),
                                                array("name" => "plugin.deactivated.author", "desc" => "Token Description")                                               
                                            ),
                                "updated" => array(
                                                array("name" => "plugin.name", "desc" => "Token Description"),
                                                array("name" => "plugin.updated.date", "desc" => "Token Description"),
                                                array("name" => "plugin.updated.author", "desc" => "Token Description")                                               
                                            ),
                                "deleted" => array(
                                                array("name" => "plugin.name", "desc" => "Token Description"),
                                                array("name" => "plugin.deleted.date", "desc" => "Token Description"),
                                                array("name" => "plugin.deleted.author", "desc" => "Token Description")                                               
                                            ),
                                "additional" => array(
                                                array("name" => "plugin.old.version", "desc" => "Token Description"),
                                                array("name" => "plugin.current.version", "desc" => "Token Description"),
                                                array("name" => "plugin.installed.count", "desc" => "Token Description"),                                               
                                                array("name" => "plugin.edited.count", "desc" => "Token Description"),
                                                array("name" => "plugin.activated.count", "desc" => "Token Description"),
                                                array("name" => "plugin.deactivated.count", "desc" => "Token Description"),
                                                array("name" => "plugin.deleted.count", "desc" => "Token Description"),
                                                array("name" => "plugin.updated.count", "desc" => "Token Description")                                                
                                            ),                                         
                            ),
           "themes"=>array(     "sections" => array(
                                                array("name" => "section.themes.installed", "desc" => "Token Description"),
                                                array("name" => "section.themes.activated", "desc" => "Token Description"),
                                                array("name" => "section.themes.edited", "desc" => "Token Description"),                                                
                                                array("name" => "section.themes.updated", "desc" => "Token Description"),
                                                array("name" => "section.themes.deleted", "desc" => "Token Description")
                                            ),  
                                'nav_group_tokens' => array("sections"=> "Sections",
                                                            "installed"=> "Installed",
                                                            "activated"=> "Activated",
                                                            "edited"=> "Edited",                                                           
                                                            "updated"=> "Updated",
                                                            "deleted"=> "Deleted",
                                                            "additional"=> "Additional",
                                                    ),
                                "installed" => array(
                                                array("name" => "theme.name", "desc" => "Token Description"),
                                                array("name" => "theme.installed.date", "desc" => "Token Description"),
                                                array("name" => "theme.installed.author", "desc" => "Token Description")                                               
                                            ),
                                "activated" => array(
                                                array("name" => "theme.name", "desc" => "Token Description"),
                                                array("name" => "theme.activated.date", "desc" => "Token Description"),
                                                array("name" => "theme.activated.author", "desc" => "Token Description")                                               
                                            ),
                                "edited" => array(
                                                array("name" => "theme.name", "desc" => "Token Description"),
                                                array("name" => "theme.edited.date", "desc" => "Token Description"),
                                                array("name" => "theme.edited.author", "desc" => "Token Description")                                               
                                            ),
                                "updated" => array(
                                                array("name" => "theme.name", "desc" => "Token Description"),
                                                array("name" => "theme.updated.date", "desc" => "Token Description"),
                                                array("name" => "theme.updated.author", "desc" => "Token Description")                                               
                                            ),
                                "deleted" => array(
                                                array("name" => "theme.name", "desc" => "Token Description"),
                                                array("name" => "theme.deleted.date", "desc" => "Token Description"),
                                                array("name" => "theme.deleted.author", "desc" => "Token Description")                                               
                                            ),
                                "additional" => array(
                                                array("name" => "theme.old.version", "desc" => "Token Description"),
                                                array("name" => "theme.current.version", "desc" => "Token Description"),
                                                array("name" => "theme.installed.count", "desc" => "Token Description"),                                               
                                                array("name" => "theme.edited.count", "desc" => "Token Description"),
                                                array("name" => "theme.activated.count", "desc" => "Token Description"),                                                
                                                array("name" => "theme.deleted.count", "desc" => "Token Description"),
                                                array("name" => "theme.updated.count", "desc" => "Token Description")                                                
                                            )
                            ),
                "posts"=>array("sections" => array(
                                                array("name" => "section.posts.created", "desc" => "Token Description"),
                                                array("name" => "section.posts.updated", "desc" => "Token Description"),
                                                array("name" => "section.posts.trashed", "desc" => "Token Description"),                                                
                                                array("name" => "section.posts.deleted", "desc" => "Token Description"),
                                                array("name" => "section.posts.restored", "desc" => "Token Description")
                                            ),  
                                'nav_group_tokens' => array("sections" => "Sections",
                                                     "created" => "Created",
                                                     "updated" => "Updated",
                                                     "trashed" => "Trashed",                                                           
                                                     "deleted" => "Deleted",
                                                     "restored" => "Restored",
                                                     "additional" => "Additional",
                                            ),
                                "created" => array(
                                                array("name" => "post.title", "desc" => "Token Description"),
                                                array("name" => "post.created.date", "desc" => "Token Description"),
                                                array("name" => "post.created.author", "desc" => "Token Description")                                               
                                            ),
                                "updated" => array(
                                                array("name" => "post.title", "desc" => "Token Description"),
                                                array("name" => "post.updated.date", "desc" => "Token Description"),
                                                array("name" => "post.updated.author", "desc" => "Token Description")                                               
                                            ),
                                "trashed" => array(
                                                array("name" => "post.name", "desc" => "Token Description"),
                                                array("name" => "post.trashed.date", "desc" => "Token Description"),
                                                array("name" => "post.trashed.author", "desc" => "Token Description")                                               
                                            ),
                                "deleted" => array(
                                                array("name" => "post.name", "desc" => "Token Description"),
                                                array("name" => "post.deleted.date", "desc" => "Token Description"),
                                                array("name" => "post.deleted.author", "desc" => "Token Description")                                               
                                            ),
                                "restored" => array(
                                                array("name" => "post.name", "desc" => "Token Description"),
                                                array("name" => "post.restored.date", "desc" => "Token Description"),
                                                array("name" => "post.restored.author", "desc" => "Token Description")                                               
                                            ),
                                "additional" => array(
                                                array("name" => "post.created.count", "desc" => "Token Description"),                                               
                                                array("name" => "post.updated.count", "desc" => "Token Description"),
                                                array("name" => "post.trashed.count", "desc" => "Token Description"),                                                
                                                array("name" => "post.restored.count", "desc" => "Token Description"),
                                                array("name" => "post.deleted.count", "desc" => "Token Description")                                                
                                            )
                            ),   
            "pages"=>array("sections" => array(
                                                array("name" => "section.pages.created", "desc" => "Token Description"),
                                                array("name" => "section.pages.updated", "desc" => "Token Description"),
                                                array("name" => "section.pages.trashed", "desc" => "Token Description"),                                                
                                                array("name" => "section.pages.deleted", "desc" => "Token Description"),
                                                array("name" => "section.pages.restored", "desc" => "Token Description")
                                            ),  
                                 'nav_group_tokens' => array("sections" => "Sections",
                                                     "created" => "Created",
                                                     "updated" => "Updated",
                                                     "trashed" => "Trashed",                                                           
                                                     "deleted" => "Deleted",
                                                     "restored" => "Restored",
                                                     "additional" => "Additional",
                                                    ),                                     
                                "created" => array(
                                                array("name" => "page.title", "desc" => "Token Description"),
                                                array("name" => "page.created.date", "desc" => "Token Description"),
                                                array("name" => "page.created.author", "desc" => "Token Description")                                               
                                            ),
                                "updated" => array(
                                                array("name" => "page.title", "desc" => "Token Description"),
                                                array("name" => "page.updated.date", "desc" => "Token Description"),
                                                array("name" => "page.updated.author", "desc" => "Token Description")                                               
                                            ),
                                "trashed" => array(
                                                array("name" => "page.name", "desc" => "Token Description"),
                                                array("name" => "page.trashed.date", "desc" => "Token Description"),
                                                array("name" => "page.trashed.author", "desc" => "Token Description")                                               
                                            ),
                                "deleted" => array(
                                                array("name" => "page.name", "desc" => "Token Description"),
                                                array("name" => "page.deleted.date", "desc" => "Token Description"),
                                                array("name" => "page.deleted.author", "desc" => "Token Description")                                               
                                            ),
                                "restored" => array(
                                                array("name" => "page.name", "desc" => "Token Description"),
                                                array("name" => "page.restored.date", "desc" => "Token Description"),
                                                array("name" => "page.restored.author", "desc" => "Token Description")                                               
                                            ),
                                "additional" => array(
                                                array("name" => "page.created.count", "desc" => "Token Description"),                                               
                                                array("name" => "page.updated.count", "desc" => "Token Description"),
                                                array("name" => "page.trashed.count", "desc" => "Token Description"),                                                
                                                array("name" => "page.restored.count", "desc" => "Token Description"),
                                                array("name" => "page.deleted.count", "desc" => "Token Description")                                                
                                            )
                            ),
            "comments"=>array("sections" => array(
                                                array("name" => "section.comments.created", "desc" => "Token Description"),
                                                array("name" => "section.comments.updated", "desc" => "Token Description"),
                                                array("name" => "section.comments.trashed", "desc" => "Token Description"),                                                
                                                array("name" => "section.comments.deleted", "desc" => "Token Description"),
                                                array("name" => "section.comments.edited", "desc" => "Token Description"),
                                                array("name" => "section.comments.restored", "desc" => "Token Description"),
                                                array("name" => "section.comments.approved", "desc" => "Token Description"),
                                                array("name" => "section.comments.spam", "desc" => "Token Description"),
                                                array("name" => "section.comments.replied", "desc" => "Token Description")                                                
                                            ),  
                                'nav_group_tokens' => array("sections"=> "Sections",
                                                     "created"=> "Created",
                                                     "updated"=> "Updated",
                                                     "trashed"=> "Trashed",                                                           
                                                     "deleted"=> "Deleted",
                                                     "edited"=> "Edited",
                                                     "restored"=> "Restored",
                                                     "approved"=> "Approved",
                                                     "spam"=> "Spam",
                                                     "replied"=> "replied",
                                                     "additional"=> "Additional",
                                                    ),
                                "created" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.created.date", "desc" => "Token Description"),
                                                array("name" => "comment.created.author", "desc" => "Token Description")                                               
                                            ),
                                "updated" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.updated.date", "desc" => "Token Description"),
                                                array("name" => "comment.updated.author", "desc" => "Token Description")                                               
                                            ),
                                "trashed" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.trashed.date", "desc" => "Token Description"),
                                                array("name" => "comment.trashed.author", "desc" => "Token Description")                                               
                                            ),
                                "deleted" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.deleted.date", "desc" => "Token Description"),
                                                array("name" => "comment.deleted.author", "desc" => "Token Description")                                               
                                            ),
                                "edited" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.edited.date", "desc" => "Token Description"),
                                                array("name" => "comment.edited.author", "desc" => "Token Description")                                               
                                            ),
                                "restored" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.restored.date", "desc" => "Token Description"),
                                                array("name" => "comment.restored.author", "desc" => "Token Description")                                               
                                            ),
                                "approved" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.approved.date", "desc" => "Token Description"),
                                                array("name" => "comment.approved.author", "desc" => "Token Description")                                               
                                            ),
                                "spam" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.spam.date", "desc" => "Token Description"),
                                                array("name" => "comment.spam.author", "desc" => "Token Description")                                               
                                            ),
                                "replied" => array(
                                                array("name" => "comment.title", "desc" => "Title of post or page where commented"),
                                                array("name" => "comment.replied.date", "desc" => "Token Description"),
                                                array("name" => "comment.replied.author", "desc" => "Token Description")                                               
                                            ),
                                "additional" => array(
                                                array("name" => "comment.created.count", "desc" => "Token Description"),                                                                                               
                                                array("name" => "comment.trashed.count", "desc" => "Token Description"),                                               
                                                array("name" => "comment.deleted.count", "desc" => "Token Description"),
                                                array("name" => "comment.edited.count", "desc" => "Token Description"),
                                                array("name" => "comment.restored.count", "desc" => "Token Description"),
                                                array("name" => "comment.deleted.count", "desc" => "Token Description"),
                                                array("name" => "comment.approved.count", "desc" => "Token Description"),
                                                array("name" => "comment.spam.count", "desc" => "Token Description"),
                                                array("name" => "comment.replied.count", "desc" => "Token Description")
                                            )
                            ),
             "users"=>array(   "sections" => array(
                                                array("name" => "section.users.created", "desc" => "Token Description"),
                                                array("name" => "section.users.updated", "desc" => "Token Description"),
                                                array("name" => "section.users.deleted", "desc" => "Token Description")                                                
                                            ),
                                'nav_group_tokens' => array("sections" => "Sections",
                                                     "created" => "Created",
                                                     "updated" => "Updated",
                                                     "deleted" => "Deleted",
                                                     "additional" => "Additional",
                                                    ),
                                "created" => array(
                                                array("name" => "user.name", "desc" => "Token Description"),
                                                array("name" => "user.created.date", "desc" => "Token Description"),
                                                array("name" => "user.created.author", "desc" => "Token Description"),
                                                array("name" => "user.updated.role", "desc" => "Token Description")   
                                            ),
                                "updated" => array(
                                                array("name" => "user.name", "desc" => "Token Description"),
                                                array("name" => "user.updated.date", "desc" => "Token Description"),
                                                array("name" => "user.updated.author", "desc" => "Token Description"),
                                                array("name" => "user.updated.role", "desc" => "Token Description")                                    
                                            ),
                                "deleted" => array(
                                                array("name" => "user.name", "desc" => "Token Description"),
                                                array("name" => "user.deleted.date", "desc" => "Token Description"),
                                                array("name" => "user.deleted.author", "desc" => "Token Description")                                               
                                            ),                                
                                "additional" => array(
                                                array("name" => "user.created.count", "desc" => "Token Description"),
                                                array("name" => "user.updated.count", "desc" => "Token Description"),
                                                array("name" => "user.deleted.count", "desc" => "Token Description")                                                                                               
                                            )
                            ),   
             "media"=>array(   "sections" => array(
                                                array("name" => "section.media.uploaded", "desc" => "Token Description"),
                                                array("name" => "section.media.updated", "desc" => "Token Description"),
                                                array("name" => "section.media.deleted", "desc" => "Token Description")                                                
                                            ),  
                                 'nav_group_tokens' => array("sections"=> "Sections",
                                                     "uploaded"=> "Uploaded",
                                                     "updated"=> "Updated",
                                                     "deleted"=> "Deleted",
                                                     "additional"=> "Additional",
                                                    ),
                                "uploaded" => array(
                                                array("name" => "media.name", "desc" => "Token Description"),
                                                array("name" => "media.uploaded.date", "desc" => "Token Description"),
                                                array("name" => "media.uploaded.author", "desc" => "Token Description")                                                
                                            ),
                                "updated" => array(
                                                array("name" => "media.name", "desc" => "Token Description"),
                                                array("name" => "media.updated.date", "desc" => "Token Description"),
                                                array("name" => "media.updated.author", "desc" => "Token Description")
                                            ),
                                "deleted" => array(
                                                array("name" => "media.name", "desc" => "Token Description"),
                                                array("name" => "media.deleted.date", "desc" => "Token Description"),
                                                array("name" => "media.deleted.author", "desc" => "Token Description")                                               
                                            ),                                
                                "additional" => array(
                                                array("name" => "media.uploaded.count", "desc" => "Token Description"),
                                                array("name" => "media.updated.count", "desc" => "Token Description"),
                                                array("name" => "media.deleted.count", "desc" => "Token Description")                                                                                               
                                            )
                            ),   
            "widgets"=>array(   "sections" => array(
                                                array("name" => "section.media.added", "desc" => "Token Description"),
                                                array("name" => "section.media.updated", "desc" => "Token Description"),
                                                array("name" => "section.media.deleted", "desc" => "Token Description")                                                
                                            ), 
                                 'nav_group_tokens' => array("sections" => "Sections",
                                                     "added" => "Added",
                                                     "updated" => "Updated",
                                                     "deleted" => "Deleted",
                                                     "additional" => "Additional",
                                                    ),
                                "added" => array(
                                                array("name" => "media.name", "desc" => "Token Description"),
                                                array("name" => "media.added.date", "desc" => "Token Description"),
                                                array("name" => "media.added.author", "desc" => "Token Description")                                                
                                            ),
                                "updated" => array(
                                                array("name" => "media.name", "desc" => "Token Description"),
                                                array("name" => "media.updated.date", "desc" => "Token Description"),
                                                array("name" => "media.updated.author", "desc" => "Token Description")                                                
                                            ),
                                "deleted" => array(
                                                array("name" => "media.name", "desc" => "Token Description"),
                                                array("name" => "media.deleted.date", "desc" => "Token Description"),
                                                array("name" => "media.deleted.author", "desc" => "Token Description")                                               
                                            ),                                
                                "additional" => array(
                                                array("name" => "media.added.count", "desc" => "Token Description"),
                                                array("name" => "media.updated.count", "desc" => "Token Description"),
                                                array("name" => "media.deleted.count", "desc" => "Token Description")                                                                                               
                                            )
                            ),  
              "menus"=>array(   "sections" => array(
                                                array("name" => "section.menus.created", "desc" => "Token Description"),
                                                array("name" => "section.menus.updated", "desc" => "Token Description"),
                                                array("name" => "section.menus.deleted", "desc" => "Token Description")                                                
                                            ),
                               'nav_group_tokens' => array("sections" => "Sections",
                                                     "created" => "Created",
                                                     "updated" => "Updated",
                                                     "deleted" => "Deleted",
                                                     "additional" => "Additional",
                                                    ),
                                "created" => array(
                                                array("name" => "menu.title", "desc" => "Token Description"),
                                                array("name" => "menu.created.date", "desc" => "Token Description"),
                                                array("name" => "menu.created.author", "desc" => "Token Description")                                                
                                            ),
                                "updated" => array(
                                                array("name" => "menu.title", "desc" => "Token Description"),
                                                array("name" => "menu.updated.date", "desc" => "Token Description"),
                                                array("name" => "menu.updated.author", "desc" => "Token Description")                                                
                                            ),
                                "deleted" => array(
                                                array("name" => "menu.title", "desc" => "Token Description"),
                                                array("name" => "menu.deleted.date", "desc" => "Token Description"),
                                                array("name" => "menu.deleted.author", "desc" => "Token Description")                                               
                                            ),                                
                                "additional" => array(
                                                array("name" => "menu.created.count", "desc" => "Token Description"),
                                                array("name" => "menu.updated.count", "desc" => "Token Description"),
                                                array("name" => "menu.deleted.count", "desc" => "Token Description")                                                                                               
                                            )
                            ), 
            "wordpress" => array("sections" => array(                                                
                                                array("name" => "section.wordpress.updated", "desc" => "Token Description")                                                
                                            ),  
                               'nav_group_tokens' => array("sections" => "Sections",                                                     
                                                            "updated" => "Updated",                                                     
                                                            "additional" => "Additional"
                                                        ),
                                "updated" => array(                                                
                                                array("name" => "wordpress.updated.date", "desc" => "Token Description"),
                                                array("name" => "wordpress.updated.author", "desc" => "Token Description")                                                
                                            ),
                                "additional" => array(
                                                array("name" => "wordpress.old.version", "desc" => "Token Description"),
                                                array("name" => "wordpress.current.version", "desc" => "Token Description"),
                                                array("name" => "wordpress.updated.count", "desc" => "Token Description")                                                                                               
                                            )
                            ),
                    "client" => array("tokens" => array(),
                                'nav_group_tokens' => array()
                            ),              
            );
       
            
            self::$tokens_nav_top = array("plugins" => "Plugins",
                                        "themes" => "Themes",
                                        "posts" => "Posts",
                                        "pages" => "Pages",
                                        "comments" => "Comments",
                                        "users" => "Users",
                                        "media" => "Media",
                                        "widgets" => "Widgets",
                                        "menus" => "Menus",
                                        "wordpress" => "WordPress",
                                        "client" => "Client Tokens"  
                                    );           
        
    }
    
    
    public function init() {
       
    }
    
    public function admin_init() {
        add_action('mainwp-extension-sites-edit', array(&$this, 'site_token'),9,1);                
        add_action('wp_ajax_mainwp_creport_load_tokens', array(&$this, 'load_tokens'));
        add_action('wp_ajax_mainwp_creport_delete_token', array(&$this, 'delete_token')); 
        add_action('wp_ajax_mainwp_creport_save_token', array(&$this, 'save_token'));
        add_action('wp_ajax_mainwp_creport_delete_report', array(&$this, 'delete_report')); 
        add_action('wp_ajax_mainwp_creport_load_client', array(&$this, 'load_client'));    
        add_action('wp_ajax_mainwp_creport_load_site_tokens', array(&$this, 'load_site_tokens')); 
        
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
            
            if(isset($_POST['mwp_creport_client'])) {
                $report['client'] = trim($_POST['mwp_creport_client']);                
            }  
            
            if(isset($_POST['mwp_creport_client_id'])) {
                $report['client_id'] = intval($_POST['mwp_creport_client_id']);                
            }  
            
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
                if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $to_email))				
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
                if ($current_report && is_object($current_report)) {
                    if (!empty($current_report->logo_file)) {                
                        $old_logo = $creport_dir . $current_report->logo_file;                    
                    }                                        
                }
            }
            $delete_logo = false;
            if (isset($_POST['mainwp_creport_delete_logo_image']) && intval($_POST['mainwp_creport_delete_logo_image']) === 1) {
                $delete_logo = true;
            }
            
            $image_logo = "NOTCHANGE";              
            if($_FILES && $_FILES['mainwp_creport_logo_file']['error'] == UPLOAD_ERR_OK) {                          
                $output = self::handleUploadImage($_FILES['mainwp_creport_logo_file'], $creport_dir);
                if (is_array($output) && isset($output['filename']) && !empty($output['filename'])) {                    
                    $image_logo = $output['filename'];  
                    $delete_logo = true; // delete old logo
                } else if (isset($output['error'])) {
                    foreach ($output['error'] as $e) {
                        $errors[] = $e;
                    }
                }
            } 
            
            if ($image_logo !== "NOTCHANGE") {
                $report['logo_file'] = $image_logo;                
            } else if ($delete_logo) {
                $report['logo_file'] = $image_logo = "";
            }   
            
            $selected_site = 0; 
            if (isset($_POST['select_by'])) {                            
                if (isset($_POST['selected_site'])) {                                        
                    $selected_site = intval($_POST['selected_site']);                    
                }                                                
            }               
            $report['selected_site'] = $selected_site;
            
            $return = array(); 
            
            if ("save" === ($_POST['mwp_creport_report_submit_action'])) {
                if($result = MainWPCReportDB::Instance()->updateReport($report)) {                    
                    $return['id'] = $result->id;                    
                    $messages[] = 'Report saved.';             
                } else {
                    $messages[] = "Report not change.";            
                }                  
            } else if ("send" === (string)$_POST['mwp_creport_report_submit_action'] || "preview" === (string)$_POST['mwp_creport_report_submit_action']) {                
                $_logo = isset($report['logo_file']) ? $report['logo_file'] : "";
                if (isset($report['id']) && !empty($report['id'])) {                    
                    $update_logo = array('id' => $report['id'], 'logo_file' => $_logo);
                    MainWPCReportDB::Instance()->updateReport($update_logo);
                } else {
                    if ($image_logo !== "NOTCHANGE") {
                        update_option('mainwp_creport_report_temp_logo', $image_logo);
                    }                                         
                    $report['logo_file'] = get_option('mainwp_creport_report_temp_logo');                    
                }
                $submit_report = json_decode(json_encode($report));
                $return['submit_report'] = $submit_report;
            }
            
            if (file_exists($old_logo)) {
                @unlink($old_logo);
            }
                    
            if (!isset($return['id']) && isset($report['id'])) {
                $return['id'] = $report['id'];
            }
            
            if (count($errors) > 0) 
                $return['error'] = $errors;  
            
            if (count($messages) > 0) 
                $return['message'] = $messages;
            
            return $return;
        } else {            
            $tmp_logo = get_option('mainwp_creport_report_temp_logo');
            if (!empty($tmp_logo)) {
                $creport_dir = apply_filters('mainwp_getspecificdir',"client_report/");
                $tmp_logo = $creport_dir.$tmp_logo;
                if (file_exists($tmp_logo)) {
                    @unlink($tmp_logo);
                }
                delete_option('mainwp_creport_report_temp_logo'); // delete temp 
            }
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
            if (wp_mail($email, 'Website Report', $content, array($from, 'content-type: text/html'))) { 
                if (!empty($report->id)) {
                    $report->lastsend = time();                    
                    $update_report = array('id' => $report->id, 'lastsend' => $report->lastsend);
                    MainWPCReportDB::Instance()->updateReport($update_report);                    
                }
                return true;
            }
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
        $do_preview = $do_send = false;              
        $report_id = 0;
        $report = null;
      
        if ((isset($_GET['action']) && "sendreport" === (string)$_GET['action']) || (isset($_POST['mwp_creport_report_submit_action']) && "send" === ($_POST['mwp_creport_report_submit_action']))) {                                
            $do_send = true;                 
        } 
        
        if ((isset($_GET['action']) && "preview" === (string)$_GET['action']) || isset($_POST['mwp_creport_report_submit_action']) && "preview" === (string)$_POST['mwp_creport_report_submit_action']) {
            $do_preview = true;
        }        
            
        // if send report from preview screen do not need to save report
        if (isset($_POST['mwp_creport_report_submit_action']) && !empty($_POST['mwp_creport_report_submit_action'])) {
            $result = self::saveReport(); 
            $report_id = isset($result['id']) && $result['id'] ? $result['id'] : 0;
            
            if (isset($result['message']))                 
                $messages = $result['message'];

            if (isset($result['error'])) 
                $errors = $result['error'];

            if (isset($result['submit_report']) && is_object($result['submit_report'])) {
                $report = $result['submit_report'];
            } else if ($report_id) {                
                $report = MainWPCReportDB::Instance()->getReportBy('id', $report_id); 
            }
        } else if (isset($_REQUEST['id'])) {
            $report_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
            $report = MainWPCReportDB::Instance()->getReportBy('id', $report_id); 
        }
       
        $style_tab_report = $style_tab_new = $style_tab_token = ' style="display: none" ';                
        
        if (isset($_REQUEST['action'])) {                
            if ($_REQUEST['action'] == "token") {            
                $style_tab_token = '';                
            } else if ($_REQUEST['action'] == "editreport" || $do_preview) {               
                $style_tab_new = '';            
            } else if ($do_send) {
                $style_tab_report = "";
            }
        } else {
            $style_tab_report = "";
        }
        
        if ($do_preview || $do_send) {
            if (empty($report) || !is_object($report)) {
                $errors[] = __('Error report data');
                $do_preview = $do_send = false;
            } else if (empty($report->selected_site)) {
                $errors[] = __('Please select a website');
                $do_preview = $do_send = false;
            } 
            
            if ($do_send && empty($report->email)) {
                $errors[] = __('Send To Email can not be empty');
                $do_send = false;
            } 
        }   
        
        if (!empty($report) && is_object($report)) {                          
            if ($do_send) {                     
                if (self::send_report_mail($report)) {                        
                    $messages[] = 'Send Report successful.';  
                } else {
                    $errors[] = 'Send Report failed.';  
                }                
            }   
        }
              
        $str_error = (count($errors) > 0) ? implode("<br/>", $errors) : "";
        $str_message = (count($messages) > 0) ? implode("<br/>", $messages) : "";
      
        
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
        
        $clients = MainWPCReportDB::Instance()->getClients();
        if (!is_array($clients)) 
            $clients = array();
        
        
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
                                <div class="tablenav top">
                                    <select name="mainwp_creport_select_client" id="mainwp_creport_select_client">
                                        <option value="0"><?php _e("Select a Client"); ?></option>
                                    <?php
                                    foreach ($clients as $client) {
                                        $_select = "";
                                        if (isset($_GET['client']) && $client->clientid == intval($_GET['client'])) {
                                            $_select = "selected";
                                        }                                        
                                    ?>
                                        <option value="<?php echo $client->clientid; ?>" <?php echo $_select; ?>><?php echo stripslashes($client->client); ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                    <input type="button" name="mainwp_creport_select_client_btn_display" id="mainwp_creport_select_client_btn_display" class="button" value="<?php _e("Display"); ?>" />
                                </div>
                            
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
                            <input type="hidden" name="mwp_creport_report_submit_action" id="mwp_creport_report_submit_action" value="">
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
                              <?php echo stripslashes(nl2br($report->filtered_header)); ?>
                          </div>
                          <?php 
                          if (!empty($logo_url)) {
                            ?>                                      
                            <div style="float: right; margin-top: .6em ;">                                        
                               <img src="<?php echo $logo_url ?>" alt="Logo" height="100"/>
                            </div>
                            <?php
                          }
                          ?>
                        <div style="clear: both;"></div>
                      </div>
                    </div>
                    <br><br><br>
                    <div>
                        <?php echo stripslashes(nl2br($report->filtered_body)); ?>
                    </div>
                    <br><br><br>
                    <div style="display: block; width: 100% ;">
                        <?php echo stripslashes(nl2br($report->filtered_footer)); ?>
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
        
        //$report->filtered_header = self::replace_content($report->header, $search_tokens, $replace_values);        
        //$report->body = self::replace_content($report->body, $search_tokens, $replace_values);        
        //$report->filtered_footer = self::replace_content($report->footer, $search_tokens, $replace_values);        
        
        $report_header = $report->header;
        $report_body = $report->body;
        $report_footer = $report->footer;
        
        $result = self::parse_report_content($report_header, $search_tokens, $replace_values);
        //print_r($result);
        self::$buffer['sections']['header'] = $sections['header'] = $result['sections'];
        $other_tokens['header'] = $result['other_tokens']; 
        $report_header = $result['filtered_content'];
        unset($result);
        
        $result = self::parse_report_content($report_body, $search_tokens, $replace_values);
        //print_r($result);
        self::$buffer['sections']['body'] = $sections['body'] = $result['sections'];
        $other_tokens['body'] = $result['other_tokens']; 
        $report_body = $result['filtered_content'];
        unset($result);
        
        $result = self::parse_report_content($report_footer, $search_tokens, $replace_values);
        //print_r($result);
        self::$buffer['sections']['footer'] = $sections['footer'] = $result['sections'];
        $other_tokens['footer'] = $result['other_tokens'];  
        $report_footer = $result['filtered_content'];
        unset($result);
        
        if ((is_array($sections) && count($sections) > 0) || (is_array($other_tokens) && count($other_tokens) > 0)) {
            $sections_data = $other_tokens_data = array();
            $information = self::fetch_stream_data($website, $report, $sections, $other_tokens);                    
            //print_r($information);
            if (is_array($information)) {                
                self::$buffer['sections_data'] = $sections_data = isset($information['sections_data']) ? $information['sections_data'] : array();
                $other_tokens_data = isset($information['other_tokens_data']) ? $information['other_tokens_data'] : array();
            }
            unset($information);
            if (isset($sections_data['header']) && is_array($sections_data['header']) && count($sections_data['header']) > 0) {
                $report_header = preg_replace_callback("/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is",  array('MainWPCReport', 'section_mark_header'), $report_header);
            }      

            if (isset($sections_data['body']) && is_array($sections_data['body']) && count($sections_data['body']) > 0) {
                $report_body = preg_replace_callback("/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is",  array('MainWPCReport', 'section_mark_body'), $report_body);
            }      

            if (isset($sections_data['footer']) && is_array($sections_data['footer']) && count($sections_data['footer']) > 0) {
                $report_footer = preg_replace_callback("/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is",  array('MainWPCReport', 'section_mark_footer'), $report_footer);
            }      
            
            if (isset($other_tokens_data['header']) && is_array($other_tokens_data['header']) && count($other_tokens_data['header']) > 0) {
                foreach ($other_tokens_data['header'] as $token => $value) {
                    if (in_array($token, $other_tokens['header'])) {
                        $search[] = $token;
                        $replace[] = $value;
                    }
                }
                $report_header = self::replace_content($report_body, $search, $replace);
            }
            
            if (isset($other_tokens_data['body']) && is_array($other_tokens_data['body']) && count($other_tokens_data['body']) > 0) {
                foreach ($other_tokens_data['body'] as $token => $value) {
                    if (in_array($token, $other_tokens['body'])) {
                        $search[] = $token;
                        $replace[] = $value;
                    }
                }
                $report_body = self::replace_content($report_body, $search, $replace);
            }
            
            if (isset($other_tokens_data['footer']) && is_array($other_tokens_data['footer']) && count($other_tokens_data['footer']) > 0) {
                foreach ($other_tokens_data['footer'] as $token => $value) {
                    if (in_array($token, $other_tokens['footer'])) {
                        $search[] = $token;
                        $replace[] = $value;
                    }
                }
                $report_body = self::replace_content($report_footer, $search, $replace);
            }
            
        }
        $report->filtered_header = $report_header;
        $report->filtered_body = $report_body;
        $report->filtered_footer = $report_footer;
        
        self::$buffer = array();
        return $report;
    } 
    
    public static function section_mark_header($matches) {
        $content = $matches[0];
        $sec = $matches[1];        
        $sec_content = trim($matches[2]);                
        if (isset(self::$buffer['sections_data']['header'][$sec])) {
            $search = self::$buffer['sections']['header'][$sec];            
            $loop = self::$buffer['sections_data']['header'][$sec]; 
            $replaced_content = "";
            if (is_array($loop)) {                
                foreach($loop as $replace) {
                    $replaced = self::replace_content($sec_content, $search, $replace);                    
                    $replaced_content .= $replaced . "<br>";
                }               
            }
            return $replaced_content;            
        }        
        return $content;
    }
    
    public static function section_mark_body($matches) {
        $content = $matches[0];
        $sec = $matches[1];        
        $sec_content = trim($matches[2]);                
        if (isset(self::$buffer['sections_data']['body'][$sec])) {
            $search = self::$buffer['sections']['body'][$sec];            
            $loop = self::$buffer['sections_data']['body'][$sec]; 
            $replaced_content = "";
            if (is_array($loop)) {                
                foreach($loop as $replace) {
                    $replaced = self::replace_content($sec_content, $search, $replace);                    
                    $replaced_content .= $replaced . "<br>";
                }               
            }
            return $replaced_content;            
        }        
        return $content;
    }
    
    public static function section_mark_footer($matches) {
        $content = $matches[0];
        $sec = $matches[1];        
        $sec_content = trim($matches[2]);                
        if (isset(self::$buffer['sections_data']['footer'][$sec])) {
            $search = self::$buffer['sections']['footer'][$sec];            
            $loop = self::$buffer['sections_data']['footer'][$sec]; 
            $replaced_content = "";
            if (is_array($loop)) {                
                foreach($loop as $replace) {
                    $replaced = self::replace_content($sec_content, $search, $replace);                    
                    $replaced_content .= $replaced . "<br>";
                }               
            }
            return $replaced_content;            
        }        
        return $content;
    }
    

    public static function replace_content($content, $tokens, $replace_tokens) {
        return str_replace($tokens, $replace_tokens, $content);                
    }
    
    public static function parse_report_content($content, $client_tokens, $replace) {
        $filtered_content = $content = str_replace($client_tokens, $replace, $content);
        $sections = array();
        if (preg_match_all("/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is", $content, $matches)) {            
            for ($i = 0; $i < count($matches[1]) ; $i++) {
                $sec = $matches[1][$i];
                $sec_content = $matches[2][$i];
                $sec_tokens = array();
                if(preg_match_all("/\[[^\]]+\]/is" , $sec_content, $matches2)) {
                    $sec_tokens = $matches2[0];
                }                 
                $sections[$sec] = $sec_tokens;            
            }            
        }        
        $removed_sections = preg_replace_callback("/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is", create_function('$matches', 'return "";'), $content);
        $other_tokens = array();
        if(preg_match_all("/\[[^\]]+\]/is" , $removed_sections, $matches)) {
            $other_tokens = $matches[0];
        }       
        return array('sections' => $sections, 'other_tokens' => $other_tokens, 'filtered_content' => $filtered_content);
    }
   
    public static function remove_section_tokens($content) {        
        $matches = array(); 
        $section_tokens = array();
        $section = "";
        if(preg_match_all("/\[\/?section\.[^\]]+\]/is" , $content, $matches)) {
            $section_tokens = $matches[0];            
            $str_tmp = str_replace(array('[', ']'), "", $section_tokens[0]);
            list($context, $action, $section) = explode(".", $str_tmp);
        }
        $content =  str_replace($section_tokens, "", $content);                
        return array('content' => $content, 'section' => $section); 
    }
    
    public static function fetch_stream_data($website, $report, $sections, $tokens) {
        global $mainWPCReportExtensionActivator;
        $post_data = array( 'mwp_action' => 'get_stream',                           
                            'sections' => base64_encode(serialize($sections)),
                            'other_tokens' => base64_encode(serialize($tokens)),
                            'date_from' =>  $report->date_from,
                            'date_to' => $report->date_to);
        
        $information = apply_filters('mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), $website['id'], 'client_report', $post_data);			                             
//        print_r($sections);
//        print_r($information);
        if (is_array($information) && !isset($information['error'])) {
            return $information;
        } else {
            $error = is_array($information) ? @implode("<br>", $information) : $information;
            throw new Exception($error);
        }
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
        
        $title_order = $name_order = $lastsend_order = $datefrom_order = $client_order = "";                     
        if (isset($_GET['orderby']) && $_GET['orderby'] == "title") {            
            $title_order = ($order == "desc") ? "asc" : "desc";                     
        } else if (isset($_GET['orderby']) && $_GET['orderby'] == "name") {            
            $name_order = ($order == "desc") ? "asc" : "desc";                     
        } else if (isset($_GET['orderby']) && $_GET['orderby'] == "lastsend") {
            $lastsend_order = ($order == "desc") ? "asc" : "desc";                     
        } else if (isset($_GET['orderby']) && $_GET['orderby'] == "date_from") {
            $datefrom_order = ($order == "desc") ? "asc" : "desc";                     
        } else if (isset($_GET['orderby']) && $_GET['orderby'] == "client") {
            $client_order = ($order == "desc") ? "asc" : "desc";                     
        } 
        
        $get_by = 'all';
        $value = null;
        if (isset($_GET['client']) && !empty($_GET['client'])) {
            $get_by = 'client';
            $value = $_GET['client'];
        }        
        $reports = MainWPCReportDB::Instance()->getReportBy($get_by, $value, $orderby, $order);
        global $mainWPCReportExtensionActivator;
        $websites = apply_filters('mainwp-getsites', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), null);                
        $all_sites = array();
        if (is_array($websites)) {
            foreach ($websites as $website) {
                $all_sites[$website['id']] = $website;
            }                
        }
        
    ?>
         <table id="mainwp-table" class="wp-list-table widefat" cellspacing="0">
            <thead>
                <tr> 
                    <th scope="col" class="manage-column sortable <?php echo $title_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=title&order=<?php echo (empty($title_order) ? 'asc' : $title_order); ?>"><span><?php _e('Title','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column sortable <?php echo $client_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=client&order=<?php echo (empty($client_order) ? 'asc' : $client_order); ?>"><span><?php _e('Client','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>                
                    <th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=name&order=<?php echo (empty($name_order) ? 'asc' : $name_order); ?>"><span><?php _e('Send To','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>                
                    <th scope="col" class="manage-column sortable <?php echo $lastsend_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=lastsend&order=<?php echo (empty($lastsend_order) ? 'asc' : $lastsend_order); ?>"><span><?php _e('Last Report Send','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column sortable <?php echo $datefrom_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=date_from&order=<?php echo (empty($datefrom_order) ? 'asc' : $datefrom_order); ?>"><span><?php _e('Report For','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column">
                        <span><?php _e('Site','mainwp'); ?></span>
                    </th>
                </tr>
            </thead>
            <tfoot>
               <tr> 
                    <th scope="col" class="manage-column sortable <?php echo $title_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=title&order=<?php echo (empty($title_order) ? 'asc' : $title_order); ?>"><span><?php _e('Title','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                     <th scope="col" class="manage-column sortable <?php echo $client_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=client&order=<?php echo (empty($client_order) ? 'asc' : $client_order); ?>"><span><?php _e('Client','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>   
                    <th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=send&order=<?php echo (empty($name_order) ? 'asc' : $name_order); ?>"><span><?php _e('Send To','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>                
                    <th scope="col" class="manage-column sortable <?php echo $lastsend_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=lastsend&order=<?php echo (empty($lastsend_order) ? 'asc' : $lastsend_order); ?>"><span><?php _e('Last Report Send','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column sortable <?php echo $datefrom_order; ?>">
                        <a href="?page=Extensions-Mainwp-Client-Reporting-Extension&orderby=date_from&order=<?php echo (empty($datefrom_order) ? 'asc' : $datefrom_order); ?>"><span><?php _e('Report For','mainwp'); ?></span><span class="sorting-indicator"></span></a>
                    </th>
                    <th scope="col" class="manage-column">
                        <span><?php _e('Site','mainwp'); ?></span>
                    </th>
                </tr>
            </tfoot>
            <tbody>
             <?php                             
                self::reportTableContent($reports, $all_sites);                               
             ?>
            </tbody>
        </table>     
    <?php
    }
    
    
    public static function reportTableContent($reports, $websites) {
        
        if (!is_array($reports) || count($reports) == 0)
        { 
        ?>
            <tr><td colspan="6"><?php _e("No reports were found.");?></td></tr>
        <?php
            return;            
        }   
        $url_loader = plugins_url('images/loader.gif', dirname(__FILE__));
        foreach ($reports as $report) {
            $website = ($report->selected_site && isset($websites[$report->selected_site])) ? $websites[$report->selected_site] : null;
            $site_column  = "";
            if (!empty($website)) {
                $site_column = '<a href="admin.php?page=managesites&dashboard=' . $website['id']. '">' .  $website['name'] . "</a><br>" .
                        '<div class="row-actions"><span class="dashboard"><a href="admin.php?page=managesites&dashboard=' . $website['id'] . '">' .  __("Dashboard") . '</a></span> | ' . 
                        '<span class="edit"><a href="admin.php?page=managesites&id=' .  $website['id'] . '">' . __("Edit") . '</a></span></div>';                    
            }
    ?>   
        <tr id="<?php echo $report->id; ?>">            
            <td>
                <a href="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=editreport&id=<?php echo $report->id; ?>"><strong><?php echo stripslashes($report->title); ?></strong></a>
                <div class="row-actions"><a href="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=preview&id=<?php echo $report->id; ?>"><?php _e("Preview");?></a></span> |  
                    <a href="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=editreport&id=<?php echo $report->id; ?>"><?php _e("Edit");?></a></span> |  
                    <a href="admin.php?page=Extensions-Mainwp-Client-Reporting-Extension&action=sendreport&id=<?php echo $report->id; ?>"><?php _e("Send");?></a> | 
                    <span class="delete"><a href="#" class="mwp-creport-report-item-delete-lnk"><?php _e("Delete");?></a></span> 
                </div>                     
                <span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>
            </td> 
            <td>
                <?php echo stripslashes($report->client); ?>
            </td> 
            <td>
                <?php echo $report->name . " - " . $report->company ."<br>" . (!empty($report->email) ? "<a href=\"mailto:" . $report->email ."\">" . $report->email . "</a>" : ""); ?>
            </td> 
            <td> 
                <?php echo !empty($report->lastsend) ? MainWPCReportUtility::formatTimestamp($report->lastsend) : ""; ?>
            </td>
            <td> 
                <?php echo !empty($report->date_from) ? "From: " . MainWPCReportUtility::formatTimestamp($report->date_from) . "<br>" : ""; ?>
                <?php echo !empty($report->date_to) ? "To: " . MainWPCReportUtility::formatTimestamp($report->date_to) : ""; ?>
            </td>
            <td> 
                <?php echo $site_column; ?>
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
        <br>
        <script>    
            jQuery(document).ready(function() {
                jQuery('#mainwp_creport_autocomplete_client').each(function(key, value) {
                    var autocompleteList = jQuery(value).attr('autocompletelist');
                    var realList = jQuery('#' + autocompleteList);
                    var text = [];
                    var foundOptions = realList.find('option');
                    for (var i = 0; i < foundOptions.length; i++)
                    {
                        text.push(jQuery(foundOptions[i]).val());
                    }
                    jQuery(value).autocomplete({
                            source:text,
                            change : mainwp_creport_client_change
                    });
                });                
                //$("#mainwp_creport_autocomplete_client").data("ui-autocomplete")._trigger("change");                
            });        
        </script>  
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
        $to_client = $to_name = $to_company = $to_email = "";
        $client_id = 0;  
        //print_r($report);
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
            $to_client = $report->client;            
            $client_id = intval($report->client_id);
        } 
//        else if (isset($_POST['submit'])){
//            $title =  isset($_POST['mwp_creport_title']) ? trim($_POST['mwp_creport_title']) : "";
//            $date_from =  isset($_POST['mwp_creport_date_from']) ? trim($_POST['mwp_creport_date_from']) : "";
//            $date_to =  isset($_POST['mwp_creport_date_to']) ? trim($_POST['mwp_creport_date_to']) : "";
//            $from_name =  isset($_POST['mwp_creport_fname']) ? trim($_POST['mwp_creport_fname']) : "";
//            $from_company =  isset($_POST['mwp_creport_fcompany']) ? trim($_POST['mwp_creport_fcompany']) : "";
//            $from_email =  isset($_POST['mwp_creport_femail']) ? trim($_POST['mwp_creport_femail']) : "";
//            $to_name =  isset($_POST['mwp_creport_name']) ? trim($_POST['mwp_creport_name']) : "";
//            $to_company =  isset($_POST['mwp_creport_company']) ? trim($_POST['mwp_creport_company']) : "";
//            $to_email =  isset($_POST['mwp_creport_email']) ? trim($_POST['mwp_creport_email']) : "";
//        }
            
        $clients = MainWPCReportDB::Instance()->getClients();
        if (!is_array($clients)) 
            $clients = array();
        
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
            <th><span><?php _e("Client"); ?></span></th>
            <td>
                <input type="text" name="mwp_creport_client" value="<?php echo stripslashes($to_client); ?>" 
                       autocompletelist="clients_list" id="mainwp_creport_autocomplete_client" />   
                <span id="mainwp_creport_client_loading"><img src="<?php echo plugins_url('images/loader.gif', dirname(__FILE__)); ?>" class="hidden-field"></span> 
                    <datalist id="clients_list">
                    <?php
                        foreach($clients as $client) {
                            echo '<option>' . $client->client . '</option>';
                        }
                    ?>
                    </datalist>
                
                
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
        <input type="hidden" name="mwp_creport_client_id" value="<?php echo $client_id; ?>">
    <?php
    }            
    
    public static function newReportFormatTableContent($report = null) {
        $header = $body = $footer = $file_logo = "";
        
        if ($report && is_object($report)) {
            $header = $report->header;
            $body = $report->body;
            $footer = $report->footer;
            $file_logo = $report->logo_file;            
        } 
            
        $client_tokens = MainWPCReportDB::Instance()->getTokens();
        $client_tokens_values = array();  
        
        if ($report->selected_site) {
            $website = null;
            global $mainWPCReportExtensionActivator;
            $website = apply_filters('mainwp-getsites', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), $report->selected_site);            
            if ($website && is_array($website)) {
                $website = current($website);
            }           
        
            if (is_array($website) && isset($website['url'])) {            
                $site_tokens = MainWPCReportDB::Instance()->getSiteTokens($website['url']);                
                foreach ($client_tokens as $token) {             
                    $client_tokens_values[] = array('token_name' => $token->token_name,
                                                    'token_value' => isset($site_tokens[$token->id]) ? $site_tokens[$token->id]->token_value : ""
                                                    );
                }  
            }
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
            <br/>
                <p><a href="#" style="float: right" class="mainwp_creport_show_insert_tokens_book_lnk"><?php _e("Show Available Tokens"); ?></a></p>
                <br class="clearfix"/>
               <?php self::gen_insert_tokens_box("header", true, $client_tokens_values, $client_tokens); ?>
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
               <?php self::gen_insert_tokens_box("body", false, $client_tokens_values, $client_tokens); ?>
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
            <br/>
                <p><a href="#" style="float: right" class="mainwp_creport_show_insert_tokens_book_lnk"><?php _e("Show Available Tokens"); ?></a></p>
                <br class="clearfix"/>            
               <?php self::gen_insert_tokens_box("footer", true, $client_tokens_values, $client_tokens); ?>
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
                    <input type="hidden" name="mainwp_creport_report_temp_logo" value="<?php echo $file_logo ?>"/>
                <?php                      
                }
                ?>                                
                <input type="file" name="mainwp_creport_logo_file" accept="image/*" />
            </td>
        </tr>
    <?php
    
    }       
    
    public static function gen_insert_tokens_box($editor, $hide = false, $client_tokens_values, $client_tokens) {
    ?>
     <div class="creport_format_insert_tokens_box <?php echo $hide ? "hidden-field" : ""; ?>" editor="<?php echo $editor; ?>">
         <div class="creport_format_data_tokens">
            <div class="creport_format_group_nav top">
                <?php
                    $visible = "plugins";
                    $nav_group = "";
                    foreach (self::$tokens_nav_top as $group => $group_title) {                                                                
                        $current = ($visible == $group) ? "current" : "";
                        $nav_group .= '<a href="#" group="' . $group . '" group-title="' . $group_title . '" class="creport_nav_group_lnk ' . $current . '">' . $group_title . '</a> | ';                                
                    }  
                    $nav_group = rtrim($nav_group, ' | ');
                    echo $nav_group;
                ?>                
            </div>
            <?php
                $visible_group = $visible."_sections";
                foreach (self::$stream_tokens as $group => $group_tokens) {
                    foreach($group_tokens as $key => $tokens) {   
                        if ($key == "nav_group_tokens")
                            continue;
                        
                    ?>
                        <div class="creport_format_group_data_tokens <?php echo ($visible_group == $group . "_" . $key) ? "current" : ""; ?>" group="<?php echo $group . "_" . $key; ?>">
                            <table>                                
                            <?php    
                                if ($group == "client" && $key == "tokens" && is_array($client_tokens)) {
                                    if (is_array($client_tokens_values) && count($client_tokens_values) > 0) {
                                        foreach($client_tokens_values as $token) {                                    
                                           echo "<tr><td><a href=\"#\" token-value = \"" . $token['token_value'] . "\"class=\"creport_format_add_token\">[" . $token['token_name'] . "]</a></td>"
                                                   . "<td class=\"creport_stream_token_desc\">" . $token['token_value'] ."</td>"
                                                   . "</tr>";
                                        }
                                    } else if (is_array($client_tokens) && count($client_tokens) > 0) {
                                        foreach($client_tokens as $token) {                                    
                                           echo "<tr><td><a href=\"#\" token-value =\"\" class=\"creport_format_add_token\">[" . $token->token_name . "]</a></td>"
                                                   . "<td class=\"creport_stream_token_desc\">" . $token->token_description ."</td>"
                                                   . "</tr>";
                                        }
                                    }                                    
                                } else {
                                    foreach($tokens as $token) {
                                       echo "<tr><td><a href=\"#\" token-value =\"\" class=\"creport_format_add_token\">[" . $token["name"] . "]</a></td>"
                                               . "<td class=\"creport_stream_token_desc\">" . $token["desc"] ."</td>"
                                               . "</tr>";
                                    }
                                }
                            ?>
                            </table>                               
                        </div>
                    <?php
                    }
                }           
            ?>
            </div>
            <div class="creport_format_nav_bottom">
            <?php
                $visible = "plugins";
                $visible_nav = "sections";                                                       
                foreach (self::$stream_tokens as $group => $group_tokens) {                        
                    $nav_group_bottom = '';
                    $group_title = self::$tokens_nav_top[$group];
                    foreach ($group_tokens['nav_group_tokens'] as $nav_key => $nav_value) {                                            
                        $current_nav = ($visible . "_" . $visible_nav ==  $group . "_" . $nav_key) ? "current" : "";
                        $nav_group_bottom .= '<a href="#" group="' . $group . "_" . $nav_key . '" group-title="' . $group_title . '" group2-title="' . $nav_value . '" class="creport_nav_bottom_group_lnk ' . $current_nav . '">' . $nav_value . '</a> | ';                                                                        
                    }  
                    $nav_group_bottom = rtrim($nav_group_bottom, ' | ');
                    $current = ($visible ==  $group) ? "current" : "";
                    echo '<div class="creport_format_group_nav bottom ' . $current . '" group="' . $group . '">' . $nav_group_bottom . '</div>';        
                }
                $breadcrumb = '<a href="javascript:void(0)" class="group" >' . self::$tokens_nav_top[$visible] . 
                        "</a><span class=\"crp_content_group2\"> > " . '<a href="javascript:void(0)" class="group2">' . 
                        self::$stream_tokens[$visible]['nav_group_tokens'][$visible_nav] . '</a></span>';

            ?>    
                <div class="creport_format_nav_bottom_breadcrumb">
                    <?php _e("You are currently here:") ?> <span><?php echo $breadcrumb; ?></span>
                </div> 
            </div>         
        </div> 
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
    
    public function load_site_tokens() {
        
        $site_id = isset($_POST['siteId']) ? $_POST['siteId'] : 0;
        if ($site_id) {
            $website = null;
            global $mainWPCReportExtensionActivator;
            $website = apply_filters('mainwp-getsites', $mainWPCReportExtensionActivator->getChildFile(), $mainWPCReportExtensionActivator->getChildKey(), $site_id);            
            if ($website && is_array($website)) {
                $website = current($website);
            }           
        
            if (is_array($website) && isset($website['url'])) {    
                $client_tokens = MainWPCReportDB::Instance()->getTokens();
                $client_tokens_values = array();
                $site_tokens = MainWPCReportDB::Instance()->getSiteTokens($website['url']);                
                foreach ($client_tokens as $token) {             
                    $client_tokens_values[] = array('token_name' => $token->token_name,
                                                    'token_value' => isset($site_tokens[$token->id]) ? $site_tokens[$token->id]->token_value : ""
                                                    );
                }                  
                if (count($client_tokens_values) > 0) {              
                    foreach($client_tokens_values as $token) {                                    
                        echo "<tr><td><a href=\"#\" token-value = \"" . $token['token_value'] . "\"class=\"creport_format_add_token\">[" . $token['token_name'] . "]</a></td>"
                                . "<td class=\"creport_stream_token_desc\">" . $token['token_value'] ."</td>"
                                . "</tr>";
                    }
                }
                die();
            }
        }        
        die('EMPTY');
    }            
    
    public function load_client() {
        if (isset($_POST['client'])) {
            $client = MainWPCReportDB::Instance()->getClientBy('client' , $_POST['client']);
            if (!empty($client)) {
                $result = array('clientid' => $client->clientid,
                                'name' => $client->name,
                                'company' => $client->company,
                                'email' => $client->email
                                );
                die(json_encode($result));
            }
        }
        die(json_encode('EMPTY'));
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
