<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       TitleGenerator.php
        function:   Generates title and sub title html for admin pages
*/

namespace PleistermanWpAdminGenerator\Admin\HtmlGenerators;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class TitleGenerator extends CommonClass {
    
    // members
    // members
        
    // generate settings title
        public function generateTitle( ){
        
        // create title html
 	echo '<h2>' . __( $this->common->getSetting( 'app-title' ), $this->common->getSetting( 'text-domain' ) ) . '</h2>';
        
    }	
    // generate settings title
    
    // generate settings sub title
    public function generateSubTitle( $settings ){
        
        // sub title ! exists
        if( !isset( $settings['sub-title'] ) ){
            // no sub title
            return;
        }
        // sub title ! exists
        
        // open sub title 
        echo '<span style="margin-top: 2em; margin-bottom: 2em;"';
        
            // open class
            echo ' class="' . $this->common->getSetting( 'app-name' ) . '-sub-title ';
        
                // class exists
                if( isset( $settings['sub-title-class'] ) ){
                    // add class
                    echo $class . ' ';
                }
                // class exists

            // close class
            echo '" ';

        // close open sub title 
        echo '>';
        
            // create title text
            echo __( $settings['sub-title'], $this->common->getSetting( 'text-domain' ) );
        
        // close sub title 
        echo '</span>';

    }	
    // generate settings sub title
    
}
