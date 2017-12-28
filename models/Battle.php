<?php

class Battle
{

    /** Get set of battles which not accomplished 
     * @return array set of battles of League represented by $idLeague
     */
    public static function getSheduleBattles($cupId){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = "SELECT id,side_a,side_b,winner,datetime,cup_id FROM `battles` "
                . "WHERE `battles`.`datetime` >  CURRENT_TIMESTAMP AND `battles`.`datetime`< '2030-01-01 10:00:00' AND `cup_id` = ? ORDER BY `battles`.`datetime` ";
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([$cupId]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }

    /** Get set of battles which are accomplished of selected league
     * @param int $id Id of league
     * @return array set of battles of League represented by $idLeague
     */
    public static function getSheduleArchiveBattlesById($id){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT id,side_a,side_b,winner,datetime,cup_id FROM `battles` '
                . 'WHERE `battles`.`datetime` <  CURRENT_TIMESTAMP AND `cup_id` = ? ORDER BY `battles`.`datetime` DESC ';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
    
    /** Get set of battles which are accomplished and has no winner
     * @return array set of battles of League represented by $idLeague
     */
    public static function getBattlesWithoutWinner(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT id,side_a,side_b,winner,datetime FROM `battles` '
                . 'WHERE `battles`.`datetime` <  CURRENT_TIMESTAMP AND `battles`.`winner` = 0 ';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }    
    
    /** Get battle of `battles` which are  
     * @return array set of fields of battle
     */
    
    public static function getBattle($id){
    $db = Db::getConnection();
    $sql = 'SELECT id,side_a,side_b,winner,datetime,cup_id FROM `battles` WHERE `battles`.`id` = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row; 
    }    
    
    /** Defines a Winner in `battles` table
     * 
     * @param int $battleId
     * @param int $teamId
     * @return boolean result of query
     */
    public static function defineWinner($battleId,$teamId) {
        $db = Db::getConnection();
        $sql = "UPDATE `battles` SET `winner` = ?,`looser`= `side_a`+`side_b`-`winner` WHERE `battles`.`id` = ?";
        $res = $db->prepare($sql)->execute([$teamId,$battleId]);
        return $res; 
        
    }
    
    /** Deletes a battle from table `battles` 
     * 
     * @param int $battleId
     * @return boolean result of query
     */
    public static function deleteBattle($battleId) {
        $db = Db::getConnection();
        $sql = "DELETE FROM `battles` WHERE `battles`.`id` = ?";
        $res = $db->prepare($sql)->execute([$battleId]);
        return $res; 
        
    }

    

    /** Создает battle в БД в таблице `battles` методом INSERT ( Только для ЛИГИ WS )
     * @param string $teamOneId id of first team
     * @param string $teamTwoId id of second team
     * @param string $dateTime datetime of battle
     * @param string $idLeague last opened league
     */
    public static function declareBattle($teamOneId,$teamTwoId,$dateTime,$idLeague)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        $sql = "INSERT INTO `battles` ( `side_a`, `side_b`, `datetime`, `cup_id`, `grade`) VALUES (?,?,?,?,-1)";
        //con('$sql:',$sql,"_________");
        return $db->prepare($sql)->execute([$teamOneId,$teamTwoId,$dateTime,$idLeague]);
        
    }

    /** Редактирует battle в БД в таблице `battles` методом UPDATE
     * @param string $teamOneId id of first team
     * @param string $teamTwoId id of second team
     * @param string $dateTime datetime of battle
     * @param string $battleId Id of battle we edit
     */
    public static function editBattle($battleId,$teamOneId,$teamTwoId,$dateTime)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        $sql = "UPDATE `battles` SET `side_a` = ?, `side_b` = ?, `datetime` = ? WHERE `battles`.`id` = ?";
        return $db->prepare($sql)->execute([$teamOneId,$teamTwoId,$dateTime,$battleId]);
    }




    /** Get all battles with winners
     * @return array set of battles which have winners
     * 
     */
    public static function getBattlesWithWinners(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT id,side_a,side_b,winner,datetime FROM `battles` '
                . 'WHERE `battles`.`winner` <> 0';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }    
    


