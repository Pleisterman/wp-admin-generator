<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       SanitizeEmail.php
        
*/

namespace PleistermanWpAdminGenerator\Admin\Sanitizers;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class SanitizeEmail extends CommonClass {
    
    // members
    // members
        
    // sanitize settings field
    public function sanitizeSettingsField( $settingsId, $field, $value ) {
        
        // has wordpress option sanitize type
        if( isset( $field['wp-sanitize-type'] ) ){
            // use wordpress option sanitize
            $value = sanitize_option( $field['wp-sanitize-type'], $value );
        }
        // has wordpress option sanitize type
                
        // type detection
        switch ( $field['args']['type'] ) {
            
            // text
            case 'text':    {
                // use wordpress sanitize 
                $value = sanitize_text_field( $value );
                
                // done
                break;
            }
            // email
            case 'email':    {
                
                // sanitize email
                $value = $this->sanitizeSettingsFieldEmail( $value );
                
                // done
                break;
            }
            // checkbox
            case 'checkbox':    {
            
                // done
                break;
            }
            // default
            default: {
                // log error
                error_log( 'sanitizeSettingsField, unknown field type: ' . $field['type'] );
            }
        }
        // type detection
        
        // return 
        return $value;
        
    }
    // sanitize settings field
  
    // sanitize settings field email
    private function sanitizeSettingsFieldEmail( $value ) {
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
    // sanitize settings field email
}
