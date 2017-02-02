<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Ng_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = WP_NG_PLUGIN_NAME;
		$this->version = WP_NG_PLUGIN_VERSION;

		$this->load_dependencies();
    $this->set_locale();
    $this->define_settings_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Ng_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Ng_i18n. Defines internationalization functionality.
	 * - Wp_Ng_Admin. Defines all hooks for the admin area.
	 * - Wp_Ng_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

    /**
     * Global Functions of the plugin.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-ng-settings-descriptor.php';

    /**
     * Global Functions of the plugin.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-ng-core-functions.php';


    /**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-ng-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-ng-i18n.php';

    /**
     * The class responsible for orchestrating the cache.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-ng-cache.php';

    /**
     * The class responsible for orchestrating the conditional settings
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-ng-conditional.php';

    /**
     * The class responsible for orchestrating the settings fields page.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-ng-settings.php';

    /**
     * The class responsible for defining manifest
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-ng-manifest.php';

    /**
     * The class responsible for defining bower map to cdn
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-ng-bower.php';

    /**
     * The class responsible for orchestrating the ng modules
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-ng-module.php';


    /**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-ng-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-ng-public.php';


		$this->loader = new Wp_Ng_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Ng_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Ng_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

   /**
	* Register all of the hooks related to the settings page
	* of the plugin.
	*
	* @since    1.0.0
	* @access   private
	*/
	private function define_settings_hooks() {

		Wp_Ng_Settings::createInstance( $this->plugin_name, $this->version );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Ng_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Ng_Public( $this->get_plugin_name(), $this->get_version() );

		//Default Scripts and styles
		$this->loader->add_action( 'wp_default_scripts',  $plugin_public, 'default_scripts' );
		$this->loader->add_action( 'wp_default_styles',   $plugin_public, 'default_styles' );
    $this->loader->add_action( 'wp_enqueue_scripts',  $plugin_public, 'external_modules' );
    $this->loader->add_action( 'wp_enqueue_scripts',  $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts',  $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'after_setup_theme',   $plugin_public, 'after_setup_theme');

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
	 * @return    Wp_Ng_Loader    Orchestrates the hooks of the plugin.
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

}
