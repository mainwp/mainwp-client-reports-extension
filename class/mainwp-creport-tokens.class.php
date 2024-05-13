<?php

class MainWP_CReport_Tokens {

	private static $reports_tokens = array();

	private static $instance = null;

	static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {

		// for reference.
		self::$reports_tokens = array(
			'client'        => array(),
			'plugins'                  => array(
				array(
					'name' => 'section.plugins.installed',
					'desc' => 'Loops through Plugins Installed during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.plugins.activated',
					'desc' => 'Loops through Plugins Activated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.plugins.edited',
					'desc' => 'Loops through Plugins Edited during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.plugins.deactivated',
					'desc' => 'Loops through Plugins Deactivated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.plugins.updated',
					'desc' => 'Loops through Plugins Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.plugins.deleted',
					'desc' => 'Loops through Plugins Deleted during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'plugin.name',
					'desc' => 'Displays the Plugin Name',
					'type' => 'installed',
				),
				array(
					'name' => 'plugin.installed.date',
					'desc' => 'Displays the Plugin Installation Date',
					'type' => 'installed',
				),
				array(
					'name' => 'plugin.installed.time',
					'desc' => 'Displays the Plugin Installation Time',
					'type' => 'installed',
				),
				array(
					'name' => 'plugin.installed.author',
					'desc' => 'Displays the User who Installed the Plugin',
					'type' => 'installed',
				),

				array(
					'name' => 'plugin.name',
					'desc' => 'Displays the Plugin Name',
					'type' => 'activated',
				),
				array(
					'name' => 'plugin.activated.date',
					'desc' => 'Displays the Plugin Activation Date',
					'type' => 'activated',
				),
				array(
					'name' => 'plugin.activated.time',
					'desc' => 'Displays the Plugin Activation Time',
					'type' => 'activated',
				),
				array(
					'name' => 'plugin.activated.author',
					'desc' => 'Displays the User who Activated the Plugin',
					'type' => 'activated',
				),

				array(
					'name' => 'plugin.name',
					'desc' => 'Displays the Plugin Name',
					'type' => 'edited',
				),
				array(
					'name' => 'plugin.edited.date',
					'desc' => 'Displays the Plugin Editing Date',
					'type' => 'edited',
				),
				array(
					'name' => 'plugin.edited.time',
					'desc' => 'Displays the Plugin Editing time',
					'type' => 'edited',
				),
				array(
					'name' => 'plugin.edited.author',
					'desc' => 'Displays the User who Edited the Plugin',
					'type' => 'edited',
				),
				array(
					'name' => 'plugin.name',
					'desc' => 'Displays the Plugin Name',
					'type' => 'deactivated',
				),
				array(
					'name' => 'plugin.deactivated.date',
					'desc' => 'Displays the Plugin Deactivation Date',
					'type' => 'deactivated',
				),
				array(
					'name' => 'plugin.deactivated.time',
					'desc' => 'Displays the Plugin Deactivation Time',
					'type' => 'deactivated',
				),
				array(
					'name' => 'plugin.deactivated.author',
					'desc' => 'Displays the User who Deactivated the Plugin',
					'type' => 'deactivated',
				),
				array(
					'name' => 'plugin.old.version',
					'desc' => 'Displays the Plugin Version Before Update',
					'type' => 'updated',
				),
				array(
					'name' => 'plugin.current.version',
					'desc' => 'Displays the Plugin Current Vesion',
					'type' => 'updated',
				),
				array(
					'name' => 'plugin.name',
					'desc' => 'Displays the Plugin Name',
					'type' => 'updated',
				),
				array(
					'name' => 'plugin.updated.date',
					'desc' => 'Displays the Plugin Update Date',
					'type' => 'updated',
				),
				array(
					'name' => 'plugin.updated.time',
					'desc' => 'Displays the Plugin Update Time',
					'type' => 'updated',
				),
				array(
					'name' => 'plugin.updated.author',
					'desc' => 'Displays the User who Updated the Plugin',
					'type' => 'updated',
				),

				array(
					'name' => 'plugin.name',
					'desc' => 'Displays the Plugin Name',
					'type' => 'deleted',
				),
				array(
					'name' => 'plugin.deleted.date',
					'desc' => 'Displays the Plugin Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'plugin.deleted.time',
					'desc' => 'Displays the Plugin Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'plugin.deleted.author',
					'desc' => 'Displays the User who Deleted the Plugin',
					'type' => 'deleted',
				),

				array(
					'name' => 'plugin.installed.count',
					'desc' => 'Displays the Number of Installed Plugins',
					'type' => 'additional',
				),
				array(
					'name' => 'plugin.edited.count',
					'desc' => 'Displays the Number of Edited Plugins',
					'type' => 'additional',
				),
				array(
					'name' => 'plugin.activated.count',
					'desc' => 'Displays the Number of Activated Plugins',
					'type' => 'additional',
				),
				array(
					'name' => 'plugin.deactivated.count',
					'desc' => 'Displays the Number of Deactivated Plugins',
					'type' => 'additional',
				),
				array(
					'name' => 'plugin.deleted.count',
					'desc' => 'Displays the Number of Deleted Plugins',
					'type' => 'additional',
				),
				array(
					'name' => 'plugin.updated.count',
					'desc' => 'Displays the Number of Updated Plugins',
					'type' => 'additional',
				),
			),
			'themes'                   => array(

				array(
					'name' => 'section.themes.installed',
					'desc' => 'Loops through Themes Installed during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.themes.activated',
					'desc' => 'Loops through Themes Activated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.themes.edited',
					'desc' => 'Loops through Themes Edited during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.themes.updated',
					'desc' => 'Loops through Themes Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.themes.deleted',
					'desc' => 'Loops through Themes Deleted during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'theme.name',
					'desc' => 'Displays the Theme Name',
					'type' => 'installed',
				),
				array(
					'name' => 'theme.installed.date',
					'desc' => 'Displays the Theme Installation Date',
					'type' => 'installed',
				),
				array(
					'name' => 'theme.installed.time',
					'desc' => 'Displays the Theme Installation Time',
					'type' => 'installed',
				),
				array(
					'name' => 'theme.installed.author',
					'desc' => 'Displays the User who Installed the Theme',
					'type' => 'installed',
				),

				array(
					'name' => 'theme.name',
					'desc' => 'Displays the Theme Name',
					'type' => 'activated',
				),
				array(
					'name' => 'theme.activated.date',
					'desc' => 'Displays the Theme Activation Date',
					'type' => 'activated',
				),
				array(
					'name' => 'theme.activated.time',
					'desc' => 'Displays the Theme Activation Time',
					'type' => 'activated',
				),
				array(
					'name' => 'theme.activated.author',
					'desc' => 'Displays the User who Activated the Theme',
					'type' => 'activated',
				),

				array(
					'name' => 'theme.name',
					'desc' => 'Displays the Theme Name',
					'type' => 'edited',
				),
				array(
					'name' => 'theme.edited.date',
					'desc' => 'Displays the Theme Editing Date',
					'type' => 'edited',
				),
				array(
					'name' => 'theme.edited.time',
					'desc' => 'Displays the Theme Editing Time',
					'type' => 'edited',
				),
				array(
					'name' => 'theme.edited.author',
					'desc' => 'Displays the User who Edited the Theme',
					'type' => 'edited',
				),

				array(
					'name' => 'theme.old.version',
					'desc' => 'Displays the Theme Version Before Update',
					'type' => 'updated',
				),
				array(
					'name' => 'theme.current.version',
					'desc' => 'Displays the Theme Current Version',
					'type' => 'updated',
				),
				array(
					'name' => 'theme.name',
					'desc' => 'Displays the Theme Name',
					'type' => 'updated',
				),
				array(
					'name' => 'theme.updated.date',
					'desc' => 'Displays the Theme Update Date',
					'type' => 'updated',
				),
				array(
					'name' => 'theme.updated.time',
					'desc' => 'Displays the Theme Update Time',
					'type' => 'updated',
				),
				array(
					'name' => 'theme.updated.author',
					'desc' => 'Displays the User who Updated the Theme',
					'type' => 'updated',
				),

				array(
					'name' => 'theme.name',
					'desc' => 'Displays the Theme Name',
					'type' => 'deleted',
				),
				array(
					'name' => 'theme.deleted.date',
					'desc' => 'Displays the Theme Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'theme.deleted.time',
					'desc' => 'Displays the Theme Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'theme.deleted.author',
					'desc' => 'Displays the User who Deleted the Theme',
					'type' => 'deleted',
				),

				array(
					'name' => 'theme.installed.count',
					'desc' => 'Displays the Number of Installed Themes',
					'type' => 'additional',
				),
				array(
					'name' => 'theme.edited.count',
					'desc' => 'Displays the Number of Edited Themes',
					'type' => 'additional',
				),
				array(
					'name' => 'theme.activated.count',
					'desc' => 'Displays the Number of Activated Themes',
					'type' => 'additional',
				),
				array(
					'name' => 'theme.deleted.count',
					'desc' => 'Displays the Number of Deleted Themes',
					'type' => 'additional',
				),
				array(
					'name' => 'theme.updated.count',
					'desc' => 'Displays the Number of Updated Themes',
					'type' => 'additional',
				),
			),
			'posts'                    => array(
				array(
					'name' => 'section.posts.created',
					'desc' => 'Loops through Posts Created during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.posts.updated',
					'desc' => 'Loops through Posts Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.posts.trashed',
					'desc' => 'Loops through Posts Trashed during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.posts.deleted',
					'desc' => 'Loops through Posts Deleted during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.posts.restored',
					'desc' => 'Loops through Posts Restored during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'post.title',
					'desc' => 'Displays the Post Title',
					'type' => 'created',
				),
				array(
					'name' => 'post.created.date',
					'desc' => 'Displays the Post Creation Date',
					'type' => 'created',
				),
				array(
					'name' => 'post.created.time',
					'desc' => 'Displays the Post Creation Time',
					'type' => 'created',
				),

				array(
					'name' => 'post.created.author',
					'desc' => 'Displays the User who Created the Post',
					'type' => 'created',
				),

				array(
					'name' => 'post.title',
					'desc' => 'Displays the Post Title',
					'type' => 'updated',
				),
				array(
					'name' => 'post.updated.date',
					'desc' => 'Displays the Post Update Date',
					'type' => 'updated',
				),
				array(
					'name' => 'post.updated.time',
					'desc' => 'Displays the Post Update Time',
					'type' => 'updated',
				),
				array(
					'name' => 'post.updated.author',
					'desc' => 'Displays the User who Updated the Post',
					'type' => 'updated',
				),

				array(
					'name' => 'post.title',
					'desc' => 'Displays the Post Title',
					'type' => 'trashed',
				),
				array(
					'name' => 'post.trashed.date',
					'desc' => 'Displays the Post Trashing Date',
					'type' => 'trashed',
				),
				array(
					'name' => 'post.trashed.time',
					'desc' => 'Displays the Post Trashing Time',
					'type' => 'trashed',
				),
				array(
					'name' => 'post.trashed.author',
					'desc' => 'Displays the User who Trashed the Post',
					'type' => 'trashed',
				),

				array(
					'name' => 'post.title',
					'desc' => 'Displays the Post Title',
					'type' => 'deleted',
				),
				array(
					'name' => 'post.deleted.date',
					'desc' => 'Displays the Post Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'post.deleted.time',
					'desc' => 'Displays the Post Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'post.deleted.author',
					'desc' => 'Displays the User who Deleted the Post',
					'type' => 'deleted',
				),

				array(
					'name' => 'post.title',
					'desc' => 'Displays Post Title',
					'type' => 'restored',
				),
				array(
					'name' => 'post.restored.date',
					'desc' => 'Displays the Post Restoring Date',
					'type' => 'restored',
				),
				array(
					'name' => 'post.restored.time',
					'desc' => 'Displays the Post Restoring Time',
					'type' => 'restored',
				),
				array(
					'name' => 'post.restored.author',
					'desc' => 'Displays the User who Restored the Post',
					'type' => 'restored',
				),

				array(
					'name' => 'post.created.count',
					'desc' => 'Displays the Number of Created Posts',
					'type' => 'additional',
				),
				array(
					'name' => 'post.updated.count',
					'desc' => 'Displays the Number of Updated Posts',
					'type' => 'additional',
				),
				array(
					'name' => 'post.trashed.count',
					'desc' => 'Displays the Number of Trashed Posts',
					'type' => 'additional',
				),
				array(
					'name' => 'post.restored.count',
					'desc' => 'Displays the Number of Restored Posts',
					'type' => 'additional',
				),
				array(
					'name' => 'post.deleted.count',
					'desc' => 'Displays the Number of Deleted Posts',
					'type' => 'additional',
				),

			),

			'pages'                    => array(
				array(
					'name' => 'section.pages.created',
					'desc' => 'Loops through Pages Created during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.pages.updated',
					'desc' => 'Loops through Pages Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.pages.trashed',
					'desc' => 'Loops through Pages Trashed during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.pages.deleted',
					'desc' => 'Loops through Pages Deleted during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.pages.restored',
					'desc' => 'Loops through Pages Restored during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'page.title',
					'desc' => 'Displays the Page Title',
					'type' => 'created',
				),
				array(
					'name' => 'page.created.date',
					'desc' => 'Displays the Page Createion Date',
					'type' => 'created',
				),
				array(
					'name' => 'page.created.time',
					'desc' => 'Displays the Page Createion Time',
					'type' => 'created',
				),
				array(
					'name' => 'page.created.author',
					'desc' => 'Displays the User who Created the Page',
					'type' => 'created',
				),

				array(
					'name' => 'page.title',
					'desc' => 'Displays the Page Title',
					'type' => 'updated',
				),
				array(
					'name' => 'page.updated.date',
					'desc' => 'Displays the Page Updating Date',
					'type' => 'updated',
				),
				array(
					'name' => 'page.updated.time',
					'desc' => 'Displays the Page Updating Time',
					'type' => 'updated',
				),
				array(
					'name' => 'page.updated.author',
					'desc' => 'Displays the User who Updated the Page',
					'type' => 'updated',
				),

				array(
					'name' => 'page.title',
					'desc' => 'Displays the Page Title',
					'type' => 'trashed',
				),
				array(
					'name' => 'page.trashed.date',
					'desc' => 'Displays the Page Trashing Date',
					'type' => 'trashed',
				),
				array(
					'name' => 'page.trashed.time',
					'desc' => 'Displays the Page Trashing Time',
					'type' => 'trashed',
				),
				array(
					'name' => 'page.trashed.author',
					'desc' => 'Displays the User who Trashed the Page',
					'type' => 'trashed',
				),

				array(
					'name' => 'page.title',
					'desc' => 'Displays the Page Title',
					'type' => 'deleted',
				),
				array(
					'name' => 'page.deleted.date',
					'desc' => 'Displays the Page Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'page.deleted.time',
					'desc' => 'Displays the Page Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'page.deleted.author',
					'desc' => 'Displays the User who Deleted the Page',
					'type' => 'deleted',
				),

				array(
					'name' => 'page.title',
					'desc' => 'Displays the Page Title',
					'type' => 'restored',
				),
				array(
					'name' => 'page.restored.date',
					'desc' => 'Displays the Page Restoring Date',
					'type' => 'restored',
				),
				array(
					'name' => 'page.restored.time',
					'desc' => 'Displays the Page Restoring Time',
					'type' => 'restored',
				),
				array(
					'name' => 'page.restored.author',
					'desc' => 'Displays the User who Restored the Page',
					'type' => 'restored',
				),
				array(
					'name' => 'page.created.count',
					'desc' => 'Displays the Number of Created Pages',
					'type' => 'additional',
				),
				array(
					'name' => 'page.updated.count',
					'desc' => 'Displays the Number of Updated Pages',
					'type' => 'additional',
				),
				array(
					'name' => 'page.trashed.count',
					'desc' => 'Displays the Number of Trashed Pages',
					'type' => 'additional',
				),
				array(
					'name' => 'page.restored.count',
					'desc' => 'Displays the Number of Restored Pages',
					'type' => 'additional',
				),
				array(
					'name' => 'page.deleted.count',
					'desc' => 'Displays the Number of Deleted Pages',
					'type' => 'additional',
				),
			),

			'comments'                 => array(
				array(
					'name' => 'section.comments.created',
					'desc' => 'Loops through Comments Created during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.comments.updated',
					'desc' => 'Loops through Comments Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.comments.trashed',
					'desc' => 'Loops through Comments Trashed during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.comments.deleted',
					'desc' => 'Loops through Comments Deleted during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.comments.edited',
					'desc' => 'Loops through Comments Edited during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.comments.restored',
					'desc' => 'Loops through Comments Restored during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.comments.approved',
					'desc' => 'Loops through Comments Approved during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.comments.spam',
					'desc' => 'Loops through Comments Spammed during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.comments.replied',
					'desc' => 'Loops through Comments Replied during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Created',
					'type' => 'created',
				),
				array(
					'name' => 'comment.created.date',
					'desc' => 'Displays the Comment Creating Date',
					'type' => 'created',
				),
				array(
					'name' => 'comment.created.time',
					'desc' => 'Displays the Comment Creating Time',
					'type' => 'created',
				),
				array(
					'name' => 'comment.created.author',
					'desc' => 'Displays the User who Created the Comment',
					'type' => 'created',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Updated',
					'type' => 'updated',
				),
				array(
					'name' => 'comment.updated.date',
					'desc' => 'Displays the Comment Updating Date',
					'type' => 'updated',
				),
				array(
					'name' => 'comment.updated.time',
					'desc' => 'Displays the Comment Updating Time',
					'type' => 'updated',
				),
				array(
					'name' => 'comment.updated.author',
					'desc' => 'Displays the User who Updated the Comment',
					'type' => 'updated',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Trashed',
					'type' => 'trashed',
				),
				array(
					'name' => 'comment.trashed.date',
					'desc' => 'Displays the Comment Trashing Date',
					'type' => 'trashed',
				),
				array(
					'name' => 'comment.trashed.time',
					'desc' => 'Displays the Comment Trashing Time',
					'type' => 'trashed',
				),
				array(
					'name' => 'comment.trashed.author',
					'desc' => 'Displays the User who Trashed the Comment',
					'type' => 'trashed',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Deleted',
					'type' => 'deleted',
				),
				array(
					'name' => 'comment.deleted.date',
					'desc' => 'Displays the Comment Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'comment.deleted.time',
					'desc' => 'Displays the Comment Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'comment.deleted.author',
					'desc' => 'Displays the User who Deleted the Comment',
					'type' => 'deleted',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Edited',
					'type' => 'edited',
				),
				array(
					'name' => 'comment.edited.date',
					'desc' => 'Displays the Comment Editing Date',
					'type' => 'edited',
				),
				array(
					'name' => 'comment.edited.time',
					'desc' => 'Displays the Comment Editing Time',
					'type' => 'edited',
				),
				array(
					'name' => 'comment.edited.author',
					'desc' => 'Displays the User who Edited the Comment',
					'type' => 'edited',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Restored',
					'type' => 'restored',
				),
				array(
					'name' => 'comment.restored.date',
					'desc' => 'Displays the Comment Restoring Date',
					'type' => 'restored',
				),
				array(
					'name' => 'comment.restored.time',
					'desc' => 'Displays the Comment Restoring Time',
					'type' => 'restored',
				),
				array(
					'name' => 'comment.restored.author',
					'desc' => 'Displays the User who Restored the Comment',
					'type' => 'restored',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Approved',
					'type' => 'approved',
				),
				array(
					'name' => 'comment.approved.date',
					'desc' => 'Displays the Comment Approving Date',
					'type' => 'approved',
				),
				array(
					'name' => 'comment.approved.time',
					'desc' => 'Displays the Comment Approving Time',
					'type' => 'approved',
				),
				array(
					'name' => 'comment.approved.author',
					'desc' => 'Displays the User who Approved the Comment',
					'type' => 'approved',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Spammed',
					'type' => 'spam',
				),
				array(
					'name' => 'comment.spam.date',
					'desc' => 'Displays the Comment Spamming Date',
					'type' => 'spam',
				),
				array(
					'name' => 'comment.spam.time',
					'desc' => 'Displays the Comment Spamming Time',
					'type' => 'spam',
				),
				array(
					'name' => 'comment.spam.author',
					'desc' => 'Displays the User who Spammed the Comment',
					'type' => 'spam',
				),

				array(
					'name' => 'comment.title',
					'desc' => 'Displays the Title of the Post or the Page where the Comment is Replied',
					'type' => 'replied',
				),
				array(
					'name' => 'comment.replied.date',
					'desc' => 'Displays the Comment Replying Date',
					'type' => 'replied',
				),
				array(
					'name' => 'comment.replied.time',
					'desc' => 'Displays the Comment Replying Time',
					'type' => 'replied',
				),
				array(
					'name' => 'comment.replied.author',
					'desc' => 'Displays the User who Replied the Comment',
					'type' => 'replied',
				),

				array(
					'name' => 'comment.created.count',
					'desc' => 'Displays the Number of Created Comments',
					'type' => 'additional',
				),
				array(
					'name' => 'comment.trashed.count',
					'desc' => 'Displays the Number of Trashed Comments',
					'type' => 'additional',
				),
				array(
					'name' => 'comment.deleted.count',
					'desc' => 'Displays the Number of Deleted Comments',
					'type' => 'additional',
				),
				array(
					'name' => 'comment.edited.count',
					'desc' => 'Displays the Number of Edited Comments',
					'type' => 'additional',
				),
				array(
					'name' => 'comment.restored.count',
					'desc' => 'Displays the Number of Restored Comments',
					'type' => 'additional',
				),
				array(
					'name' => 'comment.deleted.count',
					'desc' => 'Displays the Number of Deleted Comments',
					'type' => 'additional',
				),
				array(
					'name' => 'comment.approved.count',
					'desc' => 'Displays the Number of Approved Comments',
					'type' => 'additional',
				),
				array(
					'name' => 'comment.spam.count',
					'desc' => 'Displays the Number of Spammed Comments',
					'type' => 'additional',
				),
				array(
					'name' => 'comment.replied.count',
					'desc' => 'Displays the Number of Replied Comments',
					'type' => 'additional',
				),

			),
			'users'                    => array(

				array(
					'name' => 'section.users.created',
					'desc' => 'Loops through Users Created during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.users.updated',
					'desc' => 'Loops through Users Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.users.deleted',
					'desc' => 'Loops through Users Deleted during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'user.name',
					'desc' => 'Displays the User Name',
					'type' => 'created',
				),
				array(
					'name' => 'user.created.date',
					'desc' => 'Displays the User Creation Date',
					'type' => 'created',
				),
				array(
					'name' => 'user.created.time',
					'desc' => 'Displays the User Creation Time',
					'type' => 'created',
				),
				array(
					'name' => 'user.created.author',
					'desc' => 'Displays the User who Created the new User',
					'type' => 'created',
				),
				array(
					'name' => 'user.created.role',
					'desc' => 'Displays the Role of the Created User',
					'type' => 'created',
				),

				array(
					'name' => 'user.name',
					'desc' => 'Displays the User Name',
					'type' => 'updated',
				),
				array(
					'name' => 'user.updated.date',
					'desc' => 'Displays the User Updating Date',
					'type' => 'updated',
				),
				array(
					'name' => 'user.updated.time',
					'desc' => 'Displays the User Updating Time',
					'type' => 'updated',
				),
				array(
					'name' => 'user.updated.author',
					'desc' => 'Displays the User who Updated the new User',
					'type' => 'updated',
				),
				array(
					'name' => 'user.updated.role',
					'desc' => 'Displays the Role of the Updated User',
					'type' => 'updated',
				),

				array(
					'name' => 'user.name',
					'desc' => 'Displays the User Name',
					'type' => 'deleted',
				),
				array(
					'name' => 'user.deleted.date',
					'desc' => 'Displays the User Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'user.deleted.time',
					'desc' => 'Displays the User Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'user.deleted.author',
					'desc' => 'Displays the User who Deleted the new User',
					'type' => 'deleted',
				),

				array(
					'name' => 'user.created.count',
					'desc' => 'Displays the Number of Created Users',
					'type' => 'additional',
				),
				array(
					'name' => 'user.updated.count',
					'desc' => 'Displays the Number of Updated Users',
					'type' => 'additional',
				),
				array(
					'name' => 'user.deleted.count',
					'desc' => 'Displays the Number of Deleted Users',
					'type' => 'additional',
				),
			),

			'media'                    => array(

				array(
					'name' => 'section.media.uploaded',
					'desc' => 'Loops through Media Uploaded during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.media.updated',
					'desc' => 'Loops through Media Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.media.deleted',
					'desc' => 'Loops through Media Deleted during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'media.name',
					'desc' => 'Displays the Media Name',
					'type' => 'uploaded',
				),
				array(
					'name' => 'media.uploaded.date',
					'desc' => 'Displays the Media Uploading Date',
					'type' => 'uploaded',
				),
				array(
					'name' => 'media.uploaded.time',
					'desc' => 'Displays the Media Uploading Time',
					'type' => 'uploaded',
				),
				array(
					'name' => 'media.uploaded.author',
					'desc' => 'Displays the User who Uploaded the Media File',
					'type' => 'uploaded',
				),

				array(
					'name' => 'media.name',
					'desc' => 'Displays the Media Name',
					'type' => 'updated',
				),
				array(
					'name' => 'media.updated.date',
					'desc' => 'Displays the Media Updating Date',
					'type' => 'updated',
				),
				array(
					'name' => 'media.updated.time',
					'desc' => 'Displays the Media Updating Time',
					'type' => 'updated',
				),
				array(
					'name' => 'media.updated.author',
					'desc' => 'Displays the User who Updted the Media File',
					'type' => 'updated',
				),

				array(
					'name' => 'media.name',
					'desc' => 'Displays the Media Name',
					'type' => 'deleted',
				),
				array(
					'name' => 'media.deleted.date',
					'desc' => 'Displays the Media Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'media.deleted.time',
					'desc' => 'Displays the Media Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'media.deleted.author',
					'desc' => 'Displays the User who Deleted the Media File',
					'type' => 'deleted',
				),

				array(
					'name' => 'media.uploaded.count',
					'desc' => 'Displays the Number of Uploaded Media Files',
					'type' => 'additional',
				),
				array(
					'name' => 'media.updated.count',
					'desc' => 'Displays the Number of Updated Media Files',
					'type' => 'additional',
				),
				array(
					'name' => 'media.deleted.count',
					'desc' => 'Displays the Number of Deleted Media Files',
					'type' => 'additional',
				),

			),

			'widgets'                  => array(
				array(
					'name' => 'section.widgets.added',
					'desc' => 'Loops through Widgets Added during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.widgets.updated',
					'desc' => 'Loops through Widgets Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.widgets.deleted',
					'desc' => 'Loops through Widgets Deleted during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'widget.title',
					'desc' => 'Displays the Widget Title',
					'type' => 'added',
				),
				array(
					'name' => 'widget.added.area',
					'desc' => 'Displays the Widget Adding Area',
					'type' => 'added',
				),
				array(
					'name' => 'widget.added.date',
					'desc' => 'Displays the Widget Adding Date',
					'type' => 'added',
				),
				array(
					'name' => 'widget.added.time',
					'desc' => 'Displays the Widget Adding Time',
					'type' => 'added',
				),
				array(
					'name' => 'widget.added.author',
					'desc' => 'Displays the User who Added the Widget',
					'type' => 'added',
				),

				array(
					'name' => 'widget.title',
					'desc' => 'Displays the Widget Name',
					'type' => 'updated',
				),
				array(
					'name' => 'widget.updated.area',
					'desc' => 'Displays the Widget Updating Area',
					'type' => 'updated',
				),
				array(
					'name' => 'widget.updated.date',
					'desc' => 'Displays the Widget Updating Date',
					'type' => 'updated',
				),
				array(
					'name' => 'widget.updated.time',
					'desc' => 'Displays the Widget Updating Time',
					'type' => 'updated',
				),
				array(
					'name' => 'widget.updated.author',
					'desc' => 'Displays the User who Updated the Widget',
					'type' => 'updated',
				),

				array(
					'name' => 'widget.title',
					'desc' => 'Displays the Widget Name',
					'type' => 'deleted',
				),
				array(
					'name' => 'widget.deleted.area',
					'desc' => 'Displays the Widget Deleting Area',
					'type' => 'deleted',
				),
				array(
					'name' => 'widget.deleted.date',
					'desc' => 'Displays the Widget Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'widget.deleted.time',
					'desc' => 'Displays the Widget Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'widget.deleted.author',
					'desc' => 'Displays the User who Deleted the Widget',
					'type' => 'deleted',
				),

				array(
					'name' => 'widget.added.count',
					'desc' => 'Displays the Number of Added Widgets',
					'type' => 'additional',
				),
				array(
					'name' => 'widget.updated.count',
					'desc' => 'Displays the Number of Updated Widgets',
					'type' => 'additional',
				),
				array(
					'name' => 'widget.deleted.count',
					'desc' => 'Displays the Number of Deleted Widgets',
					'type' => 'additional',
				),

			),

			'menus'                    => array(

				array(
					'name' => 'section.menus.created',
					'desc' => 'Loops through Menus Created during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.menus.updated',
					'desc' => 'Loops through Menus Updated during the selected date range',
					'type' => 'section',
				),
				array(
					'name' => 'section.menus.deleted',
					'desc' => 'Loops through Menus Deleted during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'menu.title',
					'desc' => 'Displays the Menu Name',
					'type' => 'created',
				),
				array(
					'name' => 'menu.created.date',
					'desc' => 'Displays the Menu Creation Date',
					'type' => 'created',
				),
				array(
					'name' => 'menu.created.time',
					'desc' => 'Displays the Menu Creation Time',
					'type' => 'created',
				),
				array(
					'name' => 'menu.created.author',
					'desc' => 'Displays the User who Created the Menu',
					'type' => 'created',
				),

				array(
					'name' => 'menu.title',
					'desc' => 'Displays the Menu Name',
					'type' => 'updated',
				),
				array(
					'name' => 'menu.updated.date',
					'desc' => 'Displays the Menu Updating Date',
					'type' => 'updated',
				),
				array(
					'name' => 'menu.updated.time',
					'desc' => 'Displays the Menu Updating Time',
					'type' => 'updated',
				),
				array(
					'name' => 'menu.updated.author',
					'desc' => 'Displays the User who Updated the Menu',
					'type' => 'updated',
				),

				array(
					'name' => 'menu.title',
					'desc' => 'Displays the Menu Name',
					'type' => 'deleted',
				),
				array(
					'name' => 'menu.deleted.date',
					'desc' => 'Displays the Menu Deleting Date',
					'type' => 'deleted',
				),
				array(
					'name' => 'menu.deleted.time',
					'desc' => 'Displays the Menu Deleting Time',
					'type' => 'deleted',
				),
				array(
					'name' => 'menu.deleted.author',
					'desc' => 'Displays the User who Deleted the Menu',
					'type' => 'deleted',
				),

				array(
					'name' => 'menu.created.count',
					'desc' => 'Displays the Number of Created Menus',
					'type' => 'additional',
				),
				array(
					'name' => 'menu.updated.count',
					'desc' => 'Displays the Number of Updated Menus',
					'type' => 'additional',
				),
				array(
					'name' => 'menu.deleted.count',
					'desc' => 'Displays the Number of Deleted Menus',
					'type' => 'additional',
				),

			),

			'wordpress'                => array(

				array(
					'name' => 'section.wordpress.updated',
					'desc' => 'Loops through WordPress Updates during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'wordpress.updated.date',
					'desc' => 'Displays the WordPress Update Date',
					'type' => 'updated',
				),
				array(
					'name' => 'wordpress.updated.time',
					'desc' => 'Displays the WordPress Update Time',
					'type' => 'updated',
				),
				array(
					'name' => 'wordpress.updated.author',
					'desc' => 'Displays the User who Updated the Site',
					'type' => 'updated',
				),

				array(
					'name' => 'wordpress.old.version',
					'desc' => 'Displays the WordPress Version Before Update',
					'type' => 'additional',
				),
				array(
					'name' => 'wordpress.current.version',
					'desc' => 'Displays the Current WordPress Version',
					'type' => 'additional',
				),
				array(
					'name' => 'wordpress.updated.count',
					'desc' => 'Displays the Number of WordPress Updates',
					'type' => 'additional',
				),

			),

			'backups'                  => array(

				array(
					'name' => 'section.backups.created',
					'desc' => ' Loops through Backups Created during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'backup.created.type',
					'desc' => ' Displays the Created Backup type (Full or Database)',
					'type' => 'created',
				),
				array(
					'name' => 'backup.created.date',
					'desc' => 'Displays the Backups Creation Date',
					'type' => 'created',
				),
				array(
					'name' => 'backup.created.time',
					'desc' => 'Displays the Backups Creation Time',
					'type' => 'created',
				),

				array(
					'name' => 'backup.created.count',
					'desc' => 'Displays the number of created backups during the selected date range',
					'type' => 'additional',
				),

			),
			'report'                   => array(
				array(
					'name' => 'report.daterange',
					'desc' => 'Displays the report date range',
					'type' => 'report',
				),
				array(
					'name' => 'report.send.date',
					'desc' => 'Displays the report send date',
					'type' => 'report',
				),
			),

			'sucuri'                   => array(
				array(
					'name' => 'section.sucuri.checks',
					'desc' => 'Loops through Security Checks during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'sucuri.check.date',
					'desc' => 'Displays the Security Check date',
					'type' => 'check',
				),
				array(
					'name' => 'sucuri.check.time',
					'desc' => 'Displays the Security Check time',
					'type' => 'check',
				),
				array(
					'name' => 'sucuri.check.status',
					'desc' => 'Displays the Status info for the Child Site',
					'type' => 'check',
				),
				array(
					'name' => 'sucuri.check.webtrust',
					'desc' => 'Displays the Webtrust info for the Child Site',
					'type' => 'check',
				),

				array(
					'name' => 'sucuri.checks.count',
					'desc' => 'Displays the number of performed security checks during the selected date range',
					'type' => 'additional',
				),

			),

			'ga'                       => array(
				array(
					'name' => 'ga.visits',
					'desc' => 'Displays the Number Visits during the selected date range',
					'type' => 'ga',
				),
				array(
					'name' => 'ga.pageviews',
					'desc' => 'Displays the Number of Page Views during the selected date range',
					'type' => 'ga',
				),
				array(
					'name' => 'ga.pages.visit',
					'desc' => 'Displays the Number of Page visit during the selected date range',
					'type' => 'ga',
				),
				array(
					'name' => 'ga.bounce.rate',
					'desc' => 'Displays the Bounce Rate during the selected date range',
					'type' => 'ga',
				),
				array(
					'name' => 'ga.avg.time',
					'desc' => 'Displays the Average Visit Time during the selected date range',
					'type' => 'ga',
				),
				array(
					'name' => 'ga.new.visits',
					'desc' => 'Displays the Number of New Visits during the selected date range',
					'type' => 'ga',
				),
				array(
					'name' => 'ga.visits.chart',
					'desc' => 'Displays a chart for the activity over the past month',
					'type' => 'ga',
				),
				array(
					'name' => 'ga.visits.maximum',
					'desc' => "Displays the maximum visitor number and it's day within the past month",
					'type' => 'ga',
				),
				array(
					'name' => 'ga.startdate',
					'desc' => 'Displays the startdate for the chart',
					'type' => 'ga',
				),
				array(
					'name' => 'ga.enddate',
					'desc' => 'Displays the enddate or the chart',
					'type' => 'ga',
				),

			),

			'piwik'                    => array(
				array(
					'name' => 'piwik.visits',
					'desc' => 'Displays the Number Visits during the selected date range',
					'type' => 'piwik',
				),
				array(
					'name' => 'piwik.pageviews',
					'desc' => 'Displays the Number of Page Views during the selected date range',
					'type' => 'piwik',
				),
				array(
					'name' => 'piwik.pages.visit',
					'desc' => 'Displays the Number of Page visit during the selected date range',
					'type' => 'piwik',
				),
				array(
					'name' => 'piwik.bounce.rate',
					'desc' => 'Displays the Bounce Rate during the selected date range',
					'type' => 'piwik',
				),
				array(
					'name' => 'piwik.avg.time',
					'desc' => 'Displays the Average Visit Time during the selected date range',
					'type' => 'piwik',
				),
				array(
					'name' => 'piwik.new.visits',
					'desc' => 'Displays the Number of New Visits during the selected date range',
					'type' => 'piwik',
				),
			),

			'aum'                      => array(
				array(
					'name' => 'aum.alltimeuptimeratio',
					'desc' => 'Displays the Uptime ratio from the moment the monitor has been created',
					'type' => 'aum',
				),
				array(
					'name' => 'aum.uptime7',
					'desc' => 'Displays the Uptime ratio for last 7 days',
					'type' => 'aum',
				),
				array(
					'name' => 'aum.uptime15',
					'desc' => 'Displays the Uptime ration for last 15 days',
					'type' => 'aum',
				),
				array(
					'name' => 'aum.uptime30',
					'desc' => 'Displays the Uptime ration for last 30 days',
					'type' => 'aum',
				),
				array(
					'name' => 'aum.uptime45',
					'desc' => 'Displays the Uptime ration for last 45 days',
					'type' => 'aum',
				),
				array(
					'name' => 'aum.uptime60',
					'desc' => 'Displays the Uptime ration for last 60 days',
					'type' => 'aum',
				),
				array(
					'name' => 'aum.stats',
					'desc' => 'Displays the Uptime Statistics',
					'type' => 'aum',
				),

			),
			'woocomstatus'             => array(
				array(
					'name' => 'wcomstatus.sales',
					'desc' => 'Displays total sales during the selected data range',
					'type' => 'woocomstatus',
				),
				array(
					'name' => 'wcomstatus.topseller',
					'desc' => 'Displays the top seller product during the selected data range',
					'type' => 'woocomstatus',
				),
				array(
					'name' => 'wcomstatus.awaitingprocessing',
					'desc' => 'Displays the number of products currently awaiting for processing',
					'type' => 'woocomstatus',
				),
				array(
					'name' => 'wcomstatus.onhold',
					'desc' => 'Displays the number of orders currently on hold',
					'type' => 'woocomstatus',
				),
				array(
					'name' => 'wcomstatus.lowonstock',
					'desc' => 'Displays the number of products currently low on stock',
					'type' => 'woocomstatus',
				),
				array(
					'name' => 'wcomstatus.outofstock',
					'desc' => 'Displays the number of products currently out of stock',
					'type' => 'woocomstatus',
				),
			),

			'wordfence'                => array(
				array(
					'name' => 'section.wordfence.scan',
					'desc' => 'Loops through Wordfence scans during the selected date range',
					'type' => 'section',
				),

				array(
					'name' => 'wordfence.scan.result',
					'desc' => 'Displays the Wordfence scan result',
					'type' => 'scan',
				),
				array(
					'name' => 'wordfence.scan.date',
					'desc' => 'Displays the Wordfence scan date',
					'type' => 'scan',
				),
				array(
					'name' => 'wordfence.scan.time',
					'desc' => 'Displays the Wordfence scan time',
					'type' => 'scan',
				),
				array(
					'name' => 'wordfence.scan.details',
					'desc' => 'Displays the Wordfence scan details',
					'type' => 'scan',
				),

				array(
					'name' => 'wordfence.scan.count',
					'desc' => 'Displays the number of performed Wordfence scans during the selected date range',
					'type' => 'additional',
				),

			),

			'maintenance'              => array(
				array(
					'name' => 'section.maintenance.process',
					'desc' => 'Loops through performed Maintenance actions',
					'type' => 'section',
				),

				array(
					'name' => 'maintenance.process.result',
					'desc' => 'Displays the status of performed Maintenance',
					'type' => 'process',
				),
				array(
					'name' => 'maintenance.process.date',
					'desc' => 'Displays the date of performed Maintenance',
					'type' => 'process',
				),
				array(
					'name' => 'maintenance.process.time',
					'desc' => 'Displays the time of performed Maintenance',
					'type' => 'process',
				),
				array(
					'name' => 'maintenance.process.details',
					'desc' => 'Displays performed actions',
					'type' => 'process',
				),

				array(
					'name' => 'maintenance.process.count',
					'desc' => 'Displays the number of performed Maintenance actions during the selected date range',
					'type' => 'additional',
				),

			),

			'pagespeed'                => array(
				array(
					'name' => 'pagespeed.average.desktop',
					'desc' => 'Displays the average desktop page-speed score at the moment of report generation',
					'type' => 'pagespeed',
				),
				array(
					'name' => 'pagespeed.average.mobile',
					'desc' => 'Displays the average mobile page-speed score at the moment of report creation',
					'type' => 'pagespeed',
				),
			),
			'virusdie'                 => array(
				array(
					'name' => 'section.virusdie.scans',
					'desc' => 'Loops through scans during the selected period',
					'type' => 'section',
				),

				array(
					'name' => 'virusdie.scan.time',
					'desc' => 'Returns the time of scan',
					'type' => 'scan',
				),
				array(
					'name' => 'virusdie.scan.date',
					'desc' => 'Returns the date of scan',
					'type' => 'scan',
				),
				array(
					'name' => 'virusdie.scan.status',
					'desc' => 'Returns scan status (there are a few available, Sync Error, Threats were found, and No Threats found)',
					'type' => 'scan',
				),
				array(
					'name' => 'virusdie.scan.details',
					'desc' => 'Returns the scan details in a list like: Files scaned: xxx; Malicious: xxx; Suspicious: xxx; .....',
					'type' => 'scan',
				),

				array(
					'name' => 'virusdie.scans.count',
					'desc' => 'Displays the number of scans performed during the selected period',
					'type' => 'additional',
				),

			),

			'vulnerable'               => array(
				array(
					'name' => 'vulnerable.plugins',
					'desc' => 'Displays the vulnerable plugins score at the moment of report generation',
					'type' => 'vulnerable',
				),
				array(
					'name' => 'vulnerable.themes',
					'desc' => 'Displays the vulnerable themes score at the moment of report creation',
					'type' => 'vulnerable',
				),
				array(
					'name' => 'vulnerabilities.count',
					'desc' => 'Displays the vulnerabilities count score at the moment of report creation',
					'type' => 'vulnerable',
				),
			),

			'lighthouse'               => array(
				array(
					'name' => 'lighthouse.performance.desktop',
					'desc' => 'Displays the average desktop performance score at the moment of report generation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.performance.mobile',
					'desc' => 'Displays the average mobile performance score at the moment of report creation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.accessibility.desktop',
					'desc' => 'Displays the average desktop accessibility score at the moment of report generation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.accessibility.mobile',
					'desc' => 'Displays the average mobile accessibility score at the moment of report creation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.bestpractices.desktop',
					'desc' => 'Displays the average desktop best practices score at the moment of report generation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.bestpractices.mobile',
					'desc' => 'Displays the average mobile best practices score at the moment of report creation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.seo.desktop',
					'desc' => 'Displays the average desktop seo score at the moment of report generation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.seo.mobile',
					'desc' => 'Displays the average mobile seo score at the moment of report creation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.audits.desktop',
					'desc' => 'Displays the average desktop audits at the moment of report generation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.audits.mobile',
					'desc' => 'Displays the average mobile audits at the moment of report creation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.lastcheck.desktop',
					'desc' => 'Displays the average desktop last check at the moment of report generation',
					'type' => 'lighthouse',
				),
				array(
					'name' => 'lighthouse.lastcheck.mobile',
					'desc' => 'Displays the average mobile last check at the moment of report creation',
					'type' => 'lighthouse',
				),

			),
			'domainmonitor'            => array(
				array(
					'name' => 'domain.monitor.domain.name',
					'desc' => 'Displays the domain name',
					'type' => 'domainmonitor',
				),
				array(
					'name' => 'domain.monitor.registrar',
					'desc' => 'Displays the domain registrar',
					'type' => 'domainmonitor',
				),
				array(
					'name' => 'domain.monitor.updated.date',
					'desc' => 'Displays the monitor updated date',
					'type' => 'domainmonitor',
				),
				array(
					'name' => 'domain.monitor.creation.date',
					'desc' => 'Displays the domain monitor creation date',
					'type' => 'domainmonitor',
				),
				array(
					'name' => 'domain.monitor.expiry.date',
					'desc' => 'Displays the domain monitor expiry date',
					'type' => 'domainmonitor',
				),
				array(
					'name' => 'domain.monitor.expires',
					'desc' => 'Displays the domain monitor expires',
					'type' => 'domainmonitor',
				),
				array(
					'name' => 'domain.monitor.status',
					'desc' => 'Displays the domain monitor status',
					'type' => 'domainmonitor',
				),
				array(
					'name' => 'domain.monitor.last.check',
					'desc' => 'Displays the domain monitor last check',
					'type' => 'domainmonitor',
				),
			),

			'compatible_tokens_values' => array(
				'[sucuri.check.date]'             => '',
				'[sucuri.check.time]'             => '',
				'[sucuri.check.status]'           => '',
				'[sucuri.check.webtrust]'         => '',
				'[sucuri.check.count]'            => '',

				'[ga.visits]'                     => '',
				'[ga.pageviews]'                  => '',
				'[ga.pages.visit]'                => '',
				'[ga.bounce.rate]'                => '',
				'[ga.avg.time]'                   => '',
				'[ga.new.visits]'                 => '',
				'[ga.visits.chart]'               => '',
				'[ga.visits.maximum]'             => '',
				'[ga.startdate]'                  => '',
				'[ga.enddate]'                    => '',

				'[piwik.visits]'                  => '',
				'[piwik.pageviews]'               => '',
				'[piwik.pages.visit]'             => '',
				'[piwik.bounce.rate]'             => '',
				'[piwik.avg.time]'                => '',
				'[piwik.new.visits]'              => '',

				'[aum.alltimeuptimeratio]'        => '',
				'[aum.uptime7]'                   => '',
				'[aum.uptime15]'                  => '',
				'[aum.uptime30]'                  => '',
				'[aum.uptime45]'                  => '',
				'[aum.uptime60]'                  => '',
				'[aum.stats]'                     => '',

				'[wcomstatus.sales]'              => '',
				'[wcomstatus.topseller]'          => '',
				'[wcomstatus.awaitingprocessing]' => '',
				'[wcomstatus.onhold]'             => '',
				'[wcomstatus.lowonstock]'         => '',
				'[wcomstatus.outofstock]'         => '',

				'[wordfence.scan.result]'         => '',
				'[wordfence.scan.date]'           => '',
				'[wordfence.scan.time]'           => '',
				'[wordfence.scan.details]'        => '',
				'[wordfence.scan.count]'          => '',

				'[maintenance.process.result]'    => '',
				'[maintenance.process.date]'      => '',
				'[maintenance.process.time]'      => '',
				'[maintenance.process.details]'   => '',
				'[maintenance.process.count]'     => '',

				'[pagespeed.average.desktop]'     => '',
				'[pagespeed.average.mobile]'      => '',

			),

		);

	}




