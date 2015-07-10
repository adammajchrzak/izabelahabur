$(document).ready(function() {
    
    $(window).bind('resize', function(e) {
        if (window.RT) clearTimeout(window.RT);
        window.RT = setTimeout(function() {
            this.location.reload(false); /* false to get page from cache */
        }, 100);
    });
    
    $('#session-tooltip, .portfolio-tooltip').css({
        'display': 'none'
    });
    
    $('.carousel').carousel({
        interval: 4000
    });
    
    $('#portfolio-images img.gray').addClass('grayscale');
    
    $('#portfolio-images .tooltips').mouseover(function(){
        
        $(this).find('img').removeClass('grayscale');
        $(this).find('img').addClass('graydisabled');
        var dimW = $(this).find('img').width();
        
        $('> .portfolio-tooltip', this).css({
            'display': 'inline-block',
            'position': 'absolute',
            'bottom' : '10px',
            'left' : '0px',
            'width' : dimW,
            'height' : 'auto'
        });
    });
    
    $('#portfolio-images .tooltips').mouseout(function(){
        $(this).find('img').removeClass('graydisabled');
        $(this).find('img').addClass('grayscale');
        $('> .portfolio-tooltip', this).css({ 'display' : 'none' });
    });
    
    $('#portfolio-images img.box').each(function(){
        
        var id = $(this).offset();
        var dimW = $(this).width();
        var dimH = $(this).height();
        
        $('#' + $(this).attr('id') + '-tooltip').css({
            'position': 'absolute',
            'top' : parseInt(id.top - 10) + 'px',
            'left' : parseInt(id.left + 16) + 'px',
            'width' : dimW,
            'padding' : '10px'
        });
        
        var tHtml = '<a href="' + $(this).attr('data-url') + '"><h4>' + $(this).attr('alt') + '</h4></a>';
        $('#' + $(this).attr('id') + '-tooltip').html(tHtml);
    });
    
    $('#session-images img.gray').mouseover(function(){
        
        var id = $(this).offset();
        var dimW = $(this).width();
        var dimH = $(this).height();
        
        $('#session-tooltip').css({
            'display': 'block',
            'position': 'absolute',
            'top' : parseInt(id.top) + 'px',
            'left' : parseInt(id.left+1) + 'px',
            'width' : dimW,
            'height' : dimH
        });
        
        var tHtml = '<a href="' + $(this).attr('data-url') + '" target="_blank"><h4>' + $(this).attr('alt') + '</h4></a>';
        $('#session-tooltip').html(tHtml);
    });
    
    
});