<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       AjaxOptions.php
        function:   handles custom main 
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\Ajax;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class AjaxOptions extends CommonClass {
    
    // members
    // members
        
    // ajax
    public function ajax( $request ) {
    
        // $_POST action ! exists
        if( !isset( $_POST['action'] ) ){
            // debug 
            $this->common->debug( 'error', 'ajax invalid action not found ' );
            // invalid function
            die();
        }
        // $_POST action ! exists
        
        // $_POST optionId ! exists
        if( !isset( $_POST['optionId'] ) ){
            // debug 
            $this->common->debug( 'error', 'ajax invalid optionId not found ' );
            // invalid function
            die();
        }
        // $_POST optionId ! exists
        
        // $_POST value ! exists
        if( !isset( $_POST['value'] ) ){
            // debug 
            $this->common->debug( 'error', 'ajax invalid value not found ' );
            // invalid function
            die();
        }
        // $_POST value ! exists
       
        // get plugin id
        $pluginId = $this->common->getSetting( 'plugin-id' );
        // get options
        $settingsId = $pluginId . '-options';
        // get option
        $settings = get_option( $settingsId );
        
        // settings ! array
        if( !is_array( $settings ) ){
            // create empty settings
            $settings = array();
        }
        // settings ! array
        
        // set option value
        $settings[$_POST['optionId']] = $_POST['value'];
        
        // update settings
        update_option( $settingsId, $settings );
        
        // create data
        $data = array(
            "text"  => $_POST['value'],
            "settingsId"  => $settingsId
        );
        // create data
        
        // call ajax succes
        $request->ajaxSucces( $data );
            
    }
    // ajax

}
