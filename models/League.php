<?php

class League
{
    
    /** Gets last league or cup off-season
     * @return array Last league record
     */
    public static function getLastLeagueOrCup()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT * FROM `cups` ORDER BY datetime DESC LIMIT 0,1');
        /*$result->setFetchMode(PDO::FETCH_NUM);*/
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $cupItem = $result->fetch();
        return $cupItem;
    }
    
    /** Gets last league WS
     * @return array Last league record
     */
    public static function getLastLeagueWS()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT * FROM `cups` WHERE `type`= 1 ORDER BY datetime DESC LIMIT 0,1');
        /*$result->setFetchMode(PDO::FETCH_NUM);*/
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $cupItem = $result->fetch();
        return $cupItem;
    }
    
    /** Gets last off-season cup
     * @return array Last league record
     */
    public static function getLastCupOffSeason()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT * FROM `cups` WHERE `type`= 0 ORDER BY datetime DESC LIMIT 0,1');
        /*$result->setFetchMode(PDO::FETCH_NUM);*/
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $cupItem = $result->fetch();
        return $cupItem;
    }
    
    /** Gets league by id
     * @return array league record
     * @param int $id
     */
    public static function getLeague($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `cups` where `id`=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row; 
    }
    
    /** Gets league cup type by id
     * @return integer type of cup
     * @param int $id
     */
    public static function getLeagueCupType($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT `type` FROM `cups` where `id`=?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $cup = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cup["type"]; 
    }
    
 

  
    /** Founds a teams which contain in name section $search_string example
     * 
     * @param string $search_string String looking in name of teams
     * @return array Set of teams which contain in name section $search_string example
     */
    public static function getTeamListNamesLikeString($search_string)
    {
        $str = "%$search_string%";
        $db = Db::getConnection();
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
        $sql = 'SELECT id,name FROM `teams` WHERE `teams`.`name` LIKE ? AND `teams`.`admin_approved` = 1 AND `teams`.`visible` = 1  ';
        $stmt = $db->prepare($sql);
        $stmt->execute([$str]);
        $stack = Array();
        while($row = $stmt->fetch()){
          array_push($stack, $row);
        }
        return $stack; 
    }
    

    /** Создает кубок в БД в таблице `cups` методом INSERT
     * @param string $type тип кубка(кубок межсезонья либо ЛигаWS)
     * @return int Id of created cup
     */
    public static function createCupAndReturnId($type)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        $sql = "INSERT INTO  `cups` (`type`) VALUES (?)";
        $db->prepare($sql)->execute([ $type ]);
        return $db->lastInsertId();
    }

    
    
    

    /** Для данного кубка вносим набор команд, которые будут в нём учавствовать. Набор команд нужен, чтобы рандомно выбрать поединки команд, если нужно
     * @param string $str  строка-набор команд которые будут принимать участие в этом кубке
     * @param int $cupId  кубок
     * @return boolean true
     */
    public static function setTeamSetOfCup($teamsString,$cupId)
    {
        $teams = explode("<1113>",$teamsString); // Пример приходящих данных (специально удобно скомпонованы уже):  30<1113>45<1113>53<1113>29
        // Соединение с БД        
        $db = Db::getConnection();
        foreach ($teams as $v) {
            $sql = "INSERT INTO  `cups_teams` (`team_id`,`cup_id`) VALUES (?,?)";
            $db->prepare($sql)->execute([ $v,$cupId ]);
        }
        return true;
    }


 
    /** Returns a teams which participate in Off-season cup 
     * 
     * @param int $cupId identifier of cup
     * @return array Set of teams which contain in name section $search_string example
     */
    public static function getTeamListOfCup($cupId)
    {
        $db = Db::getConnection();
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
        $sql = 'SELECT `team_id` FROM `cups_teams` WHERE `cups_teams`.`cup_id` = ?  ';
        $stmt = $db->prepare($sql);
        $stmt->execute([$cupId]);
        $stack = Array();
        while($row = $stmt->fetch()){
          array_push($stack, $row);
        }
        return $stack; 
    }


//
    
}    