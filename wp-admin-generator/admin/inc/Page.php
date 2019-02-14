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
use PleistermanWpAdminGenerator\Admin\Base\CommonClass;
use PleistermanWpAdminGenerator\Admin\HtmlGenerators\HtmlGenerator;
use PleistermanWpAdminGenerator\Admin\Lists;
use PleistermanWpAdminGenerator\Admin\Tabs;
use PleistermanWpAdminGenerator\Admin\Sections;
use PleistermanWpAdminGenerator\Admin\Authorisation;

class Page extends CommonClass {
    
    // members
    private $htmlGenerator = null;
    private $lists = null;
    private $authorisation = null;
    private $slug = null;
    private $page = null;
    private $tabs = null;
    private $sections = null;
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

        // create html generator
        $this->htmlGenerator = new HtmlGenerator( $this->common );
        
        // create authorisation class
        $this->authorisation = new Authorisation( $this->common ); 
        
        // create tabs
        $this->tabs = new Tabs( $this->common );
        
        // create sections
        $this->sections = new Sections( $this->common, $this->htmlGenerator );
    }
    // construct

    
    // load page
    public function load( $pageDir, $slug, $tabId ) {
        
        // set current slug
        $this->slug = $slug;
        
        // debug info
        $this->common->debug( 'load-page', 'load page slug: ' . $this->slug );

        // debug 
        $this->common->debug( 'load-page', 'load page json: ' . $pageDir . $this->slug . '.json' );
        
        // create file name
        $fileName = $pageDir . $this->slug. '.json'; 
        
        // file ! exists
        if( !is_file( $fileName ) ){
        
            // debug 
            $this->common->debug( 'load-page', 'load page file not found : ' . $fileName );

            // return with error
            return;
        }
        // file ! exists

        // get page json
        $this->page = json_decode( file_get_contents( $fileName ), true );

        // load tabs 
        $this->tabs->load( $this->page, $pageDir, $tabId );

    }
    // load page

    // register page
    public function register( $capabilities ) {
        
        // debug 
        $this->common->debug( 'register-page', 'register page' );

        // get app name
        $appName = $this->common->getSetting( 'app-name' );
        
        // get tab or page settings
        $settings = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTab( ) : $this->page;
        
        // get settings id
        $settingsId = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTabId( ) : $this->slug;
        
        // create group id
        $groupId = $appName . '-group-' . $settingsId;
        // create group name
        $groupName = $appName . '-' . $settingsId;
        
        // debug 
        $this->common->debug( 'error', 'groupId: ' . $groupId );
                
        // set capabilities
        $capabilities = isset( $settings['capabilities'] ) ? $settings['capabilities'] : $capabilities;
        
        // not authorized
        if( !$this->authorisation->isAuthorised( $capabilities ) ){
            // debug 
            $this->common->debug( 'error', 'register page not authorized' );
            // echo error
            echo 'You are not authorized to edit these settings.';
            // done with error
            return;
        }
        // not authorized

        // debug 
        $this->common->debug( 'register-page', 'settings: ' . json_encode( $settings ) );
        
        // add settings group
	register_setting( $groupId, $groupName, array( $this, 'prepareSave' ) );
        
        // register sections
        $this->sections->register( $groupName, $settings );
        
    }
    // register page
    
    // prepare save
    public function prepareSave( $input ) {
        
        // prepare save
        return $this->sections->prepareSave( $input );
        
    }
    // prepare save
    
    // open page
    public function open( $listsDir, $imageUrl, $beforeForm = null, $afterForm = null ) {
                
        // debug 
        $this->common->debug( 'open-page', 'slug: ' . json_encode( $this->slug ) );
        
        // debug 
        $this->common->debug( 'open-page', 'page: ' . json_encode( $this->page ) );

        // load lists
        $this->loadLists( $listsDir );
        
        // get app name
        $appName = $this->common->getSetting( 'app-name' );
        
        // get tab or page settings
        $settings = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTab( ) : $this->page;
        
        // get settings id
        $settingsId = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTabId( ) : $this->slug;
        
        // set image url
        $this->htmlGenerator->setImageUrl( $imageUrl );
        
        // load saved values
        $this->htmlGenerator->loadSavedValues( $appName . '-' . $settingsId );
            
        // open html wrapper
        echo '<div class="wrap">';
        
            // create title
            $this->htmlGenerator->generateTitle( );

            if( $this->tabs->pageHasTabs() ){ 
                // create tabs
                $this->tabs->create( $this->htmlGenerator ,$this->slug, $this->page );
            }            
            
            // create title
            $this->htmlGenerator->generateSubTitle( $settings );

            // show errors
            settings_errors();
            
            // open main div
            echo '<div class="' . $appName . '-main">';

                // before form exists
                if( isset( $beforeForm ) ){
                    // loop over elements
                    foreach( $beforeForm as $element ){
                        // generate element
                        $this->htmlGenerator->generateElement( $element );
                    }
                    // loop over elements
                }
                // before form exists
                
                // generate the form
                $this->htmlGenerator->generateForm( $settingsId, $settings );

                // after form exists
                if( isset( $afterForm ) ){
                    // generate element
                    $this->htmlGenerator->generateElement( $afterForm );
                }
                // after form exists
                
                
            // close main div
            echo '</div>';
            
        // close html wrapper
        echo '</div>';
        
    }
    // open page
    
    // load lists
    private function loadLists( $listsDir ) {
        
        // get tab or page settings
        $settings = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTab( ) : $this->page;
        
        // no lists
        if( !isset( $settings['lists'] ) ){
            // done 
            return;
        }
        // no lists
        
        // create lists
        $this->lists = new Lists( $this->common ); 
        
        // load lists
        $this->lists->load( $listsDir, $settings['lists'] );
        
        // set lists of html generator
        $this->htmlGenerator->setLists( $this->lists );
        
    }
    // load lists
    
}
