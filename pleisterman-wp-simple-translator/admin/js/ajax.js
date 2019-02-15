/*
 
        @package    pleisterman/pleisterman-wp-simple-translator
  
        file:       ajax.js
        function:   handles image select selections

*/

// create function
( function( ) {

    // Function: pleisterman.ajax( void ) void
    
    // pleisterman object not exists
    window.pleisterman = window.pleisterman ? window.pleisterman : {};
        
    // ! window.$
    window.$ = window.$ ? window.$ : jQuery;

    // create projects tab if ! exists
    window.pleisterman.ajax = window.pleisterman.ajax ? window.pleisterman.ajax : {};
    
    // create self
    var self = window.pleisterman.ajax;
    // PRIVATE:
    
    // MEMBERS:
    self.debugOn = true;
    self.nextProcesId = 0;
    self.processes = {};   
    // DONE MEMBERS
    
    // FUNCTIONS
    
    // FUNCTION: init( void ) void
    self.init = function( ) {

        // debug 
        self.debug( 'ajax init' );
        
        // add post function
        pleisterman.post = self.post;

    };
    // DONE FUNCTION: init( void ) void
    
    // FUNCTION: post( json: data, function: callback ) void
    self.post = function( data, callback, messageCallback ) {
    
        // enrich data
        data['procesId'] = self.nextProcesId;
        data['pleistermanAjaxNonce'] = window.pleistermanAjaxNonce;
        
        // create proces
        var proces = {  'id' :              self.nextProcesId++,
                        'data' :            data,
                        'callback' :        callback,
                        'messageCallback' : messageCallback };
        // done create proces

        // add to process list
        self.processes[proces['id']] = proces;
        
        // make ajex call
        $.ajax({
            type: "POST",
            async: true,
            url: window.ajaxUrl,
            data: data,
            dataType: 'json',
            success: function( result )
            {
                // succes
                self.succes( result );
            },
            error: function( jqXHR, textStatus, errorThrown )
            {
                // error
                self.error( textStatus, errorThrown );

            }
        });
        // done make ajex call
        
    };
    // DONE FUNCTION: post( json: data, function: callback ) void
    
    // FUNCTION: succes( json: result ) void
    self.succes = function( result ) {
        
        // debug info
        self.debug( 'succes proces: ' + result['data']['procesId'] );
        
        // proces not defined
        if( result['data']['procesId'] === undefined ){
            // debug
            self.debug( 'procesId not found error ' );
            
            // loop over result
            $.each( result, function( index, value ) {
                // debug
                self.debug( index + ": " + value );
            } );
            // loop over result
        }
        else if( !result['data']['pleistermanAjaxNonce'] === undefined ){
            // debug
            self.debug( 'pleistermanAjaxNonce not found error' );
        }
        else {
            // set nonce
            window.pleistermanAjaxNonce = result['data']['pleistermanAjaxNonce'];
            
            // make callback call
            self.processes[result['data']['procesId']]['callback']( result['data'] );

            // create proces count
            var procesCount = 0;
            // loop over processes
            $.each( self.processes, function( procesId, process ) {
                // add one proces
                procesCount++;
            } );
            // done loop over processes
            
            // is last proces
            if( procesCount === 1 ){
                // call message
                self.processes[result['data']['procesId']]['messageCallback']( 'ajax-all-done' );
            }
            else {
                // call message
                self.processes[result['data']['procesId']]['messageCallback']( 'ajax-proces-done' );
            }
            // is last proces
            
            // remove proces
            delete self.processes[result['data']['procesId']];
        }

    }; 
    // FUNCTION: succes( json: result ) void
    
    // FUNCTION: error( json: textStatus, json: errorThrown ) void
    self.error = function( textStatus, errorThrown ) {
        
        // debug info
        self.debug( '-------- ajax failed ---------' + textStatus );
        // debug info
        self.debug( 'textStatus:' + textStatus );
        // debug info
        self.debug( 'errorThrown:' + errorThrown );
        // debug info
        self.debug( '-------- end ajax failed ---------' + textStatus );

    }; 
    // FUNCTION: error( json: result ) void
    
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
    window.pleisterman.ajax.init( );    
	
});
// doc loaded
