(function($){
	$.fn.textreplace = function(options){
		var root = 'localhost/photoshine/';
		var defaults = {
			root: root,
			tagUrl: 'photo/channel/$1',
			userUrl: 'u/$1'
		};
		var opts=$.extend(defaults,options);
	    var exp1 = /@([a-zA-Z1-9\-\_\.]{1,})/gi;
	    var exp2 = /\B#([a-zA-Z1-9]{1,})/gi;
	    var exp3 = /[^\"](\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
	    var exp4 = /[^\/\"](www.[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
		
		this.each(function(){
			$(this).html(' ' + $(this).html() + ' ');
			$(this).html($(this).html().replace(exp1, '<a class="bluetext" href="' + opts.root + opts.userUrl + '" target="_blank"> @$1</a>'));
			$(this).html($(this).html().replace(exp2, '<a class="bluetext" href="' + opts.root + opts.tagUrl + '" target="_blank"> #$1</a>'));
			$(this).html($(this).html().replace(exp3, '<a class="bluetext" href="$1" target="_blank"> $1</a>'));
			$(this).html($(this).html().replace(exp4, '<a class="bluetext" href="http://$1" target="_blank"> $1</a>'));
		});
	};
})(jQuery);
function text2link(text, root){
    var exp1 = /@([a-zA-Z1-9\-\_\.]{1,})/gi;
    var exp2 = /\B#([a-zA-Z1-9]{1,})/gi;
    var exp3 = /[^\"](\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    var exp4 = /[^\/\"](www.[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    text = ' ' + text + ' ';
    text = htmlEntities(text);
    text = text.replace(exp1, '<a class="bluetext" href="' + root + 'u/$1" target="_blank"> @$1</a> ');
    text = text.replace(exp2, '<a class="bluetext" href="' + root + 'photo/channel/$1" target="_blank"> #$1</a> ');
    text = text.replace(exp3, '<a class="bluetext" href="$1" target="_blank"> $1</a> ');
    text = text.replace(exp4, '<a class="bluetext" href="http://$1" target="_blank"> $1</a> ');
	
	return text;	
}
function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}