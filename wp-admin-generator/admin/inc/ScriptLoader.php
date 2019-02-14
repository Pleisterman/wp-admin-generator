<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       ScriptLoader.php
        function:   handles: 
                        loading javascripts
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class ScriptLoader extends CommonClass {
    
    // members
    private $json = array();
    // members
        
    // add javascript 
    public function add( $path, $url, $jsonFiles = array( 'js.json' ) ) {
        
        // debug 
        $this->common->debug( 'add-js', 'add js', 'before' );
        $this->common->debug( 'add-js', 'add js path: ' . $path );
        $this->common->debug( 'add-js', 'add js json file: ' . json_encode( $jsonFiles ) );
        // debug 

        // load json
        $javascripts = $this->loadJson( $path, $jsonFiles );
        
        // add jquery
        $this->addJQuery();

        // loop over javascripts
        foreach ( $javascripts as $dirFileName => $dependency ){

            // get file name
            $fileName = basename( $dirFileName );
            // split file name
            $fileNameArray = explode( '.', $fileName );
            // create id
            $id = array_splice( $fileNameArray, 0, count( $fileNameArray ) - 1 );        
            // create handle
            $handle = $this->common->getSetting( 'app-name' ) . '-' . implode( '', $id );
            
            // dependency exists
            if( $dependency ){
                // register script with dependency
                wp_register_script( $handle, $url . $dirFileName, $dependency['dependency']['app'], $dependency['dependency']['version'], true );
            }
            else {
                // register script without dependency
                wp_register_script( $handle, $url . $dirFileName, array(), false, true );
            }
            // dependency exists
           
            // enqueue script
            wp_enqueue_script( $handle );
            
            //  debug
            $this->common->debug( 'add-js', 'add js added: ' . $dirFileName );
            $this->common->debug( 'add-js', 'add js handle: ' . $handle );
            $this->common->debug( 'add-js', 'add js url: ' . $url );
            // debug 
            
        }        
        // loop over javascripts
        $this->common->debug( 'add-js', 'add js', 'after' );
    }	
    // add javascript

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
                $js = json_decode( file_get_contents( $dirFileName ), true );
                // merge array
                $json = array_merge( $json, $js );
            }
            else {
                // debug 
                $this->common->debug( 'error', 'load javascript json file not found: ' . $dirFileName );
            }
            // is file
        }
        // loop over json files
        
        // debug 
        $this->common->debug( 'add-js', 'load javascripts json result: ' . json_encode( $json ) );
        
        // return javascripts
        return $json;
        
    }
    // load json 

    // add jquery
    private function addJQuery( ) {
        
        // add jquery
        wp_enqueue_script( 'jquery' );

    }
    // add jquery 
    
}
