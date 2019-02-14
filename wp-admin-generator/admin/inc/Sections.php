<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       Sections.php
        function:   handles: 
                        register of page sections
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Common\Common;
use PleistermanWpAdminGenerator\Admin\Base\CommonClass;
use PleistermanWpAdminGenerator\Admin\HtmlGenerators\HtmlGenerator;
use PleistermanWpAdminGenerator\Admin\Fields;

class Sections extends CommonClass {
    
    // members
    private $htmlGenerator = null;
    private $sections = array();
    private $fields = null;
    // members
        
    // construct
    public function __construct( Common $common, HtmlGenerator $htmlGenerator ){
        
        // call parent constructor
        parent::__construct( $common );
        
        // set html generator
        $this->htmlGenerator = $htmlGenerator;
        
        // create fields
        $this->fields = new Fields( $common, $this->htmlGenerator );
    }
    // construct

    // register section
    public function register( $groupName, $settings  ) {
        
        // loop over sections
        foreach ( $settings['sections'] as $sectionId => $section ){
            
            // register section
            add_settings_section( $sectionId, 
                                  __( $section['title'], $this->common->getSetting( 'text-domain' ) ), 
                                  array( $this, 'generateSection' ),
                                  $groupName );
            
            // debug 
            $this->common->debug( 'register-page', 'register section: ' . $sectionId );
            
            // register fields
            $this->fields->register( $groupName, $sectionId, $section['fields'] );
            
            // add section
            $this->addSection( $sectionId, $section );
            
        }
        // loop over sections
        
    }
    // register section

    // add section
    private function addSection( $sectionId, $section ) {

        // add section and atributes
        $this->sections[$sectionId] = $section;
        // add section and atributes
        
    }
    // add section
    
    // generate section
    public function generateSection( $args ) {
        
        // debug 
        $this->common->debug( 'register-page', 'generate section args: ' . json_encode( $args ) );
        
        return $args;
    }
    // register fields
    
    // prepare save
    public function prepareSave( $input ) {
        // prepare save
        return $this->fields->prepareSave( $input );
    }
    // prepare save
    
}
