<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.linkedin.com/in/ashish-barman-9aa81010a/
 * @since      1.0.0
 *
 * @package    Mt_Collection
 * @subpackage Mt_Collection/includes
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
 * @package    Mt_Collection
 * @subpackage Mt_Collection/includes
 * @author     Ashish Barman <ashish121383@gmail.com>
 */
class Mt_Collection {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mt_Collection_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'MT_COLLECTION_VERSION' ) ) {
			$this->version = MT_COLLECTION_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mt-collection';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mt_Collection_Loader. Orchestrates the hooks of the plugin.
	 * - Mt_Collection_i18n. Defines internationalization functionality.
	 * - Mt_Collection_Admin. Defines all hooks for the admin area.
	 * - Mt_Collection_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mt-collection-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mt-collection-i18n.php';

		/**
		 * Register Custom Metoxes 
		 */
		if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/cmb2/init.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ). 'admin/cmb2/init.php';

		} elseif ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CMB2/init.php' ) ) {

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/CMB2/init.php';
		}
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mt-collection-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mt-collection-public.php';

		$this->loader = new Mt_Collection_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mt_Collection_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mt_Collection_i18n();

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

		$plugin_admin = new Mt_Collection_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// Register Post type
		$this->loader->add_action( 'init',$plugin_admin,'collection_post_call_back');
		// Register Custom Field 
		$this->loader->add_action('cmb2_init',$plugin_admin,'collection_post_add_custom_meta_box');
		// custom post type notification
		$this->loader->add_action('admin_menu',$plugin_admin,'collection_post_add_pending_bubble');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Mt_Collection_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		// Override single template hook
		$this->loader->add_filter( 'single_template',$plugin_public,'single_post_collection_template_call_back');
		// Override archive template hook
		$this->loader->add_filter( 'archive_template',$plugin_public,'archive_post_collection_template_call_back');
		// Override taxonomy template hook

		$this->loader->add_filter( 'taxonomy_template',$plugin_public,'taxonomy_template_collection_call_back');

		// action hooks for ajax request 
					
		$this->loader->add_action('wp_ajax_load_posts_by_ajax', $plugin_public,'load_posts_by_ajax_callback');
		$this->loader->add_action('wp_ajax_nopriv_load_posts_by_ajax', $plugin_public,'load_posts_by_ajax_callback');

		// Create Collection 
		$this->loader->add_action('wp_ajax_create_collection', $plugin_public,'create_collection_call_back');
		$this->loader->add_action('wp_ajax_nopriv_create_collection', $plugin_public,'create_collection_call_back');

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
	 * @return    Mt_Collection_Loader    Orchestrates the hooks of the plugin.
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
