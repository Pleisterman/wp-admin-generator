<?php
/*
        @package    pleisterman/pleisterman-wp-admin-generator
  
        file:       FieldGenerator.php
        function:   Generates field html for admin pages
*/

namespace PleistermanWpSimpleTranslator\Custom\Admin\FieldGenerators;

use PleistermanWpSimpleTranslator\Common\Common;
use PleistermanWpSimpleTranslator\Admin\Base\CommonClass;
use PleistermanWpSimpleTranslator\Admin\HtmlGenerators\HtmlGenerator;

class LanguagesGenerator extends CommonClass {
    
    // members
    private $listsDir = "\..\..\..\..\admin\lists\\";
    private $languagsList = null;
    private $imageUrl = '';
    private $languageElementsFile = '\languageListItems.json';
    private $languageElements = array();
    // members
        
    // construct
    public function __construct( Common $common ){
        
        // call parent constructor
        parent::__construct( $common );

        // get lists dir
        $this->listsDir = dirname( __FILE__ ) . $this->listsDir;
        
    }
    // construct
    
    // set image url
    public function setImageUrl( $imageUrl ){
        
        // set image url
        $this->imageUrl = $imageUrl;
        
    }
    // set image url
        
    // generate languages
    public function generate( HtmlGenerator $htmlGenerator, $groupName, $partId, $name, $part, $savedLanguages ){

        // debug 
        $this->common->debug( 'languages-field', 'generate languages-field savedLanguages: ' . json_encode( $savedLanguages ) );
            
        // get language elements
        $this->getElements();
        
        // saved languages empty
        if( empty( $savedLanguages ) ){
            
            // get language text
            $languageText = $this->getLanguageText( get_locale() );
            
            // create local language in saved languages
            $savedLanguages = array(
                array(
                    'id' =>             get_locale(),               
                    'text' =>           $languageText,               
                    'input' =>          true,
                    'active' =>         true,
                    'default' =>        true
                )
            );
            // create local language in saved languages
            
            // get option
            $settings = json_decode( get_option( $groupName ), true );
            
            // settings ! array
            if( !is_array( $settings ) ){
                // create empty settings
                $settings = array();
            }
            // settings ! array
        
            // add language to settings language list
            $settings['language-list'] = json_encode( $savedLanguages );
            
            // update settings
            update_option( $groupName, $settings );
            
        }
        else {
                
            // decode saved value
            $savedLanguages = json_decode( $savedLanguages, true );

        }
        // saved languages empty
        
     
        // create languages
        $languages = array();
        
        // create counter
        $languageCounter = 0;

        
        // loop over elements
        foreach( $this->languageElements['headers'] as $element ) {

            // generate header
            $this->generateHeader( $htmlGenerator, $element );
        }
        // loop over elements
        
        // loop over saved languages
        foreach ( $savedLanguages as $savedLanguage ) {

            // add language
            array_push( $languages, $savedLanguage['id'] );
            
            // create is first
            $isFirst = $languageCounter == 0 ? true : false;
            // create is last
            $isLast = $languageCounter == count( $savedLanguages ) - 1 ? true : false;
            
            // loop over elements
            foreach( $this->languageElements['items'] as $element ) {
            
                // generate element
                $this->generateElement( $htmlGenerator, $groupName, $element, $savedLanguage, $isFirst, $isLast );
            }
            // loop over elements
            
            // counter += 1
            $languageCounter++;
        }
        // loop over saved languages
        
        // add languages field
        echo '<input id="languages" name="' . $groupName . '[languages]" type="hidden" value="' . implode( ',', $languages ) . '" >';

        // add action field
        echo '<input id="action" name="' . $groupName . '[action]" type="hidden" value="" >';
        
        // add selection field
        echo '<input id="selection" name="' . $groupName . '[selection]" type="hidden" value="" >';
        
    }	
    // generate languages
        
    // generate header
    private function generateHeader( $htmlGenerator, $element ){
        
        // debug
        //$this->common->debug( 'languages-field', 'generate languages element' );
        
        // get text domain
        $textDomain = $this->common->getSetting( 'text-domain' );

        // has text
        if( isset( $element['text'] ) ){
            // translate
            $element['text'] = __( $element['text'], $textDomain );
        }
        // has text
        
        // generate element
        $htmlGenerator->generateElement( $element );
            
    }	
    // generate header
   