    /** Get set of battles of League represented by $idLeague
     * @return array set of battles of League represented by $idLeague
     * @param int $idLeague Id of league
     */
    public static function getBattlesFromLeague($idLeague){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT id,side_a,side_b,winner,datetime FROM `battles` '
                . 'WHERE `battles`.`cup_id` = ? AND `battles`.`datetime` < CURRENT_TIMESTAMP AND `battles`.`winner` <> 0  ';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([$idLeague]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }    


    /** Get battles of first wave for cup
     * @return array set of battles 
     * @param int $cupId Id of cup
     */
    public static function getBattlesFromCupOffSeasonFirstWave($cupId){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT id FROM `battles` '
                . 'WHERE `battles`.`cup_id` = ? AND `battles`.`grade` = 0';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([$cupId]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }    



    /** Делаем первый бой для кубка межсезонья. т.е. вершина кубка 
     * #offSeasonCupCreating 
     */
    public static function setBattleCupFirstReturnId($cupId,$grade)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        $sql = "INSERT INTO `battles` (`grade`,`cup_id`,`datetime`,`battle_c`) VALUES (?, ?, '2030-01-01 20:00:00', '-1')";
        $db->prepare($sql)->execute([$grade,$cupId]);
        return $db->lastInsertId();
    }


    /** Making child-battle. Setting parrent battle id in it
     * @param integer $battleId - id battle of parrent
     * @param integer $cupId - id of cup
     * @param integer $grade - grade of battle which is lower on 1 then parrent has
     * #offSeasonCupCreating 
     */
    public static function createChildBattleForBattleReturnId($battleId,$cupId,$grade)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        $sql = "INSERT INTO `battles` (`grade`,`cup_id`,`datetime`,`battle_c`) VALUES (?, ?, '2030-01-01 20:00:00', ?)";
        $db->prepare($sql)->execute([$grade,$cupId,$battleId]);
        return $db->lastInsertId();
    }

    /** Find battle whithout child battles 
     * 
     * @param int $cupId Id of cup off-season
     * @return array battle
     */
    public static function getBattleWhithoutChildBattles($cupId){
        $db = Db::getConnection();
        $sql = "SELECT * FROM `battles` WHERE `grade` > 0 AND `cup_id` =  ? AND `battle_a` = 0 AND `battle_b` = 0 LIMIT 0,1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$cupId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row; 
    }

