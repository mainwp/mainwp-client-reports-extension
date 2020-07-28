<?php

class MainWP_CReport {

	private static $stream_tokens		 = array();
	private static $tokens_nav_top		 = array();
	private static $buffer				 = array();	
	public static $enabled_piwik		 = null;
	public static $enabled_sucuri		 = false;
	public static $enabled_ga			 = null;
	public static $enabled_aum			 = null;
	public static $enabled_woocomstatus	 = null;
	public static $enabled_wordfence	 = null;
	public static $enabled_maintenance	 = null;
	public static $enabled_pagespeed	 = null;
	public static $enabled_brokenlinks	 = null;
	private static $count_sec_header	 = 0;
	private static $count_sec_body		 = 0;
	private static $count_sec_footer	 = 0;
	private static $raw_sec_body		 = false;
	private static $raw_section_body	 = array();
	public $update_version				 = '1.0';
	static $retry_time					 = 2;

	public function __construct() {
		
	}

	public static function init() {
		self::$stream_tokens = array(
			'client'		 => array(
				'nav_group_tokens'	 => array(
					'tokens' => 'Tokens',
				),
				'tokens'			 => array(),
			),
			'plugins'		 => array(
				'sections'			 => array(
					array('name' => 'section.plugins.installed', 'desc' => 'Loops through Plugins Installed during the selected date range'),
					array('name' => 'section.plugins.activated', 'desc' => 'Loops through Plugins Activated during the selected date range'),
					array('name' => 'section.plugins.edited', 'desc' => 'Loops through Plugins Edited during the selected date range'),
					array('name' => 'section.plugins.deactivated', 'desc' => 'Loops through Plugins Deactivated during the selected date range'),
					array('name' => 'section.plugins.updated', 'desc' => 'Loops through Plugins Updated during the selected date range'),
					array('name' => 'section.plugins.deleted', 'desc' => 'Loops through Plugins Deleted during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'		 => 'Sections',
					'installed'		 => 'Installed',
					'activated'		 => 'Activated',
					'edited'		 => 'Edited',
					'deactivated'	 => 'Deactivated',
					'updated'		 => 'Updated',
					'deleted'		 => 'Deleted',
					'additional'	 => 'Additional',
				),
				'installed'			 => array(
					array('name' => 'plugin.name', 'desc' => 'Displays the Plugin Name'),
					array('name' => 'plugin.installed.date', 'desc' => 'Displays the Plugin Installation Date'),
					array('name' => 'plugin.installed.time', 'desc' => 'Displays the Plugin Installation Time'),
					array('name' => 'plugin.installed.author', 'desc' => 'Displays the User who Installed the Plugin'),
				),
				'activated'			 => array(
					array('name' => 'plugin.name', 'desc' => 'Displays the Plugin Name'),
					array('name' => 'plugin.activated.date', 'desc' => 'Displays the Plugin Activation Date'),
					array('name' => 'plugin.activated.time', 'desc' => 'Displays the Plugin Activation Time'),
					array('name' => 'plugin.activated.author', 'desc' => 'Displays the User who Activated the Plugin'),
				),
				'edited'			 => array(
					array('name' => 'plugin.name', 'desc' => 'Displays the Plugin Name'),
					array('name' => 'plugin.edited.date', 'desc' => 'Displays the Plugin Editing Date'),
					array('name' => 'plugin.edited.time', 'desc' => 'Displays the Plugin Editing time'),
					array('name' => 'plugin.edited.author', 'desc' => 'Displays the User who Edited the Plugin'),
				),
				'deactivated'		 => array(
					array('name' => 'plugin.name', 'desc' => 'Displays the Plugin Name'),
					array('name' => 'plugin.deactivated.date', 'desc' => 'Displays the Plugin Deactivation Date'),
					array('name' => 'plugin.deactivated.time', 'desc' => 'Displays the Plugin Deactivation Time'),
					array('name' => 'plugin.deactivated.author', 'desc' => 'Displays the User who Deactivated the Plugin'),
				),
				'updated'			 => array(
					array('name' => 'plugin.old.version', 'desc' => 'Displays the Plugin Version Before Update'),
					array('name' => 'plugin.current.version', 'desc' => 'Displays the Plugin Current Vesion'),
					array('name' => 'plugin.name', 'desc' => 'Displays the Plugin Name'),
					array('name' => 'plugin.updated.date', 'desc' => 'Displays the Plugin Update Date'),
					array('name' => 'plugin.updated.time', 'desc' => 'Displays the Plugin Update Time'),
					array('name' => 'plugin.updated.author', 'desc' => 'Displays the User who Updated the Plugin'),
				),
				'deleted'			 => array(
					array('name' => 'plugin.name', 'desc' => 'Displays the Plugin Name'),
					array('name' => 'plugin.deleted.date', 'desc' => 'Displays the Plugin Deleting Date'),
					array('name' => 'plugin.deleted.time', 'desc' => 'Displays the Plugin Deleting Time'),
					array('name' => 'plugin.deleted.author', 'desc' => 'Displays the User who Deleted the Plugin'),
				),
				'additional'		 => array(
					array('name' => 'plugin.installed.count', 'desc' => 'Displays the Number of Installed Plugins'),
					array('name' => 'plugin.edited.count', 'desc' => 'Displays the Number of Edited Plugins'),
					array('name' => 'plugin.activated.count', 'desc' => 'Displays the Number of Activated Plugins'),
					array('name' => 'plugin.deactivated.count', 'desc' => 'Displays the Number of Deactivated Plugins'),
					array('name' => 'plugin.deleted.count', 'desc' => 'Displays the Number of Deleted Plugins'),
					array('name' => 'plugin.updated.count', 'desc' => 'Displays the Number of Updated Plugins'),
				),
			),
			'themes'		 => array(
				'sections'			 => array(
					array('name' => 'section.themes.installed', 'desc' => 'Loops through Themes Installed during the selected date range'),
					array('name' => 'section.themes.activated', 'desc' => 'Loops through Themes Activated during the selected date range'),
					array('name' => 'section.themes.edited', 'desc' => 'Loops through Themes Edited during the selected date range'),
					array('name' => 'section.themes.updated', 'desc' => 'Loops through Themes Updated during the selected date range'),
					array('name' => 'section.themes.deleted', 'desc' => 'Loops through Themes Deleted during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'installed'	 => 'Installed',
					'activated'	 => 'Activated',
					'edited'	 => 'Edited',
					'updated'	 => 'Updated',
					'deleted'	 => 'Deleted',
					'additional' => 'Additional',
				),
				'installed'			 => array(
					array('name' => 'theme.name', 'desc' => 'Displays the Theme Name'),
					array('name' => 'theme.installed.date', 'desc' => 'Displays the Theme Installation Date'),
					array('name' => 'theme.installed.time', 'desc' => 'Displays the Theme Installation Time'),
					array('name' => 'theme.installed.author', 'desc' => 'Displays the User who Installed the Theme'),
				),
				'activated'			 => array(
					array('name' => 'theme.name', 'desc' => 'Displays the Theme Name'),
					array('name' => 'theme.activated.date', 'desc' => 'Displays the Theme Activation Date'),
					array('name' => 'theme.activated.time', 'desc' => 'Displays the Theme Activation Time'),
					array('name' => 'theme.activated.author', 'desc' => 'Displays the User who Activated the Theme'),
				),
				'edited'			 => array(
					array('name' => 'theme.name', 'desc' => 'Displays the Theme Name'),
					array('name' => 'theme.edited.date', 'desc' => 'Displays the Theme Editing Date'),
					array('name' => 'theme.edited.time', 'desc' => 'Displays the Theme Editing Time'),
					array('name' => 'theme.edited.author', 'desc' => 'Displays the User who Edited the Theme'),
				),
				'updated'			 => array(
					array('name' => 'theme.old.version', 'desc' => 'Displays the Theme Version Before Update'),
					array('name' => 'theme.current.version', 'desc' => 'Displays the Theme Current Version'),
					array('name' => 'theme.name', 'desc' => 'Displays the Theme Name'),
					array('name' => 'theme.updated.date', 'desc' => 'Displays the Theme Update Date'),
					array('name' => 'theme.updated.time', 'desc' => 'Displays the Theme Update Time'),
					array('name' => 'theme.updated.author', 'desc' => 'Displays the User who Updated the Theme'),
				),
				'deleted'			 => array(
					array('name' => 'theme.name', 'desc' => 'Displays the Theme Name'),
					array('name' => 'theme.deleted.date', 'desc' => 'Displays the Theme Deleting Date'),
					array('name' => 'theme.deleted.time', 'desc' => 'Displays the Theme Deleting Time'),
					array('name' => 'theme.deleted.author', 'desc' => 'Displays the User who Deleted the Theme'),
				),
				'additional'		 => array(
					array('name' => 'theme.installed.count', 'desc' => 'Displays the Number of Installed Themes'),
					array('name' => 'theme.edited.count', 'desc' => 'Displays the Number of Edited Themes'),
					array('name' => 'theme.activated.count', 'desc' => 'Displays the Number of Activated Themes'),
					array('name' => 'theme.deleted.count', 'desc' => 'Displays the Number of Deleted Themes'),
					array('name' => 'theme.updated.count', 'desc' => 'Displays the Number of Updated Themes'),
				),
			),
			'posts'			 => array(
				'sections'			 => array(
					array('name' => 'section.posts.created', 'desc' => 'Loops through Posts Created during the selected date range'),
					array('name' => 'section.posts.updated', 'desc' => 'Loops through Posts Updated during the selected date range'),
					array('name' => 'section.posts.trashed', 'desc' => 'Loops through Posts Trashed during the selected date range'),
					array('name' => 'section.posts.deleted', 'desc' => 'Loops through Posts Deleted during the selected date range'),
					array('name' => 'section.posts.restored', 'desc' => 'Loops through Posts Restored during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'created'	 => 'Created',
					'updated'	 => 'Updated',
					'trashed'	 => 'Trashed',
					'deleted'	 => 'Deleted',
					'restored'	 => 'Restored',
					'additional' => 'Additional',
				),
				'created'			 => array(
					array('name' => 'post.title', 'desc' => 'Displays the Post Title'),
					array('name' => 'post.created.date', 'desc' => 'Displays the Post Creation Date'),
					array('name' => 'post.created.time', 'desc' => 'Displays the Post Creation Time'),
					array('name' => 'post.created.author', 'desc' => 'Displays the User who Created the Post'),
				),
				'updated'			 => array(
					array('name' => 'post.title', 'desc' => 'Displays the Post Title'),
					array('name' => 'post.updated.date', 'desc' => 'Displays the Post Update Date'),
					array('name' => 'post.updated.time', 'desc' => 'Displays the Post Update Time'),
					array('name' => 'post.updated.author', 'desc' => 'Displays the User who Updated the Post'),
				),
				'trashed'			 => array(
					array('name' => 'post.title', 'desc' => 'Displays the Post Title'),
					array('name' => 'post.trashed.date', 'desc' => 'Displays the Post Trashing Date'),
					array('name' => 'post.trashed.time', 'desc' => 'Displays the Post Trashing Time'),
					array('name' => 'post.trashed.author', 'desc' => 'Displays the User who Trashed the Post'),
				),
				'deleted'			 => array(
					array('name' => 'post.title', 'desc' => 'Displays the Post Title'),
					array('name' => 'post.deleted.date', 'desc' => 'Displays the Post Deleting Date'),
					array('name' => 'post.deleted.time', 'desc' => 'Displays the Post Deleting Time'),
					array('name' => 'post.deleted.author', 'desc' => 'Displays the User who Deleted the Post'),
				),
				'restored'			 => array(
					array('name' => 'post.title', 'desc' => 'Displays Post Title'),
					array('name' => 'post.restored.date', 'desc' => 'Displays the Post Restoring Date'),
					array('name' => 'post.restored.time', 'desc' => 'Displays the Post Restoring Time'),
					array('name' => 'post.restored.author', 'desc' => 'Displays the User who Restored the Post'),
				),
				'additional'		 => array(
					array('name' => 'post.created.count', 'desc' => 'Displays the Number of Created Posts'),
					array('name' => 'post.updated.count', 'desc' => 'Displays the Number of Updated Posts'),
					array('name' => 'post.trashed.count', 'desc' => 'Displays the Number of Trashed Posts'),
					array('name' => 'post.restored.count', 'desc' => 'Displays the Number of Restored Posts'),
					array('name' => 'post.deleted.count', 'desc' => 'Displays the Number of Deleted Posts'),
				),
			),
			'pages'			 => array(
				'sections'			 => array(
					array('name' => 'section.pages.created', 'desc' => 'Loops through Pages Created during the selected date range'),
					array('name' => 'section.pages.updated', 'desc' => 'Loops through Pages Updated during the selected date range'),
					array('name' => 'section.pages.trashed', 'desc' => 'Loops through Pages Trashed during the selected date range'),
					array('name' => 'section.pages.deleted', 'desc' => 'Loops through Pages Deleted during the selected date range'),
					array('name' => 'section.pages.restored', 'desc' => 'Loops through Pages Restored during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'created'	 => 'Created',
					'updated'	 => 'Updated',
					'trashed'	 => 'Trashed',
					'deleted'	 => 'Deleted',
					'restored'	 => 'Restored',
					'additional' => 'Additional',
				),
				'created'			 => array(
					array('name' => 'page.title', 'desc' => 'Displays the Page Title'),
					array('name' => 'page.created.date', 'desc' => 'Displays the Page Createion Date'),
					array('name' => 'page.created.time', 'desc' => 'Displays the Page Createion Time'),
					array('name' => 'page.created.author', 'desc' => 'Displays the User who Created the Page'),
				),
				'updated'			 => array(
					array('name' => 'page.title', 'desc' => 'Displays the Page Title'),
					array('name' => 'page.updated.date', 'desc' => 'Displays the Page Updating Date'),
					array('name' => 'page.updated.time', 'desc' => 'Displays the Page Updating Time'),
					array('name' => 'page.updated.author', 'desc' => 'Displays the User who Updated the Page'),
				),
				'trashed'			 => array(
					array('name' => 'page.title', 'desc' => 'Displays the Page Title'),
					array('name' => 'page.trashed.date', 'desc' => 'Displays the Page Trashing Date'),
					array('name' => 'page.trashed.time', 'desc' => 'Displays the Page Trashing Time'),
					array('name' => 'page.trashed.author', 'desc' => 'Displays the User who Trashed the Page'),
				),
				'deleted'			 => array(
					array('name' => 'page.title', 'desc' => 'Displays the Page Title'),
					array('name' => 'page.deleted.date', 'desc' => 'Displays the Page Deleting Date'),
					array('name' => 'page.deleted.time', 'desc' => 'Displays the Page Deleting Time'),
					array('name' => 'page.deleted.author', 'desc' => 'Displays the User who Deleted the Page'),
				),
				'restored'			 => array(
					array('name' => 'page.title', 'desc' => 'Displays the Page Title'),
					array('name' => 'page.restored.date', 'desc' => 'Displays the Page Restoring Date'),
					array('name' => 'page.restored.time', 'desc' => 'Displays the Page Restoring Time'),
					array('name' => 'page.restored.author', 'desc' => 'Displays the User who Restored the Page'),
				),
				'additional'		 => array(
					array('name' => 'page.created.count', 'desc' => 'Displays the Number of Created Pages'),
					array('name' => 'page.updated.count', 'desc' => 'Displays the Number of Updated Pages'),
					array('name' => 'page.trashed.count', 'desc' => 'Displays the Number of Trashed Pages'),
					array('name' => 'page.restored.count', 'desc' => 'Displays the Number of Restored Pages'),
					array('name' => 'page.deleted.count', 'desc' => 'Displays the Number of Deleted Pages'),
				),
			),
			'comments'		 => array(
				'sections'			 => array(
					array('name' => 'section.comments.created', 'desc' => 'Loops through Comments Created during the selected date range'),
					array('name' => 'section.comments.updated', 'desc' => 'Loops through Comments Updated during the selected date range'),
					array('name' => 'section.comments.trashed', 'desc' => 'Loops through Comments Trashed during the selected date range'),
					array('name' => 'section.comments.deleted', 'desc' => 'Loops through Comments Deleted during the selected date range'),
					array('name' => 'section.comments.edited', 'desc' => 'Loops through Comments Edited during the selected date range'),
					array('name' => 'section.comments.restored', 'desc' => 'Loops through Comments Restored during the selected date range'),
					array('name' => 'section.comments.approved', 'desc' => 'Loops through Comments Approved during the selected date range'),
					array('name' => 'section.comments.spam', 'desc' => 'Loops through Comments Spammed during the selected date range'),
					array('name' => 'section.comments.replied', 'desc' => 'Loops through Comments Replied during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'created'	 => 'Created',
					'updated'	 => 'Updated',
					'trashed'	 => 'Trashed',
					'deleted'	 => 'Deleted',
					'edited'	 => 'Edited',
					'restored'	 => 'Restored',
					'approved'	 => 'Approved',
					'spam'		 => 'Spam',
					'replied'	 => 'Replied',
					'additional' => 'Additional',
				),
				'created'			 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Created'),
					array('name' => 'comment.created.date', 'desc' => 'Displays the Comment Creating Date'),
					array('name' => 'comment.created.time', 'desc' => 'Displays the Comment Creating Time'),
					array('name' => 'comment.created.author', 'desc' => 'Displays the User who Created the Comment'),
				),
				'updated'			 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Updated'),
					array('name' => 'comment.updated.date', 'desc' => 'Displays the Comment Updating Date'),
					array('name' => 'comment.updated.time', 'desc' => 'Displays the Comment Updating Time'),
					array('name' => 'comment.updated.author', 'desc' => 'Displays the User who Updated the Comment'),
				),
				'trashed'			 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Trashed'),
					array('name' => 'comment.trashed.date', 'desc' => 'Displays the Comment Trashing Date'),
					array('name' => 'comment.trashed.time', 'desc' => 'Displays the Comment Trashing Time'),
					array('name' => 'comment.trashed.author', 'desc' => 'Displays the User who Trashed the Comment'),
				),
				'deleted'			 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Deleted'),
					array('name' => 'comment.deleted.date', 'desc' => 'Displays the Comment Deleting Date'),
					array('name' => 'comment.deleted.time', 'desc' => 'Displays the Comment Deleting Time'),
					array('name' => 'comment.deleted.author', 'desc' => 'Displays the User who Deleted the Comment'),
				),
				'edited'			 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Edited'),
					array('name' => 'comment.edited.date', 'desc' => 'Displays the Comment Editing Date'),
					array('name' => 'comment.edited.time', 'desc' => 'Displays the Comment Editing Time'),
					array('name' => 'comment.edited.author', 'desc' => 'Displays the User who Edited the Comment'),
				),
				'restored'			 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Restored'),
					array('name' => 'comment.restored.date', 'desc' => 'Displays the Comment Restoring Date'),
					array('name' => 'comment.restored.time', 'desc' => 'Displays the Comment Restoring Time'),
					array('name' => 'comment.restored.author', 'desc' => 'Displays the User who Restored the Comment'),
				),
				'approved'			 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Approved'),
					array('name' => 'comment.approved.date', 'desc' => 'Displays the Comment Approving Date'),
					array('name' => 'comment.approved.time', 'desc' => 'Displays the Comment Approving Time'),
					array('name' => 'comment.approved.author', 'desc' => 'Displays the User who Approved the Comment'),
				),
				'spam'				 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Spammed'),
					array('name' => 'comment.spam.date', 'desc' => 'Displays the Comment Spamming Date'),
					array('name' => 'comment.spam.time', 'desc' => 'Displays the Comment Spamming Time'),
					array('name' => 'comment.spam.author', 'desc' => 'Displays the User who Spammed the Comment'),
				),
				'replied'			 => array(
					array('name' => 'comment.title', 'desc' => 'Displays the Title of the Post or the Page where the Comment is Replied'),
					array('name' => 'comment.replied.date', 'desc' => 'Displays the Comment Replying Date'),
					array('name' => 'comment.replied.time', 'desc' => 'Displays the Comment Replying Time'),
					array('name' => 'comment.replied.author', 'desc' => 'Displays the User who Replied the Comment'),
				),
				'additional'		 => array(
					array('name' => 'comment.created.count', 'desc' => 'Displays the Number of Created Comments'),
					array('name' => 'comment.trashed.count', 'desc' => 'Displays the Number of Trashed Comments'),
					array('name' => 'comment.deleted.count', 'desc' => 'Displays the Number of Deleted Comments'),
					array('name' => 'comment.edited.count', 'desc' => 'Displays the Number of Edited Comments'),
					array('name' => 'comment.restored.count', 'desc' => 'Displays the Number of Restored Comments'),
					array('name' => 'comment.deleted.count', 'desc' => 'Displays the Number of Deleted Comments'),
					array('name' => 'comment.approved.count', 'desc' => 'Displays the Number of Approved Comments'),
					array('name' => 'comment.spam.count', 'desc' => 'Displays the Number of Spammed Comments'),
					array('name' => 'comment.replied.count', 'desc' => 'Displays the Number of Replied Comments'),
				),
			),
			'users'			 => array(
				'sections'			 => array(
					array('name' => 'section.users.created', 'desc' => 'Loops through Users Created during the selected date range'),
					array('name' => 'section.users.updated', 'desc' => 'Loops through Users Updated during the selected date range'),
					array('name' => 'section.users.deleted', 'desc' => 'Loops through Users Deleted during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'created'	 => 'Created',
					'updated'	 => 'Updated',
					'deleted'	 => 'Deleted',
					'additional' => 'Additional',
				),
				'created'			 => array(
					array('name' => 'user.name', 'desc' => 'Displays the User Name'),
					array('name' => 'user.created.date', 'desc' => 'Displays the User Creation Date'),
					array('name' => 'user.created.time', 'desc' => 'Displays the User Creation Time'),
					array('name' => 'user.created.author', 'desc' => 'Displays the User who Created the new User'),
					array('name' => 'user.created.role', 'desc' => 'Displays the Role of the Created User'),
				),
				'updated'			 => array(
					array('name' => 'user.name', 'desc' => 'Displays the User Name'),
					array('name' => 'user.updated.date', 'desc' => 'Displays the User Updating Date'),
					array('name' => 'user.updated.time', 'desc' => 'Displays the User Updating Time'),
					array('name' => 'user.updated.author', 'desc' => 'Displays the User who Updated the new User'),
					array('name' => 'user.updated.role', 'desc' => 'Displays the Role of the Updated User'),
				),
				'deleted'			 => array(
					array('name' => 'user.name', 'desc' => 'Displays the User Name'),
					array('name' => 'user.deleted.date', 'desc' => 'Displays the User Deleting Date'),
					array('name' => 'user.deleted.time', 'desc' => 'Displays the User Deleting Time'),
					array('name' => 'user.deleted.author', 'desc' => 'Displays the User who Deleted the new User'),
				),
				'additional'		 => array(
					array('name' => 'user.created.count', 'desc' => 'Displays the Number of Created Users'),
					array('name' => 'user.updated.count', 'desc' => 'Displays the Number of Updated Users'),
					array('name' => 'user.deleted.count', 'desc' => 'Displays the Number of Deleted Users'),
				),
			),
			'media'			 => array(
				'sections'			 => array(
					array('name' => 'section.media.uploaded', 'desc' => 'Loops through Media Uploaded during the selected date range'),
					array('name' => 'section.media.updated', 'desc' => 'Loops through Media Updated during the selected date range'),
					array('name' => 'section.media.deleted', 'desc' => 'Loops through Media Deleted during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'uploaded'	 => 'Uploaded',
					'updated'	 => 'Updated',
					'deleted'	 => 'Deleted',
					'additional' => 'Additional',
				),
				'uploaded'			 => array(
					array('name' => 'media.name', 'desc' => 'Displays the Media Name'),
					array('name' => 'media.uploaded.date', 'desc' => 'Displays the Media Uploading Date'),
					array('name' => 'media.uploaded.time', 'desc' => 'Displays the Media Uploading Time'),
					array('name' => 'media.uploaded.author', 'desc' => 'Displays the User who Uploaded the Media File'),
				),
				'updated'			 => array(
					array('name' => 'media.name', 'desc' => 'Displays the Media Name'),
					array('name' => 'media.updated.date', 'desc' => 'Displays the Media Updating Date'),
					array('name' => 'media.updated.time', 'desc' => 'Displays the Media Updating Time'),
					array('name' => 'media.updated.author', 'desc' => 'Displays the User who Updted the Media File'),
				),
				'deleted'			 => array(
					array('name' => 'media.name', 'desc' => 'Displays the Media Name'),
					array('name' => 'media.deleted.date', 'desc' => 'Displays the Media Deleting Date'),
					array('name' => 'media.deleted.time', 'desc' => 'Displays the Media Deleting Time'),
					array('name' => 'media.deleted.author', 'desc' => 'Displays the User who Deleted the Media File'),
				),
				'additional'		 => array(
					array('name' => 'media.uploaded.count', 'desc' => 'Displays the Number of Uploaded Media Files'),
					array('name' => 'media.updated.count', 'desc' => 'Displays the Number of Updated Media Files'),
					array('name' => 'media.deleted.count', 'desc' => 'Displays the Number of Deleted Media Files'),
				),
			),
			'widgets'		 => array(
				'sections'			 => array(
					array('name' => 'section.widgets.added', 'desc' => 'Loops through Widgets Added during the selected date range'),
					array('name' => 'section.widgets.updated', 'desc' => 'Loops through Widgets Updated during the selected date range'),
					array('name' => 'section.widgets.deleted', 'desc' => 'Loops through Widgets Deleted during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'added'		 => 'Added',
					'updated'	 => 'Updated',
					'deleted'	 => 'Deleted',
					'additional' => 'Additional',
				),
				'added'				 => array(
					array('name' => 'widget.title', 'desc' => 'Displays the Widget Title'),
					array('name' => 'widget.added.area', 'desc' => 'Displays the Widget Adding Area'),
					array('name' => 'widget.added.date', 'desc' => 'Displays the Widget Adding Date'),
					array('name' => 'widget.added.time', 'desc' => 'Displays the Widget Adding Time'),
					array('name' => 'widget.added.author', 'desc' => 'Displays the User who Added the Widget'),
				),
				'updated'			 => array(
					array('name' => 'widget.title', 'desc' => 'Displays the Widget Name'),
					array('name' => 'widget.updated.area', 'desc' => 'Displays the Widget Updating Area'),
					array('name' => 'widget.updated.date', 'desc' => 'Displays the Widget Updating Date'),
					array('name' => 'widget.updated.time', 'desc' => 'Displays the Widget Updating Time'),
					array('name' => 'widget.updated.author', 'desc' => 'Displays the User who Updated the Widget'),
				),
				'deleted'			 => array(
					array('name' => 'widget.title', 'desc' => 'Displays the Widget Name'),
					array('name' => 'widget.deleted.area', 'desc' => 'Displays the Widget Deleting Area'),
					array('name' => 'widget.deleted.date', 'desc' => 'Displays the Widget Deleting Date'),
					array('name' => 'widget.deleted.time', 'desc' => 'Displays the Widget Deleting Time'),
					array('name' => 'widget.deleted.author', 'desc' => 'Displays the User who Deleted the Widget'),
				),
				'additional'		 => array(
					array('name' => 'widget.added.count', 'desc' => 'Displays the Number of Added Widgets'),
					array('name' => 'widget.updated.count', 'desc' => 'Displays the Number of Updated Widgets'),
					array('name' => 'widget.deleted.count', 'desc' => 'Displays the Number of Deleted Widgets'),
				),
			),
			'menus'			 => array(
				'sections'			 => array(
					array('name' => 'section.menus.created', 'desc' => 'Loops through Menus Created during the selected date range'),
					array('name' => 'section.menus.updated', 'desc' => 'Loops through Menus Updated during the selected date range'),
					array('name' => 'section.menus.deleted', 'desc' => 'Loops through Menus Deleted during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'created'	 => 'Created',
					'updated'	 => 'Updated',
					'deleted'	 => 'Deleted',
					'additional' => 'Additional',
				),
				'created'			 => array(
					array('name' => 'menu.title', 'desc' => 'Displays the Menu Name'),
					array('name' => 'menu.created.date', 'desc' => 'Displays the Menu Creation Date'),
					array('name' => 'menu.created.time', 'desc' => 'Displays the Menu Creation Time'),
					array('name' => 'menu.created.author', 'desc' => 'Displays the User who Created the Menu'),
				),
				'updated'			 => array(
					array('name' => 'menu.title', 'desc' => 'Displays the Menu Name'),
					array('name' => 'menu.updated.date', 'desc' => 'Displays the Menu Updating Date'),
					array('name' => 'menu.updated.time', 'desc' => 'Displays the Menu Updating Time'),
					array('name' => 'menu.updated.author', 'desc' => 'Displays the User who Updated the Menu'),
				),
				'deleted'			 => array(
					array('name' => 'menu.title', 'desc' => 'Displays the Menu Name'),
					array('name' => 'menu.deleted.date', 'desc' => 'Displays the Menu Deleting Date'),
					array('name' => 'menu.deleted.time', 'desc' => 'Displays the Menu Deleting Time'),
					array('name' => 'menu.deleted.author', 'desc' => 'Displays the User who Deleted the Menu'),
				),
				'additional'		 => array(
					array('name' => 'menu.created.count', 'desc' => 'Displays the Number of Created Menus'),
					array('name' => 'menu.updated.count', 'desc' => 'Displays the Number of Updated Menus'),
					array('name' => 'menu.deleted.count', 'desc' => 'Displays the Number of Deleted Menus'),
				),
			),
			'wordpress'		 => array(
				'sections'			 => array(
					array('name' => 'section.wordpress.updated', 'desc' => 'Loops through WordPress Updates during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'updated'	 => 'Updated',
					'additional' => 'Additional',
				),
				'updated'			 => array(
					array('name' => 'wordpress.updated.date', 'desc' => 'Displays the WordPress Update Date'),
					array('name' => 'wordpress.updated.time', 'desc' => 'Displays the WordPress Update Time'),
					array('name' => 'wordpress.updated.author', 'desc' => 'Displays the User who Updated the Site'),
				),
				'additional'		 => array(
					array('name' => 'wordpress.old.version', 'desc' => 'Displays the WordPress Version Before Update'),
					array('name' => 'wordpress.current.version', 'desc' => 'Displays the Current WordPress Version'),
					array('name' => 'wordpress.updated.count', 'desc' => 'Displays the Number of WordPress Updates'),
				),
			),
			'backups'		 => array(
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'created'	 => 'Created',
					'additional' => 'Additional',
				),
				'sections'			 => array(
					array('name' => 'section.backups.created', 'desc' => ' Loops through Backups Created during the selected date range'),
				),
				'created'			 => array(
					array('name' => 'backup.created.type', 'desc' => ' Displays the Created Backup type (Full or Database)'),
					array('name' => 'backup.created.date', 'desc' => 'Displays the Backups Creation Date'),
					array('name' => 'backup.created.time', 'desc' => 'Displays the Backups Creation Time'),
				//array("name" => "backup.created.destination", "desc" => "Displays the Created Backup destination")
				),
				'additional'		 => array(
					array('name' => 'backup.created.count', 'desc' => 'Displays the number of created backups during the selected date range'),
				),
			),
			'report'		 => array(
				'nav_group_tokens'	 => array('report' => 'Report'),
				'report'			 => array(
					array('name' => 'report.daterange', 'desc' => 'Displays the report date range'),
					array('name' => 'report.send.date', 'desc' => 'Displays the report send date'),
				),
			),
			'sucuri'		 => array(
				'sections'			 => array(
					array('name' => 'section.sucuri.checks', 'desc' => 'Loops through Security Checks during the selected date range'),
				),
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'check'		 => 'Checks',
					'additional' => 'Additional',
				),
				'check'				 => array(
					array('name' => 'sucuri.check.date', 'desc' => 'Displays the Security Check date'),
					array('name' => 'sucuri.check.time', 'desc' => 'Displays the Security Check time'),
					array('name' => 'sucuri.check.status', 'desc' => 'Displays the Status info for the Child Site'),
					array('name' => 'sucuri.check.webtrust', 'desc' => 'Displays the Webtrust info for the Child Site'),
				//array("name" => "sucuri.check.results", "desc" => "Displays the Security Check details from the Security Scan Report"),
				),
				'additional'		 => array(
					array('name' => 'sucuri.checks.count', 'desc' => 'Displays the number of performed security checks during the selected date range'),
				),
			),
			'ga'			 => array(
				'nav_group_tokens'	 => array(
					'ga' => 'GA',
				),
				'ga'				 => array(
					array('name' => 'ga.visits', 'desc' => 'Displays the Number Visits during the selected date range'),
					array('name' => 'ga.pageviews', 'desc' => 'Displays the Number of Page Views during the selected date range'),
					array('name' => 'ga.pages.visit', 'desc' => 'Displays the Number of Page visit during the selected date range'),
					array('name' => 'ga.bounce.rate', 'desc' => 'Displays the Bounce Rate during the selected date range'),
					array('name' => 'ga.avg.time', 'desc' => 'Displays the Average Visit Time during the selected date range'),
					array('name' => 'ga.new.visits', 'desc' => 'Displays the Number of New Visits during the selected date range'),
					array('name' => 'ga.visits.chart', 'desc' => 'Displays a chart for the activity over the past month'),
					array('name' => 'ga.visits.maximum', 'desc' => "Displays the maximum visitor number and it's day within the past month"),
					array('name' => 'ga.startdate', 'desc' => 'Displays the startdate for the chart'),
					array('name' => 'ga.enddate', 'desc' => 'Displays the enddate or the chart'),
				),
			),
			'piwik'			 => array(
				'nav_group_tokens'	 => array(
					'piwik' => 'Piwik',
				),
				'piwik'				 => array(
					array('name' => 'piwik.visits', 'desc' => 'Displays the Number Visits during the selected date range'),
					array('name' => 'piwik.pageviews', 'desc' => 'Displays the Number of Page Views during the selected date range'),
					array('name' => 'piwik.pages.visit', 'desc' => 'Displays the Number of Page visit during the selected date range'),
					array('name' => 'piwik.bounce.rate', 'desc' => 'Displays the Bounce Rate during the selected date range'),
					array('name' => 'piwik.avg.time', 'desc' => 'Displays the Average Visit Time during the selected date range'),
					array('name' => 'piwik.new.visits', 'desc' => 'Displays the Number of New Visits during the selected date range'),
				),
			),
			'aum'			 => array(
				'nav_group_tokens'	 => array(
					'aum' => 'AUM',
				),
				'aum'				 => array(
					array('name' => 'aum.alltimeuptimeratio', 'desc' => 'Displays the Uptime ratio from the moment the monitor has been created'),
					array('name' => 'aum.uptime7', 'desc' => 'Displays the Uptime ratio for last 7 days'),
					array('name' => 'aum.uptime15', 'desc' => 'Displays the Uptime ration for last 15 days'),
					array('name' => 'aum.uptime30', 'desc' => 'Displays the Uptime ration for last 30 days'),
					array('name' => 'aum.uptime45', 'desc' => 'Displays the Uptime ration for last 45 days'),
					array('name' => 'aum.uptime60', 'desc' => 'Displays the Uptime ration for last 60 days'),
					array('name' => 'aum.stats', 'desc' => 'Displays the Uptime Statistics'),
				),
			),
			'woocomstatus'	 => array(
				'nav_group_tokens'	 => array(
					'woocomstatus' => 'WooCommerce Status',
				),
				'woocomstatus'		 => array(
					array('name' => 'wcomstatus.sales', 'desc' => 'Displays total sales during the selected data range'),
					array('name' => 'wcomstatus.topseller', 'desc' => 'Displays the top seller product during the selected data range'),
					array('name' => 'wcomstatus.awaitingprocessing', 'desc' => 'Displays the number of products currently awaiting for processing'),
					array('name' => 'wcomstatus.onhold', 'desc' => 'Displays the number of orders currently on hold'),
					array('name' => 'wcomstatus.lowonstock', 'desc' => 'Displays the number of products currently low on stock'),
					array('name' => 'wcomstatus.outofstock', 'desc' => 'Displays the number of products currently out of stock'),
				),
			),
			'wordfence'		 => array(
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'scan'		 => 'Scan',
					'additional' => 'Additional',
				),
				'sections'			 => array(
					array('name' => 'section.wordfence.scan', 'desc' => 'Loops through Wordfence scans during the selected date range'),
				),
				'scan'				 => array(
					array('name' => 'wordfence.scan.result', 'desc' => 'Displays the Wordfence scan result'),
					array('name' => 'wordfence.scan.date', 'desc' => 'Displays the Wordfence scan date'),
					array('name' => 'wordfence.scan.time', 'desc' => 'Displays the Wordfence scan time'),
					array('name' => 'wordfence.scan.details', 'desc' => 'Displays the Wordfence scan details'),
				),
				'additional'		 => array(
					array('name' => 'wordfence.scan.count', 'desc' => 'Displays the number of performed Wordfence scans during the selected date range'),
				),
			),
			'maintenance'	 => array(
				'nav_group_tokens'	 => array(
					'sections'	 => 'Sections',
					'process'	 => 'Process',
					'additional' => 'Additional',
				),
				'sections'			 => array(
					array('name' => 'section.maintenance.process', 'desc' => 'Loops through performed Maintenance actions'),
				),
				'process'			 => array(
					array('name' => 'maintenance.process.result', 'desc' => 'Displays the status of performed Maintenance'),
					array('name' => 'maintenance.process.date', 'desc' => 'Displays the date of performed Maintenance'),
					array('name' => 'maintenance.process.time', 'desc' => 'Displays the time of performed Maintenance'),
					array('name' => 'maintenance.process.details', 'desc' => 'Displays performed actions'),
				),
				'additional'		 => array(
					array('name' => 'maintenance.process.count', 'desc' => 'Displays the number of performed Maintenance actions during the selected date range'),
				),
			),
			'pagespeed'		 => array(
				'nav_group_tokens'	 => array(
					'pagespeed' => 'Page speed',
				),
				'pagespeed'			 => array(
					array('name' => 'pagespeed.average.desktop', 'desc' => 'Displays the average desktop page-speed score at the moment of report generation'),
					array('name' => 'pagespeed.average.mobile', 'desc' => 'Displays the average mobile page-speed score at the moment of report creation')
				),
			),
			// Support for the BLC should b e removed soon
			//'brokenlinks' => array(
			//	'nav_group_tokens' => array(
			//		'brokenlinks' => 'Broken Links Checker',
			//	),
			//	'brokenlinks' => array(
			//		array( 'name' => 'brokenlinks.links.broken', 'desc' => 'Displays the number of broken links at the moment of report creation' ),
			//    array( 'name' => 'brokenlinks.links.redirect', 'desc' => 'Displays the number of redirected links at the moment of report creation' ),
			//    array( 'name' => 'brokenlinks.links.dismissed', 'desc' => 'Displays the number of dismissed links at the moment of report creation' ),
			//    array( 'name' => 'brokenlinks.links.all', 'desc' => 'Displays the number of all links at the moment of report creation' )
			//	),
			//),
		);

		self::$tokens_nav_top = array(
			'client'		 => 'Client',
			'report'		 => 'Report',
			'plugins'		 => 'Plugins',
			'themes'		 => 'Themes',
			'posts'			 => 'Posts',
			'pages'			 => 'Pages',
			'comments'		 => 'Comments',
			'users'			 => 'Users',
			'media'			 => 'Media',
			'widgets'		 => 'Widgets',
			'menus'			 => 'Menus',
			'wordpress'		 => 'WordPress',
			'backups'		 => 'Backups',
			'sucuri'		 => 'Sucuri',
			'ga'			 => 'Google Analytics',
			'piwik'			 => 'Piwik',
			'aum'			 => 'AUM',
			'woocomstatus'	 => 'WooCommerce',
			'wordfence'		 => 'Wordfence',
			'maintenance'	 => 'Maintenance',
			'pagespeed'		 => 'Page Speed',
			//'brokenlinks' => 'Broken Links'
		);
	}

	public function admin_init() {
		//add_action( 'mainwp-extension-sites-edit', array( &$this, 'site_token' ), 9, 1 );
		//add_action( 'wp_ajax_mainwp_creport_load_tokens', array( &$this, 'load_tokens' ) );
		add_action( 'wp_ajax_mainwp_creport_delete_token', array(&$this, 'delete_token') );
		add_action( 'wp_ajax_mainwp_creport_save_token', array(&$this, 'save_token') );
		add_action( 'wp_ajax_mainwp_creport_do_action_report', array(&$this, 'ajax_do_action_report') );
		add_action( 'wp_ajax_mainwp_creport_load_site_tokens', array(&$this, 'load_site_tokens') );
		add_action( 'wp_ajax_mainwp_creport_save_format', array(&$this, 'save_format') );
		add_action( 'wp_ajax_mainwp_creport_get_format', array(&$this, 'get_format') );
		add_action( 'wp_ajax_mainwp_creport_delete_format', array(&$this, 'delete_format') );
		add_action( 'wp_ajax_mainwp_creport_group_load_sites', array(&$this, 'ajax_load_sites_for_group_report') );
		add_action( 'wp_ajax_mainwp_creport_general_load_sites', array(&$this, 'ajax_general_load_sites') );
		add_action( 'wp_ajax_mainwp_creport_save_settings', array(&$this, 'ajax_save_settings') );
		add_action( 'wp_ajax_mainwp_creport_generate_report', array(&$this, 'ajax_generate_report') );
		add_action( 'wp_ajax_mainwp_creport_archive_report', array(&$this, 'ajax_archive_report') );

		add_action( 'mainwp_added_new_site', array(&$this, 'update_site_update_tokens'), 8, 1 );
		add_action( 'mainwp_update_site', array(&$this, 'update_site_update_tokens'), 8, 1 );
		add_action( 'mainwp_delete_site', array(&$this, 'delete_site_delete_tokens'), 8, 1 );


		add_action( 'mainwp_managesite_backup', array(&$this, 'managesite_backup'), 10, 3 );
		add_action( 'wp_ajax_mainwp_creport_delete_client', array(&$this, 'ajax_delete_client') );

		self::$enabled_piwik		 = apply_filters( 'mainwp-extension-available-check', 'mainwp-piwik-extension' );
		self::$enabled_sucuri		 = apply_filters( 'mainwp-extension-available-check', 'mainwp-sucuri-extension' );
		self::$enabled_ga			 = apply_filters( 'mainwp-extension-available-check', 'mainwp-google-analytics-extension' );
		self::$enabled_aum			 = apply_filters( 'mainwp-extension-available-check', 'advanced-uptime-monitor-extension' );
		self::$enabled_woocomstatus	 = apply_filters( 'mainwp-extension-available-check', 'mainwp-woocommerce-status-extension' );
		self::$enabled_wordfence	 = apply_filters( 'mainwp-extension-available-check', 'mainwp-wordfence-extension' );
		self::$enabled_maintenance	 = apply_filters( 'mainwp-extension-available-check', 'mainwp-maintenance-extension' );
		self::$enabled_pagespeed	 = apply_filters( 'mainwp-extension-available-check', 'mainwp-page-speed-extension' );
//		self::$enabled_brokenlinks = apply_filters( 'mainwp-extension-available-check', 'mainwp-broken-links-checker-extension' );
		self::$stream_tokens		 = apply_filters( 'mainwp_client_reports_tokens_groups', self::$stream_tokens );
		self::$tokens_nav_top		 = apply_filters( 'mainwp_client_reports_tokens_nav_top', self::$tokens_nav_top );
	}

	function managesite_backup( $website, $args, $information ) {
		if ( empty( $website ) ) {
			return;
		}
		$type = isset( $args['type'] ) ? $args['type'] : '';
		if ( empty( $type ) ) {
			return;
		}

		global $mainWPCReportExtensionActivator;

		$backup_type = ('full' == $type) ? 'Full' : ('db' == $type ? 'Database' : '');

		$message		 = '';
		$backup_status	 = 'success';
		$backup_size	 = 0;
		if ( isset( $information['error'] ) ) {
			$message		 = $information['error'];
			$backup_status	 = 'failed';
		} else if ( 'db' == $type && !$information['db'] ) {
			$message		 = 'Database backup failed.';
			$backup_status	 = 'failed';
		} else if ( 'full' == $type && !$information['full'] ) {
			$message		 = 'Full backup failed.';
			$backup_status	 = 'failed';
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
			$message		 = 'Database backup failed due to an undefined error';
			$backup_status	 = 'failed';
		}

		// save results to child site stream
		$post_data = array(
			'mwp_action'	 => 'save_backup_stream',
			'size'			 => $backup_size,
			'message'		 => $message,
			'destination'	 => 'Local Server',
			'status'		 => $backup_status,
			'type'			 => $backup_type,
		);
		apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website->id, 'client_report', $post_data );
	}

	public static function managesite_schedule_backup( $website, $args,
													$backupResult ) {

		if ( empty( $website ) ) {
			return;
		}

		$type = isset( $args['type'] ) ? $args['type'] : '';
		if ( empty( $type ) ) {
			return;
		}

		$destination = '';
		if ( is_array( $backupResult ) ) {
			$error = false;
			if ( isset( $backupResult['error'] ) ) {
				$destination .= $backupResult['error'] . '<br />';
				$error		 = true;
			}

			if ( isset( $backupResult['ftp'] ) ) {
				if ( 'success' != $backupResult['ftp'] ) {
					$destination .= 'FTP: ' . $backupResult['ftp'] . '<br />';
					$error		 = true;
				} else {
					$destination .= 'FTP: success<br />';
				}
			}

			if ( isset( $backupResult['dropbox'] ) ) {
				if ( 'success' != $backupResult['dropbox'] ) {
					$destination .= 'Dropbox: ' . $backupResult['dropbox'] . '<br />';
					$error		 = true;
				} else {
					$destination .= 'Dropbox: success<br />';
				}
			}
			if ( isset( $backupResult['amazon'] ) ) {
				if ( 'success' != $backupResult['amazon'] ) {
					$destination .= 'Amazon: ' . $backupResult['amazon'] . '<br />';
					$error		 = true;
				} else {
					$destination .= 'Amazon: success<br />';
				}
			}

			if ( isset( $backupResult['copy'] ) ) {
				if ( 'success' != $backupResult['copy'] ) {
					$destination .= 'Copy.com: ' . $backupResult['amazon'] . '<br />';
					$error		 = true;
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
			$message	 = 'Schedule full backup.';
			$backup_type = 'Full';
		} else {
			$message	 = 'Schedule database backup.';
			$backup_type = 'Database';
		}

		global $mainWPCReportExtensionActivator;

		// save results to child site stream
		$post_data = array(
			'mwp_action'	 => 'save_backup_stream',
			'size'			 => 'N/A',
			'message'		 => $message,
			'destination'	 => $destination,
			'status'		 => 'N/A',
			'type'			 => $backup_type,
		);
		apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website->id, 'client_report', $post_data );
	}

	function mainwp_postprocess_backup_sites_feedback( $output, $unique ) {
		if ( !is_array( $output ) ) {
			
		} else {
			foreach ( $output as $key => $value ) {
				$output[$key] = $value;
			}
		}

		return $output;
	}

	public function init_cron() {
		add_action( 'mainwp_creport_cron_send_reports', array('MainWP_CReport', 'cron_send_reports') );
		add_action( 'mainwp_creport_cron_continue_send_reports', array('MainWP_CReport', 'cron_continue_send_reports') );
		$useWPCron = (false === get_option( 'mainwp_wp_cron' )) || (1 == get_option( 'mainwp_wp_cron' ));

		if ( ($sched = wp_next_scheduled( 'mainwp_creport_cron_send_reports' )) == false ) {
			if ( $useWPCron ) {
				wp_schedule_event( time(), '5minutely', 'mainwp_creport_cron_send_reports' );
			}
		} else {
			if ( !$useWPCron ) {
				wp_unschedule_event( $sched, 'mainwp_creport_cron_send_reports' );
			}
		}

		if ( ($sched = wp_next_scheduled( 'mainwp_creport_cron_continue_send_reports' )) == false ) {
			if ( $useWPCron ) {
				wp_schedule_event( time(), 'minutely', 'mainwp_creport_cron_continue_send_reports' );
			}
		} else {
			if ( !$useWPCron ) {
				wp_unschedule_event( $sched, 'mainwp_creport_cron_continue_send_reports' );
			}
		}
	}

	public static function cron_send_reports() {
		
		$send_local_time = apply_filters( 'mainwp_client_reports_send_local_time' , false);
		$timestamp_offset = 0;
		if ($send_local_time) {
			$gmtOffset = get_option( 'gmt_offset' );
			$timestamp_offset = $gmtOffset * HOUR_IN_SECONDS;
		}

		$time_check = time() + $timestamp_offset;

		$mainwpLastCheck = get_option( 'mainwp_creport_sendcheck_last' );
		if ( $mainwpLastCheck == date( 'd/m/Y', $time_check ) ) {
			do_action( 'mainp_log_debug', 'CRON :: Client Report :: already checked today' );
			return;
		}
		$forced_log = false;

		//Do cronjobs!
		//this will execute once every day to check to send the group reports

		$allReportsToSend	 = array();
		$allGroupReports	 = MainWP_CReport_DB::get_instance()->get_scheduled_reports_to_send( $timestamp_offset );

		$check_seconds = 6 * 60 * 60; // hours in seconds

		foreach ( $allGroupReports as $report ) {
			// if not debugging				
			// IMPORTANCE CHECK: to prevent INCORRECT schedule_nextsend or auto send to quick (at least after about 12 hours)
			if ( time() - $report->schedule_lastsend < $check_seconds ) {
				continue;
			}
			$cal_recurring = self::calc_recurring_date( $report->recurring_schedule, $report->recurring_day );

			if ( empty( $cal_recurring ) )
				continue;

			$log_time = date( "Y-m-d H:i:s", $cal_recurring['date_send'] );
			do_action( 'mainp_log_debug', 'CRON :: Client Report :: report id ' . $report->id . ', next send: ' . $log_time );

			// to fix: send current day/month/year... issue
			$values		 = array(
				'date_from_nextsend' => $cal_recurring['date_from'],
				'date_to_nextsend'	 => $cal_recurring['date_to'],
				'schedule_nextsend'	 => $cal_recurring['date_send'], // to check if current time > schedule nextsend then prepare report to send
			);
			$date_from	 = $report->date_from_nextsend;
			$date_to	 = $report->date_to_nextsend;
			if ( !empty( $date_from ) ) {
				// using to generate report content to send now
				$values['date_from']	 = $date_from;
				$values['date_to']	 = $date_to;
			}
			MainWP_CReport_DB::get_instance()->update_reports_with_values( $report->id, $values );

			$allReportsToSend[] = $report;
		}
		unset( $allGroupReports );

		do_action( 'mainp_log_debug', 'CRON :: MainWP Client Reports :: Check reports to send :: Found ' . count( $allReportsToSend ) . ' reports to send.', $forced_log );

		if ( count( $allReportsToSend ) == 0 ) {
			update_option( 'mainwp_creport_sendcheck_last', date( 'd/m/Y', time() ) );
		}

		foreach ( $allReportsToSend as $report ) {
			// update report to start sending
			// update `schedule_lastsend` to current time, `completed_sites` to empty array				
			MainWP_CReport_DB::get_instance()->update_reports_send( $report->id );
		}
	}

	public static function cron_continue_send_reports() {

		$forced_log = false;

		@ignore_user_abort( true );
		@set_time_limit( 0 );
		$mem = '512M';
		@ini_set( 'memory_limit', $mem );
		@ini_set( 'max_execution_time', 0 );

		//Fetch all tasks where complete < last & last checkup is more then 1 minute ago! & last is more then 1 minute ago!
		$reports = MainWP_CReport_DB::get_instance()->get_scheduled_reports_to_continue_send();

		do_action( 'mainp_log_debug', 'CRON :: Client Report :: continue send :: Found ' . count( $reports ) . ' to continue.', $forced_log );

		if ( empty( $reports ) ) {
			return;
		}

		// process one report
		$report = current( $reports );

		do_action( 'mainp_log_debug', 'CRON :: MainWP Client Reports :: Continue send :: Report: ' . $report->title, $forced_log );

		$sites	 = unserialize( base64_decode( $report->sites ) );
		$groups	 = unserialize( base64_decode( $report->groups ) );

		if ( !is_array( $sites ) ) {
			$sites = array();
		}

		if ( !is_array( $groups ) ) {
			$groups = array();
		}

		$chunkSend	 = 3;  // maximum number of sites processed per time are 3*2 = 6
		$countSend	 = 0;

		global $mainWPCReportExtensionActivator;

		$dbwebsites_indexed = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $sites, $groups );

		$total_sites = !empty( $dbwebsites_indexed ) ? count( $dbwebsites_indexed ) : 0;

		if ( $total_sites > 0 ) {

			$dbwebsites = array();
			foreach ( $dbwebsites_indexed as $value ) {
				$dbwebsites[] = $value;
			}
			unset( $dbwebsites_indexed );

			$sendme			 = true;
			$idx			 = 0;
			$completedSites = MainWP_CReport_DB::get_instance()->get_completed_sites( $report->id );

			while ( $sendme && ( $idx < $total_sites ) ) {

				$dbsite = $dbwebsites[$idx];

				$website = MainWP_CReport_Utility::map_site( $dbsite, array('id', 'name', 'url') );
				$site_id = $website['id'];

				if ( isset( $completedSites[$site_id] ) ) {
					if ( 1 == $completedSites[ $site_id ] || 0 == $completedSites[ $site_id ] ) {
						$idx++; // count to next site.
						continue;
					}
				} 
				// will update to 0 or 1 later after send report mail, to fix delay of send mail.
				$completedSites[$site_id] = 2;				
				self::update_completed_websites($report, $completedSites, $total_sites );	// update  before prepare report content, will re-set later.
				

				$data = self::prepare_content_report_email( $report, false, $website, true );

				$countSend++;


				if ( $data ) {
					$content_email = $data['content'];

					/*
					 * Perform send scheduled report email
					 * see send_onetime_report_email()
					 */
					$email_subject = stripslashes( $data['subject'] );

					if ( wp_mail( $data['to_email'], $email_subject, $content_email, $data['header'], $data['attachments'] ) ) {
						$lastsend	 = time();
						$values		 = array(
							'lastsend' => $lastsend  // to display last send time only
						);
						MainWP_CReport_DB::get_instance()->update_reports_with_values( $report->id, $values );
						MainWP_CReport_DB::get_instance()->updateWebsiteOption( $site_id, 'creport_last_report', $lastsend );

						do_action( 'mainp_log_debug', 'CRON :: MainWP Client Reports :: Send report success - website :: ' . $website['url'] . ' :: Subject :: ' . $email_subject, $forced_log );
						$completedSites[$site_id] = 1;
						self::update_completed_websites( $report, $completedSites, $total_sites, $forced_log );
					} else {
						do_action( 'mainp_log_debug', 'CRON :: MainWP Client Reports :: Send report failed - website :: ' . $website['url'] . ' :: Subject :: ' . $email_subject, $forced_log );
						/*
						 * If send report failed
						 * update completed sites to prevent re-send report multi-time
						 */
						$completedSites[$site_id] = 0;
						self::update_completed_websites( $report, $completedSites, $total_sites, $forced_log );
					}
					/*
					 * end send email
					 */
				}

				$idx++;
				if ( $countSend >= $chunkSend ) {
					$sendme = false;
				}
				usleep( 200000 );
			}
		}
	}

	function send_onetime_report_email( $data, $report, $send_test = false, $website = null ) {

		$email_subject	 = stripslashes( $data['subject'] );
		$content_email	 = $data['content'];

		$site_id = $website['id'];

		$success = false;

		if ( wp_mail( $data['to_email'], $email_subject, $content_email, $data['header'], $data['attachments'] ) ) {
			if ( !$send_test ) {
				$lastsend	 = time(); // UTC time.
				$values		 = array(
					'lastsend' => $lastsend  // to display last send time only.
				);
				MainWP_CReport_DB::get_instance()->update_reports_with_values( $report->id, $values );
				MainWP_CReport_DB::get_instance()->updateWebsiteOption( $site_id, 'creport_last_report', $lastsend );
			}
			do_action( 'mainp_log_debug', 'MainWP Client Reports :: Send report success :: Subject :: ' . $email_subject );
			$success = true;
		} else {
			do_action( 'mainp_log_debug', 'MainWP Client Reports :: Send report failed :: Subject :: ' . $email_subject );
		}

		return $success;
	}

	/*
	 * update the completed info for scheduled report
	 */

	public static function update_completed_websites( $report, $pCompletedSites, $total_sites, $forced_log = false ) {
		if ( $report->scheduled ) {
			MainWP_CReport_DB::get_instance()->update_reports_completed_sites( $report->id, $pCompletedSites );
			// filter completed site ids with completed value = 0 or = 1;
			$filter_completedSend = array_filter( $pCompletedSites, function( $val ) {
				return ( $val < 2 ); 
			} );
			//update completed sites
			if ( $total_sites > 0 && count( $filter_completedSend ) >= $total_sites ) {
				do_action( 'mainp_log_debug', 'MainWP Client Reports :: Test schedule reports :: count completed sites :: ' . count( $pCompletedSites ), $forced_log );
				MainWP_CReport_DB::get_instance()->update_reports_completed( $report->id );
			}
		}
	}

	public static function cal_days_in_month( $month, $year ) {
		if ( function_exists( 'cal_days_in_month' ) ) {
			$max_d = cal_days_in_month( CAL_GREGORIAN, $month, $year );
		} else {
			$max_d = date( 't', mktime( 0, 0, 0, $month, 1, $year ) );
		}
		return $max_d;
	}

	public static function calc_recurring_date( $schedule, $recurring_day,
											 $cal_date = false ) {
		if ( empty( $schedule ) ) {
			return false;
		}

		$the_time	 = time();
		$date_from	 = $date_to	 = $date_send	 = 0;

		if ( 'daily' == $schedule ) {
			$date_from	 = strtotime( date( 'Y-m-d', $the_time ) . ' 00:00:00' );
			$date_to	 = strtotime( date( 'Y-m-d', $the_time ) . ' 23:59:59' );
			$date_send	 = $date_to + 2;
		} else if ( 'weekly' == $schedule ) {
			// for strtotime()
			$day_of_week = array(
				1	 => 'monday',
				2	 => 'tuesday',
				3	 => 'wednesday',
				4	 => 'thursday',
				5	 => 'friday',
				6	 => 'saturday',
				7	 => 'sunday',
			);

			$date_from	 = strtotime( date( 'Y-m-d', $the_time ) . ' 00:00:00' );
			$date_to	 = $date_from + 7 * 24 * 3600 - 1;

			$date_send = strtotime( 'next ' . $day_of_week[$recurring_day] ) + 1;  // day of next week
			if ( $date_send < $date_to ) { // to fix
				$date_send += 7 * 24 * 3600;
			}
		} else if ( 'monthly' == $schedule ) {
			// to fix monthly schedule time
			if ( !empty( $cal_date ) ) {
				$the_time = $cal_date;
			}

			$first_date	 = date( 'Y-m-01', $the_time ); // first day of the month
			$last_date	 = date( "Y-m-t", $the_time ); // Date t parameter return days number in current month.

			$date_from	 = strtotime( $first_date . ' 00:00:00' );
			$date_to	 = strtotime( $last_date . ' 23:59:59' );

			$cal_month	 = date( 'm', $the_time ) + 1;
			$cal_year	 = date( 'Y', $the_time );

			if ( $cal_month > 12 ) {
				$cal_month	 = $cal_month - 12;
				$cal_year	 += 1;
			}
			$max_d			 = self::cal_days_in_month( $cal_month, $cal_year );
			if ( $recurring_day > $max_d )
				$recurring_day	 = $max_d;
			$date_send		 = mktime( 0, 0, 1, $cal_month, $recurring_day, $cal_year );
		} else if ( 'yearly' == $schedule ) {
			$date_from	 = strtotime( date( 'Y-01-01', $the_time ) . ' 00:00:00' ); // first day of the year
			$last_date	 = date( 'Y-m-d', strtotime( 'Dec 31' ) ); // last day of the year
			$date_to	 = strtotime( $last_date . ' 23:59:59' );
			list($m, $d) = explode( '-', $recurring_day );

			$max_d		 = self::cal_days_in_month( $m, date( 'Y' ) + 1 );
			if ( $d > $max_d )
				$d			 = $max_d;
			$date_send	 = mktime( 0, 0, 1, $m, $d, date( 'Y' ) + 1 );
		}

		return array(
			'date_from'	 => $date_from, //  local time
			'date_to'	 => $date_to, // local time
			'date_send'	 => $date_send // minus gmt offset so it will send in local time
		);
	}

	/**
	 * @param int $report_id The id of the report
	 * @param int $site_id The id of the site
	 * @param string|0 $from_date String of from date, date format 'Y-m-d H:i:s'
	 * @param string|0 $to_date String of to date, date format 'Y-m-d H:i:s'
	 *
	 * @return html content of generated report. False when something goes wrong.
	 */
	public static function hook_generate_report( $report_id, $site_id,
											  $from_date = 0, $to_date = 0, $type = '' ) {
		if ( empty( $report_id ) || empty( $site_id ) )
			return false;

		$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );

		if ( empty( $report ) )
			return false;

		global $mainWPCReportExtensionActivator;
		$website = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $site_id );
		if ( $website && is_array( $website ) ) {
			$website = current( $website );
		}
		if ( empty( $website ) )
			return false;

		if ( !empty( $from_date ) && !empty( $to_date ) ) {
			$from_date	 = strtotime( $from_date );
			$to_date	 = strtotime( $to_date );
		} else {
			$from_date	 = $to_date	 = 0;
		}

		$filtered_reports = self::filter_report_website( $report, $website, $from_date, $to_date, $type );

		if ( $type == 'raw' ) {
			return $filtered_reports;
		} else {
			$content = self::gen_report_content( $filtered_reports );
		}
		return $content;
	}

	public static function save_report() {
		if ( isset( $_REQUEST['action'] ) && 'editreport' == $_REQUEST['action'] && isset( $_REQUEST['nonce'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'mwp_creport_nonce' ) ) {
			$messages				 = $errors					 = array();
			$report					 = array();
			$current_attach_files	 = '';

			$update_report_date			 = false;
			$current_recurring_schedule	 = '';
			$current_recurring_day		 = '';
			if ( isset( $_REQUEST['id'] ) && !empty( $_REQUEST['id'] ) ) {
				$report					 = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $_REQUEST['id'], null, null, ARRAY_A );
				$current_attach_files	 = $report['attach_files'];
				// if current isn't scheduled report then update
				if ( !$report['scheduled'] ) {
					$update_report_date = true;
				} else {
					$current_recurring_schedule	 = $report['recurring_schedule'];
					$current_recurring_day		 = $report['recurring_day'];
				}
			} else {
				$update_report_date = true;
			}

			if ( isset( $_POST['mwp_creport_title'] ) && ($title = trim( $_POST['mwp_creport_title'] )) != '' ) {
				$report['title'] = $title;
			}

			$scheduled_report = false;
			if ( isset( $_POST['mainwp_creport_type'] ) && !empty( $_POST['mainwp_creport_type'] ) ) {
				$report['scheduled']	 = 1;
				$scheduled_report		 = true;
			} else {
				$report['scheduled'] = 0;
			}

			if ( !$scheduled_report ) {
				$utc		 = new DateTimeZone( 'UTC' );
				$start_time	 = $end_time	 = 0;
				if ( isset( $_POST['mwp_creport_date_from'] ) && ($start_date	 = trim( $_POST['mwp_creport_date_from'] )) != '' ) {
					//$start_time = strtotime( $start_date . ' ' . gmdate( 'H:i:s' ) );
					$dt			 = new DateTime( $start_date . ' ' . gmdate( 'H:i:s' ), $utc );
					$start_time	 = $dt->getTimestamp();
				}

				if ( isset( $_POST['mwp_creport_date_to'] ) && ($end_date = trim( $_POST['mwp_creport_date_to'] )) != '' ) {
					//$end_time = strtotime( $end_date . ' ' . gmdate( 'H:i:s' ) );
					$dt			 = new DateTime( $end_date . ' ' . gmdate( 'H:i:s' ), $utc );
					$end_time	 = $dt->getTimestamp();
				}

				if ( $start_time > $end_time ) {
					$tmp		 = $start_time;
					$start_time	 = $end_time;
					$end_time	 = $tmp;
				}

				if ( $start_time > 0 && $end_time > 0 ) {
					$start_time	 = gmmktime( 0, 0, 0, gmdate( 'm', $start_time ), gmdate( 'd', $start_time ), gmdate( 'Y', $start_time ) );
					$end_time	 = gmmktime( 23, 59, 59, gmdate( 'm', $end_time ), gmdate( 'd', $end_time ), gmdate( 'Y', $end_time ) );
				}

				$report['date_from']	 = $start_time;
				$report['date_to']	 = $end_time;
			}

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
			if ( !empty( $_POST['mwp_creport_femail'] ) ) {
				$from_email = trim( $_POST['mwp_creport_femail'] );
				if ( !preg_match( '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/is', $from_email ) ) {
					$from_email	 = '';
					$errors[]	 = 'Incorrect Email Address in the Send From filed.';
				}
			}
			$report['femail'] = $from_email;

			if ( isset( $_POST['mwp_creport_name'] ) ) {
				$report['name'] = trim( $_POST['mwp_creport_name'] );
			}

			if ( isset( $_POST['mwp_creport_company'] ) ) {
				$report['company'] = trim( $_POST['mwp_creport_company'] );
			}

			$to_email		 = '';
			$valid_emails	 = array();
			if ( !empty( $_POST['mwp_creport_email'] ) ) {
				$to_emails = explode( ',', trim( $_POST['mwp_creport_email'] ) );
				if ( is_array( $to_emails ) ) {
					foreach ( $to_emails as $_email ) {
						if ( !preg_match( '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/is', $_email ) && !preg_match( '/^\[.+\]/is', $_email ) ) {
							$to_email	 = '';
							$errors[]	 = 'Incorrect Email Address in the Send To field.';
						} else {
							$valid_emails[] = $_email;
						}
					}
				}
			}

			if ( count( $valid_emails ) > 0 ) {
				$to_email = implode( ',', $valid_emails );
			} else {
				$to_email	 = '';
				$errors[]	 = 'Incorrect Email Address in the Send To field.';
			}

			$report['email'] = $to_email;

			$bcc_email = '';
			if ( !empty( $_POST['mwp_creport_bcc_email'] ) ) {
				$bcc_email = trim( $_POST['mwp_creport_bcc_email'] );
				if ( !preg_match( '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/is', $bcc_email ) ) {
					$bcc_email = '';
				}
			}
			$report['bcc_email'] = $bcc_email;

			if ( isset( $_POST['mwp_creport_email_subject'] ) ) {
				$report['subject'] = trim( $_POST['mwp_creport_email_subject'] );
			}


			$report['recurring_schedule'] = '';
			if ( isset( $_POST['mainwp_creport_recurring_schedule'] ) ) {
				$report['recurring_schedule'] = trim( $_POST['mainwp_creport_recurring_schedule'] );
			}

			$report['recurring_day'] = '';

			if ( $scheduled_report ) {
				if ( $report['recurring_schedule'] == 'yearly' ) {
					$report['recurring_day'] = intval( $_POST['mainwp_creport_schedule_month'] ) . '-' . intval( $_POST['mainwp_creport_schedule_day_of_month'] );
				} else if ( $report['recurring_schedule'] == 'monthly' ) {
					$report['recurring_day'] = intval( $_POST['mainwp_creport_schedule_day_of_month'] );
				} else if ( $report['recurring_schedule'] == 'weekly' ) {
					$report['recurring_day'] = trim( $_POST['mainwp_creport_schedule_day'] );
				} else if ( $report['recurring_schedule'] == 'daily' ) {
					// nothing, send everyday
				} else {
					$report['recurring_schedule'] = ''; // will not schedule send
				}

				if ( ($current_recurring_schedule != $report['recurring_schedule']) || ($current_recurring_day != $report['recurring_day']) ) {
					$update_report_date = true;
				}

				// only update date when create new report
				// or change from one-time to scheduled report
				// or schedule settings changed
				if ( $update_report_date ) {
					$cal_recurring = self::calc_recurring_date( $report['recurring_schedule'], $report['recurring_day'] );   // ok
					if ( is_array( $cal_recurring ) ) {
						$report['date_from']			 = $cal_recurring['date_from'];
						$report['date_to']			 = $cal_recurring['date_to'];
						$report['date_from_nextsend']	 = 0; // need to be 0, will recalculate when schedule send
						$report['date_to_nextsend']	 = 0; // need to be 0, will recalculate when schedule send
						$report['schedule_nextsend']	 = $cal_recurring['date_send'];
						$report['completed']			 = $cal_recurring['date_send']; // to fix continue sending
					}
				}
			}

			if ( isset( $_POST['mainwp_creport_schedule_send_email'] ) ) {
				$report['schedule_send_email'] = trim( $_POST['mainwp_creport_schedule_send_email'] );
			}
			$report['schedule_bcc_me'] = isset( $_POST['mainwp_creport_schedule_bbc_me_email'] ) ? 1 : 0;
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
			if ( !file_exists( $creport_dir ) ) {
				@mkdir( $creport_dir, 0777, true );
			}
			if ( !file_exists( $creport_dir . '/index.php' ) ) {
				@touch( $creport_dir . '/index.php' );
			}

			$attach_files	 = 'NOTCHANGE';
			$delete_files	 = false;
			if ( isset( $_POST['mainwp_creport_delete_attach_files'] ) && '1' == $_POST['mainwp_creport_delete_attach_files'] ) {
				$attach_files = '';
				if ( !empty( $current_attach_files ) ) {
					self::delete_attach_files( $current_attach_files, $creport_dir );
				}
			}

			$return = array();
			if ( isset( $_FILES['mainwp_creport_attach_files'] ) && !empty( $_FILES['mainwp_creport_attach_files']['name'][0] ) ) {
				if ( !empty( $current_attach_files ) ) {
					self::delete_attach_files( $current_attach_files, $creport_dir );
				}

				$output = self::handle_upload_files( $_FILES['mainwp_creport_attach_files'], $creport_dir );
				//print_r($output);
				if ( isset( $output['error'] ) ) {
					$return['error'] = $output['error'];
				}
				if ( is_array( $output ) && isset( $output['filenames'] ) && !empty( $output['filenames'] ) ) {
					$attach_files = implode( ', ', $output['filenames'] );
				}
			}

			if ( 'NOTCHANGE' !== $attach_files ) {
				$report['attach_files'] = $attach_files;
			}

			//$selected_site = 0;
			$selected_sites	 = $selected_groups = array();

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

			$report['sites']	 = !empty( $selected_sites ) ? base64_encode( serialize( $selected_sites ) ) : '';
			$report['groups']	 = !empty( $selected_groups ) ? base64_encode( serialize( $selected_groups ) ) : '';

			if ( 'schedule' === $_POST['mwp_creport_report_submit_action'] ) {
				$report['scheduled'] = 1;
			}

			if ( 'save' === $_POST['mwp_creport_report_submit_action'] ||
				'sendreport' === $_POST['mwp_creport_report_submit_action'] ||
				'save_pdf' === $_POST['mwp_creport_report_submit_action'] ||
				'schedule' === $_POST['mwp_creport_report_submit_action'] ||
				'archive_report' === $_POST['mwp_creport_report_submit_action'] ||
				'preview' === (string) $_POST['mwp_creport_report_submit_action'] ||
				'send_test_email' === (string) $_POST['mwp_creport_report_submit_action']
			) {

				if ( $result = MainWP_CReport_DB::get_instance()->update_report( $report ) ) {
					$return['id']	 = $result->id;
					$messages[]		 = 'Report has been saved.';
					MainWP_CReport_DB::get_instance()->delete_group_report_content( $result->id ); // to clear reports generated content
				} else {
					$messages[] = 'Report has not been changed - Report Saved.';
				}
				$return['saved'] = true;
			}

			if ( !isset( $return['id'] ) && isset( $report['id'] ) ) {
				$return['id'] = $report['id'];
			}

			if ( isset( $_POST['mwp_creport_report_submit_action'] ) && ('save' === $_POST['mwp_creport_report_submit_action'] ) && isset( $return['saved'] ) && isset( $return['id'] ) && empty( $errors ) ) {
				//MainWP_CReport_DB::get_instance()->update_reports_errors( $return['id'], '' );	// clear errors
			}

			if ( count( $errors ) > 0 ) {
				$return['error'] = $errors;
			}

			if ( count( $messages ) > 0 ) {
				$return['message'] = $messages;
			}

			return $return;
		}
		return null;
	}

	static function delete_attach_files( $files, $dir ) {
		$files = explode( ',', $files );
		if ( is_array( $files ) ) {
			foreach ( $files as $file ) {
				$file		 = trim( $file );
				$file_path	 = $dir . $file;
				if ( file_exists( $file_path ) ) {
					@unlink( $file_path );
				}
			}
		}
	}

	public static function handle_upload_files( $file_input, $dest_dir ) {
		$output			 = array();
		$attachFiles	 = array();
		$allowed_files	 = array('jpeg', 'jpg', 'gif', 'png', 'rar', 'zip', 'pdf');

		$tmp_files = $file_input['tmp_name'];
		if ( is_array( $tmp_files ) ) {
			foreach ( $tmp_files as $i => $tmp_file ) {
				if ( ( UPLOAD_ERR_OK == $file_input['error'][$i]) && is_uploaded_file( $tmp_file ) ) {
					$file_size	 = $file_input['size'][$i];
					// = $file_input['type'][$i];
					$file_name	 = $file_input['name'][$i];
					$file_ext	 = strtolower( end( explode( '.', $file_name ) ) );
					if ( ($file_size > 5 * 1024 * 1024 ) ) {
						$output['error'][] = $file_name . ' - ' . __( 'File size too big' );
					} else if ( !in_array( $file_ext, $allowed_files ) ) {
						$output['error'][] = $file_name . ' - ' . __( 'File type are not allowed' );
					} else {
						$dest_file	 = $dest_dir . $file_name;
						$dest_file	 = dirname( $dest_file ) . '/' . wp_unique_filename( dirname( $dest_file ), basename( $dest_file ) );
						if ( move_uploaded_file( $tmp_file, $dest_file ) ) {
							$attachFiles[] = basename( $dest_file );
						} else {
							$output['error'][] = $file_name . ' - ' . __( 'Can not copy file' );
						}
						;
					}
				}
			}
		}
		$output['filenames'] = $attachFiles;
		return $output;
	}

	public static function prepare_content_report_email( $report, $send_test = false, $site = null ) {

		if ( !is_object( $report ) ) {
			return false;
		}

		$send_to_email		 = $subject			 = $bcc_email			 = '';
		$noti_email			 = @apply_filters( 'mainwp_getnotificationemail', false );
		$send_to_me_review	 = false;
		if ( $send_test ) {
			if ( empty( $noti_email ) )
				return false;
			else {
				$send_to_email	 = $noti_email;
				$subject		 = 'Send Test Email';
			}
		} else {
			if ( !empty( $report->scheduled ) ) {
				if ( $report->schedule_send_email == 'email_auto' ) {
					if ( $report->schedule_bcc_me ) {
						$bcc_email = $noti_email;
					}
				} else if ( $report->schedule_send_email == 'email_review' && !empty( $noti_email ) ) {
					$send_to_email		 = $noti_email;
					$subject			 = 'Review report';
					$send_to_me_review	 = true;
				}
			}
			$send_to_email = empty( $send_to_email ) ? $report->email : $send_to_email;
		}

		if ( empty( $send_to_email ) ) {
			return false;
		}

		$email_subject = '';
		if ( !empty( $subject ) ) {
			$email_subject = $subject;
		}

		$email_subject	 = isset( $report->subject ) && !empty( $report->subject ) ? $email_subject . ' - ' . $report->subject : $email_subject . ' - ' . 'Website Report';
		$email_subject	 = ltrim( $email_subject, ' - ' );

		global $mainWPCReportExtensionActivator;
		$email_has_token	 = $subject_has_token	 = false;
		$emails_token		 = $sites_token		 = array();

		if ( preg_match( '/^\[.+\]/is', $send_to_email ) ) {
			$email_has_token = true;
		}

		if ( preg_match( '/\[.+\]/is', $email_subject ) ) {
			$subject_has_token = true;
		}

		if ( $email_has_token || $subject_has_token ) {
			$sites	 = $groups	 = array();

			if ( !empty( $site ) ) { // send global report
				if ( isset( $site['id'] ) ) {
					$sites = array($site['id']);
				}
			}

			$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $sites, $groups );

			foreach ( $dbwebsites as $dbsite ) {
				if ( $email_has_token ) {
					$token = MainWP_CReport_DB::get_instance()->get_tokens_by( 'token_name', $send_to_email, $dbsite->url );
					if ( $token ) {
						$emails_token[$dbsite->id] = $token->site_token->token_value;
					}
				}
				if ( $subject_has_token ) {
					$sites_token[$dbsite->id] = MainWP_CReport_DB::get_instance()->get_site_tokens( $dbsite->url, 'token_name' );
				}
			}
		}

		$from_name	 = '';
		$from		 = '';
		if ( !empty( $report->fname ) ) {
			$from_name = $report->fname;

			if ( !empty( $report->fcompany ) ) {
				$from_name .= ' ' . $report->fcompany;
			}

			if ( !empty( $report->femail ) ) {
				$from .= ' <' . $report->femail . '>';
			}
		} else if ( !empty( $report->femail ) ) {
			if ( !empty( $report->fcompany ) ) {
				$from_name .= $report->fcompany . ' ';
			}
			$from .= ' <' . $report->femail . '>';
		}

		$header = array('content-type: text/html');

		if ( !empty( $from ) ) {
			$header[] = 'From: ' . $from_name . ' ' . $from;
		}

		if ( !empty( $bcc_email ) ) {
			$header[] = 'Bcc: ' . $bcc_email;
		}

		if ( !empty( $report->bcc_email ) ) {
			$header[] = 'Bcc: ' . $report->bcc_email;
		}

		$files		 = $report->attach_files;
		$attachments = array();
		if ( !empty( $files ) ) {
			$creport_dir = apply_filters( 'mainwp_getspecificdir', 'client_report/' );
			$files		 = explode( ',', $files );
			foreach ( $files as $file ) {
				$file			 = trim( $file );
				$attachments[]	 = $creport_dir . $file;
			}
		}

		$send_content = '';
		if ( !empty( $site ) ) {
			if ( !$report->is_archived ) {
				MainWP_CReport::update_group_report_site( $report, $site );
			}
			$site_id = $site['id'];
			$result	 = MainWP_CReport_DB::get_instance()->get_group_report_content( $report->id, $site_id );
			if ( $result ) {
				$send_content = json_decode( $result->report_content );
			}
		} else {
			return false;
		}

		if ( empty( $send_content ) )
			return false;

		if ( !$email_has_token || $send_to_me_review ) {
			$to_email = $send_to_email;
		}

		if ( $email_has_token && !$send_to_me_review ) {
			$to_email = isset( $emails_token[$site_id] ) ? $emails_token[$site_id] : '';
		}

		if ( empty( $to_email ) ) {
			return false;
		}

		$send_subject = $email_subject;
		if ( $subject_has_token ) {
			
//			$search_token	 = $replace_value	 = array();
			//to support report tokens
//			$search_token[]	 = '[report.daterange]';
//			$replace_value[] = MainWP_CReport_Utility::format_timestamp( $report->date_from ) . ' - ' . MainWP_CReport_Utility::format_timestamp( $report->date_to );
//			$search_token[]	 = '[report.send.date]';
			$now			 = time();			
//			$replace_value[] = MainWP_CReport_Utility::format_timestamp( MainWP_CReport_Utility::get_timestamp( $now ) );
			
			$tokens_values = array();
			$tokens_values['[report.daterange]'] = MainWP_CReport_Utility::format_timestamp( $report->date_from ) . ' - ' . MainWP_CReport_Utility::format_timestamp( $report->date_to );
			$tokens_values['[report.send.date]'] = MainWP_CReport_Utility::format_timestamp( MainWP_CReport_Utility::get_timestamp( $now ) );
			
			if ( isset( $sites_token[$site_id] ) && is_array( $sites_token[$site_id] ) ) {
				foreach ( $sites_token[$site_id] as $token_name => $token ) {
					
//					$search_token[]	 = '[' . $token_name . ']';
//					$replace_value[] = $token->token_value;
					
					$tokens_values['[' . $token_name . ']'] = $token->token_value;
				}
			}
			
			//$send_subject = str_replace( $search_token, $replace_value, $send_subject );			
			$tokens_values = apply_filters('mainwp_client_reports_custom_tokens', $tokens_values, $report, $site );
			$send_subject = self::replace_tokens_value( $send_subject, $tokens_values );
		}


		do_action( 'mainp_log_debug', 'Client Report :: Sending report to : ' . $to_email . ' :: From: ' . $from_name . ' ' . $from );

		$data = array(
			'header'		 => $header,
			'to_email'		 => $to_email,
			'subject'		 => $send_subject,
			'content'		 => $send_content,
			'attachments'	 => $attachments
		);

		$data = apply_filters( 'mainwp_creport_send_mail_data', $data );

		return $data;
	}

	public static function replace_tokens_value( $string, $replace_tokens ) {
		$tokens		 = array_keys( $replace_tokens );
		$values		 = array_values( $replace_tokens );		
		return str_replace( $tokens, $values, $string );		
	}
	
	public static function handle_upload_image( $file_input, $dest_dir,
											 $max_height, $max_width = null ) {
		$output			 = array();
		$processed_file	 = '';
		if ( UPLOAD_ERR_OK == $file_input['error'] ) {
			$tmp_file = $file_input['tmp_name'];
			if ( is_uploaded_file( $tmp_file ) ) {
				$file_size		 = $file_input['size'];
				$file_type		 = $file_input['type'];
				$file_name		 = $file_input['name'];
				$file_extension	 = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );

				if ( ($file_size > 500 * 1025 ) ) {
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
					$dest_file	 = $dest_dir . $file_name;
					$dest_file	 = dirname( $dest_file ) . '/' . wp_unique_filename( dirname( $dest_file ), basename( $dest_file ) );

					if ( move_uploaded_file( $tmp_file, $dest_file ) ) {
						if ( file_exists( $dest_file ) ) {
							list( $width, $height, $type, $attr ) = getimagesize( $dest_file );
						}

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
							$dst_height	 = $max_height;
							$dst_width	 = $width * $max_height / $height;
							$resize		 = true;
						}

						if ( $resize ) {
							$src			 = $dest_file;
							$cropped_file	 = wp_crop_image( $src, 0, 0, $width, $height, $dst_width, $dst_height, false );
							if ( !$cropped_file || is_wp_error( $cropped_file ) ) {
								$output['error'][] = __( 'Can not resize the image.' );
							} else {
								@unlink( $dest_file );
								$processed_file = basename( $cropped_file );
							}
						} else {
							$processed_file = basename( $dest_file );
						}

						$output['filename'] = $processed_file;
					} else {
						$output['error'][] = 'Can not copy the file.';
					}
				}
			}
		}
		return $output;
	}

	public static function render() {
		$messages					 = $errors						 = $reporttab_messages			 = array();
		$do_preview					 = $do_group_preview			 = $do_send					 = $do_send_test_email			 = false;
		$do_save_pdf				 = $do_download_pdf_group		 = $do_replicate				 = $do_archive					 = false;
		$do_save_pdf_get			 = $do_un_archive				 = $do_archive_get				 = false;
		$report_id					 = 0;
		$report						 = false;
		$scheduled_creport			 = false;
		$filter_group_report_actions = array('preview', 'send_test_email', 'save_pdf', 'archive_report', 'sendreport'); // do not unarchive_report
		$action_group_report		 = '';

		if ( isset( $_GET['action'] ) ) {
			if ( 'sendreport' === (string) $_GET['action'] ) {
				$do_send = true;
			} else if ( 'preview' === (string) $_GET['action'] ) {
				$do_preview = true;
			} else if ( 'show_preview_group' === (string) $_GET['action'] ) {
				$do_group_preview = true;
			} else if ( 'replicate' === (string) $_REQUEST['action'] ) {
				$do_replicate = true;
			} else if ( 'save_pdf' === (string) $_REQUEST['action'] ) {
				$do_save_pdf_get = true;
			} else if ( 'archive_report' === (string) $_REQUEST['action'] ) {
				$do_archive_get = true;
			} else if ( 'download_pdf_group' === $_GET['action'] ) {
				$do_download_pdf_group = true;
			}

			if ( in_array( $_GET['action'], $filter_group_report_actions ) )
				$action_group_report = $_GET['action'];
		}

		if ( isset( $_POST['mwp_creport_report_submit_action'] ) ) {
			if ( 'sendreport' === (string) $_POST['mwp_creport_report_submit_action'] ) {
				$do_send = true;
			} else if ( 'send_test_email' === (string) $_POST['mwp_creport_report_submit_action'] ) {
				$do_send_test_email = true;
			} else if ( 'save_pdf' === (string) $_POST['mwp_creport_report_submit_action'] ) {
				$do_save_pdf = true;
			} else if ( 'preview' === (string) $_POST['mwp_creport_report_submit_action'] ) {
				$do_preview = true;
			} else if ( 'archive_report' === (string) $_POST['mwp_creport_report_submit_action'] ) {
				$do_archive = true;
			} else if ( 'unarchive_report' == $_POST['mwp_creport_report_submit_action'] ) {
				$do_un_archive = true;
			}

			if ( in_array( $_POST['mwp_creport_report_submit_action'], $filter_group_report_actions ) )
				$action_group_report = $_POST['mwp_creport_report_submit_action'];
		}

		if ( isset( $_REQUEST['id'] ) ) {
			$report_id = $_REQUEST['id'];
		}

		// for normal report and group report
		if ( $do_un_archive ) {
			if ( self::un_archive_report( $report_id ) ) {
				$messages[] = __( 'Report restored successfully.', 'mainwp-client-reports' );
			} else {
				$errors[] = __( 'Restoring the report failed. Please try again.', 'mainwp-client-reports' );
			}
		}

		$current_is_archived = false;

		if ( $report_id ) {
			$current_report				 = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );
			MainWP_CReport::un_archive_report( $report_id ); // to un-archive, the archive feature retired
			$current_report->is_archived = false;
			//$current_is_archived = ! empty( $current_report ) && $current_report->is_archived ? true : false;
			unset( $current_report );
		}

		$save_successful	 = $save_without_error	 = false;
		$result_save		 = array();

		if ( !$current_is_archived && isset( $_POST['mwp_creport_report_submit_action'] ) && !empty( $_POST['mwp_creport_report_submit_action'] ) ) {
			$result_save = self::save_report();
			$report_id	 = isset( $result_save['id'] ) && $result_save['id'] ? $result_save['id'] : 0;

			if ( isset( $result_save['message'] ) ) {
				$messages = $result_save['message'];
			}

			if ( isset( $result_save['error'] ) ) {
				$errors = $result_save['error'];
			} else {
				$save_without_error = true;
			}

			if ( isset( $result_save['saved'] ) && (true == $result_save['saved']) ) {
				$save_successful = true;
			}
		}

		if ( $report_id && ( $do_save_pdf || $do_save_pdf_get || $do_download_pdf_group ) ) {
			if ( $current_is_archived || $do_download_pdf_group ) {
				//!=== 1 - pdf report ===!//
				$report_pdf = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );
				if ( $report_pdf ) {
					$time		 = date( 'His' );
					$content	 = MainWP_CReport::gen_content_pdf( $report_pdf );
					update_option( 'mwp_creport_pdf_' . $time . '_' . $report_id, serialize( $content ) );
					unset( $report_pdf );
					?>
					<script>
						jQuery( document ).ready( function ( $ ) {
							window.open( '<?php echo get_site_url(); ?>/wp-admin/admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report&action=savepdf&id=<?php echo esc_attr( $report_id ); ?>&time=<?php echo esc_attr( $time ); ?>&_noncesave=<?php echo wp_create_nonce( '_noncesave' ); ?>', '_blank' );
								} );
					</script>
					<?php
					$messages[]	 = __( 'Generating PDF Report. Please wait...', 'mainwp-client-reports-extension' );
				}
			}
		}

		if ( $report_id ) {
			if ( !$do_archive_get && (null == $report) ) {
				$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );
				//print_r($report);
			}
		}

		if ( $do_replicate ) {
			$report->id				 = $report_id				 = 0;
			$report->title			 = '';
			$report->is_archived	 = 0;
			$report->attach_files	 = '';
			$report->name			 = '[client.name]';
			$report->company		 = '[client.company]';
			$report->email			 = '[client.email]';
			$report->bcc_email		 = '';
			$report->client			 = '[client.name]';
			$report->client_id		 = 0;
		}

		$selected_site			 = 0;
		$do_create_new_global	 = false;

		$current_tab = '';

		if ( isset( $_GET['tab'] ) ) {
			if ( $_GET['tab'] == 'dashboard' ) {
				$current_tab = 'dashboard';
			} else if ( $_GET['tab'] == 'reports' ) {
				$current_tab = 'reports';
			} else if ( $_GET['tab'] == 'tokens' ) {
				$current_tab = 'tokens';
			} else if ( $_GET['tab'] == 'report' ) {
				$current_tab = 'report';
			} else if ( $_GET['tab'] == 'edit_report' ) {
				$current_tab = 'edit_report';
			}
		} else {
			$current_tab = 'reports';
		}