    // generate element
    private function generateElement( $htmlGenerator, $groupName, $element, $savedLanguage, $isFirst, $isLast ){
        
        // debug
        //$this->common->debug( 'languages-field', 'generate languages element' );
        
        // get text domain
        $textDomain = $this->common->getSetting( 'text-domain' );
        
        // has generate as
        if( isset( $element['generate-as'] ) ){

            // is generate as order button down
            if( $element['generate-as'] == 'order-button-down' ){
                // add id
                $element['id'] = $savedLanguage['id'] . '-order-down';
            }
            // is generate as order button down

            // is generate as order button up
            if( $element['generate-as'] == 'order-button-up' ){
                // add id
                $element['id'] = $savedLanguage['id'] . '-order-up';
            }
            // is generate as order button up

            // is generate as name    
            if( $element['generate-as'] == 'name' ){
                // add text
                $element['text'] = $this->getLanguageText( $savedLanguage['id'] );
            }
            // is generate as name    

            // is generate as slug    
            if( $element['generate-as'] == 'slug' ){
                
                // add id
                $element['id'] = $savedLanguage['id'] . '-slug';
                // add text
                $element['value'] = isset( $savedLanguage['slug'] ) ? $savedLanguage['slug'] : '';
                // add name
                $element['name'] = $groupName . '[' . $savedLanguage['id'] . '-slug]';
            }
            // is generate as slug    

            // is generate as order up button    
            if( $element['generate-as'] == 'order-button-up' && $isFirst ){
                // add hidden
                $element['style'] = 'display:none;';
            }
            // is generate as order up button        

            // is generate as order up button    
            if( $element['generate-as'] == 'order-button-down' && $isLast ){
                // add hidden
                $element['style'] = 'display:none;';
            }
            // is generate as order up button        

            // is generate as active    
            if( $element['generate-as'] == 'active' ){
                
                // add id
                $element['id'] = $savedLanguage['id'] . '-active';
                // add name
                $element['name'] = $groupName . '[' . $savedLanguage['id'] . '-active]';
                
                // add text
                $element['text'] = __( 'active', $textDomain );
                
                // active exists
                if( isset( $savedLanguage['active'] ) ){
                    // add checked
                     $element['checked'] = true;
                }
                // active exists
                
            }
            // is generate as active    

            // is generate as input language    
            if( $element['generate-as'] == 'input-language' ){
                // add id
                $element['id'] = $savedLanguage['id'] . '-input-language';
                // add name
                $element['name'] = $groupName . '[input-language]';
                // add value
                $element['value'] = $savedLanguage['id'];
                
                // input exists
                if( isset( $savedLanguage['input'] ) ){
                    
                    // add checked
                     $element['checked'] = true;
                }
                // input exists
                
            }
            // is generate as input language       

            // is generate as default language    
            if( $element['generate-as'] == 'default-language' ){
                // add id
                $element['id'] = $savedLanguage['id'] . '-default-language';
                // add name
                $element['name'] = $groupName . '[default-language]';
                // add value
                $element['value'] = $savedLanguage['id'];
                
                // default exists
                if( isset( $savedLanguage['default'] ) ){
                    // add checked
                     $element['checked'] = true;
                }
                // default exists
                
            }
            // is generate as default language        
            
            // is generate as delete    
            if( $element['generate-as'] == 'delete-button' ){
                // add id
                $element['id'] = $savedLanguage['id'] . '-delete-button';
                // add text
                $element['text'] =  __( 'Delete', $textDomain );
                // input-language exists
                if( isset( $savedLanguage['input'] ) || isset( $savedLanguage['default'] ) ){
                    // add hidden
                    $element['style'] = 'display:none;';
                }
                // input-language exists
                
            }
            // is generate as delete    

        }
        // has generate as

        // generate element
        $htmlGenerator->generateElement( $element );
            
    }	
    // generate element
        
    // get language elements
    private function getElements( ) {
        
        // get dir  file name
        $dirFileName = dirname( __FILE__ ) . $this->languageElementsFile;

        // file ! exists
        if( !is_file( $dirFileName ) ){
            // debug
            $this->common->debug( 'error', 'generate languages language elements file not found: ' . $dirFileName );
            // return empty array
            return [];
        }
        // file ! exists

        // return json
        $this->languageElements = json_decode( file_get_contents( $dirFileName ), true );
        
    }
    // get language elements
        
    // get language text
    private function getLanguageText( $languageId ) {
        
        // language list ! exists
        if( !$this->languagsList ){
            // languages json ! exists
            if( !is_file( $this->listsDir . 'languages.json' ) ){
                // debug
                $this->common->debug( 'error', 'generate languages languages list file not found: ' . $this->listsDir . 'languages.json' );
                // done with error
                return $languageId;
            }
            // languages json ! exists
            
            // load language list
            $this->languagsList = json_decode( file_get_contents( $this->listsDir . 'languages.json' ), true );
        }
        // language list ! exists
        
        // language id exists
        if( isset( $this->languagsList[$languageId] ) ){
            // return text
            return $this->languagsList[$languageId]['text'];
        }
        // language id exists
        
        // not found
        return $languageId;
        
    }
    // get language text
}
