<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       DivDropdownGenerator.php
        function:   Generates dropdown with div elements, requires divDropdown.js
*/

namespace PleistermanWpAdminGenerator\Admin\HtmlGenerators\DropdownGenerators;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class DivDropdownGenerator extends CommonClass {
    
    // members
    private $rowProperties = array( 'style' );
    // members
        
    // generate dropdown
    public function generate( $listRows, $partId, $partName, $part, $savedValue ){
        
        // open main container
        echo '<div ';
        
        // create class
        $class = 'div-dropdown ';
        
        // class exists
        if( isset( $part['class'] ) ){

            // add class
            $class .= $part['class'];

        }
        // class exists            
        
        // add class
        echo ' class="' . $class . '" ';
            
        // close open main container
        echo '>';
        
            // open main container selection
            echo '<div ';
            
            // create class
            $selectionClass = 'div-dropdown-selection ';

            // selection-class exists
            if( isset( $part['selection-class'] ) ){

                // add class
                $selectionClass .= $part['selection-class'];

            }
            // selection-class exists            
        
            // add class
            echo ' class="' . $selectionClass . '" ';
        
            // close open main container selection, close main container selection
            echo '></div>';
                
            // container button
            echo '<div ';

            // create class
            $buttonClass = 'dashicons dashicons-arrow-down-alt2 div-dropdown-button ';

            // button-class exists
            if( isset( $part['button-class'] ) ){

                // add class
                $buttonClass .= $part['button-class'];

            }
            // button-class exists            
        
            // add class
            echo ' class="' . $buttonClass . '" ';
            
            // close open main container button, close main container button
            echo '></div>';
            
            // generate content
            $this->generateContent( $listRows, $partId, $partName, $part, $savedValue );

            // generate input
            $this->generateInput( $listRows, $partId, $partName, $savedValue );
            
        // close main container
        echo '</div>';
        
    }	
    // generate dropdown
       
    // generate content
    private function generateContent( $listRows, $partId, $partName, $part, $savedValue ){
        
        // open collapse container
        echo '<div class="div-dropdown-collapse-container" ';
       
        // close open collapse container
        echo '>';
            
            // open collapse container content
            echo '<div ';
                // create class
                $class = 'div-dropdown-collapse-container-content ';

                // class exists
                if( isset( $part['content-class'] ) ){

                    // add class
                    $class .= $part['content-class'];

                }
                // class exists            

                // add class
                echo ' class="' . $class . '" ';
                
            // close collapse container content
            echo '>';

                // generate rows
                $this->generateRows( $listRows, $part, $savedValue );
            
            // close collapse container content
            echo '</div>';
        
        // close collapse container
        echo '</div>';
    }	
    // generate content

    // generate rows
    private function generateRows( $listRows, $part ) {
        
            // loop over list rows
            foreach ( $listRows as $rowId => $rowOptions ){

                // open option
                echo '<div ';
                    
                    // add id
                    echo ' id="' . $rowId . '" ';

                    // create class
                    $class = 'div-dropdown-row ';

                    // part row class exists  
                    if( isset( $part['row-class'] ) ){

                        // add option class
                        $class .= $part['row-class'];

                    }
                    // part row class exists  
                    
                    // add class
                    echo ' class="' . $class . '" ';
                    
                    // add properties
                    $this->addRowProperties( $part, $rowOptions );

                echo '>';
                // close open option

                // text exists
                if( isset( $rowOptions['text'] ) ){

                    // options content
                    echo $rowOptions['text'];

                }
                // text exists            

                // close option
                echo '</div>';
                
            }
            // loop over list options
        
    }
    // generate rows
    
    // generate input
    private function generateInput( $listRows, $partId, $partName, $savedValue ){
        
        // create selection
        $selection = $savedValue;
        
        // empty selection
        if( empty( $selection ) ){

            // unset selection
            $selection = null;    
            
            // loop over list rows
            foreach ( $listRows as $rowId => $rowOptions ){
                
                // selection ! set
                if( !isset( $selection ) ){

                    // set selection
                    $selection = $rowId;

                }
                // selection ! set            
            }
            // loop over list rows
        }
        // empty selection
        
        // generate hidden input
        echo '<input type="hidden" ';
            echo ' id="' . $partId . '" ';
            echo ' name="' . $partName . '" ';
            echo ' value="' . $selection . '"';
        echo '>';
        // generate hidden input
        
        
    }
    // generate inout
    
    // add row properties
    private function addRowProperties( $part, $options ){

        // loop over properties
        for( $i = 0; $i < count( $this->rowProperties ); $i++ ){
            
            // property exists
            if( isset( $options[$this->rowProperties[$i]] ) ){

                // get property value
                $propertyValue = $options[$this->rowProperties[$i]];

                // add property id and value
                echo ' ' . $this->rowProperties[$i] . '="' . $propertyValue . '" ';
            }                
            // property exists

        }
        // loop over properties
    }
    // add row properties
    
        
}