//		$clients = MainWP_CReport_DB::get_instance()->get_clients();
//		if ( ! is_array( $clients ) ) {
//			$clients = array();
//		}

		global $mainWPCReportExtensionActivator;

		$websites	 = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), null );
		$sites_ids	 = array();
		if ( is_array( $websites ) ) {
			foreach ( $websites as $website ) {
				$sites_ids[] = $website['id'];
			}
		}
		$option				 = array(
			'plugin_upgrades'	 => true,
			'plugins'			 => true,
		);
		$dbwebsites			 = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $sites_ids, array(), $option );
		$all_creport_sites	 = $sites_with_creport	 = array();
		foreach ( $dbwebsites as $website ) {
			if ( $website && $website->plugins != '' ) {
				$plugins = json_decode( $website->plugins, 1 );				
				if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
					foreach ( $plugins as $plugin ) {
						if ( 'mainwp-child-reports/mainwp-child-reports.php' == $plugin['slug'] ) {
							if ( $plugin['active'] ) {
								$all_creport_sites[]	 = MainWP_CReport_Utility::map_site( $website, array('id', 'name') );
								$sites_with_creport[]	 = $website->id;
								break;
							}
						}
					}
				}
			}
		}
		
		$lastReports		 = MainWP_CReport_DB::get_instance()->getOptionOfWebsites( $sites_with_creport, 'creport_last_report' );
		$lastReportsSites	 = array();
		if ( is_array( $lastReports ) ) {
			foreach ( $lastReports as $last ) {
				$lastReportsSites[$last->wpid] = $last->value;
			}
		}

		if ( !empty( $report ) && !empty( $report->scheduled ) ) {
			$scheduled_creport = true;
		}

		$selected_group = array();

		$dbwebsites_stream = MainWP_CReport_Stream::get_instance()->get_websites_stream( $dbwebsites, $selected_group, $lastReportsSites );

		unset( $dbwebsites );

		$sel_sites	 = $sel_groups	 = array();

		if ( $do_preview || $do_send || $do_send_test_email ) {
			$check_valid = true;
			if ( empty( $report ) || !is_object( $report ) ) {
				$errors[]	 = __( 'Invalid report data. Please try again.', 'mainwp-client-reports-extension' );
				$check_valid = false;
			} else {
				$sel_sites	 = unserialize( base64_decode( $report->sites ) );
				$sel_groups	 = unserialize( base64_decode( $report->groups ) );
				if ( (!is_array( $sel_sites ) || count( $sel_sites ) == 0) && (!is_array( $sel_groups ) || count( $sel_groups ) == 0 ) ) {
					$errors[]	 = __( 'Please select at least one website or group.' );
					$check_valid = false;
				}
			}
			if ( !$check_valid ) {
				$do_preview	 = $do_send	 = false;
			}

			if ( $do_send && empty( $report->email ) ) {
				$errors[]	 = __( '"Send To" email address is required.', 'mainwp-client-reports-extension' );
				$do_send	 = false;
			}

			if ( $do_send && $report->scheduled ) {
				$errors[]			 = __( 'Scheduled report not sent.', 'mainwp-client-reports-extension' );
				$do_send			 = false;
				$action_group_report = '';
			}
		}

		// do not load sites
		if ( ( $action_group_report === 'preview' && $current_is_archived ) || ( $action_group_report === 'save_pdf' && $current_is_archived ) ) {
			$action_group_report = '';
		}

		$str_error	 = ( count( $errors ) > 0 ) ? implode( '<br/>', $errors ) : '';
		$str_message = ( count( $messages ) > 0 ) ? implode( '<br/>', $messages ) : '';
		?>
		<div class="ui labeled icon inverted menu mainwp-sub-submenu" id="mainwp-client-reports-menu">
			<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=dashboard" class="item <?php echo ( $current_tab == 'dashboard' ) ? 'active' : ''; ?>"><i class="tasks icon"></i> <?php _e( 'Child Reports Dashboard', 'mainwp-client-reports-extension' ); ?></a>
			<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=reports" class="item <?php echo ( $current_tab == 'reports' || $current_tab == '' ) ? 'active' : ''; ?>"><i class="file alternate outline icon"></i> <?php _e( 'Reports', 'mainwp-client-reports-extension' ); ?></a>
			<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report" class="item <?php echo ( $current_tab == 'report' ) ? 'active' : ''; ?>"><i class="file alternate outline icon"></i> <?php _e( 'Create Report', 'mainwp-client-reports-extension' ); ?></a>
			<a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=tokens" class="item <?php echo ( $current_tab == 'tokens' ) ? 'active' : ''; ?>"><i class="code icon"></i> <?php _e( 'Tokens', 'mainwp-client-reports-extension' ); ?></a>
		</div>

		<?php if ( $current_tab == 'dashboard' ) : ?>
			<div id="mainwp-client-reports-dashboard-tab">
				<?php MainWP_CReport_Stream::gen_actions_rows(); ?>
				<?php MainWP_CReport_Stream::gen_dashboard_tab( $dbwebsites_stream ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $current_tab == 'reports' ) : ?>
			<div id="mainwp-client-reports-reports-tab">
				<div class="ui segment">
					<?php if ( count( $reporttab_messages ) > 0 ) : ?>
						<?php echo '<div  class="ui yellow message">' . implode( '<br/>', $reporttab_messages ) . '</div>'; ?>
					<?php endif; ?>
					<?php self::report_tab( $websites ); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $current_tab == 'report' ) : ?>
			<div id="mainwp-client-reports-report-tab">
				<div class="ui alt segment">
					<form method="post" enctype="multipart/form-data" id="mwp_creport_edit_form" action="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report&action=editreport<?php echo!empty( $report_id ) ? '&id=' . $report_id : ''; ?>">
						<div class="mainwp-main-content">
							<div class="ui hidden divider"></div>
							<div class="ui red message" id="mwp-creport-error-box" <?php echo empty( $str_error ) ? 'style="display: none"' : ''; ?>><?php echo $str_error; ?></div>
							<div class="ui green message" id="mwp-creport-info-box" <?php echo empty( $str_message ) ? ' style="display: none" ' : ''; ?>><?php echo $str_message; ?></div>
							<?php self::new_report_tab( $report ); ?>
						</div>
						<div class="mainwp-side-content mainwp-no-padding">
							<div class="mainwp-select-sites" id="creport_select_sites_box">
								<div class="ui header"><?php _e( 'Select Sites', 'mainwp-client-reports-extension' ); ?></div>
								<?php
								$sel_sites	 = $sel_groups	 = array();
								if ( $do_create_new_global || !empty( $report ) ) {
									if ( !empty( $report ) ) {
										$sel_sites	 = unserialize( base64_decode( $report->sites ) );
										$sel_groups	 = unserialize( base64_decode( $report->groups ) );
									}

									if ( !is_array( $sel_sites ) ) {
										$sel_sites = array();
									}

									if ( !is_array( $sel_groups ) ) {
										$sel_groups = array();
									}
								}

								if ( $selected_site ) {
									$sel_sites[] = $selected_site;
								}

								$un_archive_btn	 = '';
								$_disabled		 = '';
								if ( !empty( $report ) && isset( $report->id ) && isset( $report->is_archived ) && $report->is_archived ) {
//						$un_archive_btn = '<input type="submit" value="' . __( 'Un-Archive Report', 'mainwp-client-reports-extension' ) . '" class="ui big fluid button" id="mwp-creport-unarchive-report-btn" name="button_unarchive">';
//						$_disabled = 'disabled="disabled"';
								}


								do_action( 'mainwp_select_sites_box', '', 'checkbox', true, true, '', '', $sel_sites, $sel_groups );
								?>
							</div>
							<div class="ui divider"></div>
							<div class="mainwp-search-submit">
								<input type="submit" value="<?php _e( 'Preview Report' ); ?>" class="ui big green basic fluid button" id="mwp-creport-preview-btn" name="button_preview">
								<div class="ui hidden fitted divider"></div>
								<input type="submit" value="<?php _e( 'Send Test Email' ); ?>" class="ui big fluid button" id="mwp-creport-send-test-email-btn" name="button_send_test_email">
								<div class="ui hidden fitted divider"></div>
								<input type="submit" value="<?php _e( 'Download PDF' ); ?>" class="ui big fluid button" id="mwp-creport-save-pdf-btn" name="button_save_pdf">
								<div class="ui hidden fitted divider"></div>
								<input type="submit" <?php echo $_disabled; ?> value="<?php _e( 'Save Report' ); ?>" class="ui big green basic fluid button" id="mwp-creport-save-btn" name="button_save">
								<div class="ui hidden fitted divider"></div>
								<input type="submit" <?php echo $scheduled_creport ? 'style="display:none"' : ''; ?> value="<?php _e( 'Send Now' ); ?>"  class="ui big green fluid button" id="mwp-creport-send-btn" name="submit">
								<input type="submit" <?php echo $scheduled_creport ? '' : 'style="display:none"'; ?> value="<?php _e( 'Schedule Report' ); ?>" <?php echo $_disabled; ?> class="ui big green fluid button" id="mwp-creport-schedule-btn" name="button_schedule">

								<input type="hidden" name="mwp_creport_report_submit_action" id="mwp_creport_report_submit_action" value="">
								<input type="hidden" name="id" value="<?php echo (is_object( $report ) && isset( $report->id )) ? $report->id : '0'; ?>">
								<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'mwp_creport_nonce' ) ?>">
							</div>
						</div>
						<div class="ui clearing hidden divider"></div>
					</form>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $current_tab == 'tokens' ) : ?>
			<div id="mainwp-client-reports-tokens-tab">
				<?php self::load_tokens(); ?>
			</div>
		<?php endif; ?>

		<div class="ui large modal" id="mainwp-client-report-modal">
			<div class="header"><?php _e( 'Report Preview', 'mainwp-client-reports-extension' ); ?></div>
			<div class="scrolling content" id="mwp-creport-preview-content">
				<?php
				if ( is_object( $report ) ) {
					if ( ( $do_preview && $current_is_archived ) || $do_group_preview ) {
						echo self::gen_preview_report( $report );
						?>
						<script>
							jQuery( document ).ready( function ( $ ) {
								mainwp_creport_preview_report();
							} );
						</script>
						<?php
					}
				}
				?>
			</div>
			<div class="actions">
				<div class="ui cancel button"><?php _e( 'Close', 'mainwp-client-reports-extension' ); ?></div>
				<input type="button" <?php echo $scheduled_creport ? 'style="display:none"' : ''; ?> value="<?php _e( 'Send Now' ); ?>" class="ui button green" id="mwp-creport-preview-btn-send"/>
			</div>
		</div>
		<script>
			jQuery( document ).ready( function ( $ ) {
				mainwp_creport_remove_sites_without_creports( '<?php echo implode( ',', $sites_with_creport ) ?>' );
		<?php if ( $action_group_report != '' ) { ?>
					mainwp_client_report_load_sites( '<?php echo esc_html( $action_group_report ) ?>', <?php echo intval( $report_id ); ?> );
		<?php } ?>
		<?php if ( $do_create_new_global && $selected_site ) { ?>
					$( '#selected_sites_<?php echo $selected_site; ?>' ).trigger( 'click' );
		<?php } ?>
			} );
		</script>

		<?php
	}

	public static function render_tabs() {
		
	}

	public static function un_archive_report( $report ) {
		if ( !empty( $report ) && !is_object( $report ) ) {
			$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report );
		}

		if ( !$report->is_archived ) {
			return true;
		}

		$update_archive = array(
			'id'			 => $report->id,
			'is_archived'	 => 0
		);
		if ( MainWP_CReport_DB::get_instance()->update_report( $update_archive ) ) {
			return true;
		}
		return false;
	}

	public static function set_init_params() {
		@ignore_user_abort( true );
		$timeout = 10 * 60 * 60;
		@set_time_limit( $timeout );
		$mem	 = '1024M';
		@ini_set( 'memory_limit', $mem );
		@ini_set( 'max_execution_time', 0 );
	}

	public static function gen_preview_report( $report ) {
		self::set_init_params();

		ob_start();
		if ( !empty( $report ) ) {
			$group_contents = MainWP_CReport_DB::get_instance()->get_group_report_content( $report->id );
			if ( is_array( $group_contents ) ) {
				foreach ( $group_contents as $content ) {
					echo json_decode( $content->report_content );
				}
			}
		} else {
			?>
			<div class="mainwp_info-box-yellow"><?php _e( 'Report Error' ); ?></div>
			<?php
		}
		$output = ob_get_clean();
		return $output;
	}

	public static function gen_report_content( $report ) {
		ob_start();
		$convert_nl2br = apply_filters( 'mainwp_client_reports_newline_break', true );
		if ( is_array( $report ) && isset( $report['error'] ) ) {
			echo $report['error'];
		} else if ( is_object( $report ) ) {
			if ( $convert_nl2br ) {
				echo stripslashes( nl2br( $report->filtered_header ) );
				echo stripslashes( nl2br( $report->filtered_body ) );
				echo stripslashes( nl2br( $report->filtered_footer ) );
			} else {
				echo stripslashes( $report->filtered_header );
				echo stripslashes( $report->filtered_body );
				echo stripslashes( $report->filtered_footer );
			}
		}
		$output = ob_get_clean();
		return $output;
	}

	public static function gen_content_pdf( $report ) {
		// to fix bug from mainwp
		if ( !function_exists( 'wp_verify_nonce' ) ) {
			include_once( ABSPATH . WPINC . '/pluggable.php' );
		}

		self::set_init_params();

		if ( !empty( $report ) && is_object( $report ) ) {
			// return non-array content for pdf
			$group_contents	 = MainWP_CReport_DB::get_instance()->get_group_report_content( $report->id );
			$content_pdf	 = '';
			if ( is_array( $group_contents ) ) {
				foreach ( $group_contents as $content ) {
					$content_pdf .= json_decode( $content->report_content_pdf );
				}
			}
			return $content_pdf;
		}
		return '';
	}

	public static function gen_report_content_pdf( $filtered_reports ) {

		$convert_nl2br = apply_filters( 'mainwp_client_reports_newline_break', true );
		ob_start();

		foreach ( $filtered_reports as $site_id => $report ) {
			if ( is_array( $report ) && isset( $report['error'] ) ) {
				echo $report['error'];
			} else if ( is_object( $report ) ) {
				if ( $convert_nl2br ) {
					echo stripslashes( nl2br( $report->filtered_header ) );
					echo stripslashes( nl2br( $report->filtered_body ) );
					echo stripslashes( nl2br( $report->filtered_footer ) );
				} else {
					echo stripslashes( $report->filtered_header );
					echo stripslashes( $report->filtered_body );
					echo stripslashes( $report->filtered_footer );
				}
			}
		}

		$output = ob_get_clean();
		return $output;
	}

	public static function get_addition_tokens( $site_id ) {
		$tokens_value = array();		
		$site_info = apply_filters( 'mainwp_getwebsiteoptions', false, $site_id, 'site_info' );
		if ( $site_info ) {
			$site_info = json_decode( $site_info, true );
			if ( is_array( $site_info ) ) {
				$map_site_tokens = array(
					'client.site.version'	 => 'wpversion', // Displays the WP version of the child site,
					'client.site.theme'		 => 'themeactivated', // Displays the currently active theme for the child site
					'client.site.php'		 => 'phpversion', // Displays the PHP version of the child site
					'client.site.mysql'		 => 'mysql_version', // Displays the MySQL version of the child site
				);
				foreach ( $map_site_tokens as $tok => $val ) {
					$tokens_value[$tok] = ( is_array( $site_info ) && isset( $site_info[$val] ) ) ? $site_info[$val] : '';
				}
			}
		}
		$get_issues = apply_filters( 'mainwp_getwebsiteoptions', false, $site_id, 'health_site_status' );
		$issue_counts = json_decode( $get_issues, true );
		$issues_total = $issue_counts['recommended'] + $issue_counts['critical'];	
		$tokens_value['site.health.score'] = intval( $issues_total );
		return $tokens_value;
	}

	public static function filter_report_website( $report, $website,
											   $cust_from_date = 0, $cust_to_date = 0, $type = '' ) {
		$date_from	 = $cust_from_date ? $cust_from_date : $report->date_from;
		$date_to	 = $cust_to_date ? $cust_to_date : $report->date_to;

		$output					 = new stdClass();
		$output->filtered_header = $report->header;
		$output->filtered_body	 = $report->body;
		$output->filtered_footer = $report->footer;
		$output->id				 = isset( $report->id ) ? $report->id : 0;
		$get_ga_tokens			 = ((strpos( $report->header, '[ga.' ) !== false) || (strpos( $report->body, '[ga.' ) !== false) || (strpos( $report->footer, '[ga.' ) !== false)) ? true : false;
		$get_ga_chart			 = ((strpos( $report->header, '[ga.visits.chart]' ) !== false) || (strpos( $report->body, '[ga.visits.chart]' ) !== false) || (strpos( $report->footer, '[ga.visits.chart]' ) !== false)) ? true : false;
		$get_ga_chart			 = $get_ga_chart || (((strpos( $report->header, '[ga.visits.maximum]' ) !== false) || (strpos( $report->body, '[ga.visits.maximum]' ) !== false) || (strpos( $report->footer, '[ga.visits.maximum]' ) !== false)) ? true : false);

		$get_piwik_tokens		 = ((strpos( $report->header, '[piwik.' ) !== false) || (strpos( $report->body, '[piwik.' ) !== false) || (strpos( $report->footer, '[piwik.' ) !== false)) ? true : false;
		$get_aum_tokens			 = ((strpos( $report->header, '[aum.' ) !== false) || (strpos( $report->body, '[aum.' ) !== false) || (strpos( $report->footer, '[aum.' ) !== false)) ? true : false;
		$get_woocom_tokens		 = ((strpos( $report->header, '[wcomstatus.' ) !== false) || (strpos( $report->body, '[wcomstatus.' ) !== false) || (strpos( $report->footer, '[wcomstatus.' ) !== false)) ? true : false;
		$get_pagespeed_tokens	 = ((strpos( $report->header, '[pagespeed.' ) !== false) || (strpos( $report->body, '[pagespeed.' ) !== false) || (strpos( $report->footer, '[pagespeed.' ) !== false)) ? true : false;
		//$get_brokenlinks_tokens = ((strpos( $report->header, '[brokenlinks.' ) !== false) || (strpos( $report->body, '[brokenlinks.' ) !== false) || (strpos( $report->footer, '[brokenlinks.' ) !== false)) ? true : false;
		if ( !empty( $website ) ) {
			$tokens					 = MainWP_CReport_DB::get_instance()->get_tokens();
			$site_tokens			 = MainWP_CReport_DB::get_instance()->get_site_tokens( $website['url'] );
			$replace_tokens_values	 = array();
			foreach ( $tokens as $token ) {
				$replace_tokens_values['[' . $token->token_name . ']'] = isset( $site_tokens[$token->id] ) ? $site_tokens[$token->id]->token_value : '';
			}

			$client_addition_tokens = self::get_addition_tokens( $website['id'] );
			if ( is_array( $client_addition_tokens ) ) {
				foreach ( $client_addition_tokens as $token => $value ) {
					$replace_tokens_values['[' . $token . ']'] = $value;
				}
			}

			if ( $get_piwik_tokens ) {
				$piwik_tokens = self::piwik_data( $website['id'], $date_from, $date_to );
				if ( is_array( $piwik_tokens ) ) {
					foreach ( $piwik_tokens as $token => $value ) {
						$replace_tokens_values['[' . $token . ']'] = $value;
					}
				}
			}

			if ( $get_ga_tokens ) {
				$ga_tokens = self::ga_data( $website['id'], $date_from, $date_to, $get_ga_chart );
				if ( is_array( $ga_tokens ) ) {
					foreach ( $ga_tokens as $token => $value ) {
						$replace_tokens_values['[' . $token . ']'] = $value;
					}
				}
			}

			if ( $get_aum_tokens ) {
				$aum_tokens = self::aum_data( $website['id'], $date_from, $date_to );
				if ( is_array( $aum_tokens ) ) {
					foreach ( $aum_tokens as $token => $value ) {
						$replace_tokens_values['[' . $token . ']'] = $value;
					}
				}
			}

			if ( $get_woocom_tokens ) {
				$wcomstatus_tokens = self::woocomstatus_data( $website['id'], $date_from, $date_to );
				if ( is_array( $wcomstatus_tokens ) ) {
					foreach ( $wcomstatus_tokens as $token => $value ) {
						$replace_tokens_values['[' . $token . ']'] = $value;
					}
				}
			}

			if ( $get_pagespeed_tokens ) {
				$pagespeed_tokens = self::pagespeed_tokens( $website['id'], $date_from, $date_to );
				if ( is_array( $pagespeed_tokens ) ) {
					foreach ( $pagespeed_tokens as $token => $value ) {
						$replace_tokens_values['[' . $token . ']'] = $value;
					}
				}
			}

//            if ( $get_brokenlinks_tokens ) {
//				$brokenlinks_tokens = self::brokenlinks_tokens( $website['id'], $date_from, $date_to );
//				if ( is_array( $brokenlinks_tokens ) ) {
//					foreach ( $brokenlinks_tokens as $token => $value ) {
//						$replace_tokens_values['[' . $token . ']'] = $value;
//					}
//				}
//			}


			$replace_tokens_values['[report.daterange]']	 = MainWP_CReport_Utility::format_date( $date_from, true ) . ' - ' . MainWP_CReport_Utility::format_date( $date_to, true );
			$now											 = time();
			$replace_tokens_values['[report.send.date]']	 = MainWP_CReport_Utility::format_timestamp( MainWP_CReport_Utility::get_timestamp( $now ), true );
			$replace_tokens_values							 = apply_filters( 'mainwp_client_reports_custom_tokens', $replace_tokens_values, $report, $website );

			$report_header	 = $report->header;
			$report_body	 = $report->body;
			$report_footer	 = $report->footer;

			$result									 = self::parse_report_content( $report_header, $replace_tokens_values );
			//print_r($result);
			self::$buffer['sections']['header']	 = $sections['header']					 = $result['sections'];
			$other_tokens['header']				 = $result['other_tokens'];
			$filtered_header						 = $result['filtered_content'];
			unset( $result );

			$result									 = self::parse_report_content( $report_body, $replace_tokens_values );
			//print_r($result);
			self::$buffer['sections']['body']	 = $sections['body']						 = $result['sections'];
			$other_tokens['body']					 = $result['other_tokens'];
			$filtered_body							 = $result['filtered_content'];
			unset( $result );

			$result = self::parse_report_content( $report_footer, $replace_tokens_values );
			//print_r($result);

			self::$buffer['sections']['footer']	 = $sections['footer']					 = $result['sections'];
			$other_tokens['footer']				 = $result['other_tokens'];
			$filtered_footer						 = $result['filtered_content'];
			unset( $result );
			//print_r($sections);
			// get data from stream plugin
			$sections_data							 = $other_tokens_data						 = array();
			$information							 = self::fetch_stream_data( $website, $report, $sections, $other_tokens, $date_from, $date_to );

			$information = self::fix_empty_logs_values( $information );

			//print_r($information);
			if ( is_array( $information ) && !isset( $information['error'] ) ) {
				self::$buffer['sections_data'] = $sections_data					 = isset( $information['sections_data'] ) ? $information['sections_data'] : array();
				$other_tokens_data				 = isset( $information['other_tokens_data'] ) ? $information['other_tokens_data'] : array();
			} else {
				self::$buffer = array();
				return $information;
			}
			unset( $information );

			self::$count_sec_header	 = self::$count_sec_body	 = self::$count_sec_footer	 = 0;
			self::$raw_sec_body		 = false;

			if ( $type == 'raw' ) {
				// support get raw report data for body only
				self::$raw_sec_body		 = true;
				self::$raw_section_body	 = array();
				$filtered_raw			 = array();

				if ( is_array( $replace_tokens_values ) ) {
					foreach ( $replace_tokens_values as $token => $value ) {
						if ( strpos( $report_body, $token ) !== false ) {
							$filtered_raw[$token] = $value;
						}
					}
				}

				if ( isset( $other_tokens_data['body'] ) && is_array( $other_tokens_data['body'] ) ) {
					foreach ( $other_tokens_data['body'] as $token => $value ) {
						if ( in_array( $token, $other_tokens['body'] ) ) {
							$filtered_raw[$token] = $value;
						}
					}
				}

				if ( isset( $sections_data['body'] ) && is_array( $sections_data['body'] ) ) {
					$filtered_body = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', array('MainWP_CReport', 'section_mark_body'), $filtered_body );
					if ( is_array( self::$raw_section_body ) ) {
						foreach ( self::$raw_section_body as $sectoken => $values ) {
							$filtered_raw[$sectoken] = $values;
						}
					}
				}

				return $filtered_raw;
			}


			if ( isset( $sections_data['header'] ) && is_array( $sections_data['header'] ) && count( $sections_data['header'] ) > 0 ) {
				$filtered_header = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', array('MainWP_CReport', 'section_mark_header'), $filtered_header );
			}

			if ( isset( $sections_data['body'] ) && is_array( $sections_data['body'] ) && count( $sections_data['body'] ) > 0 ) {
				$filtered_body = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', array('MainWP_CReport', 'section_mark_body'), $filtered_body );
			}

			if ( isset( $sections_data['footer'] ) && is_array( $sections_data['footer'] ) && count( $sections_data['footer'] ) > 0 ) {
				$filtered_footer = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', array('MainWP_CReport', 'section_mark_footer'), $filtered_footer );
			}

			if ( isset( $other_tokens_data['header'] ) && is_array( $other_tokens_data['header'] ) && count( $other_tokens_data['header'] ) > 0 ) {
				$search	 = $replace = array();
				foreach ( $other_tokens_data['header'] as $token => $value ) {
					if ( in_array( $token, $other_tokens['header'] ) ) {
						$search[]	 = $token;
						$replace[]	 = $value;
					}
				}
				$filtered_header = self::replace_content( $filtered_header, $search, $replace );
			}

			if ( isset( $other_tokens_data['body'] ) && is_array( $other_tokens_data['body'] ) && count( $other_tokens_data['body'] ) > 0 ) {
				$search	 = $replace = array();
				foreach ( $other_tokens_data['body'] as $token => $value ) {
					if ( in_array( $token, $other_tokens['body'] ) ) {
						$search[]	 = $token;
						$replace[]	 = $value;
					}
				}
				$filtered_body = self::replace_content( $filtered_body, $search, $replace );
			}

			if ( isset( $other_tokens_data['footer'] ) && is_array( $other_tokens_data['footer'] ) && count( $other_tokens_data['footer'] ) > 0 ) {
				$search	 = $replace = array();
				foreach ( $other_tokens_data['footer'] as $token => $value ) {
					if ( in_array( $token, $other_tokens['footer'] ) ) {
						$search[]	 = $token;
						$replace[]	 = $value;
					}
				}
				$filtered_footer = self::replace_content( $filtered_footer, $search, $replace );
			}

			$output->filtered_header = $filtered_header;
			$output->filtered_body	 = $filtered_body;
			$output->filtered_footer = $filtered_footer;
			self::$buffer			 = array();
		}
		return $output;
	}

	public static function section_mark_header( $matches ) {
		$content	 = $matches[0];
		$sec		 = $matches[1];
		$index		 = self::$count_sec_header;
		$search		 = self::$buffer['sections']['header']['section_content_tokens'][$index];
		self::$count_sec_header++;
		$sec_content = trim( $matches[2] );
		if ( isset( self::$buffer['sections_data']['header'][$index] ) && !empty( self::$buffer['sections_data']['header'][$index] ) ) {
			$loop				 = self::$buffer['sections_data']['header'][$index];
			$replaced_content	 = '';
			if ( is_array( $loop ) ) {
				foreach ( $loop as $replace ) {
					//$replace = self::sucuri_replace_data($replace);;
					$replaced			 = self::replace_section_content( $sec_content, $search, $replace );
					$replaced_content	 .= '<p style="margin: 2px 0px 2px 0px">' . $replaced . "</p>";
				}
			}
			return $replaced_content;
		}
		return '';
	}

	public static function section_mark_body( $matches ) {
		$content	 = $matches[0];
		$start_sec	 = $matches[1];
		$index		 = self::$count_sec_body;
		$search		 = self::$buffer['sections']['body']['section_content_tokens'][$index];
		self::$count_sec_body++;
		$sec_content = trim( $matches[2] );
		if ( isset( self::$buffer['sections_data']['body'][$index] ) && !empty( self::$buffer['sections_data']['body'][$index] ) ) {
			$loop				 = self::$buffer['sections_data']['body'][$index];
			$replaced_content	 = '';
			if ( is_array( $loop ) ) {
				foreach ( $loop as $replace ) {
					//$replace = self::sucuri_replace_data($replace);
					$replaced			 = self::replace_section_content( $sec_content, $search, $replace );
					$replaced_content	 .= '<p style="margin: 2px 0px 2px 0px">' . $replaced . "</p>";
					if ( self::$raw_sec_body == true ) {
						self::$raw_section_body[$start_sec][] = $replaced;
					}
				}
			}
			return $replaced_content;
		}
		return '';
	}

	public static function section_mark_footer( $matches ) {
		$content	 = $matches[0];
		$sec		 = $matches[1];
		$index		 = self::$count_sec_footer;
		$search		 = self::$buffer['sections']['footer']['section_content_tokens'][$index];
		self::$count_sec_footer++;
		$sec_content = trim( $matches[2] );
		if ( isset( self::$buffer['sections_data']['footer'][$index] ) && !empty( self::$buffer['sections_data']['footer'][$index] ) ) {
			$loop				 = self::$buffer['sections_data']['footer'][$index];
			$replaced_content	 = '';
			if ( is_array( $loop ) ) {
				foreach ( $loop as $replace ) {
					//$replace = self::sucuri_replace_data($replace);
					$replaced			 = self::replace_section_content( $sec_content, $search, $replace );
					$replaced_content	 .= '<p style="margin: 2px 0px 2px 0px">' . $replaced . "</p>";
				}
			}
			return $replaced_content;
		}
		return '';
	}

	function ajax_delete_client() {
		self::verify_nonce();
		$client_id = $_POST['client_id'];
		if ( $client_id ) {
			if ( MainWP_CReport_DB::get_instance()->delete_client( 'clientid', $client_id ) ) {
				die( 'SUCCESS' );
			}
		}
		die( 'FAILED' );
	}

	public static function replace_content( $content, $tokens, $replace_tokens ) {
		return str_replace( $tokens, $replace_tokens, $content );
	}

	public static function replace_section_content( $content, $tokens,
												 $replace_tokens ) {
		foreach ( $replace_tokens as $token => $value ) {
			$value	 = strip_tags( $value ); // to fix
			$content = str_replace( $token, $value, $content );
		}
		$content = str_replace( $tokens, array(), $content ); // clear others tokens
		return $content;
	}

	public static function parse_report_content( $content, $replaceTokensValues ) {
		$client_tokens		 = array_keys( $replaceTokensValues );
		$replace_values		 = array_values( $replaceTokensValues );
		$filtered_content	 = $content			 = str_replace( $client_tokens, $replace_values, $content );
		$sections			 = array();
		if ( preg_match_all( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', $content, $matches ) ) {
			for ( $i = 0; $i < count( $matches[1] ); $i++ ) {
				$sec		 = $matches[1][$i];
				$sec_content = $matches[2][$i];
				$sec_tokens	 = array();
				if ( preg_match_all( '/\[[^\]]+\]/is', $sec_content, $matches2 ) ) {
					$sec_tokens = $matches2[0];
				}
				//$sections[$sec] = $sec_tokens;
				$sections['section_token'][]			 = $sec;
				$sections['section_content_tokens'][]	 = $sec_tokens;
			}
		}

		// remove sections token, to find other tokens in the report content
		$removed_sections	 = preg_replace_callback( '/(\[section\.[^\]]+\])(.*?)(\[\/section\.[^\]]+\])/is', '__return_empty_string', $content );
		$other_tokens		 = array();
		if ( preg_match_all( '/\[[^\]]+\]/is', $removed_sections, $matches ) ) {
			$other_tokens = $matches[0];
		}
		return array('sections' => $sections, 'other_tokens' => $other_tokens, 'filtered_content' => $filtered_content);
	}

	public static function fix_empty_logs_values( $infor ) {

		$secs = array(
			'header',
			'body',
			'footer'
		);
		foreach ( $secs as $sec ) {
			if ( isset( $infor['sections_data'] ) && isset( $infor['sections_data'][$sec] ) ) {
				$sections_data		 = $infor['sections_data'][$sec];
				$other_tokens_data	 = $infor['other_tokens_data']['body'];

				$fix_section_count	 = array();
				$fix_sections_data	 = $sections_data;
				foreach ( $sections_data as $index1 => $sec_logs ) {
					foreach ( $sec_logs as $index2 => $log_records ) {

						$removed_empty = false;
						foreach ( $log_records as $token => $value ) {
							if ( empty( $value ) ) {
								unset( $fix_sections_data[$index1][$index2] );
								$removed_empty = true;
								break;
							}
						}

						if ( $removed_empty ) {
							foreach ( $log_records as $token => $value ) {
								$str_tmp	 = str_replace( array('[', ']'), '', $token );
								$array_tmp	 = explode( '.', $str_tmp );

								if ( count( $array_tmp ) == 3 ) { // to able to get .count token
									if ( isset( $fix_section_count[$token] ) ) {
										$fix_section_count[$token] ++;
									} else {
										$fix_section_count[$token] = 1;
									}
									break;
								}
							}
						}
					}
				}

				// fix count tokens value
				foreach ( $fix_section_count as $tk => $count ) {
					$str_tmp	 = str_replace( array('[', ']'), '', $tk );
					$array_tmp	 = explode( '.', $str_tmp );
					list( $context, $action, $data ) = $array_tmp;
					$count_token = '[' . $context . '.' . $action . '.count]';
					if ( isset( $other_tokens_data[$count_token] ) && ( $other_tokens_data[$count_token] >= $count) ) {
						$other_tokens_data[$count_token] = $other_tokens_data[$count_token] - $count; // fix count value
					}
				}
				$infor['other_tokens_data'][$sec]	 = $other_tokens_data;
				$infor['sections_data'][$sec]		 = $fix_sections_data;
			}
		}
		return $infor;
	}

	public static function remove_section_tokens( $content ) {
		$matches		 = array();
		$section_tokens	 = array();
		$section		 = '';
		if ( preg_match_all( '/\[\/?section\.[^\]]+\]/is', $content, $matches ) ) {
			$section_tokens	 = $matches[0];
			$str_tmp		 = str_replace( array('[', ']'), '', $section_tokens[0] );
			list($context, $action, $section) = explode( '.', $str_tmp );
		}
		$content = str_replace( $section_tokens, '', $content );
		return array('content' => $content, 'section' => $section);
	}

	static function ga_data( $site_id, $start_date, $end_date, $chart = false ) {
		// fix bug cron job
		if ( null === self::$enabled_ga ) {
			self::$enabled_ga = apply_filters( 'mainwp-extension-available-check', 'mainwp-google-analytics-extension' );
		}

		if ( !self::$enabled_ga ) {
			return false;
		}

		//===============================================================
		//enym new
		//        $end_date = strtotime("-1 day", time());
		//        $start_date = strtotime( '-31 day', time() ); //31 days is more robust than "1 month" and this must match steprange in MainWPGA.class.php
		//===============================================================

		if ( !$site_id || !$start_date || !$end_date ) {
			return false;
		}
		$uniq = 'ga_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[$uniq] ) ) {
			return self::$buffer[$uniq];
		}

		$result	 = apply_filters( 'mainwp_ga_get_data', $site_id, $start_date, $end_date, $chart );
		$output	 = array(
			'ga.visits'			 => 'N/A',
			'ga.pageviews'		 => 'N/A',
			'ga.pages.visit'	 => 'N/A',
			'ga.bounce.rate'	 => 'N/A',
			'ga.new.visits'		 => 'N/A',
			'ga.avg.time'		 => 'N/A',
			'ga.visits.chart'	 => 'N/A', //enym new
			'ga.visits.maximum'	 => 'N/A', //enym new
		);
		if ( !empty( $result ) && is_array( $result ) ) {
			$custom_date_format = apply_filters( 'mainwp-ga-chart-custom-date', false ); // depredicated, use 'mainwp-reports-ga-chart-format-date'
			if ( isset( $result['stats_int'] ) ) {
				$values						 = $result['stats_int'];
				$output['ga.visits']		 = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:sessions'] )) ? $values['aggregates']['ga:sessions'] : 'N/A';
				$output['ga.pageviews']	 = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:pageviews'] )) ? $values['aggregates']['ga:pageviews'] : 'N/A';
				$output['ga.pages.visit']	 = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:pageviewsPerSession'] )) ? self::format_stats_values( $values['aggregates']['ga:pageviewsPerSession'], true, false ) : 'N/A';
				$output['ga.bounce.rate']	 = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:bounceRate'] )) ? self::format_stats_values( $values['aggregates']['ga:bounceRate'], true, true ) : 'N/A';
				$output['ga.new.visits']	 = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:percentNewSessions'] )) ? self::format_stats_values( $values['aggregates']['ga:percentNewSessions'], true, true ) : 'N/A';
				$output['ga.avg.time']	 = (isset( $values['aggregates'] ) && isset( $values['aggregates']['ga:avgSessionDuration'] )) ? self::format_stats_values( $values['aggregates']['ga:avgSessionDuration'], false, false, true ) : 'N/A';
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
						$maximum_value		 = $v['1'];
						$maximum_value_date	 = $v['0'];
					}
				}

				$vertical_max	 = ceil( $maximum_value * 1.3 );
				$dimensions		 = '0,' . $vertical_max;

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
							$teile[0] = '1';
						}
						if ( 'Feb' == $teile[0] ) {
							$teile[0] = '2';
						}
						if ( 'Mar' == $teile[0] ) {
							$teile[0] = '3';
						}
						if ( 'Apr' == $teile[0] ) {
							$teile[0] = '4';
						}
						if ( 'May' == $teile[0] ) {
							$teile[0] = '5';
						}
						if ( 'Jun' == $teile[0] ) {
							$teile[0] = '6';
						}
						if ( 'Jul' == $teile[0] ) {
							$teile[0] = '7';
						}
						if ( 'Aug' == $teile[0] ) {
							$teile[0] = '8';
						}
						if ( 'Sep' == $teile[0] ) {
							$teile[0] = '9';
						}
						if ( 'Oct' == $teile[0] ) {
							$teile[0] = '10';
						}
						if ( 'Nov' == $teile[0] ) {
							$teile[0] = '11';
						}
						if ( 'Dec' == $teile[0] ) {
							$teile[0] = '12';
						}

						$format_date = '';

						if ( !$custom_date_format ) {
							if ( isset( $arr[2] ) ) { // formated date by hook (filter)
								//$graph_dates .= $arr[2] . '|';  // default mainwp GA chart date format
								$format_date = $arr[2] . '|'; // default mainwp GA chart date format
							} else {
								//$graph_dates .= $teile[1] . '.' . $teile[0] . '.|';  // default mainwp GA chart date format
								$format_date = $teile[1] . '.' . $teile[0] . '.|';  // default mainwp GA chart date format
							}
						} else {
							$format_date = $teile[0] . '/' . $teile[1] . '.|';
						}

						$format_date = apply_filters( 'mainwp-reports-ga-chart-format-date', $format_date, $teile[0], $teile[1] );
						$graph_dates .= $format_date;
					}
				}
				//$graph_dates = urlencode($graph_dates);
				$graph_dates = trim( $graph_dates, '|' );

				//SCALE chxr=1,0,HIGHEST*2
				$scale = '1,0,' . $vertical_max;

				//WIREFRAME chg=0,10,1,4
				$wire = '0,10,1,4';

				//COLORS
				$barcolor	 = '508DDE'; //4d89f9";
				$fillcolor	 = 'EDF5FF'; //CCFFFF";
				//LINEFORMAT chls=1,0,0
				$lineformat	 = '1,0,0';

				//TITLE
				//&chtt=Last+2+Weeks+Sales
				//LEGEND
				//&chdl=Sales

				$output['ga.visits.chart'] = '<img src="https://chart.apis.google.com/chart?cht=lc&chs=600x250&chd=t:' . $graph_values . '&chds=' . $dimensions . '&chco=' . $barcolor . '&chm=B,' . $fillcolor . ',0,0,0&chls=' . $lineformat . '&chxt=x,y&chxl=0:|' . $graph_dates . '&chxr=' . $scale . '&chg=' . $wire . '">';

				$date1 = explode( ' ', $maximum_value_date );
				if ( 'Jan' == $date1[0] ) {
					$date1[0] = '1';
				}
				if ( 'Feb' == $date1[0] ) {
					$date1[0] = '2';
				}
				if ( 'Mar' == $date1[0] ) {
					$date1[0] = '3';
				}
				if ( 'Apr' == $date1[0] ) {
					$date1[0] = '4';
				}
				if ( 'May' == $date1[0] ) {
					$date1[0] = '5';
				}
				if ( 'Jun' == $date1[0] ) {
					$date1[0] = '6';
				}
				if ( 'Jul' == $date1[0] ) {
					$date1[0] = '7';
				}
				if ( 'Aug' == $date1[0] ) {
					$date1[0] = '8';
				}
				if ( 'Sep' == $date1[0] ) {
					$date1[0] = '9';
				}
				if ( 'Oct' == $date1[0] ) {
					$date1[0] = '10';
				}
				if ( 'Nov' == $date1[0] ) {
					$date1[0] = '11';
				}
				if ( 'Dec' == $date1[0] ) {
					$date1[0] = '12';
				}

				$display_maximum_value_date	 = apply_filters( 'mainwp_client_reports_ga_visits_maximum_date', false, $date1[1], $date1[0] ); // day.month
				if ( empty( $display_maximum_value_date ) )
					$display_maximum_value_date	 = $date1[1] . '.' . $date1[0] . '.'; // day.month


					
