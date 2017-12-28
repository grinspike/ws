<?php

class LeagueController {

    /** Показывает последнюю проводившуюся лигу - ЛИГУ WS
    * 
    */
    public function actionView()
    {
        $rowLeague = League::getLastLeagueWS();
        $idLeague = $rowLeague["id"];
        
//        switch ($season) {
//            case "0":
//            $season_name = "Зима";
//            break;
//            case "1":
//            $season_name = "Весна";
//            break;
//            case "2":
//            $season_name = "Лето";
//            break;
//            case "3":
//            $season_name = "Осень";
//            break;
//        }
        
        $rowBattles = Battle::getBattlesFromLeague($idLeague);
        $arr = array();
        foreach ($rowBattles as $key => $value) { // В $arr собираем статистику по командам : сколько было боев у этой команды, сколько побед
            $sideA = $value["side_a"];//id команды №1, которая принимает участие в поединке
            $sideB = $value["side_b"];//id команды №2, которая принимает участие в поединке
            $winner = $value["winner"];//id команды которая выиграла поединок
            if (!isset($arr[$sideA]["battlesCount"])){$arr[$sideA]["battlesCount"]=0;}
            if (!isset($arr[$sideB]["battlesCount"])){$arr[$sideB]["battlesCount"]=0;}
            if (!isset($arr[$sideA]["winnerCount"])){$arr[$sideA]["winnerCount"]=0;}
            if (!isset($arr[$sideB]["winnerCount"])){$arr[$sideB]["winnerCount"]=0;}

            $arr[$sideA]["battlesCount"] = $arr[$sideA]["battlesCount"] + 1;
            $arr[$sideB]["battlesCount"] = $arr[$sideB]["battlesCount"] + 1;
            $arr[$winner]["winnerCount"] = $arr[$winner]["winnerCount"] + 1;
            
        }
        $teamsOfLeague = array(); // Adding field with name of team to array
        foreach ($arr as $key => $value) {
            $teamsOfLeague[$key]["name"] = Team::getTeamNameByID($key);
            $teamsOfLeague[$key]["wins"] = $value["winnerCount"];
            $teamsOfLeague[$key]["defeats"] = $value["battlesCount"]-$value["winnerCount"];
            $teamsOfLeague[$key]["battlesCount"] = $value["battlesCount"];
        }
        
        
        require_once(ROOT . '/views/league/view.php');
		return true;
    }
    
