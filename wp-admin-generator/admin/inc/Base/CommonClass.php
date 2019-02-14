<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       SectionGenerator.php
        function:   Generates section html for admin pages
*/

namespace PleistermanWpAdminGenerator\Admin\Base;

use PleistermanWpAdminGenerator\Common\Common;

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
