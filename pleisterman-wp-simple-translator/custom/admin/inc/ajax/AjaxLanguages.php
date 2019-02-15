<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       AjaxLanguages.php
        function:   handles ajax calls for languages
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\Ajax;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class AjaxLanguages extends CommonClass {
    
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
        $settingsId = $pluginId . '-languages';
        // get option
        $settings = get_option( $settingsId );
        
        
        // settings ! array
        if( !is_array( $settings ) || !isset( $settings['language-list'] ) ){
            // debug 
            $this->common->debug( 'error', 'ajax settings is not an array or empty ' );
            // invalid function
            die();
        }
        // settings ! array
        
        // action update-active
        if( isset( $_POST['action'] ) && $_POST['action'] == 'update-active' ){

            // update active
            $this->updateActive( $settingsId, $settings, $request );
            
        }
        // action update-active
        
        // action update-default
        if( isset( $_POST['action'] ) && $_POST['action'] == 'update-default' ){

            // update default
            $this->updateDefault( $settingsId, $settings, $request );
            
        }
        // action update-default
        
        // action update-input
        if( isset( $_POST['action'] ) && $_POST['action'] == 'update-input' ){

            // update input
            $this->updateInput( $settingsId, $settings, $request );
            
        }
        // action update-input
        
        // action update-slug
        if( isset( $_POST['action'] ) && $_POST['action'] == 'update-slug' ){

            // update slug
            $this->updateSlug( $settingsId, $settings, $request );
            
        }
        // action update-slug
        
    }
    // ajax
    
    // private 
    private function updateActive( $settingsId, $settings, $request ) {
        
        // get language list
        $languageList = json_decode( $settings['language-list'], true );
            
        // create language found
        $languageFound = false;

        // loop over language list
        for( $i = 0; $i < count( $languageList ); $i++ ){
            // is language
            if( isset( $_POST['language'] ) && $_POST['language'] == $languageList[$i]['id'] ){
                // set language found
                $languageFound = true;
            }
            // is language
        }
        // loop over language list

        // language found
        if( $languageFound ){
            // loop over language list
            for( $i = 0; $i < count( $languageList ); $i++ ){
                // is language / else
                if( isset( $_POST['language'] ) && $_POST['language'] == $languageList[$i]['id'] ){
                    
                    if( $_POST['value'] == 'true' ){
                        // set active
                        $languageList[$i]['active'] = true;
                        
                    }
                    else {
                        // unset active
                        unset( $languageList[$i]['active'] );
                    }
                    
                }
                // is language / else
            }
            // loop over language list

            // set option value
            $settings['language-list'] = json_encode( $languageList );

            // update settings
            update_option( $settingsId, $settings );

            // debug 
            $this->common->debug( 'error', 'saved slug' );

        }
        // language found
            
        // create data
        $data = array(
            "text"  => 'ok',
            "settingsId"  => $settingsId
        );
        // create data
        
        // call ajax succes
        $request->ajaxSucces( $data );
            
    }
    private function updateDefault( $settingsId, $settings, $request ) {
        
        // get language list
        $languageList = json_decode( $settings['language-list'], true );
            
        // create language found
        $languageFound = false;

        // loop over language list
        for( $i = 0; $i < count( $languageList ); $i++ ){
            // is language
            if( isset( $_POST['value'] ) && $_POST['value'] == $languageList[$i]['id'] ){
                // set language found
                $languageFound = true;
            }
            // is language
        }
        // loop over language list

        // language found
        if( $languageFound ){
            // loop over language list
            for( $i = 0; $i < count( $languageList ); $i++ ){
                // is language / else
                if( isset( $_POST['value'] ) && $_POST['value'] == $languageList[$i]['id'] ){
                    $languageList[$i]['default'] = true;
                }
                else {
                    unset( $languageList[$i]['default'] );
                }
                // is language / else
            }
            // loop over language list

            // set option value
            $settings['language-list'] = json_encode( $languageList );

            // update settings
            update_option( $settingsId, $settings );

            // debug 
            $this->common->debug( 'error', 'saved default' );

        }
        // language found
            
        // create data
        $data = array(
            "text"  => 'ok',
            "settingsId"  => $settingsId
        );
        // create data
        
        // call ajax succes
        $request->ajaxSucces( $data );
            
    }
    private function updateInput( $settingsId, $settings, $request ) {
        
        // get language list
        $languageList = json_decode( $settings['language-list'], true );
            
        // create language found
        $languageFound = false;

        // loop over language list
        for( $i = 0; $i < count( $languageList ); $i++ ){
            // is language
            if( isset( $_POST['value'] ) && $_POST['value'] == $languageList[$i]['id'] ){
                // set language found
                $languageFound = true;
            }
            // is language
        }
        // loop over language list

        // language found
        if( $languageFound ){
            // loop over language list
            for( $i = 0; $i < count( $languageList ); $i++ ){
                // is language / else
                if( isset( $_POST['value'] ) && $_POST['value'] == $languageList[$i]['id'] ){
                    $languageList[$i]['input'] = true;
                }
                else {
                    unset( $languageList[$i]['input'] );
                }
                // is language / else
            }
            // loop over language list

            // set option value
            $settings['language-list'] = json_encode( $languageList );

            // update settings
            update_option( $settingsId, $settings );

            // debug 
            $this->common->debug( 'error', 'saved input' );

        }
        // language found
            
        // create data
        $data = array(
            "text"  => 'ok',
            "settingsId"  => $settingsId
        );
        // create data
        
        // call ajax succes
        $request->ajaxSucces( $data );
            
    }
    private function updateSlug( $settingsId, $settings, $request ) {
        
        // get language list
        $languageList = json_decode( $settings['language-list'], true );
            
        // create language found
        $languageFound = false;

        // loop over language list
        for( $i = 0; $i < count( $languageList ); $i++ ){
            // is language
            if( isset( $_POST['language'] ) && $_POST['language'] == $languageList[$i]['id'] ){
                // set language found
                $languageFound = true;
            }
            // is language
        }
        // loop over language list

        // language found
        if( $languageFound ){
            // loop over language list
            for( $i = 0; $i < count( $languageList ); $i++ ){
                // is language / else
                if( isset( $_POST['language'] ) && $_POST['language'] == $languageList[$i]['id'] ){
                    // set slug
                    $languageList[$i]['slug'] = $_POST['value'];
                }
                // is language / else
            }
            // loop over language list

            // set option value
            $settings['language-list'] = json_encode( $languageList );

            // update settings
            update_option( $settingsId, $settings );

            // debug 
            $this->common->debug( 'error', 'saved slug' );

        }
        // language found
            
        // create data
        $data = array(
            "text"  => 'ok',
            "settingsId"  => $settingsId
        );
        // create data
        
        // call ajax succes
        $request->ajaxSucces( $data );
            
    }
    // private 


}
