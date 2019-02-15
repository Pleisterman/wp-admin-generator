<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       Authorisation.php
        function:   handles: 
                        user authorisation for menus and tabs
*/

namespace PleistermanWpSimpleTranslator\Admin;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class Authorisation extends CommonClass {
    
    // members
    // members
        
    // is authorised
    public function isAuthorised( $capabilities ) {
        
        // current user has capabilities
        if( current_user_can( $capabilities ) ){
            // authorised
            return true;
        }
        
        // not authorised
        return false;
        
    }
    // is authorised
    
}