        /** Draws tournament table
     * 
     * @param type $bWidth
     * @param type $bHeight
     * @param type $grade
     * @param type $step
     * @param type $xRoot
     * @param type $yRoot
     * @param type $tTPNFW
     * @param type $tTPNFH
     * @param type $tTPNFWP
     * @param type $tTPNFHP
     * @param type $battleId
     * @param string $bt
     * @param int $parrentId
         * 
     * @param string $branch Shows that this branch-child is "A" or "B" type
     * @return type
     */
    public function drawBattleAdmin($bWidth,$bHeight,$grade,$step,$xRoot,$yRoot,$tTPNFW,$tTPNFH,$tTPNFWP,$tTPNFHP,$battleId,$bt,$branch,$parrentId) {
        if ($grade==0){return ;}
        $newStep = $step + 1;
        $newGrade = $grade - 1;
        $sideWinner = $bt[$battleId]["winner"];
        $sideA = $bt[$battleId]["side_a"];
        $sideB = $bt[$battleId]["side_b"];
        $teamA = $bt[$battleId]["teamA"];
        $teamB = $bt[$battleId]["teamB"];
        $battleIdA = $bt[$battleId]["battle_a"];
        $battleIdB = $bt[$battleId]["battle_b"];
        $dateTime = $bt[$battleId]["datetime"];
        //--- Для удобоваримого вида типа "2 июля, 19:30"
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
        $dt = date_parse($dateTime);
        $dt["month"] = $month[$dt["month"]];
        if (strlen($dt["minute"])<2){$dt["minute"]="0".$dt["minute"];}
        if (strlen($dt["hour"])<2){$dt["hour"]="0".$dt["hour"];}
        $dateBattle = "{$dt['day']} {$dt['month']}, {$dt['hour']}:{$dt['minute']}";
        //---
        
        $dat = '2030-01-01 10:00:00';
        
        $x = $xRoot - $tTPNFW;
        $y = $yRoot - $tTPNFH;
        if ($step==1){$mn = 4;}
        if ($step==2){$mn = 8;}
        if ($step==3){$mn = 16;}
        if ($step==4){$mn = 32;}
        if ($step==5){$mn = 64;}
        if ($step==6){$mn = 128;}
        
        $ra = round($bHeight/$mn); // деление высоты svg элемента на количество делений в зависимости шага (колонка) 

        $bpx1 = 0;//bracket point x and y 
        $bpy1 = 0;
        
        $bpx2 = round($tTPNFWP/2);
        $bpy2 = 0;
        
        $bpx3 = round($tTPNFWP/2);
        $bpy3 = round($ra/2);
        
        $bpx4 = round($tTPNFWP/2);
        $bpy4 = $ra;
        
        $bpx5 = $tTPNFWP;
        $bpy5 = $ra;
        
        $bpx6 = round($tTPNFWP/2);
        $bpy6 = $ra*2;
        
        $bpx7 = 0;
        $bpy7 = $ra*2;

        $dx = $tTPNFW+1;
        $dy = $tTPNFH+1;

        $classTeamNameA = 'team-name';
        $classTeamNameB = 'team-name';
        If($sideWinner!=0){
            if($sideWinner==$sideA){$classTeamNameA = 'team-name-winner';}
            if($sideWinner==$sideB){$classTeamNameB = 'team-name-winner';}
        }
        
        
        $svg = "<svg x='$x' y='$y' class='a' > 
            <rect x='0' y='0' width='$tTPNFW' height='$tTPNFH' rx='3' ry='3' class='$classTeamNameA'> </rect>
            <text x='0' y='17' width='$tTPNFW' height='12' text-anchor='left' class='team-name-font' >$teamA</text>

            <rect x='0' y='$dy' width='$tTPNFW' height='$tTPNFH' rx='3' ry='3' class='$classTeamNameB'></rect>
            <text x='0' y='45' width='10' height='12' text-anchor='left' class='team-name-font' >$teamB</text>
            </svg>";

        If($dateTime < $dat){ //Если дата у боя максимально-статическая('2030-01-01 10:00:00'), то редактировать его не нужно, он пустой
        $svg .= "<svg x='$x' y='$y' class='a' > 
            <rect x='$dx' y='0' width='22' height='22' rx='3' ry='3' class='svg-control-winner'> </rect>            
            <text x='$dx' y='17' width='10' height='12' text-anchor='left' class='svg-control-font-winner' winner='$sideA' battleId='$battleId' parentId='$parrentId' branch='$branch'   >&#10003</text>
            <rect x='$dx' y='$dy' width='22' height='22' rx='3' ry='3' class='svg-control-winner'> </rect>            
            <text x='$dx' y='45' width='10' height='12' text-anchor='left' class='svg-control-font-winner' winner='$sideB' battleId='$battleId' parentId='$parrentId' branch='$branch'   >&#10003</text>
            </svg>";
        }
            $x = $xRoot - $tTPNFW;
            $y = $yRoot - $tTPNFH - $tTPNFH;
            
            
            $dat1 = $dateTime;
            if ( $dat1 < $dat ){
                $svg .= "<svg x='$x' y='$y' class='a' > 
                <text x='0' y='17' width='$tTPNFW' height='12' text-anchor='left' class='battle-time-font' > $dateBattle</text>
                </svg>";
            }
        
        
        $x = $xRoot - $tTPNFW - $tTPNFWP;
        $y = $yRoot - $ra;

            $dx = $bpx5 - 23;
            $dy = $bpy5 + 3;
            $tdy = $dy+18;
            
            // Установка предупреждения перед редактированием для боев которые уже произошли
            $curDate = date('Y-m-d H:i:s');
            
            If($dateTime<$curDate){
                $pastEditWarning = "1";
            }   else    {
                $pastEditWarning = "0";
            }
            
            If($dateTime < $dat){ //Если дата у боя максимально-статическая('2030-01-01 10:00:00'), то редактировать его не нужно, он пустой
                $svg .= "<svg x='$x' y='$y' class='a' > 
                    <rect x='$dx' y='$dy' width='22' height='22' rx='3' ry='3' class='svg-control-edit'> </rect>            
                    <text x='$dx' y='$tdy' width='22' height='22' text-anchor='left' pastEditWarning='$pastEditWarning' battleId='$battleId' class='svg-control-font-edit'  > &#9999;</text>
                </svg>";
            }
            
            
        if ($newGrade>0) {
            $svg .= "<svg x='$x' y='$y' class='a' > 
                <path d='M $bpx1 $bpy1 L $bpx2 $bpy2 L $bpx3 $bpy3 ' class='bracket-line'>
                </path>
                <path d='M $bpx3 $bpy3 L $bpx4 $bpy4 L $bpx5 $bpy5 ' class='bracket-line'>
                </path>
                <path d='M $bpx4 $bpy4 L $bpx6 $bpy6 L $bpx7 $bpy7 ' class='bracket-line'>
                </path>
                </svg>";
        }
        
        $xNew = $xRoot - $tTPNFW - $tTPNFWP;
        $yNew = $yRoot - $ra;
        $svg .= $this->drawBattleAdmin($bWidth,$bHeight,$newGrade,$newStep,$xNew,$yNew,$tTPNFW,$tTPNFH,$tTPNFWP,$tTPNFHP,$battleIdA,$bt,"a",$battleId);
        
        $xNew = $xRoot - $tTPNFW - $tTPNFWP;
        $yNew = $yRoot + $ra;
        $svg .= $this->drawBattleAdmin($bWidth,$bHeight,$newGrade,$newStep,$xNew,$yNew,$tTPNFW,$tTPNFH,$tTPNFWP,$tTPNFHP,$battleIdB,$bt,"b",$battleId);
        
        return $svg;
        
    }
  
    
    
