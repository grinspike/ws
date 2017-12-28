<?php 
$id = $teamItem["id"];

require_once(ROOT . '/views/layouts/header.php');
$teamname = $teamItem["name"];
$logo = $teamItem["logo"];
$kapitan = $teamItem["kapitan"];
$osnova1 = $teamItem["osnova1"];
$osnova2 = $teamItem["osnova2"];
$osnova3 = $teamItem["osnova3"];
$osnova4 = $teamItem["osnova4"];
$standin1 = $teamItem["standin1"];
$standin2 = $teamItem["standin2"];
$standin3 = $teamItem["standin3"];
$standin4 = $teamItem["standin4"];
$standin5 = $teamItem["standin5"];
$trainer = $teamItem["trainer"];
$cupLeague = (int)$teamItem["cup_league"]+(int)$teamItem["static_cup_league"];
$cupOffSeason = (int)$teamItem["cup_off_season"]+(int)$teamItem["static_cup_off_season"];
$wins = $teamItem["wins"] + $teamItem["static_wins"];
$defeats = $teamItem["defeats"] + $teamItem["static_defeats"];;
$games = $wins + $defeats;
$logo_path = '/'.$logo;
?>




<p class="teamfont" teamId="<?php echo $id; ?>"> <?php echo $teamname; ?>  </p>
<?php  if(isset($_SESSION["admin"])): ?>
<table  class="admin-edit-box">
    <tr>
        <?php if($teamItem["admin_approved"]==0):?>
        <td><a id="approve" class="admin-edit-button-a">УТВЕРДИТЬ</a></td>
        <?php else: ?>
        <td><a id="discard" class="admin-edit-button-a">ОТВЕРГНУТЬ</a></td>
        <?php endif; ?>
        <td><a id="editByAdmin" class="admin-edit-button-a">РЕДАКТИРОВАТЬ</a></td>
        <?php if($teamItem["visible"]==0):?>
        <td><a id="restore" class="admin-edit-button-a">ВОССТАНОВИТЬ</a></td>
        <?php else: ?>
        <td><a id="delete" class="admin-edit-button-a">СКРЫТЬ</a></td>
        <?php endif; ?>
        
    </tr>
</table>
<?php endif; ?>


<p> <img src="<?php echo $logo_path; ?>"></p> 


<p> 
<?php if (isset($_SESSION["admin"])): ?>
    <div class="cupControlBox">
        <img src='/image/cup/125/60/<?php echo $cupLeague; ?>/league' title='Кубок лиги WS' >
        <table class="cupLeagueControl">
            <tr>
                <td id="cupLeagueMinus"><</td>
                <td id="cupLeagueCount"><?php echo $cupLeague; ?></td>
                <td id="cupLeaguePlus">></td>
            </tr>
        </table>
    </div>
    
    <div class="cupControlBox">
        <img src='/image/cup/125/60/<?php echo $cupOffSeason; ?>/offSeason' title='Кубок Межсезонья'> 
        <table class="cupOffSeasonControl">
            <tr>
                <td id="cupOffSeasonMinus"><</td>
                <td id="cupOffSeasonCount"><?php echo $cupOffSeason; ?></td>
                <td id="cupOffSeasonPlus">></td>
            </tr>
        </table>
    </div>
<?php    else: ?> 
<?php    
    if($cupLeague>0 ){echo "<img src='/image/cup/125/60/".$cupLeague."/league' title='Кубок лиги WS' >\n";} 
    if($cupOffSeason>0 ){echo "<img src='/image/cup/125/60/".$cupOffSeason."/offSeason' title='Кубок Межсезонья'> \n"; } 
    endif;
?>
</p> 
<p> 
<?php if (isset($_SESSION["admin"])): ?>
    <table class="cupLeagueControl">
        <thead>
            <tr>
                <th>Победы</th>
                <th>Поражения</th>
                <th>К-во игр</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a id="teamWinsMinus" class="teamControlButton"><</a><a><?php echo $wins; ?></a><a id="teamWinsPlus" class="teamControlButton">></a></td>
                <td><a id="teamDefeatsMinus" class="teamControlButton"><</a><a><?php echo $defeats; ?></a><a id="teamDefeatsPlus" class="teamControlButton">></a></td>
                <td><?php echo $games; ?></td>
            </tr>
        </tbody>
    </table>    
<?php    else: ?> 
    <table class="cupLeagueControl">
        <thead>
            <tr>
                <th>Победы</th>
                <th>Поражения</th>
                <th>К-во игр</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a><?php echo $wins; ?></a></td>
                <td><a><?php echo $defeats; ?></a></td>
                <td><a><?php echo $games; ?></a></td>
            </tr>
        </tbody>
    </table>    
<?php    endif;?>
</p> 


<p class="title-page" id="filldata">СОСТАВ:</p>

<table id="team_structure">      
  <tr>  
        <td>Капитан: </td>
        <td><?php echo $kapitan; ?> </td>
  </tr>  
  <tr>  
        <td>Основа: </td>
        <td><?php echo $osnova1; ?> </td>
  </tr>  
  <tr>  
        <td>Основа: </td>
        <td><?php echo $osnova2; ?> </td>
  </tr>  
  <tr>  
        <td>Основа: </td>
        <td><?php echo $osnova3; ?> </td>
  </tr>  
  <tr>  
        <td>Основа: </td>
        <td><?php echo $osnova4; ?> </td>
  </tr>  
   <tr>  
        <td>Стендин: </td>
        <td><?php echo $standin1; ?> </td>
  </tr>  
  <tr>  
        <td>Стендин: </td>
        <td><?php echo $standin2; ?> </td>
  </tr>  
  <tr>  
        <td>Стендин: </td>
        <td><?php echo $standin3; ?> </td>
  </tr>  
  <tr>  
        <td>Стендин: </td>
        <td><?php echo $standin4; ?> </td>
  </tr>  
  <tr>  
        <td>Стендин: </td>
        <td><?php echo $standin5; ?> </td>
  </tr>  
  <tr>  
        <td>Тренер: </td>
        <td><?php echo $trainer; ?></td>
  </tr>  
</table>



<?php
require_once(ROOT . '/views/layouts/footer.php');
?>
   
