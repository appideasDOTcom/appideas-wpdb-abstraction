jQuery( document ).ready(
function( $ )
{
    // Change the link href and target on the documentation menu item
    var docsMenuItem = $( "ul#adminmenu a[href$='appideas-wpdb-abstraction-docs']" );
    $( docsMenuItem ).attr( 'href', aidb.url + '/docs/phpdoc/index.html' );
    $( docsMenuItem ).attr( 'target', '_blank' );
});