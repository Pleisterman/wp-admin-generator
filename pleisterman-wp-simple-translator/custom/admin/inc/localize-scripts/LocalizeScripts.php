<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       LocalizeScripts.php
        function:   handles custom main 
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\LocalizeScripts;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;


class LocalizeScripts extends CommonClass {
    
    // members
    private $localizeScriptFunctions = array(
    );
    private $useAjaxIsSet = false;
    private $messagesIsSet = false;
    // members
        
    // localize scripts
    public function localizeScripts( $scriptId, $handle ) {
    
        // debug
        $this->common->debug( 'add-js', 'add js localize custom script: ' . $scriptId );
        
        // localize script function exists
        if( isset( $this->localizeScriptFunctions[$scriptId] ) ){
            // get function
            $function = $this->localizeScriptFunctions[$scriptId];
            // call ajax function
            $this->$function( $scriptId, $handle );
        }
        // localize script function exists
        
        // use ajax is ! set
        if( !$this->useAjaxIsSet ){
            // add use ajax
            $this->addUseAjax( $handle );
        }
        // use ajax is ! set
        
        // messages is ! set
        if( !$this->messagesIsSet ){
            // add messages
            $this->addMessages( $handle );
        }
        // use ajax is ! set
    }
    // localize scripts
    
    // add use ajax
    private function addUseAjax( $handle ) {
        
        // use ajax is set
        if( $this->useAjaxIsSet ){
            //already set
            return;
        }
        // use ajax is set
        
        // set use ajax is set
        $this->useAjaxIsSet = true;
        
        //  debug
        $this->common->debug( 'add-js', 'add js add use ajax var.' );
        
        // get plugin id
        $pluginId = $this->common->getSetting( 'plugin-id' );
        // get options
        $options = $this->common->getOption( $pluginId . '-options' );
        // create use ajax
        $useAjax = 'false'; 
        
        // use ajax exists and use ajax
        if( isset( $options['options-use-ajax'] ) && $options['options-use-ajax'] == 'true' ){
            // set use ajax
            $useAjax = 'true'; 
        }
        // use ajax exists and use ajax
        
        // add variable
        wp_localize_script( $handle, 'pleistermanUseAjax', $useAjax );
        
    }
    // add use ajax
    
    // add messages
    private function addMessages( $handle ) {

        // messages is set
        if( $this->messagesIsSet ){
            //already set
            return;
        }
        // messages is set
        
        // get text domain
        $textDomain = $this->common->getSetting( 'text-domain' );
        
        // create dir file name
        $dirFileName = dirname( __FILE__ ) . '/messages.json';
        
        // message file ! exists
        if( !is_file( $dirFileName ) ){
            // debug
            $this->common->debug( 'error', 'add js localize message file not found: ' . $dirFileName );
            // done with error
            return;
        }
        // message file ! exists

        // create messages 
        $messages = array();
        
        // read message id's
        $messageIds = json_decode( file_get_contents( $dirFileName ), true );
        
        // loop over message id's
        foreach( $messageIds as $messageId ){
            // add message
            $messages[$messageId] = __( $messageId, $textDomain );
        }
        // loop over message id's        
        
        // add variable
        wp_localize_script( $handle, 'pleistermanMessages', $messages );
        
        // set messages is set
        $this->messagesIsSet = true;

    }
    // add messages

}
