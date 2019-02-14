<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       DeInstaller.php
        function:   handles: 
                        de-installation of the plugin
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Common\Common;

final class DeInstaller {
    
    // de-install the plugin
    static public function deInstall( Common $common ) {
        
        // debug 
        $common->debug( 'de-install', 'de-install-plugin' );
        
    }
    // de-install the plugin
    
}