    /** Adding ids of child-battles in battle_a and battle_b field of parrent-battle
     * 
     * @param type $battleId parrent id
     * @param type $battleIdA child id A
     * @param type $battleIdB child id B
     * @return type
     */
    public static function addChildsToBattle($battleId,$battleIdA,$battleIdB)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        $sql = "UPDATE `battles` SET `battle_a` = ?, `battle_b` = ? WHERE `battles`.`id` = ?";
        return $db->prepare($sql)->execute([$battleIdA,$battleIdB,$battleId]);
    }
    
    /** Finding grade
     * @return int grade
     */
    
    public static function getGradeOfCup($cupId){
    $db = Db::getConnection();
    $sql = 'SELECT MAX(`grade`)as maxGrade FROM `battles` WHERE `battles`.`cup_id` = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$cupId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["maxGrade"]; 
    }  
    
    /** Finding grade
     * @return int grade
     */
    
    public static function getTopBattleIdOfCup($cupId){
    $db = Db::getConnection();
    $sql = 'SELECT MAX(`grade`)as maxGrade,id FROM `battles` WHERE `battles`.`cup_id` = ?';
    $stmt = $db->prepare($sql);
    $stmt->execute([$cupId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["id"]; 
    }  
    
     
    /** Inserting ids of teams in battle_a and battle_b field ( for Off-season cup )
     * 
     * @param type $battleId battle id
     * @param type $teamA team A
     * @param type $teamB team B
     * @return type
     */
    public static function fillBattleWithTeams($battleId,$teamA,$teamB)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        $sql = "UPDATE `battles` SET `side_a` = ?, `side_b` = ? WHERE `battles`.`id` = ?";
        return $db->prepare($sql)->execute([$teamA,$teamB,$battleId]);
    }
    
    /** Defines a participants to a battle
     * 
     * @param int $battleId
     * @param int $teamA
     * @param int $teamB
     * @return boolean result of query
     */
    public static function defineParticipantsAndDateTime($battleId,$teamA,$teamB,$ddt) {
        $db = Db::getConnection();
        $sql = "UPDATE `battles` SET `side_a` = ?,`side_b` = ?,`datetime` = ? WHERE `battles`.`id` = ?";
        $res = $db->prepare($sql)->execute([$teamA,$teamB,$ddt,$battleId]);
        return $res; 
        
    }
    

    /** Get set of battles of $cupId-cup for tournament table
     * @return array set of battles 
     */
    public static function getBattlesOfCupForTournamentTable($cupId){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT id,side_a,side_b,battle_a,battle_b,winner,datetime FROM `battles` WHERE cup_id = ?';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([$cupId]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
    

    /** Defines a team as side in match in `battles` table 
     * 
     * @param int $battleId id of battle
     * @param int $teamId   team id 
     * @param int $branch   one side or another. if branch='' then do nothing
     * @return boolean result of query
     */
    public static function defineSideToParent($battleId,$teamId,$branch) {
        if ($branch===''){  return true;}
        $db = Db::getConnection();
        if($branch==='a'){
            $sql = "UPDATE `battles` SET `side_a` = ? WHERE `battles`.`id` = ?";
        }
        if($branch==='b'){
            $sql = "UPDATE `battles` SET `side_b` = ? WHERE `battles`.`id` = ?";
        }
        $res = $db->prepare($sql)->execute([$teamId,$battleId]);
        return $res; 
        
    }
     
    
    


        
    /** Get max date of Off-season cup but lower then 2030-01-01 20:00:00 
     * @param $cupId id of cup
     * @return array set of fields of battle
     */
    
    public static function getBattleMaxDateOfCup($cupId){
    $db = Db::getConnection();
        $sql = "SELECT MAX(`datetime`) as maxdatetime FROM `battles` "
                . "WHERE `battles`.`cup_id` = ? AND `battles`.`datetime` < '2030-01-01 20:00:00'";
    $stmt = $db->prepare($sql);
    $stmt->execute([$cupId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["maxdatetime"]; 
    }  


    /** update Battle With Date at `battles` table
     * 
     * @param int $battleId
     * @param string $dateStr date and time of battle
     * @return boolean result of query
     */
    public static function updateBattleWithDate($battleId,$dateStr) {
        $db = Db::getConnection();
        $sql = "UPDATE `battles` SET `datetime` = ? WHERE `battles`.`id` = ?";
        $res = $db->prepare($sql)->execute([$dateStr,$battleId]);
        return $res; 
        
    }


    /** Get winners and count of winners
     * @return array set of battles 
     */
    public static function getWinnersAndTheirCount(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT winner, count(winner) as count_winner FROM `battles` WHERE `battles`.`winner` <> 0 GROUP by winner';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
    


    /** Get loosers and count of loosers
     * @return array set of battles 
     */
    public static function getLoosersAndTheirCount(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT looser, count(looser) as count_looser FROM `battles` WHERE `battles`.`looser` <> 0 GROUP by looser';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
    
    
    /** Get cup off-season team winners list
     * @return array set of battles 
     */
    public static function getCupOffSeasonWinners(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT  `winner`,count(`winner`)as wins FROM `battles` WHERE `battle_c`=-1 AND `winner` <> 0 GROUP by `winner`';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
    



    /** Get max win count of winners of cup of league WS
     * @param int $cupId Id of league which is not completed
     * @return array wins, winner, cup
     */
    public static function getMaxWinWinnersOfLeagueWS($cupId){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
        $sql = 'SELECT `new_name2`.`winner`, count(`new_name2`.`winner`)as wins FROM
            (SELECT max(new_name.cnt) as max_win, winner, cup_id FROM 
            (SELECT winner, count(winner) as cnt, cup_id 
            FROM `battles` 
            WHERE `cup_id` <> ? AND `grade`=-1  
            GROUP BY winner, cup_id ) as new_name 
            GROUP BY cup_id) as new_name2
            GROUP BY winner';
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([$cupId]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
    
}    