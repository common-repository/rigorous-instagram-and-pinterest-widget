<?php
/*
  Plugin name: Rigorous Instagram and Pinterest feed
  Plugin URI: https://rigorousthemes.com/
  Description: A plugin that add a Instagram and pinterest widget
  Version: 1.0.2
  Author: Rigorous Themes
  Author URI: https://rigorousthemes.com/
  Text Domain: 'rigorous-instagram-pinterest-feed' 
  License: GPLv2 or later
 */

 // Exit if accessed directly.
  if ( ! defined( 'ABSPATH' ) ) {
  	exit;
  }


//Decleration of the necessary constants for plugin
  if( !defined( 'RWS_VERSION' ) ) {
  	define( 'RWS_VERSION', '1.0.0' );
  }

  if( !defined( 'RWS_CSS_DIR' ) ) {
  	define( 'RWS_CSS_DIR', plugin_dir_url( __FILE__ ) . 'css' );
  }
  
  include_once( 'inc/rigorousweb-instagram-widget-function.php' );
  include_once( 'inc/rigorousweb-instagram-widget.php' );
  include_once( 'inc/rigorousweb-pinterets-widget.php' ); 
  
  /**
 * Registers Frontend Assets
 *
 */
  function rigorous_instagram_pinterest_feed_frontend_assets() {
    wp_enqueue_style( 'rigorousweb-instagram-widget', RWS_CSS_DIR . '/rigorousweb-instagram-widget.css', array(), RWS_VERSION );
    wp_enqueue_style( 'rigorousweb-pinterest-widget', RWS_CSS_DIR  . '/rigorousweb-pinterest-widget.css', array(), RWS_VERSION );
    
  }
  add_action( 'wp_enqueue_scripts', 'rigorous_instagram_pinterest_feed_frontend_assets'); 