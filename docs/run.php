#!/usr/bin/php -q
<?php
/**
 * Command line script to generate documentation
*/
$cmd = "phpdoc --force  --sourcecode --title 'APPideas Wordpress Database Abstraction' --directory ../classes --target phpdoc";

system( $cmd );

// $fp = fopen( "phpdoc/css/template.css", "a" );

// $css = "
// li#charts-menu, li#reports-menu, footer.row-fluid section.span4
// {
// 	display: none;
// }
// ";
// fwrite( $fp, $css );

