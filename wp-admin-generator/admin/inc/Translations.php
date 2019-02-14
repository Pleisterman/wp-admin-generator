<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       page.php
        function:   handles: 
                        register of page tabs, sections and fields
                        show page
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class Translations extends CommonClass {
    
    // members
    private $translationsPath = "/../../translations";
    // members
        
    // load
    public function load( ) {
        
        $translationsDir = dirname( plugin_basename( __FILE__ ) ) . $this->translationsPath;
        
        // load translations
        $result = load_plugin_textdomain( $this->common->getSetting( 'text-domain' ), false, $translationsDir );
        
        if( $result ){
            
            // debug 
            $this->common->debug( 'translations', 'Translations loaded' );
        }
        else {
            // debug 
            $this->common->debug( 'error', 'Translations not found dir: ' . $translationsDir );
        }
    }
    // load
    
}
