<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       StyleSheetLoader.php
        function:   handles: 
                        loading style sheets
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class StyleSheetLoader extends CommonClass {
    
    // members
    // members
        
    // add style sheets 
    public function add( $path, $url, $jsonFiles = array( 'css.json' ) ) {
        
        // debug 
        $this->common->debug( 'add-css', 'add css', 'before' );
        $this->common->debug( 'add-css', 'add css path: ' . $path );
        $this->common->debug( 'add-css', 'add css json file: ' . json_encode( $jsonFiles ) );
        // debug 

        // load json
        $css = $this->loadJson( $path, $jsonFiles );
        
        // loop over css
        foreach ( $css as $dirFileName ){

            // get file name
            $fileName = basename( $dirFileName );
            // split file name
            $fileNameArray = explode( '.', $fileName );
            // create id
            $id = array_splice( $fileNameArray, 0, count( $fileNameArray ) - 1 );        
            // create handle
            $handle = $this->common->getSetting( 'app-name' ) . '-' . implode( '', $id );
            
            // register script
            wp_register_style( $handle, $url . $dirFileName );
            
            // enqueue script
            wp_enqueue_style( $handle );
            
            //  debug
            $this->common->debug( 'add-css', 'add cas added: ' . $dirFileName );
            $this->common->debug( 'add-css', 'add css handle: ' . $handle );
            $this->common->debug( 'add-css', 'add css url: ' . $url );
            // debug 
        }        
        // loop over css
        
        // debug
        $this->common->debug( 'add-css', 'add css', 'after' );
    }	
    // add style sheets 
    
    // load json 
    private function loadJson( $path, $jsonFiles ) {
        
        // create json
        $json = array();
        
        // loop over json files
        for( $i = 0; $i < count( $jsonFiles ); $i++ ){
        
            // get dir file name
            $dirFileName = $path . $jsonFiles[$i];
            
            // is file
            if( is_file( $dirFileName ) ){
                // get json
                $css = json_decode( file_get_contents( $dirFileName ), true );
                // merge array
                $json = array_merge( $json, $css );
            }
            else {
                // debug 
                $this->common->debug( 'error', 'load style sheets json file not found: ' . $dirFileName );
            }
            // is file
        }
        // loop over json files
        
        // debug 
        $this->common->debug( 'add-css', 'load style sheets json result: ' . json_encode( $json ) );
        
        // return json
        return $json;
        
    }
    // load json 
    
}
