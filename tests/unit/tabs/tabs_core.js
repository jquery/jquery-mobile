( function() {

var originalBase,
	originalBaseSupport,
	phonyDirectory = "/foo/bar/baz/";

module( "Tabs extension", {
	setup: function() {
		originalBaseSupport = $.support.dynamicBaseTag;
		$.support.dynamicBaseTag = true;
		originalBase = $.mobile.base.element.attr( "href" );
		$.mobile.base.set( phonyDirectory );
	},
	teardown: function() {
		$.support.dynamicBaseTag = originalBaseSupport;
		$.mobile.base.set( originalBase );
	}
} );

test( "_isLocal() correctly identifies URLs as local/non-local", function() {

	var _isLocal = $.ui.tabs.prototype._isLocal;

	deepEqual( _isLocal( $( "<a href='#some-id'></a>" )[ 0 ] ), true,
		"'#some-id' identified as local" );

	deepEqual( _isLocal( $( "<a href='" + phonyDirectory + "#some-other-id'></a>" )[ 0 ] ), true,
		"'" + phonyDirectory + "#some-other-id' defined as local" );

} );

} )();
