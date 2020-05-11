<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.linkedin.com/in/ashish-barman-9aa81010a/
 * @since             1.0.0
 * @package           Mt_Collection
 *
 * @wordpress-plugin
 * Plugin Name:       MT Collection
 * Plugin URI:        https://wordpres.org
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ashish Barman
 * Author URI:        https://www.linkedin.com/in/ashish-barman-9aa81010a/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mt-collection
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MT_COLLECTION_VERSION', '1.0.0' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mt-collection-activator.php
 */
/*
Register custom Meta box
*/add_filter('template_include', 'taxonomy_template');
function taxonomy_template( $template ){

	if( is_tax('accommodation-categories')){
		$template = BASE_DIR .'/templates/taxonomy-accommodation-categories.php';
	}  
	
	return $template;
	
	}

function activate_mt_collection() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mt-collection-activator.php';
	Mt_Collection_Activator::activate();
	
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mt-collection-deactivator.php
 */
function deactivate_mt_collection() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mt-collection-deactivator.php';
	Mt_Collection_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mt_collection' );
register_deactivation_hook( __FILE__, 'deactivate_mt_collection' );



/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mt-collection.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mt_collection() {

	$plugin = new Mt_Collection();
	$plugin->run();

}
run_mt_collection();




