<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       FieldGenerator.php
        function:   Generates field html for admin pages
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\FieldGenerators;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;
use PleistermanWpSimpleTranslator\Admin\HtmlGenerators\HtmlGenerator;
use PleistermanWpSimpleTranslator\Custom\Admin\FieldGenerators\LanguagesGenerator;

class CustomFieldGenerator extends CommonClass {
    
    // members
    private $imageUrl = '';
    private $inputGeneratorFunctions = array(
        'languages'  =>  'generateLanguages'
    );
    private $languagesGenerator = null;
    private $lists = null;
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

        // create html generator classes
        $this->languagesGenerator = new LanguagesGenerator( $this->common ); 
        // create html generator classes
    }
    // construct

    // set image url
    public function setImageUrl( $imageUrl ){
        
        // set image url
        $this->imageUrl = $imageUrl;
        
        // set languages image url
        $this->languagesGenerator->setImageUrl( $imageUrl );
        
    }
    // set image url
        
    // set lists
    public function setLists( $lists ){
        
        // set lists
        $this->lists = $lists;
        
    }	
    // set lists
    
    // generate field
    public function generate( HtmlGenerator $htmlGenerator, $groupName, $partId, $partName, $part, $savedValue ){
        
        // generator function ! exists
        if( !isset( $this->inputGeneratorFunctions[$part['input']] ) ){
            // debug 
            $this->common->debug( 'error', ' genererate field part unknown input type ' . ' partId: ' . $partId );
            // done
            return;

        }
        // generator function ! exists

        // get function
        $function = $this->inputGeneratorFunctions[$part['input']];
        // call input generator function
        $this->$function( $htmlGenerator, $groupName, $partId, $partName, $part, $savedValue );
                    
    }	
    // generate settings field
        
    // generate languages input
    private function generateLanguages( $htmlGenerator, $groupName, $partId, $name, $part, $savedValue ) {
        
        // generate languages
        $this->languagesGenerator->generate( $htmlGenerator, $groupName, $partId, $name, $part, $savedValue );
                
    }
    // generate languages  input
    
}
