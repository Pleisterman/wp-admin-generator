<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       DeInstaller.php
        function:   handles: 
                        de-installation of the plugin
*/

namespace PleistermanWpSimpleTranslator\Admin;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Custom\Custom;

final class DeInstaller {
    
    // de-install the plugin
    static public function deInstall( ) {
        
        // create common
        $common = new Common();
        // create custom
        $custom = new Custom();
        // call custom
        $custom->deInstall();
        // debug 
        $common->debug( 'de-install', 'de-install-plugin' );
        
    }
    // de-install the plugin
    
}
