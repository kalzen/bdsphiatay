$('.wrap-property img').each(function()
{
    $(this).addClass('fancybox');
});
$(document).ready(function() {
        $('.fancybox').fancybox({
            padding : 0, // default 15
            margin: 0,   // default 20
            width: '800',  // default 800
            height: '600', // default 600
            opacity: true, // default false
        });
    });