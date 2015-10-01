<?php

class MainWP_CReport {

	private static $stream_tokens = array();
	private static $tokens_nav_top = array();
	private static $buffer = array();
	private static $order = '';
	private static $enabled_piwik = null;
	private static $enabled_sucuri = false;
	private static $enabled_ga = null;
	private static $enabled_aum = null;
	private static $enabled_woocomstatus = null;
	private static $count_sec_header = 0;
	private static $count_sec_body = 0;
	private static $count_sec_footer = 0;

	public function __construct() {

	}

	public static function init() {
		self::$stream_tokens = array(
			'client' => array(
		'tokens' => array(),
				'nav_group_tokens' => array(),
			),
			'plugins' => array(
			'sections' => array(
					array( 'name' => 'section.plugins.installed', 'desc' => 'Loops through Plugins Installed during the selected date range' ),
					array( 'name' => 'section.plugins.activated', 'desc' => 'Loops through Plugins Activated during the selected date range' ),
					array( 'name' => 'section.plugins.edited', 'desc' => 'Loops through Plugins Edited during the selected date range' ),
					array( 'name' => 'section.plugins.deactivated', 'desc' => 'Loops through Plugins Deactivated during the selected date range' ),
					array( 'name' => 'section.plugins.updated', 'desc' => 'Loops through Plugins Updated during the selected date range' ),
					array( 'name' => 'section.plugins.deleted', 'desc' => 'Loops through Plugins Deleted during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'installed' => 'Installed',
					'activated' => 'Activated',
					'edited' => 'Edited',
					'deactivated' => 'Deactivated',
					'updated' => 'Updated',
					'deleted' => 'Deleted',
					'additional' => 'Additional',
				),
				'installed' => array(
					array( 'name' => 'plugin.name', 'desc' => 'Displays the Plugin Name' ),
					array( 'name' => 'plugin.installed.date', 'desc' => 'Displays the Plugin Installation Date' ),
					array( 'name' => 'plugin.installed.author', 'desc' => 'Displays the User who Installed the Plugin' ),
				),
				'activated' => array(
					array( 'name' => 'plugin.name', 'desc' => 'Displays the Plugin Name' ),
					array( 'name' => 'plugin.activated.date', 'desc' => 'Displays the Plugin Activation Date' ),
					array( 'name' => 'plugin.activated.author', 'desc' => 'Displays the User who Activated the Plugin' ),
				),
				'edited' => array(
					array( 'name' => 'plugin.name', 'desc' => 'Displays the Plugin Name' ),
					array( 'name' => 'plugin.edited.date', 'desc' => 'Displays the Plugin Editing Date' ),
					array( 'name' => 'plugin.edited.author', 'desc' => 'Displays the User who Edited the Plugin' ),
				),
				'deactivated' => array(
					array( 'name' => 'plugin.name', 'desc' => 'Displays the Plugin Name' ),
					array( 'name' => 'plugin.deactivated.date', 'desc' => 'Displays the Plugin Deactivation Date' ),
					array( 'name' => 'plugin.deactivated.author', 'desc' => 'Displays the User who Deactivated the Plugin' ),
				),
				'updated' => array(
					array( 'name' => 'plugin.old.version', 'desc' => 'Displays the Plugin Version Before Update' ),
					array( 'name' => 'plugin.current.version', 'desc' => 'Displays the Plugin Current Vesion' ),
					array( 'name' => 'plugin.name', 'desc' => 'Displays the Plugin Name' ),
					array( 'name' => 'plugin.updated.date', 'desc' => 'Displays the Plugin Update Date' ),
					array( 'name' => 'plugin.updated.author', 'desc' => 'Displays the User who Updated the Plugin' ),
				),
				'deleted' => array(
					array( 'name' => 'plugin.name', 'desc' => 'Displays the Plugin Name' ),
					array( 'name' => 'plugin.deleted.date', 'desc' => 'Displays the Plugin Deliting Date' ),
					array( 'name' => 'plugin.deleted.author', 'desc' => 'Displays the User who Deleted the Plugin' ),
				),
				'additional' => array(
					array( 'name' => 'plugin.installed.count', 'desc' => 'Displays the Number of Installed Plugins' ),
					array( 'name' => 'plugin.edited.count', 'desc' => 'Displays the Number of Edited Plugins' ),
					array( 'name' => 'plugin.activated.count', 'desc' => 'Displays the Number of Activated Plugins' ),
					array( 'name' => 'plugin.deactivated.count', 'desc' => 'Displays the Number of Deactivated Plugins' ),
					array( 'name' => 'plugin.deleted.count', 'desc' => 'Displays the Number of Deleted Plugins' ),
					array( 'name' => 'plugin.updated.count', 'desc' => 'Displays the Number of Updated Plugins' ),
				),
			),
			'themes' => array(
			'sections' => array(
					array( 'name' => 'section.themes.installed', 'desc' => 'Loops through Themes Installed during the selected date range' ),
					array( 'name' => 'section.themes.activated', 'desc' => 'Loops through Themes Activated during the selected date range' ),
					array( 'name' => 'section.themes.edited', 'desc' => 'Loops through Themes Edited during the selected date range' ),
					array( 'name' => 'section.themes.updated', 'desc' => 'Loops through Themes Updated during the selected date range' ),
					array( 'name' => 'section.themes.deleted', 'desc' => 'Loops through Themes Deleted during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'installed' => 'Installed',
					'activated' => 'Activated',
					'edited' => 'Edited',
					'updated' => 'Updated',
					'deleted' => 'Deleted',
					'additional' => 'Additional',
				),
				'installed' => array(
					array( 'name' => 'theme.name', 'desc' => 'Displays the Theme Name' ),
					array( 'name' => 'theme.installed.date', 'desc' => 'Displays the Theme Installation Date' ),
					array( 'name' => 'theme.installed.author', 'desc' => 'Displays the User who Installed the Theme' ),
				),
				'activated' => array(
					array( 'name' => 'theme.name', 'desc' => 'Displays the Theme Name' ),
					array( 'name' => 'theme.activated.date', 'desc' => 'Displays the Theme Activation Date' ),
					array( 'name' => 'theme.activated.author', 'desc' => 'Displays the User who Activated the Theme' ),
				),
				'edited' => array(
					array( 'name' => 'theme.name', 'desc' => 'Displays the Theme Name' ),
					array( 'name' => 'theme.edited.date', 'desc' => 'Displays the Theme Editing Date' ),
					array( 'name' => 'theme.edited.author', 'desc' => 'Displays the User who Edited the Theme' ),
				),
				'updated' => array(
					array( 'name' => 'theme.old.version', 'desc' => 'Displays the Theme Version Before Update' ),
					array( 'name' => 'theme.current.version', 'desc' => 'Displays the Theme Current Version' ),
					array( 'name' => 'theme.name', 'desc' => 'Displays the Theme Name' ),
					array( 'name' => 'theme.updated.date', 'desc' => 'Displays the Theme Update Date' ),
					array( 'name' => 'theme.updated.author', 'desc' => 'Displays the User who Updated the Theme' ),
				),
				'deleted' => array(
					array( 'name' => 'theme.name', 'desc' => 'Displays the Theme Name' ),
					array( 'name' => 'theme.deleted.date', 'desc' => 'Displays the Theme Deleting Date' ),
					array( 'name' => 'theme.deleted.author', 'desc' => 'Displays the User who Deleted the Theme' ),
				),
				'additional' => array(
					array( 'name' => 'theme.installed.count', 'desc' => 'Displays the Number of Installed Themes' ),
					array( 'name' => 'theme.edited.count', 'desc' => 'Displays the Number of Edited Themes' ),
					array( 'name' => 'theme.activated.count', 'desc' => 'Displays the Number of Activated Themes' ),
					array( 'name' => 'theme.deleted.count', 'desc' => 'Displays the Number of Deleted Themes' ),
					array( 'name' => 'theme.updated.count', 'desc' => 'Displays the Number of Updated Themes' ),
				),
			),
			'posts' => array(
			'sections' => array(
					array( 'name' => 'section.posts.created', 'desc' => 'Loops through Posts Created during the selected date range' ),
					array( 'name' => 'section.posts.updated', 'desc' => 'Loops through Posts Updated during the selected date range' ),
					array( 'name' => 'section.posts.trashed', 'desc' => 'Loops through Posts Trashed during the selected date range' ),
					array( 'name' => 'section.posts.deleted', 'desc' => 'Loops through Posts Deleted during the selected date range' ),
					array( 'name' => 'section.posts.restored', 'desc' => 'Loops through Posts Restored during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'created' => 'Created',
					'updated' => 'Updated',
					'trashed' => 'Trashed',
					'deleted' => 'Deleted',
					'restored' => 'Restored',
					'additional' => 'Additional',
				),
				'created' => array(
					array( 'name' => 'post.title', 'desc' => 'Displays the Post Title' ),
					array( 'name' => 'post.created.date', 'desc' => 'Displays the Post Createion Date' ),
					array( 'name' => 'post.created.author', 'desc' => 'Displays the User who Created the Post' ),
				),
				'updated' => array(
					array( 'name' => 'post.title', 'desc' => 'Displays the Post Title' ),
					array( 'name' => 'post.updated.date', 'desc' => 'Displays the Post Update Date' ),
					array( 'name' => 'post.updated.author', 'desc' => 'Displays the User who Updated the Post' ),
				),
				'trashed' => array(
					array( 'name' => 'post.title', 'desc' => 'Displays the Post Title' ),
					array( 'name' => 'post.trashed.date', 'desc' => 'Displays the Post Trashing Date' ),
					array( 'name' => 'post.trashed.author', 'desc' => 'Displays the User who Trashed the Post' ),
				),
				'deleted' => array(
					array( 'name' => 'post.title', 'desc' => 'Displays the Post Title' ),
					array( 'name' => 'post.deleted.date', 'desc' => 'Displays the Post Deleting Date' ),
					array( 'name' => 'post.deleted.author', 'desc' => 'Displays the User who Deleted the Post' ),
				),
				'restored' => array(
					array( 'name' => 'post.title', 'desc' => 'Displays Post Title' ),
					array( 'name' => 'post.restored.date', 'desc' => 'Displays the Post Restoring Date' ),
					array( 'name' => 'post.restored.author', 'desc' => 'Displays the User who Restored the Post' ),
				),
				'additional' => array(
					array( 'name' => 'post.created.count', 'desc' => 'Displays the Number of Created Posts' ),
					array( 'name' => 'post.updated.count', 'desc' => 'Displays the Number of Updated Posts' ),
					array( 'name' => 'post.trashed.count', 'desc' => 'Displays the Number of Trashed Posts' ),
					array( 'name' => 'post.restored.count', 'desc' => 'Displays the Number of Restored Posts' ),
					array( 'name' => 'post.deleted.count', 'desc' => 'Displays the Number of Deleted Posts' ),
				),
			),
			'pages' => array(
			'sections' => array(
					array( 'name' => 'section.pages.created', 'desc' => 'Loops through Pages Created during the selected date range' ),
					array( 'name' => 'section.pages.updated', 'desc' => 'Loops through Pages Updated during the selected date range' ),
					array( 'name' => 'section.pages.trashed', 'desc' => 'Loops through Pages Trashed during the selected date range' ),
					array( 'name' => 'section.pages.deleted', 'desc' => 'Loops through Pages Deleted during the selected date range' ),
					array( 'name' => 'section.pages.restored', 'desc' => 'Loops through Pages Restored during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'created' => 'Created',
					'updated' => 'Updated',
					'trashed' => 'Trashed',
					'deleted' => 'Deleted',
					'restored' => 'Restored',
					'additional' => 'Additional',
				),
				'created' => array(
					array( 'name' => 'page.title', 'desc' => 'Displays the Page Title' ),
					array( 'name' => 'page.created.date', 'desc' => 'Displays the Page Createion Date' ),
					array( 'name' => 'page.created.author', 'desc' => 'Displays the User who Created the Page' ),
				),
				'updated' => array(
					array( 'name' => 'page.title', 'desc' => 'Displays the Page Title' ),
					array( 'name' => 'page.updated.date', 'desc' => 'Displays the Page Updating Date' ),
					array( 'name' => 'page.updated.author', 'desc' => 'Displays the User who Updated the Page' ),
				),
				'trashed' => array(
					array( 'name' => 'page.title', 'desc' => 'Displays the Page Title' ),
					array( 'name' => 'page.trashed.date', 'desc' => 'Displays the Page Trashing Date' ),
					array( 'name' => 'page.trashed.author', 'desc' => 'Displays the User who Trashed the Page' ),
				),
				'deleted' => array(
					array( 'name' => 'page.title', 'desc' => 'Displays the Page Title' ),
					array( 'name' => 'page.deleted.date', 'desc' => 'Displays the Page Deleting Date' ),
					array( 'name' => 'page.deleted.author', 'desc' => 'Displays the User who Deleted the Page' ),
				),
				'restored' => array(
					array( 'name' => 'page.title', 'desc' => 'Displays the Page Title' ),
					array( 'name' => 'page.restored.date', 'desc' => 'Displays the Page Restoring Date' ),
					array( 'name' => 'page.restored.author', 'desc' => 'Displays the User who Restored the Page' ),
				),
				'additional' => array(
					array( 'name' => 'page.created.count', 'desc' => 'Displays the Number of Created Pages' ),
					array( 'name' => 'page.updated.count', 'desc' => 'Displays the Number of Updated Pages' ),
					array( 'name' => 'page.trashed.count', 'desc' => 'Displays the Number of Trashed Pages' ),
					array( 'name' => 'page.restored.count', 'desc' => 'Displays the Number of Restored Pages' ),
					array( 'name' => 'page.deleted.count', 'desc' => 'Displays the Number of Deleted Pages' ),
				),
			),
			'comments' => array(
			'sections' => array(
					array( 'name' => 'section.comments.created', 'desc' => 'Loops through Comments Created during the selected date range' ),
					array( 'name' => 'section.comments.updated', 'desc' => 'Loops through Comments Updated during the selected date range' ),
					array( 'name' => 'section.comments.trashed', 'desc' => 'Loops through Comments Trashed during the selected date range' ),
					array( 'name' => 'section.comments.deleted', 'desc' => 'Loops through Comments Deleted during the selected date range' ),
					array( 'name' => 'section.comments.edited', 'desc' => 'Loops through Comments Edited during the selected date range' ),
					array( 'name' => 'section.comments.restored', 'desc' => 'Loops through Comments Restored during the selected date range' ),
					array( 'name' => 'section.comments.approved', 'desc' => 'Loops through Comments Approved during the selected date range' ),
					array( 'name' => 'section.comments.spam', 'desc' => 'Loops through Comments Spammed during the selected date range' ),
					array( 'name' => 'section.comments.replied', 'desc' => 'Loops through Comments Replied during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'created' => 'Created',
					'updated' => 'Updated',
					'trashed' => 'Trashed',
					'deleted' => 'Deleted',
					'edited' => 'Edited',
					'restored' => 'Restored',
					'approved' => 'Approved',
					'spam' => 'Spam',
					'replied' => 'Replied',
					'additional' => 'Additional',
				),
				'created' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Created' ),
					array( 'name' => 'comment.created.date', 'desc' => 'Displays the Comment Creating Date' ),
					array( 'name' => 'comment.created.author', 'desc' => 'Displays the User who Created the Comment' ),
				),
				'updated' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Updated' ),
					array( 'name' => 'comment.updated.date', 'desc' => 'Displays the Comment Updating Date' ),
					array( 'name' => 'comment.updated.author', 'desc' => 'Displays the User who Updated the Comment' ),
				),
				'trashed' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Trashed' ),
					array( 'name' => 'comment.trashed.date', 'desc' => 'Displays the Comment Trashing Date' ),
					array( 'name' => 'comment.trashed.author', 'desc' => 'Displays the User who Trashed the Comment' ),
				),
				'deleted' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Deleted' ),
					array( 'name' => 'comment.deleted.date', 'desc' => 'Displays the Comment Deleting Date' ),
					array( 'name' => 'comment.deleted.author', 'desc' => 'Displays the User who Deleted the Comment' ),
				),
				'edited' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Edited' ),
					array( 'name' => 'comment.edited.date', 'desc' => 'Displays the Comment Editing Date' ),
					array( 'name' => 'comment.edited.author', 'desc' => 'Displays the User who Edited the Comment' ),
				),
				'restored' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Restored' ),
					array( 'name' => 'comment.restored.date', 'desc' => 'Displays the Comment Restoring Date' ),
					array( 'name' => 'comment.restored.author', 'desc' => 'Displays the User who Restored the Comment' ),
				),
				'approved' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Approved' ),
					array( 'name' => 'comment.approved.date', 'desc' => 'Displays the Comment Approving Date' ),
					array( 'name' => 'comment.approved.author', 'desc' => 'Displays the User who Approved the Comment' ),
				),
				'spam' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Spammed' ),
					array( 'name' => 'comment.spam.date', 'desc' => 'Displays the Comment Spamming Date' ),
					array( 'name' => 'comment.spam.author', 'desc' => 'Displays the User who Spammed the Comment' ),
				),
				'replied' => array(
					array( 'name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Replied' ),
					array( 'name' => 'comment.replied.date', 'desc' => 'Displays the Comment Replying Date' ),
					array( 'name' => 'comment.replied.author', 'desc' => 'Displays the User who Replied the Comment' ),
				),
				'additional' => array(
					array( 'name' => 'comment.created.count', 'desc' => 'Displays the Number of Created Comments' ),
					array( 'name' => 'comment.trashed.count', 'desc' => 'Displays the Number of Trashed Comments' ),
					array( 'name' => 'comment.deleted.count', 'desc' => 'Displays the Number of Deleted Comments' ),
					array( 'name' => 'comment.edited.count', 'desc' => 'Displays the Number of Edited Comments' ),
					array( 'name' => 'comment.restored.count', 'desc' => 'Displays the Number of Restored Comments' ),
					array( 'name' => 'comment.deleted.count', 'desc' => 'Displays the Number of Deleted Comments' ),
					array( 'name' => 'comment.approved.count', 'desc' => 'Displays the Number of Approved Comments' ),
					array( 'name' => 'comment.spam.count', 'desc' => 'Displays the Number of Spammed Comments' ),
					array( 'name' => 'comment.replied.count', 'desc' => 'Displays the Number of Replied Comments' ),
				),
			),
			'users' => array(
			'sections' => array(
					array( 'name' => 'section.users.created', 'desc' => 'Loops through Users Created during the selected date range' ),
					array( 'name' => 'section.users.updated', 'desc' => 'Loops through Users Updated during the selected date range' ),
					array( 'name' => 'section.users.deleted', 'desc' => 'Loops through Users Deleted during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'created' => 'Created',
					'updated' => 'Updated',
					'deleted' => 'Deleted',
					'additional' => 'Additional',
				),
				'created' => array(
					array( 'name' => 'user.name', 'desc' => 'Displays the User Name' ),
					array( 'name' => 'user.created.date', 'desc' => 'Displays the User Creation Date' ),
					array( 'name' => 'user.created.author', 'desc' => 'Displays the User who Created the new User' ),
					array( 'name' => 'user.created.role', 'desc' => 'Displays the Role of the Created User' ),
				),
				'updated' => array(
					array( 'name' => 'user.name', 'desc' => 'Displays the User Name' ),
					array( 'name' => 'user.updated.date', 'desc' => 'Displays the User Updating Date' ),
					array( 'name' => 'user.updated.author', 'desc' => 'Displays the User who Updated the new User' ),
					array( 'name' => 'user.updated.role', 'desc' => 'Displays the Role of the Updated User' ),
				),
				'deleted' => array(
					array( 'name' => 'user.name', 'desc' => 'Displays the User Name' ),
					array( 'name' => 'user.deleted.date', 'desc' => 'Displays the User Deleting Date' ),
					array( 'name' => 'user.deleted.author', 'desc' => 'Displays the User who Deleted the new User' ),
				),
				'additional' => array(
					array( 'name' => 'user.created.count', 'desc' => 'Displays the Number of Created Users' ),
					array( 'name' => 'user.updated.count', 'desc' => 'Displays the Number of Updated Users' ),
					array( 'name' => 'user.deleted.count', 'desc' => 'Displays the Number of Deleted Users' ),
				),
			),
			'media' => array(
			'sections' => array(
					array( 'name' => 'section.media.uploaded', 'desc' => 'Loops through Media Uploaded during the selected date range' ),
					array( 'name' => 'section.media.updated', 'desc' => 'Loops through Media Updated during the selected date range' ),
					array( 'name' => 'section.media.deleted', 'desc' => 'Loops through Media Deleted during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'uploaded' => 'Uploaded',
					'updated' => 'Updated',
					'deleted' => 'Deleted',
					'additional' => 'Additional',
				),
				'uploaded' => array(
					array( 'name' => 'media.name', 'desc' => 'Displays the Media Name' ),
					array( 'name' => 'media.uploaded.date', 'desc' => 'Displays the Media Uploading Date' ),
					array( 'name' => 'media.uploaded.author', 'desc' => 'Displays the User who Uploaded the Media File' ),
				),
				'updated' => array(
					array( 'name' => 'media.name', 'desc' => 'Displays the Media Name' ),
					array( 'name' => 'media.updated.date', 'desc' => 'Displays the Media Updating Date' ),
					array( 'name' => 'media.updated.author', 'desc' => 'Displays the User who Updted the Media File' ),
				),
				'deleted' => array(
					array( 'name' => 'media.name', 'desc' => 'Displays the Media Name' ),
					array( 'name' => 'media.deleted.date', 'desc' => 'Displays the Media Deleting Date' ),
					array( 'name' => 'media.deleted.author', 'desc' => 'Displays the User who Deleted the Media File' ),
				),
				'additional' => array(
					array( 'name' => 'media.uploaded.count', 'desc' => 'Displays the Number of Uploaded Media Files' ),
					array( 'name' => 'media.updated.count', 'desc' => 'Displays the Number of Updated Media Files' ),
					array( 'name' => 'media.deleted.count', 'desc' => 'Displays the Number of Deleted Media Files' ),
				),
			),
			'widgets' => array(
			'sections' => array(
					array( 'name' => 'section.widgets.added', 'desc' => 'Loops through Widgets Added during the selected date range' ),
					array( 'name' => 'section.widgets.updated', 'desc' => 'Loops through Widgets Updated during the selected date range' ),
					array( 'name' => 'section.widgets.deleted', 'desc' => 'Loops through Widgets Deleted during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'added' => 'Added',
					'updated' => 'Updated',
					'deleted' => 'Deleted',
					'additional' => 'Additional',
				),
				'added' => array(
					array( 'name' => 'widget.title', 'desc' => 'Displays the Widget Title' ),
					array( 'name' => 'widget.added.area', 'desc' => 'Displays the Widget Adding Area' ),
					array( 'name' => 'widget.added.date', 'desc' => 'Displays the Widget Adding Date' ),
					array( 'name' => 'widget.added.author', 'desc' => 'Displays the User who Added the Widget' ),
				),
				'updated' => array(
					array( 'name' => 'widget.title', 'desc' => 'Displays the Widget Name' ),
					array( 'name' => 'widget.updated.area', 'desc' => 'Displays the Widget Updating Area' ),
					array( 'name' => 'widget.updated.date', 'desc' => 'Displays the Widget Updating Date' ),
					array( 'name' => 'widget.updated.author', 'desc' => 'Displays the User who Updated the Widget' ),
				),
				'deleted' => array(
					array( 'name' => 'widget.title', 'desc' => 'Displays the Widget Name' ),
					array( 'name' => 'widget.deleted.area', 'desc' => 'Displays the Widget Deleting Area' ),
					array( 'name' => 'widget.deleted.date', 'desc' => 'Displays the Widget Deleting Date' ),
					array( 'name' => 'widget.deleted.author', 'desc' => 'Displays the User who Deleted the Widget' ),
				),
				'additional' => array(
					array( 'name' => 'widget.added.count', 'desc' => 'Displays the Number of Added Widgets' ),
					array( 'name' => 'widget.updated.count', 'desc' => 'Displays the Number of Updated Widgets' ),
					array( 'name' => 'widget.deleted.count', 'desc' => 'Displays the Number of Deleted Widgets' ),
				),
			),
			'menus' => array(
			'sections' => array(
					array( 'name' => 'section.menus.created', 'desc' => 'Loops through Menus Created during the selected date range' ),
					array( 'name' => 'section.menus.updated', 'desc' => 'Loops through Menus Updated during the selected date range' ),
					array( 'name' => 'section.menus.deleted', 'desc' => 'Loops through Menus Deleted during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'created' => 'Created',
					'updated' => 'Updated',
					'deleted' => 'Deleted',
					'additional' => 'Additional',
				),
				'created' => array(
					array( 'name' => 'menu.title', 'desc' => 'Displays the Menu Name' ),
					array( 'name' => 'menu.created.date', 'desc' => 'Displays the Menu Creation Date' ),
					array( 'name' => 'menu.created.author', 'desc' => 'Displays the User who Created the Menu' ),
				),
				'updated' => array(
					array( 'name' => 'menu.title', 'desc' => 'Displays the Menu Name' ),
					array( 'name' => 'menu.updated.date', 'desc' => 'Displays the Menu Updating Date' ),
					array( 'name' => 'menu.updated.author', 'desc' => 'Displays the User who Updated the Menu' ),
				),
				'deleted' => array(
					array( 'name' => 'menu.title', 'desc' => 'Displays the Menu Name' ),
					array( 'name' => 'menu.deleted.date', 'desc' => 'Displays the Menu Deleting Date' ),
					array( 'name' => 'menu.deleted.author', 'desc' => 'Displays the User who Deleted the Menu' ),
				),
				'additional' => array(
					array( 'name' => 'menu.created.count', 'desc' => 'Displays the Number of Created Menus' ),
					array( 'name' => 'menu.updated.count', 'desc' => 'Displays the Number of Updated Menus' ),
					array( 'name' => 'menu.deleted.count', 'desc' => 'Displays the Number of Deleted Menus' ),
				),
			),
			'wordpress' => array(
			'sections' => array(
					array( 'name' => 'section.wordpress.updated', 'desc' => 'Loops through WordPress Updates during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'updated' => 'Updated',
					'additional' => 'Additional',
				),
				'updated' => array(
					array( 'name' => 'wordpress.updated.date', 'desc' => 'Displays the WordPress Update Date' ),
					array( 'name' => 'wordpress.updated.author', 'desc' => 'Displays the User who Updated the Site' ),
				),
				'additional' => array(
					array( 'name' => 'wordpress.old.version', 'desc' => 'Displays the WordPress Version Before Update' ),
					array( 'name' => 'wordpress.current.version', 'desc' => 'Displays the Current WordPress Version' ),
					array( 'name' => 'wordpress.updated.count', 'desc' => 'Displays the Number of WordPress Updates' ),
				),
			),
			'backups' => array(
			'sections' => array(
					array( 'name' => 'section.backups.created', 'desc' => ' Loops through Backups Created during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'created' => 'Created',
					'additional' => 'Additional',
				),
				'created' => array(
					array( 'name' => 'backup.created.type', 'desc' => ' Displays the Created Backup type (Full or Database)' ),
					array( 'name' => 'backup.created.date', 'desc' => 'Displays the Backups Creation date' ),
				//array("name" => "backup.created.destination", "desc" => "Displays the Created Backup destination")
				),
				'additional' => array(
					array( 'name' => 'backup.created.count', 'desc' => 'Displays the number of created backups during the selected date range' ),
				),
			),
			'report' => array(
				'nav_group_tokens' => array( 'report' => 'Report' ),
				'report' => array(
					array( 'name' => 'report.daterange', 'desc' => 'Displays the report date range' ),
				),
			),
			'sucuri' => array(
			'sections' => array(
					array( 'name' => 'section.sucuri.checks', 'desc' => 'Loops through Security Checks during the selected date range' ),
				),
				'nav_group_tokens' => array(
			'sections' => 'Sections',
					'check' => 'Checks',
					'additional' => 'Additional',
				),
				'check' => array(
					array( 'name' => 'sucuri.check.date', 'desc' => 'Displays the Security Check date' ),
					array( 'name' => 'sucuri.check.status', 'desc' => 'Displays the Status info for the Child Site' ),
					array( 'name' => 'sucuri.check.webtrust', 'desc' => 'Displays the Webtrust info for the Child Site' ),
				//array("name" => "sucuri.check.results", "desc" => "Displays the Security Check details from the Security Scan Report"),
				),
				'additional' => array(
					array( 'name' => 'sucuri.checks.count', 'desc' => 'Displays the number of performed security checks during the selected date range' ),
				),
			),
			'ga' => array(
				'nav_group_tokens' => array(
					'ga' => 'GA',
				),
				'ga' => array(
					array( 'name' => 'ga.visits', 'desc' => 'Displays the Number Visits during the selected date range' ),
					array( 'name' => 'ga.pageviews', 'desc' => 'Displays the Number of Page Views during the selected date range' ),
					array( 'name' => 'ga.pages.visit', 'desc' => 'Displays the Number of Page visit during the selected date range' ),
					array( 'name' => 'ga.bounce.rate', 'desc' => 'Displays the Bounce Rate during the selected date range' ),
					array( 'name' => 'ga.avg.time', 'desc' => 'Displays the Average Visit Time during the selected date range' ),
					array( 'name' => 'ga.new.visits', 'desc' => 'Displays the Number of New Visits during the selected date range' ),
					array( 'name' => 'ga.visits.chart', 'desc' => 'Displays a chart for the activity over the past month' ),
					array( 'name' => 'ga.visits.maximum', 'desc' => "Displays the maximum visitor number and it's day within the past month" ),
					array( 'name' => 'ga.startdate', 'desc' => 'Displays the startdate for the chart' ),
					array( 'name' => 'ga.enddate', 'desc' => 'Displays the enddate or the chart' ),

				//array("name" => "ga.visits.chart", "desc" => "...")
				),
			),
			'piwik' => array(
				'nav_group_tokens' => array(
					'piwik' => 'Piwik',
				),
				'piwik' => array(
					array( 'name' => 'piwik.visits', 'desc' => 'Displays the Number Visits during the selected date range' ),
					array( 'name' => 'piwik.pageviews', 'desc' => 'Displays the Number of Page Views during the selected date range' ),
					array( 'name' => 'piwik.pages.visit', 'desc' => 'Displays the Number of Page visit during the selected date range' ),
					array( 'name' => 'piwik.bounce.rate', 'desc' => 'Displays the Bounce Rate during the selected date range' ),
					array( 'name' => 'piwik.avg.time', 'desc' => 'Displays the Average Visit Time during the selected date range' ),
					array( 'name' => 'piwik.new.visits', 'desc' => 'Displays the Number of New Visits during the selected date range' ),
				),
			),
			'aum' => array(
				'nav_group_tokens' => array(
					'aum' => 'AUM',
				),
				'aum' => array(
					array( 'name' => 'aum.alltimeuptimeratio', 'desc' => 'Displays the Uptime ratio from the moment the monitor has been created' ),
					array( 'name' => 'aum.uptime7', 'desc' => 'Displays the Uptime ratio for last 7 days' ),
					array( 'name' => 'aum.uptime15', 'desc' => 'Displays the Uptime ration for last 15 days' ),
					array( 'name' => 'aum.uptime30', 'desc' => 'Displays the Uptime ration for last 30 days' ),
					array( 'name' => 'aum.uptime45', 'desc' => 'Displays the Uptime ration for last 45 days' ),
					array( 'name' => 'aum.uptime60', 'desc' => 'Displays the Uptime ration for last 60 days' ),
				),
			),
			'woocomstatus' => array(
				'nav_group_tokens' => array(
					'woocomstatus' => 'WooCommerce Status',
				),
				'woocomstatus' => array(
					array( 'name' => 'wcomstatus.sales', 'desc' => 'Displays total sales during the selected data range' ),
					array( 'name' => 'wcomstatus.topseller', 'desc' => 'Displays the top seller product during the selected data range' ),
					array( 'name' => 'wcomstatus.awaitingprocessing', 'desc' => 'Displays the number of products currently awaiting for processing' ),
					array( 'name' => 'wcomstatus.onhold', 'desc' => 'Displays the number of orders currently on hold' ),
					array( 'name' => 'wcomstatus.lowonstock', 'desc' => 'Displays the number of products currently low on stock' ),
					array( 'name' => 'wcomstatus.outofstock', 'desc' => 'Displays the number of products currently out of stock' ),
				),
			),
		);

		self::$tokens_nav_top = array(
			'client' => 'Client Tokens',
			'report' => 'Report',
			'plugins' => 'Plugins',
			'themes' => 'Themes',
			'posts' => 'Posts',
			'pages' => 'Pages',
			'comments' => 'Comments',
			'users' => 'Users',
			'media' => 'Media',
			'widgets' => 'Widgets',
			'menus' => 'Menus',
			'wordpress' => 'WordPress',
			'backups' => 'Backups',
			'sucuri' => 'Sucuri',
			'ga' => 'GA',
			'piwik' => 'Piwik',
			'aum' => 'AUM',
			'woocomstatus' => 'WooCommerce Status',
		);
	}

	public function admin_init() {
		add_action( 'mainwp-extension-sites-edit', array( &$this, 'site_token' ), 9, 1 );
		add_action( 'wp_ajax_mainwp_creport_load_tokens', array( &$this, 'load_tokens' ) );
		add_action( 'wp_ajax_mainwp_creport_delete_token', array( &$this, 'delete_token' ) );
		add_action( 'wp_ajax_mainwp_creport_save_token', array( &$this, 'save_token' ) );
		add_action( 'wp_ajax_mainwp_creport_delete_report', array( &$this, 'delete_report' ) );
		add_action( 'wp_ajax_mainwp_creport_cancel_scheduled_report', array( &$this, 'cancel_scheduled_report' ) );
		add_action( 'wp_ajax_mainwp_creport_load_client', array( &$this, 'load_client' ) );
		add_action( 'wp_ajax_mainwp_creport_load_site_tokens', array( &$this, 'load_site_tokens' ) );
		add_action( 'wp_ajax_mainwp_creport_save_format', array( &$this, 'save_format' ) );
		add_action( 'wp_ajax_mainwp_creport_get_format', array( &$this, 'get_format' ) );
		add_action( 'wp_ajax_mainwp_creport_delete_format', array( &$this, 'delete_format' ) );

		//        add_action('wp_ajax_mainwp_creport_upgrade_noti_dismiss', array($this,'dismissNoti'));
		//        add_action('wp_ajax_mainwp_creport_active_plugin', array($this,'active_plugin'));
		//        add_action('wp_ajax_mainwp_creport_upgrade_plugin', array($this,'upgrade_plugin'));

		add_action( 'mainwp_update_site', array( &$this, 'update_site_update_tokens' ), 8, 1 );
		add_action( 'mainwp_delete_site', array( &$this, 'delete_site_delete_tokens' ), 8, 1 );
		add_action( 'mainwp_shortcuts_widget', array( &$this, 'shortcuts_widget' ), 10, 1 );
		add_filter( 'mainwp_managesites_column_url', array( &$this, 'managesites_column_url' ), 10, 2 );
		add_action( 'mainwp_managesite_backup', array( &$this, 'managesite_backup' ), 10, 3 );
		add_action( 'mainwp_sucuri_scan_done', array( &$this, 'sucuri_scan_done' ), 10, 3 );
		add_action( 'wp_ajax_mainwp_creport_delete_client', array( &$this, 'ajax_delete_client' ) );

		self::$enabled_piwik = apply_filters( 'mainwp-extension-available-check', 'mainwp-piwik-extension' );
		self::$enabled_sucuri = apply_filters( 'mainwp-extension-available-check', 'mainwp-sucuri-extension' );
		self::$enabled_ga = apply_filters( 'mainwp-extension-available-check', 'mainwp-google-analytics-extension' );
		self::$enabled_aum = apply_filters( 'mainwp-extension-available-check', 'advanced-uptime-monitor-extension' );
		self::$enabled_woocomstatus = apply_filters( 'mainwp-extension-available-check', 'mainwp-woocommerce-status-extension' );
	}

	function managesite_backup( $website, $args, $information ) {
		if ( empty( $website ) ) {
			return; }
		$type = isset( $args['type'] ) ? $args['type'] : '';
		if ( empty( $type ) ) {
			return; }
		//error_log(print_r($information,true));
		global $mainWPCReportExtensionActivator;

		$backup_type = ('full' == $type) ? 'Full' : ('db' == $type ? 'Database' : '');

		$message = '';
		$backup_status = 'success';
		$backup_size = 0;
		if ( isset( $information['error'] ) ) {
			$message = $information['error'];
			$backup_status = 'failed';
		} else if ( 'db' == $type && ! $information['db'] ) {
			$message = 'Database backup failed.';
			$backup_status = 'failed';
		} else if ( 'full' == $type && ! $information['full'] ) {
			$message = 'Full backup failed.';
			$backup_status = 'failed';
		} else if ( isset( $information['db'] ) ) {
			if ( false != $information['db'] ) {
				$message = 'Backup database success.';
			} else if ( false != $information['full'] ) {
				$message = 'Full backup success.';
			}
			if ( isset( $information['size'] ) ) {
				$backup_size = $information['size'];
			}
		} else {
			$message = 'Database backup failed due to an undefined error';
			$backup_status = 'failed';
		}

		// save results to child site stream
		$post_data = array(
		'mwp_action' => 'save_backup_stream',
			'size' => $backup_size,
			'message' => $message,
			'destination' => 'Local Server',
			'status' => $backup_status,
			'type' => $backup_type,
		);
		apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website->id, 'client_report', $post_data );
	}

	public static function managesite_schedule_backup( $website, $args, $backupResult ) {

		if ( empty( $website ) ) {
			return; }

		$type = isset( $args['type'] ) ? $args['type'] : '';
		if ( empty( $type ) ) {
			return; }

		$destination = '';
		if ( is_array( $backupResult ) ) {
			$error = false;
			if ( isset( $backupResult['error'] ) ) {
				$destination .= $backupResult['error'] . '<br />';
				$error = true;
			}

			if ( isset( $backupResult['ftp'] ) ) {
				if ( 'success' != $backupResult['ftp'] ) {
					$destination .= 'FTP: ' . $backupResult['ftp'] . '<br />';
					$error = true;
				} else {
					$destination .= 'FTP: success<br />';
				}
			}

			if ( isset( $backupResult['dropbox'] ) ) {
				if ( 'success' != $backupResult['dropbox'] ) {
					$destination .= 'Dropbox: ' . $backupResult['dropbox'] . '<br />';
					$error = true;
				} else {
					$destination .= 'Dropbox: success<br />';
				}
			}
			if ( isset( $backupResult['amazon'] ) ) {
				if ( 'success' != $backupResult['amazon'] ) {
					$destination .= 'Amazon: ' . $backupResult['amazon'] . '<br />';
					$error = true;
				} else {
					$destination .= 'Amazon: success<br />';
				}
			}

			if ( isset( $backupResult['copy'] ) ) {
				if ( 'success' != $backupResult['copy'] ) {
					$destination .= 'Copy.com: ' . $backupResult['amazon'] . '<br />';
					$error = true;
				} else {
					$destination .= 'Copy.com: success<br />';
				}
			}

			if ( empty( $destination ) ) {
				$destination = 'Local Server';
			}
		} else {
			$destination = $backupResult;
		}

		if ( 'full' == $type ) {
			$message = 'Schedule full backup.';
			$backup_type = 'Full';
		} else {
			$message = 'Schedule database backup.';
			$backup_type = 'Database';
		}

		global $mainWPCReportExtensionActivator;

		// save results to child site stream
		$post_data = array(
		'mwp_action' => 'save_backup_stream',
			'size' => 'N/A',
			'message' => $message,
			'destination' => $destination,
			'status' => 'N/A',
			'type' => $backup_type,
		);
		apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website->id, 'client_report', $post_data );
	}

	function mainwp_postprocess_backup_sites_feedback( $output, $unique ) {
		if ( ! is_array( $output ) ) {

		} else {
			foreach ( $output as $key => $value ) {
				$output[ $key ] = $value;
			}
		}

		return $output;
	}


	public function init_cron() {
		add_action( 'mainwp_creport_cron_archive_reports', array( 'MainWP_CReport', 'cron_archive_reports' ) );
		$useWPCron = (false === get_option( 'mainwp_wp_cron' )) || (1 == get_option( 'mainwp_wp_cron' ));
		if ( ($sched = wp_next_scheduled( 'mainwp_creport_cron_archive_reports' )) == false ) {
			if ( $useWPCron ) {
				$time = strtotime( date( 'Y-m-d' ) . ' 23:59:59' );
				// minutely
				wp_schedule_event( $time, 'daily', 'mainwp_creport_cron_archive_reports' );
			}
		} else {
			if ( ! $useWPCron ) {
				wp_unschedule_event( $sched, 'mainwp_creport_cron_archive_reports' ); }
		}
	}

	public static function cron_archive_reports() {
		$reports = MainWP_CReport_DB::get_instance()->get_avail_archive_reports();
		if ( is_array( $reports ) ) {
			foreach ( $reports as $report ) {
				self::archive_report( $report );
			}
		}
		self::send_schedule_reports();
	}

	public static function send_schedule_reports() {
		// check to send schedule reports
		$sche_reports = MainWP_CReport_DB::get_instance()->get_schedule_reports();
		if ( is_array( $sche_reports ) ) {
			foreach ( $sche_reports as $report ) {
				$schedule = $report->recurring_schedule;
				$recurring_date = $report->recurring_date;
				if ( empty( $schedule ) || empty( $report->scheduled ) || empty( $recurring_date ) ) {
					continue; }

				if ( time() >= $report->schedule_nextsend - 60 * 5 ) {
					$my_email = @apply_filters( 'mainwp_getnotificationemail' );
					$bcc = '';
					if ( $report->schedule_send_email == 'email_auto' ) {
						if ( $report->schedule_bcc_me ) {
							$bcc = $my_email; }
						self::send_report_mail( $report, '', '', $bcc );
					} else if ( $report->schedule_send_email == 'email_review' && ! empty( $my_email ) ) {
						self::send_report_mail( $report, $my_email, 'Review report' );
					}
					$sch_last_send = time();
					$schedule_nextsend = self::cal_schedule_nextsend( $schedule, $recurring_date, $sch_last_send );
					$update_report = array(
					'id' => $report->id,
						'date_from' => $sch_last_send + 1,
						'date_to' => $schedule_nextsend,
						'schedule_nextsend' => $schedule_nextsend,
						'schedule_lastsend' => $sch_last_send,
					);
					MainWP_CReport_DB::get_instance()->update_report( $update_report );
				}
			}
		}
	}

	public static function cal_schedule_nextsend( $schedule, $start_recurring_date, $scheduleLastSend = 0 ) {
		if ( empty( $schedule ) || empty( $start_recurring_date ) ) {
			return 0; }

		$start_today = strtotime( date( 'Y-m-d' ) . ' 00:00:00' );
		$end_today = strtotime( date( 'Y-m-d' ) . ' 23:59:59' );

		$next_report_date_to = 0;

		if ( 0 == $scheduleLastSend ) {
			if ( $start_recurring_date > $end_today ) {
				$next_report_date_to = $start_recurring_date;
			} else if ( $start_recurring_date > $start_today ) {
				$next_report_date_to = $end_today;
			} else {
				$scheduleLastSend = $start_recurring_date;
			}
		}

		// need to calc next send report date
		if ( 0 == $next_report_date_to ) {
			if ( 'daily' == $schedule ) {
				$next_report_date_to = $scheduleLastSend + 24 * 3600;
				while ( $next_report_date_to < $start_today ) {
					$next_report_date_to += 24 * 3600;
				}
			} else if ( 'weekly' == $schedule ) {
				$next_report_date_to = $scheduleLastSend + 7 * 24 * 3600;
				while ( $next_report_date_to < $start_today ) {
					$next_report_date_to += 24 * 3600;
				}
			} else if ( 'biweekly' == $schedule ) {
				$next_report_date_to = $scheduleLastSend + 2 * 7 * 24 * 3600;
				while ( $next_report_date_to < $start_today ) {
					$next_report_date_to += 2 * 7 * 24 * 3600;
				}
			} else if ( 'monthly' == $schedule ) {
				$next_report_date_to = self::calc_next_schedule_send_date( $start_recurring_date, $scheduleLastSend, 1 );
				while ( $next_report_date_to < $start_today ) {
					$next_report_date_to = self::calc_next_schedule_send_date( $start_recurring_date, $next_report_date_to, 1 );
				}
			} else if ( 'quarterly' == $schedule ) {
				$next_report_date_to = self::calc_next_schedule_send_date( $start_recurring_date, $scheduleLastSend, 3 );
				while ( $next_report_date_to < $start_today ) {
					$next_report_date_to = self::calc_next_schedule_send_date( $start_recurring_date, $next_report_date_to, 3 );
				}
			} else if ( 'twice_a_year' == $schedule ) {
				$next_report_date_to = self::calc_next_schedule_send_date( $start_recurring_date, $scheduleLastSend, 6 );
				while ( $next_report_date_to < $start_today ) {
					$next_report_date_to = self::calc_next_schedule_send_date( $start_recurring_date, $next_report_date_to, 6 );
				}
			} else if ( '' == $schedule ) {
				$next_report_date_to = self::calc_next_schedule_send_date( $start_recurring_date, $scheduleLastSend, 12 );
				while ( $next_report_date_to < $start_today ) {
					$next_report_date_to = self::calc_next_schedule_send_date( $start_recurring_date, $next_report_date_to, 12 );
				}
			}
		}
		return $next_report_date_to;
	}

	public static function calc_next_schedule_send_date( $recurring_date, $lastSend, $monthSteps ) {
		$day_to_send = date( 'd', $recurring_date );
		$month_last_send = date( 'm', $lastSend );
		$year_last_send = date( 'Y', $lastSend );

		$day_in_month = date( 't' );
		if ( $day_to_send > $day_in_month ) {
			$day_to_send = $day_in_month;
		}

		$month_to_send = $month_last_send + $monthSteps;
		$year_to_send = $year_last_send;
		if ( $month_to_send > 12 ) {
			$month_to_send = $month_to_send - 12;
			$year_to_send = $year_last_send + 1;
		}
		return strtotime( $year_to_send . '-' . $month_to_send . '-' . $day_to_send . ' 23:59:59' );
	}

	public function shortcuts_widget( $website ) {
		if ( ! empty( $website ) ) {
			$reports = MainWP_CReport_DB::get_instance()->get_report_by( 'site', $website->id );
			$reports_lnk = '';
			if ( is_array( $reports ) && count( $reports ) > 0 ) {
				$reports_lnk = '<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&site=' . $website->id . '">' . __( 'Reports', 'mainwp' ) . '</a> | ';
			}
			?>
			<div class="mainwp-row">
				<div style="display: inline-block; width: 100px;"><?php _e( 'Client Reports:', 'mainwp' ); ?></div>
				<?php echo $reports_lnk; ?>
				<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=newreport&selected_site=<?php echo $website->id; ?>"><?php _e( 'New Report', 'mainwp' ); ?></a>
			</div>
			<?php
		}
	}

	public function managesites_column_url( $actions, $site_id ) {
		if ( ! empty( $site_id ) ) {
			$reports = MainWP_CReport_DB::get_instance()->get_report_by( 'site', $site_id );
			$link = '';
			if ( is_array( $reports ) && count( $reports ) > 0 ) {
				$link = '<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&site=' . $site_id . '">' . __( 'Reports', 'mainwp' ) . '</a> ' .
						'( <a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=newreport&selected_site=' . $site_id . '">' . __( 'New', 'mainwp' ) . '</a> )';
			} else {
				$link = '<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=newreport&selected_site=' . $site_id . '">' . __( 'New Report', 'mainwp' ) . '</a>';
			}
			$actions['client_reports'] = $link;
		}
		return $actions;
	}

	public static function save_report() {
		if ( isset( $_REQUEST['action'] ) && 'editreport' == $_REQUEST['action'] && isset( $_REQUEST['nonce'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'mwp_creport_nonce' ) ) {
			$messages = $errors = array();
			$report = array();
			$current_attach_files = '';
			if ( isset( $_REQUEST['id'] ) && ! empty( $_REQUEST['id'] ) ) {
				$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $_REQUEST['id'], null, null, ARRAY_A );
				$current_attach_files = $report['attach_files'];
				//print_r($report);
			}

			if ( isset( $_POST['mwp_creport_title'] ) && ($title = trim( $_POST['mwp_creport_title'] )) != '' ) {
				$report['title'] = $title; }

			$start_time = $end_time = 0;
			if ( isset( $_POST['mwp_creport_date_from'] ) && ($start_date = trim( $_POST['mwp_creport_date_from'] )) != '' ) {
				$start_time = strtotime( $start_date );
			}

			if ( isset( $_POST['mwp_creport_date_to'] ) && ($end_date = trim( $_POST['mwp_creport_date_to'] )) != '' ) {
				$end_time = strtotime( $end_date );
			}

			if ( 0 == $end_time ) {
				$current = time();
				$end_time = mktime( 0, 0, 0, date( 'm', $current ), date( 'd', $current ), date( 'Y', $current ) );
			}

			if ( (0 != $start_time && 0 != $end_time) && ($start_time > $end_time) ) {
				$tmp = $start_time;
				$start_time = $end_time;
				$end_time = $tmp;
			}

			$report['date_from'] = $start_time;
			$report['date_to'] = $end_time + 24 * 3600 - 1;  // end of day

			if ( isset( $_POST['mwp_creport_client'] ) ) {
				$report['client'] = trim( $_POST['mwp_creport_client'] );
			}

			if ( isset( $_POST['mwp_creport_client_id'] ) ) {
				$report['client_id'] = intval( $_POST['mwp_creport_client_id'] );
			}

			if ( isset( $_POST['mwp_creport_fname'] ) ) {
				$report['fname'] = trim( $_POST['mwp_creport_fname'] );
			}

			if ( isset( $_POST['mwp_creport_fcompany'] ) ) {
				$report['fcompany'] = trim( $_POST['mwp_creport_fcompany'] );
			}

			$from_email = '';
			if ( ! empty( $_POST['mwp_creport_femail'] ) ) {
				$from_email = trim( $_POST['mwp_creport_femail'] );
				if ( ! preg_match( '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/is', $from_email ) ) {
					$from_email = '';
					$errors[] = 'Incorrect Email Address in the Send From filed.';
				}
			}
			$report['femail'] = $from_email;

			if ( isset( $_POST['mwp_creport_name'] ) ) {
				$report['name'] = trim( $_POST['mwp_creport_name'] );
			}

			if ( isset( $_POST['mwp_creport_company'] ) ) {
				$report['company'] = trim( $_POST['mwp_creport_company'] );
			}

			$to_email = '';
			$valid_emails = array();
			if ( ! empty( $_POST['mwp_creport_email'] ) ) {
				$to_emails = explode( ',', trim( $_POST['mwp_creport_email'] ) );
				if ( is_array( $to_emails ) ) {
					foreach ( $to_emails as $_email ) {
						if ( ! preg_match( '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/is', $_email ) && ! preg_match( '/^\[.+\]/is', $_email ) ) {
							$to_email = '';
							$errors[] = 'Incorrect Email Address in the Send To field.';
						} else {
							$valid_emails[] = $_email;
						}
					}
				}
			}

			if ( count( $valid_emails ) > 0 ) {
				$to_email = implode( ',', $valid_emails );
			} else {
				$to_email = '';
				$errors[] = 'Incorrect Email Address in the Send To field.';
			}

			$report['email'] = $to_email;

			if ( isset( $_POST['mwp_creport_email_subject'] ) ) {
				$report['subject'] = trim( $_POST['mwp_creport_email_subject'] );
			}

			//print_r($_POST);
			if ( isset( $_POST['mainwp_creport_recurring_schedule'] ) ) {
				$report['recurring_schedule'] = trim( $_POST['mainwp_creport_recurring_schedule'] );
			}
			if ( isset( $_POST['mainwp_creport_schedule_date'] ) ) {
				$rec_date = trim( $_POST['mainwp_creport_schedule_date'] );
				$report['recurring_date'] = ! empty( $rec_date ) ? strtotime( $rec_date . ' ' . date( 'H:i:s' ) ) : 0;
			}
			if ( isset( $_POST['mainwp_creport_schedule_send_email'] ) ) {
				$report['schedule_send_email'] = trim( $_POST['mainwp_creport_schedule_send_email'] );
			}
			if ( isset( $_POST['mainwp_creport_schedule_bbc_me_email'] ) ) {
				$report['schedule_bcc_me'] = isset( $_POST['mainwp_creport_schedule_bbc_me_email'] ) ? 1 : 0;
			}
			if ( isset( $_POST['mainwp_creport_report_header'] ) ) {
				$report['header'] = trim( $_POST['mainwp_creport_report_header'] );
			}

			if ( isset( $_POST['mainwp_creport_report_body'] ) ) {
				$report['body'] = trim( $_POST['mainwp_creport_report_body'] );
			}

			if ( isset( $_POST['mainwp_creport_report_footer'] ) ) {
				$report['footer'] = trim( $_POST['mainwp_creport_report_footer'] );
			}

			$creport_dir = apply_filters( 'mainwp_getspecificdir', 'client_report/' );
			if ( ! file_exists( $creport_dir ) ) {
				@mkdir( $creport_dir, 0777, true );
			}
			if ( ! file_exists( $creport_dir . '/index.php' ) ) {
				@touch( $creport_dir . '/index.php' );
			}

			$attach_files = 'NOTCHANGE';
			$delete_files = false;
			if ( isset( $_POST['mainwp_creport_delete_attach_files'] ) && '1' == $_POST['mainwp_creport_delete_attach_files'] ) {
				$attach_files = '';
				if ( ! empty( $current_attach_files ) ) {
					self::delete_attach_files( $current_attach_files, $creport_dir ); }
			}

			$return = array();
			if ( isset( $_FILES['mainwp_creport_attach_files'] ) && ! empty( $_FILES['mainwp_creport_attach_files']['name'][0] ) ) {
				if ( ! empty( $current_attach_files ) ) {
					self::delete_attach_files( $current_attach_files, $creport_dir ); }
				$output = self::handle_upload_files( $_FILES['mainwp_creport_attach_files'], $creport_dir );
				//print_r($output);
				if ( isset( $output['error'] ) ) {
					$return['error'] = $output['error']; }
				if ( is_array( $output ) && isset( $output['filenames'] ) && ! empty( $output['filenames'] ) ) {
					$attach_files = implode( ', ', $output['filenames'] ); }
			}

			if ( 'NOTCHANGE' !== $attach_files ) {
				$report['attach_files'] = $attach_files; }

			$selected_site = 0;
			$selected_sites = $selected_groups = array();
			if ( isset( $_POST['mwp_creport_report_type'] ) && 'global' == $_POST['mwp_creport_report_type'] ) {
				if ( isset( $_POST['select_by'] ) ) {
					if ( isset( $_POST['selected_sites'] ) && is_array( $_POST['selected_sites'] ) ) {
						foreach ( $_POST['selected_sites'] as $selected ) {
							$selected_sites[] = intval( $selected );
						}
					}

					if ( isset( $_POST['selected_groups'] ) && is_array( $_POST['selected_groups'] ) ) {
						foreach ( $_POST['selected_groups'] as $selected ) {
							$selected_groups[] = intval( $selected );
						}
					}
				}
				$report['type'] = 1;
			} else {
				$report['type'] = 0;
				if ( isset( $_POST['select_by'] ) ) {
					if ( isset( $_POST['selected_site'] ) ) {
						$selected_site = intval( $_POST['selected_site'] );
					}
				}
			}
			$report['sites'] = base64_encode( serialize( $selected_sites ) );
			$report['groups'] = base64_encode( serialize( $selected_groups ) );
			$report['selected_site'] = $selected_site;

			if ( 'schedule' === $_POST['mwp_creport_report_submit_action'] ) {
				$report['scheduled'] = 1;
			}
			$report['schedule_nextsend'] = self::cal_schedule_nextsend( $report['recurring_schedule'], $report['recurring_date'] );

			if ( 'save' === $_POST['mwp_creport_report_submit_action'] ||
					'send' === $_POST['mwp_creport_report_submit_action'] ||
					'save_pdf' === $_POST['mwp_creport_report_submit_action'] ||
					'schedule' === $_POST['mwp_creport_report_submit_action'] ||
					'archive_report' === $_POST['mwp_creport_report_submit_action'] ) {
				//print_r($report);
				if ( $result = MainWP_CReport_DB::get_instance()->update_report( $report ) ) {
					$return['id'] = $result->id;
					$messages[] = 'Report has been saved.';
				} else {
					$messages[] = 'Report has not been changed - Report Saved.';
				}
				$return['saved'] = true;
			} else if ( 'preview' === (string) $_POST['mwp_creport_report_submit_action'] ||
					'send_test_email' === (string) $_POST['mwp_creport_report_submit_action']
			) {
				$submit_report = json_decode( json_encode( $report ) );
				$return['submit_report'] = $submit_report;
			}

			if ( ! isset( $return['id'] ) && isset( $report['id'] ) ) {
				$return['id'] = $report['id'];
			}

			if ( count( $errors ) > 0 ) {
				$return['error'] = $errors; }

			if ( count( $messages ) > 0 ) {
				$return['message'] = $messages; }

			return $return;
		}
		return null;
	}

	static function delete_attach_files( $files, $dir ) {
		$files = explode( ',', $files );
		if ( is_array( $files ) ) {
			foreach ( $files as $file ) {
				$file = trim( $file );
				$file_path = $dir . $file;
				if ( file_exists( $file_path ) ) {
					@unlink( $file_path );
				}
			}
		}
	}

	public static function handle_upload_files( $file_input, $dest_dir ) {
		$output = array();
		$attachFiles = array();
		$allowed_files = array( 'jpeg', 'jpg', 'gif', 'png', 'rar', 'zip' );

		$tmp_files = $file_input['tmp_name'];
		if ( is_array( $tmp_files ) ) {
			foreach ( $tmp_files as $i => $tmp_file ) {
				if ( (UPLOAD_ERR_OK == $file_input['error'][ $i ]) && is_uploaded_file( $tmp_file ) ) {
					$file_size = $file_input['size'][ $i ];
					// = $file_input['type'][$i];
					$file_name = $file_input['name'][ $i ];

					if ( ($file_size > 5 * 1024 * 1024) ) {
						$output['error'][] = $file_name . ' - ' . __( 'File size too big' );
					} else if ( ! in_array( end( explode( '.', $file_name ) ), $allowed_files ) ) {
						$output['error'][] = $file_name . ' - ' . __( 'File type are not allowed' );
					} else {
						$dest_file = $dest_dir . $file_name;
						$dest_file = dirname( $dest_file ) . '/' . wp_unique_filename( dirname( $dest_file ), basename( $dest_file ) );
						if ( move_uploaded_file( $tmp_file, $dest_file ) ) {
							$attachFiles[] = basename( $dest_file );
						} else {
							$output['error'][] = $file_name . ' - ' . __( 'Can not copy file' ); }
						;
					}
				}
			}
		}
		$output['filenames'] = $attachFiles;
		return $output;
	}

	public static function send_report_mail( $report, $email = '', $subject = '', $bcc = '', $combine_report = false ) {
		if ( ! is_object( $report ) ) {
			return false; }

		$email = empty( $email ) ? $report->email : $email;
		if ( empty( $email ) ) {
			return; }

		$email_subject = '';
		if ( ! empty( $subject ) ) {
			$email_subject = $subject; }

		$email_subject = isset( $report->subject ) && ! empty( $report->subject ) ? $email_subject . ' - ' . $report->subject : $email_subject . ' - ' . 'Website Report';
		$email_subject = ltrim( $email_subject, ' - ' );

		global $mainWPCReportExtensionActivator;
		$email_has_token = $subject_has_token = false;
		$send_to_emails = $sites_token = array();

		if ( preg_match( '/^\[.+\]/is', $email ) ) {
			$email_has_token = true;
		}

		if ( preg_match( '/\[.+\]/is', $email_subject ) ) {
			$subject_has_token = true;
		}

		if ( $email_has_token || $subject_has_token ) {
			$sites = $groups = array();
			if ( $report->type == 1 ) {// global report
				$sites = unserialize( base64_decode( $report->sites ) );
				$groups = unserialize( base64_decode( $report->groups ) );
			} else {
				$sites = array( $report->selected_site );
			}
			if ( ! is_array( $sites ) ) {
				$sites = array(); }
			if ( ! is_array( $groups ) ) {
				$groups = array(); }
			$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $sites, $groups );
			foreach ( $dbwebsites as $dbsite ) {
				if ( $email_has_token ) {
					$token = MainWP_CReport_DB::get_instance()->get_tokens_by( 'token_name', $email, $dbsite->url );
					if ( $token ) {
						$send_to_emails[ $dbsite->id ] = $token->site_token->token_value;
					}
				}
				if ( $subject_has_token ) {
					$sites_token[ $dbsite->id ] = MainWP_CReport_DB::get_instance()->get_site_tokens( $dbsite->url, 'token_name' ); }
			}
		}

		$from = '';
		if ( ! empty( $report->fname ) ) {
			$from = 'From: ' . $report->fname;
			if ( ! empty( $report->fcompany ) ) {
				$from .= ' ' . $report->fcompany; }
			if ( ! empty( $report->femail ) ) {
				$from .= ' <' . $report->femail . '>'; }
		} else if ( ! empty( $report->femail ) ) {
			$from = 'From: ';
			if ( ! empty( $report->fcompany ) ) {
				$from .= $report->fcompany . ' '; }
			$from .= $report->femail;
		}

		if ( empty( $from ) ) {
			$from = 'From: Noname'; }

		$header = array( $from, 'content-type: text/html' );

		if ( ! empty( $bcc ) ) {
			$header[] = 'Bcc: ' . $bcc;
		}

		$files = $report->attach_files;
		$attachments = array();
		if ( ! empty( $files ) ) {
			$creport_dir = apply_filters( 'mainwp_getspecificdir', 'client_report/' );
			$files = explode( ',', $files );
			foreach ( $files as $file ) {
				$file = trim( $file );
				$attachments[] = $creport_dir . $file;
			}
		}
		$success = 0;
		$content = self::gen_email_content( $report, $combine_report );
		if ( is_array( $content ) ) {
			if ( $combine_report || empty( $report->type ) ) {
				$send_content = current( $content );
				$to_email = $email;

				if ( empty( $report->type ) && $email_has_token ) {
					$to_email = isset( $send_to_emails[ $report->selected_site ] ) ? $send_to_emails[ $report->selected_site ] : '';
				}

				if ( ! empty( $send_content ) && ! empty( $to_email ) ) {
					$send_subject = $email_subject;
					if ( $subject_has_token && empty( $report->type ) ) {
						if ( isset( $sites_token[ $report->selected_site ] ) && is_array( $sites_token[ $report->selected_site ] ) ) {
							$search_token = $replace_value = array();
							foreach ( $sites_token[ $report->selected_site ] as $token_name => $token ) {
								$search_token[] = '[' . $token_name . ']';
								$replace_value[] = $token->token_value;
							}
							$send_subject = str_replace( $search_token, $replace_value, $send_subject );
						}
					}
					if ( ! empty( $to_email ) && wp_mail( $to_email, stripslashes( $send_subject ), $send_content, $header, $attachments ) ) {
						if ( ! empty( $report->id ) ) {
							$report->lastsend = time();
							$update_report = array( 'id' => $report->id, 'lastsend' => $report->lastsend );
							MainWP_CReport_DB::get_instance()->update_report( $update_report );
						}
						return true;
					}
				}
				return false;
			} else {
				if ( ! $email_has_token ) {
					$to_email = $email; }

				foreach ( $content as $site_id => $send_content ) {
					if ( $email_has_token ) {
						$to_email = isset( $send_to_emails[ $site_id ] ) ? $send_to_emails[ $site_id ] : '';
					}
					$send_subject = $email_subject;
					if ( $subject_has_token ) {
						if ( isset( $sites_token[ $site_id ] ) && is_array( $sites_token[ $site_id ] ) ) {
							$search_token = $replace_value = array();
							foreach ( $sites_token[ $site_id ] as $token_name => $token ) {
								$search_token[] = '[' . $token_name . ']';
								$replace_value[] = $token->token_value;
							}
							$send_subject = str_replace( $search_token, $replace_value, $send_subject );
						}
					}

					if ( ! empty( $send_content ) && ! empty( $to_email ) ) {
						if ( wp_mail( $to_email, stripslashes( $send_subject ), $send_content, $header, $attachments ) ) {
							if ( ! empty( $report->id ) ) {
								$report->lastsend = time();
								$update_report = array( 'id' => $report->id, 'lastsend' => $report->lastsend );
								MainWP_CReport_DB::get_instance()->update_report( $update_report );
							}
							$success++;
						}
					}
				}
			}
		}
		return $success;
	}

	public static function handle_upload_image( $file_input, $dest_dir, $max_height, $max_width = null ) {
		$output = array();
		$processed_file = '';
		if ( UPLOAD_ERR_OK == $file_input['error'] ) {
			$tmp_file = $file_input['tmp_name'];
			if ( is_uploaded_file( $tmp_file ) ) {
				$file_size = $file_input['size'];
				$file_type = $file_input['type'];
				$file_name = $file_input['name'];
				$file_extension = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );

				if ( ($file_size > 500 * 1025) ) {
					$output['error'][] = 'File size is too large.';
				} elseif (
						('image/jpeg' != $file_type) &&
						('image/jpg' != $file_type) &&
						('image/gif' != $file_type) &&
						('image/png' != $file_type)
				) {
					$output['error'][] = 'File Type is not allowed.';
				} elseif (
						('jpeg' != $file_extension) &&
						('jpg' != $file_extension) &&
						('gif' != $file_extension) &&
						('png' != $file_extension)
				) {
					$output['error'][] = 'File Extension is not allowed.';
				} else {
					$dest_file = $dest_dir . $file_name;
					$dest_file = dirname( $dest_file ) . '/' . wp_unique_filename( dirname( $dest_file ), basename( $dest_file ) );

					if ( move_uploaded_file( $tmp_file, $dest_file ) ) {
						if ( file_exists( $dest_file ) ) {
							list( $width, $height, $type, $attr ) = getimagesize( $dest_file ); }

						$resize = false;
						//                        if ($width > $max_width) {
						//                            $dst_width = $max_width;
						//                            if ($height > $max_height)
						//                                $dst_height = $max_height;
						//                            else
						//                                $dst_height = $height;
						//                            $resize = true;
						//                        } else
						if ( $height > $max_height ) {
							$dst_height = $max_height;
							$dst_width = $width * $max_height / $height;
							$resize = true;
						}

						if ( $resize ) {
							$src = $dest_file;
							$cropped_file = wp_crop_image( $src, 0, 0, $width, $height, $dst_width, $dst_height, false );
							if ( ! $cropped_file || is_wp_error( $cropped_file ) ) {
								$output['error'][] = __( 'Can not resize the image.' );
							} else {
								@unlink( $dest_file );
								$processed_file = basename( $cropped_file );
							}
						} else {
							$processed_file = basename( $dest_file ); }

						$output['filename'] = $processed_file;
					} else {
						$output['error'][] = 'Can not copy the file.'; }
				}
			}
		}
		return $output;
	}

	public static function render() {
		self::client_reports_qsg();
		self::render_tabs();
	}

	public static function render_tabs() {
		global $current_user;
		$messages = $errors = $reporttab_messages = array();
		$do_preview = $do_send = $do_schedule = $do_send_test_email = $do_save_pdf = $do_replicate = $do_archive = false;
		$do_save_pdf_get = $do_un_archive = $do_archive_get = $do_un_archive_get = false;
		$report_id = 0;
		$report = false;

		//        $sched = wp_next_scheduled('mainwp_creport_cron_archive_reports');
		//        $d1 = date("Y-m-d H:i:m") . " " . date("Y-m-d H:i:m", $sched) ;
		//        echo $d1;

		if ( isset( $_GET['action'] ) ) {
			if ( 'sendreport' === (string) $_GET['action'] ) {
				$do_send = true; } else if ( 'preview' === (string) $_GET['action'] ) {
				$do_preview = true; } else if ( 'replicate' === (string) $_REQUEST['action'] ) {
					$do_replicate = true; } else if ( 'save_pdf' === (string) $_REQUEST['action'] ) {
					$do_save_pdf_get = true; } else if ( 'archive_report' === (string) $_REQUEST['action'] ) {
						$do_archive_get = true; } else if ( 'unarchive_report' === $_GET['action'] ) {
						$do_un_archive_get = true; }
		}

		if ( isset( $_POST['mwp_creport_report_submit_action'] ) ) {
			if ( 'send' === (string) $_POST['mwp_creport_report_submit_action'] ) {
				$do_send = true; } else if ( 'send_test_email' === (string) $_POST['mwp_creport_report_submit_action'] ) {
				$do_send_test_email = true; } else if ( 'save_pdf' === (string) $_POST['mwp_creport_report_submit_action'] ) {
					$do_save_pdf = true; } else if ( 'preview' === (string) $_POST['mwp_creport_report_submit_action'] ) {
					$do_preview = true; } else if ( 'archive_report' === (string) $_POST['mwp_creport_report_submit_action'] ) {
						$do_archive = true; } else if ( 'schedule' == $_POST['mwp_creport_report_submit_action'] ) {
						$do_schedule = true; }
		}

		if ( isset( $_POST['mwp_creport_do_un_archive'] ) && ! empty( $_POST['mwp_creport_do_un_archive'] ) ) {
			$do_un_archive = true;
		}

		if ( isset( $_REQUEST['id'] ) ) {
			$report_id = $_REQUEST['id'];
		}

		if ( $do_un_archive || $do_un_archive_get ) {
			if ( self::un_archive_report( $report_id ) ) {
				if ( $do_un_archive_get ) {
					$reporttab_messages[] = __( 'Report has been un-archived.' );
				} else {
					$messages[] = __( 'Report has been un-archived.' );
				}
			} else {
				$errors[] = __( 'Un-Archive Report has been failed.' ); }
		}

		$current_is_archived = false;
		if ( $report_id ) {
			$current_report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );
			$current_is_archived = ! empty( $current_report ) && $current_report->is_archived ? true : false;
			unset( $current_report );
		}

		$save_successful = $save_without_error = false;
		$result_save = array();

		if ( ! $current_is_archived && isset( $_POST['mwp_creport_report_submit_action'] ) && ! empty( $_POST['mwp_creport_report_submit_action'] ) ) {
			$result_save = self::save_report();
			$report_id = isset( $result_save['id'] ) && $result_save['id'] ? $result_save['id'] : 0;

			if ( isset( $result_save['submit_report'] ) && is_object( $result_save['submit_report'] ) ) {
				$report = $result_save['submit_report'];
			}

			if ( isset( $result_save['message'] ) ) {
				$messages = $result_save['message']; }

			if ( isset( $result_save['error'] ) ) {
				$errors = $result_save['error']; } else {
				$save_without_error = true; }

				if ( isset( $result_save['saved'] ) && (true == $result_save['saved']) ) {
					$save_successful = true;
				}
		}

		if ( $report_id && ($do_save_pdf || $do_save_pdf_get) ) {
			$report_pdf = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );
			$content = MainWP_CReport::gen_email_content_pdf( $report_pdf, true );
			MainWP_CReport_Utility::update_option( 'mwp_creport_pdf_content_' . $report_id, serialize( $content ) );
			unset( $report_pdf );
			?>
            <script>
                jQuery(document).ready(function ($) {
                    window.open(
			                '<?php echo get_site_url(); ?>/wp-admin/admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=savepdf&id=<?php echo esc_attr( $report_id ); ?>',
                                            '_blank'
                                            );
                                });
            </script>
			<?php
			$messages[] = __( 'PDF downloading...' );
		} else if ( ($do_archive && $save_without_error) || $do_archive_get ) {
			if ( self::archive_report( $report_id ) ) {
				if ( $do_archive_get ) {
					$reporttab_messages[] = __( 'Report has been archived.' );
				} else {
					$messages[] = __( 'Report has been archived.' );
				}
			} else {
				$errors[] = __( 'Archive Report has been failed.' ); }
		}

		if ( $report_id ) {
			if ( ! $do_archive_get && ! $do_un_archive_get && (null == $report) ) {
				$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );
				//print_r($report);
			}
		}

		if ( $do_replicate ) {
			$report->id = $report_id = 0;
			$report->title = '';
			$report->is_archived = 0;
			$report->attach_files = '';
		}

		$selected_site = 0;
		$style_tab_report = $style_tab_edit = $style_tab_token = $style_tab_stream = ' style="display: none" ';
		$do_create_new = $do_create_new_global = false;
		if ( isset( $_REQUEST['action'] ) ) {
			if ( 'token' == $_REQUEST['action'] ) {
				$style_tab_token = '';
			} else if ( 'editreport' == $_REQUEST['action'] || $do_save_pdf_get || $do_replicate || $do_preview || 'savepdf' == $_REQUEST['action'] ) {
				$style_tab_edit = '';
			} else if ( 'newreport' == $_REQUEST['action'] ) {
				if ( isset( $_GET['selected_site'] ) && ! empty( $_GET['selected_site'] ) ) {
					$selected_site = $_GET['selected_site']; }
				if ( isset( $_GET['type'] ) && 'global' == $_GET['type'] ) {
					$do_create_new_global = true; } else {
					$do_create_new = true; }
					$style_tab_edit = '';
			} else if ( $do_send || $do_archive_get || $do_un_archive_get ) {
				$style_tab_report = '';
			}
		} else if ( isset( $_POST['mainwp_creport_stream_groups_select'] ) || isset( $_GET['s'] ) || isset( $_GET['stream_orderby'] ) ) {
			$style_tab_stream = '';
		} else if ( $do_schedule ) {
			$style_tab_edit = '';
		} else {
			$style_tab_report = ''; }

		if ( $do_preview || $do_send || $do_send_test_email ) {
			if ( empty( $report ) || ! is_object( $report ) ) {
				$errors[] = __( 'Error report data' );
				$do_preview = $do_send = false;
			} else if ( empty( $report->type ) && empty( $report->selected_site ) ) {
				$errors[] = __( 'Please select a website' );
				$do_preview = $do_send = false;
			} else if ( $report->type ) {
				$sel_sites = unserialize( base64_decode( $report->sites ) );
				$sel_groups = unserialize( base64_decode( $report->groups ) );
				if ( ( ! is_array( $sel_sites ) || count( $sel_sites ) == 0) && ( ! is_array( $sel_groups ) || count( $sel_groups ) == 0) ) {
					$errors[] = __( 'Please select a website or group' );
					$do_preview = $do_send = false;
				}
			}

			if ( $do_send && empty( $report->email ) ) {
				$errors[] = __( 'Send To Email Address field can not be empty' );
				$do_send = false;
			}
		}

		if ( ! empty( $report ) && is_object( $report ) ) {
			if ( $do_send ) {
				if ( self::send_report_mail( $report ) ) {
					$messages[] = __( 'Report has been sent successfully.' );
				} else {
					$errors[] = __( 'Sending Report failed.' );
				}
				if ( isset( $_GET['action'] ) && 'sendreport' === (string) $_GET['action'] ) {
					unset( $report );
				}
			} else if ( $do_send_test_email ) {
				$email = @apply_filters( 'mainwp_getnotificationemail' );
				if ( ! empty( $email ) ) {
					if ( self::send_report_mail( $report, $email, 'Send Test Email' ) ) {
						$messages[] = __( 'Test Email has been sent successfully.' );
					} else {
						$errors[] = __( 'Sending Test Email failed.' ); }
				} else {
					$errors[] = __( 'Notification email is empty. Test Email can not be sent.' );
				}
			}
		}

		$str_error = (count( $errors ) > 0) ? implode( '<br/>', $errors ) : '';
		$str_message = (count( $messages ) > 0) ? implode( '<br/>', $messages ) : '';

		if ( ! empty( $report ) ) {
			$selected_site = $report->selected_site;
		} else {
			if ( isset( $_POST['select_by'] ) ) {
				if ( isset( $_POST['selected_site'] ) ) {
					$selected_site = intval( $_POST['selected_site'] );
				}
			}
		}

		$clients = MainWP_CReport_DB::get_instance()->get_clients();
		if ( ! is_array( $clients ) ) {
			$clients = array(); }

		global $mainWPCReportExtensionActivator;

		$websites = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), null );
		$sites_id = array();
		if ( is_array( $websites ) ) {
			foreach ( $websites as $website ) {
				$sites_id[] = $website['id'];
			}
		}
		$option = array(
		'plugin_upgrades' => true,
			'plugins' => true,
		);
		$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $sites_id, array(), $option );
		$all_stream_sites = $sites_with_streams = array();
		foreach ( $dbwebsites as $website ) {
			if ( $website && $website->plugins != '' ) {
				$plugins = json_decode( $website->plugins, 1 );
				if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
					foreach ( $plugins as $plugin ) {
						if ( 'stream/stream.php' == $plugin['slug'] ) {
							if ( $plugin['active'] ) {
								$all_stream_sites[] = MainWP_CReport_Utility::map_site( $website, array( 'id', 'name' ) );
								$sites_with_streams[] = $website->id;
								break;
							}
						} else if ( 'mainwp-child-reports/mainwp-child-reports.php' == $plugin['slug'] ) {
							if ( $plugin['active'] ) {
								$all_stream_sites[] = MainWP_CReport_Utility::map_site( $website, array( 'id', 'name' ) );
								$sites_with_streams[] = $website->id;
								break;
							}
						}
					}
				}
			}
		}

		$selected_group = 0;

		if ( isset( $_POST['mainwp_creport_stream_groups_select'] ) ) {
			$selected_group = intval( $_POST['mainwp_creport_stream_groups_select'] );
		}
		$dbwebsites_stream = MainWP_CReport_Stream::get_instance()->get_websites_stream( $dbwebsites, $selected_group );

		//print_r($dbwebsites_stream);
		unset( $dbwebsites );
		$report_type = '';
		$edit_tab_lnk = ( ! empty( $report ) && empty( $report->type )) ? '<a id="wpcr_edit_tab_lnk" href="#" report-id="' . ( ! empty( $report ) && isset( $report->id ) ? $report->id : 0) . '"class="mainwp_action mid mainwp_action_down">' . __( 'Edit Report' ) . '</a>' : '';
		if ( $do_create_new ) {
			$new_tab_lnk = '<a id="wpcr_edit_tab_lnk" href="#" report-id="0" class="mainwp_action mid mainwp_action_down">' . __( 'New Report' ) . '</a>';
		} else if ( empty( $report ) && ! $do_create_new_global ) {
			$new_tab_lnk = '<a id="wpcr_edit_tab_lnk" href="#" report-id="0" class="mainwp_action mid">' . __( 'New Report' ) . '</a>';
		} else { // button is new report button
			$new_tab_lnk = '<a id="wpcr_new_tab_lnk" href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=newreport" class="mainwp_action mid">' . __( 'New Report' ) . '</a>'; }

		$edit_global_tab_lnk = '';
		if ( ! empty( $report ) && $report->type ) {
			$edit_global_tab_lnk = '<a id="wpcr_edit_global_tab_lnk" href="#" report-id="' . $report->id . '"class="mainwp_action mid mainwp_action_down">' . __( 'Edit Global Report' ) . '</a>';
			$report_type = 'global';
		}

		if ( $do_create_new_global ) {
			$report_type = 'global';
			$new_global_tab_lnk = '<a id="wpcr_edit_global_tab_lnk" href="#" report-id="0" class="mainwp_action mid mainwp_action_down">' . __( 'New Global Report' ) . '</a>';
		} else {
			$new_global_tab_lnk = '<a id="wpcr_new_global_tab_lnk" href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=newreport&type=global" class="mainwp_action mid">' . __( 'New Global Report' ) . '</a>'; }

		$url_loader = plugins_url( 'images/loader.gif', dirname( __FILE__ ) );
		?>
        <div class="wrap" id="mainwp-ap-option">
            <div class="clearfix"></div>           
            <div class="inside">                 
				<div  class="mainwp_error error" id="mwp-creport-error-box" <?php echo ! empty( $str_error ) ? 'style="display:block;"' : ''; ?>><?php echo ! empty( $str_error ) ? '<p>' . $str_error . '</p>' : ''; ?></div>
				<div  class="mainwp_info-box-yellow" id="mwp-creport-info-box"  <?php echo (empty( $str_message ) ? ' style="display: none" ' : ''); ?>><?php echo $str_message ?></div>
                <div id="mainwp_wpcr_option">
                    <div class="mainwp_error error" id="wpcr_error_box"></div>
                    <div class="clear">
                        <br />
						<a id="wpcr_report_tab_lnk" href="#" class="mainwp_action left <?php echo (empty( $style_tab_report ) ? 'mainwp_action_down' : ''); ?>"><?php _e( 'Client Reports' ); ?></a><?php echo $edit_tab_lnk; ?><?php echo $new_tab_lnk; ?><?php echo $edit_global_tab_lnk; ?><?php echo $new_global_tab_lnk; ?><a id="wpcr_token_tab_lnk" href="#" class="mainwp_action mid <?php echo (empty( $style_tab_token ) ? 'mainwp_action_down' : ''); ?>"><?php _e( 'Report Tokens' ); ?></a><a id="wpcr_stream_tab_lnk" href="#" class="mainwp_action right <?php echo (empty( $style_tab_stream ) ? 'mainwp_action_down' : ''); ?>"><?php _e( 'Stream Dashboard' ); ?></a>
                        <br /><br />                              
						<div id="wpcr_report_tab" <?php echo $style_tab_report; ?>>
							<?php
							if ( count( $reporttab_messages ) > 0 ) {
								echo '<div  class="mainwp_info-box-yellow">' . implode( '<br/>', $reporttab_messages ) . '</div>';
							}
							?>
                            <div class="tablenav top">
                                <select name="mainwp_creport_select_site" id="mainwp_creport_select_site">
									<option value="0"><?php _e( 'Select a Site' ); ?></option>
									<?php
									foreach ( $all_stream_sites as $site ) {
										$_select = '';
										if ( isset( $_GET['site'] ) && intval( $_GET['site'] ) == $site['id'] ) {
											$_select = 'selected';
										}
										?>
										<option value="<?php echo $site['id']; ?>" <?php echo $_select; ?>><?php echo esc_html( stripslashes( $site['name'] ) ); ?></option>
										<?php
									}
									?>
                                </select>
								<input type="button" id="mainwp_creport_select_site_btn_display" class="button" value="<?php _e( 'Display' ); ?>" />
                                <select name="mainwp_creport_select_client" id="mainwp_creport_select_client">
									<option value="0"><?php _e( 'Select a Client' ); ?></option>
									<?php
									foreach ( $clients as $client ) {
										$_select = '';
										if ( isset( $_GET['client'] ) && $client->clientid == intval( $_GET['client'] ) ) {
											$_select = 'selected';
										}
										?>
										<option value="<?php echo $client->clientid; ?>" <?php echo $_select; ?>><?php echo esc_html( stripslashes( $client->client ) ); ?></option>
										<?php
									}
									?>
                                </select>
								<input type="button" id="mainwp_creport_select_client_btn_display" class="button" value="<?php _e( 'Display' ); ?>" />
								&nbsp;&nbsp;<a href="#" id="mainwp_cr_remove_client"><?php _e( 'Remove Client', 'mainwp' ); ?></a>
								&nbsp;<span class="wpcr_report_tab_nav_action_working"><img src="<?php echo $url_loader; ?>" class="hidden"><span class="status hidden"></span></span>
                            </div>                            
							<?php self::report_tab( $websites ); ?>                                                                                  
                        </div>                       
						<form method="post" enctype="multipart/form-data" id="mwp_creport_edit_form" action="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=editreport<?php echo ! empty( $report_id ) ? '&id=' . $report_id : ''; ?>">
							<div id="creport_select_sites_box" class="mainwp_config_box_right" <?php echo $style_tab_edit; ?>>
								<?php
								if ( $do_create_new_global || ( ! empty( $report ) && $report->type) ) {
									$sel_sites = $sel_groups = array();
									if ( ! empty( $report ) ) {
										$sel_sites = unserialize( base64_decode( $report->sites ) );
										$sel_groups = unserialize( base64_decode( $report->groups ) );
									}
									if ( ! is_array( $sel_sites ) ) {
										$sel_sites = array(); }
									if ( ! is_array( $sel_groups ) ) {
										$sel_groups = array(); }
									?>                                
									<?php do_action( 'mainwp_select_sites_box', __( 'Select Site', 'mainwp' ), 'checkbox', true, true, 'mainwp_select_sites_box_right', '', $sel_sites, $sel_groups ); ?>
								<?php } else { ?>
									<?php do_action( 'mainwp_select_sites_box', __( 'Select Site', 'mainwp' ), 'radio', false, false, 'mainwp_select_sites_box_right', '', array( $selected_site ), array() ); ?>                                
                                    <div class="mainwp_info-box-yellow"><strong style="font-style:initial">Note</strong>: <span class="description">Only sites with the Stream Plugin installed will be displayed in the list.</span></div>                                
								<?php } ?>

                            </div>                            
							<div id="wpcr_edit_tab"  <?php echo $style_tab_edit; ?>> 
								<?php
								self::new_report_tab( $report );
								$_archive_btn = '<input type="submit" value="' . __( 'Archive Report', 'mainwp' ) . '" class="button" id="mwp-creport-archive-report-btn" name="button_archive">';
								$_disabled = '';
								if ( ! empty( $report ) && isset( $report->id ) && isset( $report->is_archived ) && $report->is_archived ) {
									$_archive_btn = '<input type="submit" value="' . __( 'Un-Archive Report', 'mainwp' ) . '" class="button" id="mwp-creport-unarchive-report-btn" name="button_unarchive">';
									$_disabled = 'disabled="disabled"';
								}
								?>  
                                <p class="submit">                                    
                                    <span style="float:left;">
										<input type="submit" value="<?php _e( 'Preview Report' ); ?>" class="button-primary" id="mwp-creport-preview-btn" name="button_preview">                                        
										<input type="submit" value="<?php _e( 'Send Test Email' ); ?>" class="button" id="mwp-creport-send-test-email-btn" name="button_send_test_email">                                        
                                    </span>
                                    <span style="float:right;"> 
										<?php echo $_archive_btn; ?>                                        
										<input type="submit" value="<?php _e( 'Download PDF' ); ?>" class="button" id="mwp-creport-save-pdf-btn" name="button_save_pdf">
										<input type="submit" <?php echo $_disabled; ?> value="<?php _e( 'Save Report' ); ?>" class="button" id="mwp-creport-save-btn" name="button_save">
										<input type="submit" value="<?php _e( 'Send Now' ); ?>" class="button-primary" id="mwp-creport-send-btn" name="submit">
                                    </span>
                                </p>
                            </div>  
							<input type="hidden" name="mwp_creport_report_type" id="mwp_creport_report_type" value="<?php echo $report_type; ?>">
                            <input type="hidden" name="mwp_creport_report_submit_action" id="mwp_creport_report_submit_action" value="">
                            <input type="hidden" name="mwp_creport_do_un_archive" id="mwp_creport_do_un_archive" value="0">
							<input type="hidden" name="id" value="<?php echo (is_object( $report ) && isset( $report->id )) ? $report->id : '0'; ?>">
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'mwp_creport_nonce' ) ?>">
                        </form>
						<div id="wpcr_token_tab"  <?php echo $style_tab_token; ?>>
                            <div class="mainwp_info-box">Add or Change Client Information in the <a href="admin.php?page=managesites">Edit Site Screen</a></div>
                            <div id="creport_list_tokens" class="postbox"></div>                                                                       
                        </div> 
						<div id="wpcr_stream_tab" <?php echo $style_tab_stream; ?>>
							<div class="mainwp_info-box-yellow"><span><a href="#" id="mainwp-cr-dashboard-tips-dismiss" style="float: right; margin-left: 1em;"><?php _e( 'Dismiss', 'mainwp' ); ?></a></span><span class="clearfix"></span><?php _e( 'In the Stream settings page (you can find it in your child sites), it enables you to set the number of days to keep records. We strongly recommend to set it blank, this way you will be able to generate reports for unlimited period of time. By default it is set to 90 days.' ); ?></div>
                            <div class="tablenav top">
								<?php MainWP_CReport_Stream::gen_select_sites( $dbwebsites_stream, $selected_group ); ?>  
                            </div>                            
							<?php MainWP_CReport_Stream::gen_stream_dashboard_tab( $dbwebsites_stream ); ?>                            
                        </div>

                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>        
		<div id="mwp-creport-preview-box" title="<?php _e( 'Preview Report' ); ?>" style="display: none; text-align: center">
            <div style="height: auto; overflow: auto; margin-top: 20px; margin-bottom: 10px; text-align: left" id="mwp-creport-preview-content">
				<?php
				if ( $do_preview && is_object( $report ) ) {
					echo self::gen_preview_report( $report );
				}
				?>  
            </div>
			<input type="button" value="<?php _e( 'Close' ); ?>" class="button-primary" id="mwp-creport-preview-btn-close"/>
			<input type="button" value="<?php _e( 'Send Now' ); ?>" class="button-primary" id="mwp-creport-preview-btn-send"/>
        </div>

        <script>
            jQuery(document).ready(function ($) {
                mainwp_creport_load_tokens();
		        mainwp_creport_remove_sites_without_streams('<?php echo implode( ',', $sites_with_streams ) ?>');
		<?php if ( $do_preview ) { ?>
                    mainwp_creport_preview_report();
		<?php } ?>
		<?php if ( $do_create_new && $selected_site ) { ?>
			        $('#selected_sites_<?php echo $selected_site; ?>').trigger('click');
		<?php } ?>
            });
        </script>        
		<?php
	}

	public static function archive_report( $report ) {
		if ( ! empty( $report ) && ! is_object( $report ) ) {
			$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report );
		}

		if ( $report->is_archived ) {
			return false; }
		$archive_content = self::gen_email_content( $report, true ); // to save archive always save as array report
		$archive_content_pdf = self::gen_email_content_pdf( $report );
		$update_archive = array(
		'id' => $report->id,
			'is_archived' => 1,
			'archive_report' => serialize( $archive_content ),
			'archive_report_pdf' => serialize( $archive_content_pdf ),
		);
		if ( MainWP_CReport_DB::get_instance()->update_report( $update_archive ) ) {
			return true; }
		return false;
	}

	public function un_archive_report( $report ) {
		if ( ! empty( $report ) && ! is_object( $report ) ) {
			$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report );
		}

		if ( ! $report->is_archived ) {
			return true; }
		$update_archive = array(
		'id' => $report->id,
			'is_archived' => 0,
			'archive_report' => '',
			'archive_report_pdf' => '',
		);
		if ( MainWP_CReport_DB::get_instance()->update_report( $update_archive ) ) {
			return true; }
		return false;
	}

	public static function gen_preview_report( $report ) {
		if ( ! empty( $report ) ) {
			ob_start();
			if ( isset( $report->is_archived ) && $report->is_archived ) {
				if ( ! is_serialized( $report->archive_report ) ) {
					echo $report->archive_report; } else {
					$content = unserialize( $report->archive_report );
					if ( is_array( $content ) ) {
						foreach ( $content as $ct ) {
							echo $ct;
						}
					}
					}
			} else {
				$filtered_reports = self::filter_report( $report );
				?>
                <style>
                    #crp_content_wrap ul {list-style-type:square; margin-left: 20px;}
                    #crp_content_wrap ol {list-style-type:decimal}
                    #crp_content_wrap br {line-height: 10px; display: block;}   
                    #crp_content_wrap b, #crp_content_wrap strong {font-weight: 900;}
                </style>                    
                <div id="crp_content_wrap" style="font:13px/20px Helvetica,Arial,Sans-serif;">
					<?php
					$result = self::gen_report_content( $filtered_reports, true );
					if ( isset( $result[0] ) ) {
						echo $result[0]; }
					?>
                </div> 

				<?php
			}
		} else {
			?>
			<div class="mainwp_info-box-yellow"><?php _e( 'Report Error' ); ?></div>                    
			<?php
		}
		$output = ob_get_clean();
		return $output;
	}

	public static function gen_email_content( $report, $combine_report = false ) {
		if ( is_object( $report ) ) {
			if ( $report->is_archived ) {
				if ( ! is_serialized( $report->archive_report ) ) {
					return array( $report->archive_report );
				} else {
					$content = unserialize( $report->archive_report );
					if ( is_array( $content ) ) {
						if ( ! $combine_report ) {
							return $content; } else {
							$return = '';
							foreach ( $content as $ct ) {
								$return .= $ct;
							}
							return array( $return );
							}
					}
					return false;
				}
			} else {
				$filtered_reports = self::filter_report( $report );
				return self::gen_report_content( $filtered_reports, $combine_report );
			}
		}
		return false;
	}

	public static function gen_report_content( $reports, $combine_report = false ) {
		if ( ! is_array( $reports ) ) {
			$reports = array( $reports );
		}

		if ( $combine_report ) {
			ob_start(); }
		foreach ( $reports as $site_id => $report ) {
			if ( ! $combine_report ) {
				ob_start(); }

			if ( is_array( $report ) && isset( $report['error'] ) ) {
				?>        
                <br>
                <div>
                    <br>
                    <div style="background:#ffffff;padding:0 1.618em;padding-bottom:50px!important">
                        <div style="width:600px;background:#fff;margin-left:auto;margin-right:auto;margin-top:10px;margin-bottom:25px;padding:0!important;border:10px Solid #fff;border-radius:10px;overflow:hidden">
                            <div style="display: block; width: 100% ; ">
                                <div style="display: block; width: 100% ; padding: .5em 0 ;">       
									<?php echo $report['error']; ?>
                                </div>   
                            </div>                            
                        </div>
                    </div>  
                </div>  
				<?php
			} else if ( is_object( $report ) ) {
				?>        
                <br>
                <div>
                    <br>
                    <div style="background:#ffffff;padding:0 1.618em;padding-bottom:50px!important">
                        <div style="width:600px;background:#fff;margin-left:auto;margin-right:auto;margin-top:10px;margin-bottom:25px;padding:0!important;border:10px Solid #fff;border-radius:10px;overflow:hidden">
                            <div style="display: block; width: 100% ; ">
                                <div style="display: block; width: 100% ; padding: .5em 0 ;">                          
									<?php
									//echo apply_filters( 'the_content', $report->filtered_header );
									echo stripslashes( nl2br( $report->filtered_header ) );
									//echo self::do_filter_content($report->filtered_header);
									?>                          
                                    <div style="clear: both;"></div>
                                </div>
                            </div>
                            <br><br><br>
                            <div>
								<?php
								//echo apply_filters( 'the_content', $report->filtered_body );
								echo stripslashes( nl2br( $report->filtered_body ) );
								//echo self::do_filter_content($report->filtered_body);
								?>                        
                            </div>
                            <br><br><br>
                            <div style="display: block; width: 100% ;">
								<?php
								//echo apply_filters( 'the_content', $report->filtered_footer );
								echo stripslashes( nl2br( $report->filtered_footer ) );
								//echo self::do_filter_content($report->filtered_footer);
								?>
                            </div>                                

                        </div>                            
                    </div>
                </div>           
				<?php
			}

			if ( ! $combine_report ) {
				$html = ob_get_clean();
				$output[ $site_id ] = $html;
			}
		}
		if ( $combine_report ) {
			$html = ob_get_clean();
			$output[] = $html;
		}
		return $output;
	}

	static function do_filter_content( $content ) {
		//        if (preg_match("/(<ga_chart>(.+)<\/ga_chart>)/is", $content, $matches)) {
		//            $chart_content = $matches[2];
		//            $filtered_content = preg_replace("/(<ga_chart>.+<\/ga_chart>)/is",'[GA_CHART_MARKER]',$content);
		//            $filtered_content = stripslashes(nl2br($filtered_content));
		//            $filtered_content = preg_replace("/([GA_CHART_MARKER])/is",'$chart_content',$filtered_content);
		//            $content = $filtered_content;
		//        }
		return $content;
	}

	public static function gen_email_content_pdf( $report, $combine_report = false ) {
		// to fix bug from mainwp
		if ( ! function_exists( 'wp_verify_nonce' ) ) {
			include_once( ABSPATH . WPINC . '/pluggable.php' ); }

		if ( ! empty( $report ) && is_object( $report ) ) {
			if ( $report->is_archived ) {
				if ( ! is_serialized( $report->archive_report_pdf ) ) {
					return array( $report->archive_report_pdf ); } else {
					return unserialize( $report->archive_report_pdf ); }
			} else {
				$filtered_reports = self::filter_report( $report );
				return self::gen_report_content_pdf( $filtered_reports, $combine_report );
			}
		}
		return '';
	}

	public static function gen_report_content_pdf( $reports, $combine_report = false ) {
		if ( ! is_array( $reports ) ) {
			$reports = array( 0 => $reports );
		}
		$output = array();
		if ( $combine_report ) {
			ob_start(); }

		foreach ( $reports as $site_id => $report ) {
			if ( ! $combine_report ) {
				ob_start(); }

			if ( is_array( $report ) && isset( $report['error'] ) ) {
				echo $report['error'];
			} else if ( is_object( $report ) ) {
				echo stripslashes( nl2br( $report->filtered_header ) );
				echo '<br><br>';
				echo stripslashes( nl2br( $report->filtered_body ) );
				echo '<br><br>';
				echo stripslashes( nl2br( $report->filtered_footer ) );
				echo '<br><br>';
			}

			if ( ! $combine_report ) {
				$html = ob_get_clean();
				$output[ $site_id ] = $html;
			}
		}
		if ( $combine_report ) {
			$html = ob_get_clean();
			$output[] = $html;
		}
		return $output;
	}

	public static function filter_report( $report ) {
		global $mainWPCReportExtensionActivator;
		$websites = array();
		if ( empty( $report->type ) ) {
			if ( $report->selected_site ) {
				global $mainWPCReportExtensionActivator;
				$website = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $report->selected_site );
				if ( $website && is_array( $website ) ) {
					$websites[] = current( $website );
				}
			}
		} else {
			$sel_sites = unserialize( base64_decode( $report->sites ) );
			$sel_groups = unserialize( base64_decode( $report->groups ) );
			if ( ! is_array( $sel_sites ) ) {
				$sel_sites = array(); }
			if ( ! is_array( $sel_groups ) ) {
				$sel_groups = array(); }
			$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $sel_sites, $sel_groups );
			$websites = array();
			if ( is_array( $dbwebsites ) ) {
				foreach ( $dbwebsites as $site ) {
					$websites[] = MainWP_CReport_Utility::map_site( $site, array( 'id', 'name', 'url' ) );
				}
			}
		}

		if ( count( $websites ) == 0 ) {
			return $report; }

		$filtered_reports = array();
		foreach ( $websites as $site ) {
			$filtered_reports[ $site['id'] ] = self::filter_report_website( $report, $site );
		}
		return $filtered_reports;
	}

	public static function filter_report_website( $report, $website ) {
		$output = new stdClass();
		$output->filtered_header = $report->header;
		$output->filtered_body = $report->body;
		$output->filtered_footer = $report->footer;
		$output->id = isset( $report->id ) ? $report->id : 0;
		$get_ga_tokens = ((strpos( $report->header, '[ga.' ) !== false) || (strpos( $report->body, '[ga.' ) !== false) || (strpos( $report->footer, '[ga.' ) !== false)) ? true : false;
		$get_ga_chart = ((strpos( $report->header, '[ga.visits.chart]' ) !== false) || (strpos( $report->body, '[ga.visits.chart]' ) !== false) || (strpos( $report->footer, '[ga.visits.chart]' ) !== false)) ? true : false;
		$get_ga_chart = $get_ga_chart || (((strpos( $report->header, '[ga.visits.maximum]' ) !== false) || (strpos( $report->body, '[ga.visits.maximum]' ) !== false) || (strpos( $report->footer, '[ga.visits.maximum]' ) !== false)) ? true : false);

		$get_piwik_tokens = ((strpos( $report->header, '[piwik.' ) !== false) || (strpos( $report->body, '[piwik.' ) !== false) || (strpos( $report->footer, '[piwik.' ) !== false)) ? true : false;
		$get_aum_tokens = ((strpos( $report->header, '[aum.' ) !== false) || (strpos( $report->body, '[aum.' ) !== false) || (strpos( $report->footer, '[aum.' ) !== false)) ? true : false;
		$get_woocom_tokens = ((strpos( $report->header, '[wcomstatus.' ) !== false) || (strpos( $report->body, '[wcomstatus.' ) !== false) || (strpos( $report->footer, '[wcomstatus.' ) !== false)) ? true : false;
		if ( null !== $website ) {
			$tokens = MainWP_CReport_DB::get_instance()->get_tokens();
			$site_tokens = MainWP_CReport_DB::get_instance()->get_site_tokens( $website['url'] );
			$search_tokens = $replace_values = array();
			foreach ( $tokens as $token ) {
				$search_tokens[] = '[' . $token->token_name . ']';
				$replace_values[] = isset( $site_tokens[ $token->id ] ) ? $site_tokens[ $token->id ]->token_value : '';
			}

			if ( $get_piwik_tokens ) {
				$piwik_tokens = self::piwik_data( $website['id'], $report->date_from, $report->date_to );
				if ( is_array( $piwik_tokens ) ) {
					foreach ( $piwik_tokens as $token => $value ) {
						$search_tokens[] = '[' . $token . ']';
						$replace_values[] = $value;
					}
				}
			}

			if ( $get_ga_tokens ) {
				$ga_tokens = self::ga_data( $website['id'], $report->date_from, $report->date_to, $get_ga_chart );
				if ( is_array( $ga_tokens ) ) {
					foreach ( $ga_tokens as $token => $value ) {
						$search_tokens[] = '[' . $token . ']';
						$replace_values[] = $value;
					}
				}
			}

			if ( $get_aum_tokens ) {
				$aum_tokens = self::aum_data( $website['id'], $report->date_from, $report->date_to );
				if ( is_array( $aum_tokens ) ) {
					foreach ( $aum_tokens as $token => $value ) {
						$search_tokens[] = '[' . $token . ']';
						$replace_values[] = $value;
					}
				}
			}

			if ( $get_woocom_tokens ) {
				$wcomstatus_tokens = self::woocomstatus_data( $website['id'], $report->date_from, $report->date_to );
				if ( is_array( $wcomstatus_tokens ) ) {
					foreach ( $wcomstatus_tokens as $token => $value ) {
						$search_tokens[] = '[' . $token . ']';
						$replace_values[] = $value;
					}
				}
			}

			$search_tokens[] = '[report.daterange]';
			$replace_values[] = MainWP_CReport_Utility::format_timestamp( $report->date_from ) . ' - ' . MainWP_CReport_Utility::format_timestamp( $report->date_to );

			//$report->filtered_header = self::replace_content($report->header, $search_tokens, $replace_values);
			//$report->body = self::replace_content($report->body, $search_tokens, $replace_values);
			//$report->filtered_footer = self::replace_content($report->footer, $search_tokens, $replace_values);
			// use new variables
			$report_header = $report->header;
			$report_body = $report->body;
			$report_footer = $report->footer;

			$result = self::parse_report_content( $report_header, $search_tokens, $replace_values );
			//print_r($result);
			self::$buffer['sections']['header'] = $sections['header'] = $result['sections'];
			$other_tokens['header'] = $result['other_tokens'];
			$filtered_header = $result['filtered_content'];
			unset( $result );

			$result = self::parse_report_content( $report_body, $search_tokens, $replace_values );
			//print_r($result);
			self::$buffer['sections']['body'] = $sections['body'] = $result['sections'];
			$other_tokens['body'] = $result['other_tokens'];
			$filtered_body = $result['filtered_content'];
			unset( $result );

			$result = self::parse_report_content( $report_footer, $search_tokens, $replace_values );
			//print_r($result);

			self::$buffer['sections']['footer'] = $sections['footer'] = $result['sections'];
			$other_tokens['footer'] = $result['other_tokens'];
			$filtered_footer = $result['filtered_content'];
			unset( $result );
			//print_r($sections);
			// get data from stream plugin
			$sections_data = $other_tokens_data = array();
			$information = self::fetch_stream_data( $website, $report, $sections, $other_tokens );
			//print_r($information);
			if ( is_array( $information ) && ! isset( $information['error'] ) ) {
				self::$buffer['sections_data'] = $sections_data = isset( $information['sections_data'] ) ? $information['sections_data'] : array();
				$other_tokens_data = isset( $information['other_tokens_data'] ) ? $information['other_tokens_data'] : array();
			} else {
				self::$buffer = array();
				return $information;
			}
			unset( $information );

			self::$count_sec_header = self::$count_sec_body = self::$count_sec_footer = 0;
			if ( isset( $sections_data['header'] ) && is_array( $sections_data['header'] ) && count( $sections_data['header'] ) > 0 ) {
				$filtered_header = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', array( 'MainWP_CReport', 'section_mark_header' ), $filtered_header );
			}

			if ( isset( $sections_data['body'] ) && is_array( $sections_data['body'] ) && count( $sections_data['body'] ) > 0 ) {
				$filtered_body = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', array( 'MainWP_CReport', 'section_mark_body' ), $filtered_body );
			}

			if ( isset( $sections_data['footer'] ) && is_array( $sections_data['footer'] ) && count( $sections_data['footer'] ) > 0 ) {
				$filtered_footer = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', array( 'MainWP_CReport', 'section_mark_footer' ), $filtered_footer );
			}

			if ( isset( $other_tokens_data['header'] ) && is_array( $other_tokens_data['header'] ) && count( $other_tokens_data['header'] ) > 0 ) {
				$search = $replace = array();
				foreach ( $other_tokens_data['header'] as $token => $value ) {
					if ( in_array( $token, $other_tokens['header'] ) ) {
						$search[] = $token;
						$replace[] = $value;
					}
				}
				$filtered_header = self::replace_content( $filtered_header, $search, $replace );
			}

			if ( isset( $other_tokens_data['body'] ) && is_array( $other_tokens_data['body'] ) && count( $other_tokens_data['body'] ) > 0 ) {
				$search = $replace = array();
				foreach ( $other_tokens_data['body'] as $token => $value ) {
					if ( in_array( $token, $other_tokens['body'] ) ) {
						$search[] = $token;
						$replace[] = $value;
					}
				}
				$filtered_body = self::replace_content( $filtered_body, $search, $replace );
			}

			if ( isset( $other_tokens_data['footer'] ) && is_array( $other_tokens_data['footer'] ) && count( $other_tokens_data['footer'] ) > 0 ) {
				$search = $replace = array();
				foreach ( $other_tokens_data['footer'] as $token => $value ) {
					if ( in_array( $token, $other_tokens['footer'] ) ) {
						$search[] = $token;
						$replace[] = $value;
					}
				}
				$filtered_footer = self::replace_content( $filtered_footer, $search, $replace );
			}

			$output->filtered_header = $filtered_header;
			$output->filtered_body = $filtered_body;
			$output->filtered_footer = $filtered_footer;
			self::$buffer = array();
		}
		return $output;
	}

	public static function section_mark_header( $matches ) {
		$content = $matches[0];
		$sec = $matches[1];
		$index = self::$count_sec_header;
		$search = self::$buffer['sections']['header']['section_content_tokens'][ $index ];
		self::$count_sec_header++;
		$sec_content = trim( $matches[2] );
		if ( isset( self::$buffer['sections_data']['header'][ $index ] ) && ! empty( self::$buffer['sections_data']['header'][ $index ] ) ) {
			$loop = self::$buffer['sections_data']['header'][ $index ];
			$replaced_content = '';
			if ( is_array( $loop ) ) {
				foreach ( $loop as $replace ) {
					//$replace = self::sucuri_replace_data($replace);;
					$replaced = self::replace_section_content( $sec_content, $search, $replace );
					$replaced_content .= $replaced . '<br>';
				}
			}
			return $replaced_content;
		}
		return '';
	}

	public static function section_mark_body( $matches ) {
		$content = $matches[0];
		$index = self::$count_sec_body;
		$search = self::$buffer['sections']['body']['section_content_tokens'][ $index ];
		self::$count_sec_body++;
		$sec_content = trim( $matches[2] );
		if ( isset( self::$buffer['sections_data']['body'][ $index ] ) && ! empty( self::$buffer['sections_data']['body'][ $index ] ) ) {
			$loop = self::$buffer['sections_data']['body'][ $index ];
			$replaced_content = '';
			if ( is_array( $loop ) ) {
				foreach ( $loop as $replace ) {
					//$replace = self::sucuri_replace_data($replace);;
					$replaced = self::replace_section_content( $sec_content, $search, $replace );
					$replaced_content .= $replaced . '<br>';
				}
			}
			return $replaced_content;
		}
		return '';
	}

	public static function section_mark_footer( $matches ) {
		$content = $matches[0];
		$sec = $matches[1];
		$index = self::$count_sec_footer;
		$search = self::$buffer['sections']['footer']['section_content_tokens'][ $index ];
		self::$count_sec_footer++;
		$sec_content = trim( $matches[2] );
		if ( isset( self::$buffer['sections_data']['footer'][ $index ] ) && ! empty( self::$buffer['sections_data']['footer'][ $index ] ) ) {
			$loop = self::$buffer['sections_data']['footer'][ $index ];
			$replaced_content = '';
			if ( is_array( $loop ) ) {
				foreach ( $loop as $replace ) {
					//$replace = self::sucuri_replace_data($replace);
					$replaced = self::replace_section_content( $sec_content, $search, $replace );
					$replaced_content .= $replaced . '<br>';
				}
			}
			return $replaced_content;
		}
		return '';
	}

	function sucuri_scan_done( $website_id, $scan_status, $data ) {
		$scan_result = array();
		if ( is_array( $data ) ) {
			$blacklisted = isset( $data['BLACKLIST']['WARN'] ) ? true : false;
			$malware_exists = isset( $data['MALWARE']['WARN'] ) ? true : false;
			$system_error = isset( $data['SYSTEM']['ERROR'] ) ? true : false;

			$status = array();
			if ( $blacklisted ) {
				$status[] = __( 'Site Blacklisted', 'mainwp' ); }
			if ( $malware_exists ) {
				$status[] = __( 'Site With Warnings', 'mainwp' ); }

			$scan_result['status'] = count( $status ) > 0 ? implode( ', ', $status ) : __( 'Verified Clear', 'mainwp' );
			$scan_result['webtrust'] = $blacklisted ? __( 'Site Blacklisted', 'mainwp' ) : __( 'Trusted', 'mainwp' );
		}
		// save results to child site stream
		$post_data = array(
		'mwp_action' => 'save_sucuri_stream',
			'result' => base64_encode( serialize( $scan_result ) ),
			'scan_status' => $scan_status,
		);
		global $mainWPCReportExtensionActivator;
		apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website_id, 'client_report', $post_data );
	}

	function ajax_delete_client() {
		$client_id = $_POST['client_id'];
		if ( $client_id ) {
			if ( MainWP_CReport_DB::get_instance()->delete_clientnt( 'clientid', $client_id ) ) {
				die( 'SUCCESS' ); }
		}
		die( 'FAILED' );
	}

	public static function replace_content( $content, $tokens, $replace_tokens ) {
		return str_replace( $tokens, $replace_tokens, $content );
	}

	public static function replace_section_content( $content, $tokens, $replace_tokens ) {
		foreach ( $replace_tokens as $token => $value ) {
			$content = str_replace( $token, $value, $content );
		}
		$content = str_replace( $tokens, array(), $content ); // clear others tokens
		return $content;
	}

	public static function parse_report_content( $content, $client_tokens, $replace ) {
		$filtered_content = $content = str_replace( $client_tokens, $replace, $content );
		$sections = array();
		if ( preg_match_all( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', $content, $matches ) ) {
			for ( $i = 0; $i < count( $matches[1] ); $i++ ) {
				$sec = $matches[1][ $i ];
				$sec_content = $matches[2][ $i ];
				$sec_tokens = array();
				if ( preg_match_all( '/\[[^\]]+\]/is', $sec_content, $matches2 ) ) {
					$sec_tokens = $matches2[0];
				}
				//$sections[$sec] = $sec_tokens;
				$sections['section_token'][] = $sec;
				$sections['section_content_tokens'][] = $sec_tokens;
			}
		}
		$removed_sections = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', create_function( '$matches', 'return "";' ), $content );
		$other_tokens = array();
		if ( preg_match_all( '/\[[^\]]+\]/is', $removed_sections, $matches ) ) {
			$other_tokens = $matches[0];
		}
		return array( 'sections' => $sections, 'other_tokens' => $other_tokens, 'filtered_content' => $filtered_content );
	}

	public static function remove_section_tokens( $content ) {
		$matches = array();
		$section_tokens = array();
		$section = '';
		if ( preg_match_all( '/\[\/?section\.[^\]]+\]/is', $content, $matches ) ) {
			$section_tokens = $matches[0];
			$str_tmp = str_replace( array( '[', ']' ), '', $section_tokens[0] );
			list($context, $action, $section) = explode( '.', $str_tmp );
		}
		$content = str_replace( $section_tokens, '', $content );
		return array( 'content' => $content, 'section' => $section );
	}

	static function ga_data( $site_id, $start_date, $end_date, $chart = false ) {
		// fix bug cron job
		if ( null === self::$enabled_ga ) {
			self::$enabled_ga = apply_filters( 'mainwp-extension-available-check', 'mainwp-google-analytics-extension' ); }

		if ( ! self::$enabled_ga ) {
			return false; }

		//===============================================================
		//enym new
		//        $end_date = strtotime("-1 day", time());
		//        $start_date = strtotime( '-31 day', time() ); //31 days is more robust than "1 month" and this must match steprange in MainWPGA.class.php
		//===============================================================

		if ( ! $site_id || ! $start_date || ! $end_date ) {
			return false; }
		$uniq = 'ga_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[ $uniq ] ) ) {
			return self::$buffer[ $uniq ]; }

		$result = apply_filters( 'mainwp_ga_get_data', $site_id, $start_date, $end_date, $chart );
		$output = array(
		'ga.visits' => 'N/A',
			'ga.pageviews' => 'N/A',
			'ga.pages.visit' => 'N/A',
			'ga.bounce.rate' => 'N/A',
			'ga.new.visits' => 'N/A',
			'ga.avg.time' => 'N/A',
			'ga.visits.chart' => 'N/A', //enym new
			'ga.visits.maximum' => 'N/A',//enym new
		);
		if ( ! empty( $result ) && is_array( $result ) ) {
			if ( isset( $result['stats_int'] ) ) {
				$values = $result['stats_int'];
				$output['ga.visits'] = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:sessions'] )) ? $values['aggregates']['ga:sessions'] : 'N/A';
				$output['ga.pageviews'] = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:pageviews'] )) ? $values['aggregates']['ga:pageviews'] : 'N/A';
				$output['ga.pages.visit'] = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:pageviewsPerSession'] )) ? self::format_stats_values( $values['aggregates']['ga:pageviewsPerSession'], true, false ) : 'N/A';
				$output['ga.bounce.rate'] = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:bounceRate'] )) ? self::format_stats_values( $values['aggregates']['ga:bounceRate'], true, true ) : 'N/A';
				$output['ga.new.visits'] = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:percentNewSessions'] )) ? self::format_stats_values( $values['aggregates']['ga:percentNewSessions'], true, true ) : 'N/A';
				$output['ga.avg.time'] = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:avgSessionDuration'] )) ? self::format_stats_values( $values['aggregates']['ga:avgSessionDuration'], false, false, true ) : 'N/A';
			}

			//===============================================================
			//enym new   requires change in mainWPGA.class.php in Ga extension [send pure graph data in array]
			//help: http://charts.streitenberger.net/#
			//if (isset($result['stats_graph'])) {
			if ( $chart && isset( $result['stats_graphdata'] ) ) {
				//INTERVALL chxr=1,1,COUNTALLVALUES
				$intervalls = '1,1,' . count( $result['stats_graphdata'] );

				//MAX DIMENSIONS chds=0,HIGHEST*2
				foreach ( $result['stats_graphdata'] as $k => $v ) {
					if ( $v['1'] > $maximum_value ) {
						$maximum_value = $v['1'];
						$maximum_value_date = $v['0'];
					}
				}

				$vertical_max = ceil( $maximum_value * 1.3 );
				$dimensions = '0,' . $vertical_max;

				//DATA chd=t:1,2,3,4,5,6,7,8,9,10,11,12,13,14|
				$graph_values = '';
				foreach ( $result['stats_graphdata'] as $arr ) {
					$graph_values .= $arr['1'] . ',';
				}
				$graph_values = trim( $graph_values, ',' );

				//AXISLEGEND chd=t:1.1|2.1|3.1 ...
				$graph_dates = '';

				$step = 1;
				if ( count( $result['stats_graphdata'] ) > 20 ) {
					$step = 2;
				}
				$nro = 1;
				foreach ( $result['stats_graphdata'] as $arr ) {
					$nro = $nro + 1;
					if ( 0 == ($nro % $step) ) {

						$teile = explode( ' ', $arr['0'] );
						if ( 'Jan' == $teile[0] ) {
							$teile[0] = '1'; }
						if ( 'Feb' == $teile[0] ) {
							$teile[0] = '2'; }
						if ( 'Mar' == $teile[0] ) {
							$teile[0] = '3'; }
						if ( 'Apr' == $teile[0] ) {
							$teile[0] = '4'; }
						if ( 'May' == $teile[0] ) {
							$teile[0] = '5'; }
						if ( 'Jun' == $teile[0] ) {
							$teile[0] = '6'; }
						if ( 'Jul' == $teile[0] ) {
							$teile[0] = '7'; }
						if ( 'Aug' == $teile[0] ) {
							$teile[0] = '8'; }
						if ( 'Sep' == $teile[0] ) {
							$teile[0] = '9'; }
						if ( 'Oct' == $teile[0] ) {
							$teile[0] = '10'; }
						if ( 'Nov' == $teile[0] ) {
							$teile[0] = '11'; }
						if ( 'Dec' == $teile[0] ) {
							$teile[0] = '12'; }
						$graph_dates .= $teile[1] . '.' . $teile[0] . '.|';
					}
				}
				//$graph_dates = urlencode($graph_dates);
				$graph_dates = trim( $graph_dates, '|' );

				//SCALE chxr=1,0,HIGHEST*2
				$scale = '1,0,' . $vertical_max;

				//WIREFRAME chg=0,10,1,4
				$wire = '0,10,1,4';

				//COLORS
				$barcolor = '508DDE'; //4d89f9";
				$fillcolor = 'EDF5FF'; //CCFFFF";
				//LINEFORMAT chls=1,0,0
				$lineformat = '1,0,0';

				//TITLE
				//&chtt=Last+2+Weeks+Sales
				//LEGEND
				//&chdl=Sales

				$output['ga.visits.chart'] = '<img src="http://chart.apis.google.com/chart?cht=lc&chs=600x250&chd=t:' . $graph_values . '&chds=' . $dimensions . '&chco=' . $barcolor . '&chm=B,' . $fillcolor . ',0,0,0&chls=' . $lineformat . '&chxt=x,y&chxl=0:|' . $graph_dates . '&chxr=' . $scale . '&chg=' . $wire . '">';

				$date1 = explode( ' ', $maximum_value_date );
				if ( 'Jan' == $date1[0] ) {
					$date1[0] = '1'; }
				if ( 'Feb' == $date1[0] ) {
					$date1[0] = '2'; }
				if ( 'Mar' == $date1[0] ) {
					$date1[0] = '3'; }
				if ( 'Apr' == $date1[0] ) {
					$date1[0] = '4'; }
				if ( 'May' == $date1[0] ) {
					$date1[0] = '5'; }
				if ( 'Jun' == $date1[0] ) {
					$date1[0] = '6'; }
				if ( 'Jul' == $date1[0] ) {
					$date1[0] = '7'; }
				if ( 'Aug' == $date1[0] ) {
					$date1[0] = '8'; }
				if ( 'Sep' == $date1[0] ) {
					$date1[0] = '9'; }
				if ( 'Oct' == $date1[0] ) {
					$date1[0] = '10'; }
				if ( 'Nov' == $date1[0] ) {
					$date1[0] = '11'; }
				if ( 'Dec' == $date1[0] ) {
					$date1[0] = '12'; }
				$maximum_value_date = $date1[1] . '.' . $date1[0] . '.';
				$output['ga.visits.maximum'] = $maximum_value . ' (' . $maximum_value_date . ')';
			}

			$output['ga.startdate'] = date( 'd.m.Y', $start_date );
			$output['ga.enddate'] = date( 'd.m.Y', $end_date );
			//}
			//enym end
			//===============================================================
		}
		self::$buffer[ $uniq ] = $output;
		return $output;
	}

	static function piwik_data( $site_id, $start_date, $end_date ) {
		// fix bug cron job
		if ( null === self::$enabled_piwik ) {
			self::$enabled_piwik = apply_filters( 'mainwp-extension-available-check', 'mainwp-piwik-extension' ); }

		if ( ! self::$enabled_piwik ) {
			return false; }
		if ( ! $site_id || ! $start_date || ! $end_date ) {
			return false; }
		$uniq = 'pw_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[ $uniq ] ) ) {
			return self::$buffer[ $uniq ]; }

		$values = apply_filters( 'mainwp_piwik_get_data', $site_id, $start_date, $end_date );
		//        error_log(print_r($values, true));
		//        print_r($values);
		$output = array();
		$output['piwik.visits'] = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['nb_visits'] )) ? $values['aggregates']['nb_visits'] : 'N/A';
		$output['piwik.pageviews'] = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['nb_actions'] )) ? $values['aggregates']['nb_actions'] : 'N/A';
		$output['piwik.pages.visit'] = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['nb_actions_per_visit'] )) ? $values['aggregates']['nb_actions_per_visit'] : 'N/A';
		$output['piwik.bounce.rate'] = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['bounce_rate'] )) ? $values['aggregates']['bounce_rate'] : 'N/A';
		$output['piwik.new.visits'] = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['nb_uniq_visitors'] )) ? $values['aggregates']['nb_uniq_visitors'] : 'N/A';
		$output['piwik.avg.time'] = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['avg_time_on_site'] )) ? self::format_stats_values( $values['aggregates']['avg_time_on_site'], false, false, true ) : 'N/A';
		self::$buffer[ $uniq ] = $output;

		return $output;
	}

	static function aum_data( $site_id, $start_date, $end_date ) {

		if ( null === self::$enabled_aum ) {
			self::$enabled_aum = apply_filters( 'mainwp-extension-available-check', 'advanced-uptime-monitor-extension' ); }

		if ( ! self::$enabled_aum ) {
			return false; }

		if ( ! $site_id || ! $start_date || ! $end_date ) {
			return false; }
		$uniq = 'aum_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[ $uniq ] ) ) {
			return self::$buffer[ $uniq ]; }

		$values = apply_filters( 'mainwp_aum_get_data', $site_id, $start_date, $end_date );
		//print_r($values);
		$output = array();
		$output['aum.alltimeuptimeratio'] = (is_array( $values ) && isset( $values['aum.alltimeuptimeratio'] )) ? $values['aum.alltimeuptimeratio'] . '%' : 'N/A';
		$output['aum.uptime7'] = (is_array( $values ) && isset( $values['aum.uptime7'] )) ? $values['aum.uptime7'] . '%' : 'N/A';
		$output['aum.uptime15'] = (is_array( $values ) && isset( $values['aum.uptime15'] )) ? $values['aum.uptime15'] . '%' : 'N/A';
		$output['aum.uptime30'] = (is_array( $values ) && isset( $values['aum.uptime30'] )) ? $values['aum.uptime30'] . '%' : 'N/A';
		$output['aum.uptime45'] = (is_array( $values ) && isset( $values['aum.uptime45'] )) ? $values['aum.uptime45'] . '%' : 'N/A';
		$output['aum.uptime60'] = (is_array( $values ) && isset( $values['aum.uptime60'] )) ? $values['aum.uptime60'] . '%' : 'N/A';

		self::$buffer[ $uniq ] = $output;

		return $output;
	}

	static function woocomstatus_data( $site_id, $start_date, $end_date ) {

		// fix bug cron job
		if ( null === self::$enabled_woocomstatus ) {
			self::$enabled_woocomstatus = apply_filters( 'mainwp-extension-available-check', 'mainwp-woocommerce-status-extension' ); }

		if ( ! self::$enabled_woocomstatus ) {
			return false; }

		if ( ! $site_id || ! $start_date || ! $end_date ) {
			return false; }
		$uniq = 'wcstatus_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[ $uniq ] ) ) {
			return self::$buffer[ $uniq ]; }

		$values = apply_filters( 'mainwp_woocomstatus_get_data', $site_id, $start_date, $end_date );
		$top_seller = 'N/A';
		if ( is_array( $values ) && isset( $values['wcomstatus.topseller'] ) ) {
			$top = $values['wcomstatus.topseller'];
			if ( is_object( $top ) && isset( $top->name ) ) {
				$top_seller = $top->name;
			}
		}

		//print_r($values);
		$output = array();
		$output['wcomstatus.sales'] = (is_array( $values ) && isset( $values['wcomstatus.sales'] )) ? $values['wcomstatus.sales'] : 'N/A';
		$output['wcomstatus.topseller'] = $top_seller;
		$output['wcomstatus.awaitingprocessing'] = (is_array( $values ) && isset( $values['wcomstatus.awaitingprocessing'] )) ? $values['wcomstatus.awaitingprocessing'] : 'N/A';
		$output['wcomstatus.onhold'] = (is_array( $values ) && isset( $values['wcomstatus.onhold'] )) ? $values['wcomstatus.onhold'] : 'N/A';
		$output['wcomstatus.lowonstock'] = (is_array( $values ) && isset( $values['wcomstatus.lowonstock'] )) ? $values['wcomstatus.lowonstock'] : 'N/A';
		$output['wcomstatus.outofstock'] = (is_array( $values ) && isset( $values['wcomstatus.outofstock'] )) ? $values['wcomstatus.outofstock'] : 'N/A';
		self::$buffer[ $uniq ] = $output;
		return $output;
	}

	private static function format_stats_values( $value, $round = false, $perc = false, $showAsTime = false ) {
		if ( $showAsTime ) {
			$value = MainWP_CReport_Utility::sec2hms( $value );
		} else {
			if ( $round ) {
				$value = round( $value, 2 );
			}
			if ( $perc ) {
				$value = $value . '%';
			}
		}
		return $value;
	}

	public static function fetch_stream_data( $website, $report, $sections, $tokens ) {
		global $mainWPCReportExtensionActivator;
		$post_data = array(
		'mwp_action' => 'get_stream',
			'sections' => base64_encode( serialize( $sections ) ),
			'other_tokens' => base64_encode( serialize( $tokens ) ),
			'date_from' => $report->date_from,
			'date_to' => $report->date_to,
		);

		$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website['id'], 'client_report', $post_data );
		//        print_r($sections);
		//print_r($information);
		//error_log(print_r($information, true));
		if ( is_array( $information ) && ! isset( $information['error'] ) ) {
			return $information;
		} else {
			if ( isset( $information['error'] ) ) {
				$error = $information['error'];
				if ( 'NO_STREAM' == $error ) {
					$error = __( 'Error: No Stream or MainWP Client Reports plugin installed.' );
				}
			} else {
				$error = is_array( $information ) ? @implode( '<br>', $information ) : $information;
			}
			return array( 'error' => $error );
		}
	}

	public static function report_tab( $websites, $type = 0 ) {
		$orderby = 'title';
		$order = 'asc';

		if ( isset( $_GET['orderby'] ) && ! empty( $_GET['orderby'] ) && ('site' != $_GET['orderby']) ) {
			$orderby = $_GET['orderby'];
		}
		if ( isset( $_GET['order'] ) && ! empty( $_GET['order'] ) ) {
			$order = ('desc' == $_GET['order']) ? 'asc' : 'desc';
		}

		$title_order = $name_order = $lastsend_order = $datefrom_order = $client_order = $site_order = $schedule_order = '';
		if ( 'title' == $orderby ) {
			$title_order = ('desc' == $order) ? 'asc' : 'desc';
		} else if ( 'name' == $orderby ) {
			$name_order = ('desc' == $order) ? 'asc' : 'desc';
		} else if ( 'lastsend' == $orderby ) {
			$lastsend_order = ('desc' == $order) ? 'asc' : 'desc';
		} else if ( 'date_from' == $orderby ) {
			$datefrom_order = ('desc' == $order) ? 'asc' : 'desc';
		} else if ( 'client' == $orderby ) {
			$client_order = ('desc' == $order) ? 'asc' : 'desc';
		} else if ( 'site' == $orderby ) {
			$site_order = ('desc' == $order) ? 'asc' : 'desc';
		} else if ( 'schedule' == $orderby ) {
			$orderby = 'recurring_schedule';
			$schedule_order = ('desc' == $order) ? 'asc' : 'desc';
		} else {
			$orderby = 'title';
		}

		$get_by = 'all';
		$value = null;

		if ( isset( $_GET['site'] ) && ! empty( $_GET['site'] ) ) {
			$get_by = 'site';
			$value = $_GET['site'];
		} else if ( isset( $_GET['client'] ) && ! empty( $_GET['client'] ) ) {
			$get_by = 'client';
			$value = $_GET['client'];
		}

		$reports = MainWP_CReport_DB::get_instance()->get_report_by( $get_by, $value, $orderby, $order );

		$all_sites = array();
		if ( is_array( $websites ) ) {
			foreach ( $websites as $website ) {
				$all_sites[ $website['id'] ] = $website;
			}
		}
		//print_r($all_sites);
		$temp_reports = array();
		if ( ! empty( $site_order ) ) {
			foreach ( $reports as $report ) {
				$report->site_name = ! empty( $report->selected_site ) && isset( $all_sites[ $report->selected_site ] ) ? ($all_sites[ $report->selected_site ]['name']) : '';
				$temp_reports[] = $report;
			}
			self::$order = $order;
			usort( $temp_reports, array( 'MainWP_CReport', 'creport_data_sort' ) );
			$reports = $temp_reports;
		}
		$normal_reports = $global_reports = array();
		foreach ( $reports as $rp ) {
			if ( empty( $rp->type ) ) {
				$normal_reports[] = $rp; } else {
				$global_reports[] = $rp; }
		}
		?>
		<h3><?php _e( 'Client Reports', 'mainwp' ); ?></h3>
        <table id="mainwp-table" class="wp-list-table widefat" cellspacing="0">
            <thead>
                <tr> 
					<th scope="col" class="manage-column sortable <?php echo $title_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=title&order=<?php echo (empty( $title_order ) ? 'asc' : $title_order); ?>"><span><?php _e( 'Title', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $client_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=client&order=<?php echo (empty( $client_order ) ? 'asc' : $client_order); ?>"><span><?php _e( 'Client', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>                
					<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=name&order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Send To', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>                
					<th scope="col" class="manage-column sortable <?php echo $lastsend_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=lastsend&order=<?php echo (empty( $lastsend_order ) ? 'asc' : $lastsend_order); ?>"><span><?php _e( 'Last Report Send', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $datefrom_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=date_from&order=<?php echo (empty( $datefrom_order ) ? 'asc' : $datefrom_order); ?>"><span><?php _e( 'Report For', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $schedule_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=schedule&order=<?php echo (empty( $schedule_order ) ? 'asc' : $schedule_order); ?>"><span><?php _e( 'Scheduled', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable  <?php echo $site_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=site&order=<?php echo (empty( $site_order ) ? 'asc' : $site_order); ?>"><span><span><?php _e( 'Site', 'mainwp' ); ?></span></span><span class="sorting-indicator"></span></a>
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr> 
					<th scope="col" class="manage-column sortable <?php echo $title_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=title&order=<?php echo (empty( $title_order ) ? 'asc' : $title_order); ?>"><span><?php _e( 'Title', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $client_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=client&order=<?php echo (empty( $client_order ) ? 'asc' : $client_order); ?>"><span><?php _e( 'Client', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>   
					<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=send&order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Send To', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>                
					<th scope="col" class="manage-column sortable <?php echo $lastsend_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=lastsend&order=<?php echo (empty( $lastsend_order ) ? 'asc' : $lastsend_order); ?>"><span><?php _e( 'Last Report Send', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $datefrom_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=date_from&order=<?php echo (empty( $datefrom_order ) ? 'asc' : $datefrom_order); ?>"><span><?php _e( 'Report For', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $schedule_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=schedule&order=<?php echo (empty( $schedule_order ) ? 'asc' : $schedule_order); ?>"><span><?php _e( 'Scheduled', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                    </th>
					<th scope="col" class="manage-column sortable <?php echo $site_order; ?>">
						<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=site&order=<?php echo (empty( $site_order ) ? 'asc' : $site_order); ?>"><span><span><?php _e( 'Site', 'mainwp' ); ?></span></span><span class="sorting-indicator"></span></a>
                    </th>
                </tr>
            </tfoot>
            <tbody>
				<?php
				self::report_table_content( $normal_reports, $all_sites );
				?>
            </tbody>
        </table>     

		<?php if ( count( $global_reports ) > 0 ) : ?>
            <br>
            <br>
			<h3><?php _e( 'Global Reports', 'mainwp' ); ?></h3>
            <table id="mainwp-table" class="wp-list-table widefat" cellspacing="0">
                <thead>
                    <tr> 
						<th scope="col" class="manage-column sortable <?php echo $title_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=title&order=<?php echo (empty( $title_order ) ? 'asc' : $title_order); ?>"><span><?php _e( 'Title', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>
						<th scope="col" class="manage-column sortable <?php echo $client_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=client&order=<?php echo (empty( $client_order ) ? 'asc' : $client_order); ?>"><span><?php _e( 'Client', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>                
						<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=name&order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Send To', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>                
						<th scope="col" class="manage-column sortable <?php echo $lastsend_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=lastsend&order=<?php echo (empty( $lastsend_order ) ? 'asc' : $lastsend_order); ?>"><span><?php _e( 'Last Report Send', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>
						<th scope="col" class="manage-column sortable <?php echo $datefrom_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=date_from&order=<?php echo (empty( $datefrom_order ) ? 'asc' : $datefrom_order); ?>"><span><?php _e( 'Report For', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>
						<th scope="col" class="manage-column sortable <?php echo $schedule_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=schedule&order=<?php echo (empty( $schedule_order ) ? 'asc' : $schedule_order); ?>"><span><?php _e( 'Scheduled', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>                   
                    </tr>
                </thead>
                <tfoot>
                    <tr> 
						<th scope="col" class="manage-column sortable <?php echo $title_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=title&order=<?php echo (empty( $title_order ) ? 'asc' : $title_order); ?>"><span><?php _e( 'Title', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>
						<th scope="col" class="manage-column sortable <?php echo $client_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=client&order=<?php echo (empty( $client_order ) ? 'asc' : $client_order); ?>"><span><?php _e( 'Client', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>   
						<th scope="col" class="manage-column sortable <?php echo $name_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=send&order=<?php echo (empty( $name_order ) ? 'asc' : $name_order); ?>"><span><?php _e( 'Send To', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>                
						<th scope="col" class="manage-column sortable <?php echo $lastsend_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=lastsend&order=<?php echo (empty( $lastsend_order ) ? 'asc' : $lastsend_order); ?>"><span><?php _e( 'Last Report Send', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>
						<th scope="col" class="manage-column sortable <?php echo $datefrom_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=date_from&order=<?php echo (empty( $datefrom_order ) ? 'asc' : $datefrom_order); ?>"><span><?php _e( 'Report For', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>
						<th scope="col" class="manage-column sortable <?php echo $schedule_order; ?>">
							<a href="?page=Extensions-Mainwp-Client-Reports-Extension&orderby=schedule&order=<?php echo (empty( $schedule_order ) ? 'asc' : $schedule_order); ?>"><span><?php _e( 'Scheduled', 'mainwp' ); ?></span><span class="sorting-indicator"></span></a>
                        </th>                    
                    </tr>
                </tfoot>
                <tbody>
					<?php
					self::report_table_content( $global_reports, $all_sites );
					?>
                </tbody>
            </table>  
		<?php endif; ?>
		<?php
	}

	public static function creport_data_sort( $a, $b ) {
		$a = $a->site_name;
		$b = $b->site_name;
		$cmp = strcmp( $a, $b );

		if ( 0 == $cmp ) {
			return 0; }
		if ( 'desc' == self::$order ) {
			return ($cmp > 0) ? -1 : 1; } else {
			return ($cmp > 0) ? 1 : -1; }
	}

	public static function report_table_content( $reports, $websites ) {

		if ( ! is_array( $reports ) || count( $reports ) == 0 ) {
			?>
			<tr><td colspan="6"><?php _e( 'No Reports Found.' ); ?></td></tr>
			<?php
			return;
		}
		$recurring_schedule = array(
		'daily' => __( 'Daily' ),
			'weekly' => __( 'Weekly' ),
			'biweekly' => __( 'Bi Weekly' ),
			'monthly' => __( 'Monthly' ),
			'quarterly' => __( 'Quarterly' ),
			'twice_a_year' => __( 'Twice a Year' ),
			'yearly' => __( 'Yearly' ),
		);
		global $mainWPCReportExtensionActivator;
		$url_loader = plugins_url( 'images/loader.gif', dirname( __FILE__ ) );
		$sites_token = array();
		foreach ( $reports as $report ) {

			$client_tooltip = $report->client;
			$client_name_tooltip = $report->name;
			$email_tooltip = $report->email;
			$company_tooltip = $report->company;
			$subject_tooltip = $report->subject;

			if ( preg_match( '/\[.+\]/is', $client_tooltip ) ) {
				$client_tooltip = preg_replace_callback( '/\[.+\]/is', array( 'MainWP_CReport', 'tooltip_mark_token' ), $client_tooltip );
			}

			if ( preg_match( '/\[.+\]/is', $client_name_tooltip ) ) {
				$client_tooltip = preg_replace_callback( '/\[.+\]/is', array( 'MainWP_CReport', 'tooltip_mark_token' ), $client_name_tooltip );
			}
			$email_has_token = false;
			if ( preg_match( '/^\[.+\]/is', $email_tooltip ) ) {
				$email_has_token = true;
				$email_tooltip = preg_replace_callback( '/\[.+\]/is', array( 'MainWP_CReport', 'tooltip_mark_token' ), $email_tooltip );
			}
			if ( preg_match( '/\[.+\]/is', $company_tooltip ) ) {
				$company_tooltip = preg_replace_callback( '/\[.+\]/is', array( 'MainWP_CReport', 'tooltip_mark_token' ), $company_tooltip );
			}
			if ( preg_match( '/\[.+\]/is', $subject_tooltip ) ) {
				$subject_tooltip = preg_replace_callback( '/\[.+\]/is', array( 'MainWP_CReport', 'tooltip_mark_token' ), $subject_tooltip );
			}

			if ( empty( $report->type ) ) {
				$website = ($report->selected_site && isset( $websites[ $report->selected_site ] )) ? $websites[ $report->selected_site ] : null;
				$site_column = '';
				if ( ! empty( $website ) ) {
					$site_column = '<a href="admin.php?page=managesites&dashboard=' . $website['id'] . '">' . esc_html( $website['name'] ) . '</a><br>' .
							'<div class="row-actions"><span class="dashboard"><a href="admin.php?page=managesites&dashboard=' . $website['id'] . '">' . __( 'Dashboard' ) . '</a></span> | ' .
							'<span class="edit"><a href="admin.php?page=managesites&id=' . $website['id'] . '">' . __( 'Edit' ) . '</a></span></div>';
				}
			}

			$sche_column = _( 'No' );
			if ( ! empty( $report->recurring_schedule ) && ! empty( $report->scheduled ) ) {
				$sche_column = $recurring_schedule[ $report->recurring_schedule ];
				if ( ! empty( $report->schedule_nextsend ) ) {
					$sche_column .= '<br> Next Send: ' . MainWP_CReport_Utility::format_timestamp( $report->schedule_nextsend ); }
			}
			?>   
			<tr id="<?php echo $report->id; ?>">            
                <td>
					<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=editreport&id=<?php echo $report->id; ?>"><strong><?php echo stripslashes( $report->title ); ?></strong></a>
					<div class="row-actions"><a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=preview&id=<?php echo $report->id; ?>"><?php _e( 'Preview' ); ?></a></span> |  
					<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=editreport&id=<?php echo $report->id; ?>"><?php _e( 'Edit' ); ?></a></span> |  
				<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=replicate&id=<?php echo $report->id; ?>"><?php _e( 'Replicate' ); ?></a></span> |  
			<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=sendreport&id=<?php echo $report->id; ?>"><?php _e( 'Send' ); ?></a> | 
			<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=save_pdf&id=<?php echo $report->id; ?>"><?php _e( 'PDF' ); ?></a> | 
			<?php if ( ! $report->is_archived ) { ?>
				<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=archive_report&id=<?php echo $report->id; ?>"><?php _e( 'Archive' ); ?></a> | 
			<?php } else { ?>
				<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=unarchive_report&id=<?php echo $report->id; ?>"><?php _e( 'Un-Archive' ); ?></a> |                       
			<?php } ?>

			<?php if ( $report->scheduled ) { ?>
				<span class="schedule"><a href="#" class="mwp-creport-report-item-cancel-scheduled-lnk"><?php _e( 'Cancel Schedule' ); ?></a> | </span>   
			<?php } ?>

			<span class="delete"><a href="#" class="mwp-creport-report-item-delete-lnk"><?php _e( 'Delete' ); ?></a></span> 
            </div>                     
			<span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>
            </td> 
            <td>
				<?php echo stripslashes( $client_tooltip ); ?>
            </td> 
            <td>
				<?php
				echo $client_name_tooltip . ' - ' . $company_tooltip . '<br>';
				if ( $email_has_token ) {
					echo $email_tooltip;
				} else {
					echo ! empty( $report->email ) ? '<a href="mailto:' . $report->email . '">' . $report->email . '</a>' : '';
				}
				?>
            </td> 
            <td> 
				<?php echo ! empty( $report->lastsend ) ? MainWP_CReport_Utility::format_timestamp( $report->lastsend ) : ''; ?>
            </td>
            <td> 
				<?php echo ! empty( $report->date_from ) ? 'From: ' . MainWP_CReport_Utility::format_timestamp( $report->date_from ) . '<br>' : ''; ?>
				<?php echo ! empty( $report->date_to ) ? 'To: ' . MainWP_CReport_Utility::format_timestamp( $report->date_to ) : ''; ?>
            </td>
            <td> 
				<span class="creport_sche_column"><?php echo $sche_column; ?></span>
            </td>
			<?php if ( empty( $report->type ) ) { ?>
                <td> 
					<?php echo $site_column; ?>
                </td>
			<?php } ?>
            </tr>
			<?php
		}
	}

	static function tooltip_mark_token( $matches ) {
		$token_name = $matches[0];
		$token = MainWP_CReport_DB::get_instance()->get_tokens_by( 'token_name', $token_name );
		$tooltip = '';
		if ( $token ) {
			$token_site_values = MainWP_CReport_DB::get_instance()->get_site_token_values( $token->id );
			if ( is_array( $token_site_values ) && count( $token_site_values ) > 0 ) {
				foreach ( $token_site_values as $tok ) {
					if ( ! empty( $tok->token_value ) ) {
						$tooltip .= $tok->token_value . '<br>';
					}
				}
				if ( ! empty( $tooltip ) ) {
					$tooltip = rtrim( $tooltip, '<br>' );
					$tooltip = '<span class="mwp_creport_tooltip_content">' . $tooltip . '</span>';
				}
			}
		}
		if ( ! empty( $tooltip ) ) {
			return '<span class="mwp_creport_tooltip_container"><span class="mwp_creport_token_tooltip">' . $matches[0] . '</span>' . $tooltip . '</span>';
		}
		return $matches[0] . $tooltip;
	}

	public static function new_report_tab( $report = null ) {
		self::new_report_setting( $report );
		self::new_report_format( $report );
		self::new_report_schedule( $report );
	}

	public static function new_report_setting( $report = null ) {
		?>
        <fieldset class="mainwp-creport-report-setting-box">   
			<?php if ( ! empty( $report ) && isset( $report->scheduled ) && ! empty( $report->scheduled ) ) { ?>
				<div class="mainwp_info-box-yellow"><?php _e( 'This report has been scheduled' ); ?></div>
			<?php } ?>                                      
            <table class="wp-list-table widefat" cellspacing="0">
                <thead>
                    <tr>          
                        <th scope="col" colspan="2">
							<?php _e( 'Client Report Settings', 'mainwp' ); ?>
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
					self::new_report_setting_table_content( $report );
					?>
                </tbody>
            </table>         
        </fieldset>
        <br>
        <script>
            jQuery(document).ready(function () {
                jQuery('#mainwp_creport_autocomplete_client').each(function (key, value) {
                    var autocompleteList = jQuery(value).attr('autocompletelist');
                    var realList = jQuery('#' + autocompleteList);
                    var text = [];
                    var foundOptions = realList.find('option');
                    for (var i = 0; i < foundOptions.length; i++)
                    {
                        text.push(jQuery(foundOptions[i]).val());
                    }
                    jQuery(value).autocomplete({
                        source: text,
                        change: mainwp_creport_client_change
                    });
                });
                //$("#mainwp_creport_autocomplete_client").data("ui-autocomplete")._trigger("change");                
            });
        </script>  
		<?php
	}

	public static function new_report_format( $report ) {
		?>        
        <table class="wp-list-table widefat" cellspacing="0">
            <thead>
                <tr>          
                    <th scope="col" colspan="2">
						<?php _e( 'Report Format', 'mainwp' ); ?>
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
				self::new_report_format_table_content( $report );
				?>
            </tbody>
        </table>
		<?php
	}

	public static function new_report_schedule( $report ) {
		$recurring_schedule = array(
		'daily' => __( 'Daily' ),
			'weekly' => __( 'Weekly' ),
			'biweekly' => __( 'Bi Weekly' ),
			'monthly' => __( 'Monthly' ),
			'quarterly' => __( 'Quarterly' ),
			'twice_a_year' => __( 'Twice a Year' ),
			'yearly' => __( 'Yearly' ),
		);
		$recurringSchedule = $recurringDate = '';
		$scheduleSendEmail = 'email_auto';
		$scheduleBCCme = 0;
		if ( ! empty( $report ) ) {
			$recurringSchedule = $report->recurring_schedule;
			$recurringDate = ! empty( $report->recurring_date ) ? date( 'Y-m-d', $report->recurring_date ) : '';
			$scheduleSendEmail = $report->schedule_send_email;
			$scheduleBCCme = isset( $report->schedule_bcc_me ) ? $report->schedule_bcc_me : 0;
		}
		?>        
        <br>
        <table class="wp-list-table widefat" cellspacing="0">
            <thead>
                <tr>          
                    <th scope="col" colspan="2">
						<?php _e( 'Schedule Report', 'mainwp' ); ?>
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th style="border:none !important;" colspan="2">&nbsp;</th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <th colspan="2"> 
			<div class="mainwp_info-box-red"><?php echo __( 'Note: This feature uses cron functions in order to work correctly. If you are experiencing issues having the feature trigger please review this' ) . ' <a href="http://docs.mainwp.com/backups-scheduled-events-occuring/" target="_blank">' . __( 'help document' ) . '</a>.'; ?></div>
        </th>
        </tr>
        <tr>
			<th><span><?php _e( 'Recurring Schedule' ); ?></span></th>
            <td><p><select name='mainwp_creport_recurring_schedule' id="mainwp_creport_recurring_schedule">   
						<option value=""><?php _e( 'Off' ); ?></option>
						<?php
						foreach ( $recurring_schedule as $value => $title ) {
							$_select = '';
							if ( $recurringSchedule == $value ) {
								$_select = 'selected'; }
							echo '<option value="' . $value . '" ' . $_select . '>' . $title . '</option>';
						}
						?>
					</select>&nbsp;&nbsp;<?php _e( 'Start Send Date' ); ?>&nbsp;&nbsp;
					<input type="text" name="mainwp_creport_schedule_date" id="mainwp_creport_schedule_date" class="mainwp_creport_datepicker" value="<?php echo $recurringDate; ?>"/>
					<input type="submit" value="<?php _e( 'Schedule Report' ); ?>" class="button-primary" id="mwp-creport-schedule-btn" name="button_schedule">
                </p>
				<p><input type="radio" name="mainwp_creport_schedule_send_email" value="email_review" id="mainwp_creport_schedule_send_email_me_review" <?php echo ('email_review' == $scheduleSendEmail) ? 'checked' : ''; ?>/><label for="mainwp_creport_schedule_send_email_me_review"><?php _e( 'Email me when report is complete so I can review' ); ?></label></p>
				<p><input type="radio" name="mainwp_creport_schedule_send_email" value="email_auto" id="mainwp_creport_schedule_send_email_auto" <?php echo ('email_auto' == $scheduleSendEmail) ? 'checked' : ''; ?>/><label for="mainwp_creport_schedule_send_email_auto"><?php _e( 'Automatically email my client the report' ); ?></label></p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="mainwp_creport_schedule_bbc_me_email" value="1" id="mainwp_creport_schedule_bbc_me_email" <?php echo $scheduleBCCme ? 'checked' : ''; ?>/><label for="mainwp_creport_schedule_bbc_me_email"><?php _e( 'BCC me on report email' ); ?></label></p>
            </td>
        </tr>
        </tbody>
        </table>
		<?php
	}

	public static function new_report_setting_table_content( $report = null ) {
		$title = $date_from = $date_to = '';
		$from_name = $from_company = $from_email = '';

		$to_client = '[client.name]';
		$to_name = '[client.name]';
		$to_company = '[client.company]';
		$to_email = '[client.email]';
		$email_subject = 'Report for [client.site.name]';
		$to_orther_email = '';

		$client_id = 0;
		$attachFiles = '';
		//$scheduleSendEmail = "email_auto";
		// $scheduleBCCme = 0;
		//print_r($report);
		if ( ! empty( $report ) ) {
			$title = $report->title;
			$date_from = ! empty( $report->date_from ) ? date( 'Y-m-d', $report->date_from ) : '';
			$date_to = ! empty( $report->date_to ) ? date( 'Y-m-d', $report->date_to ) : '';
			$from_name = $report->fname;
			$from_company = $report->fcompany;
			$from_email = $report->femail;
			$to_name = $report->name;
			$to_company = $report->company;
			$to_email = $report->email;
			$to_client = $report->client;
			$email_subject = $report->subject;
			$to_orther_email = $report->to_other_email;

			//$recurringSchedule = $report->recurring_schedule;
			//$recurringDate = !empty($report->recurring_date) ? date("Y-m-d", $report->recurring_date) : "";
			//$scheduleSendEmail = $report->schedule_send_email;
			//            $scheduleBCCme = $report->schedule_bcc_me;
			$attachFiles = isset( $report->attach_files ) ? $report->attach_files : '';
			$client_id = intval( $report->client_id );
			if ( $client_id ) {
				$client = MainWP_CReport_DB::get_instance()->get_client_by( 'clientid', $client_id );
				if ( ! empty( $client ) ) {
					$to_client = $client->client;
					$to_name = $client->name;
					$to_company = $client->company;
					$to_email = $client->email;
				}
			}
		}

		$clients = MainWP_CReport_DB::get_instance()->get_clients();
		if ( ! is_array( $clients ) ) {
			$clients = array(); }

		if ( ! empty( $report ) && isset( $report->id ) && isset( $report->is_archived ) && $report->is_archived ) {
			?>
			<tr><td colspan="2"><div class="mainwp_info-box-yellow"><?php _e( 'This is an Archived Report' ); ?></div></td></tr>            
		<?php } ?>

        <tr>
			<th><span><?php _e( 'Title' ); ?> <span class="desc-light"><?php _e( '(required)' ); ?></span></span></th>
            <td class="title">
				<input type="text" name="mwp_creport_title" id="mwp_creport_title" value="<?php echo esc_attr( stripslashes( $title ) ); ?>" />
            </td>
        </tr>
        <tr>
			<th><span><?php _e( 'Date Range' ); ?></span></th>
            <td class="date">
				<input type="text" name="mwp_creport_date_from" id="mwp_creport_date_from" class="mainwp_creport_datepicker" value="<?php echo $date_from; ?>"/>&nbsp;&nbsp;To&nbsp;&nbsp;<input type="text" class="mainwp_creport_datepicker" name="mwp_creport_date_to" id="mwp_creport_date_to" value="<?php echo $date_to; ?>" />
            </td>           
        </tr>
        <tr>
			<th><span><?php _e( 'Send From' ); ?></span></th>
            <td>
				<input type="text" name="mwp_creport_fname" placeholder="Name" value="<?php echo esc_attr( stripslashes( $from_name ) ); ?>" />&nbsp;&nbsp;
				<input type="text" name="mwp_creport_fcompany" placeholder="Company" value="<?php echo esc_attr( stripslashes( $from_company ) ); ?>" />&nbsp;&nbsp;
				<input type="text" name="mwp_creport_femail" placeholder="Email" value="<?php echo esc_attr( stripslashes( $from_email ) ); ?>" />
            </td>
        </tr>
        <tr>
			<th><span><?php _e( 'Client' ); ?></span></th>
            <td>
				<input type="text" name="mwp_creport_client" value="<?php echo esc_attr( stripslashes( $to_client ) ); ?>"
                       autocompletelist="clients_list" id="mainwp_creport_autocomplete_client" /> 
				<span id="mainwp_creport_client_loading"><img src="<?php echo plugins_url( 'images/loader.gif', dirname( __FILE__ ) ); ?>" class="hidden-field"></span> 
                <datalist id="clients_list">
					<?php
					foreach ( $clients as $client ) {
						echo '<option>' . $client->client . '</option>';
					}
					?>
                </datalist>


            </td>
        </tr>
        <tr>
			<th><span><?php _e( 'Send To' ); ?></span></th>
            <td>
				<input type="text" name="mwp_creport_name" placeholder="Name" value="<?php echo esc_attr( stripslashes( $to_name ) ); ?>" />&nbsp;&nbsp;
				<input type="text" name="mwp_creport_company" placeholder="Company" value="<?php echo esc_attr( stripslashes( $to_company ) ); ?>" />&nbsp;&nbsp;
				<input type="text" name="mwp_creport_email" id="mwp_creport_email" placeholder="Email" value="<?php echo esc_attr( stripslashes( $to_email ) ); ?>" />
            </td>
        </tr>       
        <tr>
			<th><span><?php _e( 'Email Subject' ); ?></span></th>
            <td>
				<input type="text" name="mwp_creport_email_subject" value="<?php echo esc_attr( stripslashes( $email_subject ) ); ?>"
                       id="mwp_creport_email_subject" />                  
            </td>
        </tr>       
        <tr>
			<th><span><?php _e( 'Attach Files' ); ?></span></th>
			<td><?php
			if ( ! empty( $attachFiles ) ) {
				?>
				<p><?php echo $attachFiles ?></p>                                
                    <p>
                    <input type="checkbox" class="mainwp-checkbox2" value="1"  id="mainwp_creport_delete_attach_files" name="mainwp_creport_delete_attach_files">
					<label class="mainwp-label2" for="mainwp_creport_delete_attach_files"><?php _e( 'Delete attach files', 'mainwp' ); ?></label>
                    </p>
					<?php
			}
				?>
                <input type="file" name="mainwp_creport_attach_files[]" multiple="true"><br /> 
				<span class="description"><?php _e( 'Maximum filesize 5MB.' ) ?></span>
            </td>
        </tr>

		<input type="hidden" name="mwp_creport_client_id" value="<?php echo esc_attr( $client_id ); ?>">
		<?php
	}

	public static function new_report_format_table_content( $report = null ) {
		$header = $body = $footer = $file_logo = '';

		if ( $report && is_object( $report ) ) {
			$header = $report->header;
			$body = $report->body;
			$footer = $report->footer;
			//       $file_logo = isset($report->logo_file) ? $report->logo_file : "" ;
		}

		$client_tokens = MainWP_CReport_DB::get_instance()->get_tokens();
		$client_tokens_values = array();
		$website = null;
		if ( $report && $report->selected_site ) {
			global $mainWPCReportExtensionActivator;
			$website = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $report->selected_site );
			if ( $website && is_array( $website ) ) {
				$website = current( $website );
			}

			if ( is_array( $website ) && isset( $website['url'] ) ) {
				$site_tokens = MainWP_CReport_DB::get_instance()->get_site_tokens( $website['url'] );
				foreach ( $client_tokens as $token ) {
					$client_tokens_values[] = array(
					'token_name' => $token->token_name,
						'token_value' => isset( $site_tokens[ $token->id ] ) ? $site_tokens[ $token->id ]->token_value : '',
					);
				}
			}
		}

		$header_formats = MainWP_CReport_DB::get_instance()->get_formats( 'H' );
		$body_formats = MainWP_CReport_DB::get_instance()->get_formats( 'B' );
		$footer_formats = MainWP_CReport_DB::get_instance()->get_formats( 'F' );
		if ( ! is_array( $header_formats ) ) {
			$header_formats = array(); }
		if ( ! is_array( $body_formats ) ) {
			$body_formats = array(); }
		if ( ! is_array( $footer_formats ) ) {
			$footer_formats = array(); }

		$url_loader = plugins_url( 'images/loader.gif', dirname( __FILE__ ) );
		?>  
        <tr>
            <th colspan="2">
        <div class="mainwp_creport_format_section_header closed" section="header">
			<a href="javascript:void(0)" class="handlelnk"><?php _e( 'Show' ); ?></a>
			<h3><?php _e( 'Report Header' ); ?></h3>
        </div>
        </th>
        </tr>
        <tr class="mainwp_creport_format_section hidden-field">
			<th><span><?php _e( 'Enter Report Header' ); ?></span>
		<div class="logo"><img src="<?php echo MainWP_CReport_Extension::$plugin_url . 'images/cr-header.png'; ?>"></div>
        </th>
        <td>
			<?php
			remove_editor_styles(); // stop custom theme styling interfering with the editor
			wp_editor(stripslashes( $header ), 'mainwp_creport_report_header', array(
				'textarea_name' => 'mainwp_creport_report_header',
				'textarea_rows' => 5,
				'teeny' => true,
				'media_buttons' => true,
					)
			);
			?>
            <div class="mainwp_creport_format_save_section">
                <div class="inner">
					<?php _e( 'Save Report Header' ); ?>
					<input type="text" placeholder="<?php _e( 'Enter Report Header Title' ); ?>" name="mainwp_creport_report_save_header" value=""/>
					<input type="button" format="H" ed-name="header" class="button-primary mainwp_creport_report_save_format_btn" value="<?php _e( 'Save' ); ?>"/>
					<span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>                    
                </div>
                <div class="inner">
					<?php _e( 'Report Header' ); ?>
                    <select name="mainwp_creport_report_insert_header_sle">
						<option value="0"><?php _e( 'Select a Report Header' ); ?></option>
						<?php
						foreach ( $header_formats as $format ) {
							echo '<option value="' . $format->id . '">' . esc_html( $format->title ) . '</option>';
						}
						?>
                    </select>
					<input type="button" ed-name="header" class="button-primary mainwp_creport_report_insert_format_btn" value="<?php _e( 'Insert' ); ?>"/>
					<input type="button" ed-name="header" class="button-primary mainwp_creport_report_delete_format_btn" value="<?php _e( 'Delete' ); ?>"/>
					<span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>
                </div>
            </div>            
			<div style="background: #F5F5F5; padding: 5px; border-bottom: 1px Dashed #fff;"><a href="#" style="float: right" class="mainwp_creport_show_insert_tokens_book_lnk"><?php _e( 'Show Available Tokens' ); ?></a><div class="clearfix"></div></div>
            <div class="clearfix"></div>
			<?php self::gen_insert_tokens_box( 'header', true, $client_tokens_values, $client_tokens, $website ); ?>
        </td> 
        </tr>  
        <tr>
            <th colspan="2">
        <div class="mainwp_creport_format_section_header closed" section="body">
			<a href="javascript:void(0)" class="handlelnk"><?php _e( 'Show' ); ?></a>
			<h3><?php _e( 'Report Body' ); ?></h3>
        </div>
        </th>
        </tr>
        <tr class="mainwp_creport_format_section hidden-field">        
			<th><span><?php _e( 'Enter Report Body' ); ?></span>
		<div class="logo"><img src="<?php echo MainWP_CReport_Extension::$plugin_url . 'images/cr-body.png'; ?>"></div>
        </th>
        <td>
			<?php
			remove_editor_styles(); // stop custom theme styling interfering with the editor
			wp_editor(stripslashes( $body ), 'mainwp_creport_report_body', array(
				'textarea_name' => 'mainwp_creport_report_body',
				'textarea_rows' => 20,
				'teeny' => true,
				'media_buttons' => true,
				'tinymce' => array( 'height' => 400 ),
					)
			);
			?>
            <div class="mainwp_creport_format_save_section">
                <div class="inner">
					<?php _e( 'Save Report Body' ); ?>
					<input type="text" placeholder="<?php _e( 'Enter Report Body Title' ); ?>" name="mainwp_creport_report_save_header" value=""/>
					<input type="button" format="B" ed-name="body" class="button-primary mainwp_creport_report_save_format_btn" value="<?php _e( 'Save' ); ?>"/>
					<span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>                    
                </div>
                <div class="inner">
					<?php _e( 'Report Body' ); ?>
                    <select name="mainwp_creport_report_insert_header_sle">
						<option value="0"><?php _e( 'Select a Report Body' ); ?></option>
						<?php
						foreach ( $body_formats as $format ) {
							echo '<option value="' . $format->id . '">' . esc_html( $format->title ) . '</option>';
						}
						?>
                    </select>
					<input type="button" ed-name="body" class="button-primary mainwp_creport_report_insert_format_btn" value="<?php _e( 'Insert' ); ?>"/>
					<input type="button" ed-name="body" class="button-primary mainwp_creport_report_delete_format_btn" value="<?php _e( 'Delete' ); ?>"/>
					<span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>
                </div>
            </div>

			<?php self::gen_insert_tokens_box( 'body', false, $client_tokens_values, $client_tokens, $website ); ?>
        </td> 
        </tr>   
        <tr>
            <th colspan="2">
        <div class="mainwp_creport_format_section_header closed" section="footer">
			<a href="javascript:void(0)" class="handlelnk"><?php _e( 'Show' ); ?></a>
			<h3><?php _e( 'Report Footer' ); ?></h3>
        </div>
        </th>
        </tr>
        <tr class="mainwp_creport_format_section hidden-field">     
			<th><span><?php _e( 'Enter Report Footer' ); ?></span>
		<div class="logo"><img src="<?php echo MainWP_CReport_Extension::$plugin_url . 'images/cr-footer.png'; ?>"></div>
        </th>
        <td>
			<?php
			remove_editor_styles(); // stop custom theme styling interfering with the editor
			wp_editor(stripslashes( $footer ), 'mainwp_creport_report_footer', array(
				'textarea_name' => 'mainwp_creport_report_footer',
				'textarea_rows' => 5,
				'teeny' => true,
				'media_buttons' => true,
					)
			);
			?>
            <div class="mainwp_creport_format_save_section">
                <div class="inner">
					<?php _e( 'Save Report Footer' ); ?>
					<input type="text" placeholder="<?php _e( 'Enter Report Footer Title' ); ?>" name="mainwp_creport_report_save_header" value=""/>
					<input type="button" format="F" ed-name="footer" class="button-primary mainwp_creport_report_save_format_btn" value="<?php _e( 'Save' ); ?>"/>
					<span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>                    
                </div>
                <div class="inner">
					<?php _e( 'Report Footer' ); ?>
                    <select name="mainwp_creport_report_insert_header_sle">
						<option value="0"><?php _e( 'Select a Report Body' ); ?></option>
						<?php
						foreach ( $footer_formats as $format ) {
							echo '<option value="' . $format->id . '">' . esc_html( $format->title ) . '</option>';
						}
						?>
                    </select>
					<input type="button" ed-name="footer" class="button-primary mainwp_creport_report_insert_format_btn" value="<?php _e( 'Insert' ); ?>"/>
					<input type="button" ed-name="footer" class="button-primary mainwp_creport_report_delete_format_btn" value="<?php _e( 'Delete' ); ?>"/>
					<span class="loading"><span class="status hidden-field"></span><img src="<?php echo $url_loader; ?>" class="hidden-field"></span>
                </div>
            </div>                
			<div style="background: #F5F5F5; padding: 5px; border-bottom: 1px Dashed #fff;"><a href="#" style="float: right" class="mainwp_creport_show_insert_tokens_book_lnk"><?php _e( 'Show Available Tokens' ); ?></a><div class="clearfix"></div></div>                          
            <div class="clearfix"></div>
			<?php self::gen_insert_tokens_box( 'footer', true, $client_tokens_values, $client_tokens, $website ); ?>
        </td> 
        </tr> 
		<?php
	}

	public static function gen_insert_tokens_box( $editor, $hide = false, $client_tokens_values, $client_tokens, $website ) {
		?>
		<div class="creport_format_insert_tokens_box <?php echo $hide ? 'hidden-field' : ''; ?>" editor="<?php echo $editor; ?>">
            <div class="creport_format_data_tokens">
                <div class="creport_format_group_nav top">
					<?php
					$visible = 'client';
					$nav_group = '';
					foreach ( self::$tokens_nav_top as $group => $group_title ) {
						$disabled = '';
						if ( ( ! 'sucuri' == self::$enabled_sucuri && $group) ||
								( ! 'ga' == self::$enabled_ga && $group) ||
								( ! 'piwik' == self::$enabled_piwik && $group) ||
								( ! 'aum' == self::$enabled_aum && $group) ||
								( ! (self::$enabled_woocomstatus && 'woocomstatus' == $group))
						) {
							$disabled = 'disabled';
						}

						$current = ($visible == $group) ? 'current' : '';
						$nav_group .= '<a href="#" group="' . $group . '" group-title="' . $group_title . '" class="creport_nav_group_lnk ' . $current . ' ' . $disabled . '">' . $group_title . '</a> | ';
					}
					$nav_group = rtrim( $nav_group, ' | ' );
					echo $nav_group;
					?>                
                </div>
				<?php
				$visible_group = $visible . '_tokens';
				foreach ( self::$stream_tokens as $group => $group_tokens ) {
					$enabled = true;
					$str_requires = '';
					if ( ! self::$enabled_sucuri && 'sucuri' == $group ) {
						$str_requires = 'Requires' . ' <a href="http://extensions.mainwp.com/product/mainwp-sucuri-extension/" title="MainWP Sucuri Extension">MainWP Sucuri Extension</a>';
						$enabled = false;
					} else if ( ! self::$enabled_ga && 'ga' == $group ) {
						$str_requires = 'Requires' . ' <a href="http://extensions.mainwp.com/product/mainwp-google-analytics-extension/" title="MainWP Google Analytics Extension">MainWP Google Analytics Extension</a>';
						$enabled = false;
					} else if ( ! self::$enabled_piwik && 'piwik' == $group ) {
						$str_requires = 'Requires' . ' <a href="http://extensions.mainwp.com/product/mainwp-piwik-extension/" title="MainWP Piwik Extension">MainWP Piwik Extension</a>';
						$enabled = false;
					} else if ( ! self::$enabled_aum && 'aum' == $group ) {
						$str_requires = 'Requires' . ' <a href="http://extensions.mainwp.com/product/advanced-uptime-monitor-extension/" title="Advanced Uptime Monitor Extension">Advanced Uptime Monitor Extension</a>';
						$enabled = false;
					} else if ( ! self::$enabled_woocomstatus && 'woocomstatus' == $group ) {
						$str_requires = 'Requires' . ' <a href="http://extensions.mainwp.com/product/mainwp-woocommerce-status-extension/" title="MainWP WooCommerce Status Extension">MainWP WooCommerce Status Extension</a>';
						$enabled = false;
					}
					if ( ! $enabled ) {
						?>             
						<div class="creport_format_group_data_tokens" group="<?php echo $group; ?>">
							<div class="mainwp_info-box" style="text-align: center"><?php echo $str_requires; ?></div>    
                        </div>     
						<?php
						continue;
					}

					foreach ( $group_tokens as $key => $tokens ) {
						if ( 'nav_group_tokens' == $key ) {
							continue; }
						?>
						<div class="creport_format_group_data_tokens <?php echo ($visible_group == $group . '_' . $key) ? 'current' : ''; ?>" group="<?php echo $group . '_' . $key; ?>">
							<?php
							if ( 'sucuri' == $group && 'sections' == $key ) {
								echo '<div class="mainwp_info-box">' . __( 'MainWP Sucuri Extensions version 0.0.6 is required. Previous version will show invalid data.' ) . '</div>';
							}
							?>             
                            <table>                                
								<?php
								if ( 'client' == $group && 'tokens' == $key && is_array( $client_tokens ) ) {
									if ( is_array( $client_tokens_values ) && count( $client_tokens_values ) > 0 ) {
										foreach ( $client_tokens_values as $token ) {
											echo '<tr><td><a href="#" token-value = "' . esc_attr( stripslashes( $token['token_value'] ) ) . '"class="creport_format_add_token">[' . esc_html( stripslashes( $token['token_name'] ) ) . ']</a></td>'
											. '<td class="creport_stream_token_desc">' . esc_html( stripslashes( $token['token_value'] ) ) . '</td>'
											. '</tr>';
										}
									} else if ( is_array( $client_tokens ) && count( $client_tokens ) > 0 ) {
										foreach ( $client_tokens as $token ) {
											echo '<tr><td><a href="#" token-value ="" class="creport_format_add_token">[' . esc_html( stripslashes( $token->token_name ) ) . ']</a></td>'
											. '<td class="creport_stream_token_desc">' . esc_html( stripslashes( $token->token_description ) ) . '</td>'
											. '</tr>';
										}
									}
								} else {
									foreach ( $tokens as $token ) {
										echo '<tr><td><a href="#" token-value ="" class="creport_format_add_token">[' . esc_html( stripslashes( $token['name'] ) ) . ']</a></td>'
										. '<td class="creport_stream_token_desc">' . esc_html( stripslashes( $token['desc'] ) ) . '</td>'
										. '</tr>';
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
				$visible = 'client';
				$visible_nav = 'tokens';
				foreach ( self::$stream_tokens as $group => $group_tokens ) {
					if ( ( ! self::$enabled_sucuri && 'sucuri' == $group) ||
							( ! self::$enabled_ga && 'ga' == $group) ||
							( ! self::$enabled_piwik && 'piwik' == $group) ||
							( ! self::$enabled_aum && 'aum' == $group) ||
							( ! self::$enabled_woocomstatus && 'woocomstatus' == $group)
					) {
						echo '<div class="creport_format_group_nav bottom" group="' . $group . '">&nbsp</div>';
						continue;
					}

					$nav_group_bottom = '';
					$group_title = self::$tokens_nav_top[ $group ];
					foreach ( $group_tokens['nav_group_tokens'] as $nav_key => $nav_value ) {
						$current_nav = ($visible . '_' . $visible_nav == $group . '_' . $nav_key) ? 'current' : '';
						$nav_group_bottom .= '<a href="#" group="' . $group . '_' . $nav_key . '" group-title="' . $group_title . '" group2-title="' . $nav_value . '" class="creport_nav_bottom_group_lnk ' . $current_nav . '">' . $nav_value . '</a> | ';
					}
					$nav_group_bottom = rtrim( $nav_group_bottom, ' | ' );
					$current = ($visible == $group) ? 'current' : '';
					echo '<div class="creport_format_group_nav bottom ' . $current . '" group="' . $group . '">' . $nav_group_bottom . '</div>';
				}
				$breadcrumb = '<a href="javascript:void(0)" class="group" >' . self::$tokens_nav_top[ $visible ] .
						'</a><span class="crp_content_group2 hidden-field"> > ' . '<a href="javascript:void(0)" class="group2">' .
						//self::$stream_tokens[$visible]['nav_group_tokens'][$visible_nav] .
						'</a></span>';
				?>    
                <div class="creport_format_nav_bottom_breadcrumb">
					<?php _e( 'You are currently here:' ) ?> <span><?php echo $breadcrumb; ?></span>
					<span class="mwp_creport_edit_client_tokens" style="float: right"><?php echo ! empty( $website ) ? '<a href="admin.php?page=managesites&id=' . $website['id'] . '">' . __( 'Edit Client Tokens' ) . '</a>' : '' ?></span>
                </div> 
            </div>         
        </div> 
		<?php
	}

	public function site_token( $website ) {
		global $wpdb;
		$tokens = MainWP_CReport_DB::get_instance()->get_tokens();

		$site_tokens = array();
		if ( $website ) {
			$site_tokens = MainWP_CReport_DB::get_instance()->get_site_tokens( $website->url ); }

		$html = '<div class="postbox"> 
                            <h3 class="mainwp_box_title"><span>Client Report Settings</span></h3>
                            <div class="inside">';
		if ( is_array( $tokens ) && count( $tokens ) > 0 ) {
			$html .= '<table class="form-table" style="width: 100%">';
			foreach ( $tokens as $token ) {
				if ( ! $token ) {
					continue; }
				$token_value = '';
				if ( isset( $site_tokens[ $token->id ] ) && $site_tokens[ $token->id ] ) {
					$token_value = stripslashes( $site_tokens[ $token->id ]->token_value ); }

				$input_name = 'creport_token_' . str_replace( array( '.', ' ', '-' ), '_', $token->token_name );
				$html .= '<tr>                      
                            <th scope="row" class="token-name" >[' . esc_html( stripslashes( $token->token_name ) ) . ']</th>
                            <td>                                        
                            <input type="text" value="' . esc_attr( $token_value ) . '" class="regular-text" name="' . esc_attr( $input_name ) . '"/>
                            </td>                           
                    </tr>';
			}
			$html .= '</table>';
		} else {
			$html .= 'Not found tokens.';
		}
		$html .= '<div class="mainwp_info-box"><strong><b>Note</b>: <i>Add or Edit Client Report Tokens in the <a target="_blank" href="' . admin_url( 'admin.php?page=Extensions-Mainwp-Client-Reports-Extension&action=token' ) . '">Client Report Extension Settings</a></i>.</strong></div>                                   
                </div></div>';
		echo $html;
	}

	public function update_site_update_tokens( $websiteId ) {
		global $wpdb, $mainWPCReportExtensionActivator;
		if ( isset( $_POST['submit'] ) ) {
			$website = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $websiteId );
			if ( $website && is_array( $website ) ) {
				$website = current( $website );
			}

			if ( ! is_array( $website ) ) {
				return; }

			$tokens = MainWP_CReport_DB::get_instance()->get_tokens();
			foreach ( $tokens as $token ) {
				$input_name = 'creport_token_' . str_replace( array( '.', ' ', '-' ), '_', $token->token_name );
				if ( isset( $_POST[ $input_name ] ) ) {
					$token_value = $_POST[ $input_name ];

					// default token
					//                    if ($token->type == 1 && empty($token_value))
					//                        continue;

					$current = MainWP_CReport_DB::get_instance()->get_tokens_by( 'id', $token->id, $website['url'] );
					if ( $current ) {
						MainWP_CReport_DB::get_instance()->update_token_site( $token->id, $token_value, $website['url'] );
					} else {
						MainWP_CReport_DB::get_instance()->add_token_site( $token->id, $token_value, $website['url'] );
					}
				}
			}
		}
	}

	public function delete_site_delete_tokens( $website ) {
		if ( $website ) {
			MainWP_CReport_DB::get_instance()->delete_site_tokens( $website->url );
		}
	}

	public function load_tokens() {
		$tokens = MainWP_CReport_DB::get_instance()->get_tokens();
		?>
        <div class="creport_list_tokens">
            <table width="100%">
                <tbody> 
					<?php
					if ( is_array( $tokens ) && count( $tokens ) > 0 ) {
						foreach ( (array) $tokens as $token ) {
							if ( ! $token ) {
								continue; }
							echo $this->create_token_item( $token );
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
							<span class="mainwp_more_loading"><img src="<?php echo MainWP_CReport_Extension::$plugin_url . 'images/loader.gif'; ?>"/></span>
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

		$site_id = isset( $_POST['siteId'] ) ? $_POST['siteId'] : 0;
		if ( $site_id ) {
			$website = null;
			global $mainWPCReportExtensionActivator;
			$website = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $site_id );
			if ( $website && is_array( $website ) ) {
				$website = current( $website );
			}

			if ( is_array( $website ) && isset( $website['url'] ) ) {
				$client_tokens = MainWP_CReport_DB::get_instance()->get_tokens();
				$client_tokens_values = array();
				$site_tokens = MainWP_CReport_DB::get_instance()->get_site_tokens( $website['url'] );
				foreach ( $client_tokens as $token ) {
					$client_tokens_values[ $token->token_name ] = array(
					'token_name' => $token->token_name,
						'token_value' => isset( $site_tokens[ $token->id ] ) ? $site_tokens[ $token->id ]->token_value : '',
					);
				}

				$html = '';
				$tokens = array();
				if ( count( $client_tokens_values ) > 0 ) {
					foreach ( $client_tokens_values as $token ) {
						$html .= '<tr><td><a href="#" token-value = "' . esc_attr( stripcslashes( $token['token_value'] ) ) . '"class="creport_format_add_token">[' . esc_html( stripcslashes( $token['token_name'] ) ) . ']</a></td>'
								. '<td class="creport_stream_token_desc">' . esc_html( stripcslashes( $token['token_value'] ) ) . '</td>'
								. '</tr>';
					}
					$tokens = array(
					'client.name' => $client_tokens_values['client.name']['token_value'],
						'client.contact.name' => $client_tokens_values['client.contact.name']['token_value'],
						'client.company' => $client_tokens_values['client.company']['token_value'],
						'client.email' => $client_tokens_values['client.email']['token_value'],
					);
				}

				die( json_encode( array( 'tokens' => $tokens, 'html_tokens' => $html ) ) );
			}
		}
		die( json_encode( 'EMPTY' ) );
	}

	public function get_format() {
		$format_id = isset( $_POST['formatId'] ) ? trim( $_POST['formatId'] ) : 0;
		$content = '';
		if ( $format_id ) {
			$format = MainWP_CReport_DB::get_instance()->get_format_by( 'id', $format_id );
			if ( $format ) {
				die(json_encode(array(
								'success' => true,
								'content' => stripslashes( $format->content ),
					)));
			}
		}
		die( json_encode( 'failed' ) );
	}

	public function save_format() {
		$title = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
		$content = isset( $_POST['content'] ) ? trim( $_POST['content'] ) : '';
		$type = isset( $_POST['type'] ) ? trim( $_POST['type'] ) : 'H';
		if ( ! empty( $title ) ) {
			$format = array( 'title' => $title, 'content' => $content, 'type' => $type );
			if ( MainWP_CReport_DB::get_instance()->updateformat( $format ) ) {
				die( 'success' ); }
		}
		die( 'failed' );
	}

	public function delete_format() {
		$format_id = isset( $_POST['formatId'] ) ? trim( $_POST['formatId'] ) : 0;
		$content = '';
		if ( $format_id ) {
			$deleted = MainWP_CReport_DB::get_instance()->delete_format_by( 'id', $format_id );
			if ( $deleted ) {
				die( json_encode( array( 'success' => true ) ) ); }
		}
		die( json_encode( 'failed' ) );
	}

	public function load_client() {
		if ( isset( $_POST['client'] ) ) {
			$client = MainWP_CReport_DB::get_instance()->get_client_by( 'client', $_POST['client'] );
			if ( ! empty( $client ) ) {
				$result = array(
				'clientid' => $client->clientid,
					'name' => $client->name,
					'company' => $client->company,
					'email' => $client->email,
				);
				die( json_encode( $result ) );
			}
		}
		die( json_encode( 'EMPTY' ) );
	}

	public function delete_token() {
		global $wpdb;
		$ret = array( 'success' => false );
		$token_id = intval( $_POST['token_id'] );
		if ( MainWP_CReport_DB::get_instance()->delete_token_by( 'id', $token_id ) ) {
			$ret['success'] = true;
		}
		echo json_encode( $ret );
		exit;
	}

	public function save_token() {
		global $wpdb;
		$return = array( 'success' => false, 'error' => '', 'message' => '' );
		$token_name = sanitize_text_field( $_POST['token_name'] );
		$token_name = trim( $token_name, '[]' );
		$token_description = sanitize_text_field( $_POST['token_description'] );

		// update
		if ( isset( $_POST['token_id'] ) && $token_id = intval( $_POST['token_id'] ) ) {
			$current = MainWP_CReport_DB::get_instance()->get_tokens_by( 'id', $token_id );
			if ( $current && $current->token_name == $token_name && $current->token_description == $token_description ) {
				$return['success'] = true;
				$return['message'] = __( 'The token does not change.' );
				$return['row_data'] = $this->create_token_item( $current, false );
			} else if ( ($current = MainWP_CReport_DB::get_instance()->get_tokens_by( 'token_name', $token_name )) && $current->id != $token_id ) {
				$return['error'] = __( 'The token name existed.' );
			} else if ( $token = MainWP_CReport_DB::get_instance()->update_token( $token_id, array( 'token_name' => $token_name, 'token_description' => $token_description ) ) ) {
				$return['success'] = true;
				$return['row_data'] = $this->create_token_item( $token, false );
			}
		} else { // add new
			if ( $current = MainWP_CReport_DB::get_instance()->get_tokens_by( 'token_name', $token_name ) ) {
				$return['error'] = __( 'The token name existed.' );
			} else {
				if ( $token = MainWP_CReport_DB::get_instance()->add_token( array( 'token_name' => $token_name, 'token_description' => $token_description, 'type' => 0 ) ) ) {
					$return['success'] = true;
					$return['row_data'] = $this->create_token_item( $token );
				} else {
					$return['error'] = __( 'Error: Add token failed.' ); }
			}
		}
		echo json_encode( $return );
		exit;
	}

	private function create_token_item( $token, $with_tr = true ) {
		$colspan = $html = '';
		if ( $token->type == 1 ) {
			$colspan = ' colspan="2" '; }
		if ( $with_tr ) {
			$html = '<tr class="managetoken-item" token_id="' . $token->id . '">'; }

		$html .= '<td class="token-name">                            
                    <span class="text" ' . (($token->type == 1) ? '' : 'value="' . $token->token_name) . '">[' . esc_html( stripslashes( $token->token_name ) ) . ']</span>' .
				(($token->type == 1) ? '' : '<span class="input hidden"><input type="text" value="' . esc_attr( stripslashes( $token->token_name ) ) . '" name="token_name"></span>') .
				'</td>        
                <td class="token-description" ' . $colspan . '>                            
                    <span class="text" ' . (($token->type == 1) ? '' : 'value="' . esc_attr( stripslashes( $token->token_description ) )) . '">' . esc_html( stripslashes( $token->token_description ) ) . '</span>';
		if ( $token->type != 1 ) {
			$html .= '<span class="input hidden"><input type="text" value="' . esc_attr( stripslashes( $token->token_description ) ) . '" name="token_description"></span>
                        <span class="mainwp_more_loading"><img src="' . MainWP_CReport_Extension::$plugin_url . 'images/loader.gif"/></span>';
		}
		$html .= '</td>';

		if ( $token->type == 0 ) {
			$html .= '<td class="token-option">
                    <span class="mainwp_group-actions actions-text" ><a class="creport_managetoken-edit" href="#">' . __( 'Edit', 'mainwp' ) . '</a> | <a class="creport_managetoken-delete" href="#">' . __( 'Delete', 'mainwp' ) . '</a></span>
                    <span class="mainwp_group-actions actions-input hidden" ><a class="creport_managetoken-save" href="#">' . __( 'Save', 'mainwp' ) . '</a> | <a class="creport_managetoken-cancel" href="#">' . __( 'Cancel', 'mainwp' ) . '</a></span>
                </td>';
		}
		if ( $with_tr ) {
			$html .= '</tr>'; }

		return $html;
	}

	public function delete_report() {
		global $wpdb;
		$ret = array();
		$id = intval( $_POST['reportId'] );
		if ( $id && MainWP_CReport_DB::get_instance()->delete_report_by( 'id', $id ) ) {
			$ret['status'] = 'success'; }
		echo json_encode( $ret );
		exit;
	}

	public function cancel_scheduled_report() {
		global $wpdb;
		$ret = array();
		$id = intval( $_POST['reportId'] );
		$update = array( 'id' => $id, 'scheduled' => 0, 'recurring_schedule' => '' );
		if ( $id && MainWP_CReport_DB::get_instance()->update_report( $update ) ) {
			$ret['status'] = 'success'; }
		echo json_encode( $ret );
		exit;
	}

	public static function client_reports_qsg() {
		$plugin_data = get_plugin_data( MAINWP_CLIENT_REPORTS_PLUGIN_FILE, false );
		$description = $plugin_data['Description'];
		$extraHeaders = array( 'DocumentationURI' => 'Documentation URI' );
		$file_data = get_file_data( MAINWP_CLIENT_REPORTS_PLUGIN_FILE, $extraHeaders );
		$documentation_url = $file_data['DocumentationURI'];
		?>
        <div  class="mainwp_ext_info_box" id="cs-pth-notice-box">
			<div class="mainwp-ext-description"><?php echo $description; ?></div><br/>
			<b><?php echo __( 'Need Help?' ); ?></b> <?php echo __( 'Review the Extension' ); ?> <a href="<?php echo $documentation_url; ?>" target="_blank"><i class="fa fa-book"></i> <?php echo __( 'Documentation' ); ?></a>. 
			<a href="#" id="mainwp-cr-quick-start-guide"><i class="fa fa-info-circle"></i> <?php _e( 'Show Quick Start Guide', 'mainwp' ); ?></a></div>
        <div  class="mainwp_ext_info_box" id="mainwp-cr-tips" style="color: #333!important; text-shadow: none!important;">
			<span><a href="#" class="mainwp-show-tut" number="1"><i class="fa fa-book"></i> <?php _e( 'Creating a Client Report', 'mainwp' ) ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="mainwp-show-tut"  number="2"><i class="fa fa-book"></i> <?php _e( 'Add Client Tokens', 'mainwp' ) ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="mainwp-show-tut"  number="3"><i class="fa fa-book"></i> <?php _e( 'Edit Client Tokens', 'mainwp' ) ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="mainwp-show-tut"  number="4"><i class="fa fa-book"></i> <?php _e( 'Insert Tokens in Client Report', 'mainwp' ) ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="mainwp-show-tut"  number="5"><i class="fa fa-book"></i> <?php _e( 'Client Report Tokens', 'mainwp' ) ?></a></span><span><a href="#" id="mainwp-cr-tips-dismiss" style="float: right;"><i class="fa fa-times-circle"></i> <?php _e( 'Dismiss', 'mainwp' ); ?></a></span>
            <div class="clear"></div>
            <div id="mainwp-cr-tuts">
                <div class="mainwp-cr-tut" number="1">
                    <h3>Creating a Client Report</h3>
                    <p>The MainWP Client Report Extension enables you to create reports for your client or for your own archive. It shows activity/changes on your child sites.</p>
                    <p>
                    <h3>Step 1: Select a Child Site</h3>
                    <p>On the New Report screen, on the right-hand side you can find the Select Sites box. The in the box you will see all your sites with the Stream plugin installed.</p>
                    <p>Select a site you want to generate the report for.</p>
                    <p>By selecting a site, the Client and the Send To form fields will be automatically populated in case you have previously entered values for the site in the Site Edit page. If you missed this step, please see here how to do that.</p>
                    </p>
                    <p>
                    <h3>Step 2: Client Report Settings</h3>
                    <ol>
                        <li>Enter a <strong>Report Title</strong> (Required).</li>
                        <li>Select a <strong>Date Range</strong> for the report (Required). The extension will generate report only with changes made in the selected period of time.</li>
                        <li>In the <strong>Send From</strong> fields enter your information (Optional). Enter your Name, Company and Email Address. It will be displayed in the Email sent to your clients.</li>
                        <li><strong>Client (Required).</strong> Here you can enter, if not added automatically by selecting a child site, a Client. The entered data will be displayed in the Reports list and it will enable you to filter reports by client.</li>
                        <li><strong>Send To (Required)</strong> If not populated by selecting a child site, enter here the Client Contact Name, Client's Company and email address for email to be sent to. (Email Address is required)</li>
                        <li><strong>Email Subject</strong>, here add a custom subject for the Report Email.</li>
                    </ol>
                    </p>
                    <p>
                    <h3>Step 3: Format Report</h3>
                    <p>A Report is splitted in 3 section. Header, Body and Footer.</p>
                    <p>By default, all three sections are collapsed, to start editing any of sections click the Show link (when you are done, you can hide it by clicking the Hide link).</p>
                    <p>In the text editor box, to format your report you are allowed to use custom text and tokens. Tokens are used to display report data, pulled from child site.</p>
                    <p>By combining tokens with custom text you will be able to customize the report and have it look like you want it.</p>
                    <p>Under each section edit box you will find mechanism to Save or Insert saved sections.</p>
                    <p>Once you create a Header, Body or Footer which you would like to use multiple times, you can save it by adding a custom title and clicking the Save button.</p>
                    <p>Next time you want to use the saved the saved section, you can select it from the Select box on the right hand side and click the Insert button.</p>
                    <br/>
                    <p><strong>After you are done with formatting your report, you have options to Preview Report, Send Test Email, Archive Report, Download PDF, Save Report and Send Report.</strong></p>
                    </p>
                </div>
                <div class="mainwp-cr-tut"  number="2">
                    <h3>Add Client Tokens</h3>
                    <p>
                    <ol>
                        <li>Click the Report Tokens tab<br/><br/>
                            <img src="http://docs.mainwp.com/wp-content/uploads/2014/06/cr-report-tokens-tab.png" style="wight: 100% !important;" alt="screenshot"/>
                        </li>
                        <li>
                            At the bottom, locate the empty fields<br/><br/>
                            <img src="http://docs.mainwp.com/wp-content/uploads/2014/06/cr-new-token-fields-1024x407.png" style="wight: 100% !important;" alt="screenshot"/>
                        </li>
                        <li>Enter a Token and Token Description.</li>
                        <li>
                            Click the Save button
                        </li>
                    </ol>
                    <p>To add custom values for the Token, you will need to go to the child site edit page and enter it.</p>
                    <p>After creating a new token it will be added in the Report Tokens section in the Child Site edit page and in the Insert Tokens section in the Report Format section.</p>
                    </p>
                </div>
                <div class="mainwp-cr-tut"  number="3">
                    <h3>Edit Client Tokens</h3>
                    <p>
                    <ol>
                        <li>Go to the Site Edit page</li>
                        <li>Scroll down until you see the Client Report Settings section</li>
                        <li>
                            Enter wanted values <br/><br/>
                            <img src="http://docs.mainwp.com/wp-content/uploads/2014/06/cr-client-report-settings-values-1024x715.png" style="wight: 100% !important;" alt="screenshot"/>
                        </li>
                        <li>Click the Update Site button</li>
                    </ol>
                    </p>
                </div>
                <div class="mainwp-cr-tut"  number="4">
                    <h3>Insert Tokens in Client Report</h3>
                    <p>Under the Header, Body and Footer sections in the Report Format area you can find the list of tokens which you can insert in your reports. Simply by clicking on a token it will be added to the edit box right in a place where you have your cursor placed.</p>
                    <img src="http://docs.mainwp.com/wp-content/uploads/2014/06/cr-insert-tokens-box.png" style="wight: 100% !important;" alt="screenshot"/>
                    <p>If you use section tokens, it will insert both, opening and closing tag.</p>
                    <p>If the Insert Tokens box is hidden, click the Show Available Tokens link to display the box.</p>
                    <img src="http://docs.mainwp.com/wp-content/uploads/2014/06/cr-show-available-tokens.png" style="wight: 100% !important;" alt="screenshot"/>
                    <p>Use the provided navigation system to toggle between different group of tokens.</p>
                    <img src="http://docs.mainwp.com/wp-content/uploads/2014/06/cr-tokens-nav.png" style="wight: 100% !important;" alt="screenshot"/>
                    <p>Upper navigation will enable you to toggle between different groups of tokens, and the lower part to toggle between available groups of tokens for the selected group in the upper part.</p>
                </div>
                <div class="mainwp-cr-tut"  number="5">
                    <h3>Client Report Tokens</h3>
                    <p>To properly use tokens in the MainWP Client Reports Extension, you have to know difference between SECTION, DATA and CLIENT tokens.</p>
                    <strong>SECTION TOKENS</strong>
                    <p>Section tokens require both opening and closing tags. They can easily be recognized by starting part 'section'. Section token loops through database and searches for right data.</p>
                    <strong>DATA TOKENS</strong>
                    <p>Data tokens have only one tag, they have to be used inside section tokens and have to be added between opening and closing tag of a section token. Special type of Data tokens are COUNTER TOKENS. You will be able to recognize this tokens by the first word. They end with ".count". This tokens won't work inside of the section tokens. You need to use them out of section tokens.</p>
                    <strong>CLIENT TOKENS</strong>
                    <p>This tokens will allow you to display data you have set in the Child Site edit screen. For each child site you should set the token values. After you set values you will easily display data for selected site in the report.</p>
                </div>
            </div>
        </div>
		<?php
	}
}
