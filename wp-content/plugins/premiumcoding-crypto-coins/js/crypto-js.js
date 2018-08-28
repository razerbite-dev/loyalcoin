
jQuery(window).load(function(){
    var speed = 3;
    var items, scroller = jQuery('.crypto-slider');
    var width = 0;
    scroller.children().each(function(){
        width += jQuery(this).outerWidth(true);
    });
    scroller.css('width', width);
    scroll();
    function scroll(){
        items = scroller.children();
        var scrollWidth = items.eq(0).outerWidth();
        scroller.animate({'left' : 0 - scrollWidth}, scrollWidth * 100 / speed, 'linear', changeFirst);
    }
    function changeFirst(){
        scroller.append(items.eq(0).remove()).css('left', 0);
        scroll();
    }
	jQuery('.tradingview-widget-copyright').fadeIn();
	
});


