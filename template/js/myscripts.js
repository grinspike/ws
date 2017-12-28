// специальная конструкция которая позволяет дожидаться построения ДОМ дерева и потому вызов скриптов можно писать в разделе HEAD а не в самом конце 
$(document).ready(function(){
var id_parent = 0; // tag shows id of parent
var teamN = 0; // tag shows id of parent
var timerId=-1;
var participantCount = 0;
var allCount = 0;
var prt = 0;
var all = [];
var all0 = [];
var pnt = []; //ParticipaNT array for off-season cup which will be a member of cup// 
//Массив команды которые будут принимать участие в кубке межсезонья.
//Мы этот массив отправим на сервер, где он создаст турнирную таблицу
var grade = -1;
$('#roles').click(function(ev){ 
    location.href=  "/team/roles/";
});

$('#listteamdeleted').click(function(ev){  
    location.href='/team/indexDeleted';
});

$('#newteam').click(function(ev){  
    location.href='/team/indexNew';
});



/** Approves team and refreshes the page of this team
 * 
 * @param {integer} teamId Team identifier
 * @returns {redirect} location.href='/team/'+teamId;
 */
function approve_team(teamId) {
    var params = "teamId="+teamId;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/'+teamId;
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/approve",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#approve').click(function(ev){ 
    var id = $(".teamfont").attr('teamId'); 
    approve_team(id);
});




function discard_team(teamId) {
    var params = "teamId="+teamId;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/'+teamId;
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/discard",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#discard').click(function(ev){ 
    var id = $(".teamfont").attr('teamId'); 
    discard_team(id);
});




function delete_team(teamId) {
    var params = "teamId="+teamId;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/'+teamId;
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/delete",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#delete').click(function(ev){ 
    var id = $(".teamfont").attr('teamId'); 
    delete_team(id);
});



function restore_team(teamId) {
    var params = "teamId="+teamId;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/'+teamId;
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/restore",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#restore').click(function(ev){ 
    var id = $(".teamfont").attr('teamId'); 
    restore_team(id);
});


$('#editByAdmin').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    location.href=  "/team/editAdmin/"+id;
});

/*
 * 
 */

function set_role(role,teamId) {
    var params = "teamId="+teamId+"&role="+role;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/roles';
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/setRole",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#teamroleslist tr td').click(function(ev){
    var id = $(this).attr('teamId'); 
    var role = $(this).attr('role'); 
    set_role(role,id);    
});




/** Changes count of cups of League for team which have teamId identifier
 * 
 * @param {integer} teamId
 * @param {integer} inc 
 * @returns {redirect} Refreshes the page. Page will be with new count of cups of League
 */
function cupLeague(teamId,inc) {
    var params = "teamId="+teamId+"&inc="+inc;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/'+teamId;
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/teamCupLeagueChange",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#cupLeaguePlus').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    var inc = 1;
    cupLeague(id,inc);    
});

$('#cupLeagueMinus').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    var inc = -1;
    cupLeague(id,inc);    
});




/** Changes count of cups of OffSeason for team which have teamId identifier
 * 
 * @param {integer} teamId
 * @param {integer} inc 
 * @returns {redirect} Refreshes the page. Page will be with new count of cups of OffSeason
 */
function cupOffSeason(teamId,inc) {
    var params = "teamId="+teamId+"&inc="+inc;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/'+teamId;
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/teamCupOffSeasonChange",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#cupOffSeasonPlus').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    var inc = 1;
    cupOffSeason(id,inc);    
});

$('#cupOffSeasonMinus').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    var inc = -1;
    cupOffSeason(id,inc);    
});





/** Changes count of wins of team which have teamId identifier
 * 
 * @param {integer} teamId
 * @param {integer} inc 
 * @returns {redirect} Refreshes the page. Page will be with new count of cups of OffSeason
 */
function winsTeamCountChange(teamId,inc) {
    var params = "teamId="+teamId+"&inc="+inc;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/'+teamId;
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/winsTeamCountChange",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#teamWinsPlus').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    var inc = 1;
    winsTeamCountChange(id,inc);    
});

