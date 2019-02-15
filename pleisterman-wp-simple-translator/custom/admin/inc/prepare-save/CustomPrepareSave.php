<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       CustomPrepareSave.php
        function:   handles: 
                        prepare save is called when saving data
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\PrepareSave;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;
use PleistermanWpSimpleTranslator\Custom\Admin\PrepareSave\LanguagesPrepareSave;

class CustomPrepareSave extends CommonClass {
    
    // members
    private $prepareSaveFunctions = array(
        'languages' =>  'prepareSaveLanguages'
    );
    // members
        
    // prepare save settings field
    public function prepareSave( $fieldId, $field, $input ) {
    
        // prepare save not set
        if( !isset( $field['prepare-save'] ) ){
            // no prepare save
            return $input;
        }
        // prepare save not set
        
        // debug 
        //$this->common->debug( 'prepare-save', 'custom prepare save: ' . $fieldId );
        
        // create empty output
        $output = array();
        
        // prepare save option exists
        if( isset( $this->prepareSaveFunctions[$field['prepare-save']] ) ){
            // get function
            $function = $this->prepareSaveFunctions[$field['prepare-save']];
            // call prepare save function
            $output = $this->$function( $input );
        }
        else {
            $this->common->debug( 'error', 'custom prepare save option not found: ' . $part['prepare-save'] );
        }
        // prepare save option exists
            
        
        // debug 
        $this->common->debug( 'prepare-save', 'prepare save custom output: ' . json_encode( $output ) );
        
        
        // return 
        return $output;
        
    }
    // prepare save settings field
    
    // prepare save languages settings field
    public function prepareSaveLanguages( $input ) {
        // create languages prepare save
        $languagesPrepareSave = new LanguagesPrepareSave( $this->common );
        // prepare save
        return $languagesPrepareSave->prepareSave( $input );
    }
    // prepare save languages settings field
}
