<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       HtmlGenerator.php
        function:   Generates html for admin pages
*/

namespace PleistermanWpSimpleTranslator\Admin\HtmlGenerators;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;
use PleistermanWpSimpleTranslator\Admin\HtmlGenerators\ElementGenerator;
use PleistermanWpSimpleTranslator\Admin\HtmlGenerators\TitleGenerator;
use PleistermanWpSimpleTranslator\Admin\HtmlGenerators\TabsGenerator;
use PleistermanWpSimpleTranslator\Admin\HtmlGenerators\FormGenerator;
use PleistermanWpSimpleTranslator\Admin\HtmlGenerators\FieldGenerators\FieldGenerator;

class HtmlGenerator extends CommonClass {
    
    // members
    private $elementGenerator = null;
    private $titleGenerator = null;
    private $tabsGenerator = null;
    private $formGenerator = null;
    private $fieldGenerator = null;
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );
       
        // create html generator classes
        $this->elementGenerator = new ElementGenerator( $this->common ); 
        $this->titleGenerator = new TitleGenerator( $this->common ); 
        $this->tabsGenerator = new TabsGenerator( $this->common ); 
        $this->formGenerator = new FormGenerator( $this->common ); 
        $this->fieldGenerator = new FieldGenerator( $this->common ); 
        // create html generator classes
    }
    // construct
    
    // set image url
    public function setImageUrl( $imageUrl ){
        
        // set image url of element generator
        $this->elementGenerator->setImageUrl( $imageUrl );
        // set image url of fields generator
        $this->fieldGenerator->setImageUrl( $imageUrl );
        
    }
    // set image url
        
    // set lists
    public function setLists( $lists ){
        
        // set lists of fields generator
        $this->fieldGenerator->setLists( $lists );
        
    }	
    // set lists
    
    // load saved values
    public function loadSavedValues( $optionId ){
        
        // call fields generator
        $this->fieldGenerator->loadSavedValues( $optionId );
        
    }	
    // load saved values
    
    // generate title
    public function generateTitle( ){
        
        // generate title
        $this->titleGenerator->generateTitle();
        
    }	
    // generate title
    
    // generate sub title
    public function generateSubTitle( $settings ) {

        // generate title
        $this->titleGenerator->generateSubTitle( $settings );
        
    }	
    // generate sub title

    // generate tabs
    public function generateTabs( $slug, $pageOptions, $tabs, $selectedTabId ){
        
        // create tabs
        $this->tabsGenerator->generateTabs( $slug, $pageOptions, $tabs, $selectedTabId );
        
    }	
    // generate tabs

    // generate settings field
    public function generateField( $args ){
        
        
        // generate field
        $this->fieldGenerator->generate( $this, $args );
        
    }	
    // generate settings field
    
    // open field container
    public function openContainer( $args ){
        
        
        // open field container
        $this->elementGenerator->openContainer( $args );
        
    }	
    // open field container
    
    // close field container
    public function closeContainer( $args ){
        
        
        // close field container
        $this->elementGenerator->closeContainer( $args );
        
    }	
    // close field container
    
    // generate settings form
    public function generateForm( $settingsId, $settings ){
        
        
        // generate form
        $this->formGenerator->generate( $settingsId, $settings );
        
    }	
    // generate settings form
    
    // generate element
    public function generateElement( $options ){
        
        // generate element
        $this->elementGenerator->generate( $options );
        
    }	
    // generate element
    
}
