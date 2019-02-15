/*
 
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       save-options-ajax.js
        function:   handles saving options through ajax calls

*/

// create function
( function( ) {

    // Function: pleisterman.saveOptions( void ) void
    
    // pleisterman object not exists
    window.pleisterman = window.pleisterman ? window.pleisterman : {};
        
    // ! window.$
    window.$ = window.$ ? window.$ : jQuery;

    // create collapse if ! exists
    window.pleisterman.saveOptions = window.pleisterman.saveOptions ? window.pleisterman.saveOptions : {};
    
    // create self
    var self = window.pleisterman.saveOptions;
    // PRIVATE:
    
    // MEMBERS:
    self.debugOn = true;
    self.timer = null;
    self.ticInterval = 1000;
    // DONE MEMBERS
    
    // FUNCTIONS
    
    // FUNCTION: init( void ) void
    self.init = function( ) {
        
        // debug
        self.debug( 'save options init' );
        
        // add input events
        self.addInputEvents();

    };
    // DONE FUNCTION: init( void ) void
    
    // FUNCTION: addInputEvents( void ) void
    self.addInputEvents = function() {
        
        // loop over inputs
        $( ".option" ).each( function( index ) {
            
            // add input change event
            $( this ).change( function( event ){ self.changeOption( event ); } );
            
        } );
        // loop over inputs
        
    };
    // DONE FUNCTION: addInputEvents( void ) void
    
    // FUNCTION: changeOption( event ) void
    self.changeOption = function( event ) {
      
        // options use ajax is false
        if( $('input[id="options-use-ajax"]:checked' ).val() === 'false' ){
            // don't use ajax
            return;
        }
        // options use ajax is false
        
        // debug
        self.debug( 'change' );
        
        // debug
        self.debug( $( event.target ).prop( 'name' ) );
        
        // get input name
        var name = $( event.target ).prop( 'name' );
        // debug
        self.debug( $('input[name="' + name + '"]:checked' ).val() );
        
        // create data
        var data = {
            'subject' :     'options',
            'action' :      'save',
            'optionId' :    $( event.target ).prop( 'id' ),
            'value' : $('input[name="' + name + '"]:checked' ).val()
        };
        // create data
        
        // call post
        pleisterman.post( data, self.changeOptionCallback, self.ajaxMessageCallback );
        
        // set message
        $( '#message' ).html( window.pleistermanMessages['saving'] );
    };
    // DONE FUNCTION: changeOption( event ) void
    
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
    
    
    // FUNCTION: tic( void ) void
    self.tic = function( ) {

        // unset timer
        self.timer = null;
        
        // clear message
        $( '#message' ).html( '' );
        
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
    window.pleisterman.saveOptions.init( );    
	
});
// doc loaded
