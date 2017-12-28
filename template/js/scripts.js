// специальная конструкция которая позволяет дожидаться построения ДОМ дерева и потому вызов скриптов можно писать в разделе HEAD а не в самом конце 
$(document).ready(function(){

$('#editteam').click(function(ev){
    location.href=  "/team/edit/";
});

$('#createteam').click(function(ev){
    location.href=  "/team/create/";
});

$('#enterteam').click(function(ev){
    location.href=  "/team/login/";
});

$('#listteam').click(function(ev){  
    location.href='/team/';
});

$('#exitteam').click(function(ev){  
    location.href='/team/exit';
});

$('#contact').click(function(ev){  
    location.href='/contact';
});

$('#teamlist tr td').click(function(ev){ 
    var id = $(this).attr('teamid'); 
    location.href='/team/'+id;
});

$('#league').click(function(ev){
    location.href=  "/league";
});

$('#offSeason').click(function(ev){
    location.href=  "/league/offSeasonView";
});

$('#shedule').click(function(ev){
    location.href=  "/shedule";
});

$('#archive').click(function(ev){
    location.href=  "/shedule/archive";
});

$('#filldata').click(function(ev){ 
    // заполнение полей, для облегчения отладки
    $('#login').val('some_login'); 
    $('#pass').val('some_password'); 
    $('#teamname').val('Супер командааааААаа:)'); 
    var email = 'web.worm@mail.ru';
    $('#email').val(email); 
});


});// конец ready .
