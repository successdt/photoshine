/****************************************
* copyright@duythanh
* success.ddt@gmail.com
* lifetime technologies Co..Ltd
*
*
*****************************************/
(function($){
	$.fn.slidebox = function(options){
		var defaults = {
		    iframe		: false,
		    href		: '',
		    width 		: 960,
		    height 		: 0,
		    offset 		: 200,
		    loadingDiv 	: '',
		    html		: ''
		};
		var opts=$.extend(defaults,options);
		var initDiv = '<div id="slidebox-background"></div>' +
						'<div id="slidebox-wrapper">' +
							'<div id="slidebox">' +
							'</div>' +
						'</div>';
		$('body').prepend(initDiv);
		if (opts.iframe){
			$('#slidebox-background').fadeIn(200);
			$('#slidebox-wrapper').show();
			$('#slidebox-wrapper').css('top', - opts.height - 10);
			$('#slidebox').html('<iframe src="' + opts.href + '" width="' + opts.width + '" height="' + opts.height + '"></iframe>');
			setTimeout(function(){
				$('#slidebox-wrapper').css('top', '0px');	
			}, 400);
		}
		else {
			$('#slidebox-background').fadeIn(200);
			$('#slidebox').html(opts.html);
			$('#slidebox-wrapper').show();
			$('#slidebox-wrapper').css('top', - $('#slidebox-wrapper').outerHeight());
			$('#slidebox').width($('#slidebox').children().outerWidth());
			setTimeout(function(){
				$('#slidebox-wrapper').css('top', '0px');	
			}, 400);
		}
		
		$('#slidebox-background').click(function(){
			$().slidebox.close();
		});
		
		$('#slidebox-wrapper').click(function(){
			$().slidebox.close();
		});
		
		$('#slidebox').click(function(e){
			e.stopPropagation();
		});
				
		$(document).keyup(function(e) {
			if (e.keyCode == 27) {
				$().slidebox.close();
			}
		});
	}
	$.fn.slidebox.close = function (){
		$('#slidebox-wrapper').css('top', - $('#slidebox').outerHeight());
		setTimeout(function(){
			$('#slidebox-wrapper').remove();
		}, 400);
		
		$('#slidebox-background').fadeOut(200, function(){
			$(this).remove();
		})	
	}
})(jQuery);