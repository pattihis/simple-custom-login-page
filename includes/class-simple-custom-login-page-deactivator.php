<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://profiles.wordpress.org/pattihis/
 * @since      1.0.0
 *
 * @package    Simple_Custom_Login_Page
 * @subpackage Simple_Custom_Login_Page/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Simple_Custom_Login_Page
 * @subpackage Simple_Custom_Login_Page/includes
 * @author     George Pattichis <gpattihis@gmail.com>
 */
class Simple_Custom_Login_Page_Deactivator {

	/**
	 * We will leave this here in case we need it in the future.
	 *
	 * We could purge our options on deactivations but we will use the uninstall.php file
	 * in the case the user is only temporarily deactivating.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
	}
}