$('#teamWinsMinus').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    var inc = -1;
    winsTeamCountChange(id,inc);    
});




/** Changes count of defeats of team which have teamId identifier
 * 
 * @param {integer} teamId
 * @param {integer} inc 
 * @returns {redirect} Refreshes the page. Page will be with new count of cups of OffSeason
 */
function defeatsTeamCountChange(teamId,inc) {
    var params = "teamId="+teamId+"&inc="+inc;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            location.href='/team/'+teamId;
            //document.getElementById("fortext").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/team/defeatsTeamCountChange",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#teamDefeatsPlus').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    var inc = 1;
    defeatsTeamCountChange(id,inc);    
});

$('#teamDefeatsMinus').click(function(ev){
    var id = $(".teamfont").attr('teamId'); 
    var inc = -1;
    defeatsTeamCountChange(id,inc);    
});



















/** Gets team names for search string
 * 
 * @param {string} search string
 */
function getTeamsName(str) {
    var params = "search_string="+str;
    //alert("getTeamsName="+params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            //location.href='/team/'+teamId;
            document.getElementById("dynamicSelectDiv").innerHTML=itext;
    	}	
    }
    xmlhttp.open("POST",  "/league/getTeamList",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}



 


$('#myTextbox').on('input', function() {
    var val = $('#myTextbox').val();
    clearTimeout(timerId);// Таймер нужен, чтобы после каждой клавиши не шел запрос, а ожидал 200 мс, если не нажималась еще клавиша, то только тогда отправляет запрос на сервер
    timerId = setTimeout(function () {getTeamsName(val);}, 300);
});



if ($('#dynamicSelectDiv').attr("func")=="getTeamsName" ){//Чтобы вызов этой функции срабатывал только на странице лигаWS
    getTeamsName("");// Заполняем ЛистБокс на модальной форме данными команд
}
 
//------------------------------------------
$('.team1').click(function (ev){
    var el = $( this ).parent();
    id_parent = el.attr("id");
    teamN = 1;
    location.href="#openModalTeam";
})

$('.team2').click(function (ev){
    var el = $( this ).parent();
    id_parent = el.attr("id");
    teamN = 2;
    location.href="#openModalTeam";
})
// модальная форма, клик по элементу из списка
$('#dynamicSelectDiv').click(function(ev){
    var idStr = "#"+id_parent+" .team"+teamN;
    $(idStr).attr("value",$( "#teamSelect option:selected" ).text());
    $(idStr).attr("team_id",$( "#teamSelect" ).val());
    location.href="#close_modalSelectTeam";
});

$('.btn_done').click(function (ev){
    var el = $( this ).parent();
    var id_parent = el.attr("id");
    var idStr = "#"+id_parent + " .team";
    var idTime = "#"+id_parent + " .date";
    var teamOneId = $(idStr+"1").attr("team_id");
    var teamTwoId = $(idStr+"2").attr("team_id");
    var dateTime = $(idTime).val();
    declareBattle(teamOneId,teamTwoId,dateTime,el);
});

/** Declares a battle through AJAX 
 * 
 * @param int teamOneId
 * @param int teamTwoId 
 * @param int dateTime Time of battle
 * @param object element of parent which we need to change after responce   
 * @returns {redirect} Refreshes the page. Page will be with new count of cups of OffSeason
 */
