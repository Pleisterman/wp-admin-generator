<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       SectionGenerator.php
        function:   Generates section html for admin pages
*/

namespace PleistermanWpSimpleTranslator\Admin\Base;

use PleistermanWpSimpleTranslator\Common\Common;

class CommonClass {
    
    // members
    protected $common = null;
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // set common
        $this->common = $common;

    }
    // construct
    
}
