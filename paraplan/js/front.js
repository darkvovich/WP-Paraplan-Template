var hash = window.location.hash.replace('#pa-','');
var isAllowedToScroll = true;

function resetScroll(callback) {
    $("html, body").css("height", "auto").css("width", "auto").css("overflow", "auto");
    $(window).scrollTop(0);
    $(document).scrollTop(0);
    $(scrl_top).scrollTop(0);
    window.scrollTo(0,0);
    $("html, body").css("height", "").css("width", "").css("overflow", "");
    if (callback) {
        callback();
    }
}

function addParalax(on, bkg) {
    var old_x = 0;
    var old_y = 0;
    var slower = 3;
    $(on).mousemove(function(e) {
        var x = e.pageX;
        var y = e.pageY;
        if(old_x!=0 && old_y!=0) {
            var dx = x - old_x;
            var dy = y - old_y;
            var bkgpos = $(bkg).css('background-position').split(" ");
            var bkgx = parseFloat(bkgpos[0].replace("%", ''));
            var dxp = dx * 100 / $(on).width();
            var new_bkgx = bkgx + (dxp/slower);
            if(new_bkgx<1) {new_bkgx=0;}
            if(new_bkgx>100) {new_bkgx=100;}
            var bkgy = parseFloat(bkgpos[1].replace("%", ''));
            var dyp = dy * 100 / $(on).height();
            var new_bkgy = bkgy + (dyp/slower);
            if(new_bkgy<1) {new_bkgy=0;}
            if(new_bkgy>100) {new_bkgy=100;}
            //var new_bkgy = 20;
            $(bkg).css('background-position',new_bkgx+"% "+new_bkgy+"%");
        }
        old_x = x;
        old_y = y;
    });
}

function vAlign(i) {
    var h = $('#other .otherHolder').innerHeight();
    $('#other .otherHolder').css('line-height',h+'px');
    $('#other .otherHolder .verticalAligner').css('margin-top',0);

    $('#people img').css('margin-top',"");
    $('#people .text').css('margin-top',"").css('padding-top',0);
    $.each($('#people .slick-slide'), function() {
        var t = $(this);
        //if(!$(t).hasClass('slick-cloned')) {
            var h = $(t).height();
            $.each($(t).find('img, .text'),function() {
                var h2 = $(this).outerHeight(false);
                var m = Math.floor((h - h2) / 2);
                $(this).css('margin-top',m);
            });
        //}
    });
    
    var wh = $(window).innerHeight();
    $("#contacts").css("line-height", wh+"px");

    if(i==undefined) {
        var int = setInterval(function() {
            vAlign(false);
            clearInterval(int);
            resetServices();
        },500);
    }
}

function resetServices() {
    $('#servicesAll').css('top',0).show().css('opacity',1);
    $('#serviceClicked').hide().removeClass('relative').css('opacity',0).css('top',0);
}

function moveTo(param) {
    var to;
    if (param == undefined) {
        return false;
    } else if (param=='next' || param=='down') {
        to = $('.main section.current').next('section');
        if($(to).length!=1) {
            to = $('.main section:last');
        }
    } else if (param=='prev' || param=='up') {
        to = $('.main section.current').prev('section');
        if($(to).length!=1) {
            to = $('.main section:first');
        }
    } else if (param=='current') {
        to = $('.main section.'+param);
        if(to.length!=1) {
            to = $('.main section:first');
        }
    } else if (!isNaN(parseInt(param))) {
        var s = $('.main section');
        to = s[param];
        if ($(to).length!=1) {
            to = $('.main section:first');
        }
    } else if($('.main').find(param+':first').length==1) {
        to = $('.main '+param);
    }

    if ($(to).length!=1) {
        return;
    } else {
        var i = $(to).index();
        $('a[data-moveTo]').removeClass('current');
        $('a[data-moveTo="'+i+'"]').addClass('current');
    }
    
    $('.main section.current').removeClass('current');
    $(to).addClass('current');
    var i = $('.main section.current').index();
    var t = i * windowHeight * -1;
    if (t>0) {
        t = 0;
        to = $('.main section:first');
    }
    resetScroll(function() {
        $('.main section:first').stop().animate({'margin-top': t}, 500, 'swing', function(){
            var wainting4bitches = setInterval(function(){
                isAllowedToScroll = true;
                clearInterval(wainting4bitches);
            },wait);
        });
    });
}

$(window).resize(function() {
    windowHeight = $(window).innerHeight();
    moveTo('current');
    vAlign();
    resetServices();
});