function declareBattle(teamOneId,teamTwoId,dateTime,el) {
    var params = "teamOneId="+teamOneId+"&teamTwoId="+teamTwoId+"&dateTime="+dateTime;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext[1]);
            if (itext[0]!="0"){
                el.css( "background-color", "#33BE39" );
                el.html(itext);
            }   else {
                alert("Ошибка сохранения боя. Повторите попытку");
            }
    	}	
    }
    xmlhttp.open("POST",  "/league/declareBattle",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('.btn_done_edit').click(function (ev){
    var el = $( this ).parent();
    var id_parent = el.attr("id");
    var idStr = "#"+id_parent + " .team";
    var idTime = "#"+id_parent + " .date";
    var battleId = el.attr("battleId");
    var teamOneId = $(idStr+"1").attr("team_id");
    var teamTwoId = $(idStr+"2").attr("team_id");
    var dateTime = $(idTime).val();
    editBattle(battleId,teamOneId,teamTwoId,dateTime,el);
});

/** Declares a battle through AJAX 
 * 
 * @param int teamOneId
 * @param int teamTwoId 
 * @param int dateTime Time of battle
 * @param object element of parent which we need to change after responce   
 * @returns {redirect} Refreshes the page. Page will be with new count of cups of OffSeason
 */
function editBattle(battleId,teamOneId,teamTwoId,dateTime,el) {
    var params = "battleId="+battleId+"&teamOneId="+teamOneId+"&teamTwoId="+teamTwoId+"&dateTime="+dateTime;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext[1]);
            if (itext[0]!="0"){
                el.css( "background-color", "#33BE39" );
                el.html(itext);
                location.href="/shedule/#battle"+battleId;
                
            }   else {
                alert("Ошибка сохранения боя. Повторите попытку");
            }
    	}	
    }
    xmlhttp.open("POST",  "/league/editBattleAJAX",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}




$('.date').click(function(){
    //window.alert("Generate");
	$(this).appendDtpicker({
		"onInit": function(handler){
			handler.show();
		},
		"onHide": function(handler){
			//window.alert("Picker is hidden, Then destroy a picker");
			handler.destroy();
		},
        "closeOnSelected": true
	});
});

//------------------------------------------


/** Define a winner of battle through AJAX 
 * 
 * @param int battleId Identifier of battle
 * @param int teamId Identifier of team
 * @param object element of parent which we need to change after responce   
 * @returns string html
 */
function defineWinner(battleId,teamId,idElement) {
    var params = "battleId="+battleId+"&teamId="+teamId;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            if (itext[0]!="0"){
                document.getElementById(idElement).innerHTML=itext;
            }   else {
                alert("Ошибка сохранения боя. Повторите попытку");
            }
    	}	
    }
    xmlhttp.open("POST",  "/shedule/defineWinner",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('.battleAssignWinner').click(function(ev){
    var battleId = $(this).attr("battleId");
    var teamId = $(this).attr("teamId");
    var idElement = 'battle'+battleId;
        defineWinner(battleId,teamId,idElement);
    
});

/* -------------------------------------------------------------- */

$('.battleEdit').click(function(ev){
    var battleId = $(this).attr("battleId");
    location.href= '/league/editBattle/'+battleId;
    
});

$('.battleDelete').click(function(ev){
    var answ = confirm('Вы собираетесь удалить матч. Вы уверены?');
    if (answ){
        var battleId = $(this).attr("battleId");
        deleteBattle(battleId);
    }
});

/** Deletes a battle through AJAX 
 * 
 * @param int battleId Identifier of battle
 */
function deleteBattle(battleId) {
    var params = "battleId="+battleId;
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            //alert(itext);
            if (itext[0]!="0"){
                $('#battle'+battleId).css('display','none');
            }   else {
                alert("Ошибка удаления боя. Повторите попытку");
            }
    	}	
    }
    xmlhttp.open("POST",  "/shedule/deleteBattle",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#newLeague').click(function(ev){  
    var answ = confirm("Вы уверены что хотите создать новую Лигу WS? Предыдущая лига, в таком случае, будет скрыта ");
    if (answ) {
        location.href='/league/addNew/1';
    }
});

$('#newCupOffSeason').click(function(ev){ 
    $(".ControlBoxCupOffSeasonTeamCount").css( "display", "block" );
    $(this).css("display","none");

});

$(".gradeTd").click(function(ev){ 
    grade = $(this).attr("grade");
    participantCount = $(this).text();
//    for(var i=1;i<=participantCount;i++){
//        alert(i);
//    }
    // let's get all teams
    // put them into all-array
    // 
    $(".ControlBoxCupOffSeasonTeamCount").css( "display", "none" );
    $(".selectParticipants").css( "display", "inline-table" );
    getAllTeam();
});