    /** Draws tournament table
     * 
     * @param type $bWidth
     * @param type $bHeight
     * @param type $grade
     * @param type $step
     * @param type $xRoot
     * @param type $yRoot
     * @param type $tTPNFW
     * @param type $tTPNFH
     * @param type $tTPNFWP
     * @param type $tTPNFHP
     * @param type $battleId
     * @param type $bt
     * @return type
     */
    public function drawBattle($bWidth,$bHeight,$grade,$step,$xRoot,$yRoot,$tTPNFW,$tTPNFH,$tTPNFWP,$tTPNFHP,$battleId,$bt) {
        if ($grade==0){return ;}
        $newStep = $step + 1;
        $newGrade = $grade - 1;
        $sideWinner = $bt[$battleId]["winner"];
        $sideA = $bt[$battleId]["side_a"];
        $sideB = $bt[$battleId]["side_b"];
        $teamA = $bt[$battleId]["teamA"];
        $teamB = $bt[$battleId]["teamB"];
        $battleIdA = $bt[$battleId]["battle_a"];
        $battleIdB = $bt[$battleId]["battle_b"];
        
        $x = $xRoot - $tTPNFW;
        $y = $yRoot - $tTPNFH;
        if ($step==1){$mn = 4;}
        if ($step==2){$mn = 8;}
        if ($step==3){$mn = 16;}
        if ($step==4){$mn = 32;}
        if ($step==5){$mn = 64;}
        if ($step==6){$mn = 128;}
        
        $ra = round($bHeight/$mn); // деление высоты svg элемента на количество делений в зависимости шага (колонка) 

        $bpx1 = 0;//bracket point x and y 
        $bpy1 = 0;
        
        $bpx2 = round($tTPNFWP/2);
        $bpy2 = 0;
        
        $bpx3 = round($tTPNFWP/2);
        $bpy3 = round($ra/2);
        
        $bpx4 = round($tTPNFWP/2);
        $bpy4 = $ra;
        
        $bpx5 = $tTPNFWP;
        $bpy5 = $ra;
        
        $bpx6 = round($tTPNFWP/2);
        $bpy6 = $ra*2;
        
        $bpx7 = 0;
        $bpy7 = $ra*2;
        
            $classTeamNameA = 'team-name';
            $classTeamNameB = 'team-name';
        If($sideWinner!=0){            
            if($sideWinner==$sideA){$classTeamNameA = 'team-name-winner';}
            if($sideWinner==$sideB){$classTeamNameB = 'team-name-winner';}
        }

        $svg = "<svg x='$x' y='$y' class='a' > 
            <rect x='0' y='0' width='$tTPNFW' height='$tTPNFH' rx='3' ry='3' class='$classTeamNameA'> </rect>
            <text x='0' y='17' width='10' height='12' text-anchor='left' class='team-name-font' >$teamA</text>
    
            <rect x='0' y='26' width='$tTPNFW' height='$tTPNFH' rx='3' ry='3' class='$classTeamNameB'></rect>
            <text x='0' y='45' width='10' height='12' text-anchor='left' class='team-name-font' >$teamB</text>

            </svg>";

        $x = $xRoot - $tTPNFW - $tTPNFWP;
        $y = $yRoot - $ra;
        
        if ($newGrade>0) {
            $svg .= "<svg x='$x' y='$y' class='a' > 
                <path d='M $bpx1 $bpy1 L $bpx2 $bpy2 L $bpx3 $bpy3 ' class='bracket-line'>
                </path>
                <path d='M $bpx3 $bpy3 L $bpx4 $bpy4 L $bpx5 $bpy5 ' class='bracket-line'>
                </path>
                <path d='M $bpx4 $bpy4 L $bpx6 $bpy6 L $bpx7 $bpy7 ' class='bracket-line'>
                </path>
                </svg>";
        }
        
        $xNew = $xRoot - $tTPNFW - $tTPNFWP;
        $yNew = $yRoot - $ra;
        $svg .= $this->drawBattle($bWidth,$bHeight,$newGrade,$newStep,$xNew,$yNew,$tTPNFW,$tTPNFH,$tTPNFWP,$tTPNFHP,$battleIdA,$bt);
        
        $xNew = $xRoot - $tTPNFW - $tTPNFWP;
        $yNew = $yRoot + $ra;
        $svg .= $this->drawBattle($bWidth,$bHeight,$newGrade,$newStep,$xNew,$yNew,$tTPNFW,$tTPNFH,$tTPNFWP,$tTPNFHP,$battleIdB,$bt);
        
        return $svg;
        
    }
     
