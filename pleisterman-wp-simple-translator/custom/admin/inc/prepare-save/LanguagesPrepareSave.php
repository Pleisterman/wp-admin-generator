<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       FieldGenerator.php
        function:   Generates field html for admin pages
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\PrepareSave;

use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;

class LanguagesPrepareSave extends CommonClass {
    
        
    // prepare save field
    public function prepareSave( $input ) {
        
        // action not set
        if( !isset( $input['action'] ) ){
            // done
            return $input;
        }
        // action not set

        // debug 
        $this->common->debug( 'languages-field', 'prepareSave input: ' . json_encode( $input ) );

        // create languages
        $languages = $this->getLanguages( $input );
        
        // debug 
        $this->common->debug( 'languages-field', 'prepareSave action: ' .  $input['action'] );
        
        // is insert action
        if( $input['action'] == 'insert' ){
            
            // insert language
            $languages = $this->insert( $languages, $input );

        }
        // is insert action

        // is delete action
        if( $input['action'] == 'delete' ){

            // delete language
            $languages = $this->delete( $languages, $input );
            
        }
        // is delete action
        
        // is order down action
        if( $input['action'] == 'order-down' ){

            // order dwon
            $languages = $this->orderDown( $languages, $input );
            
        }
        // is order down action
        
        // is order up action
        if( $input['action'] == 'order-up' ){

            // order up
            $languages = $this->orderUp( $languages, $input );
            
        }
        // is order up action
        
        // create output
        $output = array( 
            'language-list' => json_encode( $languages )
        );
        // create output
        
        // debug 
        $this->common->debug( 'languages-field', 'prepareSave output: ' . json_encode( $output ) );
        
        return $output;
    }	
    // prepare save field
       
    // get languages
    private function getLanguages( $input ) {
        
        // create languages
        $languages = array();
        
        
        
        // loop over input languages
        foreach( explode( ',', $input['languages'] ) as $inputLanguage ) {
            // add language to languages
            $language = array( 'id' => $inputLanguage );
            
            // slug is set
            if(  isset( $input[$inputLanguage . '-slug'] ) ){
                // set default
                $language['slug'] = $input[$inputLanguage . '-slug'];
            }
            // default is set
            
            // default is set
            if(  isset( $input['default-language'] ) && $input['default-language'] == $inputLanguage ){
                // set default
                $language['default'] = true;
            }
            // default is set
            
            // input is set
            if( isset( $input['input-language'] ) && $input['input-language'] == $inputLanguage ){
                // set input
                $language['input'] = true;
            }
            // input is set
            
            // active is set
            if( isset( $input[$inputLanguage . '-active'] ) ){
                // set active
                $language['active'] = true;
            }
            // active is set
            
            // add language
            array_push( $languages, $language );
        }
        // loop over languages
        
        // return languages
        return $languages;
        
    }
    
    // insert
    private function insert( $languages, $input ) {
        
        // add language
        array_push( $languages, array( 'id' => $input['language-add-list'], 'slug' => $input['language-add-list'] ) );
        
        // return languages
        return $languages;
        
    }
    // insert
    
    // delete
    private function delete( $languages, $input ) {
        
        // create language index
        $languageIndex = -1;

        // loop over languages
        for( $i = 0; $i < count( $languages ); $i++ ){
            // is selected language
            if( $languages[$i]['id'] == $input['selection'] ){
                // set index
                $languageIndex = $i;
            }
            // is selected language
        }
        // loop over languages

        // index found
        if( $languageIndex >= 0 ){
            // remove language
             array_splice( $languages, $languageIndex, 1 );
        }
        // index found
        
        // return languages
        return $languages;
        
    }
    // delete
    
    // order down
    private function orderDown( $languages, $input ) {
        
        // create language index
        $languageIndex = -1;

        // loop over languages
        for( $i = 0; $i < count( $languages ); $i++ ){
            // is selected language
            if( $languages[$i]['id'] == $input['selection'] ){
                // set index
                $languageIndex = $i;
            }
            // is selected language
        }
        // loop over languages

        // index found
        if( $languageIndex >= 0 ){
            // remove language
             $language = array_splice( $languages, $languageIndex, 1 );
             // add language on next index
             array_splice( $languages, $languageIndex + 1, 0, $language );
        }
        // index found
        
        // return languages
        return $languages;
        
    }
    // order down
    
    // order up
    private function orderUp( $languages, $input ) {
        
        // create language index
        $languageIndex = -1;

        // loop over languages
        for( $i = 0; $i < count( $languages ); $i++ ){
            // is selected language
            if( $languages[$i]['id'] == $input['selection'] ){
                // set index
                $languageIndex = $i;
            }
            // is selected language
        }
        // loop over languages

        // index found
        if( $languageIndex >= 0 ){
            // remove language
             $language = array_splice( $languages, $languageIndex, 1 );
             // add language on next index
             array_splice( $languages, $languageIndex - 1, 0, $language );
        }
        // index found
        
        // return languages
        return $languages;
        
    }
    // order up
    
}