//---------------------------------------------------------------------------------------------


/** Get all approved team for off-season cup through AJAX 
 * 
 * @return {string} teams in string format with delimiters
 */
function getAllTeam() {
    var params = "param=1";
    
    //alert(params);
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            //alert("itext 5");
            var itext = xmlhttp.responseText;
            allCount = 0;
            pnt = [];
            var a1 = itext.split("<1111>");
            for(var i=1;i<a1.length;i++){
                all.push(a1[i].split("<1112>"));
            }
            all0 = all.slice(0);
            drawTeamsMemberTable();
            
    	}	
    }
    xmlhttp.open("POST",  "/team/getAllTeamApproved",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}



/*
  1.процедура из all в participant один элемент переместить
  2.процедура из participant в all один элемент переместить
  3.процедура в all всех переместить
  4.процедура в participant всех переместить
*/

/** Drawing table-tool to choose teams
 */
function drawTeamsMemberTable()
{
    var s="";
    var i=0;
    for(i=0; i<all.length; i++){
        s = s + "<div teamId="+all[i][0]+" class='teamMemberListAllArray' >" +all[i][1]+" </div>";
    }
    document.getElementById("teamMemberAllList").innerHTML=s;
    
    s="";
    for(i=0; i<pnt.length; i++){
        s = s + "<div teamId="+pnt[i][0]+" class='teamMemberListPntArray' >" +pnt[i][1]+" </div>";
    }
    document.getElementById("teamMemberPntList").innerHTML=s;

$('#teamMemberAllList').off('click', '.teamMemberListAllArray'); 
$('#teamMemberPntList').off('click', '.teamMemberListPntArray'); 


$('#teamMemberAllList').on('click', '.teamMemberListAllArray', function() 
{ 
    var id = $(this).attr("teamId");
    oneFromAllArrayToPntArray(id);
    drawTeamsMemberTable();
});

$('#teamMemberPntList').on('click', '.teamMemberListPntArray', function() 
{ 
    var id = $(this).attr("teamId");
    oneFromPntArrayToAllArray(id);
    drawTeamsMemberTable();
});

$("#teamsCount").html(pnt.length+" из "+participantCount);

if(participantCount<=pnt.length){
    $("#createCupOffSeasonButton").css('display','block');
    $("#timeStarterCupOffSeason").css('display','block');
}   else {
    $("#createCupOffSeasonButton").css('display','none');
    $("#timeStarterCupOffSeason").css('display','none');
}


}


/** Replacing element n from all-array to pnt-array
 * 
 * @param {integer} n
 * @returns {nothing}
 */
function oneFromAllArrayToPntArray(n)
{
    var ea = [];
    for(var i=0;i<all.length;i++){
        if (all[i][0]==n){
//            alert(all[i][1]);            
            ea = all[i];
            pnt.push(ea);//Добавляем в pnt тот элемент, который удалили из all-массива
            all.splice(i,1);
            return;
        }
    }
}

/** Replacing element n from png-array to all-array
 * 
 * @param {integer} n
 * @returns {nothing}
 */
function oneFromPntArrayToAllArray(n)
{
    var ea = [];
    for(var i=0;i<pnt.length;i++){
        if (pnt[i][0]==n){
//            alert(all[i][1]);            
            ea = pnt[i];
            all.push(ea);//Добавляем в pnt тот элемент, который удалили из all-массива
            pnt.splice(i,1);
            return;
        }
    }
}

function eachFromAllArrayToPntArray()
{
    all = [];
    pnt = [];
    pnt = all0.slice(0);
}

function eachFromPntArrayToAllArray()
{
    all = [];
    pnt = [];
    all = all0.slice();
}

$(".newCupSelectAll").click(function(ev)
{
    eachFromAllArrayToPntArray();
    drawTeamsMemberTable();
});

$(".newCupDeSelectAll").click(function(ev)
{
    eachFromPntArrayToAllArray();
    drawTeamsMemberTable();
});


