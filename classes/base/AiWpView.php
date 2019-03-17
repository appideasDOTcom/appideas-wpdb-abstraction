<?php
/**
 * Wordpress views
*/
/**
 * Wordpress views
 * 
 * @author Chris ostmo
 * @package		Ai_DatabaseAbstraction
 */
class AiWpView
{

    /**
	 * Placeholder for the admin menu page
	 *
	 * @return void
	 */
	public static function mainMenuPage()
	{
        $returnValue = <<<EOT
        <div id="aidb">
            <div class="aidb-container">
                <div class="aidb-title wrap">
                    <h1 class="wp-heading-inline">The APPideas Wordpress Database Abstraction</h1>
                </div>
                <div class="aidb-content wrap">
                    <p>Versions and options.</p>
                </div>
            </div>
        </div>
EOT;
		echo $returnValue;
    }
    
    /**
	 * Placeholder for the query screen
	 *
	 * @return void
	 */
	public static function queryPage()
	{
        $returnValue = <<<EOT
        <div id="aidb">
            <div class="aidb-container">
                <div class="aidb-title wrap">
                    <h1 class="wp-heading-inline">The APPideas Wordpress Database Abstraction</h1>
                </div>
                <div class="aidb-content wrap">
                    <p>Perform a database query.</p>
                </div>
            </div>
        </div>
EOT;
		echo $returnValue;
    }
    
    /**
	 * Placeholder for the browse screen
	 *
	 * @return void
	 */
	public static function browsePage()
	{
        $returnValue = <<<EOT
        <div id="aidb">
            <div class="aidb-container">
                <div class="aidb-title wrap">
                    <h1 class="wp-heading-inline">The APPideas Wordpress Database Abstraction</h1>
                </div>
                <div class="aidb-content wrap">
                    <p>Find your data. Select a table.</p>
                </div>
            </div>
        </div>
EOT;
		echo $returnValue;
    }
    
    /**
	 * Placeholder for the about screen
	 *
	 * @return void
	 */
	public static function aboutPage()
	{
        $returnValue = <<<EOT
        <div id="aidb">
            <div class="aidb-container">
                <div class="aidb-title wrap">
                    <h1 class="wp-heading-inline">The APPideas Wordpress Database Abstraction</h1>
                </div>
                <div class="aidb-content wrap">
                    <p>About the database abstraction layer.</p>
                </div>
            </div>
        </div>
EOT;
		echo $returnValue;
	}
}