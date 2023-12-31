<?php
/**
 * Simple Custom Login Page
 *
 * @author            George Pattichis
 * @copyright         2024 George Pattichis
 * @license           GPL-2.0-or-later
 * @link              https://profiles.wordpress.org/pattihis/
 * @since             1.0.0
 * @package           Simple_Custom_Login_Page
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Custom Login Page
 * Plugin URI:        https://wordpress.org/plugins/simple-custom-login-page/
 * Description:       This plugin allows you to customize the image and the appearance of the WordPress Login Screen.
 * Version:           1.0.1
 * Requires at least: 5.3.0
 * Tested up to:      6.4.2
 * Requires PHP:      7.0
 * Author:            George Pattichis
 * Author URI:        https://profiles.wordpress.org/pattihis/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-custom-login-page
 * Domain Path:       /languages
 */

/*
	Copyright 2024  George Pattihis (gpattihis@gmail.com)

	"Simple Custom Login Page" is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 2 of the License, or
	any later version.

	"Simple Custom Login Page" is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	"along with Simple Custom Login Page". If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
	*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 *
 * @var string The current plugin version.
 */
define( 'SCLP_VERSION', '1.0.1' );

/**
 * Plugin's basename
 */
define( 'SCLP_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-custom-login-page-activator.php
 */
function activate_simple_custom_login_page() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-custom-login-page-activator.php';
	Simple_Custom_Login_Page_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-custom-login-page-deactivator.php
 */
function deactivate_simple_custom_login_page() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-custom-login-page-deactivator.php';
	Simple_Custom_Login_Page_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_custom_login_page' );
register_deactivation_hook( __FILE__, 'deactivate_simple_custom_login_page' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-custom-login-page.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_simple_custom_login_page() {

	$plugin = new Simple_Custom_Login_Page();
	$plugin->run();
}

run_simple_custom_login_page();
