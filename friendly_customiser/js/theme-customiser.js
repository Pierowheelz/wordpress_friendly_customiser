var wb_customise_preview = new function(){
	var self = this;
	var $ = jQuery;
	
	self.init = function(){
		self.process_rules( previews );
	};
	
	self.process_rules = function( rules ){
		$.each( rules, function( id, vars ){
			var these_vars = vars;
			wp.customize( id, function( value ) {
				value.bind( function( newval ) {
					if( typeof these_vars['type'] != 'undefined' ){
						self.process_rule( these_vars, newval );
					} else {
						$.each( these_vars, function( i, rule ){
							if( typeof rule['type'] != 'undefined' ){
								self.process_rule( rule, newval );
							} else {
								if( typeof console.warn == 'function' ){
									console.warn( 'Cannot parse theme rule:' );
									console.log( rule );
								}
							}
						} );
					}
				});
			});
		});
	};
	
	self.process_rule = function( rule, newval ){
		switch( rule['type'] ){
			case 'css':
				var $elm = $( rule['hook'] );
				if( $elm[0] ){
					var prepend = (typeof rule['prepend'] != 'undefined')?rule['prepend']:'';
					var append = (typeof rule['units'] != 'undefined')?rule['units']:'';
					$elm.css( rule['variable'], (prepend + newval + append) );
				}
				break;
			case 'class':
				var $elm = $( rule['hook'] );
				if( $elm[0] ){
					var class_string = '';
					if( typeof rule['variations'] != 'undefined' ){
						$.each( rule['variations'], function( i, this_class ){
							class_string += ' '+this_class;
						});
					}
					$elm.removeClass( class_string ).addClass( newval );
				}
				break;
			case 'text':
				var $elm = $( rule['hook'] );
				if( $elm[0] ){
					var prepend = (typeof rule['prepend'] != 'undefined')?rule['prepend']:'';
					var append = (typeof rule['units'] != 'undefined')?rule['units']:'';
					$elm.html( prepend + newval + append );
				}
				break;
		}
	};
	
	$(document).ready(function(){
		try{
			self.init();
		} catch( e ){
			console.warn( 'JS Error in theme_customiser.js' );
			console.log( e );
		}
	});
};
