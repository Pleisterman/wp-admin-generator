<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       page.php
        function:   handles: 
                        register of page tabs, sections and fields
                        show page
*/

namespace PleistermanWpSimpleTranslator\Admin;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;
use PleistermanWpSimpleTranslator\Admin\HtmlGenerators\HtmlGenerator;
use PleistermanWpSimpleTranslator\Admin\Lists;
use PleistermanWpSimpleTranslator\Admin\Tabs;
use PleistermanWpSimpleTranslator\Admin\Sections;
use PleistermanWpSimpleTranslator\Admin\Authorisation;

class Page extends CommonClass {
    
    // members
    private $htmlGenerator = null;
    private $lists = null;
    private $authorisation = null;
    private $slug = null;
    private $page = null;
    private $tabs = null;
    private $sections = null;
    private $pageDir = '/../../custom/admin/pages/';
    private $imageUrl = '/../../../custom/admin/images/';
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
        
        // get page dir
        $this->pageDir = dirname( __FILE__ ) . $this->pageDir;
        
        // get image url
        $this->imageUrl = plugin_dir_url( __FILE__ ) . $this->imageUrl;
        
    }
    // construct

    
    // load page
    public function load( $slug, $tabId ) {
        
        // set current slug
        $this->slug = $slug;
        
        // debug info
        $this->common->debug( 'load-page', 'load page slug: ' . $this->slug );

        // debug 
        $this->common->debug( 'load-page', 'load page json: ' . $this->pageDir . $this->slug . '.json' );
        
        // create file name
        $fileName = $this->pageDir . $this->slug. '.json'; 
        
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
        $this->tabs->load( $this->page, $this->pageDir, $tabId );

    }
    // load page

    // register page
    public function register( $capabilities ) {
        
        // debug 
        $this->common->debug( 'register-page', 'register page' );

        // get plugin id
        $pluginId = $this->common->getSetting( 'plugin-id' );
        
        // get tab or page settings
        $settings = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTab( ) : $this->page;
        
        // get settings id
        $settingsId = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTabId( ) : $this->slug;
        
        // create group id
        $groupId = $pluginId . '-group-' . $settingsId;
        // create group name
        $groupName = $pluginId . '-' . $settingsId;
        
        // debug 
        $this->common->debug( 'register-page', 'groupId: ' . $groupId );
                
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
    public function open( ) {
                
        // debug 
        $this->common->debug( 'open-page', 'slug: ' . json_encode( $this->slug ) );
        
        // debug 
        $this->common->debug( 'open-page', 'page: ' . json_encode( $this->page ) );

        // get plugin id
        $pluginId = $this->common->getSetting( 'plugin-id' );
        
        // get tab or page settings
        $settings = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTab( ) : $this->page;
        
        // get settings id
        $settingsId = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTabId( ) : $this->slug;
        
        // load lists
        $this->loadLists( $settings );
        
        // set image url
        $this->htmlGenerator->setImageUrl( $this->imageUrl );
        
        // load saved values
        $this->htmlGenerator->loadSavedValues( $pluginId . '-' . $settingsId );
            
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
            echo '<div class="' . $pluginId . '-main">';

                // settings before form exists
                if( isset( $settings['before-form'] ) ){
                    // loop over elements
                    foreach( $settings['before-form'] as $element ){
                        // generate element
                        $this->htmlGenerator->generateElement( $element );
                    }
                    // loop over elements
                }
                // settings before form exists
                
                // generate the form
                $this->htmlGenerator->generateForm( $settingsId, $settings );

                // settings after form exists
                if( isset( $settings['after-form'] ) ){
                    // loop over elements
                    foreach( $settings['after-form'] as $element ){
                        // generate element
                        $this->htmlGenerator->generateElement( $element );
                    }
                    // loop over elements
                }
                // settings after form exists
                
            // close main div
            echo '</div>';
            
        // close html wrapper
        echo '</div>';
        
    }
    // open page
    
    // load lists
    private function loadLists( $settings ) {
        
        // no lists
        if( !isset( $settings['lists'] ) ){
            // done 
            return false;
        }
        // no lists
        
        // create lists
        $this->lists = new Lists( $this->common ); 
        
        // load lists
        $this->lists->load( $settings['lists'] );
        
        // set lists of html generator
        $this->htmlGenerator->setLists( $this->lists );
        
    }
    // load lists

    // get scripts
    public function getStylesheets( ){
        
        // get page settings
        $settings = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTab( ) : $this->page;
        
        // stylesheets exists
        if( isset( $settings['stylesheets'] ) ){
            // return stylesheets
            return $settings['stylesheets'];
        }
        // stylesheets exists
        
        // no stylesheets
        return false;
    }
    // get stylesheets
    

    // get scripts
    public function getScripts( ){
        
        // get page settings
        $settings = $this->tabs->pageHasTabs() ? $this->tabs->getSelectedTab( ) : $this->page;
        
        // scripts exists
        if( isset( $settings['scripts'] ) ){
            // return scripts
            return $settings['scripts'];
        }
        // scripts exists
        
        // no scripts
        return false;
    }
    // get scripts
    
}