    /** Показывает последний проводившийся кубок - кубок межсезонья
    * 
    */
    public function actionOffSeasonView()
    {
        
        $rowLeague = League::getLastCupOffSeason();
        $cupId = $rowLeague["id"];
        //include_once ROOT .'/config/tournamentTable.php';
        require ROOT .'/config/tournamentTable.php';
        //finding grade
        $grade = Battle::getGradeOfCup($cupId);
        $topBattleId = Battle::getTopBattleIdOfCup($cupId);
        $bt = Battle::getBattlesOfCupForTournamentTable($cupId);
        
        foreach ($bt as $key=> $v) {
            $id = $v["id"];
            $bt[$id] = $bt[$key];
            unset($bt[$key]);
            $bt[$id]["teamA"] = Team::getTeamNameByID($bt[$id]["side_a"]);
            $bt[$id]["teamB"] = Team::getTeamNameByID($bt[$id]["side_b"]);
        }
//        echo "<pre>";
//        var_dump($bt);
//        return true;
        
        $grade = $grade + 1; // Грейд в т. `battles` касается на самом деле количества команд, потому для боев 
        $bWidth = $grade*($tTPNFW+$tTPNFWP);
        if ($grade == 1) {$battles = 2;}
        if ($grade == 2) {$battles = 4;}
        if ($grade == 3) {$battles = 8;}
        if ($grade == 4) {$battles = 16;}
        if ($grade == 5) {$battles = 32;}
        if ($grade == 6) {$battles = 64;}
        if (isset($_SESSION["admin"])){
            $bHeight = $battles*($tTPNFH+$tTPNFHP+$tTPNFHP);
        }   else    {
            $bHeight = $battles*($tTPNFH+$tTPNFHP);
        }

        
        
        $svg1 = "<svg width='".$bWidth."' height='".$bHeight."' class='tournament-table'>";
        if (isset($_SESSION["admin"])){
            $svg2 = $this->drawBattleAdmin($bWidth,$bHeight,$grade,1,$bWidth-round($tTPNFWP/2),round($bHeight/2),$tTPNFW,$tTPNFH,$tTPNFWP,$tTPNFHP,$topBattleId,$bt,"",-1);     
        }   else    {
            $svg2 = $this->drawBattle($bWidth,$bHeight,$grade,1,$bWidth-round($tTPNFWP/2),round($bHeight/2),$tTPNFW,$tTPNFH,$tTPNFWP,$tTPNFHP,$topBattleId,$bt);     
        }
        
        $svg3 = "</svg>";
        require_once(ROOT . '/views/league/offSeasonView.php');
        return true;
    } 