//$maximum_value_date = $date1[1] . '.' . $date1[0] . '.'; // day.month
				$output['ga.visits.maximum'] = $maximum_value . ' (' . $display_maximum_value_date . ')';
			}

			$output['ga.startdate']	 = MainWP_CReport_Utility::format_datestamp( $start_date, true );
			$output['ga.enddate']		 = MainWP_CReport_Utility::format_datestamp( $end_date, true );
			//}
			//enym end
			//===============================================================
		}
		self::$buffer[$uniq] = $output;
		return $output;
	}

	static function piwik_data( $site_id, $start_date, $end_date ) {
		// fix bug cron job
		if ( null === self::$enabled_piwik ) {
			self::$enabled_piwik = apply_filters( 'mainwp-extension-available-check', 'mainwp-piwik-extension' );
		}

		if ( !self::$enabled_piwik ) {
			return false;
		}
		if ( !$site_id || !$start_date || !$end_date ) {
			return false;
		}
		$uniq = 'pw_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[$uniq] ) ) {
			return self::$buffer[$uniq];
		}

		$values = apply_filters( 'mainwp_piwik_get_data', $site_id, $start_date, $end_date );

		$output							 = array();
		$output['piwik.visits']		 = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['nb_visits'] )) ? $values['aggregates']['nb_visits'] : 'N/A';
		$output['piwik.pageviews']	 = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['nb_actions'] )) ? $values['aggregates']['nb_actions'] : 'N/A';
		$output['piwik.pages.visit']	 = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['nb_actions_per_visit'] )) ? $values['aggregates']['nb_actions_per_visit'] : 'N/A';
		$output['piwik.bounce.rate']	 = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['bounce_rate'] )) ? $values['aggregates']['bounce_rate'] : 'N/A';
		$output['piwik.new.visits']	 = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['nb_uniq_visitors'] )) ? $values['aggregates']['nb_uniq_visitors'] : 'N/A';
		$output['piwik.avg.time']		 = (is_array( $values ) && isset( $values['aggregates'] ) && isset( $values['aggregates']['avg_time_on_site'] )) ? self::format_stats_values( $values['aggregates']['avg_time_on_site'], false, false, true ) : 'N/A';
		self::$buffer[$uniq]			 = $output;

		return $output;
	}

	static function aum_data( $site_id, $start_date, $end_date ) {

		if ( null === self::$enabled_aum ) {
			self::$enabled_aum = apply_filters( 'mainwp-extension-available-check', 'advanced-uptime-monitor-extension' );
		}

		if ( !self::$enabled_aum ) {
			return false;
		}

		if ( !$site_id || !$start_date || !$end_date ) {
			return false;
		}
		$uniq = 'aum_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[$uniq] ) ) {
			return self::$buffer[$uniq];
		}

		$values								 = apply_filters( 'mainwp_aum_get_data', $site_id, $start_date, $end_date );
		//print_r($values);
		$output								 = array();
		$output['aum.alltimeuptimeratio']	 = (is_array( $values ) && isset( $values['aum.alltimeuptimeratio'] )) ? $values['aum.alltimeuptimeratio'] . '%' : 'N/A';
		$output['aum.uptime7']			 = (is_array( $values ) && isset( $values['aum.uptime7'] )) ? $values['aum.uptime7'] . '%' : 'N/A';
		$output['aum.uptime15']			 = (is_array( $values ) && isset( $values['aum.uptime15'] )) ? $values['aum.uptime15'] . '%' : 'N/A';
		$output['aum.uptime30']			 = (is_array( $values ) && isset( $values['aum.uptime30'] )) ? $values['aum.uptime30'] . '%' : 'N/A';
		$output['aum.uptime45']			 = (is_array( $values ) && isset( $values['aum.uptime45'] )) ? $values['aum.uptime45'] . '%' : 'N/A';
		$output['aum.uptime60']			 = (is_array( $values ) && isset( $values['aum.uptime60'] )) ? $values['aum.uptime60'] . '%' : 'N/A';
		$output['aum.stats']				 = (is_array( $values ) && isset( $values['aum.stats'] )) ? $values['aum.stats'] : 'N/A';

		self::$buffer[$uniq] = $output;

		return $output;
	}

	static function woocomstatus_data( $site_id, $start_date, $end_date ) {

		// fix bug cron job
		if ( null === self::$enabled_woocomstatus ) {
			self::$enabled_woocomstatus = apply_filters( 'mainwp-extension-available-check', 'mainwp-woocommerce-status-extension' );
		}

		if ( !self::$enabled_woocomstatus ) {
			return false;
		}

		if ( !$site_id || !$start_date || !$end_date ) {
			return false;
		}
		$uniq = 'wcstatus_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[$uniq] ) ) {
			return self::$buffer[$uniq];
		}

		$values		 = apply_filters( 'mainwp_woocomstatus_get_data', $site_id, $start_date, $end_date );
		$top_seller	 = 'N/A';
		if ( is_array( $values ) && isset( $values['wcomstatus.topseller'] ) ) {
			$top = $values['wcomstatus.topseller'];
			if ( is_object( $top ) && isset( $top->name ) ) {
				$top_seller = $top->name;
			}
		}

		//print_r($values);
		$output										 = array();
		$output['wcomstatus.sales']				 = (is_array( $values ) && isset( $values['wcomstatus.sales'] )) ? $values['wcomstatus.sales'] : 'N/A';
		$output['wcomstatus.topseller']			 = $top_seller;
		$output['wcomstatus.awaitingprocessing']	 = (is_array( $values ) && isset( $values['wcomstatus.awaitingprocessing'] )) ? $values['wcomstatus.awaitingprocessing'] : 'N/A';
		$output['wcomstatus.onhold']				 = (is_array( $values ) && isset( $values['wcomstatus.onhold'] )) ? $values['wcomstatus.onhold'] : 'N/A';
		$output['wcomstatus.lowonstock']			 = (is_array( $values ) && isset( $values['wcomstatus.lowonstock'] )) ? $values['wcomstatus.lowonstock'] : 'N/A';
		$output['wcomstatus.outofstock']			 = (is_array( $values ) && isset( $values['wcomstatus.outofstock'] )) ? $values['wcomstatus.outofstock'] : 'N/A';
		self::$buffer[$uniq]						 = $output;
		return $output;
	}

	static function pagespeed_tokens( $site_id, $start_date, $end_date ) {

		// fix bug cron job
		if ( null === self::$enabled_pagespeed ) {
			self::$enabled_pagespeed = apply_filters( 'mainwp-extension-available-check', 'mainwp-page-speed-extension' );
		}

		if ( !self::$enabled_pagespeed ) {
			return false;
		}

		if ( !$site_id || !$start_date || !$end_date ) {
			return false;
		}

		$uniq = 'pagespeed_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[$uniq] ) ) {
			return self::$buffer[$uniq];
		}

		$data					 = apply_filters( 'mainwp_pagespeed_get_data', array(), $site_id, $start_date, $end_date );
		self::$buffer[$uniq]	 = $data;
		return $data;
	}

	static function brokenlinks_tokens( $site_id, $start_date, $end_date ) {

		// fix bug cron job
		if ( null === self::$enabled_brokenlinks ) {
			self::$enabled_brokenlinks = apply_filters( 'mainwp-extension-available-check', 'mainwp-broken-links-checker-extension' );
		}

		if ( !self::$enabled_brokenlinks ) {
			return false;
		}

		if ( !$site_id || !$start_date || !$end_date ) {
			return false;
		}

		$uniq = 'brokenlinks_' . $site_id . '_' . $start_date . '_' . $end_date;
		if ( isset( self::$buffer[$uniq] ) ) {
			return self::$buffer[$uniq];
		}

		$data					 = apply_filters( 'mainwp_brokenlinks_get_data', array(), $site_id, $start_date, $end_date );
		self::$buffer[$uniq]	 = $data;
		return $data;
	}

	private static function format_stats_values( $value, $round = false,
											  $perc = false, $showAsTime = false ) {
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

	public static function fetch_stream_data( $website, $report, $sections,
										   $tokens, $date_from, $date_to ) {
		global $mainWPCReportExtensionActivator;
		$post_data = array(
			'mwp_action'	 => 'get_stream',
			'sections'		 => base64_encode( serialize( $sections ) ),
			'other_tokens'	 => base64_encode( serialize( $tokens ) ),
			'date_from'		 => $date_from,
			'date_to'		 => $date_to,
		);

		$post_data = apply_filters( 'mainwp_client_reports_fetch_post_data', $post_data, $website, $report );

		$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $website['id'], 'client_report', $post_data );

		if ( is_array( $information ) && !isset( $information['error'] ) ) {
			return $information;
		} else {
			if ( isset( $information['error'] ) ) {
				$error = $information['error'];
				if ( 'NO_CREPORT' == $error ) {
					$error = __( 'Error: No MainWP Client Reports plugin installed.' );
				}
			} else {
				$error = is_array( $information ) ? @implode( '<br>', $information ) : $information;
			}
			return array('error' => $error);
		}
	}

	public static function report_tab( $websites, $type = 0 ) {

		$reports = MainWP_CReport_DB::get_instance()->get_report_by( 'all' );
		if ( !is_array( $reports ) )
			$reports = array();

//		$all_sites = array();
//		if ( is_array( $websites ) ) {
//			foreach ( $websites as $website ) {
//				$all_sites[ $website['id'] ] = $website;
//			}
//		}

		$client_reports = array();

		foreach ( $reports as $rp ) {
			$client_reports[] = $rp;
		}
		?>

		<table id="mainwp-client-reports-reports-table" class="ui single line table">
			<thead>
				<tr>
					<th><?php _e( 'Report', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Client', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Send To', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Last Sent', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Date Range', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Schedule', 'mainwp-client-reports-extension' ); ?></th>
					<th class="no-sort collapsing"><?php _e( '', 'mainwp-client-reports-extension' ); ?></th>
				</tr>
			</thead>
			<tbody>
		<?php self::report_table_content( $client_reports ); ?>
			</tbody>
			<tfoot>
				<tr>
					<th><?php _e( 'Report', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Client', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Send To', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Last Sent', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Date Range', 'mainwp-client-reports-extension' ); ?></th>
					<th><?php _e( 'Schedule', 'mainwp-client-reports-extension' ); ?></th>
					<th class="no-sort collapsing"><?php _e( '', 'mainwp-client-reports-extension' ); ?></th>
				</tr>
			</tfoot>
		</table>
		<script type="text/javascript">
			jQuery( '#mainwp-client-reports-reports-table' ).DataTable( {
				"columnDefs": [ { "orderable": false, "targets": "no-sort" } ],
				"order": [ [ 1, "asc" ] ],
				"language": { "emptyTable": "No websites were found with the MainWP Child Reports plugin installed." },
				"drawCallback": function ( settings ) {
					jQuery( '#mainwp-client-reports-reports-table .ui.dropdown' ).dropdown();
				},
			} );
		</script>
		<?php
	}

	public static function report_table_content( $reports ) {

		$recurring_schedule = array(
			'daily'		 => __( 'Daily', 'mainwp-client-reports-extension' ),
			'weekly'	 => __( 'Weekly', 'mainwp-client-reports-extension' ),
			'monthly'	 => __( 'Monthly', 'mainwp-client-reports-extension' ),
			'yearly'	 => __( 'Yearly', 'mainwp-client-reports-extension' ),
		);

		$_show_completed_siteids = apply_filters( 'mainwp_client_reports_table_show_completed_site_ids', false );
		
		foreach ( $reports as $report ) {

			$is_scheduled = $report->scheduled ? true : false;

			$sche_column = _( 'Manually' );

			if ( !empty( $report->recurring_schedule ) && $is_scheduled ) {
				$sche_column = $recurring_schedule[$report->recurring_schedule];
				if ( !empty( $report->schedule_nextsend ) ) {
					$sche_column .= '<br><em>Next Run: ' . MainWP_CReport_Utility::format_timestamp( $report->schedule_nextsend ) . '</em>';
				}
			}

			$sel_sites	 = unserialize( base64_decode( $report->sites ) );
			$sel_groups	 = unserialize( base64_decode( $report->groups ) );

			if ( !is_array( $sel_sites ) ) {
				$sel_sites = array();
			}

			if ( !is_array( $sel_groups ) ) {
				$sel_groups = array();
			}

			$disable_act_buttons = true;
			if ( count( $sel_sites ) > 0 || count( $sel_groups ) > 0 ) {
				$disable_act_buttons = false;
			}

			//echo var_dump( $report );
			?>
			<tr id="<?php echo $report->id; ?>">
				<td><a href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report&action=editreport&id=<?php echo $report->id; ?>"><?php echo stripslashes( $report->title ); ?></a></td>
				<td><?php echo stripslashes( $report->client ); ?></td>
				<td><?php echo stripslashes( $report->email ); ?></td>
				<td>
					<?php
					echo !empty( $report->lastsend ) ? MainWP_CReport_Utility::format_timestamp( MainWP_CReport_Utility::get_timestamp( $report->lastsend ) ) : ''; // format to show local time.

					if ( $_show_completed_siteids ) {

						$comp_ids = !empty( $report->completed_sites ) ? @json_decode( $report->completed_sites, true ) : false;

						$str_info = '';

						if ( !empty( $comp_ids ) && is_array( $comp_ids ) ) {

							$failed_ids		 = $success_ids	 = $gen_failed_ids	 = array();
							foreach ( $comp_ids as $sid => $val ) {
								if ( $val == 1 )
									$success_ids[]		 = $sid;
								else if ( $val == 0 )
									$failed_ids[]		 = $sid;
								else if ( $val > 1 ) // generated content failed
									$gen_failed_ids[]	 = $sid;
							}

							if ( !empty( $success_ids ) ) {
								$str_info = 'Success: ' . count( $success_ids );
							}

							if ( !empty( $failed_ids ) ) {
								$str_info	 .= '<br/>';
								$str_info	 = 'Send failed: ' . count( $failed_ids );
							}

							if ( !empty( $gen_failed_ids ) ) {
								$str_info	 .= '<br/>';
								$str_info	 .= 'Generate failed: ' . count( $gen_failed_ids );
							}
						}

						if ( $str_info != '' ) {
							?>
							<br/>
							<em>
							<?php echo $str_info; ?>
							</em>
							<?php
						}
					}
					?>
				</td>
				<td>
					<?php
					if ( $is_scheduled ) {
						$date_from	 = $report->date_from_nextsend;
						$date_to	 = $report->date_to_nextsend;
						if ( empty( $date_from ) && $report->date_from )
							$date_from	 = $report->date_from;
						if ( empty( $date_to ) && $report->date_to )
							$date_to	 = $report->date_to;
					} else {
						$date_from	 = $report->date_from;
						$date_to	 = $report->date_to;
					}
					?>
					<?php echo!empty( $date_from ) ? MainWP_CReport_Utility::format_datestamp( $date_from, true ) . ' - ' : ''; ?>
			<?php echo!empty( $date_to ) ? MainWP_CReport_Utility::format_datestamp( $date_to, true ) : ''; ?>
				</td>
				<td><span class="creport_sche_column"><?php echo $sche_column; ?></span></td>
				<td>
					<div class="ui left pointing dropdown icon mini basic green button" style="z-index:999">
						<a href="javascript:void(0)"><i class="ellipsis horizontal icon"></i></a>
						<div class="menu">
							<a class="item" href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report&action=editreport&id=<?php echo $report->id; ?>"><?php _e( 'Edit', 'mainwp-client-reports-extension' ); ?></a>
							<a class="item" href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report&action=replicate&id=<?php echo $report->id; ?>"><?php _e( 'Duplicate', 'mainwp-client-reports-extension' ); ?></a>
			<?php if ( !$disable_act_buttons ) : ?>
								<a class="item" href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report&action=preview&id=<?php echo $report->id; ?>"><?php _e( 'Preview' ); ?></a>
								<a class="item" href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report&action=save_pdf&id=<?php echo $report->id; ?>" ><?php _e( 'Generate PDF' ); ?></a>
							<?php endif; ?>
							<?php if ( !$disable_act_buttons && !$is_scheduled ) : ?>
								<a class="item" href="admin.php?page=Extensions-Mainwp-Client-Reports-Extension&tab=report&action=sendreport&id=<?php echo $report->id; ?>"><?php _e( 'Send' ); ?></a>
							<?php endif; ?>
							<?php if ( $is_scheduled ) : ?>
								<a href="#" action="cancelschedule" class="item creport_action_row_lnk"><?php _e( 'Cancel Schedule' ); ?></a>
							<?php endif; ?>
							<?php if ( $report->is_archived ) : ?>
								<a href="#" action="unarchive" class="item creport_action_row_lnk" ><?php _e( 'Un-Archive' ); ?></a>
			<?php endif; ?>
							<a href="#" action="delete" class="item creport_action_row_lnk"><?php _e( 'Delete', 'mainwp-client-reports-extension' ); ?></a>
						</div>
					</div>
				</td>
			</tr>
			<?php
		}
	}

	static function tooltip_mark_token( $matches ) {
		$token_name	 = $matches[0];
		$token		 = MainWP_CReport_DB::get_instance()->get_tokens_by( 'token_name', $token_name );
		$tooltip	 = '';
		if ( $token ) {
			$token_site_values = MainWP_CReport_DB::get_instance()->get_site_token_values( $token->id );
			if ( is_array( $token_site_values ) && count( $token_site_values ) > 0 ) {
				foreach ( $token_site_values as $tok ) {
					if ( !empty( $tok->token_value ) ) {
						$tooltip .= $tok->token_value . '<br>';
					}
				}
				if ( !empty( $tooltip ) ) {
					$tooltip = rtrim( $tooltip, '<br>' );
					$tooltip = '<span class="mwp_creport_tooltip_content">' . $tooltip . '</span>';
				}
			}
		}
		if ( !empty( $tooltip ) ) {
			return '<span class="mwp_creport_tooltip_container"><span class="mwp_creport_token_tooltip">' . $matches[0] . '</span>' . $tooltip . '</span>';
		}
		return $matches[0] . $tooltip;
	}

	public static function new_report_tab( $report = null ) {
		self::new_report_setting( $report );
		self::new_report_format( $report );
	}

	public static function new_report_setting( $report = null ) {
		$scheduled_report	 = false;
		$recurringSchedule	 = '';
		$report_error		 = '';

		if ( !empty( $report ) ) {
			if ( !empty( $report->scheduled ) ) {
				$scheduled_report = true;
			}
			$recurringSchedule = $report->recurring_schedule;
			if ( !empty( $report->sending_errors ) ) {
				$report_error = $report->sending_errors;
			}
		}
		?>
		<?php if ( !empty( $report_error ) ) : ?>
			<div class="ui red message"><?php echo $report_error; ?></div>
		<?php endif; ?>
		<h3 class="ui dividing header"><?php _e( 'Report Settings', 'mainwp-client-reports-extension' ); ?></h3>
		<div class="<?php echo $scheduled_report ? 'scheduled_creport' : ''; ?> ui form <?php echo $recurringSchedule; ?>" id="mwp_creport_settings_tbl">
		<?php self::new_report_setting_table_content( $report ); ?>
		</div>
		<div class="ui form">
		<?php self::new_report_email_setting_table_content( $report ); ?>
		</div>
		<?php
	}

	public static function new_report_format( $report ) {
		self::new_report_format_table_content( $report );
	}

	public static function new_report_setting_table_content( $report = null ) {
		$title				 = $date_from			 = $date_to			 = '';
		$recurring_schedule	 = array(
			'daily'		 => __( 'Daily', 'mainwp-client-reports-extension' ),
			'weekly'	 => __( 'Weekly', 'mainwp-client-reports-extension' ),
			'monthly'	 => __( 'Monthly', 'mainwp-client-reports-extension' ),
			'yearly'	 => __( 'Yearly', 'mainwp-client-reports-extension' ),
		);

		$day_of_week = array(
			1	 => __( 'Monday', 'mainwp-client-reports-extension' ),
			2	 => __( 'Tuesday', 'mainwp-client-reports-extension' ),
			3	 => __( 'Wednesday', 'mainwp-client-reports-extension' ),
			4	 => __( 'Thursday', 'mainwp-client-reports-extension' ),
			5	 => __( 'Friday', 'mainwp-client-reports-extension' ),
			6	 => __( 'Saturday', 'mainwp-client-reports-extension' ),
			7	 => __( 'Sunday', 'mainwp-client-reports-extension' ),
		);

		$recurringSchedule			 = $recurringDate				 = $recurringMonth				 = $recurringDay				 = '';
		$scheduleSendEmail			 = 'email_auto';
		$scheduleBCCme				 = 0;
		$scheduled_report			 = false;
		$send_on_style				 = $send_on_day_of_week_style	 = $send_on_day_of_mon_style	 = $send_on_month_style		 = $monthly_style				 = 'style="display:none"';

		if ( !empty( $report ) ) {
			$title				 = $report->title;
			$date_from			 = !empty( $report->date_from ) ? gmdate( 'Y-m-d', $report->date_from ) : '';
			$date_to			 = !empty( $report->date_to ) ? gmdate( 'Y-m-d', $report->date_to ) : '';
			$recurringSchedule	 = $report->recurring_schedule;
			$recurringDay		 = $report->recurring_day;
			$scheduleSendEmail	 = $report->schedule_send_email;
			$scheduleBCCme		 = isset( $report->schedule_bcc_me ) ? $report->schedule_bcc_me : 0;
			$scheduled_report	 = isset( $report->scheduled ) && !empty( $report->scheduled ) ? true : false;

			if ( $scheduled_report && ($recurringSchedule == 'weekly' || $recurringSchedule == 'monthly' || $recurringSchedule == 'yearly') ) {
				$send_on_style = '';
				if ( $recurringSchedule == 'weekly' ) {
					$send_on_day_of_week_style = '';
				} else if ( $recurringSchedule == 'monthly' ) {
					$send_on_day_of_mon_style	 = $monthly_style				 = '';
					$recurringDate				 = $recurringDay;
				} else if ( $recurringSchedule == 'yearly' ) {
					list($recurringMonth, $recurringDate) = explode( '-', $recurringDay );
					$send_on_day_of_mon_style	 = $send_on_month_style		 = '';
				}
			}
		}
		?>
		<div class="ui grid field">
			<label class="four wide column middle aligned"><?php echo __( 'Report title', 'mainwp-client-reports-extension' ); ?></label>
			<div class="ten wide column">
				<input type="text" name="mwp_creport_title" id="mwp_creport_title" placeholder="Required field" value="<?php echo esc_attr( stripslashes( $title ) ); ?>" />
			</div>
		</div>

		<div class="ui grid field">
			<label class="four wide column middle aligned"><?php echo __( 'Report type', 'mainwp-client-reports-extension' ); ?></label>
			<div class="ten wide column">
				<select name='mainwp_creport_type' id="mainwp_creport_type" class="ui dropdown">
					<option value="0" <?php echo!$scheduled_report ? 'selected="selected"' : ''; ?>><?php _e( 'One-time report', 'mainwp-client-reports-extension' ); ?></option>
					<option value="1" <?php echo $scheduled_report ? 'selected="selected"' : ''; ?>><?php _e( 'Recurring report', 'mainwp-client-reports-extension' ); ?></option>
				</select>
			</div>
		</div>

		<div class="ui grid field show_if_scheduled">
			<label class="four wide column middle aligned"><?php echo __( 'Report schedule', 'mainwp-client-reports-extension' ); ?></label>
			<div class="six wide column">
				<select name='mainwp_creport_recurring_schedule' id="mainwp_creport_recurring_schedule" class="ui dropdown">
					<option value=""><?php _e( 'Off', 'mainwp-client-reports-extension' ); ?></option>
					<?php
					foreach ( $recurring_schedule as $value => $title ) {
						$_select = '';
						if ( $recurringSchedule == $value ) {
							$_select = 'selected';
						}
						echo '<option value="' . $value . '" ' . $_select . '>' . $title . '</option>';
					}
					?>
				</select>
			</div>
		</div>

		<div class="ui grid field show_if_scheduled mainwp_creport_send_on_wrap" <?php echo $send_on_style; ?> id="scheduled_send_on_day_of_week_wrap" <?php echo $send_on_day_of_week_style; ?>>
			<label class="four wide column middle aligned"><?php echo __( 'Send report on', 'mainwp-client-reports-extension' ); ?></label>
			<div class="six wide column">
				<select name='mainwp_creport_schedule_day' id="mainwp_creport_schedule_day" class="ui dropdown" >
					<?php
					foreach ( $day_of_week as $value => $title ) {
						$_select = '';
						if ( $recurringDay == $value ) {
							$_select = 'selected';
						}
						echo '<option value="' . $value . '" ' . $_select . '>' . $title . '</option>';
					}
					?>
				</select>
			</div>
		</div>

		<div class="ui grid field show_if_scheduled mainwp_creport_send_on_wrap" <?php echo $send_on_style; ?> id="scheduled_send_on_month_wrap" <?php echo $send_on_month_style; ?>>
			<label class="four wide column middle aligned"><?php echo __( 'Send report on', 'mainwp-client-reports-extension' ); ?></label>
			<div class="six wide column">
				<select name='mainwp_creport_schedule_month' id="mainwp_creport_schedule_month" class="ui dropdown" >
					<?php
					$months_name = array(
						1	 => __( 'January' ),
						2	 => __( 'February' ),
						3	 => __( 'March' ),
						4	 => __( 'April' ),
						5	 => __( 'May' ),
						6	 => __( 'June' ),
						7	 => __( 'July' ),
						8	 => __( 'August' ),
						9	 => __( 'September' ),
						10	 => __( 'October' ),
						11	 => __( 'November' ),
						12	 => __( 'December' ),
					);
					for ( $x = 1; $x <= 12; $x++ ) {
						$_select = '';
						if ( $recurringMonth == $x ) {
							$_select = 'selected';
						}
						echo '<option value="' . $x . '" ' . $_select . '>' . $months_name[$x] . '</option>';
					}
					?>
				</select>
			</div>
		</div>

		<div class="ui grid field show_if_scheduled mainwp_creport_send_on_wrap" <?php echo $send_on_style; ?> id="scheduled_send_on_day_of_month_wrap" <?php echo $send_on_day_of_mon_style; ?>>
			<label class="four wide column middle aligned"><?php echo __( 'Send report on', 'mainwp-client-reports-extension' ); ?></label>
			<div class="six wide column">
				<select name='mainwp_creport_schedule_day_of_month' id="mainwp_creport_schedule_day_of_month" class="ui dropdown" >
					<?php
					$day_suffix = array(
						1	 => 'st',
						2	 => 'nd',
						3	 => 'rd'
					);
					for ( $x = 1; $x <= 31; $x++ ) {
						$_select = '';
						if ( $recurringDate == $x ) {
							$_select = 'selected';
						}
						$remain	 = $x % 10;
						$day_sf	 = isset( $day_suffix[$remain] ) ? $day_suffix[$remain] : 'th';
						echo '<option value="' . $x . '" ' . $_select . '>' . $x . $day_sf . ' of the month</option>';
					}
					?>
				</select>
			</div>
		</div>

		<div class="ui grid field hide_if_scheduled">
			<label class="four wide column middle aligned"><?php echo __( 'Date range', 'mainwp-client-reports-extension' ); ?></label>
			<div class="three wide column">
				<div class="ui calendar" >
					<div class="ui input left icon">
						<i class="calendar icon"></i>
						<input type="text" placeholder="From (yyyy-m-d)" name="mwp_creport_date_from" id="mwp_creport_date_from" value="<?php echo $date_from; ?>"/>
					</div>
				</div>
			</div>
			<div class="three wide column">
				<div class="ui calendar" >
					<div class="ui input left icon">
						<i class="calendar icon"></i>
						<input type="text" placeholder="To (yyyy-m-d)" name="mwp_creport_date_to" id="mwp_creport_date_to" value="<?php echo $date_to; ?>" />
					</div>
				</div>
			</div>
		</div>

		<div class="ui grid field show_if_scheduled">
			<label class="four wide column middle aligned"><?php echo __( 'Send options', 'mainwp-client-reports-extension' ); ?></label>
			<div class="six wide column">
				<div class="ui radio checkbox">
					<input type="radio" name="mainwp_creport_schedule_send_email" value="email_review" id="mainwp_creport_schedule_send_email_me_review" <?php echo ('email_review' == $scheduleSendEmail) ? 'checked' : ''; ?>/><label for="mainwp_creport_schedule_send_email_me_review"><?php _e( 'Email me when report is complete so I can review' ); ?></label>
				</div>
				<br />
				<div class="ui radio checkbox">
					<input type="radio" name="mainwp_creport_schedule_send_email" value="email_auto" id="mainwp_creport_schedule_send_email_auto" <?php echo ('email_auto' == $scheduleSendEmail) ? 'checked' : ''; ?>/><label for="mainwp_creport_schedule_send_email_auto"><?php _e( 'Automatically email my client the report' ); ?></label>
				</div>
				<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="ui checkbox">
					<input type="checkbox" name="mainwp_creport_schedule_bbc_me_email" value="1" id="mainwp_creport_schedule_bbc_me_email" <?php echo $scheduleBCCme ? 'checked' : ''; ?>/><label for="mainwp_creport_schedule_bbc_me_email"><?php _e( 'BCC me on report email' ); ?></label>
				</div>
			</div>
		</div>

		<script>
			jQuery( document ).ready( function ( $ ) {
				mainwp_creport_recurring_select_date_init();

			} );
		</script>
		<?php
	}

	public static function new_report_email_setting_table_content( $report = null ) {
		$from_name		 = $from_company	 = $from_email		 = '';

		$to_client		 = '[client.name]';
		$to_name		 = '[client.name]';
		$to_company		 = '[client.company]';
		$to_email		 = '[client.email]';
		$email_subject	 = 'Report for [client.site.name]';
		$bcc_email		 = '';

		$client_id	 = 0;
		$attachFiles = '';

		if ( !empty( $report ) ) {
			// send from info
			$from_name		 = $report->fname;
			$from_company	 = $report->fcompany;
			$from_email		 = $report->femail;

			// to client info
			$to_name		 = $report->name;
			$to_company		 = $report->company;
			$to_email		 = $report->email;
			$bcc_email		 = $report->bcc_email;
			$to_client		 = $report->client;
			$email_subject	 = $report->subject;


			$attachFiles = isset( $report->attach_files ) ? $report->attach_files : '';

			$client_id = intval( $report->client_id );
			if ( $client_id ) {
				$client = MainWP_CReport_DB::get_instance()->get_client_by( 'clientid', $client_id );
				if ( !empty( $client ) ) {
					$to_client	 = $client->client;
					$to_name	 = $client->name;
					$to_company	 = $client->company;
					$to_email	 = $client->email;
				}
			}
		}
		?>
		<h3 class="ui dividing header"><?php echo __( 'Report Email Settings', 'mainwp-client-reports-extension' ); ?></h3>
		<div class="ui grid field">
			<label class="four wide column middle aligned"><?php echo __( 'Send from', 'mainwp-client-reports-extension' ); ?></label>
			<div class="three wide column">
				<input type="text" name="mwp_creport_femail" id="mwp_creport_femail" placeholder="Email (required)" value="<?php echo esc_attr( stripslashes( $from_email ) ); ?>" />
			</div>
			<div class="three wide column">
				<input type="text" name="mwp_creport_fname" id="mwp_creport_fname" placeholder="Name" value="<?php echo esc_attr( stripslashes( $from_name ) ); ?>" />
			</div>
			<div class="three wide column">
				<input type="text" name="mwp_creport_fcompany" id="mwp_creport_fcompany" placeholder="Company" value="<?php echo esc_attr( stripslashes( $from_company ) ); ?>" />
			</div>
		</div>

		<div class="ui grid field">
			<label class="four wide column middle aligned"><?php echo __( 'Send to', 'mainwp-client-reports-extension' ); ?></label>
			<div class="three wide column">
				<input type="text" name="mwp_creport_email" placeholder="Email (required)" value="<?php echo esc_attr( stripslashes( $to_email ) ); ?>" id="mwp_creport_email"/>
			</div>
			<div class="three wide column">
				<input type="text" name="mwp_creport_name" placeholder="Name" value="<?php echo esc_attr( stripslashes( $to_name ) ); ?>" id="mwp_creport_name" />
			</div>
			<div class="three wide column">
				<input type="text" name="mwp_creport_company" placeholder="Company" value="<?php echo esc_attr( stripslashes( $to_company ) ); ?>" id="mwp_creport_company" />
			</div>
			<div class="three wide column">
				<input type="text" name="mwp_creport_client" placeholder="Client" value="<?php echo esc_attr( stripslashes( $to_client ) ); ?>" id="mwp_creport_client" />
			</div>
		</div>

		<div class="ui grid field">
			<label class="four wide column middle aligned"><?php echo __( 'BCC', 'mainwp-client-reports-extension' ); ?></label>
			<div class="twelve wide column">
				<input type="text" name="mwp_creport_bcc_email" id="mwp_creport_bcc_email" placeholder="Email address (optional)" value="<?php echo esc_attr( stripslashes( $bcc_email ) ); ?>" />
			</div>
		</div>

		<div class="ui grid field">
			<label class="four wide column middle aligned"><?php echo __( 'Subject', 'mainwp-client-reports-extension' ); ?></label>
			<div class="twelve wide column">
				<input type="text" name="mwp_creport_email_subject" value="<?php echo esc_attr( stripslashes( $email_subject ) ); ?>" id="mwp_creport_email_subject" />
			</div>
		</div>

		<div class="ui grid field">
			<label class="four wide column middle aligned"><?php echo __( 'Attachment', 'mainwp-client-reports-extension' ); ?></label>
			<div class="four wide column">
				<input type="file" name="mainwp_creport_attach_files[]"  id="mainwp_creport_attach_files[]" multiple="true">
			</div>
		<?php if ( !empty( $attachFiles ) ) : ?>
				<div class="eight wide column">
					<div><?php echo $attachFiles ?></div>
					<span class="ui checkbox">
						<input type="checkbox" value="1"  id="mainwp_creport_delete_attach_files" name="mainwp_creport_delete_attach_files">
						<label cfor="mainwp_creport_delete_attach_files"><?php _e( 'Delete attached files', 'mainwp-client-reports-extension' ); ?></label>
					</span>
				</div>
		<?php endif; ?>
		</div>
		<input type="hidden" name="mwp_creport_client_id" value="<?php echo esc_attr( $client_id ); ?>">
		<?php
	}

	public static function new_report_format_table_content( $report = null ) {
		$header		 = $body		 = $footer		 = $file_logo	 = '';

		if ( $report && is_object( $report ) ) {
			$header	 = $report->header;
			$body	 = $report->body;
			$footer	 = $report->footer;
		}

		$client_tokens			 = MainWP_CReport_DB::get_instance()->get_tokens();
		$client_tokens_values	 = array();
		$website				 = null;

		$header_formats	 = MainWP_CReport_DB::get_instance()->get_formats( 'H' );
		$body_formats	 = MainWP_CReport_DB::get_instance()->get_formats( 'B' );
		$footer_formats	 = MainWP_CReport_DB::get_instance()->get_formats( 'F' );
		if ( !is_array( $header_formats ) ) {
			$header_formats = array();
		}
		if ( !is_array( $body_formats ) ) {
			$body_formats = array();
		}
		if ( !is_array( $footer_formats ) ) {
			$footer_formats = array();
		}
		?>
		<h3 class="ui dividing header"><?php echo __( 'Report Content', 'mainwp-client-reports-extension' ); ?></h3>
		<div class="ui grid field">
			<label class="four wide column top aligned"><?php echo __( 'Report Header', 'mainwp-client-reports-extension' ); ?></label>
			<div class="twelve wide column">
				<?php
				add_filter( 'mce_buttons', 'add_tinymce_toolbar_button' );
				add_filter( 'tiny_mce_before_init', 'tinymce_before_init', 10, 2 );

				function add_tinymce_toolbar_button( $buttons ) {
					array_push( $buttons, 'insertsection', 'insertreporttoken' );
					return $buttons;
				}

				function tinymce_before_init( $settings, $eid ) {
					return $settings;
				}

				remove_editor_styles(); // stop custom theme styling interfering with the editor
				wp_editor( stripslashes( $header ), 'mainwp_creport_report_header', array(
					'textarea_name'	 => 'mainwp_creport_report_header',
					'textarea_rows'	 => 10,
					'teeny'			 => false,
					'media_buttons'	 => true
					)
				);
				?>
				<div class="ui fitted hidden divider"></div>
				<div class="ui grid temp-section-wrapper">
					<div class="two column row">
						<div class="column">
							<span class="ui mini input"><input type="text" placeholder="<?php _e( 'Save report header title', 'mainwp-client-reports-extension' ); ?>" name="mainwp_creport_report_save_header" value=""/></span>
							<input type="button" format="H" ed-name="header" class="ui green mini button mainwp_creport_report_save_format_btn" value="<?php _e( 'Save Template', 'mainwp-client-reports-extension' ); ?>"/>
						</div>
						<div class="right aligned column">
							<span class="status" style="float:left"></span>
							<span class="ui mini form">
								<select name="mainwp_creport_report_insert_header_sle" class="ui dropdown">
									<option value="0"><?php _e( 'Select report header', 'mainwp-client-reports-extension' ); ?></option>
									<?php
									foreach ( $header_formats as $format ) {
										echo '<option value="' . $format->id . '">' . esc_html( $format->title ) . '</option>';
									}
									?>
								</select>
							</span>
							<input type="button" ed-name="header" class="ui mini button mainwp_creport_report_delete_format_btn" value="<?php _e( 'Delete', 'mainwp-client-reports-extension' ); ?>"/>
							<input type="button" ed-name="header" class="ui button mini green mainwp_creport_report_insert_format_btn" value="<?php _e( 'Insert', 'mainwp-client-reports-extension' ); ?>"/>
						</div>
					</div>
				</div>
				<div class="ui fitted hidden divider"></div>
				<div class="ui center aligned secondary segment">
					<a href="#" class="mainwp_creport_show_insert_tokens_book_lnk ui mini green basic button"><?php _e( 'Show Available Tokens', 'mainwp-client-reports-extension' ); ?></a>
		<?php self::gen_insert_tokens_box( 'header', true, $client_tokens_values, $client_tokens, $website ); ?>
				</div>
			</div>
		</div>

		<div class="ui grid field">
			<label class="four wide column top aligned"><?php echo __( 'Report Body', 'mainwp-client-reports-extension' ); ?></label>
			<div class="twelve wide column">
				<?php
				remove_editor_styles(); // stop custom theme styling interfering with the editor
				wp_editor( stripslashes( $body ), 'mainwp_creport_report_body', array(
					'textarea_name'	 => 'mainwp_creport_report_body',
					'textarea_rows'	 => 20,
					'teeny'			 => false,
					'media_buttons'	 => true
					)
				);
				?>
				<div class="ui fitted hidden divider"></div>
				<div class="ui grid temp-section-wrapper">
					<div class="two column row">
						<div class="column">
							<span class="ui mini input"><input type="text" placeholder="<?php _e( 'Save report body', 'mainwp-client-reports-extension' ); ?>" name="mainwp_creport_report_save_header" value=""/></span>
							<input type="button" format="B" ed-name="body" class="ui green mini button mainwp_creport_report_save_format_btn" value="<?php _e( 'Save Template', 'mainwp-client-reports-extension' ); ?>"/>
						</div>
						<div class="right aligned column">
							<span class="status" style="float:left"></span>
							<span class="ui mini form">
								<select name="mainwp_creport_report_insert_header_sle" class="ui dropdown">
									<option value="0"><?php _e( 'Select report body', 'mainwp-client-reports-extension' ); ?></option>
									<?php
									foreach ( $body_formats as $format ) {
										echo '<option value="' . $format->id . '">' . esc_html( $format->title ) . '</option>';
									}
									?>
								</select>
							</span>
							<input type="button" ed-name="body" class="ui mini button mainwp_creport_report_delete_format_btn" value="<?php _e( 'Delete', 'mainwp-client-reports-extension' ); ?>"/>
							<input type="button" ed-name="body" class="ui button mini green mainwp_creport_report_insert_format_btn" value="<?php _e( 'Insert', 'mainwp-client-reports-extension' ); ?>"/>
						</div>
					</div>
				</div>
				<div class="ui fitted hidden divider"></div>
				<div class="ui center aligned secondary segment">
					<a href="#" class="mainwp_creport_show_insert_tokens_book_lnk ui mini green basic button"><?php _e( 'Show Available Tokens', 'mainwp-client-reports-extension' ); ?></a>
		<?php self::gen_insert_tokens_box( 'body', true, $client_tokens_values, $client_tokens, $website ); ?>
				</div>
			</div>
		</div>

		<div class="ui grid field">
			<label class="four wide column top aligned"><?php echo __( 'Report Footer', 'mainwp-client-reports-extension' ); ?></label>
			<div class="twelve wide column">
				<?php
				remove_editor_styles(); // stop custom theme styling interfering with the editor
				wp_editor( stripslashes( $footer ), 'mainwp_creport_report_footer', array(
					'textarea_name'	 => 'mainwp_creport_report_footer',
					'textarea_rows'	 => 10,
					'teeny'			 => false,
					'media_buttons'	 => true
					)
				);
				?>
				<div class="ui fitted hidden divider"></div>
				<div class="ui grid temp-section-wrapper">
					<div class="two column row">
						<div class="column">
							<span class="ui mini input"><input type="text" placeholder="<?php _e( 'Save report footer', 'mainwp-client-reports-extension' ); ?>" name="mainwp_creport_report_save_footer" value=""/></span>
							<input type="button" format="F" ed-name="footer" class="ui green mini button mainwp_creport_report_save_format_btn" value="<?php _e( 'Save Template', 'mainwp-client-reports-extension' ); ?>"/>
						</div>
						<div class="right aligned column">
							<span class="status" style="float:left"></span>
							<span class="ui mini form">
								<select name="mainwp_creport_report_insert_header_sle" class="ui dropdown">
									<option value="0"><?php _e( 'Select report footer', 'mainwp-client-reports-extension' ); ?></option>
									<?php
									foreach ( $footer_formats as $format ) {
										echo '<option value="' . $format->id . '">' . esc_html( $format->title ) . '</option>';
									}
									?>
								</select>
							</span>
							<input type="button" ed-name="footer" class="ui mini button mainwp_creport_report_delete_format_btn" value="<?php _e( 'Delete', 'mainwp-client-reports-extension' ); ?>"/>
							<input type="button" ed-name="footer" class="ui button mini green mainwp_creport_report_insert_format_btn" value="<?php _e( 'Insert', 'mainwp-client-reports-extension' ); ?>"/>
						</div>
					</div>
				</div>
				<div class="ui fitted hidden divider"></div>
				<div class="ui center aligned secondary segment">
					<a href="#" class="mainwp_creport_show_insert_tokens_book_lnk ui mini green basic button"><?php _e( 'Show Available Tokens', 'mainwp-client-reports-extension' ); ?></a>
		<?php self::gen_insert_tokens_box( 'footer', true, $client_tokens_values, $client_tokens, $website ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	public static function gen_insert_tokens_box( $editor, $hide = false,
											   $client_tokens_values, $client_tokens, $website ) {
		?>
		<div class="creport_format_insert_tokens_box <?php echo $hide ? 'hidden-field' : ''; ?>" editor="<?php echo $editor; ?>">
			<div class="creport_format_data_tokens">
				<div class="creport_format_group_nav top">
					<?php
					$visible	 = 'client';
					$nav_group	 = '';
					foreach ( self::$tokens_nav_top as $group => $group_title ) {
						$disabled = '';
						if ( (!self::$enabled_sucuri && ('sucuri' == $group)) ||
							(!self::$enabled_ga && ('ga' == $group)) ||
							(!self::$enabled_piwik && ('piwik' == $group)) ||
							(!self::$enabled_aum && ('aum' == $group)) ||
							(!self::$enabled_woocomstatus && ('woocomstatus' == $group)) ||
							(!self::$enabled_wordfence && ('wordfence' == $group)) ||
							(!self::$enabled_maintenance && ('maintenance' == $group)) ||
							(!self::$enabled_pagespeed && ('pagespeed' == $group))
						) {
							$disabled = 'disabled';
						}
						$first_group = current( array_keys( self::$stream_tokens[$group]['nav_group_tokens'] ) );
						$first_title = reset( self::$stream_tokens[$group]['nav_group_tokens'] );

						$current	 = ($visible == $group) ? 'current' : '';
						$nav_group	 .= '<a href="#" group="' . $group . '" group-title="' . $group_title . '" class="creport_nav_group_lnk ' . $current . ' ' . $disabled . '" first-group="' . $first_group . '" first-title="' . $first_title . '">' . $group_title . '</a> | ';
					}
					$nav_group		 = rtrim( $nav_group, ' | ' );
					echo $nav_group;
					?>
				</div>
				<?php
				$visible_group	 = $visible . '_tokens';
				foreach ( self::$stream_tokens as $group => $group_tokens ) {
					$enabled		 = true;
					$str_requires	 = '';
					if ( !self::$enabled_sucuri && 'sucuri' == $group ) {
						$str_requires	 = 'Requires' . ' <a href="https://mainwp.com/extension/sucuri/" title="MainWP Sucuri Extension">MainWP Sucuri Extension</a>';
						$enabled		 = false;
					} else if ( !self::$enabled_ga && 'ga' == $group ) {
						$str_requires	 = 'Requires' . ' <a href="https://mainwp.com/extension/google-analytics/" title="MainWP Google Analytics Extension">MainWP Google Analytics Extension</a>';
						$enabled		 = false;
					} else if ( !self::$enabled_piwik && 'piwik' == $group ) {
						$str_requires	 = 'Requires' . ' <a href="https://mainwp.com/extension/piwik/" title="MainWP Piwik Extension">MainWP Piwik Extension</a>';
						$enabled		 = false;
					} else if ( !self::$enabled_aum && 'aum' == $group ) {
						$str_requires	 = 'Requires' . ' <a href="https://mainwp.com/extension/advanced-uptime-monitor/" title="Advanced Uptime Monitor Extension">Advanced Uptime Monitor Extension</a>';
						$enabled		 = false;
					} else if ( !self::$enabled_woocomstatus && 'woocomstatus' == $group ) {
						$str_requires	 = 'Requires' . ' <a href="https://mainwp.com/extension/woocommerce-status/" title="MainWP WooCommerce Status Extension">MainWP WooCommerce Status Extension</a>';
						$enabled		 = false;
					} else if ( !self::$enabled_wordfence && 'wordfence' == $group ) {
						$str_requires	 = 'Requires' . ' <a href="https://mainwp.com/extension/wordfence/" title="MainWP Wordfence Extension">MainWP Wordfence Extension</a>';
						$enabled		 = false;
					} else if ( !self::$enabled_maintenance && 'maintenance' == $group ) {
						$str_requires	 = 'Requires' . ' <a href="https://mainwp.com/extension/maintenance/" title="MainWP Maintenance Extension">MainWP Maintenance Extension</a>';
						$enabled		 = false;
					} else if ( !self::$enabled_pagespeed && 'pagespeed' == $group ) {
						$str_requires	 = 'Requires' . ' <a href="https://mainwp.com/extension/page-speed/" title="MainWP Page Speed Extension">MainWP Page Speed Extension</a>';
						$enabled		 = false;
					}

					if ( !$enabled ) {
						?>
						<div class="creport_format_group_data_tokens" group="<?php echo $group; ?>">
							<div class="mainwp_info-box" style="text-align: center"><?php echo $str_requires; ?></div>
						</div>
						<?php
						continue;
					}

					foreach ( $group_tokens as $key => $tokens ) {
						if ( 'nav_group_tokens' == $key ) {
							continue;
						}
						?>
						<div class="creport_format_group_data_tokens <?php echo ( $visible_group == $group . '_' . $key ) ? 'current' : ''; ?>" group="<?php echo $group . '_' . $key; ?>">
							<div class="ui divider"></div>
							<table class="ui selectable very compact table">
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
							<div class="ui divider"></div>
						</div>
						<?php
					}
				}
				?>
			</div>

			<div class="creport_format_nav_bottom">
				<?php
				$visible	 = 'client';
				$visible_nav = 'tokens';
				foreach ( self::$stream_tokens as $group => $group_tokens ) {
					if ( (!self::$enabled_sucuri && 'sucuri' == $group ) ||
						(!self::$enabled_ga && 'ga' == $group ) ||
						(!self::$enabled_piwik && 'piwik' == $group ) ||
						(!self::$enabled_aum && 'aum' == $group ) ||
						(!self::$enabled_woocomstatus && 'woocomstatus' == $group ) ||
						(!self::$enabled_wordfence && ( 'wordfence' == $group ) ) ||
						(!self::$enabled_maintenance && ( 'maintenance' == $group ) ) ||
						(!self::$enabled_pagespeed && ( 'pagespeed' == $group ) )
					) {
						echo '<div class="creport_format_group_nav bottom" group="' . $group . '">&nbsp</div>';
						continue;
					}

					$nav_group_bottom	 = '';
					$group_title		 = self::$tokens_nav_top[$group];
					foreach ( $group_tokens['nav_group_tokens'] as $nav_key => $nav_value ) {
						$current_nav		 = ($visible . '_' . $visible_nav == $group . '_' . $nav_key) ? 'current' : '';
						$nav_group_bottom	 .= '<a href="#" group="' . $group . '_' . $nav_key . '" group-title="' . $group_title . '" group2-title="' . $nav_value . '" class="creport_nav_bottom_group_lnk ' . $current_nav . '">' . $nav_value . '</a> | ';
					}
					$nav_group_bottom	 = rtrim( $nav_group_bottom, ' | ' );
					$current			 = ($visible == $group) ? 'current' : '';
					echo '<div class="creport_format_group_nav bottom ' . $current . '" group="' . $group . '">' . $nav_group_bottom . '</div>';
				}
				$breadcrumb = '<a href="javascript:void(0)" class="group" >' . self::$tokens_nav_top[$visible] .
					'</a><span class="crp_content_group2 hidden-field"> > ' . '<a href="javascript:void(0)" class="group2">' .
					//self::$stream_tokens[$visible]['nav_group_tokens'][$visible_nav] .
					'</a></span>';
				?>
				<div class="ui divider"></div>

				<div class="creport_format_nav_bottom_breadcrumb">
		<?php _e( 'You are currently here:' ) ?> <span><?php echo $breadcrumb; ?></span>
					<span class="mwp_creport_edit_client_tokens" style="float: right"><?php echo!empty( $website ) ? '<a href="admin.php?page=managesites&id=' . $website['id'] . '">' . __( 'Edit Client Tokens' ) . '</a>' : '' ?></span>
				</div>
			</div>
		</div>
		<?php
	}

	public static function renderClientReportsSiteTokens() {
		global $mainWPCReportExtensionActivator;

		$websiteid	 = isset( $_GET['id'] ) ? $_GET['id'] : null;
		$website	 = null;

		if ( $websiteid ) {
			$website = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $websiteid );
			if ( $website && is_array( $website ) ) {
				$website = current( $website );
			}

			if ( empty( $website ) )
				return;
		}

		$tokens = MainWP_CReport_DB::get_instance()->get_tokens();

		$site_tokens = array();

		if ( $website ) {
			$site_tokens = MainWP_CReport_DB::get_instance()->get_site_tokens( $website['url'] );
		}

		$html = '';

		if ( is_array( $tokens ) && count( $tokens ) > 0 ) {
			$html .= '
				<h3 class="ui dividing header">' . __( 'Client Reports Tokens', 'boilerplate-extension' ) . '</h3>
				<div class="ui form">
			';
			foreach ( $tokens as $token ) {
				if ( !$token ) {
					continue;
				}
				$token_value = '';
				if ( isset( $site_tokens[$token->id] ) && $site_tokens[$token->id] ) {
					$token_value = htmlspecialchars( stripslashes( $site_tokens[$token->id]->token_value ) );
				}

				$input_name = 'creport_token_' . str_replace( array('.', ' ', '-'), '_', $token->token_name );

				$html .= '

				<div class="ui grid field">
					<label class="six wide column middle aligned">[' . stripslashes( $token->token_name ) . ']</label>
					<div class="ui six wide column">
						<div class="ui left labeled input">
							<input type="text" value="' . $token_value . '" class="regular-text" name="' . $input_name . '"/>
						</div>
					</div>
				</div>';
			}
			$html .= '</div>';
		}
		echo $html;
	}

	public function update_site_update_tokens( $websiteId ) {

		global $mainWPCReportExtensionActivator;

		if ( $websiteId ) {
			$website = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $websiteId );
			if ( $website && is_array( $website ) ) {
				$website = current( $website );
			}

			if ( !is_array( $website ) ) {
				return;
			}

			$tokens = MainWP_CReport_DB::get_instance()->get_tokens();
			foreach ( $tokens as $token ) {
				$input_name = 'creport_token_' . str_replace( array('.', ' ', '-'), '_', $token->token_name );
				if ( isset( $_POST[$input_name] ) ) {
					$token_value = $_POST[$input_name];
					$current	 = MainWP_CReport_DB::get_instance()->get_tokens_by( 'id', $token->id, $website['url'] );
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

	public static function load_tokens() {
		$tokens = MainWP_CReport_DB::get_instance()->get_tokens();
		?>
		<div class="ui segment">
			<table id="mainwp-client-reports-tokens-table" class="ui single line table">
				<thead>
					<tr>
						<th><?php _e( 'Token Name', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( 'Token Description', 'mainwp-client-reports-extension' ); ?></th>
						<th class="no-sort collapsing"><?php _e( '', 'mainwp-client-reports-extension' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( is_array( $tokens ) && count( $tokens ) > 0 ) : ?>
						<?php foreach ( (array) $tokens as $token ) : ?>
				<?php if ( !$token ) continue; ?>
							<tr class="mainwp-token" token_id="<?php echo $token->id; ?>">
								<td class="token-name">[<?php echo stripslashes( $token->token_name ); ?>]</td>
								<td class="token-description"><?php echo stripslashes( $token->token_description ); ?></td>
								<td>
									<div class="ui left pointing dropdown icon mini basic green button">
										<i class="ellipsis horizontal icon"></i>
										<div class="menu">
											<a class="item" id="mainwp-creport-edit-token" href="#"><?php _e( 'Edit', 'mainwp-client-reports-extension' ); ?></a>
											<a class="item" id="mainwp-creport-delete-token" href="#"><?php _e( 'Delete', 'mainwp-client-reports-extension' ); ?></a>
										</div>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
		<?php endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<th><a class="ui mini green button" href="#" id="mainwp-creport-new-token-button"><?php _e( 'Create New Token', 'mainwp-client-reports-extension' ); ?></a></th>
						<th><?php _e( '', 'mainwp-client-reports-extension' ); ?></th>
						<th><?php _e( '', 'mainwp-client-reports-extension' ); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="ui modal" id="mainwp-creport-new-token-modal">
			<div class="header"><?php echo __( 'Custom Token', 'mainwp-client-reports-extension' ); ?></div>
			<div class="content ui mini form">
				<div class="ui yellow message" style="display:none"></div>
				<div class="field">
					<label><?php _e( 'Token Name', 'mainwp-client-reports-extension' ); ?></label>
					<input type="text" value="" id="token-name" name="token-name" placeholder="<?php esc_attr_e( 'Enter token name (without of square brackets)', 'mainwp-client-reports-extension' ); ?>">
				</div>
				<div class="field">
					<label><?php _e( 'Token Description', 'mainwp-client-reports-extension' ); ?></label>
					<input type="text" value="" id="token-description" name="token-description" placeholder="<?php esc_attr_e( 'Enter token description', 'mainwp-client-reports-extension' ); ?>">
				</div>
			</div>
			<div class="actions">
				<input type="button" class="ui green button" id="mainwp-creport-create-new-token" value="<?php esc_attr_e( 'Save Token', 'mainwp-client-reports-extension' ); ?>">
				<div class="ui cancel button"><?php echo __( 'Close', 'mainwp-client-reports-extension' ); ?></div>
			</div>
		</div>

		<div class="ui modal" id="mainwp-creport-update-token-modal">
			<div class="header"><?php echo __( 'Custom Token', 'mainwp-client-reports-extension' ); ?></div>
			<div class="content ui mini form">
				<div class="ui yellow message" style="display:none"></div>
				<div class="field">
					<label><?php _e( 'Token Name', 'mainwp-client-reports-extension' ); ?></label>
					<input type="text" value="" id="token-name" name="token-name" placeholder="<?php esc_attr_e( 'Enter token name (without of square brackets)', 'mainwp-client-reports-extension' ); ?>">
				</div>
				<div class="field">
					<label><?php _e( 'Token Description', 'mainwp-client-reports-extension' ); ?></label>
					<input type="text" value="" id="token-description" name="token-description" placeholder="<?php esc_attr_e( 'Enter token description', 'mainwp-client-reports-extension' ); ?>">
				</div>
				<input type="hidden" value="" id="token-id" name="token-id">
			</div>
			<div class="actions">
				<input type="button"  class="ui green button" id="mainwp-save-creport-token" value="<?php esc_attr_e( 'Save Token', 'mainwp-client-reports-extension' ); ?>">
				<div class="ui cancel button"><?php echo __( 'Close', 'mainwp-client-reports-extension' ); ?></div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery( '#mainwp-client-reports-tokens-table' ).DataTable( {
				"columnDefs": [ { "orderable": false, "targets": "no-sort" } ],
				"order": [ [ 0, "asc" ] ],
				"language": { "emptyTable": "No tokens found." },
				"drawCallback": function ( settings ) {
					jQuery( '#mainwp-client-reports-tokens-table .ui.dropdown' ).dropdown();
				}
			} );

			jQuery( '#mainwp-creport-new-token-button' ).on( 'click', function () {
				jQuery( '#mainwp-creport-new-token-modal' ).modal( {
					closable: false,
					onHide: function () {
						jQuery( '#mainwp-creport-new-token-modal input[name="token-name"]' ).val( '' );
						jQuery( '#mainwp-creport-new-token-modal input[name="token-description"]' ).val( '' );
						jQuery( '#mainwp-creport-new-token-modal input[name="token-id"]' ).val( 0 );
					}
				} ).modal( 'show' );
			} );
		</script>
		<?php
	}

	public function load_site_tokens() {
		self::verify_nonce();
		$site_id = isset( $_POST['siteId'] ) ? $_POST['siteId'] : 0;
		if ( $site_id ) {
			$website = null;
			global $mainWPCReportExtensionActivator;
			$website = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $site_id );
			if ( $website && is_array( $website ) ) {
				$website = current( $website );
			}

			if ( is_array( $website ) && isset( $website['url'] ) ) {
				$client_tokens			 = MainWP_CReport_DB::get_instance()->get_tokens();
				$client_tokens_values	 = array();
				$site_tokens			 = MainWP_CReport_DB::get_instance()->get_site_tokens( $website['url'] );
				foreach ( $client_tokens as $token ) {
					$client_tokens_values[$token->token_name] = array(
						'token_name'	 => $token->token_name,
						'token_value'	 => isset( $site_tokens[$token->id] ) ? $site_tokens[$token->id]->token_value : '',
					);
				}

				$html	 = '';
				$tokens	 = array();
				if ( count( $client_tokens_values ) > 0 ) {
					foreach ( $client_tokens_values as $token ) {
						$html .= '<tr><td><a href="#" token-value = "' . esc_attr( stripcslashes( $token['token_value'] ) ) . '"class="creport_format_add_token">[' . esc_html( stripcslashes( $token['token_name'] ) ) . ']</a></td>'
							. '<td class="creport_stream_token_desc">' . esc_html( stripcslashes( $token['token_value'] ) ) . '</td>'
							. '</tr>';
					}
					$tokens = array(
						'client.name'			 => $client_tokens_values['client.name']['token_value'],
						'client.contact.name'	 => $client_tokens_values['client.contact.name']['token_value'],
						'client.company'		 => $client_tokens_values['client.company']['token_value'],
						'client.email'			 => $client_tokens_values['client.email']['token_value'],
					);
				}

				die( json_encode( array('tokens' => $tokens, 'html_tokens' => $html) ) );
			}
		}
		die( json_encode( 'EMPTY' ) );
	}

	public function get_format() {
		self::verify_nonce();
		$format_id	 = isset( $_POST['formatId'] ) ? trim( $_POST['formatId'] ) : 0;
		$content	 = '';
		if ( $format_id ) {
			$format = MainWP_CReport_DB::get_instance()->get_format_by( 'id', $format_id );
			if ( $format ) {
				die( json_encode( array(
					'success'	 => true,
					'content'	 => stripslashes( $format->content ),
				) ) );
			}
		}
		die( json_encode( 'failed' ) );
	}

	public function save_format() {
		self::verify_nonce();

		$title	 = isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
		$content = isset( $_POST['content'] ) ? trim( $_POST['content'] ) : '';
		$type	 = isset( $_POST['type'] ) ? trim( $_POST['type'] ) : 'H';

		if ( !empty( $title ) ) {
			$format = array('title' => $title, 'content' => $content, 'type' => $type);
			if ( MainWP_CReport_DB::get_instance()->update_format( $format ) ) {
				die( 'success' );
			}
		}

		die( 'failed' );
	}

	public function delete_format() {
		self::verify_nonce();
		$format_id	 = isset( $_POST['formatId'] ) ? trim( $_POST['formatId'] ) : 0;
		$content	 = '';
		if ( $format_id ) {
			$deleted = MainWP_CReport_DB::get_instance()->delete_format_by( 'id', $format_id );
			if ( $deleted ) {
				die( json_encode( array('success' => true) ) );
			}
		}
		die( json_encode( 'failed' ) );
	}

	public function get_sites_with_reports( $websites ) {
		$sites = array();
		if ( is_array( $websites ) && count( $websites ) ) {
			foreach ( $websites as $website ) {
				if ( $website && $website->plugins != '' ) {
					$plugins = json_decode( $website->plugins, 1 );
					if ( is_array( $plugins ) && count( $plugins ) != 0 ) {
						foreach ( $plugins as $plugin ) {
							if ( 'mainwp-child-reports/mainwp-child-reports.php' == $plugin['slug'] ) {
								if ( !$plugin['active'] )
									break;
								$site	 = MainWP_CReport_Utility::map_site( $website, array('id', 'name', 'url') );
								$sites[] = $site;
								break;
							}
						}
					}
				}
			}
		}
		return $sites;
	}

	public static function verify_nonce() {
		if ( !isset( $_REQUEST['nonce'] ) || !wp_verify_nonce( $_REQUEST['nonce'], '_wpnonce_creport' ) ) {
			die( json_encode( array('error' => 'Invalid request') ) );
		}
	}

	public static function ajax_general_load_sites() {
		self::verify_nonce();
		global $mainWPCReportExtensionActivator;

		$what		 = $_POST['what'];
		$websites	 = apply_filters( 'mainwp-getsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), null );
		$sites_ids	 = array();
		if ( is_array( $websites ) ) {
			foreach ( $websites as $website ) {
				$sites_ids[] = $website['id'];
			}
			unset( $websites );
		}
		$option				 = array(
			'plugin_upgrades'	 => true,
			'plugins'			 => true,
		);
		$dbwebsites			 = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $sites_ids, array(), $option );
		$dbwebsites_reports	 = self::get_sites_with_reports( $dbwebsites );

		unset( $dbwebsites );

		$error = '';

		if ( count( $dbwebsites_reports ) == 0 ) {
			$error = '<div class="mainwp_info-box-yellow">' . _e( 'No websites were found with the MainWP Child Reports plugin installed.' ) . '</div>';
		}

		$html = '';
		if ( empty( $error ) ) {
			$title = '';
			if ( $what == 'save_settings' ) {
				$title = __( 'Saving settings to child sites ...', 'mainwp-client-reports-extension' );
			}
			ob_start();
			?>
			<div class="poststuff">
				<div class="postbox">
					<h3 class="mainwp_box_title"><span><i class="fa fa-cog"></i>
			<?php echo!empty( $title ) ? $title : '&nbsp;'; ?>
						</span></h3>
					<div class="inside">
						<?php
						foreach ( $dbwebsites_reports as $website ) {
							echo '<div><strong>' . $website['name'] . '</strong>: ';
							echo '<span class="siteItemProcess" action="" site-id="' . $website['id'] . '" status="queue"><span class="status">Queue ...</span> <i style="display: none;" class="fa fa-spinner fa-pulse"></i></span>';
							echo '</div><br />';
						}
						?>
						<div id="mainwp_creport_group_working"><span class="status" style="display:none"></span> <i style="display: none;" class="fa fa-spinner fa-pulse"></i></div>
					</div>
				</div>
			</div>
			<?php
			$html = ob_get_clean();
		}

		if ( !empty( $error ) ) {
			$error = '<div class="mainwp_info-box-yellow">' . $error . '</div>';
			die( $error );
		}


		die( $html );
	}

	function ajax_save_settings() {
		self::verify_nonce();
		$siteid = $_POST['site_id'];
		if ( empty( $siteid ) ) {
			die( json_encode( array('error' => 'Error: site id empty') ) );
		}
		global $mainWPCReportExtensionActivator;
		$settings	 = get_option( 'mainwp_creport_settings', array() );
		$post_data	 = array('mwp_action' => 'save_settings',
			'settings'	 => $settings
		);
		$information = apply_filters( 'mainwp_fetchurlauthed', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $siteid, 'client_report', $post_data );

		die( json_encode( $information ) );
	}

	public static function ajax_load_sites_for_group_report() {
		self::verify_nonce();

		global $mainWPCReportExtensionActivator;
		$what		 = $_POST['what'];
		$report_id	 = $_POST['report_id'];
		$websites	 = array();

		if ( $report_id ) {
			$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );
			if ( $report ) {
				$sel_sites	 = unserialize( base64_decode( $report->sites ) );
				$sel_groups	 = unserialize( base64_decode( $report->groups ) );
				if ( !is_array( $sel_sites ) ) {
					$sel_sites = array();
				}
				if ( !is_array( $sel_groups ) ) {
					$sel_groups = array();
				}
				$dbwebsites = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), $sel_sites, $sel_groups );
				if ( is_array( $dbwebsites ) ) {
					foreach ( $dbwebsites as $site ) {
						$websites[] = MainWP_CReport_Utility::map_site( $site, array('id', 'name', 'url') );
					}
				}
			}
		}

		$error = '';

		if ( empty( $report ) ) {
			$error = __( 'Report not found. Please try again.', 'mainwp-client-reports-extension' );
		} else if ( count( $websites ) == 0 ) {
			$error = __( 'No selected sites found.', 'mainwp-client-reports-extension' );
		}

		$html = '';

		if ( empty( $error ) ) {
			ob_start();
			?>
			<div class="ui modal" id="mainwp-client-reports-generating-report-modal">
				<div class="header"><?php echo $report->title; ?></div>
				<div class="scrolling content">
					<div class="ui relaxed divided list">
							<?php foreach ( $websites as $website ) : ?>
							<div class="item">
				<?php echo $website['name']; ?>
								<span class="siteItemProcess right floated" action="" site-id="<?php echo $website['id']; ?>" status="queue">
									<span class="status"><i class="clock outline icon"></i></span> <i style="display: none;" class="notched circle loading icon"></i></span>
							</div>
			<?php endforeach; ?>
					</div>
				</div>
				<div class="actions">
					<div class="ui cancel button"><?php echo __( 'Close', 'mainwp-client-reprots-extension' ); ?></div>
				</div>
			</div>
			<?php
			$html = ob_get_clean();
		}

		if ( !empty( $error ) ) {
			$error = '<div class="ui red message">' . $error . '</div>';
			die( $error );
		}
		die( $html );
	}

	public function ajax_generate_report() {
		self::verify_nonce();
		$report_id	 = $_POST['report_id'];
		$site_id	 = $_POST['site_id'];
		$what		 = $_POST['what'];

		if ( empty( $site_id ) || empty( $report_id ) )
			die( json_encode( array('error' => __( 'Invalid data.' )) ) );

		$report = MainWP_CReport_DB::get_instance()->get_report_by( 'id', $report_id );

		if ( empty( $report ) ) { // is not group report
			die( json_encode( array('error' => __( 'Report could not be found.', 'mainwp-client-reports-extension' )) ) );
		}

		if ( $report->is_archived ) {
			die( json_encode( array('error' => __( 'This is an archived report.', 'mainwp-client-reports-extension' )) ) );
		}

		global $mainWPCReportExtensionActivator;
		$dbwebsites	 = apply_filters( 'mainwp-getdbsites', $mainWPCReportExtensionActivator->get_child_file(), $mainWPCReportExtensionActivator->get_child_key(), array($site_id), array() );
		$site		 = array();
		if ( is_array( $dbwebsites ) ) {
			$site			 = current( $dbwebsites );
			$site			 = MainWP_CReport_Utility::map_site( $site, array('id', 'name', 'url') );
			$cust_from_date	 = $cust_to_date	 = 0;

			if ( $what == 'preview' && $report->scheduled ) {

				$preview_recurring = self::calc_recurring_date( $report->recurring_schedule, $report->recurring_day ); // ok
				if ( is_array( $preview_recurring ) ) {
					if ( 'daily' == $report->recurring_schedule ) {
						$cust_from_date	 = $preview_recurring['date_from'] - 24 * 3600;
						$cust_to_date	 = $preview_recurring['date_to'] - 24 * 3600;
					} else if ( 'weekly' == $report->recurring_schedule ) {
						$cust_from_date	 = $preview_recurring['date_from'] - 7 * 24 * 3600;
						$cust_to_date	 = $preview_recurring['date_to'] - 7 * 24 * 3600;
					} else if ( 'monthly' == $report->recurring_schedule ) {
						$cust_from_date	 = strtotime( 'first day of last month' );
						$cust_from_date	 = strtotime( date( 'Y-m-d', $cust_from_date ) . ' 00:00:00' );
						$cust_to_date	 = strtotime( 'last day of last month' );
						$cust_to_date	 = strtotime( date( 'Y-m-d', $cust_to_date ) . ' 23:59:59' );
					}
				}
			}

			if ( self::update_group_report_site( $report, $site, $cust_from_date, $cust_to_date ) ) {
				$success = true;
				if ( $what == 'send_test_email' ) {
					$data = self::prepare_content_report_email( $report, true, $site );
					if ( empty( $data ) || !$this->send_onetime_report_email( $data, $report, true, $site ) ) {
						die( json_encode( array('error' => 'Send mail error.') ) );
					}
				} else if ( $what == 'sendreport' ) {
					$data = self::prepare_content_report_email( $report, false, $site );
					if ( empty( $data ) || !$this->send_onetime_report_email( $data, $report, false, $site ) ) {
						die( json_encode( array('error' => 'Send mail error.') ) );
					}
				}
				if ( $success )
					die( json_encode( array('result' => 'success') ) );
			} else {
				die( json_encode( array('error' => 'Save data') ) );
			}
		}
		die( json_encode( array('error' => 'Site could not be found') ) );
	}

	public static function update_group_report_site( $report, $site,
												  $cust_from_date = 0, $cust_to_date = 0 ) {
		if ( empty( $site ) || !is_array( $site ) )
			return false;
		$site_id = $site['id'];

		// fix bug
		if ( empty( $site_id ) )
			return false;

		$filtered_reports	 = self::filter_report_website( $report, $site, $cust_from_date, $cust_to_date );
		$content			 = self::gen_report_content( $filtered_reports );
		$content_pdf		 = self::gen_report_content_pdf( array($site_id => $filtered_reports) );
		$values				 = array(
			'report_id'			 => $report->id,
			'site_id'			 => $site_id,
			'report_content'	 => json_encode( $content ),
			'report_content_pdf' => json_encode( $content_pdf ),
		);
		if ( MainWP_CReport_DB::get_instance()->update_group_report_content( $values ) ) {
			return true;
		} else {
			return false;
		}
	}

	public static function ajax_archive_report() {
		self::verify_nonce();

		if ( !isset( $_POST['report_id'] ) || empty( $_POST['report_id'] ) )
			die( json_encode( array('error' => __( 'Empty report id', 'mainwp-client-reports-extension' )) ) );

		if ( self::archive_report( $_POST['report_id'], true ) )
			die( json_encode( array('result' => 'success') ) );
		else
			die( json_encode( array('result' => 'failed') ) );
	}

	public function delete_token() {
		self::verify_nonce();
		$ret		 = array('success' => false);
		$token_id	 = intval( $_POST['token_id'] );
		if ( MainWP_CReport_DB::get_instance()->delete_token_by( 'id', $token_id ) ) {
			$ret['success'] = true;
		}
		echo json_encode( $ret );
		exit;
	}

	public function save_token() {

		$return				 = array('success' => false, 'error' => '', 'message' => '');
		$token_name			 = sanitize_text_field( $_POST['token_name'] );
		$token_name			 = trim( $token_name, '[]' );
		$token_description	 = sanitize_text_field( $_POST['token_description'] );

		// update
		if ( isset( $_POST['token_id'] ) && $token_id = intval( $_POST['token_id'] ) ) {
			$current = MainWP_CReport_DB::get_instance()->get_tokens_by( 'id', $token_id );
			if ( $current && $current->token_name == $token_name && $current->token_description == $token_description ) {
				$return['success'] = true;
				$return['message'] = __( 'Token updated successfully.', 'mainwp-client-reports-extension' );
				//$return['row_data'] = $this->create_token_item( $current, false );
			} else if ( ($current = MainWP_CReport_DB::get_instance()->get_tokens_by( 'token_name', $token_name )) && $current->id != $token_id ) {
				$return['error'] = __( 'Token already exists', 'mainwp-client-reports-extension' );
			} else if ( $token = MainWP_CReport_DB::get_instance()->update_token( $token_id, array('token_name' => $token_name, 'token_description' => $token_description) ) ) {
				$return['success'] = true;
				//$return['row_data'] = $this->create_token_item( $token, false );
			}
		} else { // add new
			if ( $current = MainWP_CReport_DB::get_instance()->get_tokens_by( 'token_name', $token_name ) ) {
				$return['error'] = __( 'Token already exists', 'mainwp-client-reports-extension' );
			} else {
				if ( $token = MainWP_CReport_DB::get_instance()->add_token( array('token_name' => $token_name, 'token_description' => $token_description, 'type' => 0) ) ) {
					$return['success'] = true;
					//$return['row_data'] = $this->create_token_item( $token );
				} else {
					$return['error'] = __( 'Saving the token failed. Please, try again.', 'mainwp-client-reports-extension' );
				}
			}
		}
		echo json_encode( $return );
		exit;
	}

	public function ajax_do_action_report() {
		self::verify_nonce();
		$report_id	 = intval( $_POST['reportId'] );
		$action		 = $_POST['what'];

		if ( empty( $report_id ) )
			die( json_encode( array('error' => __( 'Site id empty' )) ) );

		$ret	 = array();
		$success = false;
		switch ( $action ) {
			case 'delete':
				if ( MainWP_CReport_DB::get_instance()->delete_report_by( 'id', $report_id ) ) {
					$success = true;
				}
				break;
			case 'unarchive':
				if ( MainWP_CReport::un_archive_report( $report_id ) ) {
					$success = true;
				}
				break;
			case 'cancelschedule':
				$update = array('id' => $report_id, 'scheduled' => 0, 'recurring_schedule' => '');
				if ( MainWP_CReport_DB::get_instance()->update_report( $update ) ) {
					$success = true;
				}
				break;
			default:
				break;
		}

		if ( $success )
			$ret['status'] = 'success';

		echo json_encode( $ret );
		exit;
	}

	public static function showMainWPMessage( $type, $notice_id ) {
		if ( $type == 'tour' ) {
			$status = get_user_option( 'mainwp_tours_status' );
		} else {
			$status = get_user_option( 'mainwp_notice_saved_status' );
		}

		if ( !is_array( $status ) ) {
			$status = array();
		}
		if ( isset( $status[$notice_id] ) ) {
			return false;
		}
		return true;
	}

}
