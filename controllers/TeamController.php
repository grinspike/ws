<?php

class TeamController {
    /**
    * Show list of teams
    */
    public function actionIndex()
    {
        $teamList = array();
        $teamList = Team::getTeamList();
        require_once(ROOT . '/views/team/index.php');
        return true;
    }

    /**
    * Show list of teams
    */
    public function actionIndexNew()
    {
    if (isset($_SESSION["admin"])){
        $teamList = array();
        $teamList = Team::getNewTeamList();
        require_once(ROOT . '/views/team/indexNew.php');
    }
            return true;
    }

    /**
    * Show list of hided teams
    */
	public function actionIndexDeleted()
	{
        if (isset($_SESSION["admin"])){
            $teamList = array();
            $teamList = Team::getDeletedTeamList();
            require_once(ROOT . '/views/team/indexDeleted.php');
        }
		return true;
	}
    
  /**
   * @Show one team
   */
	public function actionView($id)
	{
		if ($id) {
			$teamItem = Team::getTeamItemByID($id);
            require_once(ROOT . '/views/team/view.php');

/*			echo 'actionView'; */
		}

		return true;

	}

  
   /**
   * @create a team
   */
	public function actionCreate()
	{
        $teamName = "";
        $email = "";
        $password = "";
        $code = "";
        $result = false;
        $errors = false;// Флаг ошибок
       
        
        if(isset($_POST["submit"])){
            $email=$_POST["email"];
            $password=$_POST["password"];
            $teamName=$_POST["teamname"];
            $code=$_POST["code"];
            
            if (!(Team::checkTeamNameLength($teamName))){
                $errors[] = "Имя должно быть более 2-х символов";
            }
            if (!Team::checkEmail($email)){
                $errors[] = "Неверный e-mail";
            }
            if (!Team::checkPassword($password)){
                $errors[] = "Пароль должен быть более 6-ти символов";
            }
            if (Team::checkEmailExists($email)){
                $errors[] = "Такой e-mail уже зарегистрирован!";
            }
            
            if (!Team::checkCaptcha($code)){
                $errors[] = "Код указан неверно";
            }
            
            if (empty($_FILES['fupload']['name'])){            
                //если переменной не существует (пользователь не отправил изображение),то присваиваем ему заранее приготовленную картинку пустого логотипа
                $logo = "template/logo/empty_logo.png"; 
            } else {
                $logo = Team::loadLogo();
                if ($logo==false){
                    $errors[] = "Логотип должен быть в формате <strong>JPG,GIF или PNG</strong>";
                }
            }
                

            
            
            // Хэшируем пароль
            $options = [
            'cost' => PASS_COST,
            ];
            $password_h = password_hash($password, PASSWORD_BCRYPT, $options);
            
            if ($errors == false) {
                // Если ошибок нет
                // Создаем команду
                $tokenEmail = Team::generateTokenEmail(60);
                $result = Team::createTeam($email, $password_h, $teamName, $logo, $tokenEmail);
            }            
        }
        
        require_once(ROOT . '/views/team/create.php');
		return true;

	}
    
    
    
    /** Login team
     * 
     * @return boolean
     */
	public function actionLogin()
	{
        $password = "";
        $email = "";
        $errors = false;
        
        if (isset($_POST["email"])){
            $password = $_POST["password"];
            $email = $_POST["email"];
            
            $row = Team::getPasswordHashRoleIdByEmail($email);
            if ($row==0){
                $errors = "Неверное имя пользователя либо пароль";
            } else {
                if (password_verify($password, $row['password'])) {
                    //Всё ок, пользователь прошел аутентификацию
                    $_SESSION["teamId"] = $row["id"];// ГЛавный признак того, что пользователь залогинен
                    if ($row["role"]==="admin"){
                        $_SESSION["admin"] = $row["id"];// Признак того, что пользователь админ
                    }
                    header("Location: /team/{$row["id"]}");
                } else{
                    $errors = "Неверное имя пользователя либо пароль";
                }
                    
            }
            
        }
        
        require_once(ROOT . '/views/team/login.php');
		return true;

	}
    
