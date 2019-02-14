<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       Lists.php
        function:   handles: 
                        loading lists
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Common\Common;
use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class Lists extends CommonClass {
    
    // members
    private $lists = array();
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

    }
    // construct
    
    // load
    public function load( $path, $lists ) {
        
        // debug 
        $this->common->debug( 'lists', 'load lists', 'before' );
        
        
        $this->common->debug( 'lists', 'path: ' . $path  );
        
        // loop over lists
        for( $i = 0; $i < count( $lists ); $i++ ){
        
                $this->common->debug( 'lists', 'file: ' . $lists[$i]  );
                
            // file exists
            if( is_file( $path . $lists[$i] .  '.json' ) ){
                // get listId
                $listId = basename( $lists[$i] );
                // add tab json
                $this->lists[$listId] = json_decode( file_get_contents( $path . $lists[$i] .  '.json' ), true );
                // debug 
                $this->common->debug( 'lists', 'loaded list: ' . $listId  );
            }
            else {
                // debug 
                $this->common->debug( 'error', 'load lists file not found path: ' . $path  );
                $this->common->debug( 'error', 'load lists file not found file: ' . $lists[$i] .  '.json'  );
                // debug 
            }
            // file exists
        }
        // loop over lists
        
        // debug 
        $this->common->debug( 'lists', 'load lists', 'after' );
    }
    // load
    
    // get list
    public function getList( $listId ) {
        
        // list id exists
        if( isset( $this->lists[$listId] ) ){
            // return list
            return $this->lists[$listId];
        }
        // list id exists
        
        // debug 
        $this->common->debug( 'error', 'get list list not found listId: ' . $listId  );
        
        // return with error
        return false;
    }
    // get list
}
