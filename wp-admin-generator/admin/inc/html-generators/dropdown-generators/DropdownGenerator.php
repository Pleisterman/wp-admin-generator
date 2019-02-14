<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       DropdownGenerator.php
        function:   Generates dropdown html for admin pages
*/

namespace PleistermanWpAdminGenerator\Admin\HtmlGenerators\DropdownGenerators;

use PleistermanWpAdminGenerator\Common\Common;
use PleistermanWpAdminGenerator\Admin\Base\CommonClass;
use PleistermanWpAdminGenerator\Admin\HtmlGenerators\DropdownGenerators\DefaultDropdownGenerator;
use PleistermanWpAdminGenerator\Admin\HtmlGenerators\DropdownGenerators\DivDropdownGenerator;

class DropdownGenerator extends CommonClass {
    
    // members
    private $lists = null;
    private $defaultDropdownGenerator = null;
    private $divDropdownGenerator = null;
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

        // create default dropdown generator
        $this->defaultDropdownGenerator = new DefaultDropdownGenerator( $common );

        // create div dropdown generator
        $this->divDropdownGenerator = new DivDropdownGenerator( $common );
        
    }
    // construct

    // set lists
    public function setLists( $lists ){
        
        // set lists
        $this->lists = $lists;
        
    }	
    // set lists
        
    // generate dropdown
    public function generate( $partId, $partName, $part, $savedValue ){
        
        // list-id ! exists or list ! exists
        if( !isset( $part['list-id'] ) || !$this->lists->getList( $part['list-id'] ) ){
            // debug 
            $this->common->debug( 'error', 'generate list-id not found field: ' . $partName  );
            // return with error
            return;
        }
        // list-id ! exists or list ! exists
        
        // no type or type text
        if( !isset( $part['type'] ) || $part['type'] == 'text' ){
            // generate text dropdown
            $this->defaultDropdownGenerator->generate( $this->lists->getList( $part['list-id'] ), $partId, $partName, $part, $savedValue );
        }
        // no type or type text
        
        // type image
        if( isset( $part['type'] ) && $part['type'] == 'image' ){
            // generate image dropdown
            $this->divDropdownGenerator->generate( $this->lists->getList( $part['list-id'] ), $partId, $partName, $part, $savedValue );
        }
        // type image
        
    }	
    // generate dropdown
        
}
