<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       Lists.php
        function:   handles: 
                        loading lists
*/

namespace PleistermanWpSimpleTranslator\Admin;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class Lists extends CommonClass {
    
    // members
    private $lists = array();
    private $listsDir = "/../lists/";
    private $customListsDir = "/../../custom/admin/lists/";
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

        // get lists dir
        $this->listsDir = dirname( __FILE__ ) . $this->listsDir;
        
        // get custom lists dir
        $this->customListsDir = dirname( __FILE__ ) . $this->customListsDir;
        
    }
    // construct
    
    // load
    public function load( $lists ) {
        
        // debug 
        $this->common->debug( 'lists', 'load lists', 'before' );
        
        
        // debug
        $this->common->debug( 'lists', 'customListDir: ' . $this->customListsDir  );
        // debug
        $this->common->debug( 'lists', 'listDir: ' . $this->listsDir  );
        
        // loop over lists
        for( $i = 0; $i < count( $lists ); $i++ ){
        
            // debug
            $this->common->debug( 'lists', 'file: ' . $lists[$i]  );
                
            // create list found
            $listFound = false;
            
            // file exists in custom list dir
            if( is_file($this->customListsDir . $lists[$i] .  '.json' ) ){
                // set list found
                $listFound = true;
                // get listId
                $listId = basename( $lists[$i] );
                // add tab json
                $this->lists[$listId] = json_decode( file_get_contents($this->customListsDir . $lists[$i] .  '.json' ), true );
                // debug 
                $this->common->debug( 'lists', 'loaded list: ' . $listId  );
            }
            // file exists in custom list dir
            
            // list not found is file in list dir
            if( !$listFound && is_file($this->listsDir . $lists[$i] .  '.json' ) ){
                // set list found
                $listFound = true;
                // get listId
                $listId = basename( $lists[$i] );
                // add tab json
                $this->lists[$listId] = json_decode( file_get_contents($this->listsDir . $lists[$i] .  '.json' ), true );
                // debug 
                $this->common->debug( 'lists', 'loaded list: ' . $listId  );
            }
            // list not found and is file in list dir
                
            // list not found
            if( !$listFound ){
                // debug 
                $this->common->debug( 'error', 'load lists file not found file: ' . $lists[$i] .  '.json'  );
                // debug 
            }
            // list not found
            
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
