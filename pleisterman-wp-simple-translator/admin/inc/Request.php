<?php
/*
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       page.php
        function:   handles: 
                        register of page tabs, sections and fields
                        show page
*/

namespace PleistermanWpSimpleTranslator\Admin;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class Request extends CommonClass {
    
    // members
    // members
        
    // is wp ajax
    public function isWpAjax( ) {
        
        // wordpress is doing ajax
        if( wp_doing_ajax() ){
            
            // my page but no ajax action for now
            return true;
        }
        // wordpress is doing ajax

        // not a ajax request
        return false;
    } 
    // is wp ajax
    
    // is ajax
    public function isAjax( ) {
        
        // $_POST exists and pleisterman ajax nonce exists
        if( isset( $_POST ) && isset( $_POST['pleistermanAjaxNonce'] ) ){
            // is a ajax request
            return true;
        }
        // $_POST exists and pleisterman ajax nonce exists
        
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
    
    // valid ajax request
    public function ajaxIsValid( ) {
        
        // debug 
        $this->common->debug( 'ajax', 'ajax post: ' . json_encode( $_POST ) );
        // debug 
        $this->common->debug( 'ajax', 'ajax get: ' . json_encode( $_GET ) );
        
        // check nonce
        if( !isset( $_POST ) || !isset( $_POST['pleistermanAjaxNonce'] ) ){

            // debug 
            $this->common->debug( 'error', 'pleistermanAjaxNonce not found ' );
            // nonce not found
            return false;
        }
        // check nonce
        
    
        if( !check_ajax_referer( 'pleistermanAjaxNonce', 'pleistermanAjaxNonce' ) ){
            // debug 
            $this->common->debug( 'error', 'pleistermanAjaxNonce is invalid ' );
            // nonce invalid
            return false;
        }
        

        // debug 
        $this->common->debug( 'ajax', 'pleistermanAjaxNonce is valid ' );
        
        // ajax is valid
        return true;
    }
    // valid ajax request
    
    // ajax succes
    public function ajaxSucces( $data ) {

        // enhance data
        $data['procesId'] = $_POST['procesId'];
        $data['pleistermanAjaxNonce'] = wp_create_nonce( 'pleistermanAjaxNonce' );
        // enhance data
        
        // send wp json succes
        wp_send_json_success( $data );
        
    }
    // ajax succes
    
}