	public function get_default_tokens_values( $group, $type = '' ) {
		$tokens_default_values = array();
		$tokens                = $this->get_reports_tokens( $group, $type );

		if ( is_array( $tokens ) ) {
			foreach ( $tokens as $token ) {
				if ( is_array( $token ) && isset( $token['name'] ) ) {
					$tokens_default_values[ '[' . $token['name'] . ']' ] = 'N/A';
				}
			}
		}

		return $tokens_default_values;
	}


	public function get_compatible_tokens_values() {
		return $this->get_reports_tokens( 'compatible_tokens_values' );
	}


	private function get_reports_tokens( $group, $type = '' ) {

		if ( 'compatible_tokens_values' === $group ) {
			if ( isset( self::$reports_tokens[ $group ] ) && is_array( self::$reports_tokens[ $group ] ) ) {
				return self::$reports_tokens[ $group ];
			}
			return array();
		}

		if ( empty( $type ) ) {
			return array();
		}

		$tokens = array();
		if ( isset( self::$reports_tokens[ $group ] ) && is_array( self::$reports_tokens[ $group ] ) ) {
			foreach ( self::$reports_tokens[ $group ] as $token ) {
				if ( isset( $token['type'] ) && $type == $token['type'] ) {
					$tokens[] = $token;
				}
			}
		}
		return $tokens;
	}


