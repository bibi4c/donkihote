/**
 * common.js
 *
 *  version --- 3.6
 *  updated --- 2011/09/06
 */


/* !stack ------------------------------------------------------------------- */
jQuery(document).ready(function($) {
	pageScroll();
	rollover();
	popWindow();
	addCss();
});

/* !isUA -------------------------------------------------------------------- */
var isUA = (function(){
	var ua = navigator.userAgent.toLowerCase();
	indexOfKey = function(key){ return (ua.indexOf(key) != -1)? true: false;}
	var o = {};
	o.ie      = function(){ return indexOfKey("msie"); }
	o.fx      = function(){ return indexOfKey("firefox"); }
	o.chrome  = function(){ return indexOfKey("chrome"); }
	o.opera   = function(){ return indexOfKey("opera"); }
	o.android = function(){ return indexOfKey("android"); }
	o.ipad    = function(){ return indexOfKey("ipad"); }
	o.ipod    = function(){ return indexOfKey("ipod"); }
	o.iphone  = function(){ return indexOfKey("iphone"); }
	return o;
})();

/* !rollover ---------------------------------------------------------------- */
var rollover = function(){
	var suffix = { normal : '_no.', over   : '_on.'}
	$('a.over, img.over, input.over').each(function(){
		var a = null;
		var img = null;

		var elem = $(this).get(0);
		if( elem.nodeName.toLowerCase() == 'a' ){
			a = $(this);
			img = $('img',this);
		}else if( elem.nodeName.toLowerCase() == 'img' || elem.nodeName.toLowerCase() == 'input' ){
			img = $(this);
		}

		var src_no = img.attr('src');
		var src_on = src_no.replace(suffix.normal, suffix.over);

		if( elem.nodeName.toLowerCase() == 'a' ){
			a.bind("mouseover focus",function(){ img.attr('src',src_on); })
			 .bind("mouseout blur",  function(){ img.attr('src',src_no); });
		}else if( elem.nodeName.toLowerCase() == 'img' ){
			img.bind("mouseover",function(){ img.attr('src',src_on); })
			   .bind("mouseout", function(){ img.attr('src',src_no); });
		}else if( elem.nodeName.toLowerCase() == 'input' ){
			img.bind("mouseover focus",function(){ img.attr('src',src_on); })
			   .bind("mouseout blur",  function(){ img.attr('src',src_no); });
		}

		var cacheimg = document.createElement('img');
		cacheimg.src = src_on;
	});
};
/* !pageScroll -------------------------------------------------------------- */
var pageScroll = function(){
	jQuery.easing.easeInOutCubic = function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	}; 
	$('a.scroll, .scroll a, .pageTop a').each(function(){
		$(this).bind("click keypress",function(e){
			e.preventDefault();
			var target  = $(this).attr('href');
			var targetY = $(target).offset().top;
			var parent  = ( isUA.opera() )? (document.compatMode == 'BackCompat') ? 'body': 'html' : 'html,body';
			$(parent).animate(
				{scrollTop: targetY },
				400,
				'easeInOutCubic',
				function(){
					location.hash = target;
				}
			);
			return false;
		});
	});
}

/* !popWindow --------------------------------------------------------------- */
var popWindow = function (){
	var param = null;
	// param[0] = width
	// param[1] = height
	// param[2] = window.name
	$('a[class^="js_popup"], area[class^="js_popup"]').each(function(i){
		$(this).click(function(){
			var w = null;
			param = $(this).attr('class').match(/[0-9]+/g);
			// get window.name
			param[2] = window.name ? window.name+'_' : '';
			w = window.open(this.href, param[2]+'popup'+i,'width='+param[0]+',height='+param[1]+',scrollbars=yes');
			w.focus();
			return false;
		});
	});
}
/* !defFunc ----------------------------------------------------------------- */
var defFunc = (function(){
	Print = function(){ window.print(); return false;}
	Close = function(){ window.close(); return false;}
})();
/* !Addition Fitst & Last --------------------------------------------------- */
var addCss = (function(){
	$('.section:first-child:not(:last-child)').addClass('first');
	$('.section:last-child').addClass('last');
	$('li:first-child:not(:last-child)').addClass('first');
	$('li:last-child').addClass('last');
});


