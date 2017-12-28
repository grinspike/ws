<?php 
require_once(ROOT . '/views/layouts/header.php');
?>

<p class="title-page"> АРХИВ </p>
<?php 

$month[1]="Января";
$month[2]="Февраля";
$month[3]="Марта";
$month[4]="Апреля";
$month[5]="Мая";
$month[6]="Июня";
$month[7]="Июля";
$month[8]="Августа";
$month[9]="Сентября";
$month[10]="Октября";
$month[11]="Ноября";
$month[12]="Декабря";

foreach ($battles as $v) {
    if ($v["winner"]!="0"){ // if winner is defined
        if($v["winner"]==$v["side_a"]){
            $htmlWinnerSideA = '<img src="/template/images/winnerCup.png" class="battleLogoImage">';
            $htmlWinnerSideB = '';            
        }   else    {
            $htmlWinnerSideA = '';            
            $htmlWinnerSideB = '<img src="/template/images/winnerCup.png" class="battleLogoImage">';            
        }
        
        $htmlWinner = '<div class="battleWinnerTitle">Победившая сторона: <a class="battleWinnerName">'.$v["winnerTeamName"].'</a></div>';
    } else { // winner not defined
        $htmlWinnerSideA = '';
        $htmlWinnerSideB = '';
        $htmlWinner = '<div class="battleWinnerTitle">Победившая сторона не определена</div>';
    }
    // controls for defining a winner
    if (isset($_SESSION["admin"])AND($cupType==1)){ 
        $htmlWinnerSideAControl = '<a class="battleAssignWinner" battleId="'.$v["id"].'" teamId="'.$v["side_a"].'">Сделать победителем</a>';
        $htmlWinnerSideBControl = '<a class="battleAssignWinner" battleId="'.$v["id"].'" teamId="'.$v["side_b"].'">Сделать победителем</a>';
        $doNotShowThisBattle = false;
    }   else    {
        $htmlWinnerSideAControl = '';
        $htmlWinnerSideBControl = '';        
        if ($v["datetime"]!=="0000-00-00 00:00:00") {    $doNotShowThisBattle = true; } else {    $doNotShowThisBattle = false; }
    }
    $dt = date_parse($v["datetime"]);
    $battles[$key]["month"] = $month[$dt["month"]];
    if (strlen($dt["minute"])<2){$dt["minute"]="0".$dt["minute"];}
    if (strlen($dt["hour"])<2){$dt["hour"]="0".$dt["hour"];}
    
    $timeAction = "{$battles[$key]["cupName"]}, {$dt["day"]} {$battles[$key]["month"]}, {$dt["hour"]}:{$dt["minute"]}";
    if ($v["datetime"]==="0000-00-00 00:00:00") {$timeAction = "{$battles[$key]["cupName"]}, время боя не определено";}
    
    print <<<HERE
    <div id="battle{$v["id"]}" class="battle"> 
        <div class="battleTimeTitle">  $timeAction </div> 
        <table>
        <tr>
            <td style="text-align : left;"><div class="battleStripTitleLeft">{$v["teamNameA"]}</div>
                <a href="/team/{$v["side_a"]}"><img src="{$v["teamLogoA"]}" class="battleLogoImage"></a>$htmlWinnerSideA<br>$htmlWinnerSideAControl</td>
            <td style="text-align : right;"><div class="battleStripTitleRight">{$v["teamNameB"]}</div>
                $htmlWinnerSideB<a href="/team/{$v["side_b"]}"><img src="{$v["teamLogoB"]}" class="battleLogoImage"></a><br>$htmlWinnerSideBControl</td>
        </tr>
        </table>
            $htmlWinner
    </div>
HERE;
    }
        

?>

<?php 
require_once(ROOT . '/views/layouts/footer.php');
?>
   