	/**
	 * Get  group reports tokens.
	 *
	 * to compatible.
	 */
	public function get_group_reports_tokens() {
		$nav_group_tokens = array(
			'client'        => array(
				'nav_group_tokens' => array(
					'tokens' => 'Tokens',
				),
				'tokens'           => array(),
			),
			'plugins'       => array(
				'nav_group_tokens' => array(
					'sections'    => 'Sections',
					'installed'   => 'Installed',
					'activated'   => 'Activated',
					'edited'      => 'Edited',
					'deactivated' => 'Deactivated',
					'updated'     => 'Updated',
					'deleted'     => 'Deleted',
					'additional'  => 'Additional',
				),

				'sections'         => $this->get_reports_tokens( 'plugins', 'section' ),
				'installed'        => $this->get_reports_tokens( 'plugins', 'installed' ),
				'activated'        => $this->get_reports_tokens( 'plugins', 'activated' ),
				'edited'           => $this->get_reports_tokens( 'plugins', 'edited' ),
				'deactivated'      => $this->get_reports_tokens( 'plugins', 'deactivated' ),
				'updated'          => $this->get_reports_tokens( 'plugins', 'updated' ),
				'deleted'          => $this->get_reports_tokens( 'plugins', 'deleted' ),
				'additional'       => $this->get_reports_tokens( 'plugins', 'additional' ),

			),
			'themes'        => array(
				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'installed'  => 'Installed',
					'activated'  => 'Activated',
					'edited'     => 'Edited',
					'updated'    => 'Updated',
					'deleted'    => 'Deleted',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'themes', 'section' ),
				'installed'        => $this->get_reports_tokens( 'themes', 'installed' ),
				'activated'        => $this->get_reports_tokens( 'themes', 'activated' ),
				'edited'           => $this->get_reports_tokens( 'themes', 'edited' ),
				'updated'          => $this->get_reports_tokens( 'themes', 'updated' ),
				'deleted'          => $this->get_reports_tokens( 'themes', 'deleted' ),
				'additional'       => $this->get_reports_tokens( 'themes', 'additional' ),
			),

			'posts'         => array(
				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'created'    => 'Created',
					'updated'    => 'Updated',
					'trashed'    => 'Trashed',
					'deleted'    => 'Deleted',
					'restored'   => 'Restored',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'posts', 'section' ),
				'created'          => $this->get_reports_tokens( 'posts', 'created' ),
				'updated'          => $this->get_reports_tokens( 'posts', 'updated' ),
				'trashed'          => $this->get_reports_tokens( 'posts', 'trashed' ),
				'deleted'          => $this->get_reports_tokens( 'posts', 'deleted' ),
				'restored'         => $this->get_reports_tokens( 'posts', 'restored' ),
				'additional'       => $this->get_reports_tokens( 'posts', 'additional' ),
			),

