<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       ElementGenerator.php
        function:   Generates html elements for admin pages
*/

namespace PleistermanWpAdminGenerator\Admin\HtmlGenerators;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class ElementGenerator extends CommonClass {
    
    // members
    private $imageUrl = '';
    private $elementProperties = array( 'id', 'name', 'href', 'type', 'src', 'value', 'class', 'style' );
    // members
        
    // set image url
    public function setImageUrl( $imageUrl ){
        
        // set image url
        $this->imageUrl = $imageUrl;
        
    }
    // set image url
        
    // generate element
    public function generate( $options, $open = true, $close = true ){
    
        // ! element type exists
        if( !isset( $options['element'] ) ){
            // debug 
            $this->common->debug( 'generate', 'generate element not found options: ' . json_encode( $options ) );

            // return with error
            return;
        }
        // ! element type exists

        // options container exists
        if( isset( $options['container'] ) ) {
            // create container
            $this->createContainer( $options );
            // done
            return;
        }   
        // options container exists
        
        
        // open container
        $this->openContainer( $options );
        
        // add text
        $this->addText( $options );
        
        // close container
        $this->closeContainer( $options );
            
    }        
    // generate element

    // create container
    public function createContainer( $options ){

        // options container open
        if( $options['container'] == 'open' ) {
            // open container
            $this->openContainer( $options );
            // add text
            $this->addText( $options );
        }   
        // options container open

        // options container close
        if( $options['container'] == 'close' ) {
            // close container
            $this->closeContainer( $options );
        }   
        // options container close
        
    }    
    // create container
    
    // open container
    public function openContainer( $options ){
        
        // ! element type exists
        if( !isset( $options['element'] ) ){
            // debug 
            $this->common->debug( 'generate', 'open container element not found options: ' . json_encode( $options ) );

            // return with error
            return;
        }
        // ! element type exists

        // open element
        echo '<';
            // add element
            echo $options['element'];
        
            // add properties
            $this->addProperties( $options );
            
        // close open element
        echo '>';
        
    }
    // open container
    
    // add properties
    private function addProperties( $options ){

        // loop over properties
        for( $i = 0; $i < count( $this->elementProperties ); $i++ ){
            // property exists
            if( isset( $options[$this->elementProperties[$i]] ) ){
                
                // get property value
                $propertyValue = $options[$this->elementProperties[$i]];
                
                // is src
                if( $this->elementProperties[$i] == 'src' ){
                    // add image url to source
                    $propertyValue = $this->imageUrl . $propertyValue;
                }
                // is src
                
                // add property id and value
                echo ' ' .$this->elementProperties[$i] . '="' . $propertyValue . '" ';
            }
            // property exists
        }
        // loop over properties
    }
    // add properties

    // add text
    public function addText( $options ){

        // text exists
        if( isset( $options['text'] ) ){
            // add text
            echo __( $options['text'], $this->common->getSetting( 'text-domain' ) );
        }
        // text exists
    }
    // add text

    // close container
    public function closeContainer( $options ){

        // close element
        echo '</' . $options['element'] . '>';
    }
    // close container


}