    /** Set of team names which contain $str в виде листбокса. AJAX
     * @param string $search_string By POST
     * @return boolean
     */
    public function actionGetTeamList()
    {
        $str = $_POST["search_string"];    
        if (isset($_SESSION["admin"])){
            $array = League::getTeamListNamesLikeString($str);
            echo '<select name="name" id="teamSelect" size = "10">';
            foreach ($array as $value) {
            echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
            }
            echo '</select>';
        }
        return true;
    }
    /** Set winner and update parrent battle. Off-season Cup. AJAX
     * @return boolean
     */
    public function actionSetWinnerUpdateParentBattleAJAX()
    {
        
        if (isset($_SESSION["admin"])){
            $battleId = $_POST["battleId"];    
            $parentId = $_POST["parentId"];  
            $branch = $_POST["branch"];  
            $winner = $_POST["winner"];  
            //1.Текущему бою назначаем победителя
            Battle::defineWinner($battleId, $winner);
            //2.Бою-родителю назначаем сторону противостояния в поле side_a или side_b в зависимости от значения переменной branch
            if ($parentId!=-1){
                Battle::defineSideToParent($parentId, $winner, $branch);
            
            //3.Если родительский бой имеет уже две противоборствующие стороны(в смысле side_a <> 0 and side_b<>0) 
            //и дата боя - максимальная-статическая дата(datetime = '2030-01-01 20:00:00'), 
            //то находим максимальную дату боев, среди боев текущего кубка, 
            //но которая меньше максимальной-статической даты, прибавляем к ней одни сутки 
            //и эту дату устанавливаем для родительского боя
                $btl = Battle::getBattle($parentId);
                //var_dump($btl);
                if(($btl["side_a"]!=0)AND($btl["side_b"]!=0)AND($btl["datetime"]=='2030-01-01 20:00:00')){
                    var_dump($btl);
                    $rowLeague = League::getLastCupOffSeason();
                    $cupId = $rowLeague["id"];
                    echo "<br>";
                    echo $cupId." _ ";
                    $dt =  Battle::getBattleMaxDateOfCup($cupId);

                    $date = new DateTime($dt);
                    //$dts = $date->format('Y-m-d H:i:s');
                    $date      -> modify('+1 day');
                    $dts = $date->format('Y-m-d H:i:s');
                    echo "_".Battle::updateBattleWithDate($parentId,$dts);

                }
            }
            $controllerUpdateStat = New TeamController();
            $controllerUpdateStat->actionRefreshStatisticsOfTeams();
        }
        return true;
    }

        
        

