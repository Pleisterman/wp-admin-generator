/*
 
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       save-languages-ajax.js
        function:   handles saving languages through ajax calls

*/

// create function
( function( ) {

    // Function: pleisterman.saveLanguages( void ) void
    
    // pleisterman object not exists
    window.pleisterman = window.pleisterman ? window.pleisterman : {};
        
    // ! window.$
    window.$ = window.$ ? window.$ : jQuery;

    // create collapse if ! exists
    window.pleisterman.saveLanguages = window.pleisterman.saveLanguages ? window.pleisterman.saveLanguages : {};
    
    // create self
    var self = window.pleisterman.saveLanguages;
    // PRIVATE:
    
    // MEMBERS:
    self.debugOn = true;
    self.timer = null;
    self.ticInterval = 3000;
    self.languages = [];
    // DONE MEMBERS
    
    // FUNCTIONS
    
    // FUNCTION: init( void ) void
    self.init = function( ) {
        
        // debug
        self.debug( 'init languages' );
        // debug
        self.debug( 'use ajax: ' + window.pleistermanUseAjax );
        
        // get languages
        self.languages = $( '#languages' ).val().split( ',' );
        
        // clean add list
        self.cleanAddList();
        
        // add events
        self.addEvents();

    };
    // DONE FUNCTION: init( void ) void
    
    // FUNCTION: cleanAddList( void ) void
    self.cleanAddList = function() {
        
        // create first visible option
        var firstVisibleOption = null;
        
        // loop over list items
        $( '#language-add-list option' ).each( function() {

            // language exists
            if( jQuery.inArray( $( this ).val(), self.languages ) >= 0 ) {
               
               self.debug( 'in array: ' + jQuery.inArray( $( this ).val(), self.languages ) );
               
               self.debug( 'hiding: ' + $( this ).val() );
               
                // hide option
                $( this ).css( 'display', 'none' );
            }
            else {
                // not first visible option
                if( !firstVisibleOption ){
                    // set first visible option
                    firstVisibleOption = $( this ).val();
                }
                // not first visible option
                
            }
            // language exists
            
        } );
        // loop ober list items

        // select first visible option
         $( '#language-add-list' ).val( firstVisibleOption );

    };
    // DONE FUNCTION: cleanAddList( void ) void
    
    // FUNCTION: addEvents( void ) void
    self.addEvents = function() {
        
        // add button events
        self.addButtonEvents();

        // add order button events
        self.addOrderButtonEvents();        
        
        // loop over languages
        for( var i = 0; i < self.languages.length; i++ ) {
          
          // add activate click
          $( '#' + self.languages[i] + '-slug' ).change( function( event ){ self.slugChange( event ); } );

          // add activate click
          $( '#' + self.languages[i] + '-active' ).click( function( event ){ self.changeActivate( event ); } );

          // add input click
          $( '#' + self.languages[i] + '-input-language' ).click( function( event ){ self.changeInput( event ); } );

          // add default click
          $( '#' + self.languages[i] + '-default-language' ).click( function( event ){ self.changeDefault( event ); } );

            
        }
        // loop over languages
        
    };
    // DONE FUNCTION: addEvents( void ) void
    
    // FUNCTION: addButtonEvents( void ) void
    self.addButtonEvents = function() {
        
        // loop over buttons
        $( ".button" ).each( function( index ) {
            
            // add button click event
            $( this ).click( function( event ){ self.buttonClick( event ); } );
            
        } );
        // loop over buttons
        
    };
    // DONE FUNCTION: addButtonEvents( void ) void
    
    // FUNCTION: addOrderButtonEvents( void ) void
    self.addOrderButtonEvents = function() {
        
        // loop over order down containers
        $( ".order-button-down-container" ).each( function( index ) {
            
            // add click event
            $( this ).click( function( event ){ self.orderDownClick( event ); } );
            
        } );
        // loop over order down containers
        
        // loop over order up containers
        $( ".order-button-up-container" ).each( function( index ) {
            
            // add click event
            $( this ).click( function( event ){ self.orderUpClick( event ); } );
            
        } );
        // loop over order up containers
        
    };
    // DONE FUNCTION: addOrderButtonEvents( void ) void
    
    // FUNCTION: slugChange( event ) void
    self.slugChange = function( event ) {

        self.debug( 'slugChange' );
        
        // slugs are ! unique
        if( !self.slugsUnique( event ) ){
            // done with error
            return;
        }
        // slugs are ! unique
        
        // split id
        var idArray = $( event.target ).prop( 'id' ).split( '-' );
        // get language
        var language = idArray[0];
        // get slug
        var slug = $( '#' + language + '-slug' ).val();
        // debug info
        self.debug( 'slug: ' + slug );
        
        // use ajax
        if( window.pleistermanUseAjax ){
            // create data
            var data = {
                'subject' :     'languages',
                'action' :      'update-slug',
                'language' :    language,
                'value' :       slug
            };
            // create data

            // call post
            pleisterman.post( data, self.changeOptionCallback, self.ajaxMessageCallback );

            // show message
            self.showMessage( 'saving' );
            
        }
        // use ajax
        
    };
    // DONE FUNCTION: slugChange( void ) void
    
    // FUNCTION: slugsUnique( event ) void
    self.slugsUnique = function( event ) {
        
        // create slugs
        var slugs = {};
        // create not unique
        var unique = true;
        // create not unique slugs
        var notUniqueSlugs = {};
        
        // loop over slugs
        $( 'input[id*="slug"]' ).each( function( index ) {

            // slugs value exists
            if( slugs[$( this ).val()] ){
                // set unique
                unique = false;
                // add to not unique
                notUniqueSlugs[$( this ).val()] = true;
            }
            // slugs value exists
            
            // add slug
            slugs[$( this ).val()] = true;
            
        } );
        // loop over slugs

        // loop over slugs
        $( 'input[id*="slug"]' ).each( function( index ) {

            // in not unique
            if( notUniqueSlugs[$( this ).val()] ){
                // add error
                $( this ).addClass( 'error' );
            }
            else {
                // remove error
                $( this ).removeClass( 'error' );
            }
            // in not unique

        } );
        // loop over slugs
            
        // ! unique
        if( !unique ){
            
            // not unique
            self.debug( 'not unique' );
            // prevent default
            event.preventDefault();
            // show message
            self.showMessage( 'slugs-must-be-unique', true );
        }
        // ! unique

        // slugs are unique
        return unique;
        
    };
    // DONE FUNCTION: slugsUnique( void ) void
    
    // FUNCTION: buttonClick( event ) void
    self.buttonClick = function( event ) {
        
        // debug
        self.debug( 'click: ' + $( event.target ).prop( 'id' ) );

        // slugs are ! unique
        if( !self.slugsUnique( event ) ){
            // done with error
            return;
        }
        // slugs are ! unique

        // is delete 
        if( $( event.target ).prop( 'id' ).indexOf( 'delete' ) > 0 ){
            // split id
            var idArray = $( event.target ).prop( 'id' ).split( '-' );
            // set language selection
            $( '#selection' ).val( idArray[0] );
            // set action
            $( '#action' ).val( 'delete' );
        }
        // is update or insert


        // is update or insert
        if( $( event.target ).prop( 'id' ) === 'update' ||
            $( event.target ).prop( 'id' ) === 'insert' ){
        
            // set action
            $( '#action' ).val( $( event.target ).prop( 'id' ) );
        }
        // is update or insert

        // get form
        var form = $( document ).find( 'form' ).first();
        // submit the form
        form.submit();
        
    };
    // DONE FUNCTION: buttonClick( event ) void
    
    // FUNCTION: orderDownClick( event ) void
    self.orderDownClick = function( event ) {
        
        // debug
        self.debug( 'orderDownClick: ' + $( event.target ).prop( 'id' ) );
        
        // slugs are ! unique
        if( !self.slugsUnique( event ) ){
            // done with error
            return;
        }
        // slugs are ! unique
                
        // split id
        var idArray = $( event.target ).prop( 'id' ).split( '-' );
        // set language selection
        $( '#selection' ).val( idArray[0] );
        // set action
        $( '#action' ).val( 'order-down' );
        
        // get form
        var form = $( document ).find( 'form' ).first();
        // submit the form
        form.submit();
        
    };
    // DONE FUNCTION: orderDownClick( event ) void
    
    // FUNCTION: orderUpClick( event ) void
    self.orderUpClick = function( event ) {
        
        // debug
        self.debug( 'orderUpClick: ' + $( event.target ).prop( 'id' ) );

        // slugs are ! unique
        if( !self.slugsUnique( event ) ){
            // done with error
            return;
        }
        // slugs are ! unique
        
        // split id
        var idArray = $( event.target ).prop( 'id' ).split( '-' );
        // set language selection
        $( '#selection' ).val( idArray[0] );
        // set action
        $( '#action' ).val( 'order-up' );
        
        // get form
        var form = $( document ).find( 'form' ).first();
        // submit the form
        form.submit();
        
    };
    // DONE FUNCTION: orderDownClick( event ) void
    
        
    // FUNCTION: changeActivate( event ) void
    self.changeActivate = function( event ) {
        
        // debug
        self.debug( 'changeActivate' );
        
        // get input language
        var inputLanguage =  $('input[id*="input-language"]:checked' ).val();
        
        // get default language
        var defaultLanguage = $('input[id*="default-language"]:checked' ).val();
        
        // debug
        self.debug( $( event.target ).prop( 'id' ) );
        // split id
        var idArray = $( event.target ).prop( 'id' ).split( '-' );
        // get language
        var language = idArray[0];
        
        // is input language
        if( language === inputLanguage ){
            // prevent default
            event.preventDefault();
            // show message
            self.showMessage( 'Cannot deactivate input language' );
            // done
            return;
        }
        // is input language
        
        // is default language
        if( language === defaultLanguage ){
            // prevent default
            event.preventDefault();
            // show message
            self.showMessage( 'Cannot deactivate default language' );
            // done
            return;
        }
        // is default language
        
        // create active
        var active = false;
        
        // is checked
        if( $( '#' + language + '-active' ).prop( 'checked' ) ){
            // set active
            active = true;
        }
        // is checked
        
        // debug info
        self.debug( 'active: ' + active );
        
        // use ajax
        if( window.pleistermanUseAjax ){
            // create data
            var data = {
                'subject' :     'languages',
                'action' :      'update-active',
                'language' :    language,
                'value' :       active
            };
            // create data

            // call post
            pleisterman.post( data, self.changeOptionCallback, self.ajaxMessageCallback );

            // show message
            self.showMessage( 'saving' );
            
        }
        // use ajax
        
    };
    // DONE FUNCTION: changeActivate( event ) void
    
    // FUNCTION: changeDefault( event ) void
    self.changeDefault = function( event ) {
        
        // debug
        self.debug( 'changeDefault' );

        // split id
        var idArray = $( event.target ).prop( 'id' ).split( '-' );
        // get language
        var language = idArray[0];
        
        // language not active
        if( $( '#' + language + '-active' ).prop( 'checked' ) === false ) {
            // prevent default
            event.preventDefault();
            // show message
            self.showMessage( 'Cannot set deactivated language default language' );
            // done
            return;
        }
        // language not active
        
        // get input language
        var inputLanguage =  $('input[id*="input-language"]:checked' ).val();
        
        // get default language
        var defaultLanguage = $('input[id*="default-language"]:checked' ).val();
        
        // debug
        self.debug( 'changeDefault default: ' + defaultLanguage );
        
        // loop over languages
        for( var i = 0; i < self.languages.length; i++ ) {
        
            // not default and not input
            if( self.languages[i] !== inputLanguage && 
                self.languages[i] !== defaultLanguage ){
                // show delete button
                $( '#' + self.languages[i] + '-delete-button' ).css( 'display', 'inline-block' );
            }
            else {
                // hide delete button
                $( '#' + self.languages[i] + '-delete-button' ).css( 'display', 'none' );
            }
            // not default and not input
            
        }
        // loop over languages
        
        // use ajax
        if( window.pleistermanUseAjax ){
            // create data
            var data = {
                'subject' :     'languages',
                'action' :      'update-default',
                'value' :       language
            };
            // create data

            // call post
            pleisterman.post( data, self.changeOptionCallback, self.ajaxMessageCallback );

            // show message
            self.showMessage( 'saving' );
            
        }
        // use ajax
        
    };
    // DONE FUNCTION: changeDefault( event ) void
    
    // FUNCTION: changeInput( event ) void
    self.changeInput = function( event ) {
        
        // debug
        self.debug( 'changeInput' );

        // split id
        var idArray = $( event.target ).prop( 'id' ).split( '-' );
        // get language
        var language = idArray[0];
        
        // language not active
        if( $( '#' + language + '-active' ).prop( 'checked' ) === false ) {
            // prevent default
            event.preventDefault();
            // show message
            self.showMessage( 'Cannot set deactivated language input language' );
            // done
            return;
        }
        // language not active
        
        // get input language
        var inputLanguage =  $('input[id*="input-language"]:checked' ).val();
        
        // get default language
        var defaultLanguage = $('input[id*="default-language"]:checked' ).val();
        
        // debug
        self.debug( 'changeDefault default: ' + defaultLanguage );
        
        // loop over languages
        for( var i = 0; i < self.languages.length; i++ ) {
        
            // not default and not input
            if( self.languages[i] !== inputLanguage && 
                self.languages[i] !== defaultLanguage ){
                // show delete button
                $( '#' + self.languages[i] + '-delete-button' ).css( 'display', 'inline-block' );
            }
            else {
                // hide delete button
                $( '#' + self.languages[i] + '-delete-button' ).css( 'display', 'none' );
            }
            // not default and not input
            
        }
        // loop over languages
        
        // use ajax
        if( window.pleistermanUseAjax ){
            // create data
            var data = {
                'subject' :     'languages',
                'action' :      'update-input',
                'value' :       language
            };
            // create data

            // call post
            pleisterman.post( data, self.changeOptionCallback, self.ajaxMessageCallback );

            // show message
            self.showMessage( 'saving' );
            
        }
        // use ajax
        
    };
    // DONE FUNCTION: changeInput( event ) void
    
    // FUNCTION: showMessage( void ) void
    self.showMessage = function( message, isError ) {
        
        // timer running
        if( self.timer ) {
            // clear timer
            clearTimeout( self.timer ); 
        }
        // timer running
            
        // message exists    
        if( pleistermanMessages[message] ){
            // set message
            message = pleistermanMessages[message];
        }    
        // message exists    
            
        // set message
        $( '#message' ).html( message );
        
        // is error
        if( isError ){
            // add error class
            $( '#message' ).addClass( 'error' );
        }
        // is error
        
        // set timer
        self.timer = setTimeout( function () { self.tic(); }, self.ticInterval );
    };
    // DONE FUNCTION: showMessage( void ) void
    
    // FUNCTION: tic( void ) void
    self.tic = function( ) {

        // unset timer
        self.timer = null;
        
        // clear message
        $( '#message' ).html( '' );
        // remove error class
        $( '#message' ).removeClass( 'error' );
        
    };
    // DONE FUNCTION: tic( void ) void
    
    
    // FUNCTION: changeOptionCallback( result ) void
    self.changeOptionCallback = function( result ) {
      
        // debug
        self.debug( 'change options callback result: ' + result['settingsId'] );
        
    };
    // DONE FUNCTION: changeOptionCallback( result ) void
    
    // FUNCTION: ajaxMessageCallback( eventId ) void
    self.ajaxMessageCallback = function( eventId ) {
      
        // debug
        self.debug( 'message callback result: ' + eventId );
      
        // ajax proces done
        if( eventId === 'ajax-proces-done' ){
            
            // timer running
            if( self.timer ) {
                // clear timer
                clearTimeout( self.timer ); 
            }
            // timer running
            
            // message empty
            if( $( '#message' ).html() === '' ){
                // set message
                $( '#message' ).html( window.pleistermanMessages['data-saved'] );
            }
            else {
                // set message
                $( '#message' ).html( $( '#message' ).html() + '.' );
            }
            // message empty
            
        }
        // ajax proces done
      
        // ajax all done
        if( eventId === 'ajax-all-done' ){
            // set message
            $( '#message' ).html( window.pleistermanMessages['data-saved'] );
            
            // timer running
            if( self.timer ) {
                // clear timer
                clearTimeout( self.timer ); 
            }
            // timer running
            
            // set timer
            self.timer = setTimeout( function () { self.tic(); }, self.ticInterval );
        }
        // proces ready
        
    };
    // DONE FUNCTION: ajaxMessageCallback( result ) void
        
    // FUNCTION: debug( string ) void
    self.debug = function( message ) {
      
        // debug on and pleisterman debug exists
        if( self.debugOn && pleisterman.debug !== undefined ){
            // add message
            pleisterman.debug( message );
        }
        // debug on and pleisterman debug exists
        
    };
    // DONE FUNCTION: debug( event ) void
    
    // DONE FUNCTIONS
})( );
// done create function
 
// doc loaded
$( document ).ready( function( ) {
    
    // init collapse
    window.pleisterman.saveLanguages.init( );    
	
});
// doc loaded
