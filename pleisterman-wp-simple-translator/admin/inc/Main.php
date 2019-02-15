<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       dashboard.php
        function:   handles: 
                        register wordpress hooks
                        admin enqueue scripts 
                        dashboard create menu 
                        register wordpress options
                        open selected menu page
                        activate, 
                        deactivate
*/

namespace PleistermanWpSimpleTranslator\Admin;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Translations;
use PleistermanWpSimpleTranslator\Admin\StylesheetLoader;
use PleistermanWpSimpleTranslator\Admin\ScriptLoader;
use PleistermanWpSimpleTranslator\Admin\DeInstaller;
use PleistermanWpSimpleTranslator\Admin\Request;
use PleistermanWpSimpleTranslator\Admin\Menu;
use PleistermanWpSimpleTranslator\Admin\Page;
use PleistermanWpSimpleTranslator\Custom\Admin\Custom;

class Main {
    // members
    private $common = null;
    private $translations = null;
    private $adminPath = '../';
    private $menu = null;
    private $page = null;
    private $pageId = null;
    private $tabId = null;
    private $slug = null;
    private $request = null;
    private $deInstaller = null;
    private $stylesheetLoader = null;
    private $scriptLoader = null;
    private $custom = null;
    // members
    
    // construct
    public function __construct( ){
        
        // create common
        $this->common = new Common( );
        
        // create translations
        $this->translations = new Translations( $this->common );
        
        // create request
        $this->request = new Request( $this->common );
        
        // create de-Installer
        $this->deInstaller = new DeInstaller( $this->common );
        
        // set admin path
        $this->adminPath = plugin_dir_url( __FILE__ ) . $this->adminPath;
        
        // create custom
        $this->custom = new Custom( $this->common, $this->request ); 
        
        // create script loader
        $this->scriptLoader = new ScriptLoader( $this->common, $this->custom );
        
        // create stylesheet loader
        $this->stylesheetLoader = new StylesheetLoader( $this->common );
        
        // register wp hooks
        $this->registerWordpressHooks();
        
        // register custom wp hooks
        $this->custom->registerWordpressHooks();
        
        // add wp actions
        $this->addWordpressActions();
        
        // add custom wp actions
        $this->custom->addWordpressActions();
        
        // create menu class
        $this->menu = new Menu( $this->common, $this, 'openPage' ); 
            
        // create page
        $this->page = new Page( $this->common );
        
    }
    // construct

    // register wordpress hooks
    private function registerWordpressHooks( ) {

        // register acivation hook
        register_activation_hook( __FILE__, array( $this, 'activate' ) );

        // register deacivation hook
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
        
        // register uninstall_hook
        register_uninstall_hook(  __FILE__, array( 'deInstall', 'deInstall' ) );
        
    }
    // register wordpress hooks
    
    // add wordpress actions
    private function addWordpressActions( ) {

        // enqueue scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        // create dashboard menu
        add_action( 'admin_menu', array( $this, 'createMenu' ) );

        // register settings
        add_action( 'admin_init', array( $this, 'adminInit' ) );
        
    }
    // add wordpress actions
    
    // enqueue scripts 
    public function enqueueScripts() {
        
        // debug 
        $this->common->debug( 'add-css', 'admin-css-main', 'before' );
        
        // request needs handling
        if( !$this->requestNeedsHandling() ){
            // no handling needed
            return;
        }
        // request needs handling
        
        // add style sheets
        $this->addStyleSheets( );
        // add javascripts
        $this->addJavascripts( );
        
    }	
    // enqueue scripts 

    // add style sheets
    private function addStyleSheets() {
        
        // debug 
        $this->common->debug( 'add-css', 'admin-css-main', 'before' );
        
        // get page stylesheets
        $stylesheets = $this->page->getStylesheets();
        
        // add stylesheets
        $this->stylesheetLoader->add( $stylesheets );
        
        // debug 
        $this->common->debug( 'add-css', 'admin-css-main', 'after' );
        
    }	
    // add style sheets
    
    // add javascripts
    private function addJavascripts() {
        
        // debug 
        $this->common->debug( 'add-js', 'admin-js-main', 'before' );

        // get page scripts
        $scripts = $this->page->getScripts();
        
        // add javascripts
        $this->scriptLoader->add( $scripts );
        
        // debug 
        $this->common->debug( 'add-js', 'admin-js-main', 'after' );
    }	
    // add javascripts
    
    // create menu
    public function createMenu() {

        // debug 
        $this->common->debug( 'create-menu', 'admin-menu-main', 'before' );
        
        // create translations
        $this->translations->load();

        // get page id
        $this->pageId = $this->request->getPageId();
        
        // get tab id
        $this->tabId = $this->request->getTabId();

        // create menu
        $this->menu->create(); 
        
        // get slug from menu
        $this->slug = $this->menu->getSlug( $this->pageId );
        
        // debug 
        $this->common->debug( 'create-menu', 'admin-menu-main', 'after' );
    }	
    // create menu
    
    // admin init
    public function adminInit() {
        
        // is ajax request
        if( $this->request->isWpAjax() ){
            // done
            return;
        }
        // is ajax request
        
        // debug 
        $this->common->debug( 'admin-init', 'admin-init-main', 'before' );
        
        // get capabilities from menu
        $capabilities = $this->menu->getCapabilties( $this->pageId );
        
        // request needs handling
        if( !$this->requestNeedsHandling() ){
            // debug 
            $this->common->debug( 'admin-init', 'admin-init-main request not handled', 'after' );
            // no handling needed
            return;
        }
        // request needs handling
        
        // debug 
        $this->common->debug( 'admin-init', 'page: ' . $this->pageId );

        // load page
        $this->page->load( $this->slug, $this->tabId );
            
        // register page
        $this->page->register( $capabilities );
        
        // debug 
        $this->common->debug( 'admin-init', 'admin-init-main request handled', 'after' );
    }
    // admin init
    
    // open page called by Wordpress when a menu is selected
    public function openPage( ){
        
        // debug 
        $this->common->debug( 'open-page', 'admin-init-main open page', 'before' );
        
        // request needs handling
        if( !$this->requestNeedsHandling() ){
            // debug 
            $this->common->debug( 'open-page', 'admin-init-main request not handled', 'after' );
            // no handling needed
            return;
        }
        // request needs handling
        
        // open page
        $this->page->open( );
        
        // debug 
        $this->common->debug( 'open-page', PHP_EOL . 'admin-init-main request handled', 'after' );
        
    } 
    // open page called by Wordpress when a menu is selected
    
    // request needs handling
    private function requestNeedsHandling() {
        
        // get plugin id
        $pluginId = $this->common->getSetting( 'plugin-id' );
        
        // plugin-id in pageid
        if( strstr( $this->pageId, $pluginId ) ){

            // debug
            $this->common->debug( 'request-needs-handling', 'request is simple-translator page' );
            
            // request is ajax
            if( $this->request->isAjax() ){
                // do ajax
                $this->ajax();
                // handled by ajax
                return false;
            }
            // request is ajax

            // a generator page
            return true;
        }
        // plugin-id in page

        // debug 
        $this->common->debug( 'request-needs-handling', 'request is not simple-translator page' );
        // not a generator page
        return false;
        
    }
    // request needs handling
    
    // ajax
    public function ajax() {

        // call custom
        $this->custom->ajax();
        
    }
    // ajax

    // activate
    public function activate() {
        
        // call custom
        $this->custom->activate();
        
    }
    // activate

    // deActivate
    public function deActivate() {
        
        // call custom
        $this->custom->deActivate();
        
    }
    // deActivate
}
