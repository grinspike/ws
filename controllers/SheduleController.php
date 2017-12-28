<?php

class SheduleController {

    /** Расписание
    * 
    */
    public function actionView()
    {
        //1 Определить что последнее : кубок межсезонья либо лига, и взять cupId её
        $v = League::getLastLeagueOrCup();
        $cupId = $v["id"];
        //2 Сделать соответствующую выборку боев, используя cupId
        $battles = Battle::getSheduleBattles($cupId);
        foreach ($battles as $key => $value) {
            $battles[$key]["teamNameA"] = Team::getTeamNameByID($battles[$key]["side_a"]);
            $battles[$key]["teamNameB"] = Team::getTeamNameByID($battles[$key]["side_b"]);
            $battles[$key]["teamLogoA"] = '/'.Team::getTeamLogoByID($battles[$key]["side_a"]);
            $battles[$key]["teamLogoB"] = '/'.Team::getTeamLogoByID($battles[$key]["side_b"]);
            $cupType = League::getLeagueCupType($battles[$key]["cup_id"]);
            if ($cupType==0){$battles[$key]["cupName"]="Кубок межсезонья";}
            if ($cupType==1){$battles[$key]["cupName"]="Лига WS";}
        }
        require_once(ROOT . '/views/shedule/view.php');
        return true;
    }

    /** Archive
    * 
    */
    public function actionArchive()
    {
        $v = League::getLastLeagueOrCup();
        $id = $v["id"];
        $battles = Battle::getSheduleArchiveBattlesById($id);
        foreach ($battles as $key => $value) {
            $battles[$key]["teamNameA"] = Team::getTeamNameByID($battles[$key]["side_a"]);
            $battles[$key]["teamNameB"] = Team::getTeamNameByID($battles[$key]["side_b"]);
            $battles[$key]["teamLogoA"] = '/'.Team::getTeamLogoByID($battles[$key]["side_a"]);
            $battles[$key]["teamLogoB"] = '/'.Team::getTeamLogoByID($battles[$key]["side_b"]);
            if ($battles[$key]["side_a"]===$battles[$key]["winner"]){
                $battles[$key]["winnerTeamName"] = $battles[$key]["teamNameA"];
            }
            if ($battles[$key]["side_b"]===$battles[$key]["winner"]){
                $battles[$key]["winnerTeamName"] = $battles[$key]["teamNameB"];
            }
            $cupType = League::getLeagueCupType($battles[$key]["cup_id"]);
            if ($cupType==0){$battles[$key]["cupName"]="Кубок межсезонья";}
            if ($cupType==1){$battles[$key]["cupName"]="Лига WS";}
        }
        require_once(ROOT . '/views/shedule/archive.php');
        return true;
    }




        
    
    public function actionDefineWinner()
    {
        $battleId = $_POST["battleId"];    
        $teamId = $_POST["teamId"];    
        
        if (isset($_SESSION["admin"])){
            $result = Battle::defineWinner($battleId, $teamId);
            if ($result!=true){
                echo "0";        
            }   else { 
                $v = Battle::getBattle($battleId);
                $v["teamNameA"] = Team::getTeamNameByID($v["side_a"]);
                $v["teamNameB"] = Team::getTeamNameByID($v["side_b"]);
                $v["teamLogoA"] = '/'.Team::getTeamLogoByID($v["side_a"]);
                $v["teamLogoB"] = '/'.Team::getTeamLogoByID($v["side_b"]);
                if ($v["side_a"]===$v["winner"]){
                    $v["winnerTeamName"] = $v["teamNameA"];
                }
                if ($v["side_b"]===$v["winner"]){
                    $v["winnerTeamName"] = $v["teamNameB"];
                }

                if($v["winner"]==$v["side_a"]){
                    $htmlWinnerSideA = '<img src="/template/images/winnerCup.png" class="battleLogoImage">';
                    $htmlWinnerSideB = '';            
                }   else    {
                    $htmlWinnerSideA = '';            
                    $htmlWinnerSideB = '<img src="/template/images/winnerCup.png" class="battleLogoImage">';            
                }
            $cupType = League::getLeagueCupType($v["cup_id"]);
            if ($cupType==0){$v["cupName"]="Кубок межсезонья";}
            if ($cupType==1){$v["cupName"]="Лига WS";}
            
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

            $dt = date_parse($v["datetime"]);
            $v["month"] = $month[$dt["month"]];
            if (strlen($dt["minute"])<2){$dt["minute"]="0".$dt["minute"];}
            if (strlen($dt["hour"])<2){$dt["hour"]="0".$dt["hour"];}
                

            
                $htmlWinner = '<div class="battleWinnerTitle">Победившая сторона: '.$v["winnerTeamName"].'</div>';
                $htmlWinner = '<div class="battleWinnerTitle">Победившая сторона: <a class="battleWinnerName">'.$v["winnerTeamName"].'</a></div>';
                print <<<HERE
        <div class="battleTimeTitle"> {$v["cupName"]}, {$dt["day"]} {$v["month"]}, {$dt["hour"]}:{$dt["minute"]} </div> 
        
        <table>
        <tr>
            <td style="text-align : left;"><div class="battleStripTitleLeft">{$v["teamNameA"]}</div> 
                <a href="/team/{$v["side_a"]}"><img src="{$v["teamLogoA"]}" class="battleLogoImage"></a>$htmlWinnerSideA </td>
            <td style="text-align : right;"><div class="battleStripTitleRight">{$v["teamNameB"]}</div> 
                $htmlWinnerSideB<a href="/team/{$v["side_b"]}"><img src="{$v["teamLogoB"]}" class="battleLogoImage"></a> </td>
        </tr>
        </table>
            $htmlWinner
HERE;
            }
            $controllerUpdateStat = New TeamController();
            $controllerUpdateStat->actionRefreshStatisticsOfTeams();
        }
        return true;
    }

    public function actionDeleteBattle()
    {
        $battleId = $_POST["battleId"];    
        
        if (isset($_SESSION["admin"])){
            $result = Battle::deleteBattle($battleId);
            if ($result!=true){
                echo "0";        
            }   else { 
                echo "ok";        
            }
        }
        return true;
    }




    
    
}

