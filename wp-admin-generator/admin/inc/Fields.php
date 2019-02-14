<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       Fields.php
        function:   handles: 
                        register of page section fields
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Common\Common;
use PleistermanWpAdminGenerator\Admin\Base\CommonClass;
use PleistermanWpAdminGenerator\Admin\HtmlGenerators\HtmlGenerator;
use PleistermanWpAdminGenerator\Admin\Sanitizers\Sanitizer;
use PleistermanWpAdminGenerator\Admin\Validators\Validator;

class Fields extends CommonClass {
    
    // members
    private $htmlGenerator = null;
    private $groupName = null;
    private $fields = array();
    private $validator = null;
    private $sanitizer = null;
    // members
        
    // construct
    public function __construct( Common $common, HtmlGenerator $htmlGenerator ){
        
        // call parent constructor
        parent::__construct( $common );
        
        // create validator
        $this->validator = new Validator( $common );

        // create sanitizer
        $this->sanitizer = new Sanitizer( $common );

        // set html generator
        $this->htmlGenerator = $htmlGenerator;
    }
    // construct

    // register field
    public function register( $groupName, $sectionId, $fields  ) {
        
        // set groupName
        $this->groupName = $groupName;
        
        // loop over fields
        foreach ( $fields as $fieldId => $field ){
            
            // get label
            $label = isset( $field['label'] ) ? $field['label'] : '';            
            
            // add field
            add_settings_field( $fieldId,
                                $label,
                                array( $this, 'generate' ),
                                $groupName,
                                $sectionId,
                                array( 'fieldId' => $fieldId ) );
            // add field

            // debug 
            $this->common->debug( 'register-page', 'register field: ' . $fieldId );
            
            // add field
            $this->add( $fieldId, $field );
        }
        // loop over fields
        
    }
    // register field

    // add field
    private function add( $fieldId, $field ) {

        // add field
        $this->fields[$fieldId] = $field;
        
    }
    // add section
    
    // generate section
    public function generate( $args ) {
        
        // debug 
        $this->common->debug( 'register-page', 'generate field field: ' . json_encode( $args['fieldId'] ) );
        
        // create field options
        $fieldOptions = array (
            'group-name' => $this->groupName,
            'field-id'   =>  $args['fieldId'],
            'field' => $this->fields[$args['fieldId']]
        );
        // create field options

        // generate html
        $this->htmlGenerator->generateField( $fieldOptions );
        
    }
    // register fields
    
    // prepare save
    public function prepareSave( $input ) {
        
        // debug 
        $this->common->debug( 'save-page', 'prepare save input: ' . json_encode( $input ) );

        // Create our array for storing the validated options
        $output = array();

        // get saved options
        $savedOptions = $this->common->getOption( $this->groupName );
        
        // loop over fields
        foreach( $this->fields as $fieldId => $field ) {
            
            // loop over parts
            foreach( $field['parts'] as $partId => $part ) {
                
                // create key
                $key = $fieldId . '-' . strtolower( $partId );

                // part exists in input
                if( isset( $input[$key] ) ){
                    
                    // sanitisation
                    $sanitizedValue = $this->sanitizer->sanitize( $this->groupName, $field['label'], $partId, $part, $input[$key] );
                    // validation
                    $returnValue = $this->validator->validate( $this->groupName, $field['label'], $partId, $part, $sanitizedValue );
                    
                    // errors or no errors
                    if( $returnValue['error'] ){
                        // set output saved value
                        $output[$key] = $savedOptions[$key];
                    }
                    else {
                        // set output return value
                        $output[$key] = $returnValue['value'];
                    }
                    // errors or no errors
                }
                // part exists in input
            } 
            // loop over parts
        } 
        // loop over fields
        
        // debug 
        $this->common->debug( 'save-page', 'prepare save output: ' . json_encode( $output ) );

        // return output
        return $output;

    }
    // prepare save
    
}
