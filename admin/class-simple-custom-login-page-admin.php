<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/pattihis/
 * @since      1.0.0
 *
 * @package    Simple_Custom_Login_Page
 * @subpackage Simple_Custom_Login_Page/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Custom_Login_Page
 * @subpackage Simple_Custom_Login_Page/admin
 * @author     George Pattichis <gpattihis@gmail.com>
 */
class Simple_Custom_Login_Page_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-custom-login-page-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_media();
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-custom-login-page-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
	}

	/**
	 * Register the admin menu
	 *
	 * @since    1.0.0
	 */
	public function simple_custom_login_page_admin_menu() {

		$page_title = __( 'Simple Custom Login Settings', 'simple-custom-login-page' );
		$menu_title = 'Simple Custom Login';
		$capability = 'manage_options';
		$menu_slug  = 'simple-custom-login-page';
		$function   = array( $this, 'simple_custom_login_page_admin_page' );

		add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	}

	/**
	 * Render the admin menu page content
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function simple_custom_login_page_admin_page() {
		include_once 'partials/simple-custom-login-page-admin-display.php';
	}

	/**
	 * Show custom links in Plugins Page
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $links Default Links.
	 * @param  array $file Plugin's root filepath.
	 * @return array Links list to display in plugins page.
	 */
	public function simple_custom_login_page_plugin_links( $links, $file ) {

		if ( SCLP_BASENAME === $file ) {
			$scpt_links = '<a href="' . get_admin_url() . 'options-general.php?page=simple-custom-login-page" title="Plugin Options">' . __( 'Settings', 'simple-custom-login-page' ) . '</a>';
			$scpt_visit = '<a href="https://gp-web.dev/" title="Contact" target="_blank" >' . __( 'Contact', 'simple-custom-login-page' ) . '</a>';
			array_unshift( $links, $scpt_visit );
			array_unshift( $links, $scpt_links );
		}

		return $links;
	}

	/**
	 * Register the settings
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function simple_custom_login_page_settings() {

		add_settings_section(
			'simple_custom_login_page_main_section',
			'Customize Your Admin Login Page',
			function () {
				esc_html_e( 'Use the options below to personalize the login page to your admin dashboard.', 'simple-custom-login-page' );
			},
			'simple-custom-login-page'
		);

		add_settings_field(
			'simple_custom_login_page_image',
			'Logo Image',
			function () {
				$default = get_home_url() . '/wp-admin/images/wordpress-logo.svg';
				if ( get_option( 'simple_custom_login_page_image' ) ) {
					$img = get_option( 'simple_custom_login_page_image' );
				} else {
					$img = $default;
				}
				?>
				<div class="sclp-image-selector">
					<img id="upload_image_preview" src='<?php echo esc_url( $img ); ?>' width='300' height='100' data-default="<?php echo esc_url( $default ); ?>">
					<button id="upload_image_button" class="button button-primary"><?php esc_html_e( 'Select Image', 'simple-custom-login-page' ); ?></button>
					<button id="reset_image_button" class="button button-secondary"><?php esc_html_e( 'Reset', 'simple-custom-login-page' ); ?></button>
					<input id="simple_custom_login_page_image" type="hidden" name="simple_custom_login_page_image" value=<?php echo esc_url( $img ); ?> />
				</div>
				<p class="sclp-info"><?php esc_html_e( 'Recommended dimensions width: 320px, height: 84px.', 'simple-custom-login-page' ); ?></p>
				<?php
			},
			'simple-custom-login-page',
			'simple_custom_login_page_main_section'
		);
		register_setting( 'simple-custom-login-page', 'simple_custom_login_page_image' );

		add_settings_field(
			'simple_custom_login_page_url',
			'Logo Link',
			function () {
				if ( get_option( 'simple_custom_login_page_url' ) ) {
					$url = get_option( 'simple_custom_login_page_url' );
				} else {
					$url = get_home_url();
				}
				?>
				<input type="text" name="simple_custom_login_page_url" value="<?php echo esc_url( $url ); ?>">
				<?php
			},
			'simple-custom-login-page',
			'simple_custom_login_page_main_section'
		);
		register_setting( 'simple-custom-login-page', 'simple_custom_login_page_url' );

		add_settings_field(
			'simple_custom_login_page_background',
			'Page Background',
			function () {
				if ( get_option( 'simple_custom_login_page_background' ) ) {
					$color = get_option( 'simple_custom_login_page_background' );
				} else {
					$color = '#f0f0f1';
				}

				?>
				<input type="text" name="simple_custom_login_page_background" id="simple_custom_login_page_background" value="<?php echo esc_html( $color ); ?>" data-default-color="#f0f0f1" />
				<?php
			},
			'simple-custom-login-page',
			'simple_custom_login_page_main_section'
		);
		register_setting( 'simple-custom-login-page', 'simple_custom_login_page_background' );

		add_settings_field(
			'simple_custom_login_page_form_bg',
			'Form Background',
			function () {
				if ( get_option( 'simple_custom_login_page_form_bg' ) ) {
					$color = get_option( 'simple_custom_login_page_form_bg' );
				} else {
					$color = '#ffffff';
				}

				?>
				<input type="text" name="simple_custom_login_page_form_bg" id="simple_custom_login_page_form_bg" value="<?php echo esc_html( $color ); ?>" data-default-color="#ffffff" />
				<?php
			},
			'simple-custom-login-page',
			'simple_custom_login_page_main_section'
		);
		register_setting( 'simple-custom-login-page', 'simple_custom_login_page_form_bg' );

		add_settings_field(
			'simple_custom_login_page_text_color',
			'Text Color',
			function () {
				if ( get_option( 'simple_custom_login_page_text_color' ) ) {
					$color = get_option( 'simple_custom_login_page_text_color' );
				} else {
					$color = '#3c434a';
				}

				?>
				<input type="text" name="simple_custom_login_page_text_color" id="simple_custom_login_page_text_color" value="<?php echo esc_html( $color ); ?>" data-default-color="#3c434a" />
				<?php
			},
			'simple-custom-login-page',
			'simple_custom_login_page_main_section'
		);
		register_setting( 'simple-custom-login-page', 'simple_custom_login_page_text_color' );

		add_settings_field(
			'simple_custom_login_page_link_color',
			'Link Color',
			function () {
				if ( get_option( 'simple_custom_login_page_link_color' ) ) {
					$color = get_option( 'simple_custom_login_page_link_color' );
				} else {
					$color = '#50575e';
				}

				?>
				<input type="text" name="simple_custom_login_page_link_color" id="simple_custom_login_page_link_color" value="<?php echo esc_html( $color ); ?>" data-default-color="#50575e" />
				<?php
			},
			'simple-custom-login-page',
			'simple_custom_login_page_main_section'
		);
		register_setting( 'simple-custom-login-page', 'simple_custom_login_page_link_color' );
	}
}
