$(document).ready(function(){
    $('.navbar-link').click(function(){
        $page = $(this).attr('data-page');
        crowpack.showpage($page);
        $parent = $(this).attr('data-parent');
        $('.navbar-nav').children().removeClass('active');
        if($parent) { $($parent).addClass('active'); }
    });
});
