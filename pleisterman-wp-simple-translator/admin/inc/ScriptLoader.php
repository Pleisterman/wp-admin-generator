<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       ScriptLoader.php
        function:   handles: 
                        loading scripts
*/

namespace PleistermanWpSimpleTranslator\Admin;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;
use PleistermanWpSimpleTranslator\Custom\Admin\Custom;

class ScriptLoader extends CommonClass {
    
    // members
    private $custom = null;
    private $scriptsDir = '/../js/';
    private $scriptsUrl = '/../../js/';
    private $customScriptsDir = '/../../custom/admin/js/';
    private $customScriptsUrl = '/../../../custom/admin/js/';
    private $localizedScriptFunctions = array(
        'debugger'  =>   'localizeDebugger',
        'ajax'      =>   'localizeAjax'
    );
    // members

    // construct
    public function __construct( Common $common, Custom $custom ){
        
        // call parent constructor
        parent::__construct( $common );

        // set custom
        $this->custom = $custom; 
        
        // set scripts dir
        $this->scriptsDir = dirname( __FILE__ ) . $this->scriptsDir; 
        
        // get script url
        $this->scriptsUrl = plugin_dir_url( __FILE__ ) . $this->scriptsUrl;
                
        // set custom cripts dir
        $this->customScriptsDir = dirname( __FILE__ ) . $this->customScriptsDir; 
        
        // get custom script url
        $this->customScriptsUrl = plugin_dir_url( __FILE__ ) . $this->customScriptsUrl;
                
    }
    // construct
 
    // add scripts 
    public function add( $scripts ) {
        
        // debug 
        $this->common->debug( 'add-js', 'add scripts: ' . json_encode( $scripts ) );

        // scripts ! exists or ! array
        if( !$scripts || !is_array( $scripts ) ){
            // no scripts or invalid
            return;
        }
        // scripts ! exists or ! array
        
        // add jquery
        $this->addJQuery();

        // loop over scripts
        foreach ( $scripts as $script => $dependency ){
            
            // create dir
            $dir = null;
            // create url
            $url = null;
            // create is custom script
            $isCustomScript = false;
            
            // file exists in scripts dir
            if( is_file( $this->scriptsDir . $script ) ){
                // set dir
                $dir = $this->scriptsDir;
                // set url
                $url = $this->scriptsUrl;
                // debug 
                $this->common->debug( 'add-js', 'script found: ' . $script );
            }
            // file exists in scripts dir
            
            // dir not found and file exists in custom scripts dir
            if( !$dir && is_file( $this->customScriptsDir . $script ) ){
                // set is custom script
                $isCustomScript = true;
                // set dir
                $dir = $this->customScriptsDir;
                // set url
                $url = $this->customScriptsUrl;
                // debug 
                $this->common->debug( 'add-js', 'custom script found: ' . $script );
            }
            // dir not found and file exists in custom scripts dir
            
            // dir not found
            if( !$dir ){
                // debug 
                $this->common->debug( 'error', 'add scripts file not found: ' . $script );
                // debug 
                $this->common->debug( 'error', 'custom dir file: ' . $this->customScriptsDir . $script );
                
            }
            // dir not found
            
            // dir found
            if( $dir ){
                // register script
                $this->registerScript( $dir, $url, $script, $dependency, $isCustomScript );
                
            }            
            // dir found
        }        
        // loop over scripts
        
    }	
    // add scripts

    // register script
    private function registerScript( $dir, $url, $script, $dependency, $isCustomScript ) {
        
        // get file name
        $fileName = basename( $script );
        // split file name
        $fileNameArray = explode( '.', $fileName );
        // create id
        $id = implode( '', array_splice( $fileNameArray, 0, count( $fileNameArray ) - 1 ) );        
        // create handle
        $handle = $this->common->getSetting( 'plugin-id' ) . '-' . $id;

        // dependency exists
        if( $dependency ){
            // register script with dependency
            wp_register_script( $handle, $url . $script, $dependency['dependency']['app'], $dependency['dependency']['version'], true );
        }
        else {
            // register script without dependency
            wp_register_script( $handle, $url . $script, array(), false, true );
        }
        // dependency exists

        // enqueue script
        wp_enqueue_script( $handle );

        // is in localized script functions
        if( isset( $this->localizedScriptFunctions[$id] ) ){
            // get function
            $function = $this->localizedScriptFunctions[$id];
            // call localize script function
            $this->$function( $handle );
            
        }
        // is in localized script functions
        
        // is custom script 
        if( $isCustomScript ) {
            // localize custom scripts
            $this->custom->localizeScripts( $id, $handle );
        }
        // is custom script 
                
        //  debug
        $this->common->debug( 'add-js', 'add js added: ' . $script );
        $this->common->debug( 'add-js', 'add js handle: ' . $handle );
        $this->common->debug( 'add-js', 'add js url: ' . $url );
        // debug 
        
    }
    // register script

    // add jquery
    private function addJQuery( ) {
        
        // add jquery
        wp_enqueue_script( 'jquery' );

    }
    // add jquery 
    
    // localize debugger
    private function localizeDebugger( $handle ) {

        $this->common->debug( 'add-js', 'localizing debugger' );
        
        // get debug js options
        $debugOptions = $this->common->getSetting( 'debug-js' );
        
        // add debug options
        wp_localize_script( $handle, 'pleistermanDebugOptions', $debugOptions );
        

    }
    // localize debugger
    
    // localize ajax
    private function localizeAjax( $handle ) {

        // debug
        $this->common->debug( 'add-js', 'localizing ajax' );
        
        // add debug options
        wp_localize_script( $handle, 'pleistermanAjaxNonce', wp_create_nonce( 'pleistermanAjaxNonce' ) );
        

    }
    // localize debugger
    
}
