/*
 
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       verticalCollapse.js
        function:   activates vertical collapse buttons

*/

// create function
( function( ) {

    // Function: pleisterman.verticalCollapse( void ) void
    
    // pleisterman object not exists
    window.pleisterman = window.pleisterman ? window.pleisterman : {};
        
    // ! window.$
    window.$ = window.$ ? window.$ : jQuery;

    // create collapse if ! exists
    window.pleisterman.verticalCollapse = window.pleisterman.verticalCollapse ? window.pleisterman.verticalCollapse : {};
    
    // create self
    var self = window.pleisterman.verticalCollapse;
    // PRIVATE:
    
    // MEMBERS:
    self.debugOn = true;
    self.icons = {
        'up'    :   'dashicons-arrow-up-alt2',
        'down'  :   'dashicons-arrow-down-alt2'
    };
    self.timer = null;
    self.ticInterval = 10;
    self.ticHeightDelta = 25;
    self.opening = [];
    self.closing = [];
    // DONE MEMBERS

    // FUNCTIONS
    
    // FUNCTION: init( void ) void
    self.init = function( ) {

        // add top button events
        self.addTopButtonEvents( );

        // add bottom button events
        self.addBottomButtonEvents( );

    };
    // DONE FUNCTION: init( void ) void

    // FUNCTION: addTopButtonEvents( void ) void
    self.addTopButtonEvents = function() {

        // loop over top buttons
        $( ".vertical-collapse-toggle-button-top" ).each(function( index ) {

            // add top button events
            $( this ).mouseenter( function( event ){ self.buttonMouseIn( event ); } );
            $( this ).mouseleave( function( event ){ self.buttonMouseOut( event ); } );
            // add top button events
            
            // has class start open
            if( $( this ).parent().hasClass( 'vertical-collapse-start-open' ) ){

                // find button top button and set icon
                $( this ).removeClass( self.icons['down'] );
                $( this ).addClass( self.icons['up'] );
                // find button top button and set icon

                // add top button event hide
                $( this ).click( function( event ){ self.hide( event ); } );

                // find button bottom button and show it
                $( this ).parent().find( '.vertical-collapse-toggle-button-bottom' ).css( 'display', 'block' );
                
                // find button text container
                var container = $(this).parent().find( '.vertical-collapse-collapse-container' );
                // set text container height
                container.css( 'max-height', container.prop( 'scrollHeight' ) + 'px' );

            }
            else {
                // add top button event show 
                 $( this ).click( function( event ){ self.show( event ); } );
            }
            // has class start open
            
        } );
        // loop over top buttons

    };
    // DONE FUNCTION: addTopButtonEvents( void ) void

    // FUNCTION: addBottomButtonEvents( void ) void
    self.addBottomButtonEvents = function() {
        
        // loop over bottom buttons
        $( ".vertical-collapse-toggle-button-bottom" ).each(function( index ) {

            // add bottom button events
            $( this ).click( function( event ){ self.hide( event ); } );
            $( this ).mouseenter( function( event ){ self.buttonMouseIn( event ); } );
            $( this ).mouseleave( function( event ){ self.buttonMouseOut( event ); } );
            // add bottom button events
            
        } );
        // loop over bottom buttons

    };
    // DONE FUNCTION: addBottomButtonEvents( void ) void

    // FUNCTION: buttonMouseIn( event ) void
    self.buttonMouseIn = function( event ) {

        // set active
        $( event.target ).addClass( 'active' );

    };
    // DONE FUNCTION: buttonMouseIn( void ) void
    
    // FUNCTION: buttonMouseOut( event ) void
    self.buttonMouseOut = function( event ) {

        // set active
        $( event.target ).removeClass( 'active' );

    };
    // DONE FUNCTION: buttonMouseOut( void ) void
    
    // FUNCTION: show( event ) void
    self.show = function( event ) {

        // get parent
        var parent = $( event.target ).parent();

        // find button top button and set icon
        $( parent.find( '.vertical-collapse-toggle-button-top' ) ).removeClass( self.icons['down'] );
        $( parent.find( '.vertical-collapse-toggle-button-top' ) ).addClass( self.icons['up'] );
        // find button top button and set icon

        // find button top button and set event
        $( parent.find( '.vertical-collapse-toggle-button-top' ) ).off( 'click' );
        $( parent.find( '.vertical-collapse-toggle-button-top' ) ).click( function( event ){ self.hide( event ); } );

        // find button bottom button and show it
        $( parent.find( '.vertical-collapse-toggle-button-bottom' ) ).css( 'display', 'block' );

        // add opening
        self.addOpening( parent.find( '.vertical-collapse-collapse-container' ) );

    };
    // DONE FUNCTION: show( event ) void

    // FUNCTION: addOpening( event ) void
    self.addOpening  = function( container ) {
        
        // get index of container in closing
        var index = self.closing.indexOf( container );
        
        // container found
        if( index >= 0 ) {
            // remove container from closing
            self.closing.splice( index, 1 );
        }
        // container found

        // get index of container in opening
        var index = self.opening.indexOf( container );
        
        // container ! found
        if( index < 0 ) {
            // add container to opening
            self.opening.push( container );
        }
        // container ! found
        
        // timer not running
        if( !self.timer ) {
            // set timer
            self.timer = setTimeout( function () { self.tic(); }, self.ticInterval );
        }
        // timer not running
        
    };
    // DONE FUNCTION: addOpening( event ) void

    // FUNCTION: hide( event ) void
    self.hide = function( event ) {

        // get parent
        var parent = $( event.target ).parent();
        
        // find button top button and set icon
        $( parent.find( '.vertical-collapse-toggle-button-top' ) ).removeClass( self.icons['up'] );
        $( parent.find( '.vertical-collapse-toggle-button-top' ) ).addClass( self.icons['down'] );
        // find button top button and set icon

        // find button top button and set event
        $( parent.find( '.vertical-collapse-toggle-button-top' ) ).off( 'click' );
        $( parent.find( '.vertical-collapse-toggle-button-top' ) ).click( function( event ){ self.show( event ); } );

        // find button bottom button and hide it
        $( parent.find( '.vertical-collapse-toggle-button-bottom' ) ).css( 'display', 'none' );

        // add closing
        self.addClosing( parent.find( '.vertical-collapse-collapse-container' ) );
    };
    // DONE FUNCTION: hide( event ) void

    // FUNCTION: addClosing( event ) void
    self.addClosing = function( container ) {
        
        // get index of container in opening 
        var index = self.opening.indexOf( container );
        
        // container found
        if( index >= 0 ) {
            // remove container from opening
            self.opening.splice( index, 1 );
        }
        // container found

        // get index of container in closing
        var index = self.closing.indexOf( container );
        
        // container ! found
        if( index < 0 ) {
            // add container to closing
            self.closing.push( container );
        }
        // container ! found
        
        // timer not running
        if( !self.timer ) {
            // set timer
            self.timer = setTimeout( function () { self.tic(); }, self.ticInterval );
        }
        // timer not running
        
    };
    // DONE FUNCTION: addClosing( event ) void
    
    // FUNCTION: tic( void ) void
    self.tic = function( ) {

        // unset timer
        self.timer = null;

        // create opened indexes
        var openedIndexes = [];
        
        // loop over opening
        for( var i = 0; i < self.opening.length; i++ ){
            
            // get height
            var height = self.opening[i].css( 'max-height' ).replace( "px", '' );
            // 
            height = parseInt( height );
            
            // add delta
            height += self.ticHeightDelta;
            
            // height > scroll height
            if( height > self.opening[i].prop( 'scrollHeight' ) ){
                // add index to opened
                openedIndexes.push( i );
            }
            // height > scroll height
            
            // set height
            self.opening[i].css( 'max-height', parseInt( height ) + 'px' );
        }
        // loop over opening

        // reverse loop over opened indexes
        for( var i = openedIndexes.length - 1; i >= 0; i-- ){
            // remove container from opening
            self.opening.splice( openedIndexes[i], 1 );
        }
        // reverse over opened indexes

        // create closed indexes
        var closedIndexes = [];

        // loop over closing
        for( var i = 0; i < self.closing.length; i++ ){
            // get height
            var height = self.closing[i].css( 'max-height' ).replace( "px", '' );
            // parse int
            height = parseInt( height );
            // subtract delta
            height -= self.ticHeightDelta;
            // get padding top
            var padding = self.closing[i].css( 'padding-top' ).replace( "px", '' );
            // parse int
            padding = parseInt( padding );
            // get padding bottom
            padding += parseInt( self.closing[i].css( 'padding-bottom' ).replace( "px", '' ) );
            
            // height <= 0
            if( height <= 0 ){
                // set height
                height = 0;
                // add index to closed
                closedIndexes.push( i );
            }
            // height <= 0
            
            // set height
            self.closing[i].css( 'max-height', parseInt( height ) + 'px' );
            
        }
        // loop over closing

        // reverse loop over closed indexes
        for( var i = closedIndexes.length - 1; i >= 0; i-- ){
            // remove container from closing
            self.closing.splice( closedIndexes[i], 1 );
        }
        // reverse over closed indexes

        // has opening or closing
        if( self.opening.length > 0 || self.closing.length > 0  ) {
            // set timer
            self.timer = setTimeout( function () { self.tic(); }, self.ticInterval );
        }
        // has opening or closing

    };
    // DONE FUNCTION: tic( void ) void

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
    window.pleisterman.verticalCollapse.init( );    
	
});
// doc loaded
