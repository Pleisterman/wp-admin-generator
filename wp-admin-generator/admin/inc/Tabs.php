<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       page.php
        function:   handles: 
                        register of page tabs, sections and fields
                        show page
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Common\Common;

class Tabs {
    
    // members
    private $common = null;
    private $tabs = null;
    private $selectedTabId = null;
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // set common
        $this->common = $common;

    }
    // construct

    // page has tabs
    public function pageHasTabs( ){

        // tabs exist
        if( $this->tabs ){
            // has tabs
            return true; 
        }
        // tabs exist
        
        // no tabs
        return false; 
        
    }
    // page has tabs
    
    // get selected tab
    public function getSelectedTab( ){
        
        // has tabs
        if( $this->tabs ){
            // return selected tab
            return $this->tabs[$this->selectedTabId];
        }
        // has tabs

        // debug 
        $this->common->debug( 'tabs', 'tab not found ' );
        
        // return with error
        return false;
    }
    // get selected tab
    
    // get selected tab
    public function getSelectedTabId( ){
        
        // selected tabId exits
        if( $this->selectedTabId ){
            // return selected tab
            return $this->selectedTabId;
        }
        // selected tabId exits

        // debug 
        $this->common->debug( 'tabs', 'selecte tabId not found ' );
        
        // return with error
        return false;
    }
    // get selected tab
    
    // create tabs
    public function create( $htmlGenerator, $slug, $page ){
    
        // tabs ! exist
        if( !$this->tabs ){

            // no tabs
            return;
            
        }
        // tabs ! exist
    
        // debug 
        $this->common->debug( 'tabs', 'tabs: ' . json_encode( $this->tabs ) );
        
        // debug 
        $this->common->debug( 'tabs', 'selected tabId: ' . $this->selectedTabId );
        
        // create tabs
        $htmlGenerator->generateTabs( $slug, $page, $this->tabs, $this->selectedTabId );
        
    }
    // create tabs
    
    // load
    public function load( $page, $tabsDir, $tabId ){
        
        // page tabs ! exist
        if( !isset( $page['tabs'] ) ){
            // no tabs
            return;
        }
        // page tabs ! exist
        
        // get current tab
        $this->selectedTabId = $tabId;
        
        // get tab dir
        $tabsDir = $tabsDir . $page['tabs'] . '\\';
        
        // get tab file list
        $tabFiles = $this->getTabFileList( $tabsDir ); 

        // loop over files
        for( $i = 0; $i < count( $tabFiles ); $i++ ){

            // get tabId
            $tabId = basename( $tabFiles[$i], '.json' );
            
            // tabs ! exists
            if( !$this->tabs ){
                // create tabs
                $this->tabs = array();
            }
            // tabs ! exists

            // selected tabId ! exists
            if( empty( $this->selectedTabId ) ){
                // set tab first tab
                $this->selectedTabId = $tabId;
            }
            // selected tabId ! exists
                
            // add tab json
            $this->tabs[$tabId] = json_decode( file_get_contents( $tabsDir . $tabFiles[$i] ), true );
        }
        
        // debug 
        $this->common->debug( 'tabs', 'load tabs, selected tab: ' . $this->selectedTabId );
        // debug 
        $this->common->debug( 'tabs', 'load tabs, tabs: ' . json_encode( $this->tabs ) );

    }
    // get tabs
    
    // get tab fileList
    private function getTabFileList( $tabsDir ) {
        
        // get file list from tabs dir
        $tabsDirList = scandir( $tabsDir );
        
        // create files
        $files = array();
                
        // loop over tabsdir list
        for( $i = 0; $i < count( $tabsDirList ); $i++ ){

            // ! dir
            if( !is_dir( $tabsDir . $tabsDirList[$i] ) ){
    
                // get file name
                array_push( $files, $tabsDirList[$i] );
            }
            // done ! dir
        }
        // done loop over tabsdir list

        // no files
        if( count( $files ) <= 0 ){
            // debug 
            $this->common->debug( 'tabs', 'load tab fileList, no files found tabsDir: ' . $tabsDir );
            // no files for tabs error
            return $files;
        }
        // no files

        // debug 
        $this->common->debug( 'tabs', 'load tab fileList, files: ' . json_encode( $files ) );
        
        // return files
        return $files;
    }
    // get tab fileList

}