/** Creates new off-season cup through AJAX 
 * 
 * @param string teams teams which take a member in cup
 */
function createCupOffSeasonAJAX(teams) {
    var dt = $( "#timeStarterCupOffSeason input" ).val();
    var params = "teams="+teams+"&grade="+grade+"&dt="+dt;
    
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            var itext = xmlhttp.responseText;
            if (itext[0]!="0"){
                //alert(itext);
                document.location = "/league/offSeasonView";
            }   else {
                alert("Ошибка создания кубка");
            }
    	}	
    }
    xmlhttp.open("POST",  "/league/addNew/0",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#createCupOffSeasonButton').click(function()
{
    var answ = confirm("Вы уверены что хотите создать новый Кубок Межсезонья? Предыдущий кубок, в таком случае, будет скрыт");
    if (answ) {
        if (pnt.length>participantCount){
            alert('Команд выбрано больше, чем того требует кубок. Последние команды будут отсечены');
        }
        var s=pnt[0][0]+"<1113>";
        for (var i=1;i<participantCount-1;i++ ){ // нам нужно только participantCount команд, не более
            s = s + pnt[i][0]+"<1113>";
        }
        s = s + pnt[participantCount-1][0];
        createCupOffSeasonAJAX(s); //sending participant teams
    }
});
//.svg-control 
$('.svg-control-font-winner').click(function(){
    var parentId = $(this).attr("parentId");
    var battleId = $(this).attr("battleId");
    var branch = $(this).attr("branch");
    var winner = $(this).attr("winner");
    //alert(parentId +" "+ battleId +" "+ branch+" "+ winner);
    setWinnerAndUpdateParentBattle(parentId,battleId,branch,winner);
   
    
   
});


function setWinnerAndUpdateParentBattle(parentId,battleId,branch,winner) {
    var params = "parentId="+parentId+"&battleId="+battleId+"&branch="+branch+"&winner="+winner;
    
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            var itext = xmlhttp.responseText;
            if (itext[0]!="0"){
                document.location = "/league/offSeasonView";
                //alert(itext);
            }   else {
                alert("Ошибка создания кубка");
            }
    	}	
    }
    xmlhttp.open("POST",  "/league/setWinnerUpdateParentBattleAJAX",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}

$('.svg-control-font-edit').click(function(){
    
    var battleId = $(this).attr("battleId");
    var pastEditWarning = $(this).attr("pastEditWarning");
    if (pastEditWarning==0){
        location.href= '/league/editBattle/'+battleId;   
    }
    if (pastEditWarning==1){
        var answ = confirm("Вы хотите редактировать матч, который уже состоялся. Продолжить?");
        if (answ) {
            location.href= '/league/editBattle/'+battleId;   
        }
    }
    
});


/** Shuffles teams at off-season cup through AJAX 
 * 
 * @param string dt date of begining cup. this date will be inc at 24 hours for each battle
 */
function shuffleCupOffSeasonAJAX(dt) {
    var params = "dt="+dt;
    if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 
    xmlhttp.onreadystatechange=function()
    { 
        if (xmlhttp.readyState==4 && xmlhttp.status==200){//проверяю, что запрос успешно прошел (status == 200) и что все данные были получены (readyState == 4).
            var itext = xmlhttp.responseText;
            if (itext[0]!="0"){
                //alert(itext);
                document.location = "/league/offSeasonView";
            }   else {
                alert("Ошибка смешивания команд =\ ");
            }
    	}	
    }
    xmlhttp.open("POST",  "/league/shuffle",true);
    xmlhttp.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );
    xmlhttp.send(params);
}


$('#aShuffle').click(function(){
    $("#shuffleContainer").css('display','block');
    $("#aShuffle").css('display','none');
});    

$('#shuffleCupOffSeasonButton').click(function(){
    var answ = confirm("Команды будут смешаны. Продолжить?");
    var dt = $( "#shuffleContainer input" ).val();
    if (answ){
        shuffleCupOffSeasonAJAX(dt);
    }
});    




});// конец ready .
