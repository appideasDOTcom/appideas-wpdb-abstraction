<?php
/**
 * Core wordpress functionality helper functions.
*/
/**
 * Core wordpress functionality helper functions.
 * 
 * @author Chris Ostmo
 * @link https://appideas.com/blog/
 * @package		Ai_DatabaseAbstraction
 */
class AiWpHelper
{
	/**
	 * Install the needed schema and data on plugin activation
	 *
	 * @return void
	 */
    public static function wpActivate()
	{
		global $wpdb;
		
		$collation = $wpdb->get_charset_collate();
		$tableName = $wpdb->prefix . "aidb_versions";

		// Add our necessary schema
		$sql = "
		CREATE TABLE `" . $tableName . "` (
			`schema_slug` TINYTEXT,
			`version_number` int(11) NOT NULL default '0',
			`update_time` timestamp NOT NULL default CURRENT_TIMESTAMP
		) " . $collation . ";";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		// Record version 1 using AiDb if no record is present
		$common = new AiCommon();
		$sql = "SELECT COUNT(*) FROM " . $tableName . " WHERE schema_slug = '" . AiCommon::$schemaSlug . "'";
		$result = $common->mDb->query( $sql, __FILE__, __LINE__ );
		while( $row = $common->mDb->fetchRow( $result ) )
		{
			if( $row[0] < 1 )
			{
				$sql = "
					INSERT 	INTO " . $tableName . " 
							(schema_slug, version_number, update_time)
					VALUES	('" . AiCommon::$schemaSlug . "', 1, NULL)";
				$common->mDb->query( $sql, __FILE__, __LINE__ );
			}
		}
	}

	/**
	 * Actions to perform on plugin initialization (every page load in Wordpress)
	 *
	 * @return void
	 */
	public static function wpInit()
	{
		// Load CSS
		// There's currently no need to enqueue the CSS or javascript except in admin since 
		//    there is no end-user visualization of this plugin
		// add_action( 'wp_enqueue_scripts', array( 'AiWpHelper', 'wpLoadCss' ) );
		add_action( 'admin_enqueue_scripts', array( 'AiWpHelper', 'wpLoadCss' ) );

		// Load javascript
		// add_action( 'wp_enqueue_scripts', array( 'AiWpHelper', 'wpLoadJavascript' ) );
		add_action( 'admin_enqueue_scripts', array( 'AiWpHelper', 'wpLoadJavascript' ) );

		// Add the admin menu
		add_action( 'admin_menu', array( 'AiWpHelper', 'adminMenu' ) );
	}

	/**
	 * Load plugin CSS file(s)
	 *
	 * @return void
	 */
	public static function wpLoadCss()
	{
		$cssUrl = AIDB_PLUGIN_URL . "/css/aidb.css";
		$pluginData = get_plugin_data( AIDB_PLUGIN_URL . "/appideas-wpdb-abstraction.php" );

		wp_register_style( 'aidb_css', $cssUrl, false, $pluginData['Version'], 'all' );
		wp_enqueue_style( 'aidb_css' );
	}

	/**
	 * Load plugin javascript file(s)
	 *
	 * @return void
	 */
	public static function wpLoadJavascript()
	{
		$jsUrl = AIDB_PLUGIN_URL . "/js/aidb.js";
		$pluginData = get_plugin_data( AIDB_PLUGIN_URL . "/appideas-wpdb-abstraction.php" );

		wp_register_script( 'aidb_js', $jsUrl, array( 'jquery' ), $pluginData['Version'], 'all' );
		wp_enqueue_script( 'aidb_js' );

		// Reveal some variables that PHP knows to javascript
		$jsData = array(
			'url' => AIDB_PLUGIN_URL,
			'path' => AIDB_PLUGIN_DIR,
			'slug' => AiCommon::$schemaSlug
		);
		wp_localize_script( 'aidb_js', 'aidb', $jsData );
	}

	/**
	 * Create the Wordpress admin menu items
	 *
	 * @return void
	 */
	public static function adminMenu()
	{
		global $submenu;
		add_menu_page( 'AiDb Options', 'AiDb', 'manage_options', 'appideas-wpdb-abstraction', array( 'AiWpView', 'mainMenuPage' ), 'dashicons-feedback' );
		add_submenu_page( 'appideas-wpdb-abstraction', 'AiDb Browse', 'Browse', 'manage_options', 'appideas-wpdb-abstraction-browse', array( 'AiWpView', 'browsePage' ) );
		add_submenu_page( 'appideas-wpdb-abstraction', 'AiDb Query', 'Query', 'manage_options', 'appideas-wpdb-abstraction-query', array( 'AiWpView', 'queryPage' ) );
		add_submenu_page( 'appideas-wpdb-abstraction', 'AiDb About', 'About', 'manage_options', 'appideas-wpdb-abstraction-about', array( 'AiWpView', 'aboutPage' ) );
		add_submenu_page( 'appideas-wpdb-abstraction', 'AiDb Docs', 'Docs', 'manage_options', 'appideas-wpdb-abstraction-docs', '' );
		

		// Override the title of the first item in the submenu so that the top-level and first item don't have the same title
		if( isset( $submenu['appideas-wpdb-abstraction'][0][0] ) )
		{
			$submenu['appideas-wpdb-abstraction'][0][0] = "Versions &amp; Options";
		}
	}

	
}