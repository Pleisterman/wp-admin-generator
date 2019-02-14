<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       TabsGenerator.php
        function:   Generates tabs html for admin pages
*/

namespace PleistermanWpAdminGenerator\Admin\HtmlGenerators;

use PleistermanWpAdminGenerator\Common\Common;
use PleistermanWpAdminGenerator\Admin\Base\CommonClass;
use PleistermanWpAdminGenerator\Admin\Authorisation;

class TabsGenerator extends CommonClass {
    
    // members
    private $authorisation = null;
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

        // create authorisation class
        $this->authorisation = new Authorisation( $this->common ); 
    }
    // construct
    
    // generate tabs 
    public function generateTabs( $slug, $pageOptions, $tabs, $selectedTabId ){
        
        // open html wrapper
        echo '<div class="wrap">';
        
        // create html wrapper
        echo '<h2 class="nav-tab-wrapper ';
            
        // page options nav class exists
        if( isset( $pageOptions['tabs-class'] ) ){
            // add page nav class
            echo ' ' . $pageOptions['tabs-class'];
        }
        
        echo '">';

            // loop over tabs
            foreach( $tabs as $tabId => $tabOptions ) {

                // user is authorized
                if( $this->authorisation->isAuthorised( $tabOptions['capabilities'] )  ){
                    // create tab
                    $this->createTab( $slug, $tabId, $tabOptions, $selectedTabId );
                }                
                // user is authorised

            }
            // loop over tabs
            
            // close html wrapper
            echo '</h2>';
            
        // close html wrapper
        echo '</div>';
    }	
    // generate tab content
    
    // generate tab
    private function createTab( $slug, $tabId, $tabOptions, $selectedTabId ){
        
        // get app-name
        $appName = $this->common->getSetting( 'app-name' );
        
        // open link
        echo '<a href="' . $this->common->getAdminLink() . '?page=' . $appName . '-' . $slug . '&tab=' . $tabId; 

        // add nav=tab class
        echo '" class="nav-tab'; 

        // is current tab
        if( $tabId == $selectedTabId ) {
            echo ' nav-tab-active';
        }
        // is current tab

        // tab class exists
        if( isset( $tabOptions['class'] ) ) {
            // add class
            echo ' ' . $tabOptions['class'];
        }
        // tab class exists

        // done open link
        echo '">';

            // add icon    
            echo '<span style="margin-right:0.4em;" class="' . $tabOptions['icon-class'] . '"></span>';

            // add tab title
            echo __( $tabOptions['title'],  $this->common->getSetting( 'text-domain' ) );

        // close link
        echo '</a>';    
    }	
    // generate tab
    
}