    /** Выход и3 аккаунта
     * 
     * @return boolean
     */
    public function actionExit()
	{
        
        header("Location: /team/{$_SESSION["teamId"]}");
//        unset($_SESSION["teamId"]);
//        unset($_SESSION["admin"]);
        session_destroy(); 
        return true;

	}
    
    
    
    /** Редактирование залогиненной команды. Вызывает другой actionEdit($id) в параметр подставляет ID залогиненной команды. Это когда идут по пути team\edit, а не по team/edit/([0-9]+)
    * 
    */
	public function actionEditOwnTeam()
	{   
        $id = $_SESSION["teamId"];
        $this->actionEdit($id);
		return true;
	}


   /** Редактированной команды 
   * @param int $id Номер команды
   */
	public function actionEdit($id)
	{
        if(!isset($_SESSION["teamId"])){//Если юзер незалогинен, то выкидываем его на страницу команды, которую он хотел править
            header("Location: /team/".$id);
            return true;
        }
        
        if(isset($_POST["submit"])){
            $errors = false;// Флаг ошибок
            $t_name = $_POST["name"];
            $t_kapitan = $_POST["kapitan"];
            $t_osnova1 = $_POST["osnova1"];
            $t_osnova2 = $_POST["osnova2"];
            $t_osnova3 = $_POST["osnova3"];
            $t_osnova4 = $_POST["osnova4"];
            $t_standin1 = $_POST["standin1"];
            $t_standin2 = $_POST["standin2"];
            $t_standin3 = $_POST["standin3"];
            $t_standin4 = $_POST["standin4"];
            $t_standin5 = $_POST["standin5"];
            $t_trainer = $_POST["trainer"];
            $t_logo = $_SESSION["logo"];
            if (empty($_FILES['fupload']['name'])){            
                //если переменной не существует (пользователь не отправил изображение),то присваиваем ему заранее приготовленную картинку с надписью "нет аватара"
                $logo = $_SESSION["logo"];
            } else {
                $logo = Team::loadLogo();
                if ($logo==false){
                    $errors[] = "Логотип должен быть в формате <strong>JPG,GIF или PNG</strong>";
                }
            }
            
            if ($errors == false) {
                // Если ошибок нет, то правим команду
                Team::editTeam($logo, $t_kapitan,$t_osnova1,$t_osnova2,$t_osnova3,
                    $t_osnova4,$t_standin1,$t_standin2,$t_standin3,$t_standin4,$t_standin5,$t_trainer,$_SESSION["teamId"]);
    
                header("Location: /team/".$id);//Показываем ту команду, которую редактировали
                return true;
            } else { // Показываем сообщение о неправильном формате логотипа
                require_once(ROOT . '/views/team/edit.php');
        		return true;
            }
        }   else    {
            if (!isset($_SESSION["admin"])) {
                $id = $_SESSION["teamId"];
            }
            $row = Team::showOneTeam($id);

            $t_name = $row["name"];
            $t_kapitan = $row["kapitan"];
            $t_osnova1 = $row["osnova1"];
            $t_osnova2 = $row["osnova2"];
            $t_osnova3 = $row["osnova3"];
            $t_osnova4 = $row["osnova4"];
            $t_standin1 = $row["standin1"];
            $t_standin2 = $row["standin2"];
            $t_standin3 = $row["standin3"];
            $t_standin4 = $row["standin4"];
            $t_standin5 = $row["standin5"];
            $t_trainer = $row["trainer"];
            $t_logo = $row["logo"];
            $_SESSION["logo"] = $row["logo"];
            require_once(ROOT . '/views/team/edit.php');
            return true;
        }
	}
    
    

