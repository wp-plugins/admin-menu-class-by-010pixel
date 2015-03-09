<?php
/*
Plugin Name: Admin Menu Class by 010Pixel 
Plugin URI: http://www.010pixel.com/plugins/admin-menu-class-by-010pixel/
Description: This plugin is to create menu on left navigation in WordPress Admin Panel
Author: 010 Pixel
Version: 1.2.0
Author URI: http://www.010pixel.com/

--------------------------------------------------------------------------------

 How to use:

--------------------------------------------------------------------------------

 	*	$menu['prefix'] : Prefix for slug. This prefix will be applied to all the menus and sub menus
 	*	$menu['users'] : Array of user groups which can access the menu. This applies to all menus and submenus. This one will be applied when no user is set for menu or submenu.
 	*	$menu['menus'][0]['users'] : Array of users groups which can access the menu. This will apply to this particular menu and it's submenus. This one will override $menu['users']. This one will be applied when no user is set for menu or submenus.
 	*	$menu['menus'][0]['args'] : Necessary arguments for the main page
 	*	$menu['menus'][0]['args']['include'] : A file to be included when this page is being executed. (Tip: put all the functions necessary for the page in this file)
	*	$menu['menus'][0]['submenus'] : Array of arguments for submenus under this particular menu
	*	$menu['menus'][0]['submenus'][0]['users'] : Array of user groups which can access this submenu. This one will override all above user arguments.
 	*	$menu['menus'][0]['submenus'][0]'include'] : A file to be included when this page is being executed. (Tip: put all the functions necessary for the page in this file)

--------------------------------------------------------------------------------
 
 Sample Code:
 
--------------------------------------------------------------------------------
	// Check if admin_menu_class_by_010pixel class exists
	// (if not, check if the plugin is active)
    if ( class_exists('admin_menu_class_by_010pixel') ) {
        $args = array(
            'prefix' => '',
            'users' => array(),
            'menus' => array(
                    array(
                        'users' => array('administrator'),
                        'args' => array(
                            'page_title' => 'Reports',
                            'menu_title' => 'Reports',
                            'users' => array('administrator'),
                            'slug' => 'reports',
                            'icon_url' => 'http://www.google.com/images/icons/product/spreadsheets-16.png',
                            'position' => '0',
                            'include' => array('somefile.php', 'somefile2.php')
                        ), // End of args Array
                        'submenus' => array(
                            array(
                                'page_title' => 'All Reports',
                                'menu_title' => 'All Reports',
                                'users' => array('administrator'),
                                'slug' => 'reports',
                                'function' => function() { echo "This is sample reports page."; },
	                            'include' => 'somefile.php'
                            ), // End of submenus Array item1
                            array(
                                'page_title' => 'Invoice',
                                'menu_title' => 'Invoice',
                                'users' => array('administrator'),
                                'slug' => 'invoice',
                                'function' => 'sample_show_invoice',
	                            'include' => 'somefile.php'
                            ) // End of submenus Array item2
                        ) // End of submenus Array
                    ), // End of menus Array item1
                    array(
                        'users' => array('administrator'),
                        'args' => array(
                            'page_title' => 'Contest',
                            'menu_title' => 'Contest',
                            'users' => array('administrator'),
                            'slug' => 'contest',
                            'function' => function() { echo "This is sample contest page."; },
                            'include' => 'somefile.php'
                        ), // End of args Array
                        'submenus' => array(
                            array(
                                'page_title' => 'Participants',
                                'menu_title' => 'Participants',
                                'users' => array('administrator'),
                                'slug' => 'participants',
                                'function' => function() { echo "This is sample participants page."; },
	                            'include' => 'somefile.php'
                            ) // End of submenus Array item1
                        ) // End of submenus Array
                    ) // End of menus Array item2
                ) // End of menus Array
        ); // End of $args

        $menus = new admin_menu_class_by_010pixel();
        $menus->create($args);
    }

    function sample_show_invoice () {
        echo "This is sample invoice page.";  
    }

--------------------------------------------------------------------------------
 
    Copyright 2013  010 Pixel  (email : 010pixel@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

--------------------------------------------------------------------------------
*/
?>
<?php
	class admin_menu_class_by_010pixel {

		var $menu = array(
						'prefix' => '',
						'users' => array(),
						'menus' => array(
								array(
									'users' => array('administrator'),
									'args' => array(
										/*'page_title' => 'Sample Page Title',
										'menu_title' => 'SampleMenu Title',
										'users' => array('administrator'),
										'slug' => 'sample_slug',
										'function' => '',
										'icon_url' => '',
										'position' => null,
			                            'include' => ''*/
									),
									'submenus' => array(
										array(
											/*'page_title' => 'sample subpage title',
											'menu_title' => 'sample submenu title',
											'users' => array('administrator'),
											'slug' => 'submenu_slug',
											'function' => '',
				                            'include' => ''*/
										),
									),
								),
							),
						);

		var $defaults = array(
				'menu' => array(
					'page_title' => '',
					'menu_title' => '',
					'users' => array(),
					'slug' => '',
					'function' => '',
					'icon_url' => '',
					'position' => null,
					'include' => '',
				),
				'submenu' => array(
					'page_title' => '',
					'menu_title' => '',
					'users' => array(),
					'slug' => 'submenu_slug',
					'function' => '',
					'include' => '',
				)
			);

		private $user_roles;

		public function __construct( $args = array() ) {

			// Get logged-in user roles
			$user = wp_get_current_user();
			$this->user_roles = $user->roles;

			if ( !is_admin() ) return;

			if ( !empty($args) ) {			
				$this->menu = array_merge($this->menu, $args);
			}

		}

		public function create( $args = array() ) {

			if ( !is_admin() ) return;

			if ( !empty($args) ) {			
				$this->menu = array_merge($this->menu, $args);
			}
			
			add_action('admin_menu', array( &$this, 'create_menu') );
			// $this->create_menu();

		}
		
		// Create Menu to access Template List Metabox Admin Page
		public function create_menu() {

			$menu_obj = $this->menu;

			// Add main menu
			foreach ( $menu_obj['menus'] as $menu ) {

				// If main menu has no argument then skip this menu
				if ( empty($menu['args']) ) continue;

				// Merge with default arguments to skip missing values
				$menu = array_merge($this->defaults['menu'], $menu);
				if ( empty($menu['args']['menu_title']) ) { $menu['args']['menu_title'] = $menu['args']['page_title']; }
				if ( empty($menu['args']['function']) ) { $menu['args']['function'] = array( &$this, 'empty_function'); }

				$menu_users = (array) ( !empty($menu['args']['users']) ? $menu['args']['users'] : (!empty($menu['users']) ? $menu['users'] : $menu_obj['users']) );

				foreach ( $menu_users as $menu_user ) {

					// check if the menu is for currently logged in user
					// if not continue with next menu item
					if ( ! in_array( $menu_user, $this->user_roles ) ) continue;

					// Include required file
					$this->include_file($menu['args']['include'], $menu_obj['prefix'] . $menu['args']['slug']);

					// Add Main Menu Item
					add_menu_page(
						$menu['args']['page_title'],
						$menu['args']['menu_title'],
						$menu_user,
						$menu_obj['prefix'] . $menu['args']['slug'],
						$menu['args']['function'],
						$menu['args']['icon_url'],
						$menu['args']['position']
					);

				}

				// Add submenus
				foreach ( $menu['submenus'] as $submenu ) {

					// If sub menu has no argument then skip this submenu
					if ( empty($submenu) ) continue;

					// Merge with default arguments to skip missing values
					$submenu = array_merge($this->defaults['submenu'], $submenu);
					if ( empty($submenu['menu_title']) ) { $submenu['menu_title'] = $submenu['page_title']; }
					if ( empty($submenu['function']) ) { $submenu['function'] = array( &$this, 'empty_function'); }

					$submenu_users = (array) ( !empty($submenu['users']) ? $submenu['users'] : (!empty($menu['args']['users']) ? $menu['args']['users'] : $menu_obj['users']) );

					foreach ( $submenu_users as $submenu_user ) {

						// check if the submenu is for currently logged in user
						// if not continue with next submenu item
						if ( ! in_array( $submenu_user, $this->user_roles ) ) continue;

						// Include required file
						$this->include_file($submenu['include'], $menu_obj['prefix'] . $submenu['slug']);

						// Add SubMenu Item
						add_submenu_page(
							$menu_obj['prefix'] . $menu['args']['slug'],
							$submenu['page_title'],
							$submenu['menu_title'],
							$submenu_user,
							$menu_obj['prefix'] . $submenu['slug'],
							$submenu['function']
						);  

					}

				}

			}

		}

		public function empty_function () {}

		/*
			Include necessary file
			$files: a single file path or a list of file paths
			$page: the page name which requires this files to be included
		*/
		private function include_file ($files, $page) {

			if ( isset($files) && !empty($files) ) {

				$files = (array) $files;
				
				foreach ( $files as $file ) {

					// Skip including this file if,
					// $file is blank
					// or current page is not the one requiring the file
					// or the file doesn't exist
					if ( empty($file) || ($GLOBALS['plugin_page'] !== $page) || !file_exists($file) )
						continue;

					require_once ($file);

				}
			}

		}

	}

?>