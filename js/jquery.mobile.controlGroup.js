/*
* jQuery Mobile Framework: "controlgroup" plugin - corner-rounding for groups of buttons, checks, radios, etc
* Copyright (c) jQuery Project
* Dual licensed under the MIT or GPL Version 2 licenses.
* http://jquery.org/license
*/
(function($, undefined ) {
    var methods = {
        init: function() {
            return this.each(function(){
                var o = $.extend({
                    direction: $( this ).data( "type" ) || "vertical",
                    shadow: false
                },options);
                var groupheading = $(this).find('>legend'),
                    flCorners = o.direction == 'horizontal' ? ['ui-corner-left', 'ui-corner-right'] : ['ui-corner-top', 'ui-corner-bottom'],
                    type = $(this).find('input:eq(0)').attr('type');
                
                //replace legend with more stylable replacement div	
                if( groupheading.length ){
                    $(this).wrapInner('<div class="ui-controlgroup-controls"></div>');	
                    $('<div role="heading" class="ui-controlgroup-label">'+ groupheading.html() +'</div>').insertBefore( $(this).children(0) );	
                    groupheading.remove();	
                }

                $(this).addClass('ui-corner-all ui-controlgroup ui-controlgroup-'+o.direction);
                
                function flipClasses(els){
                    els
                        .removeClass('ui-btn-corner-all ui-shadow')
                        .eq(0).addClass(flCorners[0])
                        .end()
                        .filter(':last').addClass(flCorners[1]).addClass('ui-controlgroup-last');
                }
                flipClasses($(this).find('.ui-btn'));
                flipClasses($(this).find('.ui-btn-inner'));
                if(o.shadow){
                    $(this).addClass('ui-shadow');
                }
            });	
        },
        
        refresh: function() {
            this.each(function(){
                $(this).removeClass('ui-controlgroup-horizontal ui-controlgroup-vertical');
                $(this).find('.ui-btn,.ui-btn-inner').removeClass('ui-controlgroup-last ui-corner-left ui-corner-right ui-corner-top ui-corner-bottom');
            });
            
            return methods.init.call(this);
        }
    };
    
    $.fn.controlgroup = function(options){
        if ( methods[method] ) {
          return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
          return methods.init.apply( this, arguments );
        } else {
          $.error( 'Method ' +  method + ' does not exist on jQuery.controlgroup' );
        }    
    };
})(jQuery);