   /** Редактированной команды администратором
   * @param int $id Номер команды
   */
	public function actionEditAdmin($id)
	{
        if(!isset($_SESSION["teamId"])){//Если юзер незалогинен, то выкидываем его на страницу команды, которую он хотел править
            header("Location: /team/".$id);
            return true;
        }
        if(!isset($_SESSION["admin"])){//Если юзер не админ, то выкидываем его на страницу команды, которую он хотел править
            header("Location: /team/".$id);
            return true;
        }
        
        if(isset($_POST["submit"])){
            $errors = false;// Флаг ошибок
            $t_name = $_POST["name"];
            $t_email = $_POST["email"];
            $t_password = $_POST["password"];
            if ((!Team::checkPassword($t_password))and($t_password!="")){
                $errors[] = "Пароль должен быть более 6-ти символов";
            }

            $t_kapitan = $_POST["kapitan"];
            $t_osnova1 = $_POST["osnova1"];
            $t_osnova2 = $_POST["osnova2"];
            $t_osnova3 = $_POST["osnova3"];
            $t_osnova4 = $_POST["osnova4"];
            $t_standin1 = $_POST["standin1"];
            $t_standin2 = $_POST["standin2"];
            $t_standin3 = $_POST["standin3"];
            $t_standin4 = $_POST["standin4"];
            $t_standin5 = $_POST["standin5"];
            $t_trainer = $_POST["trainer"];
            $t_logo = $_SESSION["logo"];
            if (empty($_FILES['fupload']['name'])){            
                //если переменной не существует (пользователь не отправил изображение),то присваиваем ему заранее приготовленную картинку пустого логотипа
                $logo = $_SESSION["logo"];
            } else {
                $logo = Team::loadLogo();
                if ($logo==false){
                    $errors[] = "Логотип должен быть в формате <strong>JPG,GIF или PNG</strong>";
                }
            }
            
            if ($errors == false) {
                // Если ошибок нет, то правим команду
                $res = Team::editTeamAdmin($t_name,$t_email,$t_password,$logo,$t_kapitan,$t_osnova1,$t_osnova2,$t_osnova3,
                    $t_osnova4,$t_standin1,$t_standin2,$t_standin3,$t_standin4,$t_standin5,$t_trainer,$id);
                
                header("Location: /team/".$id);//Показываем ту команду, которую редактировали
                return true;
            } else { // Показываем сообщения об ошибках
                require_once(ROOT . '/views/team/editAdmin.php');
        		return true;
            }
        }   else    {
            $row = Team::showOneTeam($id);

            $t_name = $row["name"];
            $t_email = $row["email"];
            //---
            $t_kapitan = $row["kapitan"];
            $t_osnova1 = $row["osnova1"];
            $t_osnova2 = $row["osnova2"];
            $t_osnova3 = $row["osnova3"];
            $t_osnova4 = $row["osnova4"];
            $t_standin1 = $row["standin1"];
            $t_standin2 = $row["standin2"];
            $t_standin3 = $row["standin3"];
            $t_standin4 = $row["standin4"];
            $t_standin5 = $row["standin5"];
            $t_trainer = $row["trainer"];
            $t_logo = $row["logo"];
            $_SESSION["logo"] = $row["logo"];
            require_once(ROOT . '/views/team/editAdmin.php');
            return true;
        }
	}
    
    

    
    


    
    /** Утверждение команды
     * 
     * @return boolean
     */
    public function actionApprove()
	{
        $id = $_POST["teamId"];    
        if (isset($_SESSION["admin"])){
            if (Team::approveTeam($id)==true){//проверка на ошибки отсутствует
            }
        }
        return true;

	}
    
    /** Отвергание команды
     * 
     * @return boolean
     */
    public function actionDiscard()
	{
        $id = $_POST["teamId"];    
        if (isset($_SESSION["admin"])){
            if (Team::discardTeam($id)==true){//проверка на ошибки отсутствует
            }
        }
        return true;

	}
    

