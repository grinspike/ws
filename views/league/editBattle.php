<?php 
require_once(ROOT . '/views/layouts/header.php');
?>

<p class="title-page"> Редактирование Боя </p>


<?php 

print <<<HERE
<div id="set0" battleId="{$v["id"]}" class="battle">
    <p>Время:</p><input type="text" class="date" value="{$v["datetime"]}">
    <p>Комада 1:</p><input type="text" class="team1" team_id="{$v["side_a"]}" value="{$v["teamNameA"]}">
    <p>Команда 2:</p><input type="text" class="team2" team_id="{$v["side_b"]}" value="{$v["teamNameB"]}">
    <br><input type="button" class="btn_done_edit" value="СОХРАНИТЬ">
</div><br>
HERE;

?>


<a href="#openModal" data-title="Выбрать команду"></a>
<div id="openModalTeam" class="modalSelectTeam">
    <div>
		<a id="modal_closeTeam" href="#close_modalSelectTeam" title="Закрыть" class="close_modalSelectTeam">X</a>
		<h3 id="dob_perevoz">Выбор команды</h3>
<div action="#close_modalSelectTeam" name="form1">
    <input type="text" id="myTextbox" value="">
    <br>
    <div id="dynamicSelectDiv" func="getTeamsName">
        <select name="name" id="teamSelect" size = "10">
        </select>
    </div>
</div>
</div>
</div>


<?php 
require_once(ROOT . '/views/layouts/footer.php');
?>
   
