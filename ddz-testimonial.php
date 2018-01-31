<?php
/*
Plugin Name:  DDZ Testimonial Plugin
Plugin URI:   https://ddeveloperz.com
Description:  Testimonial
Version:      0.0.1
Author:       ddeveloperz.com
Author URI:   https://ddeveloperz.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wporg
Domain Path:  /languages
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$plugin_dir = dirname( __FILE__ );
$plugin_url = plugin_dir_url( __FILE__ );

define( 'DDZ_INC_DIR', $plugin_dir . '/inc/' );
define( 'DDZ_JS_URL', $plugin_url . 'assets/js/' );
ob_start();

/**
* 
*/
class DDZ_testimonial 
{
	
	public function __construct()
	{
		if(is_admin()) {
   		 add_action('admin_menu', array( $this, 'ddz_testimonial_menu' ));
   		
		}
		 add_action( 'admin_enqueue_scripts', array( $this, 'ddz_testimonial_assets' ) );
		 add_action( 'wp_enqueue_scripts', array( $this, 'ddz_testimonial_assets' ) );
		 
		require( DDZ_INC_DIR. 'ddz-front-display.php');
	}
	
	

	public function ddz_testimonial_menu() {
		add_menu_page( 'DDZ Testimonial', 'Testimonial', 'manage_options', 'ddz-testimonial', array($this,'ddz_display') );
		add_submenu_page( 'ddz-testimonial', 'Add Testimonial', 'Add testimonial' , 'manage_options', 'add_testimonial', array($this,'ddz_display') );
		add_submenu_page( 'ddz-testimonial', 'Settings', 'Settings' , 'manage_options', 'ddz-options', array($this,'ddz_display') );
	}

	public function ddz_testimonial_assets() {
		wp_enqueue_style( 'ddz-bootstrap', plugins_url( '/assets/css/bootstrap.css', __FILE__ ), array(), '2.0.1', false );
		wp_enqueue_style( 'ddz-testimonial-mdb', plugins_url( '/assets/css/mdb.min.css', __FILE__ ), array(), '2.0.1', false );
		wp_enqueue_style( 'ddz-testimonial-test', plugins_url( '/assets/css/test.css', __FILE__ ), array(), '2.0.1', false );
		wp_enqueue_style( 'ddz-testimonial', plugins_url( '/assets/css/style.css', __FILE__ ), array(), '2.0.1', false );

	
		wp_enqueue_media('media-upload');
	        wp_enqueue_media('thickbox');
		wp_enqueue_script( 'ddz-testimonial-script', plugins_url( '/assets/js/script.js', __FILE__ ) , array(), '', true );
		wp_enqueue_script( 'ddz-testimonial-bootstrap', plugins_url( '/assets/js/bootstrap.min.js', __FILE__ ) , array(), '', true );
		wp_enqueue_script( 'ddz-testimonial-mdb', plugins_url( '/assets/js/mdb.min.js', __FILE__ ) , array(), '', true );
	}
	public function dzz_testimonial_includes()
	{
		
		
		if ($_GET['page'] == 'ddz-options') {
			require( DDZ_INC_DIR. 'ddz-admin-settings.php');
		}	else {
			require( DDZ_INC_DIR. 'ddz-admin-display.php');
		}
		
		
	}

	public function ddz_display()
	{
		$this->dzz_testimonial_includes();
	}

	
}

new DDZ_testimonial;