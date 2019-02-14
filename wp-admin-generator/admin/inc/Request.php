<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       page.php
        function:   handles: 
                        register of page tabs, sections and fields
                        show page
*/

namespace PleistermanWpAdminGenerator\Admin;

use PleistermanWpAdminGenerator\Admin\Base\CommonClass;

class Request extends CommonClass {
    
    // members
    // members
        
    // is ajax
    public function isAjax( ) {
        
        // debug 
        $this->common->debug( 'is-ajax', ' request url: ' . $_SERVER['REQUEST_URI'] );

        // wordpress is doing ajax
        if( wp_doing_ajax() ){
            
            // debug 
            $this->common->debug( 'is-ajax', 'doing ajax' );

            // my page but no ajax action for now
            return true;
        }
        // wordpress is doing ajax

            // debug 
            $this->common->debug( 'is-ajax', 'not ajax' );
        // not a ajax request
        return false;
    } 
    // is ajax
    
    // is post
    public function isPost( ) {
        
        // $_POST exists
        if( isset( $_POST ) && isset( $_POST['_wp_http_referer'] ) ){
            // a post request
            return true;
        }
        // $_POST exists
        
        // not a post request
        return false;
    }
    // is post
    
    // get page id
    public function getPageId( ) {

        // get and get['page'] exist
        if( isset( $_GET ) && isset( $_GET['page'] ) ){
            // debug 
            $this->common->debug( 'admin-init', '$_GET page found pageId: ' . $_GET['page'] );
            // return page
            return $_GET['page'];
        
        }        
        // get and get['page'] exist
        
        // post and post['_wp_http_referer'] exist
        if( isset( $_POST ) && isset( $_POST['_wp_http_referer'] ) ){
            // split 'page='
            $refererParts = explode( 'page=', $_POST['_wp_http_referer'] );
            // split '&'
            $refererParts = explode( '&', $refererParts[count( $refererParts ) - 1] );
            // debug 
            $this->common->debug( 'admin-init', '$_POST page found pageId: ' . $refererParts[0] );
             // return page
            return $refererParts[0];
        
        }        
        // get and get['page'] exist
        
    }
    // get page id
    
    // get tab id
    public function getTabId( ) {

        // get and get['tab'] exist
        if( isset( $_GET ) && isset( $_GET['tab'] ) ){
            // debug 
            $this->common->debug( 'tabs', '$_GET found tab: ' . $_GET['tab'] );
            // return tab
            return $_GET['tab'];
        
        }        
        // get and get['tab'] exist
        
        // post and post['_wp_http_referer'] exist
        if( isset( $_POST ) && isset( $_POST['_wp_http_referer'] ) && strstr( $_POST['_wp_http_referer'], 'tab='  ) ){
            
            // split 'page='
            $refererParts = explode( 'tab=', $_POST['_wp_http_referer'] );
            // split '&'
            $refererParts = explode( '&', $refererParts[count( $refererParts ) - 1] );
            // debug 
            $this->common->debug( 'tabs', '$_POST found tab: ' . $refererParts[0] );
            // return page
            return $refererParts[0];
        
        }        
        // get and get['page'] exist
        
        // debug 
        $this->common->debug( 'tabs', '$_GET and $_POST no tab selected' );
        
    }
    // get tab id
    
}
