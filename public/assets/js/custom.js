$(document).on('click','#menuNavBar',function (){
    $('.front_nav').toggleClass('responsive');
});

$(document).ready(function (){

    var etatmenu = localStorage.getItem('menu') ? localStorage.getItem('menu') : 'opened';
    if (!localStorage.getItem('menu'))
        localStorage.setItem('menu','opened');

    if(etatmenu === 'closed'){
        $('.side-menu').addClass('closed');
        $('.admin_container').addClass('closed');
    }else{
        $('.side-menu').removeClass('closed');
        $('.admin_container').removeClass('closed');
    }

});
$(document).on('click','#toggle-menu',function (){
    if (localStorage.getItem('menu') === 'closed')
        localStorage.setItem('menu','opened');
    else
        localStorage.setItem('menu','closed');

    $('.side-menu').toggleClass('closed');
    $('.admin_container').toggleClass('closed');
});
$(document).ready(function (){
    if ($( window ).width() <= 800 || localStorage.getItem('menu') === 'closed' ) {
        $('.side-menu').addClass('closed');
        $('.admin_container').addClass('closed');
    }else{
        $('.side-menu').removeClass('closed');
        $('.admin_container').removeClass('closed');
    }
})
$(window).resize(function (){
    if ($( window ).width() <= 800 || localStorage.getItem('menu') === 'closed') {
        $('.side-menu').addClass('closed');
        $('.admin_container').addClass('closed');
    }else{
        $('.side-menu').removeClass('closed');
        $('.admin_container').removeClass('closed');
    }
})
$(document).on('click','.options img',function (){
    $('.dropdown').toggleClass('active');
});