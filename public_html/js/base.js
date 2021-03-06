$(document).ready(function() {
    
    
    $('#portfolio-tooltips, #session-tooltip').css({
        'display': 'none'
    });
    
    $('.carousel').carousel({
        interval: 2000
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
            'left' : parseInt(id.left+3) + 'px',
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
            'top' : parseInt(id.top + dimH - 70) + 'px',
            'left' : parseInt(id.left+3) + 'px',
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
            'left' : parseInt(id.left+3) + 'px',
            'width' : dimW,
            'height' : dimH
        });
        
        var tHtml = '<a href="' + $(this).attr('data-url') + '"><h4>' + $(this).attr('alt') + '</h4></a>';
        $('#session-tooltip').html(tHtml);
        
    });
    
    
});