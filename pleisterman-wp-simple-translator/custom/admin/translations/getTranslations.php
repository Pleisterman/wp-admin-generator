<?php
/*
 *  @package        pleisterman-wp-simple-translator
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
 *  text domain:    pleisterman-wp-simple-translator
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
$menusFileName = '\..\menus\menus.json';

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
$pagesDir = dirname( __FILE__ ) . '\..\pages\\';
// create pages
$pages = array(
    'main',
    'main-tabs\languages',
    'main-tabs\options',
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
    
    // has before form
    if( isset( $pageJson['before-form'] ) ){
        
        // loop over elements
        foreach ( $pageJson['before-form'] as $element ) {
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
        }
        // loop over elements
    }
    // has before form
    
    // has after form
    if( isset( $pageJson['after-form'] ) ){
        
        // loop over elements
        foreach ( $pageJson['after-form'] as $element ) {
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
        }
        // loop over elements
    }
    // has after form
    
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
                        
                        // placeholder exists
                        if( isset( $element['values'] ) ){
                            // loop over values
                            foreach ( $element['values'] as $value ) {
                                // add value
                                array_push( $translations, $value );
                                
                            }
                            // loop over values
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

// create list dir
$listsDir = dirname( __FILE__ ) . '\..\lists\\';

// get file list from lists dir
$listsFileList = scandir( $listsDir );

// loop over lists file list
for( $i = 0; $i < count( $listsFileList ); $i++ ){

    // ! dir
    if( !is_dir( $listsDir . $listsFileList[$i] ) ){
        // get json
        $listJson = json_decode( file_get_contents( $listsDir . $listsFileList[$i] ), true );
        // loop over list
        foreach ( $listJson as $id => $values ) {
            // text exists
            if( isset( $values['text'] ) ){
                // add text
                array_push( $translations, $values['text'] );
            }
            // text exists
        }

    
    }
    // done ! dir
}
// done loop over lists file list

// create main list dir
$mainListsDir = dirname( __FILE__ ) . '\..\..\..\admin\lists\\';

// get file list from main lists dir
$mainListsFileList = scandir( $mainListsDir );

// loop over main lists file list
for( $i = 0; $i < count( $mainListsFileList ); $i++ ){

    // ! dir
    if( !is_dir( $mainListsDir . $mainListsFileList[$i] ) &&
        $mainListsFileList[$i] != 'icons.json' &&
        $mainListsFileList[$i] != 'languages.json' ){
        // get json
        $listJson = json_decode( file_get_contents( $mainListsDir . $mainListsFileList[$i] ), true );
        // loop over list
        foreach ( $listJson as $id => $values ) {
            // text exists
            if( isset( $values['text'] ) ){
                // add text
                array_push( $translations, $values['text'] );
            }
            // text exists
        }

    
    }
    // done ! dir
}
// done loop over main lists file list

// add messages
$messagesDirFile = dirname( __FILE__ ) . '\..\inc\localize-scripts\messages.json';

// is file
if( is_file( $messagesDirFile ) ){
    
    // get json
    $messagesJson = json_decode( file_get_contents( $messagesDirFile ), true );
    
    // loop over messages
    foreach ( $messagesJson as $id ) {
        // add id
        array_push( $translations, $id );
    }
}

// add messages


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
