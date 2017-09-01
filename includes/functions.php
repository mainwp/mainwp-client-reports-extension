<?php

  function mainwp_creport_admin_print_footer_scripts() {
        $client_tokens = MainWP_CReport_DB::get_instance()->get_tokens(); 
        ?>        
            <script type="text/javascript">
                jQuery(function ($) {
                    tinymce.on('SetupEditor', function (editor) {                
                        if (editor.id === 'mainwp_creport_report_header' || editor.id === 'mainwp_creport_report_body' || editor.id === 'mainwp_creport_report_footer') {                                 
                                editor.addButton('insertsection', {
                                    type: 'menubutton',
                                    text: 'Insert Sections',
                                    icon: false,
                                    menu: [                            
                                         {
                                            text: 'Plugins',
                                            menu: [{
                                                    text: 'Installed',
                                                    onclick: function() {
                                                        editor.insertContent('[section.plugins.installed]([plugin.installed.date], [plugin.installed.time]) [plugin.name] by [plugin.installed.author];[/section.plugins.installed]');
                                                    }

                                                }, {
                                                    text: 'Activated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.plugins.activated]([plugin.activated.date], [plugin.activated.time]) [plugin.name] by [plugin.activated.author];[/section.plugins.activated]');
                                                    }

                                                }, {
                                                    text: 'Edited',
                                                    onclick: function() {
                                                        editor.insertContent('[section.plugins.edited]([plugin.edited.date], [plugin.edited.time]) [plugin.name] by [plugin.edited.author];[/section.plugins.edited]');
                                                    }

                                                }, {
                                                    text: 'Deactivated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.plugins.deactivated]([plugin.deactivated.date], [plugin.deactivated.time]) [plugin.name] by [plugin.deactivated.author];[/section.plugins.deactivated]');
                                                    }

                                                }, {
                                                    text: 'Updated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.plugins.updated]([plugin.updated.date], [plugin.updated.time]) [plugin.name] by [plugin.updated.author] - [plugin.old.version] to [plugin.current.version];[/section.plugins.updated]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.plugins.deleted]([plugin.deleted.date], [plugin.deleted.time]) [plugin.name] by [plugin.deleted.author];[/section.plugins.deleted]');
                                                    }

                                                }
                                            ]

                                        },

                                        {
                                            text: 'Themes',
                                            menu: [{
                                                    text: 'Installed',
                                                    onclick: function() {
                                                        editor.insertContent('[section.themes.installed]([theme.installed.date], [theme.installed.time]) [theme.name] by [theme.installed.author];[/section.themes.installed]');
                                                    }

                                                }, {
                                                    text: 'Activated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.themes.activated]([theme.activated.date], [theme.activated.time]) [theme.name] by [theme.activated.author];[/section.themes.activated]');
                                                    }

                                                }, {
                                                    text: 'Edited',
                                                    onclick: function() {
                                                        editor.insertContent('[section.themes.edited]([theme.edited.date], [theme.edited.time]) [theme.name] by [theme.edited.author];[/section.themes.edited]');
                                                    }

                                                }, {
                                                    text: 'Updated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.themes.updated]([theme.updated.date], [theme.updated.time]) [theme.name] by [theme.updated.author] - [theme.old.version] to [theme.current.version];[/section.themes.updated]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.themes.deleted]([theme.deleted.date], [theme.deleted.time]) [theme.name] by [theme.deleted.author];[/section.themes.deleted]');
                                                    }

                                                }
                                            ]

                                        },
                                        {
                                            text: 'Posts',
                                            menu: [{
                                                    text: 'Created',
                                                    onclick: function() {
                                                        editor.insertContent('[section.posts.created]([post.created.date], [post.created.time]) [post.title] by [post.created.author];[/section.posts.created]');
                                                    }

                                                }, {
                                                    text: 'Updated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.posts.updated]([post.updated.date], [post.updated.time]) [post.title] by [post.updated.author];[/section.posts.updated]');
                                                    }

                                                }, {
                                                    text: 'Trashed',
                                                    onclick: function() {
                                                        editor.insertContent('[section.posts.trashed]([post.trashed.date], [post.trashed.time]) [post.title] by [post.trashed.author];[/section.posts.trashed]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.posts.deleted]([post.deleted.date], [post.deleted.time]) [post.title] by [post.deleted.author];[/section.posts.deleted]');
                                                    }

                                                }, {
                                                    text: 'Restored',
                                                    onclick: function() {
                                                        editor.insertContent('[section.posts.restored]([post.restored.date], [post.restored.time]) [post.title] by [post.restored.author];[/section.posts.restored]');
                                                    }

                                                }
                                            ]

                                        },
                                         {
                                            text: 'Pages',
                                            menu: [{
                                                    text: 'Created',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.created]([page.created.date], [page.created.time]) [page.title] by [page.created.author];[/section.pages.created]');
                                                    }

                                                }, {
                                                    text: 'Updated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.updated]([page.updated.date], [page.updated.time]) [page.title] by [post.page.author];[/section.page.updated]');
                                                    }

                                                }, {
                                                    text: 'Trashed',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.trashed]([page.trashed.date], [page.trashed.time]) [page.title] by [page.trashed.author];[/section.pages.trashed]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.deleted]([page.deleted.date],  [page.deleted.time]) [page.title] by [page.deleted.author];[/section.pages.deleted]');
                                                    }

                                                }, {
                                                    text: 'Restored',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.restored]([page.restored.date], [page.restored.time]) [page.title] by [page.restored.author];[/section.pages.restored]');
                                                    }

                                                }
                                            ]

                                        },
                                        {
                                            text: 'Users',
                                            menu: [{
                                                    text: 'Created',
                                                    onclick: function() {
                                                        editor.insertContent('[section.users.created]([user.created.date], [user.created.time]) [user.name] ([user.created.role]) by [user.created.author];[/section.users.created]');
                                                    }

                                                }, {
                                                    text: 'Updated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.users.updated]([user.updated.date], [user.updated.time]) [user.name] ([user.updated.role]) by [user.updated.author];[/section.users.updated]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.users.deleted]([user.deleted.date], [user.deleted.time]) [user.name] by [user.deleted.author];[/section.users.deleted]');
                                                    }

                                                }
                                            ]

                                        },
                                        {
                                            text: 'Comments',
                                            menu: [{
                                                    text: 'Created',
                                                    onclick: function() {
                                                        editor.insertContent('[section.comments.created]([comment.created.date], [comment.created.time]) [comment.title] by [comment.created.author];[/section.comments.created]');
                                                    }

                                                }, {
                                                    text: 'Trashed',
                                                    onclick: function() {
                                                        editor.insertContent('[section.comments.trashed]([comment.trashed.date], [comment.trashed.time]) [comment.title] by [comment.trashed.author];[/section.comments.trashed]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.comments.deleted]([comment.deleted.date], [comment.deleted.time]) [comment.title] by [comment.deleted.author];[/section.comments.deleted]');
                                                    }

                                                }, {
                                                    text: 'Edited',
                                                    onclick: function() {
                                                        editor.insertContent('[section.comments.edited]([comment.edited.date], [comment.edited.time]) [comment.title] by [comment.edited.author];[/section.comments.edited]');
                                                    }

                                                }, {
                                                    text: 'Restored',
                                                    onclick: function() {
                                                        editor.insertContent('[section.comments.restored]([comment.restored.date], [comment.restored.time]) [comment.title] by [comment.restored.author];[/section.comments.restored]');
                                                    }

                                                }, {
                                                    text: 'Approved',
                                                    onclick: function() {
                                                        editor.insertContent('[section.comments.approved]([comment.approved.date], [comment.approved.time]) [comment.title] by [comment.approved.author];[/section.comments.approved]');
                                                    }

                                                }, {
                                                    text: 'Spammed',
                                                    onclick: function() {
                                                        editor.insertContent('[section.comments.spam]([comment.spam.date], [comment.spam.time]) [comment.title] by [comment.spam.author];[/section.comments.spam]');
                                                    }

                                                }, {
                                                    text: 'Replied',
                                                    onclick: function() {
                                                        editor.insertContent('[section.comments.replied]([comment.replied.date], [comment.replied.time]) [comment.title] by [comment.replied.author];[/section.comments.replied]');
                                                    }

                                                }
                                            ]
                                        },
                                        {
                                            text: 'Media',
                                            menu: [{
                                                    text: 'Uploaded',
                                                    onclick: function() {
                                                        editor.insertContent('[section.media.uploaded]([media.uploaded.date], [media.uploaded.time]) [media.name] by [media.uploaded.author];[/section.media.uploaded]');
                                                    }

                                                }, {
                                                    text: 'Updated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.media.updated]([media.updated.date], [media.updated.time]) [media.name] by [media.updated.author];[/section.media.updated]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.media.deleted]([media.deleted.date], [media.deleted.time]) [media.name] by [media.deleted.author];[/section.media.deleted]');
                                                    }

                                                }
                                            ]

                                        },
                                        {
                                            text: 'Widgets',
                                            menu: [{
                                                    text: 'Added',
                                                    onclick: function() {
                                                        editor.insertContent('[section.widgets.added]([widget.added.date], [widget.added.time]) [widget.title] added in [widget.added.area] by [widget.added.author];[/section.widgets.added]');
                                                    }

                                                }, {
                                                    text: 'Updated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.widgets.updated]([widget.updated.date], [widget.updated.time]) [widget.title] in [widget.updated.area] by [widget.updated.author];[/section.widgets.updated]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.widgets.deleted]([widget.deleted.date], [widget.deleted.time]) [widget.title] in [widget.deleted.area] by [widget.deleted.author];[/section.widgets.deleted]');
                                                    }

                                                }
                                            ]

                                        },
                                        {
                                            text: 'Menus',
                                            menu: [{
                                                    text: 'Created',
                                                    onclick: function() {
                                                        editor.insertContent('[section.menus.created]([menu.added.date], [menu.added.time]) [menu.title] by [menu.added.author];[/section.menus.created]');
                                                    }

                                                }, {
                                                    text: 'Updated',
                                                    onclick: function() {
                                                        editor.insertContent('[section.menus.updated]([menu.updated.date], [menu.updated.time]) [menu.title] by [menu.updated.author];[/section.menus.updated]');
                                                    }

                                                }, {
                                                    text: 'Deleted',
                                                    onclick: function() {
                                                        editor.insertContent('[section.menus.deleted]([menu.deleted.date], [menu.deleted.time]) [menu.title] by [menu.deleted.author];[/section.menus.deleted]');
                                                    }

                                                }
                                            ]

                                        },
                                        {
                                            text: 'WordPress',
                                            menu: [{
                                                    text: 'Updates',
                                                    onclick: function() {
                                                        editor.insertContent('[section.wordpress.updated]([wordpress.updated.date], [wordpress.updated.time]) Updated by [wordpress.updated.author] - [wordpress.old.version] to [wordpress.current.version][/section.wordpress.updated]');
                                                    }

                                                }
                                            ]

                                        }


                                  ]

                                }); 
                                editor.addButton('insertreporttoken', {
                        type: 'menubutton',
                        text: 'Insert Tokens',
                        icon: false,
                        menu: [
                             {
                                text: 'Client Tokens',
                                menu: [
                                <?php                                 
                                foreach($client_tokens as $token) {
                                    ?>
                                    {
                                        text: '[<?php echo esc_html($token->token_name ); ?>] - <?php echo esc_html( $token->token_description ); ?>',
                                        onclick: function() {
                                            editor.insertContent('[<?php echo esc_html( $token->token_name ) ?>]');
                                        }  
                                    },
                                    <?php                               
                                }
                                ?>
                                ]
                            },
                            {
                                text: 'Plugins',
                                menu: [{
                                        text: 'Sections',
                                        menu: [{
                                                text: '[section.plugins.installed][/section.plugins.installed] - Loops through Plugins Installed during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.plugins.installed][/section.plugins.installed]');
                                                }
                                            }, {
                                                text: '[section.plugins.activated][/section.plugins.activated] - Loops through Plugins Activated during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.plugins.activated][/section.plugins.activated]');
                                                }
                                            }
                                            , {
                                                text: '[section.plugins.edited][/section.plugins.edited] - Loops through Plugins Edited during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.plugins.edited][/section.plugins.edited]');
                                                }
                                            }, {
                                                text: '[section.plugins.deactivated][/section.plugins.deactivated] - Loops through Plugins Deactivated during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.plugins.deactivated][/section.plugins.deactivated] ');
                                                }
                                            }, {
                                                text: '[section.plugins.updated][/section.plugins.updated] - Loops through Plugins Updated during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.plugins.updated][/section.plugins.updated] ');
                                                }
                                            }, {
                                                text: '[section.plugins.deleted][/section.plugins.deleted] - Loops through Plugins Deleted during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.plugins.deleted][/section.plugins.deleted]');
                                                }
                                            }]
                                    }, {
                                        text: 'Installed',
                                        menu: [{
                                                text: '[plugin.name] - Displays the Plugin Name',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.name]');
                                                }
                                            }, {
                                                text: '[plugin.installed.date] - Displays the Plugin Installation Date',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.installed.date]');
                                                }
                                            }, {
                                                text: '[plugin.installed.author] - Displays the User who Installed the Plugin',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.installed.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Activated',
                                        menu: [{
                                                text: '[plugin.name] - Displays the Plugin Name',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.name]');
                                                }
                                            }, {
                                                text: '[plugin.activated.date] - Displays the Plugin Activation Date',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.activated.date]');
                                                }
                                            }, {
                                                text: '[plugin.activated.author] - Displays the User who Activated the Plugin',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.activated.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Edited',
                                        menu: [{
                                                text: '[plugin.name] - Displays the Plugin Name',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.name]');
                                                }
                                            }, {
                                                text: '[plugin.edited.date] - Displays the Plugin Editing Date',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.edited.date]');
                                                }
                                            }, {
                                                text: '[plugin.edited.author] - Displays the User who Edited the Plugin',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.edited.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Deactivated',
                                        menu: [{
                                                text: '[plugin.name] - Displays the Plugin Name',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.name]');
                                                }
                                            }, {
                                                text: '[plugin.deactivated.date] - Displays the Plugin Deactivation Date',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.deactivated.date]');
                                                }
                                            }, {
                                                text: '[plugin.deactivated.author] - Displays the User who Deactivated the Plugin',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.deactivated.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Updated',
                                        menu: [{
                                                text: '[plugin.name] - Displays the Plugin Name',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.name]');
                                                }
                                            }, {
                                                text: '[plugin.updated.date] - Displays the Plugin Update Date',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.updated.date]');
                                                }
                                            }, {
                                                text: '[plugin.updated.author] - Displays the User who Updated the Plugin',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.updated.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Deleted',
                                        menu: [{
                                                text: '[plugin.name] - Displays the Plugin Name',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.name]');
                                                }
                                            }, {
                                                text: '[plugin.deleted.date] - Displays the Plugin Deliting Date',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.deleted.date]');
                                                }
                                            }, {
                                                text: '[plugin.deleted.author] - Displays the User who Deleted the Plugin',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.deleted.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Additional',
                                        menu: [{
                                                text: '[plugin.old.version] - Displays the Plugin Version Before Update',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.old.version]');
                                                }
                                            }, {
                                                text: '[plugin.current.version] - Displays the Plugin Current Vesion',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.current.version]');
                                                }
                                            }
                                            , {
                                                text: '[plugin.installed.count] - Displays the Number of Installed Plugins',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.installed.count]');
                                                }
                                            }, {
                                                text: '[plugin.edited.count] - Displays the Number of Edited Plugins',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.edited.count]');
                                                }
                                            }, {
                                                text: '[plugin.activated.count] - Displays the Number of Activated Plugins',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.activated.count]');
                                                }
                                            }, {
                                                text: '[plugin.deactivated.count] - Displays the Number of Deactivated Plugins',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.deactivated.count]');
                                                }
                                            }, {
                                                text: '[plugin.deleted.count] - Displays the Number of Deleted Plugins',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.deleted.count]');
                                                }
                                            }, {
                                                text: '[plugin.updated .count] - Displays the Number of Updated Plugins',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.updated.count]');
                                                }
                                            }]
                                    }]
                            },                            
                            {
                                text: 'Themes',
                                menu: [{
                                        text: 'Sections',
                                        menu: [{
                                                text: '[section.themes.installed][/section.themes.installed] - Loops through Themes Installed during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.themes.installed][/section.themes.installed]');
                                                }
                                            }, {
                                                text: '[section.themes.activated][/section.plugins.activated] - Loops through Themes Activated during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.themes.activated][/section.themes.activated]');
                                                }
                                            }
                                            , {
                                                text: '[section.themes.edited][/section.themes.edited] - Loops through Themes Edited during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.themes.edited][/section.themes.edited]');
                                                }
                                            }, {
                                                text: '[section.themes.updated][/section.themes.updated] - Loops through Themes Updated during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.themes.updated][/section.themes.updated] ');
                                                }
                                            }, {
                                                text: '[section.themes.deleted][/section.themes.deleted] - Loops through Themes Deleted during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.themes.deleted][/section.themes.deleted]');
                                                }
                                            }]
                                    }, {
                                        text: 'Installed',
                                        menu: [{
                                                text: '[theme.name] - Displays the Theme Name',
                                                onclick: function() {
                                                    editor.insertContent('[theme.name]');
                                                }
                                            }, {
                                                text: '[theme.installed.date] - Displays the Theme Installation Date',
                                                onclick: function() {
                                                    editor.insertContent('[theme.installed.date]');
                                                }
                                            }, {
                                                text: '[theme.installed.author] - Displays the User who Installed the Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.installed.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Activated',
                                        menu: [{
                                                text: '[theme.name] - Displays the Theme Name',
                                                onclick: function() {
                                                    editor.insertContent('[theme.name]');
                                                }
                                            }, {
                                                text: '[theme.activated.date] - Displays the Theme Activation Date',
                                                onclick: function() {
                                                    editor.insertContent('[theme.activated.date]');
                                                }
                                            }, {
                                                text: '[theme.activated.author] - Displays the User who Activated the Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.activated.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Edited',
                                        menu: [{
                                                text: '[theme.name] - Displays the Theme Name',
                                                onclick: function() {
                                                    editor.insertContent('[plugin.name]');
                                                }
                                            }, {
                                                text: '[theme.edited.date] - Displays the Theme Editing Date',
                                                onclick: function() {
                                                    editor.insertContent('[theme.edited.date]');
                                                }
                                            }, {
                                                text: '[theme.edited.author] - Displays the User who Edited the Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.edited.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Updated',
                                        menu: [{
                                                text: '[theme.name] - Displays the Theme Name',
                                                onclick: function() {
                                                    editor.insertContent('[theme.name]');
                                                }
                                            }, {
                                                text: '[theme.updated.date] - Displays the Theme Update Date',
                                                onclick: function() {
                                                    editor.insertContent('[theme.updated.date]');
                                                }
                                            }, {
                                                text: '[theme.updated.author] - Displays the User who Updated the Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.updated.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Deleted',
                                        menu: [{
                                                text: '[theme.name] - Displays the Theme Name',
                                                onclick: function() {
                                                    editor.insertContent('[theme.name]');
                                                }
                                            }, {
                                                text: '[theme.deleted.date] - Displays the Theme Deliting Date',
                                                onclick: function() {
                                                    editor.insertContent('[theme.deleted.date]');
                                                }
                                            }, {
                                                text: '[theme.deleted.author] - Displays the User who Deleted the Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.deleted.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Additional',
                                        menu: [{
                                                text: '[theme.old.version] - Displays the Theme Version Before Update',
                                                onclick: function() {
                                                    editor.insertContent('[theme.old.version]');
                                                }
                                            }, {
                                                text: '[theme.current.version] - Displays the Theme Current Vesion',
                                                onclick: function() {
                                                    editor.insertContent('[theme.current.version]');
                                                }
                                            }
                                            , {
                                                text: '[theme.installed.count] - Displays the Number of Installed Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.installed.count]');
                                                }
                                            }, {
                                                text: '[theme.edited.count] - Displays the Number of Edited Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.edited.count]');
                                                }
                                            }, {
                                                text: '[theme.activated.count] - Displays the Number of Activated Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.activated.count]');
                                                }
                                            }, {
                                                text: '[theme.deleted.count] - Displays the Number of Deleted Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.deleted.count]');
                                                }
                                            }, {
                                                text: '[theme.updated.count] - Displays the Number of Updated Theme',
                                                onclick: function() {
                                                    editor.insertContent('[theme.updated.count]');
                                                }
                                            }]
                                    }]
                            },                            
                            {
                                text: 'Posts',
                                menu: [{
                                        text: 'Sections',
                                        menu: [{
                                                text: '[section.posts.created][/section.posts.created] - Loops through Posts Created during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.posts.created][/section.posts.created]');
                                                }
                                            }, {
                                                text: '[section.posts.updated][/section.posts.updated] - Loops through Posts Updated during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.posts.updated][/section.posts.updated]');
                                                }
                                            }
                                            , {
                                                text: '[section.posts.trashed][/section.posts.trashed] - Loops through Posts Trashed during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.posts.trashed][/section.posts.trashed]');
                                                }
                                            }, {
                                                text: '[section.posts.deleted][/section.posts.deleted] - Loops through Posts Deleted during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.posts.deleted][/section.posts.deleted] ');
                                                }
                                            }, {
                                                text: '[section.posts.restored][/section.posts.restored] - Loops through Posts Restored during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.posts.restored][/section.posts.restored]');
                                                }
                                            }]
                                    }, {
                                        text: 'Created',
                                        menu: [{
                                                text: '[post.title] - Displays the Post Title',
                                                onclick: function() {
                                                    editor.insertContent('[post.title]');
                                                }
                                            }, {
                                                text: '[post.created.date] - Displays the Post Createion Date',
                                                onclick: function() {
                                                    editor.insertContent('[post.created.date]');
                                                }
                                            }, {
                                                text: '[post.created.author] - Displays the User who Created the Post',
                                                onclick: function() {
                                                    editor.insertContent('[post.created.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Updated',
                                        menu: [{
                                                text: '[post.title] - Displays the Post Title',
                                                onclick: function() {
                                                    editor.insertContent('[post.title]');
                                                }
                                            }, {
                                                text: '[post.updated.date] - Displays the Post Update Date',
                                                onclick: function() {
                                                    editor.insertContent('[post.updated.date]');
                                                }
                                            }, {
                                                text: '[post.updated.author] - Displays the User who Updated the Post',
                                                onclick: function() {
                                                    editor.insertContent('[post.updated.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Trashed',
                                        menu: [{
                                                text: '[post.title] - Displays the Post Title',
                                                onclick: function() {
                                                    editor.insertContent('[post.title]');
                                                }
                                            }, {
                                                text: '[post.trashed.date] - Displays the Post Trashing Date',
                                                onclick: function() {
                                                    editor.insertContent('[post.trashed.date]');
                                                }
                                            }, {
                                                text: '[post.trashed.author] - Displays the User who Trashed the Post',
                                                onclick: function() {
                                                    editor.insertContent('[post.trashed.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Deleted',
                                        menu: [{
                                                text: '[post.title] - Displays the Post Title',
                                                onclick: function() {
                                                    editor.insertContent('[post.title]');
                                                }
                                            }, {
                                                text: '[post.deleted.date] - Displays the Post Deleting Date',
                                                onclick: function() {
                                                    editor.insertContent('[post.deleted.date]');
                                                }
                                            }, {
                                                text: '[post.deleted.author] - Displays the User who Deleted the Post',
                                                onclick: function() {
                                                    editor.insertContent('[post.deleted.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Restored',
                                        menu: [{
                                                text: '[post.title] - Displays Post Title',
                                                onclick: function() {
                                                    editor.insertContent('[post.title]');
                                                }
                                            }, {
                                                text: '[post.restored.date] - Displays the Post Restoring Date',
                                                onclick: function() {
                                                    editor.insertContent('[post.restored.date]');
                                                }
                                            }, {
                                                text: '[post.restored.author] - Displays the User who Restored the Post',
                                                onclick: function() {
                                                    editor.insertContent('[post.restored.author]');
                                                }
                                            }]
                                    }, {
                                        text: 'Additional',
                                        menu: [{
                                                text: '[post.created.count] - Displays the Number of Created Posts',
                                                onclick: function() {
                                                    editor.insertContent('[post.created.count]');
                                                }
                                            }, {
                                                text: '[post.updated.count] - Displays the Number of Updated Posts',
                                                onclick: function() {
                                                    editor.insertContent('[post.updated.count]');
                                                }
                                            }
                                            , {
                                                text: '[post.trashed.count] - Displays the Number of Trashed Posts',
                                                onclick: function() {
                                                    editor.insertContent('[post.trashed.count]');
                                                }
                                            }, {
                                                text: '[post.restored.count] - Displays the Number of Restored Posts',
                                                onclick: function() {
                                                    editor.insertContent('[post.restored.count]');
                                                }
                                            }, {
                                                text: '[post.deleted.count] - Displays the Number of Deleted Posts',
                                                onclick: function() {
                                                    editor.insertContent('[post.deleted.count]');
                                                }
                                            }]
                                    }]
                            },
                            {
                                    text: 'Pages',
                                    menu: [{
                                            text: 'Sections',
                                            menu: [{
                                                    text: '[section.pages.created][/section.pages.created] - Loops through Pages  Created during the selected date range',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.created][/section.pages.created]');
                                                    }
                                                }, {
                                                    text: '[section.pages.updated][/section.pages.updated] - Loops through Pages  Updated during the selected date range',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.updated][/section.pages.updated]');
                                                    }
                                                }
                                                , {
                                                    text: '[section.pages.trashed][/section.pages.trashed] - Loops through Pages  Trashed during the selected date range',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.trashed][/section.pages.trashed]');
                                                    }
                                                }, {
                                                    text: '[section.pages.deleted][/section.pages.deleted] - Loops through Pages  Deleted during the selected date range',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.deleted][/section.pages.deleted] ');
                                                    }
                                                }, {
                                                    text: '[section.pages.restored][/section.pages.restored] - Loops through Pages  Restored during the selected date range',
                                                    onclick: function() {
                                                        editor.insertContent('[section.pages.restored][/section.pages.restored]');
                                                    }
                                                }]
                                        }, {
                                            text: 'Created',
                                            menu: [{
                                                    text: '[page.title] - Displays the Page Title',
                                                    onclick: function() {
                                                        editor.insertContent('[page.title]');
                                                    }
                                                }, {
                                                    text: '[page.created.date] - Displays the Page Createion Date',
                                                    onclick: function() {
                                                        editor.insertContent('[page.created.date]');
                                                    }
                                                }, {
                                                    text: '[page.created.author] - Displays the User who Created the Page',
                                                    onclick: function() {
                                                        editor.insertContent('[page.created.author]');
                                                    }
                                                }]
                                        }, {
                                            text: 'Updated',
                                            menu: [{
                                                    text: '[page.title] - Displays the Page Title',
                                                    onclick: function() {
                                                        editor.insertContent('[page.title]');
                                                    }
                                                }, {
                                                    text: '[page.updated.date] - Displays the Page Update Date',
                                                    onclick: function() {
                                                        editor.insertContent('[page.updated.date]');
                                                    }
                                                }, {
                                                    text: '[page.updated.author] - Displays the User who Updated the Page',
                                                    onclick: function() {
                                                        editor.insertContent('[page.updated.author]');
                                                    }
                                                }]
                                        }, {
                                            text: 'Trashed',
                                            menu: [{
                                                    text: '[page.title] - Displays the Page Title',
                                                    onclick: function() {
                                                        editor.insertContent('[page.title]');
                                                    }
                                                }, {
                                                    text: '[page.trashed.date] - Displays the Page Trashing Date',
                                                    onclick: function() {
                                                        editor.insertContent('[page.trashed.date]');
                                                    }
                                                }, {
                                                    text: '[page.trashed.author] - Displays the User who Trashed the Page',
                                                    onclick: function() {
                                                        editor.insertContent('[page.trashed.author]');
                                                    }
                                                }]
                                        }, {
                                            text: 'Deleted',
                                            menu: [{
                                                    text: '[page.title] - Displays the Page Title',
                                                    onclick: function() {
                                                        editor.insertContent('[page.title]');
                                                    }
                                                }, {
                                                    text: '[page.deleted.date] - Displays the Page Deleting Date',
                                                    onclick: function() {
                                                        editor.insertContent('[page.deleted.date]');
                                                    }
                                                }, {
                                                    text: '[page.deleted.author] - Displays the User who Deleted the Page',
                                                    onclick: function() {
                                                        editor.insertContent('[page.deleted.author]');
                                                    }
                                                }]
                                        }, {
                                            text: 'Restored',
                                            menu: [{
                                                    text: '[page.title] - Displays Page Title',
                                                    onclick: function() {
                                                        editor.insertContent('[page.title]');
                                                    }
                                                }, {
                                                    text: '[page.restored.date] - Displays the Page Restoring Date',
                                                    onclick: function() {
                                                        editor.insertContent('[page.restored.date]');
                                                    }
                                                }, {
                                                    text: '[page.restored.author] - Displays the User who Restored the Page',
                                                    onclick: function() {
                                                        editor.insertContent('[page.restored.author]');
                                                    }
                                                }]
                                        }, {
                                            text: 'Additional',
                                            menu: [{
                                                    text: '[page.created.count] - Displays the Number of Created Pages',
                                                    onclick: function() {
                                                        editor.insertContent('[page.created.count]');
                                                    }
                                                }, {
                                                    text: '[page.updated.count] - Displays the Number of Updated Pages',
                                                    onclick: function() {
                                                        editor.insertContent('[page.updated.count]');
                                                    }
                                                }
                                                , {
                                                    text: '[page.trashed.count] - Displays the Number of Trashed Pages',
                                                    onclick: function() {
                                                        editor.insertContent('[page.trashed.count]');
                                                    }
                                                }, {
                                                    text: '[page.restored.count] - Displays the Number of Restored Pages',
                                                    onclick: function() {
                                                        editor.insertContent('[page.restored.count]');
                                                    }
                                                }, {
                                                    text: '[page.deleted.count] - Displays the Number of Deleted Pages',
                                                    onclick: function() {
                                                        editor.insertContent('[page.deleted.count]');
                                                    }
                                                }]
                                        }]
                                },
                                {
                                        text: 'Comments',
                                        menu: [{
                                                text: 'Sections',
                                                menu: [{
                                                        text: '[section.comments.created][/section.comments.created] - Loops through Comments Created during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.comments.created][/section.comments.created]');
                                                        }
                                                    }, {
                                                        text: '[section.comments.updated][/section.comments.updated] - Loops through Comments Updated during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.comments.updated][/section.comments.updated]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[section.comments.trashed][/section.comments.trashed] - Loops through Comments Trashed during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.comments.trashed][/section.comments.trashed]');
                                                        }
                                                    }, {
                                                        text: '[section.comments.deleted][/section.comments.deleted] - Loops through Comments Deleted during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.comments.deleted][/section.comments.deleted]');
                                                        }
                                                    }, {
                                                        text: '[section.comments.edited][/section.comments.edited] - Loops through Comments Edited during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.comments.edited][/section.comments.edited]');
                                                        }
                                                    }, {
                                                        text: '[section.comments.restored][/section.comments.restored] - Loops through Comments Restored during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.comments.restored][/section.comments.restored]');
                                                        }
                                                    }, {
                                                        text: '[section.comments.approved][/section.comments.approved] - Loops through Comments Approved during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('section.comments.approved][/section.comments.approved]');
                                                        }
                                                    }, {
                                                        text: '[section.comments.spam][/section.comments.spam] - Loops through Comments Spammed during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.comments.spam][/section.comments.spam]');
                                                        }
                                                    }, {
                                                        text: '[section.comments.replied][/section.comments.replied] - Loops through Comments Replied during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.comments.replied][/section.comments.replied]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Created',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Created',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.created.date] - Displays the Comment Creating Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.created.date]');
                                                        }
                                                    }, {
                                                        text: '[comment.created.author] - Displays the User who Created the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.created.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Updated',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Updated',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.updated.date] - Displays the Comment Updating Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.updated.date]');
                                                        }
                                                    }, {
                                                        text: '[comment.updated.author] - Displays the User who Updated the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.updated.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Trashed ',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Trashed',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.trashed.date] - Displays the Comment Trashing Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.trashed.date]');
                                                        }
                                                    }, {
                                                        text: '[comment.trashed.author] - Displays the User who Trashed the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.trashed.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Deleted',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Deleted',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.deleted.date] - Displays the Comment Deleting Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.deleted.date]');
                                                        }
                                                    }, {
                                                        text: '[comment.deleted.author] - Displays the User who Deleted the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.deleted.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Edited',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Edited',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.edited.date] - Displays the Comment Editing Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.edited.date]');
                                                        }
                                                    }, {
                                                        text: '[comment.edited.author] - Displays the User who Edited the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.edited.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Restored',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Restored',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.restored.date] - Displays the Comment Restoring Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.restored.date]');
                                                        }
                                                    }, {
                                                        text: '[comment.restored.author] - Displays the User who Restored the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.restored.author]');
                                                        }
                                                    }]
                                            }
                                            , {
                                                text: 'Approved',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Approved',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.approved.date] - Displays the Comment Approving Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.approved.date]');
                                                        }
                                                    }, {
                                                        text: ' [comment.approved.author] - Displays the User who Approved the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.approved.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Spam',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Spammed',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.spam.date] - Displays the Comment Spamming Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.spam.date]');
                                                        }
                                                    }, {
                                                        text: '[comment.spam.author] - Displays the User who Spammed the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.spam.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Replied',
                                                menu: [{
                                                        text: '[comment.title] - Displays the Title of the Post or the Page where the Comment is Replied',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.title]');
                                                        }
                                                    }, {
                                                        text: '[comment.replied.date] - Displays the Comment Replying Date',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.replied.date]');
                                                        }
                                                    }, {
                                                        text: '[comment.replied.author] - Displays the User who Replied the Comment',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.replied.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Additional',
                                                menu: [{
                                                        text: '[comment.created.count] - Displays the Number of Created Comments',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.created.count]');
                                                        }
                                                    }, {
                                                        text: '[comment.trashed.count] - Displays the Number of Trashed Comments',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.trashed.count]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[comment.deleted.count] - Displays the Number of Deleted Comments',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.deleted.count]');
                                                        }
                                                    }, {
                                                        text: '[comment.edited.count] - Displays the Number of Edited Comments',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.edited.count]');
                                                        }
                                                    }, {
                                                        text: '[comment.restored.count] - Displays the Number of Restored Comments',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.restored.count]');
                                                        }
                                                    }, {
                                                        text: '[comment.approved.count] - Displays the Number of Approved Comments',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.approved.count]');
                                                        }
                                                    }, {
                                                        text: '[comment.spam.count] - Displays the Number of Spammed Comments',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.spam.count]');
                                                        }
                                                    }, {
                                                        text: '[comment.replied.count] - Displays the Number of Replied Comments',
                                                        onclick: function() {
                                                            editor.insertContent('[comment.replied.count]');
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        text: 'Users',
                                        menu: [{
                                                text: 'Sections',
                                                menu: [{
                                                        text: '[section.users.created][/section.users.created] - Loops through Users  Created during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.users.created][/section.users.created]');
                                                        }
                                                    }, {
                                                        text: '[section.users.updated][/section.users.updated] - Loops through Users  Updated during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.users.updated][/section.users.updated]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[section.users.deleted][/section.users.deleted] - Loops through Users  Deleted during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.users.deleted][/section.users.deleted] ');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Created',
                                                menu: [{
                                                        text: '[user.name] - Displays the User Name',
                                                        onclick: function() {
                                                            editor.insertContent('[user.name]');
                                                        }
                                                    }, {
                                                        text: '[user.created.date] - Displays the User Creation Date',
                                                        onclick: function() {
                                                            editor.insertContent('[user.created.date]');
                                                        }
                                                    }, {
                                                        text: '[user.created.author] - Displays the User who Created the new User',
                                                        onclick: function() {
                                                            editor.insertContent('[user.created.author]');
                                                        }
                                                    }, {
                                                        text: '[user.created.role] - Displays the Role of the Created User',
                                                        onclick: function() {
                                                            editor.insertContent('[user.created.role');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Updated',
                                                menu: [{
                                                        text: '[user.name] - Displays the User Name',
                                                        onclick: function() {
                                                            editor.insertContent('[user.name]');
                                                        }
                                                    }, {
                                                        text: '[user.updated.date] - Displays the User Updating Date',
                                                        onclick: function() {
                                                            editor.insertContent('[user.updated.date]');
                                                        }
                                                    }, {
                                                        text: '[user.updated.author] - Displays the User who Updated the new User',
                                                        onclick: function() {
                                                            editor.insertContent('[user.updated.author]');
                                                        }
                                                    }, {
                                                        text: '[user.updated.role] - Displays the Role of the Updated User',
                                                        onclick: function() {
                                                            editor.insertContent('[user.updated.role]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Deleted',
                                                menu: [{
                                                        text: '[user.name] - Displays the User Name',
                                                        onclick: function() {
                                                            editor.insertContent('[user.name]');
                                                        }
                                                    }, {
                                                        text: '[user.deleted.date] - Displays the User Deleting Date',
                                                        onclick: function() {
                                                            editor.insertContent('[user.deleted.date]');
                                                        }
                                                    }, {
                                                        text: '[user.deleted.author] - Displays the User who Deleted the new User',
                                                        onclick: function() {
                                                            editor.insertContent('[user.deleted.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Additional',
                                                menu: [{
                                                        text: '[user.created.count] - Displays the Number of Created Users',
                                                        onclick: function() {
                                                            editor.insertContent('[page.created.count]');
                                                        }
                                                    }, {
                                                        text: '[user.updated.count] - Displays the Number of Updated Users',
                                                        onclick: function() {
                                                            editor.insertContent('[user.updated.count]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[user.deleted.count] - Displays the Number of Deleted Users',
                                                        onclick: function() {
                                                            editor.insertContent('[user.deleted.count]');
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        text: 'Media',
                                        menu: [{
                                                text: 'Sections',
                                                menu: [{
                                                        text: '[section.media.uploaded][/section.media.uploaded] - Loops through Media  Uploaded during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.media.uploaded][/section.media.uploaded]');
                                                        }
                                                    }, {
                                                        text: '[section.media.updated][/section.media.updated] - Loops through Media  Updated during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.media.updated][/section.media.updated]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[section.media.deleted][/section.media.deleted] - Loops through Media  Deleted during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.media.deleted][/section.media.deleted] ');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Uploaded',
                                                menu: [{
                                                        text: '[media.name] - Displays the Media Name',
                                                        onclick: function() {
                                                            editor.insertContent('[user.name]');
                                                        }
                                                    }, {
                                                        text: '[media.uploaded.date] - Displays the Media Uploading Date',
                                                        onclick: function() {
                                                            editor.insertContent('[media.uploaded.date]');
                                                        }
                                                    }, {
                                                        text: '[media.uploaded.author] - Displays the User who Uploaded the Media File',
                                                        onclick: function() {
                                                            editor.insertContent('[media.uploaded.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Updated',
                                                menu: [{
                                                        text: '[media.name] - Displays the Media Name',
                                                        onclick: function() {
                                                            editor.insertContent('[media.name]');
                                                        }
                                                    }, {
                                                        text: '[media.updated.date] - Displays the Media Updating Date',
                                                        onclick: function() {
                                                            editor.insertContent('[media.updated.date]');
                                                        }
                                                    }, {
                                                        text: '[media.updated.author] - Displays the User who Updated the Media File',
                                                        onclick: function() {
                                                            editor.insertContent('[media.updated.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Deleted',
                                                menu: [{
                                                        text: '[media.name] - Displays the Media Name',
                                                        onclick: function() {
                                                            editor.insertContent('[media.name]');
                                                        }
                                                    }, {
                                                        text: '[media.deleted.date] - Displays the Media Deleting Date',
                                                        onclick: function() {
                                                            editor.insertContent('[media.deleted.date]');
                                                        }
                                                    }, {
                                                        text: '[media.deleted.author] - Displays the User who Deleted the Media File',
                                                        onclick: function() {
                                                            editor.insertContent('[media.deleted.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Additional',
                                                menu: [{
                                                        text: '[media.uploaded.count] -  Displays the Number of Uploaded Media Files',
                                                        onclick: function() {
                                                            editor.insertContent('[media.updated.count]');
                                                        }
                                                    }, {
                                                        text: '[media.updated.count] - Displays the Number of Updated Media Files',
                                                        onclick: function() {
                                                            editor.insertContent('[media.updated.count]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[media.deleted.count] - Displays the Number of Deleted Media Files',
                                                        onclick: function() {
                                                            editor.insertContent('[media.deleted.count]');
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        text: 'Widgets',
                                        menu: [{
                                                text: 'Sections',
                                                menu: [{
                                                        text: '[section.widgets.added][/section.widgets.added] - Loops through Widgets Added during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.widgets.added][/section.widgets.added]');
                                                        }
                                                    }, {
                                                        text: '[section.widgets.updated][/section.widgets.updated] - Loops through Widgets  Updated during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.widgets.updated][/section.widgets.updated]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[section.widgets.deleted][/section.widgets.deleted] - Loops through Widgets  Deleted during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.widgets.deleted][/section.widgets.deleted] ');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Added',
                                                menu: [{
                                                        text: '[widget.title] - Displays the Widget Title',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.title]');
                                                        }
                                                    }, {
                                                        text: '[widget.added.area] - Displays the Widget Adding Area',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.added.area]');
                                                        }
                                                    }, {
                                                        text: '[widget.added.date] - Displays the Widget Adding Date',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.added.date]');
                                                        }
                                                    } ,{
                                                        text: '[widget.added.time] - Displays the Widget Adding Time',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.added.time]');
                                                        }
                                                    }, {
                                                        text: '[widget.added.author] - Displays the User who Added the Widget',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.added.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Updated',
                                                menu: [{
                                                        text: '[widget.title] - Displays the Widget Name',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.title]');
                                                        }
                                                    }, {
                                                        text: '[widget.updated.area] - Displays the Widget Updating Area',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.updated.area]');
                                                        }
                                                    }, {
                                                        text: '[widget.updated.date] - Displays the Widget Updating Date',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.updated.date]');
                                                        }
                                                    },{
                                                        text: '[widget.updated.time] - Displays the Widget Updating Time',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.updated.time]');
                                                        }
                                                    }, {
                                                        text: '[widget.updated.author] - Displays the User who Updated the Widget',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.updated.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Deleted',
                                                menu: [{
                                                        text: '[widget.title] - Displays the Widget Name',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.title]');
                                                        }
                                                    }, {
                                                        text: '[widget.deleted.area] - Displays the Widget Deleting Area',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.deleted.area]');
                                                        }
                                                    }, {
                                                        text: '[widget.deleted.date] - Displays the Widget Deleting Date',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.deleted.date]');
                                                        }
                                                    },{
                                                        text: '[widget.deleted.time] - Displays the Widget Deleting Time',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.deleted.time]');
                                                        }
                                                    }, {
                                                        text: '[widget.deleted.author] - Displays the User who Deleted the Widget',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.deleted.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Additional',
                                                menu: [{
                                                        text: '[widget.added.count]  -  Displays the Number of Added Widgets',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.added.count]');
                                                        }
                                                    }, {
                                                        text: '[widget.updated.count]  -  Displays the Number of Updated Widgets',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.updated.count]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[widget.deleted.count]  -  Displays the Number of Deleted Widgets',
                                                        onclick: function() {
                                                            editor.insertContent('[widget.deleted.count]');
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        text: 'Menus',
                                        menu: [{
                                                text: 'Sections',
                                                menu: [{
                                                        text: '[section.menus.created][/section.menus.created] - Loops through Menus  Created during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.menus.created][/section.menus.created]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[section.pages.trashed][/section.pages.trashed] - Loops through Menus  Trashed during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.pages.trashed][/section.pages.trashed]');
                                                        }
                                                    }, {
                                                        text: '[section.menus.deleted][/section.menus.deleted] - Loops through Menus  Deleted during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.menus.deleted][/section.menus.deleted] ');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Created',
                                                menu: [{
                                                        text: '[menus.title] - Displays the Menu Name',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.title]');
                                                        }
                                                    }, {
                                                        text: '[menus.created.date] - Displays the Menu Creation Date',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.created.date]');
                                                        }
                                                    }, {
                                                        text: '[menus.created.time] - Displays the Menu Creation Time',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.created.time]');
                                                        }
                                                    }, {
                                                        text: '[menus.created.author] - Displays the User who Created the Menu ',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.created.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Updated',
                                                menu: [{
                                                        text: '[menus.title] - Displays the Menu Name',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.title]');
                                                        }
                                                    }, {
                                                        text: '[menus.updated.date] - Displays the Menu Updating Date',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.updated.date]');
                                                        }
                                                    },{
                                                        text: '[menus.updated.time] - Displays the Menu Updating Time',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.updated.time]');
                                                        }
                                                    }, {
                                                        text: '[menus.updated.author] - Displays the User who Updated the Menu',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.updated.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Deleted',
                                                menu: [{
                                                        text: '[menus.title] - Displays the Menu Name',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.title]');
                                                        }
                                                    }, {
                                                        text: '[menus.deleted.date] - Displays the Menu Deleting Date',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.deleted.date]');
                                                        }
                                                    },{
                                                        text: '[menus.deleted.time] - Displays the Menu Deleting Time',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.deleted.time]');
                                                        }
                                                    }, {
                                                        text: '[menus.deleted.author] - Displays the User who Deleted the Menu',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.deleted.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Additional',
                                                menu: [{
                                                        text: '[menus.created.count] - Displays the Number of Created Menus',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.created.count]');
                                                        }
                                                    }, {
                                                        text: '[menus.updated.count] - Displays the Number of Updated Menus',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.updated.count]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[menus.deleted.count] - Displays the Number of Deleted Menus',
                                                        onclick: function() {
                                                            editor.insertContent('[menus.deleted.count]');
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        text: 'WordPress',
                                        menu: [{
                                                text: 'Sections',
                                                menu: [{
                                                        text: '[section.wordpress.updated][/section.wordpress.updated] - Loops through WordPress Updates during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.wordpress.updated][/section.wordpress.updated]');
                                                        }

                                                    }]
                                            }, {
                                                text: 'Updated',
                                                menu: [{
                                                        text: '[wordpress.updated.date] - Displays the WordPress Update Date',
                                                        onclick: function() {
                                                            editor.insertContent('[wordpress.updated.date]');
                                                        }
                                                    },{
                                                        text: '[wordpress.updated.time] - Displays the WordPress Update Time',
                                                        onclick: function() {
                                                            editor.insertContent('[wordpress.updated.time]');
                                                        }
                                                    }, {
                                                        text: '[wordpress.updated.author] - Displays the User who Updated the Site',
                                                        onclick: function() {
                                                            editor.insertContent('[wordpress.updated.author]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Additional',
                                                menu: [{
                                                        text: '[wordpress.old.version] - Displays the WordPress Version Before Update',
                                                        onclick: function() {
                                                            editor.insertContent('[wordpress.old.version]');
                                                        }
                                                    }, {
                                                        text: '[wordpress.current.version] - Displays the Current WordPress Version',
                                                        onclick: function() {
                                                            editor.insertContent('[wordpress.current.version]');
                                                        }
                                                    }
                                                    , {
                                                        text: '[wordpress.updated.count] - Displays the Number of WordPress Updates',
                                                        onclick: function() {
                                                            editor.insertContent('[wordpress.updated.count]');
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        text: 'Backups',
                                        menu: [{
                                                text: 'Sections',
                                                menu: [{
                                                        text: '[section.backups.created][/section.backups.created] - Loops through Backups Created during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.backups.created][/section.backups.created]');
                                                        }

                                                    }]
                                            }, {
                                                text: 'Created',
                                                menu: [{
                                                        text: '[backup.created.type] - Displays the Created Backup type (Full or Database)',
                                                        onclick: function() {
                                                            editor.insertContent('[backup.created.type]');
                                                        }
                                                    }, {
                                                        text: '[backup.created.date] - Displays the Backups Creation date',
                                                        onclick: function() {
                                                            editor.insertContent('[backup.created.date] ');
                                                        }
                                                    }, {
                                                        text: '[backup.created.time] - Displays the Backups Creation time',
                                                        onclick: function() {
                                                            editor.insertContent('[backup.created.time] ');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Additional',
                                                menu: [{
                                                        text: '[backup.created.count] - Displays the number of created backups during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[backup.created.count]');
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        text: 'Sucuri (Security Checks)',
                                        menu: [{
                                                text: 'Sections',
                                                menu: [{
                                                        text: '[section.sucuri.checks][/section.sucuri.checks] - Loops through Security Checks during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[section.sucuri.checks][/section.sucuri.checks]');
                                                        }

                                                    }]
                                            }, {
                                                text: 'Checks',
                                                menu: [{
                                                        text: '[sucuri.check.date] - Displays the Security Check date',
                                                        onclick: function() {
                                                            editor.insertContent('[sucuri.check.date]');
                                                        }
                                                    },{
                                                        text: '[sucuri.check.time] - Displays the Security Check time',
                                                        onclick: function() {
                                                            editor.insertContent('[sucuri.check.time]');
                                                        }
                                                    }, {
                                                        text: '[sucuri.check.status] - Displays the Status info for the Child Site',
                                                        onclick: function() {
                                                            editor.insertContent('[sucuri.check.status]');
                                                        }
                                                    }, {
                                                        text: '[sucuri.check.webtrust] - Displays the Webtrust info for the Child Site',
                                                        onclick: function() {
                                                            editor.insertContent('[sucuri.check.webtrust]');
                                                        }
                                                    }]
                                            }, {
                                                text: 'Additional',
                                                menu: [{
                                                        text: '[sucuri.checks.count]  - Displays the number of performed security checks during the selected date range',
                                                        onclick: function() {
                                                            editor.insertContent('[sucuri.checks.count] ');
                                                        }
                                                    }]
                                            }]
                                    },
                                    {
                                        text: 'Client Tokens',
                                        menu: [{
                                                text: '[client.city] - Displays the Client City',
                                                onclick: function() {
                                                    editor.insertContent('[client.city]');
                                                }


                                            }, {
                                                text: '[client.company] - Displays the Client Company',
                                                onclick: function() {
                                                    editor.insertContent('[client.company]');
                                                }


                                            }, {
                                                text: '[client.contact.address.1] - Displays the Client Contact Address 1',
                                                onclick: function() {
                                                    editor.insertContent('[client.contact.address.1]');
                                                }


                                            }, {
                                                text: '[client.contact.address.2] - Displays the Client Contact Address 2',
                                                onclick: function() {
                                                    editor.insertContent('[client.contact.address.2]');
                                                }


                                            }, {
                                                text: '[client.contact.name] - Displays the Client Contact Name',
                                                onclick: function() {
                                                    editor.insertContent('[client.contact.name]');
                                                }


                                            }, {
                                                text: '[client.email] - Displays the Client Email',
                                                onclick: function() {
                                                    editor.insertContent('[client.email]');
                                                }


                                            }, {
                                                text: '[client.name] - Displays the Client Name',
                                                onclick: function() {
                                                    editor.insertContent('[client.name]');
                                                }


                                            }, {
                                                text: '[client.phone] - Displays the Client Phone',
                                                onclick: function() {
                                                    editor.insertContent('[client.phone]');
                                                }


                                            }, {
                                                text: '[client.site.name] - Displays the Site Name',
                                                onclick: function() {
                                                    editor.insertContent('[client.site.name]');
                                                }


                                            }, {
                                                text: '[client.site.url] - Displays the Site Url',
                                                onclick: function() {
                                                    editor.insertContent('[client.site.url]');
                                                }


                                            }, {
                                                text: '[client.state] - Displays the Client State',
                                                onclick: function() {
                                                    editor.insertContent('[client.state]');
                                                }


                                            }, {
                                                text: '[client.zip] - Displays the Client Zip',
                                                onclick: function() {
                                                    editor.insertContent('[client.zip]');
                                                }


                                            }]
                                    },
                                    
                                    {
                                        text: 'Google Analytics',
                                        menu: [{
                                                text: '[ga.visits] - Displays the Number Visits during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[ga.visits]');
                                                }


                                            }, {
                                                text: '[ga.pageviews] - Displays the Number of Page Views during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[ga.pageviews]');
                                                }


                                            }, {
                                                text: '[ga.pages.visit] - Displays the Number of Page visit during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[ga.pages.visit]');
                                                }


                                            }, {
                                                text: '[ga.bounce.rate] - Displays the Bounce Rate during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[ga.bounce.rate]');
                                                }


                                            }, {
                                                text: '[ga.avg.time] - Displays the Average Visit Time during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[ga.avg.time]');
                                                }


                                            }, {
                                                text: '[ga.new.visits] - Displays the Number of New Visits during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[ga.new.visits]');
                                                }


                                            }, {
                                                text: '[a.visits.chart] - Displays a chart for the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[a.visits.chart]');
                                                }


                                            }]
                                    },
                                    {
                                        text: 'Piwik',
                                        <?php if (!MainWP_CReport::$enabled_piwik) { ?>
                                            menu: [{
                                                text: 'Requires MainWP Piwik Extension',
                                            }]
                                        <?php } else { ?>
                                            menu: [{
                                                text: '[piwik.visits] - Displays the Number Visits during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[piwik.visits]');
                                                }


                                            }, {
                                                text: '[piwik.pageviews] - Displays the Number of Page Views during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[piwik.pageviews]');
                                                }


                                            }, {
                                                text: '[piwik.pages.visit] - Displays the Number of Page visit during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[piwik.pages.visit]');
                                                }


                                            }, {
                                                text: '[piwik.bounce.rate] - Displays the Bounce Rate during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[piwik.bounce.rate]');
                                                }


                                            }, {
                                                text: '[piwik.avg.time] - Displays the Average Visit Time during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[piwik.avg.time]');
                                                }


                                            }, {
                                                text: '[piwik.new.visits] - Displays the Number of New Visits during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[piwik.new.visits]');
                                                }


                                            }]
                                         <?php }  ?>
                                    },
                                    {
                                        text: 'AUM',
                                        <?php if (!MainWP_CReport::$enabled_ga) { ?>
                                            menu: [{
                                                text: 'Requires MainWP Google Analytics Extension',
                                            }]
                                        <?php } else { ?>
                                        menu: [{
                                                text: '[aum.alltimeuptimeratio] - Displays the Uptime ratio from the moment the monitor has been created',
                                                onclick: function() {
                                                    editor.insertContent('[aum.alltimeuptimeratio]');
                                                }


                                            }, {
                                                text: '[aum.uptime7] - Displays the Uptime ratio for last 7 days',
                                                onclick: function() {
                                                    editor.insertContent('[aum.uptime7]');
                                                }


                                            }, {
                                                text: '[aum.uptime15] - Displays the Uptime ration for last 15 days',
                                                onclick: function() {
                                                    editor.insertContent('[aum.uptime15]');
                                                }


                                            }, {
                                                text: '[aum.uptime30] - Displays the Uptime ration for last 30 days',
                                                onclick: function() {
                                                    editor.insertContent('[aum.uptime30]');
                                                }


                                            }, {
                                                text: '[aum.uptime45] - Displays the Uptime ration for last 45 days',
                                                onclick: function() {
                                                    editor.insertContent('[aum.uptime45]');
                                                }


                                            }, {
                                                text: '[aum.uptime60] - Displays the Uptime ration for last 60 days',
                                                onclick: function() {
                                                    editor.insertContent('[aum.uptime60]');
                                                }
                                            }, {
                                                text: '[aum.stats] - Displays the Uptime Statistics',
                                                onclick: function() {
                                                    editor.insertContent('[aum.stats]');
                                                }
                                            }]
                                         <?php }  ?>
                                    },
                                    {
                                        text: 'WooCommerce Status',
                                        <?php if (!MainWP_CReport::$enabled_woocomstatus) { ?>
                                            menu: [{
                                                text: 'Requires MainWP WooCommerce Status Extension',
                                            }]
                                        <?php } else { ?>                                                
                                        menu: [{
                                                text: '[wcomstatus.sales] - Displays total sales during the selected data range',
                                                onclick: function() {
                                                    editor.insertContent('[wcomstatus.sales]');
                                                }


                                            }, {
                                                text: '[wcomstatus.topseller] - Displays the top seller product during the selected data range',
                                                onclick: function() {
                                                    editor.insertContent('[wcomstatus.topseller]');
                                                }


                                            }, {
                                                text: '[wcomstatus.awaitingprocessing] - Displays the number of products currently awaiting for processing',
                                                onclick: function() {
                                                    editor.insertContent('[wcomstatus.awaitingprocessing]');
                                                }


                                            }, {
                                                text: '[wcomstatus.onhold] - Displays the number of orders currently on hold',
                                                onclick: function() {
                                                    editor.insertContent('[wcomstatus.onhold]');
                                                }


                                            }, {
                                                text: '[wcomstatus.lowonstock] - Displays the number of products currently low on stock',
                                                onclick: function() {
                                                    editor.insertContent('[wcomstatus.lowonstock]');
                                                }


                                            }, {
                                                text: '[wcomstatus.outofstock] - Displays the number of products currently out of stock',
                                                onclick: function() {
                                                    editor.insertContent('[wcomstatus.outofstock]');
                                                }


                                            }]
                                        <?php }  ?>
                                    },
                                    {
                                        text: 'Wordfence',
                                        <?php if (!MainWP_CReport::$enabled_wordfence) { ?>
                                            menu: [{
                                                text: 'Requires MainWP Wordfence Extension',
                                            }]
                                        <?php } else { ?>                                                
                                            menu: [{
                                                text: '[section.wordfence.scan][/section.wordfence.scan] - Loops through Wordfence scans during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[section.wordfence.scan][/section.wordfence.scan]');
                                                }


                                            }, {
                                                text: '[wordfence.scan.count] - Displays the number of performed Wordfence scans during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[wordfence.scan.count]');
                                                }


                                            }, {
                                                text: '[wordfence.scan.result] - Displays the Wordfence scan result',
                                                onclick: function() {
                                                    editor.insertContent('[wordfence.scan.result]');
                                                }


                                            }, {
                                                text: '[wordfence.scan.date] - Displays the Wordfence scan date',
                                                onclick: function() {
                                                    editor.insertContent('[wordfence.scan.date]');
                                                }


                                            }, {
                                                text: '[wordfence.scan.time] - Displays the Wordfence scan time',
                                                onclick: function() {
                                                    editor.insertContent('[wordfence.scan.time]');
                                                }


                                            }, {
                                                text: '[wordfence.scan.details] - Displays the Wordfence scan details',
                                                onclick: function() {
                                                    editor.insertContent('[wordfence.scan.details]');
                                                }


                                            }]
                                        <?php }  ?>
                                    },
                                    {
                                        text: 'Maintenance',
                                        <?php if (!MainWP_CReport::$enabled_maintenance) { ?>
                                            menu: [{
                                                text: 'Requires MainWP Maintenance Extension',
                                            }]
                                        <?php } else { ?>  
                                        menu: [{
                                                text: '[section.maintenance.process][/section.maintenance.process] - Loops through performed Maintenance actions',
                                                onclick: function() {
                                                    editor.insertContent('[section.maintenance.process][/section.maintenance.process]');
                                                }


                                            }, {
                                                text: '[maintenance.process.count] - Displays the number of performed Maintenance actions during the selected date range',
                                                onclick: function() {
                                                    editor.insertContent('[maintenance.process.count]');
                                                }


                                            }, {
                                                text: '[maintenance.process.result] - Displays the status of performed Maintenance',
                                                onclick: function() {
                                                    editor.insertContent('[maintenance.process.result]');
                                                }


                                            }, {
                                                text: '[maintenance.process.date] - Displays the date of performed Maintenance',
                                                onclick: function() {
                                                    editor.insertContent('[maintenance.process.date]');
                                                }


                                            }, {
                                                text: '[maintenance.process.time] - Displays the time of performed Maintenance',
                                                onclick: function() {
                                                    editor.insertContent('[maintenance.process.time]');
                                                }


                                            }, {
                                                text: '[maintenance.process.details] - Displays performed actions',
                                                onclick: function() {
                                                    editor.insertContent('[maintenance.process.details]');
                                                }


                                            }]
                                        <?php } ?>  
                                    },
                                    {
                                        text: 'Pagespeed',
                                        <?php if (!MainWP_CReport::$enabled_pagespeed) { ?>
                                            menu: [{
                                                text: 'Requires MainWP Page Speed Extension',
                                            }]
                                        <?php } else { ?>  
                                        menu: [{
                                                text: '[pagespeed.average.desktop] - Displays the average desktop page-speed score at the moment of report generation',
                                                onclick: function() {
                                                    editor.insertContent('[pagespeed.average.desktop]');
                                                }


                                            }, {
                                                text: '[pagespeed.average.mobile] - Displays the average mobile page-speed score at the moment of report creation',
                                                onclick: function() {
                                                    editor.insertContent('[pagespeed.average.mobile]');
                                                }


                                            }]
                                        <?php } ?>  
                                    },
                                    {
                                        text: 'Broken Links',
                                        <?php if (!MainWP_CReport::$enabled_brokenlinks) { ?>
                                            menu: [{
                                                text: 'Requires MainWP Broken Links Checker Extension',
                                            }]
                                        <?php } else { ?> 
                                        menu: [{
                                                text: '[brokenlinks.links.broken] - Displays the number of broken links at the moment of report creation',
                                                onclick: function() {
                                                    editor.insertContent('[brokenlinks.links.broken]');
                                                }


                                            }, {
                                                text: '[brokenlinks.links.redirect] - Displays the number of redirected links at the moment of report creation',
                                                onclick: function() {
                                                    editor.insertContent('[brokenlinks.links.redirect]');
                                                }


                                            }, {
                                                text: '[brokenlinks.links.dismissed] - Displays the number of dismissed links at the moment of report creation',
                                                onclick: function() {
                                                    editor.insertContent('[brokenlinks.links.dismissed]');
                                                }


                                            }, {
                                                text: '[brokenlinks.links.all] - Displays the number of all links at the moment of report creation',
                                                onclick: function() {
                                                    editor.insertContent('[brokenlinks.links.all]');
                                                }


                                            }]
                                         <?php } ?>  
                                    }                                    
                        ]

                    });  
                        }
                    });
                });
            </script>
        <?php
    }