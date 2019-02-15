<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       Sanitizer.php
        function:   handles: 
                        sanitising settings
        
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\Sanitizers;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class CustomSanitizer extends CommonClass {
    
    // members
    private $sanitizeFunctions = array(
    );
    // members
        
    // sanitize 
    public function sanitize( $settingsId, $label, $partId, $part, $value, $values ) {

        // debug 
        $this->common->debug( 'sanitize', 'custom sanitize: ' . $partId );
        
        // loop over sanitize
        foreach( $part['sanitize'] as $sanitizeOption ){

            // sanitize option exists
            if( isset( $this->sanitizeFunctions[$sanitizeOption] ) ){
                // get function
                $function = $this->sanitizeFunctions[$sanitizeOption];
                // call sanitize function
                $value = $this->$function( $value );
            }
            else {
                $this->common->debug( 'error', 'custom sanitize option not found: ' . $sanitizeOption );
            }
            // sanitize option exists
            
        }
        // loop over sanitize
        
        // return 
        return $value;
        
    }
    // sanitize 
  
}
