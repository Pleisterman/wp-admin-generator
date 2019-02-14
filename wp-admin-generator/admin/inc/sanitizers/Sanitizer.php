<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       Sanitizer.php
        function:   handles: 
                        sanitising settings
        
*/

namespace PleistermanWpAdminGenerator\Admin\Sanitizers;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class Sanitizer extends CommonClass {
    
    // members
    private $sanitizeFunctions = array(
        'text'      =>  'sanitizeText',
        'checkbox'  =>  'sanitizeCheckbox',
        'email'     =>  'sanitizeEmail'
    );
    // members
        
    // sanitize 
    public function sanitize( $settingsId, $label, $partId, $part, $value ) {

        // debug 
        $this->common->debug( 'sanitize', 'sanitize', 'before' );
        $this->common->debug( 'sanitize', 'sanitize: ' . $partId );
        // debug 
        
        // has wordpress option sanitize type
        if( isset( $part['wp-sanitize-type'] ) ){
            // use wordpress option sanitize
            $value = sanitize_option( $part['wp-sanitize-type'], $value );
        }
        // has wordpress option sanitize type
           
        // ! has option sanitize
        if( !isset( $part['sanitize'] ) ){
            // done
            return $value;
        }
        // ! has option sanitize
        
        
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
                $this->common->debug( 'error', 'sanitize option not found: ' . $sanitizeOption );
            }
            // sanitize option exists
            
        }
        // loop over sanitize
        
        // debug 
        $this->common->debug( 'sanitize', 'sanitize', 'after' );
        
        // return 
        return $value;
        
    }
    // sanitize 
  
    // sanitize text
    private function sanitizeText( $value ) {

        // use wordpress sanitize 
        $value = sanitize_text_field( $value );
        
        // return value
        return $value;
    }
    // sanitize text
        
    // sanitize text
    private function sanitizeCheckbox( $value ) {

        // value exists
        if( $value ){
            // return 
            return true;
        }
        // value exists
        
        // return 
        return false;
    }
    // sanitize text
        
    // sanitize email
    private function sanitizeEmail( $value ) {
        
        // sanitize email 
        $sanitizedValue = sanitize_email( $value );
        // sanitized value not empty
        if( !empty( $sanitizedValue ) ){
            // set value
            $value = $sanitizedValue;
        }
        else {
            // sanitize as text
            $value = sanitize_text_field( $value );
        }
        // sanitized value not empty
        
        // return
        return $value;
    }
    // sanitize email
}
