<?php
/**
 * Core wordpress functionality helper functions
*/
/**
 * Core wordpress functionality helper functions
 * 
 * @author Chris ostmo
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

		// Record version 1
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
	 * Actions on plugin initialization
	 *
	 * @return void
	 */
	public static function wpInit()
	{
		// add_action( 'wp_enqueue_scripts', array( 'AiWpHelper', 'wpLoadCss' ) );
		add_action( 'admin_enqueue_scripts', array( 'AiWpHelper', 'wpLoadCss' ) );

		add_action( 'admin_menu', array( 'AiWpHelper', 'adminMenu' ) );
	}

	public static function wpLoadCss()
	{
		$pluginBaseUrl = dirname( dirname( plugin_dir_url( __FILE__ ) ) );
		$cssUrl = $pluginBaseUrl . "/css/aidb.css";

		$path = dirname( dirname( plugin_dir_path( __FILE__ ) ) );
		$pluginData = get_plugin_data( $path . "/appideas-wpdb-abstraction.php" );

		wp_register_style( 'aidb', $cssUrl, false, $pluginData['Version'], 'all' );
		wp_enqueue_style( 'aidb' );
	}

	/**
	 * The Wordpress admin menu
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
		

		// Override the title of the first item in the submenu so that the top-level and first item don't have the same title
		if( isset( $submenu['appideas-wpdb-abstraction'][0][0] ) )
		{
			$submenu['appideas-wpdb-abstraction'][0][0] = "Versions &amp; Options";
		}
	}

	
}