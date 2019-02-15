<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       StylesheetLoader.php
        function:   handles: 
                        loading style sheets
*/

namespace PleistermanWpSimpleTranslator\Admin;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class StylesheetLoader extends CommonClass {
    
    // members
    private $stylesheetsDir = '/../css/';
    private $stylesheetsUrl = '/../../css/';
    private $customStylesheetsDir = '/../../custom/admin/css/';
    private $customStylesheetsUrl = '/../../../custom/admin/css/';
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

                
        // set stylesheets dir
        $this->stylesheetsDir = dirname( __FILE__ ) . $this->stylesheetsDir; 
        
        // set stylesheets dir
        $this->customStylesheetsDir = dirname( __FILE__ ) . $this->customStylesheetsDir; 
        
        // get stylesheets url
        $this->stylesheetsUrl = plugin_dir_url( __FILE__ ) . $this->stylesheetsUrl;
        
        // get custom stylesheets url
        $this->customStylesheetsUrl = plugin_dir_url( __FILE__ ) . $this->customStylesheetsUrl;
        
    }
    // construct
    
    // add style sheets 
    public function add( $stylesheets ) {

        // debug 
        $this->common->debug( 'add-css', 'add stylesheets: ' . json_encode( $stylesheets ) );
        
        // stylesheets ! exists or ! array
        if( !$stylesheets || !is_array( $stylesheets ) ){
            // no stylesheets or invalid
            return;
        }
        // stylesheets ! exists or ! array
        
        // loop over stylesheets
        foreach ( $stylesheets as $stylesheet ){
            
            // create dir
            $dir = null;
            // create url
            $url = null;
            
            // file exists in css dir
            if( is_file( $this->stylesheetsDir . $stylesheet ) ){
                // set dir
                $dir = $this->stylesheetsDir;
                // set url
                $url = $this->stylesheetsUrl;
                // debug 
                $this->common->debug( 'add-css', 'stylesheet found: ' . $stylesheet );
            }
            // file exists in css dir
            
            // dir not found and file exists in custom css dir
            if( !$dir && is_file( $this->customStylesheetsDir . $stylesheet ) ){
                // set dir
                $dir = $this->customStylesheetsDir;
                // set url
                $url = $this->customStylesheetsUrl;
                // debug 
                $this->common->debug( 'add-css', 'custom stylesheet found: ' . $stylesheet );
            }
            // dir not found and file exists in custom css dir
            
            // dir not found
            if( !$dir ){
                // debug 
                $this->common->debug( 'error', 'add stylesheets file not found: ' . $stylesheet );
                // debug 
                $this->common->debug( 'error', 'custom dir file: ' . $this->customStylesheetsDir . $stylesheet );
                
            }
            // dir not found
            
            // dir found
            if( $dir ){
                // get file name
                $fileName = basename( $stylesheet );
                // split file name
                $fileNameArray = explode( '.', $fileName );
                // create id
                $id = array_splice( $fileNameArray, 0, count( $fileNameArray ) - 1 );        
                // create handle
                $handle = $this->common->getSetting( 'plugin-id' ) . '-' . implode( '', $id );

                // register script
                wp_register_style( $handle, $url . $stylesheet );

                // enqueue script
                wp_enqueue_style( $handle );

                //  debug
                $this->common->debug( 'add-css', 'add cas added: ' . $stylesheet );
                $this->common->debug( 'add-css', 'add css handle: ' . $handle );
                $this->common->debug( 'add-css', 'add css dir: ' . $dir );
                // debug 
                
            }            
            // dir found
        }        
        // loop over stylesheets
        
        
        return;
        
        
        // load json
        $css = $this->loadJson( $path, $jsonFiles );
        
        // loop over css
        foreach ( $css as $dirFileName ){

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