$(function(){
	if($("#news_area ul").length){
		$(document).ready(function(){
			$("#news_area ul").liScroll({travelocity: 0.05});
		});
	}
	var winW = $(window).width();
	var topBtn = $('.pageTop');	
	if($("#bnr_menulist").length){
		$("#bnr_menulist li:nth-child(4n)").addClass("li04");
		$("#bnr_menulist li:nth-child(3n)").addClass("li03");
		if (winW >= 568) {
			$("#bnr_menulist li a").hover(
			function () {
				$(this).children("div").fadeIn('fast')
			},
			function () {
				$(this).children("div").fadeOut('fast')
			}
			);
    }
	}
	if (winW <= 568) {
		topBtn.hide();
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				topBtn.fadeIn();
			} else {
				topBtn.fadeOut();
			}
		});
		topBtn.click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 500);
			return false;
		});
	}	
});

$(function(){
$("#lNavi2 li").mouseover(function(){
	$(this).addClass("over");
});
$("#lNavi2 li").mouseout(function(){
	$(this).removeClass("over");
});
$("#sNavi li.more a").click(function(){
	$("#sNavi li.more a").toggleClass("on");
	$("#hd_submenu").slideToggle();
	return false;
});

$(".spNav > li > a").click(function(){
	if($(this).parent().hasClass("tLink")){
	} else {
		$(this).next().slideToggle();
		$(this).parent().toggleClass("on");
		return false;
	}
});

$('#slider1').bxSlider({
	auto: true,
	mode: 'fade',
  	pagerCustom: '#bx-pager'
});

$('#slider2').bxSlider({
  	mode: 'fade',
  	captions: true,
	pager: false
});

$('#slideFlash').supergallery();
});


/*
		CSS Browser Selector v0.4.0 (Nov 02, 2010)
		Rafael Lima (http://rafael.adm.br)
		http://rafael.adm.br/css_browser_selector
		License: http://creativecommons.org/licenses/by/2.5/
		Contributors: http://rafael.adm.br/css_browser_selector#contributors
		*/
		function css_browser_selector(u){var ua=u.toLowerCase(),is=function(t){return ua.indexOf(t)>-1},g='gecko',w='webkit',s='safari',o='opera',m='mobile',h=document.documentElement,b=[(!(/opera|webtv/i.test(ua))&&/msie\s(\d)/.test(ua))?('ie ie'+RegExp.$1):is('firefox/2')?g+' ff2':is('firefox/3.5')?g+' ff3 ff3_5':is('firefox/3.6')?g+' ff3 ff3_6':is('firefox/3')?g+' ff3':is('gecko/')?g:is('opera')?o+(/version\/(\d+)/.test(ua)?' '+o+RegExp.$1:(/opera(\s|\/)(\d+)/.test(ua)?' '+o+RegExp.$2:'')):is('konqueror')?'konqueror':is('blackberry')?m+' blackberry':is('android')?m+' android':is('chrome')?w+' chrome':is('iron')?w+' iron':is('applewebkit/')?w+' '+s+(/version\/(\d+)/.test(ua)?' '+s+RegExp.$1:''):is('mozilla/')?g:'',is('j2me')?m+' j2me':is('iphone')?m+' iphone':is('ipod')?m+' ipod':is('ipad')?m+' ipad':is('mac')?'mac':is('darwin')?'mac':is('webtv')?'webtv':is('win')?'win'+(is('windows nt 6.0')?' vista':''):is('freebsd')?'freebsd':(is('x11')||is('linux'))?'linux':'','js']; c = b.join(' '); h.className += ' '+c; return c;}; css_browser_selector(navigator.userAgent);