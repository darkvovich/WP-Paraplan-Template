function smoothScroll(element) {
    var ot = $(element).offset().top;
    var h = $(element).outerHeight();
    var scrollTo = ot;
    if(windowHeight>h) {
        var d = (windowHeight - h) / 2;
        scrollTo = ot - d;
    }
    $(scrl_top).animate({scrollTop: scrollTo}, 500);
}

function openWork(t, callback) {
    if (!$(t).hasClass('opened')) {
        closeAll(t);
        $(t).addClass('opened');
        $(t).find('.description, .slider').slideDown(200, callback || function() {});
        $(t).find($('.slider:not(.slick-initialized)')).css("opacity", 0);
        $(t).find('.preview').slideUp(200, function() {
            $(t).find($('.slider:not(.slick-initialized)')).slick();
            $(t).find($('.slider')).css("opacity", 1);
            // скроллим работу вверх
            smoothScroll('#' + $(t).attr('id'));
        });
    } else {
        $(t).removeClass('opened');
        $(t).find('.description, .slider').slideUp(200);
        $(t).find($('.slider.slick-initialized')).unslick();
        $(t).find('.preview').slideDown(200);
    }
}
function openWorkDes(t, callback) {
    if (!$(t).hasClass('opened')) {
        closeAllDes(t);
        $(t).addClass('opened');
    } else {
        $(t).removeClass('opened');
    }
}

function closeAll(nt) {
    $('.workBlock').each(function() {
        if ($(this).hasClass('opened') && $(this).not(nt)) {
            $(this).removeClass('opened');
            $(this).find('.description, .slider').slideUp(200);
            $(this).find('.preview').slideDown(200);
        }
    });
}
function closeAllDes(nt) {
    $('.workBlock').each(function() {
        if ($(this).hasClass('opened') && $(this).not(nt)) {
            $(this).removeClass('opened');
        }
    });
}

$(document).ready(function() {

    $(document).on('click','a.smoothScroll',function() {
        var h = $(this).attr('href');
        smoothScroll(h);
        return false;
    });
    
    $(".changeJS").each(function() {
        var href = $(this).attr('href');
        var nhref = href.replace(/[\/,\#]/gi, "");
        $(this).attr('href', "/#pa-"+nhref);
    });

    $("body").on('click', "a[data-slickOn]", function(e) {
        e.preventDefault();
        var t = $(this).attr('data-slickOn');
        $(t).click();
    });

    $('.workBlock').click(function(e){
    	if (!$(this).hasClass('design')) {
	        var t = e.target;
	        if($(t).parents('.slider').length>0 || $(t).hasClass('.slider') || $(t).is('a')) {
	        	return;
	        }
	        openWork($(this));
	    }
    });
    $('.slider img').on("dragstart", function() {
         return false;
    });
    $('li[data-scrollTo]').click(function(){
        var to = $(this).attr('data-scrollTo');
        to = $(to);
        if($(to).length==1) {
            //var top = $(to).offset().top + 100;
            if(!$(to).hasClass('opened')) {
            	if (!$(to).hasClass('design')) {
                	openWork($(to));
                } else {
	                openWorkDes($(to));
	            }
            }
            smoothScroll($(this).attr('data-scrollTo'));
            //$("html, body").animate({scrollTop:top}, 1000);
        }
    });
    function refreshPosition() {
        var wh = $(window).innerHeight();
        $("#contacts").height(wh).css("line-height", wh+"px");
        var w = $("#content>.col-5").innerWidth();
        $("#content .sideMenu").width(w);
    }
    refreshPosition();
    $(window).resize(function() {
        refreshPosition();
    });
});