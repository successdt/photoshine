/*
 * Customize colorbox iframe resize
 */
function resizeColorbox(width, height) {
	if (width == 'undefined' || height == 'undefined' || typeof (colorbox) == 'undefined') {
		return false;
	}

	$.colorbox.resize({
		innerWidth: width,
		innerHeight: height
	});
}

function loadCss(cssId, href) {
	if (!document.getElementById(cssId)) {
		var head = document.getElementsByTagName('head')[0];
		var link = document.createElement('link');
		link.id = cssId;
		link.rel = 'stylesheet';
		link.type = 'text/css';
		link.href = href;
		link.media = 'all';
		head.appendChild(link);
	}
}

//function auto resize blocks container
function autoSizeGridview(rightSpace){
	var blockWidth = $('.gridview-block:first-child').outerWidth(true);
	var rightSpace = rightSpace || 30;
	
	var nbOfBlock = Math.floor(($('#content').width() - rightSpace)/blockWidth);
	$('.gridview-wrapper, #gridview-wrapper').width(nbOfBlock * blockWidth);
	$(window).resize(function(){
		nbOfBlock = Math.floor(($('#content').width() - rightSpace)/blockWidth);
		$('.gridview-wrapper, #gridview-wrapper').width(nbOfBlock * blockWidth);
	});
}

$(document).ready(function(){

/**
 * convert number to format like k, M, G, T
 * author: thanhdd@lifetimetech.vn
 */

});
function toNumberSize(number){
    if(number < 1000){
         return number;              
    }
    if(number < 1000000){
        var result = number / 10;
        result = parseInt(result);
        return (result / 100) + 'k';
    }
    if(number < 1000000000){
        var result = number / 10000;
        result = parseInt(result);
        return (result / 100) + 'M';                
    }
    if(number < 1000000000000){
        var result = number / 10000000;
        result = parseInt(result);
        return (result / 100) + 'G';                
    }
    if(number < 1000000000000000){
        var result = number / 10000000000;
        result = parseInt(result);
        return (result / 100) + 'T';                
    }
}
