test( "Base tag inserted only if dynamic base tag support is enabled", function() {
	var docBaseUrl = $.mobile.path.documentBase.hrefNoSearch;

	deepEqual( $( "head" ).children( "base" ).length, 0, "Initially, no base tag is present" );

	$.mobile.dynamicBaseEnabled = false;
	$.mobile.base.set( "http://example.com/" );
	deepEqual( $( "head" ).children( "base" ).length, 0,
		"Calling set() while the flag is disabled causes no base tag to be inserted" );

	$.mobile.dynamicBaseEnabled = true;
	$.mobile.base.set( "http://example.com/" );
	deepEqual( $( "head" ).children( "base" ).length, 1,
		"Calling set() while the flag is enabled causes one base tag to be inserted" );
	deepEqual( $( "head" ).children( "base" ).attr( "href" ), "http://example.com/",
		"The base URL is correctly set after calling set() while the flag is enabled" );

	$.mobile.dynamicBaseEnabled = false;
	$.mobile.base.reset();
	deepEqual( $( "head" ).children( "base" ).length, 1,
		"Calling reset() while the flag is disabled causes no more base tags to be inserted" );
	deepEqual( $( "head" ).children( "base" ).attr( "href" ), "http://example.com/",
		"The base remains correct after calling reset() with the flag unset" );

	$.mobile.dynamicBaseEnabled = true;
	$.mobile.base.reset();
	deepEqual( $( "head" ).children( "base" ).length, 1,
		"Calling reset() while the flag is enabled causes no more base tags to be inserted" );
	deepEqual( $( "head" ).children( "base" ).attr( "href" ), docBaseUrl,
		"Calling reset() while the flag is enabled correctly resets the base URL" );
});
