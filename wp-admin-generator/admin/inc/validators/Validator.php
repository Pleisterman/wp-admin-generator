<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       Validator.php
        function:   handles: 
                        validation of settings 
*/

namespace PleistermanWpAdminGenerator\Admin\Validators;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class Validator extends CommonClass {
    
    // members
    private $validateFunctions = array(
        'email'             =>  'valdateEmail',
        'positive-number'   =>  'validatePositiveNumber',
        'not-empty'         =>  'validateNotEmpty'
    );
    // members
        
    // validate settings field
    public function validate( $settingsId, $label, $partId, $part, $value ) {
    
        // debug 
        $this->common->debug( 'validate', 'validate', 'before' );
        $this->common->debug( 'validate', 'validate: ' . $partId );
        // debug 
        
        // create return value
        $returnValue = array( 
            'error' => false,
            'value' => $value
        );
        // create return value
        
        // ! field has validation
        if( !isset( $part['validate'] ) ){
            // no validation
            return $returnValue;
        }
        // ! field has validation
        
        // loop over validate
        foreach( $part['validate'] as $validateOption ){

            // no error
            if( !$returnValue['error'] ){
                
                // validate option exists
                if( isset( $this->validateFunctions[$validateOption] ) ){
                    
                    // get function
                    $function = $this->validateFunctions[$validateOption];
                    // call validate function
                    $returnValue['error'] = $this->$function( $settingsId, $label, $partId, $part, $value );
                    
                }
                else {
                    $this->common->debug( 'error', 'validate option not found: ' . $validateOption );
                }
                // sanitize option exists

            }
            // no error
        }
        // loop over validate
        
        // no error
        if( !$returnValue['error'] ){
            // set return value
            $returnValue['value'] = $value;
        }
        else {
            // debug 
            $this->common->debug( 'validate', 'error: ' . $returnValue['error'] );
        }
        // no error
        
        // debug 
        $this->common->debug( 'validate', 'validate', 'after' );
        
        // return 
        return $returnValue;
        
    }
    // validate settings field
 
    // validate email
    private function validateEmail( $settingsId, $label, $partId, $part, $value ) {
        
        // check email
        if( ! is_email( $value ) ){
            
            // get textDomain
            $textDomain = $this->common->getSetting('text-domain');
            // get error text
            $errorText = __( 'Enter a valid email adress.', $textDomain );
            // add spacing
            $errorText .= '&nbsp&nbsp&nbsp';
            // add field prefix to error
            $errorText .= __( 'At:', $textDomain ); 
            // add field to error
            $errorText .= '&nbsp' . $label; 
            
            // add error
            add_settings_error( $settingsId, $label, $partId, $errorText );
            // return error
            return true;
        }
        // check email
        
        // return valid
        return false;
    }
    // validate email

    // validate positive number
    private function validatePositiveNumber( $settingsId, $label, $partId, $part, $value ) {
        
        // check email
        if( !is_numeric ( $value ) || !intVal( $value ) < 0 ){
            
            // get error text
            $errorText = __( 'Enter a valid valid postive number at: ', $this->common->getSetting('text-domain') );
            // add field to error
            $errorText .= '  ' . $partId; 
            
            // add error
            add_settings_error( $settingsId, $partId, $errorText );
            
            // return with error
            return true;
        }
        // check email
        
        // return valid
        return false;
    }
    // validate positive number
    
    // validate not empty
    private function validateNotEmpty( $settingsId, $label, $partId, $part, $value ) {
        
        // check empty
        if( empty ( $value ) ){
            // get error translation
            $error = __( 'The value %s cannot be empty.', $this->common->getSetting('text-domain') );
            // replace %s with part name
            $error = sprintf( $error, __( $partId, $this->common->getSetting('text-domain') ) );
            
            // add error
            add_settings_error( $settingsId, $partId, $error );
            // done empty error
            return true;
        }
        // check empty
        
        // done not empty
        return false;
        
    }
    // validate not empty
    
}
