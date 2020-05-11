<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/ashish-barman-9aa81010a/
 * @since      1.0.0
 *
 * @package    Mt_Collection
 * @subpackage Mt_Collection/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mt_Collection
 * @subpackage Mt_Collection/public
 * @author     Ashish Barman <ashish121383@gmail.com>
 */
class Mt_Collection_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( $this->plugin_name.'-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mt-collection-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		

	
		wp_enqueue_script( $this->plugin_name.'slim-js', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'custom-jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'custom-pop', 'https://cdn.jsdelivr.net/npm/sweetalert2@9', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mt-collection-public.js', array( 'jquery' ), $this->version, true );
		
			// Localize the script with new data
			$script_data_array = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'load_more_posts' ),
			);
			wp_localize_script( $this->plugin_name, 'blog', $script_data_array );
		 
			

	}

	public function single_post_collection_template_call_back(){
		global $post;

	    $located = locate_template( 'single-collection.php' );
		if ( !empty( $located ) ) {
			return $located;
		}else{
			if ($post->post_type == 'collection')
			$single_template = dirname( __FILE__ ) . '/partials/mt-collection-public-single-collection.php';
		}
		return $single_template;
	}

	public function archive_post_collection_template_call_back(){
		global $post;
		$located = locate_template( 'archive-collection.php' );
		if ( !empty( $located ) ) {
			return $located;
		}else{
			if ($post->post_type == 'collection')
			$archive_template = dirname( __FILE__ ) . '/partials/mt-collection-public-archive-collection.php';
		}
	 
		
		return $archive_template;
	}

	public function taxonomy_template_collection_call_back(){
		global $post;
		$taxonomy_slug = get_query_var('taxonomy');
		$located = locate_template( "taxonomy-{$taxonomy_slug }.php" );
		if ( !empty( $located ) ) {
			return $located;
		}else{
			if ($post->post_type == 'collection'){
				
				$taxonomy_template = dirname( __FILE__ ) . "/partials/taxonomy-{$taxonomy_slug}.php";
			}	
		}
		return $taxonomy_template;
	}

	public function load_posts_by_ajax_callback() {
		check_ajax_referer('load_more_posts', 'security');
		$paged = $_POST['page']?:'';
		$color = $_POST['collection_color']?:'';
		$size = $_POST['collection_size']?:'';

		if(!empty($color) && !empty($size) && $paged < 1 ){
			$args = array(
				'post_type' => 'collection',
				'post_status' => 'publish',
				'posts_per_page' => '-1',
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key'     => 'collection_size',
						'value'   => $size,
						'compare' => '=',
					),
					array(
						'key'     => 'collection_color',
						'value'   => $color,
						'compare' => '=',
					),
				),
			);		
		}elseif(!empty($color) && !empty($size) && $paged > 1 ){
			$args = array(
				'post_type' => 'collection',
				'post_status' => 'publish',
				'posts_per_page' => '3',
				'paged' => $paged,
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key'     => 'collection_size',
						'value'   => $size,
						'compare' => '=',
					),
					array(
						'key'     => 'collection_color',
						'value'   => $color,
						'compare' => '=',
					),
				),
			);
			
			
		}else{
			$args = array(
				'post_type' => 'collection',
				'post_status' => 'publish',
				'posts_per_page' => '3',
				'paged' => $paged,
			);

		}

		$blog_posts = new WP_Query( $args );
		?>
	 
		<?php if ( $blog_posts->have_posts() ) : ?>
			<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post();
			 $featured_image_url = get_the_post_thumbnail_url() ?: 'http://localhost/manekTech/wp-content/uploads/2020/05/social.jpeg';
			?>
			<div class="col-md-4 collection-post">
                  <div class="product-item">
                     <figure>
                        <img src="<?php echo $featured_image_url; ?>" alt="" />
                     </figure>
                     <div class="p-3">
                        <h6 class="product-title"><?php echo ucfirst(get_the_title()); ?></h6>
                        <p><?php the_excerpt();?></p>
                     </div>
                  </div>
               </div>
			<?php endwhile; ?>
			<?php
			wp_reset_query();
			?>
				
			<?php
		endif;
	 
		wp_die();
	}


	// Create Collection 

	public function create_collection_call_back(){
		$collection_data = $_POST['collection_data'];
		
		$args =  array(
			'post_title'   => wp_strip_all_tags($collection_data[0]['value']),
			'post_content' => wp_strip_all_tags($collection_data[1]['value']),
			'post_type'=>'collection',
			'post_status'  => 'pending',
			'post_author'  => get_current_user_id(),
			'tax_input'    => array(
				'collection_category' => array( $collection_data[2]['value'] )
			),
			'meta_input'   => array(
				'collection_size' => $collection_data[3]['value'],
				'collection_color' => $collection_data[4]['value']
			),
		);

		$post_id = wp_insert_post($args);

		if( !is_wp_error($post_id) ) {
			wp_send_json_success(array('post_id' => $post_id), 200);
		  } else {
			wp_send_json_error($post_id->get_error_message());
		  }


		wp_die();
	}

}
