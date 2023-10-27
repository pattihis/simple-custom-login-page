<?php
/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://profiles.wordpress.org/pattihis/
 * @since      1.0.0
 *
 * @package    Simple_Custom_Login_Page
 * @subpackage Simple_Custom_Login_Page/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<h1 class="sclp-heading"><?php esc_html_e( 'Simple Custom Login', 'simple-custom-login-page' ); ?></h1>
<form method="POST" action="options.php">
<?php
	settings_fields( 'simple-custom-login-page' );
	do_settings_sections( 'simple-custom-login-page' );
	submit_button();
?>
</form>
<div class="wrap">
	<p>If you find this free plugin useful then please <a target="_blank" href="https://wordpress.org/support/plugin/simple-custom-login-page/reviews/?rate=5#new-post" title="Rate the plugin">rate the plugin ★★★★★</a> to support us. Thank you!</p>
</div>
