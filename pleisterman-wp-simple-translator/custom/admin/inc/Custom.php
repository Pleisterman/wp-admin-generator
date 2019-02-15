<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       Main.php
        function:   handles custom main 
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;
use PleistermanWpSimpleTranslator\Admin\Request;
use PleistermanWpSimpleTranslator\Custom\Admin\Ajax\Ajax;
use PleistermanWpSimpleTranslator\Custom\Admin\LocalizeScripts\LocalizeScripts;

class Custom extends CommonClass {
    
    // members
    private $request = null;
    private $ajax = null;
    private $localizeScripts = null;
    // members
        
    // construct
    public function __construct( Common $common, Request $request ){
        
        // call parent constructor
        parent::__construct( $common );

        // set request
        $this->request = $request;
        
        // create ajax
        $this->ajax = new Ajax( $this->common );
                
        // create localized scripts
        $this->localizeScripts = new LocalizeScripts( $this->common );
                
    }
    // construct

    // localize scripts
    public function localizeScripts( $scriptId, $handle ) {
    
        // call localized scripts
        $this->localizeScripts->localizeScripts( $scriptId, $handle );
    }
    // localize scripts
    
    // register wordpress hooks
    public function registerWordpressHooks( ) {
    }
    // register wordpress hooks
    
    // add wordpress actions
    public function addWordpressActions( ) {
    }
    // add wordpress actions
    
    // ajax
    public function ajax() {
        
        // debug 
        $this->common->debug( 'ajax', 'custom ajax' );
        
        // call ajax
        $this->ajax->ajax( $this->request );
        
    }
    // ajax
    
    // activate
    public function activate() {
        
        
    }
    // activate

    // deActivate
    public function deActivate() {
        
        
    }
    // deActivate

    // deInstall
    public function deInstall() {
        
        
    }
    // deInstall
}
