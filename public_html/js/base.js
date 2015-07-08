$(document).ready(function() {
    
    $(window).bind('resize', function(e) {
        if (window.RT) clearTimeout(window.RT);
        window.RT = setTimeout(function() {
            this.location.reload(false); /* false to get page from cache */
        }, 100);
    });
    
    $('#portfolio-tooltips, #session-tooltip').css({
        'display': 'none'
    });
    
    $('.carousel').carousel({
        interval: 4000
    });
    
    $('#portfolio-images img.gray').addClass('grayscale');
    
    $('#portfolio-images img.gray').mouseover(function(){
        
        $(this).removeClass('grayscale');
        $(this).addClass('graydisabled');
        
        var id = $(this).offset();
        var dimW = $(this).width();
        var dimH = $(this).height();
        
        $('#portfolio-tooltip').css({
            'display': 'inline',
            'position': 'absolute',
            'top' : parseInt(id.top + dimH - 50) + 'px',
            'left' : parseInt(id.left + 1) + 'px',
            'width' : dimW
        });
        
        var tHtml = '<a href="' + $(this).attr('data-url') + '"><h4>' + $(this).attr('alt') + '</h4></a>';
        $('#portfolio-tooltip').html(tHtml);
        
    });
    
    $('#portfolio-images img.gray').mouseout(function(){
        $(this).removeClass('graydisabled');
        $(this).addClass('grayscale');
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