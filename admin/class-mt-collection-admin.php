<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/ashish-barman-9aa81010a/
 * @since      1.0.0
 *
 * @package    Mt_Collection
 * @subpackage Mt_Collection/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mt_Collection
 * @subpackage Mt_Collection/admin
 * @author     Ashish Barman <ashish121383@gmail.com>
 */
class Mt_Collection_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mt_Collection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mt_Collection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mt-collection-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mt_Collection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mt_Collection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mt-collection-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function collection_post_call_back(){

		$labels = array(
			'name'                  => _x( 'MT Collection', 'collection general name', 'mt-collection' ),
			'singular_name'         => _x( 'MT Collection', 'collection singular name', 'mt-collection' ),
			'menu_name'             => _x( 'MT Collection', 'Admin Menu text', 'mt-collection' ),
			'name_admin_bar'        => _x( 'MT Collection', 'Add New on Toolbar', 'mt-collection' ),
			'add_new'               => __( 'Add New', 'mt-collection' ),
			'add_new_item'          => __( 'Add New Collection', 'mt-collection' ),
			'new_item'              => __( 'New Collection', 'mt-collection' ),
			'edit_item'             => __( 'Edit Collection', 'mt-collection' ),
			'view_item'             => __( 'View Collection', 'mt-collection' ),
			'all_items'             => __( 'All Collection', 'mt-collection' ),
			'search_items'          => __( 'Search Collection', 'mt-collection' ),
			'parent_item_colon'     => __( 'Parent Collection:', 'mt-collection' ),
			'not_found'             => __( 'No collection found.', 'mt-collection' ),
			'not_found_in_trash'    => __( 'No collection found in Trash.', 'mt-collection' ),
			'featured_image'        => _x( 'Collection Cover Image', 'Overrides the “Featured Image” phrase for this collection. Added in 4.3', 'mt-collection' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this collection. Added in 4.3', 'mt-collection' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this collection. Added in 4.3', 'mt-collection' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this collection. Added in 4.3', 'mt-collection' ),
			'archives'              => _x( 'Collection archives', 'The collection archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'mt-collection' ),
			'insert_into_item'      => _x( 'Insert into collections', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'mt-collection' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this collections', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'mt-collection' ),
			'filter_items_list'     => _x( 'Filter collections list', 'Screen reader text for the filter links heading on the collection listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'mt-collection' ),
			'items_list_navigation' => _x( 'Collections list navigation', 'Screen reader text for the pagination heading on the collection listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'mt-collection' ),
			'items_list'            => _x( 'Collections list', 'Screen reader text for the items list heading on the collection listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'mt-collection' ),
		);
	 
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'collection' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'taxonomies' 			 => array('collection_category')
		);
	 
		register_taxonomy(
			'collection_category', 'collection', array(
			'hierarchical' => true,
			'label' => 'Collection Category',
			'query_var' => true,
			'rewrite' => true
		));

		register_post_type( 'collection', $args );

		flush_rewrite_rules();

	}

	public function collection_post_add_custom_meta_box(){
		$prefix = 'collection_';
		$collection_meta = new_cmb2_box( array(
			'id'            => $prefix.'meta_box',
			'title'         => esc_html__( 'Collection More Info', 'mt-collection' ),
			'object_types'  => array( 'collection' ), // Post type
		) );
	
		$collection_meta->add_field( array(
			'name'             => esc_html__( 'Collection Size', 'mt-collection' ),
			'desc'             => esc_html__( 'Please choose collection size', 'mt-collection' ),
			'id'               => $prefix.'size',
			'type'             => 'select',
			'show_option_none' => 'Select Size',
			'options'          => array(
				'20' => esc_html__( '20', 'mt-collection' ),
				'22'   => esc_html__( '22', 'mt-collection' ),
				'25'     => esc_html__( '25', 'mt-collection' ),
				'30'     => esc_html__( '30', 'mt-collection' ),
				'32'     => esc_html__( '32', 'mt-collection' ),
			),
		) );

		$collection_meta->add_field( array(
			'name'             => esc_html__( 'Collection Color', 'mt-collection' ),
			'desc'             => esc_html__( 'Select Color', 'mt-collection' ),
			'id'      => $prefix.'color',
			'type'    => 'multicheck',
			'options' => array(
				'red' => 'Red',
				'green' => 'Green',
				'blue' => 'Blue',
				'white' => 'White',
				'black' => 'Black',
			),
		) );
		
	}

	public function collection_post_add_pending_bubble(){
		global $menu;
		$custom_post_count = wp_count_posts('collection');
		$custom_post_pending_count = $custom_post_count->pending;
		if ( $custom_post_pending_count ) {
			foreach ( $menu as $key => $value ) {
				if ( $menu[$key][2] == 'edit.php?post_type=collection' ) {
					$menu[$key][0] .= ' <span class="update-plugins count-' . $custom_post_pending_count . '"><span class="plugin-count">' . $custom_post_pending_count . '</span></span>';
					return;
				}
			}
		}
	}


	
}