    /** Удаление команды команды
     * 
     * @return boolean
     */
    public function actionDelete()
	{
        $id = $_POST["teamId"];    
        if (isset($_SESSION["admin"])){
            if (Team::deleteTeam($id)==true){//проверка на ошибки отсутствует
            }
        }
        return true;

	}
    


    /** Удаление команды команды
     * 
     * @return boolean
     */
    public function actionRestore()
	{
        $id = $_POST["teamId"];    
        if (isset($_SESSION["admin"])){
            if (Team::restoreTeam($id)==true){//проверка на ошибки отсутствует
            }
        }
        return true;

	}
    
    /** Удаление команды команды
     * 
     * @return boolean
     */
    public function actionRoles()
	{
        if (isset($_SESSION["admin"])){
            $teamList = array();
            $teamList = Team::getTeamListAll();
            require_once(ROOT . '/views/team/roles.php');
            //if (Team::restoreTeam($id)==true){//проверка на ошибки отсутствует
            //}
        }
        return true;

	}
    
    
    /** Установка роли для команды
     * 
     * @return boolean
     */
    public function actionSetRole()
	{
        if (isset($_SESSION["admin"])){
            $role = $_POST["role"];
            $id = $_POST["teamId"];
            
            if ($role=="kapitan"){
                $res = Team::setRole($id, "");
            }
            
            if ($role=="moder"){
                $res = Team::setRole($id, "moder");
            }
            
            if ($role=="admin"){
                $res = Team::setRole($id, "admin");
            }
            if ($res) {echo "fine";}
        }
        return true;

	}
    


    /** Changes count of cups of league 
     * 
     * @return boolean
     */
    public function actionTeamCupLeagueChange()
	{
        $id = $_POST["teamId"];    
        $inc = $_POST["inc"];    
        if (isset($_SESSION["admin"])){
            if (Team::cupLeagueCountChange($id,$inc)){//проверка на ошибки отсутствует
                //echo Team::getCupLeagueCount($id);
            }
        }
        return true;

	}
    
    /** Changes count of cups of off-season 
     * 
     * @return boolean
     */
    public function actionTeamCupOffSeasonChange()
	{
        $id = $_POST["teamId"];    
        $inc = $_POST["inc"];    
        if (isset($_SESSION["admin"])){
            if (Team::cupOffSeasonCountChange($id,$inc)){//проверка на ошибки отсутствует
                //echo Team::getCupOffSeasonCount($id);
            }
        }
        return true;

	}



    
    /** Changes count of wins of team
     * 
     * @return boolean
     */
    public function actionWinsTeamCountChange()
	{
        $id = $_POST["teamId"];    
        $inc = $_POST["inc"];    
        if (isset($_SESSION["admin"])){
            if (Team::winsCountChange($id,$inc)){//проверка на ошибки отсутствует
            }
        }
        return true;

	}


    
    /** Changes count of cups of off-season 
     * 
     * @return boolean
     */
    public function actionDefeatsTeamCountChange()
	{
        $id = $_POST["teamId"];    
        $inc = $_POST["inc"];    
        if (isset($_SESSION["admin"])){
            if (Team::defeatsCountChange($id,$inc)){//проверка на ошибки отсутствует
            }
        }
        return true;

	}


    /** Sends to js list of teams which are approved and visible. Creating new cup off-season
    * 
    */
    public function actionGetAllTeamApproved()
    {
        $teamList = array();
        $teamList = Team::getTeamList();
        foreach ($teamList as $v) {
            echo "<1111>".$v["id"]."<1112>".$v["name"];
        }
        return true;
    }

