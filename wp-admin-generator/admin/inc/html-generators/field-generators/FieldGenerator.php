<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       FieldGenerator.php
        function:   Generates field html for admin pages
*/

namespace PleistermanWpAdminGenerator\Admin\HtmlGenerators\FieldGenerators;

use PleistermanWpAdminGenerator\Common\Common;
use PleistermanWpAdminGenerator\Admin\Base\CommonClass;
use PleistermanWpAdminGenerator\Admin\HtmlGenerators\HtmlGenerator;
use PleistermanWpAdminGenerator\Admin\HtmlGenerators\DropdownGenerators\DropdownGenerator;
use PleistermanWpAdminGenerator\Admin\HtmlGenerators\FieldGenerators\RadioGroupGenerator;

class FieldGenerator extends CommonClass {
    
    // members
    private $imageUrl = '';
    private $dropdownGenerator = null;
    private $radioGroupGenerator = null;
    private $inputGeneratorFunctions = array(
        'hidden'    =>  'generateHidden',
        'text'      =>  'generateText',
        'textarea'  =>  'generateTextArea',
        'email'     =>  'generateText',
        'checkbox'  =>  'generateCheckbox',
        'radio-group'  =>  'generateRadioGroup',
        'dropdown'  =>  'generateDropdown'
    );
    private $savedValues = array();
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

