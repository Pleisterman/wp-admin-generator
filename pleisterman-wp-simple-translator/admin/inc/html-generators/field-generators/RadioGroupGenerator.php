<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       DropdownGenerator.php
        function:   Generates dropdown html for admin pages
*/

namespace PleistermanWpSimpleTranslator\Admin\HtmlGenerators\FieldGenerators;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class RadioGroupGenerator extends CommonClass {
    
    // members
    // members
        
    // generate radio group 
    public function generate( $id, $partName, $part, $savedValue ){
        
        // open group div
        echo '<div ';
        
            // class exists
            if( isset( $part['class'] ) ){
                // set class
                echo ' class="' . $part['class'] . '" ';
            }
            // class exists
            
        // close open group div    
        echo '>'; 
        
        // generate group items
        $this->generateGroupItems(  $id, $partName, $part, $savedValue );
        
        // close group div
        echo '</div>'; 
    }	
    // generate radio group
        
    // generate radio group items 
    public function generateGroupItems( $id, $partName, $part, $savedValue ){
    
        // values ! exists
        if( !isset( $part['values'] ) ){
            // done no values
            echo ' no values ';
        }
        // values ! exists
        
        // get text domain
        $textDomain = $this->common->getSetting( 'text-domain' );
        
        // loop over values
        foreach( $part['values'] as $valueId => $valueText ){
            
            // open item div
            echo '<div ';

                // item-class exists
                if( isset( $part['class'] ) ){
                    // set item-class
                    echo ' class="' . $part['item-class'] . '" ';
                }
                // item-class exists

            // close open item div    
            echo '>'; 
            
                // open item
                echo '<input type="radio"';

                    // add id
                    echo ' id="' . $id . '" ';
                    // add name
                    echo ' name="' . $partName . '" ';
                    // add value
                    echo ' value="' . $valueId . '" ';

                    // input class exists
                    if( isset( $part['input-class'] ) ){
                        // set input class
                        echo ' class="' . $part['input-class'] . '" ';
                    }
                    // input class exists

                    // saved value is empty
                    if( empty( $savedValue ) ){
                        // set saved value
                        $savedValue = $valueId;
                    }
                    // saved value is empty
                    
                    // valueId = saved value
                    if( $valueId == $savedValue ){
                        // add selected
                        echo ' checked';
                    }
                    // valueId = saved value
                    
                // close open item    
                echo '>'; 

                // open label
                echo '<label for="' . $valueId . '" ';

                    // label class exists
                    if( isset( $part['label-class'] ) ){
                        // set label class
                        echo ' class="' . $part['label-class'] . '" ';
                    }
                    // label class exists

                // close open label
                echo '>';
                    // add text
                    echo __( $valueText, $textDomain );
                // close label
                echo '</label>';

            // close item div
            echo '</div>'; 
        }
        // loop over values
        
        
    }	
    // generate radio group items 
        
}
