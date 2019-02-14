<?php
/*
 *  @package        pleisterman-wp-admin-generator
 *
 *  file:           getTranslations.php
 *  function:       collects translations from the json files for po-edit for the plugin
 * 
 *  website:        https://www.pleisterman.nl/
 *  github:         https://github.com/Pleisterman
 *  description:    Unit test landing page
 *  version:        1.0.0
 *  Author:         Rob Wolters
 *  license:        GPLv2 or later
 *  text domain:    pleisterman-wp-admin-generator
 * 
 *  last-update     30-12-2017
 * 
*/

// create output dir
$translationFileName = dirname( __FILE__ ) . './generated-translations.php';
// create translation file
$translationFile = fopen( $translationFileName, "wb");

// write php open
fwrite( $translationFile, "<?php" . PHP_EOL . PHP_EOL . PHP_EOL );
// write time stamp
fwrite( $translationFile, "// translations collected on " . date("d-m-Y  H:i:s", time() ) . PHP_EOL );


// create translations
$translations = array();

// create menu
$menusFileName = '\..\admin\menus\menus.json';

// get menu json
$menusJson = json_decode( file_get_contents( dirname( __FILE__ ) . $menusFileName ), true );

// add top menu page title
array_push( $translations, $menusJson['top-menu']['page-title'] );
// add top menu menu title
array_push( $translations, $menusJson['top-menu']['menu-title'] );
    
// loop over menus
foreach ( $menusJson['sub-menus'] as $menuId => $menuOptions ) {
    // add sub menu page title
    array_push( $translations, $menuOptions['page-title'] );
    // add sub menu menu title
    array_push( $translations, $menuOptions['menu-title'] );
}
// loop over menus

// create page dir
$pagesDir = dirname( __FILE__ ) . '\..\admin\pages\\';
// create pages
$pages = array(
    'main',
    'test-01',
    'test-02',
    'about-tabs\help',
    'about-tabs\about'
);

// loop over pages
foreach ( $pages as $page ) {

    // get menu json
    $pageJson = json_decode( file_get_contents( $pagesDir . $page . '.json' ), true );

    // has page title
    if( isset( $pageJson['title'] ) ){
        // add page title
        array_push( $translations, $pageJson['title'] );
    }
    // has page title
    
    // has page sub title
    if( isset( $pageJson['sub-title'] ) ){
        // add sub page sub title
        array_push( $translations, $pageJson['sub-title'] );
    }
    // has page sub title
    
    // has page submit text
    if( isset( $pageJson['submit-text'] ) ){
        // add submit text
        array_push( $translations, $pageJson['submit-text'] );
    }
    // has page submit text
    
    // has sections
    if( isset( $pageJson['sections'] ) ){
        // loop over sections
        foreach ( $pageJson['sections'] as $sectionId => $section ) {
     
            // add sub menu page title
            array_push( $translations, $section['title'] );

            // loop over fields
            foreach ( $section['fields'] as $field ) {

                // label exists
                if( isset( $field['label'] ) ){
                    // add label
                    array_push( $translations, $field['label'] );
                }
                // label exists
                
                // loop over parts
                foreach ( $field['parts'] as $partId => $part ) {
                
                    // loop over elements
                    foreach ( $part['elements'] as $element ) {
                        
                        // add part id
                        array_push( $translations, $partId );
                        
                        // text exists
                        if( isset( $element['text'] ) ){
                            // add text
                            array_push( $translations, $element['text'] );
                        }
                        // text exists

                        // placeholder exists
                        if( isset( $element['placeholder'] ) ){
                            // add placeholder
                            array_push( $translations, $element['placeholder'] );
                        }
                        // placeholder exists
                        
                        // default value exists and is string
                        if( isset( $element['default-value'] ) && is_string( $element['default-value'] ) ){
                            // add placeholder
                            array_push( $translations, $element['default-value'] );
                        }
                        // placeholder exists
                        
                    }
                    // loop over elements
            
                }
                // loop over parts
            }
            // loop over sections

        }
        // loop over sections
    }
    // has sections
    
}
// loop over pages

// remove duplicates
$translations = array_unique ( $translations );

// loop over translations
foreach ( $translations as $translation ) {
    
    // string not empty
    if( !empty( $translation ) ){
        // write translation
        fwrite( $translationFile, '__( "' . $translation . '" );' . PHP_EOL );
    }
    // string not empty
}
// loop over translations
