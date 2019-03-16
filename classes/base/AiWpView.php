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
            </div>
        </div>
EOT;
		echo $returnValue;
    }
    
    /**
	 * Placeholder for the admin menu page
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
                    <p>Perform a database query</p>
                </div>
            </div>
        </div>
EOT;
		echo $returnValue;
	}
}