			'pages'         => array(

				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'created'    => 'Created',
					'updated'    => 'Updated',
					'trashed'    => 'Trashed',
					'deleted'    => 'Deleted',
					'restored'   => 'Restored',
					'additional' => 'Additional',
				),

				'sections'         => $this->get_reports_tokens( 'pages', 'section' ),
				'created'          => $this->get_reports_tokens( 'pages', 'created' ),
				'updated'          => $this->get_reports_tokens( 'pages', 'updated' ),
				'trashed'          => $this->get_reports_tokens( 'pages', 'trashed' ),
				'deleted'          => $this->get_reports_tokens( 'pages', 'deleted' ),
				'restored'         => $this->get_reports_tokens( 'pages', 'restored' ),
				'additional'       => $this->get_reports_tokens( 'pages', 'additional' ),
			),

			'comments'      => array(
				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'created'    => 'Created',
					'updated'    => 'Updated',
					'trashed'    => 'Trashed',
					'deleted'    => 'Deleted',
					'edited'     => 'Edited',
					'restored'   => 'Restored',
					'approved'   => 'Approved',
					'spam'       => 'Spam',
					'replied'    => 'Replied',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'comments', 'section' ),
				'created'          => $this->get_reports_tokens( 'comments', 'created' ),
				'updated'          => $this->get_reports_tokens( 'comments', 'updated' ),
				'trashed'          => $this->get_reports_tokens( 'comments', 'trashed' ),
				'deleted'          => $this->get_reports_tokens( 'comments', 'deleted' ),
				'edited'           => $this->get_reports_tokens( 'comments', 'edited' ),
				'restored'         => $this->get_reports_tokens( 'comments', 'restored' ),
				'approved'         => $this->get_reports_tokens( 'comments', 'approved' ),
				'spam'             => $this->get_reports_tokens( 'comments', 'spam' ),
				'replied'          => $this->get_reports_tokens( 'comments', 'replied' ),

				'additional'       => $this->get_reports_tokens( 'comments', 'additional' ),
			),

			'users'         => array(

				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'created'    => 'Created',
					'updated'    => 'Updated',
					'deleted'    => 'Deleted',
					'additional' => 'Additional',
				),

				'sections'         => $this->get_reports_tokens( 'users', 'section' ),
				'created'          => $this->get_reports_tokens( 'users', 'created' ),
				'updated'          => $this->get_reports_tokens( 'users', 'updated' ),
				'deleted'          => $this->get_reports_tokens( 'users', 'deleted' ),
				'additional'       => $this->get_reports_tokens( 'users', 'additional' ),
			),

			'media'         => array(

				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'uploaded'   => 'Uploaded',
					'updated'    => 'Updated',
					'deleted'    => 'Deleted',
					'additional' => 'Additional',
				),

				'sections'         => $this->get_reports_tokens( 'media', 'section' ),
				'uploaded'         => $this->get_reports_tokens( 'media', 'uploaded' ),
				'updated'          => $this->get_reports_tokens( 'media', 'updated' ),
				'deleted'          => $this->get_reports_tokens( 'media', 'deleted' ),
				'additional'       => $this->get_reports_tokens( 'media', 'additional' ),
			),

			'widgets'       => array(

				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'added'      => 'Added',
					'updated'    => 'Updated',
					'deleted'    => 'Deleted',
					'additional' => 'Additional',
				),

				'sections'         => $this->get_reports_tokens( 'widgets', 'section' ),
				'added'            => $this->get_reports_tokens( 'widgets', 'added' ),
				'updated'          => $this->get_reports_tokens( 'widgets', 'updated' ),
				'deleted'          => $this->get_reports_tokens( 'widgets', 'deleted' ),
				'additional'       => $this->get_reports_tokens( 'widgets', 'additional' ),
			),

			'menus'         => array(

				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'created'    => 'Created',
					'updated'    => 'Updated',
					'deleted'    => 'Deleted',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'menus', 'section' ),
				'created'          => $this->get_reports_tokens( 'menus', 'created' ),
				'updated'          => $this->get_reports_tokens( 'menus', 'updated' ),
				'deleted'          => $this->get_reports_tokens( 'menus', 'deleted' ),
				'additional'       => $this->get_reports_tokens( 'menus', 'additional' ),
			),
			'wordpress'     => array(

				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'updated'    => 'Updated',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'wordpress', 'section' ),
				'updated'          => $this->get_reports_tokens( 'wordpress', 'updated' ),
				'additional'       => $this->get_reports_tokens( 'wordpress', 'additional' ),
			),

			'backups'       => array(
				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'created'    => 'Created',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'backups', 'section' ),
				'created'          => $this->get_reports_tokens( 'backups', 'created' ),
				'additional'       => $this->get_reports_tokens( 'backups', 'additional' ),
			),

			'report'        => array(
				'nav_group_tokens' => array( 'report' => 'Report' ),
				'report'           => $this->get_reports_tokens( 'report', 'report' ),
			),
			'sucuri'        => array(
				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'check'      => 'Checks',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'sucuri', 'section' ),
				'check'            => $this->get_reports_tokens( 'sucuri', 'check' ),
				'additional'       => $this->get_reports_tokens( 'sucuri', 'additional' ),
			),

			'ga'            => array(
				'nav_group_tokens' => array(
					'ga' => 'GA',
				),
				'ga'               => $this->get_reports_tokens( 'ga', 'ga' ),
			),

			'piwik'         => array(
				'nav_group_tokens' => array(
					'piwik' => 'Piwik',
				),
				'piwik'            => $this->get_reports_tokens( 'piwik', 'piwik' ),
			),

			'aum'           => array(
				'nav_group_tokens' => array(
					'aum' => 'AUM',
				),
				'aum'              => $this->get_reports_tokens( 'aum', 'aum' ),
			),

			'woocomstatus'  => array(
				'nav_group_tokens' => array(
					'woocomstatus' => 'WooCommerce Status',
				),
				'woocomstatus'     => $this->get_reports_tokens( 'woocomstatus', 'woocomstatus' ),
			),

			'wordfence'     => array(
				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'scan'       => 'Scan',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'wordfence', 'section' ),
				'scan'             => $this->get_reports_tokens( 'wordfence', 'scan' ),
				'additional'       => $this->get_reports_tokens( 'wordfence', 'additional' ),
			),

			'maintenance'   => array(
				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'process'    => 'Process',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'maintenance', 'section' ),
				'process'          => $this->get_reports_tokens( 'maintenance', 'process' ),
				'additional'       => $this->get_reports_tokens( 'maintenance', 'additional' ),

			),

			'pagespeed'     => array(
				'nav_group_tokens' => array(
					'pagespeed' => 'Page speed',
				),
				'pagespeed'        => $this->get_reports_tokens( 'pagespeed', 'pagespeed' ),

			),

			'virusdie'      => array(
				'nav_group_tokens' => array(
					'sections'   => 'Sections',
					'scan'       => 'Scans',
					'additional' => 'Additional',
				),
				'sections'         => $this->get_reports_tokens( 'virusdie', 'section' ),
				'scan'             => $this->get_reports_tokens( 'virusdie', 'scan' ),
				'additional'       => $this->get_reports_tokens( 'virusdie', 'additional' ),

			),

			'vulnerable'    => array(
				'nav_group_tokens' => array(
					'vulnerable' => 'Vulnerability',
				),
				'vulnerable'       => $this->get_reports_tokens( 'vulnerable', 'vulnerable' ),
			),

			'lighthouse'    => array(
				'nav_group_tokens' => array(
					'lighthouse' => 'Lighthouse',
				),
				'lighthouse'       => $this->get_reports_tokens( 'lighthouse', 'lighthouse' ),
			),

			'domainmonitor' => array(
				'nav_group_tokens' => array(
					'domainmonitor' => 'Domain monitor',
				),
				'domainmonitor'    => $this->get_reports_tokens( 'domainmonitor', 'domainmonitor' ),
			),
		);

		return $nav_group_tokens;
	}

}