        // create html generator classes
        $this->dropdownGenerator = new DropdownGenerator( $this->common ); 
        $this->radioGroupGenerator = new RadioGroupGenerator( $this->common ); 
        // create html generator classes
    }
    // construct

    // set image url
    public function setImageUrl( $imageUrl ){
        
        // set image url
        $this->imageUrl = $imageUrl;
        
    }
    // set image url
        
    // set lists
    public function setLists( $lists ){
        
        // set lists of dropdown generator
        $this->dropdownGenerator->setLists( $lists );
        
    }	
    // set lists
    
    // load saved values
    public function loadSavedValues( $optionId ){
        
        // get saved options
        $savedValues = $this->common->getOption( $optionId  );
        
        // saved values exist
        if( $savedValues ){
            // set saved values
            $this->savedValues = $savedValues;
        }
        // saved values exist
        
        // debug 
        $this->common->debug( 'generate', 'generate field groupName: ' . $optionId );
        $this->common->debug( 'generate', 'generate field saved values: ' . json_encode( $savedValues ) );
        
    }	
    // load saved values
    
    // generate field
    public function generate( HtmlGenerator $htmlGenerator, $fieldOptions ){
        
        // loop over parts
        foreach ( $fieldOptions['field']['parts'] as $partId => $part ){
            
            // generate part
            $this->generatePart( $htmlGenerator, $fieldOptions['group-name'], $fieldOptions['field-id'], $partId, $part );
            
        }
        // loop over parts
        
    }	
    // generate settings field
        
    // generate part
    private function generatePart( $htmlGenerator, $groupName, $fieldId, $partId, $part ){
        
        // create part name
        $partName = $groupName . '['. $fieldId . '-' . $partId . ']';
        // get saved value
        $savedValue = isset( $this->savedValues[$fieldId . '-' . $partId] ) ? $this->savedValues[$fieldId . '-' . $partId] : null;

        // debug 
        $this->common->debug( 'generate', 'generate field partName: ' . $partName );

        // part element exists
        if( isset( $part['element'] ) ) {
            
            // open container element
            $htmlGenerator->openContainer( $part );
        }
        // part element exists

        // loop over parts
        foreach ( $part['elements'] as $element ){
            
            // generate part
            $this->generatePartContent( $htmlGenerator, $partId, $partName, $element, $savedValue );
            
        }
        // loop over parts
        

        // part element exists
        if( isset( $part['element'] ) ) {
            
            // close container element
            $htmlGenerator->closeContainer( $part );
            
        }
        // part element exists
        
    }	
    // generate settings field
    
    // generate part content
    private function generatePartContent( $htmlGenerator, $partId, $partName, $part, $savedValue ){

        // input type ! exists
        if( !isset( $part['input'] ) ) {
            
            // generate before content
            $htmlGenerator->generateElement( $part );
            
            // done
            return;
        }
        // input type ! exists
       
        // generator function ! exists
        if( !isset( $this->inputGeneratorFunctions[$part['input']] ) ){
            
            // debug 
            $this->common->debug( 'error', ' genererate field part unknown input type ' . ' partId: ' . $partId );
            
            // done with error
            return;
            
        }
        // generator function ! exists
            
        // use saved value exists and is false
        if( isset( $part['use-saved-value'] ) && !$part['use-saved-value'] ){

            // unset saved value
            $savedValue = null;
        }
        // use saved value exists and is false

        // default value exists
        if( isset( $part['default-value'] ) && empty( $savedValue ) ) {
            
            // get default value
            $defaultValue = $part['default-value'];
            
            // is string
            if( is_string( $defaultValue ) ){
                // translate
                $defaultValue = __( $defaultValue, $this->common->getSetting( 'text-domain' ) );
            }
            // is string
                    
            // set savedValue
            $savedValue = $defaultValue;
        }
        // default value exists
                
        // get function
        $function = $this->inputGeneratorFunctions[$part['input']];
            
        // debug 
        $this->common->debug( 'generate', 'generate field savedValue: ' . $savedValue );

            // call input generator function
            $this->$function( $partId, $partName, $part, $savedValue );
            
        
    }	
    // generate part content
    
    // generate text input
    private function generateHidden( $partId, $name, $part, $savedValue ) {

        // create input
        echo '<input type="hidden" ';
            // add name
            echo ' name="' . strtolower( $name ) . '" ';
            // add id
            echo ' id="' . strtolower( $partId ) . '" ';
            // add value
            echo 'value="' . $savedValue . '" ';
            
        echo '>'; 
        // create input
        
    }
    // generate text input
    
    // generate text input
    private function generateText( $partId, $name, $part, $savedValue ) {

        // create input
        echo '<input type="text" ';
            // add name
            echo ' name="' . strtolower( $name ) . '" ';
            // add id
            echo ' id="' . strtolower( $partId ) . '" ';
            // add value
            echo ' value="' . $savedValue . '" ';
            
            // placeholder exists
            if( isset( $part['placeholder'] ) ){
                // set placeholder
                echo ' placeholder="' . __( $part['placeholder'], $this->common->getSetting( 'text-domain' ) ). '" ';
            }
            // placeholder exists
            
            // size exists
            if( isset( $part['size'] ) ){
                // set size
                echo ' size="' . $part['size'] . '" ';
            }
            // size exists
            
        echo '>'; 
        // create input
        
    }
    // generate text input
    
    // generate text area input
    private function generateTextArea( $partId, $name, $part, $savedValue ) {

        // open textarea
        echo '<textarea ';
            // add name
            echo ' name="' . strtolower( $name ) . '" ';
            // add id
            echo ' id="' . strtolower( $partId ) . '" ';
            
            // placeholder exists
            if( isset( $part['placeholder'] ) ){
                // set placeholder
                echo ' placeholder="' . __( $part['placeholder'], $this->common->getSetting( 'text-domain' ) ). '" ';
            }
            // placeholder exists
            
            // rows exists
            if( isset( $part['rows'] ) ){
                // set rows
                echo ' rows="' . $part['rows'] . '" ';
            }
            // rows exists
            
            // cols exists
            if( isset( $part['cols'] ) ){
                // set cols
                echo ' cols="' . $part['cols'] . '" ';
            }
            // cols exists
            
        echo '>'; 
        // close open textarea
        
            // add value
            echo $savedValue;
            
        echo '</textarea>'; 
        // create input
    }
    // generate text area input

    // generate checkbox input
    private function generateCheckbox( $partId, $name, $part, $value ) {

        // has label
        if( isset( $part['label'] ) ){
            // open container
            echo '<span class="form-label checkbox-label" >';
                echo $part['label'];
            echo '</span>';
            // close container
        }
        // has label
        
        // create input
        echo '<input type="checkbox" ';
            // add name
            echo ' name="' . strtolower( $name ) . '" ';
            // add id
            echo ' id="' . strtolower( $partId ) . '" ';
            // value exists
            if( $value ){
                // check checkbox
                echo ' checked ';
            }
            // value exists
        echo '>'; 
        // create input
        
    }
    // generate checkbox input

    // generate radio group input
    private function generateRadioGroup( $partId, $name, $part, $savedValue ) {
        
        // generate radio group 
        $this->radioGroupGenerator->generate( $partId, $name, $part, $savedValue );
                
    }
    // generate radio group  input
    
    // generate dropdown input
    private function generateDropdown( $partId, $name, $part, $savedValue ) {
        
        // generate dropdown
        $this->dropdownGenerator->generate( $partId, $name, $part, $savedValue );
                
    }
    // generate dropdown input
}
