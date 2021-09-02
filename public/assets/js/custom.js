// pour fermer et ouvrir le menu burger
$(document).on('click','#menuNavBar',function (){
    $('.front_nav').toggleClass('responsive');
});

$(document).on('click','#toggle-menu',function (){

    // changement de l'etat de menu dans localstorage
    if (localStorage.getItem('menu') === 'closed')
        localStorage.setItem('menu','opened');
    else
        localStorage.setItem('menu','closed');

    // ici on va fermer ou ouvrir le menu
    $('.side-menu').toggleClass('closed');
    $('.admin_container').toggleClass('closed');

});

$(document).ready(function (){

    // etat menu par defaut opened
    var etatmenu = "opened";

    // si il y a un valeur dans le localstorage on va le met dans etatmenu
    if(localStorage.getItem('menu'))
        etatmenu = localStorage.getItem('menu');

    // si etatmenu = closed on va ajouter la class closed sinon on va le supprimer
    if(etatmenu === 'closed'){
        $('.side-menu').addClass('closed');
        $('.admin_container').addClass('closed');
    }else{
        $('.side-menu').removeClass('closed');
        $('.admin_container').removeClass('closed');
    }

});

$(document).on('click','.options img',function (){
    $('.dropdown').toggleClass('active');
});