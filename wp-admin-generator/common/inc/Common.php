<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       common.php
        function:   common functions and settings
*/

namespace PleistermanWpAdminGenerator\Common;

class Common {
    
    // members
    private $settings = null; 
    private $settingsFilePath = '\..\..\config\settings.json';
    // members
    
    
    // construct
    public function __construct( ){

        
        // read settings
        $this->readSettings();
    }
    // construct
    
    // read settings
    private function readSettings( ){
        
        $settingsFile = dirname( __FILE__ ) . $this->settingsFilePath; 
        
        if( is_file( $settingsFile ) ){
            // read settings
            $this->settings = json_decode( file_get_contents( $settingsFile ), true );
        }
        else {
            // settings not found
            error_log( '   settings not found.' );
        }
    }
    // read settings
    
    // is admin
    public function isAdmin( ){
        
        // is wp admin
        if( defined( 'WP_ADMIN' ) || defined( 'WP_NETWORK_ADMIN' ) ){
            // is admin
            return true;
        }
        // is wp admin
        
        // ! admin
        return false;
    }	
    // is admin

    // get setting
    public function getSetting( $key ){
        
        return $this->settings[$key];
    }	
    // get setting
    
    // get translate
    public function translate( $key ){
        
        return $key;
    }	
    // get setting
    
    // debug
    public function debug( $level, $message, $marker = false ){

        // debug on and level in debug-levels
        if( $this->settings['debug-on'] && in_array( $level, $this->settings['debug-levels'] ) ){
            
            // marker and empty line is before
            if( $marker && $marker == 'before' ){
                // write error
                error_log( 'before  ' . $this->getSetting( 'debug-marker' ) );
            }
            // marker and empty line is before

            // write error
            error_log( $this->settings['app-name'] . ': ' . $message );

            // marker and empty line is after
            if( $marker && $marker == 'after' ){
                // write error
                error_log( 'after  ' . $this->getSetting( 'debug-marker' ) );
            }
            // marker and empty line is after
        }
        // debug on and level in debug-levels

    }	
    // debug

    // get admin link
    public function getAdminLink( ){
        
        // is multi site
	if( !is_multisite() ){
            // done
            return admin_url( 'admin.php' );
	}
	else{
            // done
            return network_admin_url( 'admin.php' );
	}
        // is multi site
    }	
    // get admin link
    
    // get option
    public function getOption( $optionName ){
        
        // return wordpress get option
        return get_option( $optionName );
    }	
    // get option
    
    
}
