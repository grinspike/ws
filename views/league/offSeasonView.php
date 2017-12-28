<?php 
require_once(ROOT . '/views/layouts/header.php');
include_once ROOT .'/config/tournamentTable.php';

?>

<p class="title-page"> Кубок Межсезонья </p>
<?php 
    $date = date('Y-m-d H:i:s');
    $dt = date_parse($date);
    if (strlen($dt["month"])<2){$dt["month"]="0".$dt["month"];}
    if (strlen($dt["day"])<2){$dt["day"]="0".$dt["day"];}
    $t = $dt["year"]."-".$dt["month"]."-".$dt["day"]." 20:00";
?>

<?php 
if(isset($_SESSION["admin"])): ?>
<a class='newCupOrLeague' id='aShuffle' >Смешать команды</a><br>
<div id="shuffleContainer" class="battle">
    <p>День и время, с которого начнется кубок и все последующие матчи будут происходить через сутки:</p>
    <input type="text" class="date" value="<?php echo $t;?>">
    <div id="shuffleCupOffSeasonButton"> СМЕШАТЬ </div>
</div><br>

<a class='newCupOrLeague' id='newCupOffSeason' >Создать новый Кубок Межсезонья</a>
<table class="ControlBoxCupOffSeasonTeamCount">
        <tr>
            <td class="gradeTd" grade="6">64</td>
            <td class="gradeTd" grade="5">32</td>
            <td class="gradeTd" grade="4">16</td>
            <td class="gradeTd" grade="3">8</td>
            <td class="gradeTd" grade="2">4</td>
            <td class="gradeTd" grade="1">2</td>
        </tr>
</table>
<p class="title-page" id="teamsCount">  </p>

<table class="selectParticipants">
        <tr>
            <td><a>Список доступных команд</a></td>
            <td><a>Список выбранных команд</a></td>
        </tr>
        <tr>
            <td><a class="newCupSelectAll">Выбрать всех</a></td>
            <td><a class="newCupDeSelectAll">Отменить всех</a></td>
        </tr>
        <tr>
            <td id="teamMemberAllList"></td>
            <td id="teamMemberPntList"></td>
        </tr>
</table>



<div id="timeStarterCupOffSeason" class="battle">
    <p>День и время, с которого начнется кубок и все последующие матчи будут происходить через сутки:</p><input type="text" class="date" value="<?php echo $t;?>">
</div><br>


<div id="createCupOffSeasonButton"> СОЗДАТЬ </div>
<?php endif;?>

<?php 
$svg = $svg1.$svg2.$svg3;
echo $svg; ?>

<?php 
require_once(ROOT . '/views/layouts/footer.php');
?>
   