    /** Refreshes team statics
    * 
    */
    public function actionRefreshStatisticsOfTeams()
    {
        if (isset($_SESSION["admin"])){
            // Обновить статистику побед и поражений в командах
            //1 Получаем список утверждённых команд
            $teamList = Team::getTeamList();
           
            //echo "<pre>.<br>";
            //2 Получаем массив, где указаны айди команды и количество побед (winner, count(winner) as count_winner)
            $winners = Battle::getWinnersAndTheirCount();
            //3 Изменяем массив, чтобы к нему можно было бы обращаться по адйди команды
            foreach ($winners as $key=> $v) {
                $id = $v["winner"];
                $winners[$id] = $winners[$key];
                unset($winners[$key]);
            }
            //4 Получаем массив, где указаны айди команды и количество поражений (looser, count(looser) as count_looser)
            $loosers = Battle::getLoosersAndTheirCount();
            //5 Меняем массив, чтобы к можно было бы обращаться по адйди команды
            foreach ($loosers as $key=> $v) {
                $id = $v["looser"];
                $loosers[$id] = $loosers[$key];
                unset($loosers[$key]);
            }
            //6 Переходим по списку команд и для каждой команды достаем количество побед и количество поражений
            $iCount = count($teamList);
            for ($i = 0; $i < $iCount; $i++) {
                $id = $teamList[$i]["id"];
                If(isset($winners[$id])){
                    $wCount=$winners[$id]["count_winner"];
                }   else    {
                    $wCount=0;
                }
                
                If(isset($loosers[$id])){
                    $lCount=$loosers[$id]["count_looser"];
                }   else    {
                    $lCount=0;
                }
                //7 Обновляем данные в таблице `teams` и заносим количество побед и поражений
                Team::setStaticWinsAndDefeats($id, $wCount, $lCount);
            }
            //==================================================================
            // Обновить статистику кубков межсезонья и лиги WS
            // Сначала кубок межсезонья
            //1 Ищем все бои, где battle_c=-1(это последний бой кубка межсезонья) 
            //      и группируем по победителям и выбираем количество побед 
            //      SELECT  `winner`,count(`winner`)as wins FROM `battles` 
            //      WHERE `battle_c`=-1 AND `winner` <> 0 GROUP by `winner`
            
            $teamList = Battle::getCupOffSeasonWinners();
            //2 В цикле переходим по массиву комманд, что заработали кубки и каждой команде проставляем кол-во кубков
            foreach ($teamList as $v) {
                Team::setStaticCupOffseasonWinsCount($v["winner"], $v["wins"]);
            }
            
            // Теперь Лига WS
            // Общий смысл: чтобы определить победителя лиги, мы должны найти команду, которая больше всего выиграла матчей. Если в одной лиге получаются две команды, которые набрали одинаковое количество побед, то они должны сразиться друг с другом. 
            // Ньюанс: мы не можем брать во внимание лигу, что еще не завершена, т.е. если в лиге есть бои, которые предстоят в будущем, то эту лигу не берем.
            // 1. Берем последнюю лигу, к примеру это будет 54.
            // 2. Если есть бои, в этой лиге, которые больше текущего времени, 
            // то эту лигу исключаем из запроса
            // (SELECT * FROM `battles` WHERE `grade`= -1 AND `cup_id` <> 54), 
            // иначе - берем все лиги(SELECT * FROM `battles` WHERE `grade`= -1).
            //
            //
            $v = League::getLastLeagueWS();
            $cupId = $v["id"];
            $battles = Battle::getSheduleBattles($cupId);
            $c = count($battles); //Если есть бои, которые не завершились, то с <> 0
            if ($c===0){
                $w = Battle::getMaxWinWinnersOfLeagueWS(0);
            } else {
                $w = Battle::getMaxWinWinnersOfLeagueWS($cupId);// Передаем id лиги, которую не нужно учитывать, поскольку она еще не завершена
            }
            
            foreach ($w as $v) {
                Team::setStaticLeagueWSWinsCount($v["winner"],$v["wins"]);
            }
             
//            echo "<pre>";
//            var_dump($w);
//            return true;
            
            
        }//if is admin 
        return true;
    }


    
    
    
}