$(document).ready(function() {
    $('.main section:first').addClass('current');

    $(document).on('click','a.smoothScroll',function() {
        var h = $(this).attr('href');
        moveTo(h);
        return false;
    });

    $('#logo .slogan').wordsChanger();

    var scrollBullets = "";
    for(var i=0;i<$('.main section').length;i++) {
        scrollBullets += "<a href='#' data-moveTo='"+i+"'></a>";
    }
    var addScrollBullets = "<div id='scrollBullets'>"+scrollBullets+"</div>";
    $('body').prepend(addScrollBullets);
    $('a[data-moveTo]:first').addClass('current');
    
    $('#arrowDown').click(function(){
        moveTo('down');
    });

    if ($('.single-item').length > 0) {
        $('.single-item').slick({
            autoplay: true,
            autoplaySpeed: 15000,
        });
    }
    
    $('a[data-moveTo]').click(function(e){
        e.preventDefault();
        var t = $(this).attr('data-moveTo');
        moveTo(t);
    });
	
	$.fn.swipeEvents = function() {
        return this.each(function() {

            var startX,
                startY,
                $this = $(this);

            $this.bind('touchstart', touchstart);

            function touchstart(event) {
              var touches = event.originalEvent.touches;
              if (touches && touches.length) {
                startX = touches[0].pageX;
                startY = touches[0].pageY;
                $this.bind('touchmove', touchmove);
              }
            }

            function touchmove(event) {
              var touches = event.originalEvent.touches;
              if (touches && touches.length) {
                var deltaX = startX - touches[0].pageX;
                var deltaY = startY - touches[0].pageY;

                if (deltaX >= 50) {
                  $this.trigger("swipeLeft");
                }
                if (deltaX <= -50) {
                  $this.trigger("swipeRight");
                }
                if (deltaY >= 50) {
                  $this.trigger("swipeUp");
                }
                if (deltaY <= -50) {
                  $this.trigger("swipeDown");
                }
                if (Math.abs(deltaX) >= 50 || Math.abs(deltaY) >= 50) {
                  $this.unbind('touchmove', touchmove);
                }
              }
            }

        });
    };
    
    $(document).bind('mousewheel DOMMouseScroll', function(event) {
        if (isAllowedToScroll) {
            isAllowedToScroll = false;
            event.preventDefault();
            var delta = event.originalEvent.wheelDelta || -event.originalEvent.detail;
            if(delta<0) {
                moveTo('down');
            }else{
                moveTo('up');
            }
        }
    });
    
    $(document).keydown(function(e) {
        var tag = e.target.tagName.toLowerCase();

        if (!$("body").hasClass("disabled-onepage-scroll")) {
            switch(e.which) {
                case 38:
                    if (tag != 'input' && tag != 'textarea') moveTo('up');
                    break;
                case 40:
                    if (tag != 'input' && tag != 'textarea') moveTo('down');
                    break;
                default: return;
            }
        }
    });
    
    $('.main').swipeEvents().bind("swipeDown",  function(event){ 
        if (!$("body").hasClass("disabled-onepage-scroll")) event.preventDefault();
        moveTo('up');
    }).bind("swipeUp", function(event){ 
        if (!$("body").hasClass("disabled-onepage-scroll")) event.preventDefault();
        moveTo('down');
    });
    
    // Header
    addParalax($('#header'), $('#bkgParallaxImage1'));

    // Services
    addParalax($('#services'), $('#bkgParallaxImage3'));
    $('#servicesAll img').hover(function() {
        var p = $(this).parents('#servicesAll').first();
        $(p).find('img').not($(this)).stop().animate({'opacity':0.5},200);
    },function(){
        var p = $(this).parents('#servicesAll').first();
        $(p).find('img').stop().animate({'opacity':1},200);
    });
    $('#servicesAll img').click(function() {
        var p = $(this).parents('#servicesAll').first();
        var text = $(this).next('.text').html();
        var img = $(this).attr('src');
        $('#serviceClicked img').attr('src',img);
        $('#serviceClicked .text').html(text);
        $('#servicesAll').animate({'top':"+=100",'opacity':0},200,'swing',function() {
            $('#servicesAll').hide();
            $('#serviceClicked').addClass('relative');
            $('#serviceClicked').css('opacity',0).css('top',0).show();
            var m = 0;
            $.each($('#serviceClicked').find('img, .text'),function() {
                var h = $(this).outerHeight(false);
                if(h>m) { m = h; }
            });
            $('#serviceClicked').find('.textHolder:first').css('line-height',m+'px');
            $('#serviceClicked').animate({'opacity':1},200);
        });
    });
    $('#services').click(function(){
        if($('#serviceClicked').is(':visible')) {
            $('#serviceClicked').animate({'top':"+=100",'opacity':0},200,'swing',function() {
                $('#serviceClicked').hide().removeClass('relative');
                $('#servicesAll').css('opacity',0).css('top',0).show().animate({'opacity':1},200);
            });
        }
    });
});

$(window).on('load', function() {
    vAlign();
    resetScroll(function() {
        if(hash!="" && hash!=undefined && hash.length>0) {
            if($('section#'+hash).length==1) {
                moveTo("section#"+hash);
            }
        }
    });
});