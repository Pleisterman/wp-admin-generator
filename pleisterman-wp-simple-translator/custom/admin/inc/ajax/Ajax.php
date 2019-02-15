<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       Ajax.php
        function:   handles custom main 
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\Ajax;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;
use PleistermanWpSimpleTranslator\Custom\Admin\Ajax\AjaxOptions;
use PleistermanWpSimpleTranslator\Custom\Admin\Ajax\AjaxLanguages;

class Ajax extends CommonClass {
    
    // members
    private $ajaxFunctions = array(
        'options'   =>  'ajaxOptions',
        'languages'   =>  'ajaxLanguages'
    );
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );
                
    }
    // construct

    // ajax
    public function ajax( $request ) {
        
        // ! valid ajax request
        if( !$request->ajaxIsValid() ){
            // debug 
            $this->common->debug( 'error', 'invalid ajax request ' );
            // done with error
            die();
        }
        // ! valid ajax request

        // ! $_POST['subject']
        if( !isset( $_POST['subject'] ) ){
            // debug 
            $this->common->debug( 'error', 'ajax invalid subject request ' );
            // invalid subject
            die();
        }
        // ! $_POST['subject']
        
        // function ! exists
        if( !isset( $this->ajaxFunctions[$_POST['subject']] ) ){
            // debug 
            $this->common->debug( 'error', 'ajax invalid function not found ' );
            // invalid function
            die();
        }
        // function ! exists
        
        // get function
        $function = $this->ajaxFunctions[$_POST['subject']];
        // call ajax function
        $this->$function( $request );
            
    }
    // ajax
    
    // ajax options
    private function ajaxOptions( $request ) {
        
        // create ajax options
        $options = new AjaxOptions( $this->common );
        // call ajax options
        $options->ajax( $request );
        
    }
    // ajax options

    // ajax languages
    private function ajaxLanguages( $request ) {
        
        // create ajax languages
        $languages = new AjaxLanguages( $this->common );
        // call ajax languages
        $languages->ajax( $request );
        
    }
    // ajax languages

}
