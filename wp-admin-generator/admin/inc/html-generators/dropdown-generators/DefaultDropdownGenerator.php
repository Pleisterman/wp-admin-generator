<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       DefaultDropdownGenerator.php
        function:   Generates default dropdown
*/

namespace PleistermanWpAdminGenerator\Admin\HtmlGenerators\DropdownGenerators;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class DefaultDropdownGenerator extends CommonClass {
    
    // members
    private $mainProperties = array( 'class', 'style' );
    // members

    // generate dropdown
    public function generate( $listRows, $partId, $partName, $part, $savedValue ){
        
        // has label
        if( isset( $part['label'] ) ){
            // open container
            echo '<span class="form-label select-label" >';
                echo $part['label'];
            echo '</span>';
            // close container
        }
        // has label
        
        // open select
        echo '<select ';
            // add name
            echo ' name="' . strtolower( $partName ) . '" ';
            // add id
            echo ' id="' . strtolower( $partId ) . '" ';

            $this->addProperties( $this->mainProperties, $part );
            
        echo '>'; 
        // open select
     
            // generate select rows
            $this->generateSelectRows( $listRows, $part, $savedValue );
        
        // close select
        echo '</select>'; 
        // close select
        
    }
    // generate dropdown

    // generate select rows
    private function generateSelectRows( $listRows, $part, $savedValue ) {
        
        // loop over list options
        foreach ( $listRows as $optionId => $options ){
            
            // open option
            echo '<option';

            // add value
            echo ' value="' . $optionId . '" ';
            
            // index is value
            if( $optionId == $savedValue ){
                // selected
                echo ' selected ';
            }
            // index is value

            // part row class exists  
            if( isset( $part['row-class'] ) ){

                // set option class
                echo ' class="' . $part['row-class'] . '" ';

            }
            // part item class exists  
            
            echo '>';
            // close open option
        
            // text exists
            if( isset( $options['text'] ) ){
                
                // options content
                echo $options['text'];
                
            }
            // text exists            

            // close option
            echo '</option>';
        }
        // loop over list options
        
    }
    // generate image select input rows
    
    // add properties
    private function addProperties( $properties, $options ){

        // loop over properties
        for( $i = 0; $i < count( $properties ); $i++ ){
            
            // property exists
            if( isset( $options[$properties[$i]] ) ){
                
                // add property id and value
                echo ' ' . $properties[$i] . '="' . $options[$properties[$i]] . '" ';
            }
            // property exists
        }
        // loop over properties
    }
    // add properties
    
}
