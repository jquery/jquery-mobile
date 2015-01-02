//>>excludeStart("jqmBuildExclude", pragmas.jqmBuildExclude);
//>>description: Dynamic Base Tag Support
//>>label: Base Tag
//>>group: Navigation
define([
	"jquery",
	"./path",
	"./../ns" ], function( jQuery ) {
//>>excludeEnd("jqmBuildExclude");

(function( $, undefined ) {

	var base,

		// existing base tag?
		baseElement = $( "head" ).children( "base" ),

		// DEPRECATED as of 1.5.0 and will be removed in 1.6.0. As of 1.6.0 only
		// base.dynamicBaseEnabled will be checked
		getDynamicEnabled = function() {
			if ( $.mobile.dynamicBaseEnabled !== undefined ) {
				return $.mobile.dynamicBaseEnabled;
			}
			return base.dynamicBaseEnabled;
		};

	// base element management, defined depending on dynamic base tag support
	// TODO move to external widget
	base = {

		// disable the alteration of the dynamic base tag or links
		dynamicBaseEnabled: true,

		// Make sure base element is defined, for use in routing asset urls that are referenced
		// in Ajax-requested markup
		element: function() {
			if ( !( baseElement && baseElement.length ) ) {
				baseElement = $( "<base>", { href: $.mobile.path.documentBase.hrefNoSearch } )
					.prependTo( $( "head" ) );
			}

			return baseElement;
		},

		// set the generated BASE element's href to a new page's base path
		set: function( href ) {

			// we should do nothing if the user wants to manage their url base
			// manually
			// DEPRECATED as of 1.5.0 and will be removed in 1.6.0. As of 1.6.0 only
			// base.dynamicBaseEnabled will be checked
			if ( !getDynamicEnabled() ) {
				return;
			}

			// we should use the base tag if we can manipulate it dynamically
			base.element().attr( "href",
				$.mobile.path.makeUrlAbsolute( href, $.mobile.path.documentBase ) );
		},

		// set the generated BASE element's href to a new page's base path
		reset: function(/* href */) {

			// DEPRECATED as of 1.5.0 and will be removed in 1.6.0. As of 1.6.0 only
			// base.dynamicBaseEnabled will be checked
			if ( !getDynamicEnabled() ) {
				return;
			}

			base.element().attr( "href", $.mobile.path.documentBase.hrefNoSearch );
		}
	};

	$.mobile.base = base;

})( jQuery );

//>>excludeStart("jqmBuildExclude", pragmas.jqmBuildExclude);
});
//>>excludeEnd("jqmBuildExclude");