    /** НЕДОДЕЛАНА Показывает последнюю проводившуюся лигу - ЛИГУ WS
    * @Show one team
    */
    public function actionBattles($battlesCount)
    {
        if (isset($_SESSION["admin"])){
            $rowLeague = League::getLastLeagueWS();
            $idLeague = $rowLeague["id"];
            
            
            require_once(ROOT . '/views/league/battles.php');
        }   else    {
            header("Location: /league");
        }
        return true;
    }
        


    /** Editing of selected battle in shedule
    * @Show one team
    */
    public function actionEditBattle($battleId)
    {
        if (isset($_SESSION["admin"])){
            $v = Battle::getBattle($battleId);
            $v["teamNameA"] = Team::getTeamNameByID($v["side_a"]);
            $v["teamNameB"] = Team::getTeamNameByID($v["side_b"]);
            require_once(ROOT . '/views/league/editBattle.php');
        }   else    {
            header("Location: /shedule");
        }
        return true;
    }
        
    /** Editing of selected battle in shedule
    * @Show one team
    */
    public function actionEditBattleAJAX()
    {
        if (isset($_SESSION["admin"])){
            $battleId = $_POST["battleId"];
            $teamOneId = $_POST["teamOneId"];
            $teamTwoId = $_POST["teamTwoId"];
            $teamOneName = Team::getTeamNameByID($teamOneId);    
            $teamTwoName = Team::getTeamNameByID($teamTwoId);    
            $dateTime = $_POST["dateTime"];
            $result = Battle::editBattle($battleId, $teamOneId, $teamTwoId, $dateTime);
            if ($result!=true){
                echo "0";        
            }   else { 
                echo "<H5>Время : $dateTime</H5>";
                echo "<H5>Команда 1 : $teamOneName</H5>";
                echo "<H5>Команда 2 : $teamTwoName</H5>";
                echo "<H5>СОХРАНЕНО </H5>";
            }

        }
        return true;
    }
        
    
    
    
    /** Adds a battle of two teams and datetime to database in table `battles`
     * @param string teamOneId By POST
     * @param string teamTwoId By POST
     * @param string dateTime By POST
     * @return boolean
     */
    public function actionDeclareBattle()
    {
        if (isset($_SESSION["admin"])){
            $teamOneId = $_POST["teamOneId"];    
            $teamTwoId = $_POST["teamTwoId"];
            $teamOneName = Team::getTeamNameByID($teamOneId);    
            $teamTwoName = Team::getTeamNameByID($teamTwoId);    
            $dateTime = $_POST["dateTime"];
            $rowLeague = League::getLastLeagueWS();
            $idLeague = $rowLeague["id"];
            $result = Battle::declareBattle($teamOneId, $teamTwoId, $dateTime, $idLeague);
            if ($result!=true){
                echo "0";        
            }   else { 
                echo "<H5>Время : $dateTime</H5>";
                echo "<H5>Команда 1 : $teamOneName</H5>";
                echo "<H5>Команда 2 : $teamTwoName</H5>";
                echo "<H5>СОХРАНЕНО </H5>";
            }
                
        }
        return true;
    }



