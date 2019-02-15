<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       Validator.php
        function:   handles: 
                        validation of settings 
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\Validators;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class CustomValidator extends CommonClass {
    
    // members
    private $validateFunctions = array(
    );
    // members
        
    // validate settings field
    public function validate( $settingsId, $label, $partId, $part, $value, $values ) {
    
        // debug 
        $this->common->debug( 'validate', 'custom validate: ' . $partId );
        
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
                    // debug
                    $this->common->debug( 'error', 'custom validate option not found: ' . $validateOption );
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
            $this->common->debug( 'validate', 'custom validate error: ' . $returnValue['error'] );
        }
        // no error
        
        // return 
        return $returnValue;
        
    }
    // validate settings field
    
}
