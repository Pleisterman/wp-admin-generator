<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       FormGenerator.php
        function:   Generates form html for admin pages
*/

namespace PleistermanWpAdminGenerator\Admin\HtmlGenerators;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class FormGenerator extends CommonClass {
    
    // members
    // members
        
    // generate settings form
    public function generate( $settingsId, $settings  ){
        
        // ? determine method
        $method = 'post';
        // ? determine action
        $action = 'options.php';
        // get Appname
        $appName = $this->common->getSetting( 'app-name' );
        // create group id
        $groupId = $appName . '-group-' . $settingsId;
        // create group name
        $groupName = $appName . '-' . $settingsId;
                
        // open form
        echo '<form method="' . $method . '" action="' . $action . '">';
        
            // set wordpress fields
            settings_fields( $groupId );
            // se wordpress sections
            do_settings_sections( $groupName ); 
            
            // create show submit
            $showSubmit = true;
            
            // submit is set and ! submit
            if( isset( $settings['submit'] ) && !$settings['submit'] ){
                // set show submit
                $showSubmit = false;
            }
            // submit is set and ! submit

            // create submit text
            $submitText = null;
            
            // text is set
            if( isset( $settings['submit-text'] ) ){
                // set submit text
                $submitText = $settings['submit-text'];
            }
            // text is set
                
            // create submit class
            $submitClass = null;
            
            // class is set
            if( isset( $settings['submit-class'] ) ){
                // set submit class
                $submitClass = $settings['submit-class'];
            }
            // class is set
               
            
            // add error message
            echo '<div id="error-message" class="error-message"></div>';
            
            
            // show submit
            if( $showSubmit ){
                // submit is set and ! submit
                if( isset( $settings['submit-as-button'] ) ){
                    // set show submit
                    echo '<input type="button" id="submit-button" ';
                    echo 'class="button button-primary ' . $submitClass . '" ';
                    echo 'value="' . __( $submitText, $this->common->getSetting( 'text-domain' ) ) . '" ';
                    echo '>';
                }
                else {
                    // add submit
                    submit_button( __( $submitText, $this->common->getSetting( 'text-domain' ) ), $submitClass );
                }
                // submit is set and ! submit
            }
            // show submit
                
        // close form
        echo '</form>';
        
    }	
    // generate settings form
    
}
