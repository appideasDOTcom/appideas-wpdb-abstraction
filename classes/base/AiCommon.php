<?php
/**
 * A class to manage Common needs. For this project, this is used as a gateway to the database layer.
 */
require_once( dirname( dirname( __FILE__  ) ) . "/util/AiUtil.php" );
require_once( dirname( __FILE__ ) . "/AiDb.php" );
require_once( dirname( __FILE__ ) . "/AiMysql.php" );
/**
* A class to manage Common needs. For this project, this is used as a gateway to the database layer.
* 
* @package		Ai_DatabaseAbstraction
*/
class AiCommon
{
	// database connection info
	// reset these to match your server
	/**
	 * Database host name
	 * @var string
	 */
	protected $mDbHost = DB_HOST;
	
	/**
	 * Database schema name
	 * @var string
	 */
	protected $mDbName = DB_NAME;
	
	/**
	 * Database username
	 * @var string
	 */
	protected $mDbUser = DB_USER;
	
	/**
	 * Database password
	 * @var string
	 */
	protected $mDbPass = DB_PASSWORD;

	public static $schemaSlug = "aidb-wpdb-abstraction";
	
	/**
	 * Database system utilized if the argument to the constructor is blank. This only ever needs to get reset through the constructor for testing.
	 * Under normal circumstances, leave the constructor argument blank, and this will be used.
	 * Valid values with the default distribution are 'pgsql' 'mysql' or 'oracle'
	 * @var string
	 */
	public $mAutoDbMethod = "mysql";
	
	/**
	 * Database system utilized by instances of this class.
	 * @var string
	 */
	public $mDbMethod;
	
	/**
	 * An instance of the database
	 * @var AiDb
	 */
	public $mDb;


	/**
	* Class constructor.
	*
	* Creates an instance
	*
	* @since 	Version 20120328
	* @author	Version 20120328, costmo
	* @param		string		$dbMethod			Specify a different DBMS to use. This is for testing only. Normal use would have $mAutoDbMethod defined and this class instantiated with a blank constructor.
	*/
	function __construct( $dbMethod = null )
	{
		$this->mDbMethod = (null === $dbMethod) ? strtolower( $this->mAutoDbMethod ) : strtolower( $dbMethod );
		
		if( "mysql" === $this->mDbMethod )
		{
			$this->mDb = new AiMysql( $this->mDbHost, $this->mDbUser, $this->mDbPass, $this->mDbName );
			$this->mDb->connect();
		}
		else
		{
			echo "FATAL ERROR: '" . $this->mDbMethod . "' is an unknown database connector.
			I tried my best, but you fed me information that I don't comprehend.
			Please consult your system administrator.";
			exit();
		}
		
		// get our PHP version and define generic names for superglobal arrays
		$phpVer = phpversion();
		$split = explode( ".", $phpVer );
		$major = (int) $split[0];

		// force PHP version >= 5
		if( !$major || $major < 5 )
		{
			echo "Sorry, PHP version must be at least 5.
			Current version detected: " . $phpVer . "\n";
			exit();
		}

	} // end constructor

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

} // end Common
