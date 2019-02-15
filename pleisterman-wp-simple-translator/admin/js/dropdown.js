/*
 
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       dropdown.js
        function:   handles image select selections

*/

// create function
( function( ) {

    // Function: pleisterman.dropdown( void ) void
    
    // pleisterman object not exists
    window.pleisterman = window.pleisterman ? window.pleisterman : {};
        
    // ! window.$
    window.$ = window.$ ? window.$ : jQuery;

    // create projects tab if ! exists
    window.pleisterman.dropdown = window.pleisterman.dropdown ? window.pleisterman.dropdown : {};
    
    // create self
    var self = window.pleisterman.dropdown;
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

        // add button events
        self.addButtonEvents( );
        
        // add row events
        self.addRowEvents( );

        // show selection
        self.showSelection();
        
    };
    // DONE FUNCTION: init( void ) void

    // FUNCTION: addButtonEvents( void ) void
    self.addButtonEvents = function() {
        
        // loop over buttons
        $( ".div-dropdown-button" ).each( function( index ) {
            
            // add button event show content
            $( this ).click( function( event ){ self.showContent( event ); } );
            
        } );
        // loop over buttons
    };
    // DONE FUNCTION: addButtonEvents( void ) void
    
    // FUNCTION: addRowEvents( void ) void
    self.addRowEvents = function() {
        
        // loop over rows
        $( ".div-dropdown-row" ).each( function( index ) {
            
            // add button event show content
            $( this ).click( function( event ){ self.select( event ); } );
            
        } );
        // loop over rows
    };
    // DONE FUNCTION: addRowEvents( void ) void
    
    // FUNCTION: showSelection( void ) void
    self.showSelection = function( ) {
        
        // loop over buttons
        $( ".div-dropdown-button" ).each(function( index ) {
            
            // find hidden input
            $( this ).parent().find( 'input' ).each( function( ) {
                
                // get selection div
                var selection = $( this ).parent().find( '.div-dropdown-selection' );
                
                // get value
                var value = $( this ).prop( 'value' );
                
                // find rows
                $( this ).parent().find( 'div' ).each( function( index ) {
                
                    // find rows
                    if( $( this ).prop( 'id' ) === value ){
                        // set selection content
                        selection.html( $( this ).html() );
                    }
                
                } );
                // find hidden rows
            } );
            // find hidden input
        } );
        // loop over buttons
        
    };
    // DONE FUNCTION: showSelection( void ) void
    
    // FUNCTION: select( event ) void
    self.select = function( event ) {
        
        // get collapse container parent
        var collapseContainerParent = $( event.target ).parent().parent().parent().parent();
        
        // loop over buttons
        collapseContainerParent.find( ".div-dropdown-button" ).each( function( index ) {
            
            // set button icon
            $( this ).removeClass( self.icons['up'] );
            $( this ).addClass( self.icons['down'] );
            // set icon
            
            // set button event
            $( this ).off( 'click' );
            $( this ).click( function( event ){ self.showContent( event ); } );
            // set button event
        } );
        // loop over buttons
        
        // get selection div
        var selection = collapseContainerParent.parent().find( '.div-dropdown-selection' );
       
        // has class drop-down-row
        if( $( event.target ).hasClass( 'div-dropdown-row' ) ){
            // set selection content
            selection.html( $( event.target ).html() );
        }
        else {
            // set selection content
            selection.html( $( event.target ).parent().html() );
        }
        // has class drop-down-row
                    

        // find hidden input
        var input = collapseContainerParent.find( 'input' );
        input.prop( 'value', $( event.target ).parent().prop( 'id' ) );
        
        // add closing 
        self.addClosing( collapseContainerParent.find( '.div-dropdown-collapse-container' ) );
        
    };
    // DONE FUNCTION: select( void ) void

    
    // FUNCTION: showContent( event ) void
    self.showContent = function( event ) {
    
        // get parent
        var parent = $( event.target ).parent();
    
        // set button icon
        $( event.target ).removeClass( self.icons['down'] );
        $( event.target ).addClass( self.icons['up'] );
        // set icon
        
        // set button event
        $( event.target ).off( 'click' );
        $( event.target ).click( function( event ){ self.hideContent( event ); } );
        // set button event
        
        // add opening 
        self.addOpening( parent.find( '.div-dropdown-collapse-container' ) );
        
    };
    // DONE FUNCTION: showContent( event ) void
    
    // FUNCTION: addOpening( element ) void
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
    
    // FUNCTION: hideContent( event ) void
    self.hideContent = function( event ) {
    
        // get parent
        var parent = $( event.target ).parent();
    
        // set button icon
        $( event.target ).removeClass( self.icons['up'] );
        $( event.target ).addClass( self.icons['down'] );
        // set icon
        
        // set button event
        $( event.target ).off( 'click' );
        $( event.target ).click( function( event ){ self.showContent( event ); } );
        // set button event
        
        // add closing
        self.addClosing( parent.find( '.div-dropdown-collapse-container' ) );
        
    };
    // DONE FUNCTION: hideContent( event ) void
    
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

        // loop over opened indexes
        for( var i = 0; i < openedIndexes.length; i++ ){
            // remove container from opening
            self.opening.splice( openedIndexes[i], 1 );
        }
        // loop over opened indexes

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

        // loop over closed indexes
        for( var i = 0; i < closedIndexes.length; i++ ){
            // remove container from closing
            self.closing.splice( closedIndexes[i], 1 );
        }
        // loop over closed indexes

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
    
    // init image select tab
    window.pleisterman.dropdown.init( );    
	
});
// doc loaded
