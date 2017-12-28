<?php 
require_once(ROOT . '/views/layouts/header.php');
?>

<p class="title-page"> РАСПИСАНИЕ </p>
<p class="title-page"> <a href='/shedule/archive' class="archive">АРХИВ</a>     </p>

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
    // controls for defining a winner
    if (isset($_SESSION["admin"])){ 
        $htmlBattleControlEdit = '<img src="/template/images/edit.png" class="battleEdit" title="Редактировать" battleId="'.$v["id"].'" >';
        if ($cupType==1){ // Удаление активно только для Лиги
            $htmlBattleControlDelete = '<img src="/template/images/delete.png" class="battleDelete"  title="Удалить бой" battleId="'.$v["id"].'" >';
        }   else    {$htmlBattleControlDelete = '';}
    }   else    {
        $htmlBattleControlEdit = '';
        $htmlBattleControlDelete = '';        
    }

    $dt = date_parse($v["datetime"]);
    $battles[$key]["month"] = $month[$dt["month"]];
    if (strlen($dt["minute"])<2){$dt["minute"]="0".$dt["minute"];}
    if (strlen($dt["hour"])<2){$dt["hour"]="0".$dt["hour"];}
    print <<<HERE
    <div id="battle{$v["id"]}" class="battle">
        <div class="battleTimeTitle"> $htmlBattleControlEdit {$battles[$key]["cupName"]}, {$dt["day"]} {$battles[$key]["month"]}, {$dt["hour"]}:{$dt["minute"]}  $htmlBattleControlDelete </div> 
        <table>
        <tr>
            <td style="text-align : left;"><div class="battleStripTitleLeft">{$v["teamNameA"]}</div> <a href="/team/{$v["side_a"]}"><img src="{$v["teamLogoA"]}" class="battleLogoImage"></a></td>
            <td style="text-align : right;"><div class="battleStripTitleRight">{$v["teamNameB"]}</div> <a href="/team/{$v["side_b"]}"><img src="{$v["teamLogoB"]}" class="battleLogoImage"></a></td>
        </tr>
        </table>
    </div>
HERE;
}

?>
<?php 
require_once(ROOT . '/views/layouts/footer.php');
?>
   