    /** Adding a cup(off-season) or league ( 0 - off-season, 1- league) 
    */
    public function actionAddNew($type)
    {
        if (isset($_SESSION["admin"])){
            $cupId = League::createCupAndReturnId($type);
            if($type==0){
                $teamsString = $_POST["teams"];
                League::setTeamSetOfCup($teamsString, $cupId);
                $grade = $_POST["grade"];
                $dt = $_POST["dt"];
                $ddt = date($dt);
                $grade = $grade - 1; // For battles it needs to be devided on 2, cause in one battle two teams
                $battleId = Battle::setBattleCupFirstReturnId($cupId, $grade);

                
                $done = true;
                while ($done) {
                    $row = Battle::getBattleWhithoutChildBattles($cupId);
                    if (isset($row["id"])){
                        $battleId = $row["id"];
                        $grade = $row["grade"];
                        $grade--;
                        $battleIdA = Battle::createChildBattleForBattleReturnId($battleId, $cupId, $grade);
                        $battleIdB = Battle::createChildBattleForBattleReturnId($battleId, $cupId, $grade);
                        
                        Battle::addChildsToBattle($battleId, $battleIdA, $battleIdB);
                        $done = true;
                    }   else    {
                        $done = false;
                    }
                    
                    
                }
                
                $this->actionFillBattlesWithShuffledTeams($dt);
                
                // 0. Нужно занести все команды присланые пользователем в списмок команд для этого кубка. Чтобы в случае рандома можно было бы перемешать эти команды
                // 1. Создаю бой этого кубка c грейдом и cup_id
                // 2. Ищу бой с пустыми полями side_a или side_b
                // 3. Создаю бои для side_a и side_b, переменную "все бои обработаны" ставлю в FALSE
                // 4. Если переменная "все бои обработаны" равна TRUE, то иду дальше, иначе шаг 2.
                // 5. Ищу бой с грейдом таким же как переменная "grade", если нахожу , 
                // то ставлю ему дату и (переменную "даты проставлены" в FALSE и переменную "next_grade"
                // в FALSE), иначе переменную "даты проставлены" в TRUE
                // 6. Если переменная "даты проставлены" равна FALSE, то выполняю шаг 5, иначе шаг 7
                // 7. Уменьшаю переменную "grade" на единицу и выполняю шаг 5
            }
            if($type==1){
                header("Location: /league");    
            }
        }
        return true;
    }

    /** Shuffle teams through AJAX
     * 
     * @return boolean
     */
    public function actionShuffle()    {   
        if (isset($_SESSION["admin"])){
            $dt = $_POST["dt"];
            $this->actionFillBattlesWithShuffledTeams($dt);            
            //echo "all good";
        }
        return true;
    }
    
    /** Filling first wave battles with set of teams for cup off-season
     * 
     * @param string $ddt datetime. every next battle will be after 24 hours
     * @return boolean
     */
    public function actionFillBattlesWithShuffledTeams($dt)    {   
        
        //0 taking last off season cup id
        //1 taking team-list of cup, taking their id-s in array
        //2 shuffle array
        //3 taking battles id which grade=0 and cup_id=our cup_id and set it in battle-array
        //3.5 for-loop on battle-array
        //4 $teamA = array_shift ( team-array ) , $teamB = array_shift (team-array)
        //5 fillBattleWithTeams($battleId,$teamA,$teamB)
        $row = League::getLastCupOffSeason();
        $cupId = $row["id"];
        $arr = League::getTeamListOfCup($cupId);
        $teams = [];
        $count = count($arr);
        for($i=0;$i<$count;$i++){
            $teams[]=$arr[$i]["team_id"];
        }
        //2
        shuffle($teams);
        //3
        $arr = Battle::getBattlesFromCupOffSeasonFirstWave($cupId);
//        var_dump($teams);
//        echo "<br>";
//        var_dump($arr);
        //3.5
        $date = new DateTime($dt);
        $dts = $date->format('Y-m-d H:i:s');
        $battles = [];
        $count = count($arr);
        for($i=0;$i<$count;$i++){
            $battles[]=$arr[$i]["id"];
        }
//        echo "<br>";
//        var_dump($battles);
        $count = count($battles);
        for($i=0;$i<$count;$i++){
            //4
            $teamA = array_shift($teams);
            $teamB = array_shift($teams);
            $battleId = $battles[$i];
            //5
            Battle::defineParticipantsAndDateTime($battleId,$teamA,$teamB,$dts);//Каждый следующий бой на следующий день
            $date      -> modify('+1 day');
            $dts = $date->format('Y-m-d H:i:s');
        }
        return true;
        
    }
    
    
}

