/*
 
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       debugger.js
        function:   handles image select selections

*/

// create function
( function( ) {

    // Function: pleisterman.debugger( void ) void
    
    // pleisterman object not exists
    window.pleisterman = window.pleisterman ? window.pleisterman : {};
        
    // ! window.$
    window.$ = window.$ ? window.$ : jQuery;

    // create projects tab if ! exists
    window.pleisterman.debugger = window.pleisterman.debugger ? window.pleisterman.debugger : {};
    
    // create self
    var self = window.pleisterman.debugger;
    // PRIVATE:
    
    // MEMBERS:
    self.debugOn = true;
    self.lineCounter = 0;                               // integer: line counter
    self.options = null;
    // DONE MEMBERS
    
    // FUNCTIONS
    
    // FUNCTION: init( void ) void
    self.init = function( ) {
        
        // get options
        self.options = window.pleistermanDebugOptions;

        // create screen
        self.createScreen();
        
        // add functions to application 
        pleisterman.debug = self.debug;
            
        // add events
        self.addEvents();
        
        // debug
        self.debug( 'debugger started' );
    };
    // DONE FUNCTION: init( void ) void

    // FUNCTION: createScreen( void ) void
    self.createScreen = function( ) {

            // create the html for the window
            var html = '';
            // debug div
            html += '<div id="debug-div" ';
                html += 'style="';
                    html += ' position:absolute; ';
                    html += ' top: ' + self.options['top'] + 'px; ';
                    html += ' left: ' + self.options['left'] + 'px;';
                    html += ' z-index: ' + self.options['z-index'] + ';';
                    html += ' border: lightblue 1px groove; ';
                    html += ' border-radius: 5px; ';
                html += '"';
            html += '>';
                // drag handle
                html += '<div id="debug-div-drag-handle" ';
                    html += 'style="';
                        html += ' cursor:move; ';
                        html += ' width:100%; ';
                        html += ' height:20px; ';
                        html += ' background-color:green; ';
                    html += '"';
                html += '>';
                
                html += '</div>';
                html += '<div id="debug-div-content" ';
                    html += 'style="';
                        html += ' line-height: 1.2em; ';
                        html += ' overflow: auto; ';
                        html += ' width: ' + self.options['width'] + 'px; ';
                        html += ' height: ' + self.options['height'] + 'px;';
                        html += ' background-color:black;color:white; ';
                    html += '"';
                html += '>';

                html += '</div>';
            html += '</div>';
            // done debug div
            $( document.body ).append( html );
            

    };
    // DONE FUNCTION: createScreen( void ) void

    // FUNCTION: addEvents( void ) void
    self.addEvents = function( ) {
        // add the drag events
        $("#debug-div-drag-handle" ).mouseenter( function( ){ self.dragHandleMouseIn(); } );
        $("#debug-div-drag-handle" ).mouseout( function(){ self.dragHandleMouseOut(); } );
        $("#debug-div-drag-handle" ).mousedown( function( event ){ self.dragHandleMouseClick( event ); } );
        // add the drag events
    };
    // DONE FUNCTION: addEvents( void ) void
    
    self.dragHandleMouseIn = function( ) {
    // FUNCTION: dragHandleMouseIn( void ) void

        //self.debug( ' over');
        $("#debug-div-drag-handle" ).css('background-color', 'lightgreen' ); 

    // DONE FUNCTION: dragHandleMouseIn( void ) void
    };
    self.dragHandleMouseOut = function( ) {
    // FUNCTION: dragHandleMouseOut( void ) void

        //self.debug( ' out' );
        $("#debug-div-drag-handle" ).css('background-color', 'green' ); 

    // DONE FUNCTION: dragHandleMouseOut( void ) void
    };
    self.dragHandleMouseClick = function( event ) {
    // FUNCTION: dragHandleMouseClick( event: event ) void

        //self.debug( ' down' );
        self.lastPosition = { 'x' : event.pageX, 'y' : event.pageY };

        $(document).on( 'mousemove', function( event ) { self.move( event ); } );
        $(document).on( 'mouseup', function( event ) { self.up( event ); } );

    // DONE FUNCTION: dragHandleMouseClick( event: event ) void
    };
    self.move = function( event ) {
    // FUNCTION: move( event: event ) void

        //self.debug( ' move' );
        self.positionChange = { 'x' : 0, 'y' : 0 };
        self.positionChange['y'] = self.lastPosition['y'] - event.pageY;
        self.positionChange['x'] = self.lastPosition['x'] - event.pageX;
        var newTop = parseFloat( $('#debug-div').offset().top ) - parseFloat( self.positionChange['y'] ),
            newLeft = parseFloat( $('#debug-div').offset().left ) - parseFloat( self.positionChange['x'] );
        if( newTop < 0 ){
            newTop = 0;
        } 
        if( newLeft < 0 ){
            newLeft = 0;
        } 

        $( '#debug-div' ).css( 'top', newTop );
        $( '#debug-div' ).css( 'left', newLeft );
        self.lastPosition = { 'x' : event.pageX, 'y' : event.pageY };

    // DONE FUNCTION: move( event: event ) void
    }; 
    self.up = function( event ) { 
    // FUNCTION: up( event: event ) void

        //self.debug( ' up' );
        $(document).off('mousemove');
        $(document).off('mouseup');

    // DONE FUNCTION: up( event: event ) void
    }; 
    self.active = function( active ) { 
    // FUNCTION: active( boolean: active ) void

        // show is true
        if( active ){
            // add message
            $( '#debug-div-content' ).prepend( self.pad( self.lineCounter, '0', 2 ) + '-' + 'Debugger started' + '<br/>' );
            // line counter +1
            self.lineCounter++;
            // line counter max 9
            self.lineCounter %= 10; 
            // show debugger
            $( '#debug-div-content' ).show();
        }
        else {
            // add message
            $( '#debug-div-content' ).prepend( self.pad( self.lineCounter, '0', 2 ) + '-' + 'Debugger stopped' + '<br/>' );
            // line counter +1
            self.lineCounter++;
            // line counter max 9
            self.lineCounter %= 10; 
            // hide debugger
            $( '#debug-div-content' ).hide();
        }
        // show is true

        // set debug on
        self.debugOn = active;   

    // DONE FUNCTION: active( boolean: active ) void
    }; 
    self.pad = function( string, padWith, padCount ) {
    // FUNCTION: pad( string: string, string: padWith, integer: padCount ) json

        // add padding to a string
        string = string.toString();
        // string lenght < pad count
        while( string.length < padCount ){
            string = padWith + string;
        }
        // done string lenght < pad count

        return string;

    // DONE FUNCTION: pad( string: string, string: padWith, integer: padCount ) json
    };
    self.debug = function( message ){
    // FUNCTION: debug( string: message ) void

        // debug on, function prepends the message to the div
        if( self.debugOn && self.options['debug-on'] ) {
            // prepend info
            $( '#debug-div-content' ).prepend( self.pad( self.lineCounter, '0', 2 ) + '-' + message + '<br/>' );
            // line counter +1
            self.lineCounter++;
            // line counter max 9
            self.lineCounter %= 10; 
        }
        // debug on, function prepends the message to the div
        
    // DONE FUNCTION: debug( string: message ) void
    };
    
    // DONE FUNCTIONS
})( );
// done create function
 
// doc loaded
$( document ).ready( function( ) {
    
    // init image select tab
    window.pleisterman.debugger.init( );    
	
});
// doc loaded
