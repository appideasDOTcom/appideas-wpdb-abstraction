<?php
/**
 * Plugin Name: APPideas Wordpress Database Abstraction
 * Plugin URI: https://github.com/appideasDOTcom/appideas-wpdb-abstraction
 * Description: A Wordpress plugin that provides a database abstraction layer
 * Version: 1.0
 * Author: Chris Ostmo
 * Author URI: https://appideas.com
 */
require_once( dirname( __FILE__ ) . "/classes/base/AiCommon.php" );

register_activation_hook( __FILE__, array( 'AiCommon', 'wpActivate' ) );