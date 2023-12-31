<?php
/**
 * The file that defines the core plugin class
 *
 * @link       https://profiles.wordpress.org/pattihis/
 * @since      1.0.0
 *
 * @package    Simple_Custom_Login_Page
 * @subpackage Simple_Custom_Login_Page/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization and hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Simple_Custom_Login_Page
 * @subpackage Simple_Custom_Login_Page/includes
 * @author     George Pattichis <gpattihis@gmail.com>
 */
class Simple_Custom_Login_Page {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Simple_Custom_Login_Page_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SCLP_VERSION' ) ) {
			$this->version = SCLP_VERSION;
		} else {
			$this->version = '1.0.1';
		}
		$this->plugin_name = 'simple-custom-login-page';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Simple_Custom_Login_Page_Loader. Orchestrates the hooks of the plugin.
	 * - Simple_Custom_Login_Page_I18n. Defines internationalization functionality.
	 * - Simple_Custom_Login_Page_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-custom-login-page-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-custom-login-page-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-simple-custom-login-page-admin.php';

		$this->loader = new Simple_Custom_Login_Page_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Simple_Custom_Login_Page_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Simple_Custom_Login_Page_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Simple_Custom_Login_Page_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'simple_custom_login_page_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'simple_custom_login_page_admin_menu' );
		$this->loader->add_filter( 'plugin_action_links', $plugin_admin, 'simple_custom_login_page_plugin_links', 10, 2 );

		$this->loader->add_action( 'login_head', $this, 'simple_custom_login_page_customize' );
		$this->loader->add_action( 'login_headerurl', $this, 'sclp_link_customize' );
		$this->loader->add_action( 'login_headertext', $this, 'sclp_text_customize' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Simple_Custom_Login_Page_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Customize the login page styles.
	 *
	 * @since     1.0.0
	 * @return    void
	 * @link      https://codex.wordpress.org/Customizing_the_Login_Form
	 */
	public function simple_custom_login_page_customize() {

		if ( get_option( 'simple_custom_login_page_background' ) ) {
			$background = get_option( 'simple_custom_login_page_background' );
		} else {
			$background = '#f0f0f1';
		}

		if ( get_option( 'simple_custom_login_page_text_color' ) ) {
			$text = get_option( 'simple_custom_login_page_text_color' );
		} else {
			$text = '#3c434a';
		}

		if ( get_option( 'simple_custom_login_page_image' ) ) {
			$img          = get_option( 'simple_custom_login_page_image' );
			$upload_dir   = wp_upload_dir();
			$image_path   = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $img );
			$getimagesize = wp_getimagesize( $image_path );
			if ( $getimagesize ) {
				$width  = $getimagesize[0];
				$height = $getimagesize[1];
			} else {
				$width  = '320px';
				$height = '84px';
			}
		} else {
			return;
		}

		if ( get_option( 'simple_custom_login_page_form_bg' ) ) {
			$form = get_option( 'simple_custom_login_page_form_bg' );
		} else {
			$form = '#ffffff';
		}

		if ( get_option( 'simple_custom_login_page_link_color' ) ) {
			$link = get_option( 'simple_custom_login_page_link_color' );
		} else {
			$link = '#50575e';
		}

		echo '<style type="text/css">
			body.login {
				background-color: ' . esc_attr( $background ) . ';
				color: ' . esc_attr( $text ) . ';
			}

			#login h1 a, .login h1 a {
				background-image:url(' . esc_url( $img ) . ');
				height: ' . esc_attr( $height ) . 'px;
				width: ' . esc_attr( $width ) . 'px;
				max-width: 100%;
				max-height: 84px;
				background-size: contain;
				background-repeat: no-repeat;
			}

			body.login div#login form#loginform,
			body.login div#login form#lostpasswordform,
			body.login div#login p.message {
				background-color: ' . esc_attr( $form ) . ';
				border-color: ' . esc_attr( $form ) . ';
			}

			body.login div#login p#backtoblog a,
			body.login div#login p#nav a {
				color: ' . esc_attr( $link ) . ';
			}
		</style>';
	}


	/**
	 * Customize the login page link
	 *
	 * @since     1.0.0
	 * @return    string    $url    The url of the link
	 * @link      https://codex.wordpress.org/Customizing_the_Login_Form
	 */
	public function sclp_link_customize() {
		if ( get_option( 'simple_custom_login_page_url' ) ) {
			$url = get_option( 'simple_custom_login_page_url' );
		} else {
			$url = get_home_url();
		}
		return $url;
	}


	/**
	 * Customize the login page title
	 *
	 * @since     1.0.0
	 * @return    string    $title    The title of the link
	 * @link      https://codex.wordpress.org/Customizing_the_Login_Form
	 */
	public function sclp_text_customize() {
		return get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' );
	}
}
