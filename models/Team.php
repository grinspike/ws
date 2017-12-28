<?php


class Team
{

    /**
     * Проверяет, чтобы название команды было больше 2 символов
     * @param string $teamName <p>Название команды</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    
    public static function checkTeamNameLength($teamName)
    {
        if (strlen($teamName)>2){
            return true;
        }
        return false;
    }
    /**
     * Проверяет, чтобы длина пароля была больше 2 символов
     * @param string $password <p>пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    
    public static function checkPassword($password)
    {
        if (strlen($password)>6){
            return true;
        }
        return false;
    }
    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

  
  /** Получить запись из таблицы `teams` по ID 
    * @param int $id - номер команды
    * @return array 
    */
  public static function getTeamItemByID($id){
    $db = Db::getConnection();
    $sql = "SELECT * FROM `teams` WHERE `id`= ? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row; 
  }

    /** Получить массив всех команд для отображения списком
     * @return array
     */
    public static function getTeamListAll(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
    $sql = "SELECT id,name,email,role FROM `teams`";
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
      //echo "<tr><td teamid='".$row['id']."'>".$row['name']."</td></tr>";
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }

    /** Получить массив всех команд разрешённые администратором для отображения списком
     * @return array
     */
    public static function getTeamList(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
    $sql = "SELECT id,name FROM `teams` WHERE `admin_approved` = 1 and `visible` = 1 ";
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
      //echo "<tr><td teamid='".$row['id']."'>".$row['name']."</td></tr>";
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
    
    /** Получить массив всех команд еще не разрешённые администратором для отображения списком
     * @return array
     */
    public static function getNewTeamList(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */    
    /* создаем подготавливаемый запрос */
    $sql = "SELECT id,name FROM `teams` WHERE `admin_approved` = 0 and `visible` = 1 ";
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
      //echo "<tr><td teamid='".$row['id']."'>".$row['name']."</td></tr>";
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
  
 
    /** Получить массив всех команд удалённые администратором 
     * @return array
     */
    public static function getDeletedTeamList(){

    $db = Db::getConnection();
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);//Если TRUE, то большой расход памяти. Весь результат загоняется сразу в память, а не по одному. 
    /*So, keep in mind that if you are selecting a really huge amount of data, always set PDO::MYSQL_ATTR_USE_BUFFERED_QUERY to FALSE */
    /* создаем подготавливаемый запрос */
    $sql = "SELECT id,name FROM `teams` WHERE `visible` = 0";
    //con('$sql:',"_____________________",$sql);
    //$mem = memory_get_usage();
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    $stack = Array();
    while($row = $stmt->fetch()){
      array_push($stack, $row);
      //echo "<tr><td teamid='".$row['id']."'>".$row['name']."</td></tr>";
    }
    //echo "Memory used: ".round((memory_get_usage() - $mem) / 1024 / 1024, 2)."M\n";
    return $stack; 
    }
  
     
    /**
    * Проверяет не занят ли email другим пользователем
    * @param type $email <p>E-mail</p>
    * @return boolean <p>Результат выполнения метода</p>
    */
    public static function checkEmailExists($email)
    {
        // Соединение с БД        
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT 1 FROM `teams` WHERE `email` = ?';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->execute([$email]);

        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Проверяет captcha code
     * @param string $code <p>captcha code</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkCaptcha($code)
    {
        if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $code){
            return true;
        }else{
            return false;
        }        
    }

  
    /**
     * Генерирует токен, чтобы послать его по e-mail. Для подтверждения e-mail.
     * @param integer $length
     * @return string Токен
     */

    public static function generateTokenEmail($length)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
          $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    /** Создает команду в БД в таблице `teams` методом INSERT
     * @param string $email e-mail
     * @param string $password пароль
     * @param string $teamName имя команды
     * @param string $logo логотип
     * @param string $emailToken Токен для подтверждения e-mail
     */
    public static function createTeam($email,$password,$teamName,$logo,$tokenEmail)
    {
        // Соединение с БД        
        $db = Db::getConnection();
        $sql = "INSERT INTO `teams` ( `email`, `password`, `name`,`logo`, `email_token`) VALUES (?,?,?,?,?)";
        //con('$sql:',$sql,"_________");
        return $db->prepare($sql)->execute([ $email, $password, $teamName, $logo, $tokenEmail]);
        
    }
    
    /** Загрузка изображения в папку template/logo, обрезка до квадратного, ресайз до 256х256
     * @return string Путь к изображению относительно корневого каталога
     */
    public static function loadLogo()
    {
        $path_to_logo_directory = 'template/logo/';//папка, куда будет загружаться начальная картинка и ее сжатая копия

        if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name'])){//проверка формата исходного изображения
            $filename = $_FILES['fupload']['name'];
            $source = $_FILES['fupload']['tmp_name'];	
            $target = $path_to_logo_directory . $filename;
            move_uploaded_file($source, $target);//загрузка оригинала в папку $path_to_logo_directory

            if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
            $im = imagecreatefromgif($path_to_logo_directory.$filename) ; //если оригинал был в формате gif, то создаем изображение в этом же формате. Необходимо для последующего сжатия
            }
            if(preg_match('/[.](PNG)|(png)$/', $filename)) {
            $im = imagecreatefrompng($path_to_logo_directory.$filename) ;//если оригинал был в формате png, то создаем изображение в этом же формате. Необходимо для последующего сжатия
            }

            if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
                $im = imagecreatefromjpeg($path_to_logo_directory.$filename); //если оригинал был в формате jpg, то создаем изображение в этом же формате. Необходимо для последующего сжатия
            }

            // Создание квадрата 256x256
            // dest - результирующее изображение 
            // w - ширина изображения 
            // ratio - коэффициент пропорциональности 

            $w = 256;  // квадратная 256x256
            // создаём исходное изображение на основе 
            // исходного файла и определяем его размеры 
            $w_src = imagesx($im); //вычисляем ширину
            $h_src = imagesy($im); //вычисляем высоту изображения

            // создаём пустую квадратную картинку 
            // важно именно truecolor!, иначе будем иметь 8-битный результат 
            $dest = imagecreatetruecolor($w,$w); 

            // вырезаем квадратную серединку по x, если фото горизонтальное 
            if ($w_src>$h_src) 
            imagecopyresampled($dest, $im, 0, 0,
                    round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                    0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 

            // вырезаем квадратную верхушку по y, 
            // если фото вертикальное (хотя можно тоже серединку) 
            if ($w_src<$h_src) 
            imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,
                    min($w_src,$h_src), min($w_src,$h_src)); 

            // квадратная картинка масштабируется без вырезок 
            if ($w_src==$h_src) 
            imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 


            $date=time(); //вычисляем время в настоящий момент.
            imagejpeg($dest, $path_to_logo_directory.$date.".jpg");//сохраняем изображение формата jpg в нужную папку, именем будет текущее время. Сделано, чтобы у аватаров не было одинаковых имен.

            //почему именно jpg? Он занимает очень мало места + уничтожается анимирование gif изображения, которое отвлекает пользователя. Не очень приятно читать его комментарий, когда краем глаза замечаешь какое-то движение.

            $logo = $path_to_logo_directory.$date.".jpg";//заносим в переменную путь до лого.

            $delfull = $path_to_logo_directory.$filename; 
            unlink ($delfull);//удаляем оригинал загруженного изображения, он нам больше не нужен. Задачей было - получить миниатюру.
            return $logo;
        } else {
            //в случае несоответствия формата
            return false;
        }
    }

    /** Возвращает хэш пароля и id пользователя, с логином $email из таблицы `teams`
     * 
     * @param string $email Email пользователя для входа
     * @return int or array
     */
    public static function getPasswordHashRoleIdByEmail($email)
    {
        $db = Db::getConnection();
        /* создаем подготавливаемый запрос */
        $sql = "SELECT `id`,`password`,`role` FROM `teams` WHERE `email`= ? ";
        //con('$sql:',"_____________________",$sql);
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //con('$row:',"______________________",$row);
        if (isset($row["id"])){
            return $row;   
        }
        else{
            return 0;
        }

    }

    
    /** Возвращает массив-запись команды по id из таблицы `teams`
     * 
     * @param integer $id Номер команды
     * @return array Запись команде из таблицы `teams`
     */
    public static function showOneTeam($id)
    {
        $db = Db::getConnection();
        /* создаем подготавливаемый запрос */
        $sql = "SELECT * FROM `teams` WHERE `id`= ? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row; 
    }

    /** Правка команды по ID
     * 
     * @param реквизиты команды
     * @return boolean результат запроса
     */
    public static function editTeam($logo,$kapitan,$osnova1,$osnova2,$osnova3,$osnova4,$standin1,$standin2,$standin3,$standin4,$standin5,$trainer,$id)
    {
        $db = Db::getConnection();
        /* создаем подготавливаемый запрос */
        $sql = "UPDATE `teams` SET `logo` = ?, `kapitan` = ?, `osnova1` = ?, `osnova2` = ?, `osnova3` = ?, `osnova4` = ?, `standin1` = ?, `standin2` = ?, `standin3` = ?, `standin4` = ?, `standin5` = ?, `trainer` = ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$logo,$kapitan,$osnova1,$osnova2,$osnova3,$osnova4,$standin1,$standin2,$standin3,$standin4,$standin5,$trainer,$id]);
        return $res; 
    }

    /** Правка команды по ID админом. Если пароль-"", то его не меняем
     * 
     * @param реквизиты команды
     * @return boolean результат запроса
     */
    public static function editTeamAdmin($name,$email,$password,$logo,$kapitan,$osnova1,$osnova2,$osnova3,$osnova4,$standin1,$standin2,$standin3,$standin4,$standin5,$trainer,$id)
    {
        $db = Db::getConnection();
        /* создаем подготавливаемый запрос */
        $password = trim($password);
        if($password==""){ // Пароль не меняли
            $sql = "UPDATE `teams` SET `name` = ?,`email` = ?,`logo` = ?, `kapitan` = ?, `osnova1` = ?, `osnova2` = ?, `osnova3` = ?, `osnova4` = ?, `standin1` = ?, `standin2` = ?, `standin3` = ?, `standin4` = ?, `standin5` = ?, `trainer` = ? WHERE `teams`.`id` = ?";
            $res = $db->prepare($sql)->execute([$name,$email,$logo,$kapitan,$osnova1,$osnova2,$osnova3,$osnova4,$standin1,$standin2,$standin3,$standin4,$standin5,$trainer,$id]);
        } else{
            // Хэшируем пароль
            $options = [
                'cost' => PASS_COST,
            ];
            $password_h = password_hash($password, PASSWORD_BCRYPT, $options);
            $sql = "UPDATE `teams` SET `name` = ?,`email` = ?,`password` = ?,`logo` = ?, `kapitan` = ?, `osnova1` = ?, `osnova2` = ?, `osnova3` = ?, `osnova4` = ?, `standin1` = ?, `standin2` = ?, `standin3` = ?, `standin4` = ?, `standin5` = ?, `trainer` = ? WHERE `teams`.`id` = ?";
            $res = $db->prepare($sql)->execute([$name,$email,$password_h,$logo,$kapitan,$osnova1,$osnova2,$osnova3,$osnova4,$standin1,$standin2,$standin3,$standin4,$standin5,$trainer,$id]);
        }
        return $res; 
    }
    
    
    /** Установка роли команде по ID.  таблица `teams`
     * 
     * @param $id - id of team
     * @param $role - role of team(kapitan,moder,admin)
     * @return boolean результат запроса
     */
    public static function setRole($id,$role)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `role` = ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$role,$id]);
        return $res; 
    }
    
    /** Утверждение команды по ID.  таблица `teams`
     * 
     * @param реквизиты команды
     * @return boolean результат запроса
     */
    public static function approveTeam($id)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `admin_approved` = 1 WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$id]);
        return $res; 
    }

    /** Отвергание команды по ID.  таблица `teams`
     * 
     * @param реквизиты команды
     * @return boolean результат запроса
     */
    public static function discardTeam($id)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `admin_approved` = 0 WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$id]);
        return $res; 
    }

    /** Удаление команды по ID.  таблица `teams`
     * 
     * @param реквизиты команды
     * @return boolean результат запроса
     */
    public static function deleteTeam($id)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `visible` = 0 WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$id]);
        return $res; 
    }

    /** Восстановление команды из списка удалённых по ID.  таблица `teams`
     * 
     * @param реквизиты команды
     * @return boolean результат запроса
     */
    public static function restoreTeam($id)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `visible` = 1 WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$id]);
        return $res; 
    }
    /** Returns count of cups of league из таблицы `teams`
     * 
     * @param int $id
     * @return int count of cupLeague
     */
    public static function getCupLeagueCount($id)
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT `cup_league` FROM `teams` WHERE `teams`.`id`=' . $id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $count = $result->fetch();
        return $count["cup_league"];
    }
    
    /** Changes count of cups of league due of $inc variable
     * 
     * @param integer $inc Increases count of cups on this value
     * @param integer $id Team id
     * @return boolean
     */
    public static function cupLeagueCountChange($id,$inc)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `cup_league` = `cup_league` + ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$inc,$id]);
        return $res; 
    }
    
    /** Returns count of cups of off-season
     * 
     * @param int $id Team Identifier
     * @return int count of cupOffSeason
     */
    public static function getCupOffSeasonCount($id)
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT `cup_off_season` FROM `teams` WHERE `teams`.`id`=' . $id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $count = $result->fetch();
        return $count["cup_off_season"];
    }
    
    /** Changes count of cups of Off-Season due of $inc variable
     * 
     * @param integer $inc Increases count of cups on this value
     * @param integer $id Team id
     * @return boolean
     */
    public static function cupOffSeasonCountChange($id,$inc)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `cup_off_season` = `cup_off_season` + ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$inc,$id]);
        return $res; 
    }
    
    /** Changes count of wins due of $inc variable(-1 or 1) for team 
     * 
     * @param integer $inc Increases count of cups on this value
     * @param integer $id Team id
     * @return boolean
     */
    public static function winsCountChange($id,$inc)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `wins` = `wins` + ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$inc,$id]);
        return $res; 
    }
    
      /** Changes count of defeats due of $inc variable(-1 or 1) for team 
     * 
     * @param integer $inc Increases count of cups on this value
     * @param integer $id Team id
     * @return boolean
     */
    public static function defeatsCountChange($id,$inc)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `defeats` = `defeats` + ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$inc,$id]);
        return $res; 
    }
    
  
    /** Sets `static_wins` ,`static_defeats` field of team which id is $id
     * 
     * @param integer $id Team id
     * @param integer $wins Wins count
     * @param integer $defeats defeats count
     * @return boolean
     */
    public static function setStaticWinsAndDefeats($id,$wins,$defeats)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `static_wins` = ?,`static_defeats` = ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$wins,$defeats,$id]);
        return $res; 
    }

        /** Sets `static_wins` ,`static_defeats` field of team which id is $id
     * 
     * @param integer $id Team id
     * @param integer $wins Wins count
     * @param integer $defeats defeats count
     * @return boolean
     */
    public static function setStaticCupOffseasonWinsCount($teamId,$wins)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `static_cup_off_season` = ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$wins,$teamId]);
        return $res; 
    }

        /** Sets `static_wins` ,`static_defeats` field of team which id is $id
     * 
     * @param integer $id Team id
     * @param integer $wins Wins count
     * @param integer $defeats defeats count
     * @return boolean
     */
    public static function setStaticLeagueWSWinsCount($teamId,$wins)
    {
        $db = Db::getConnection();
        $sql = "UPDATE `teams` SET `static_cup_league` = ? WHERE `teams`.`id` = ?";
        $res = $db->prepare($sql)->execute([$wins,$teamId]);
        return $res; 
    }



  
    /** Получить имя команды пo ID
    * @param int $id - номер команды
    * @return int Название команды 
    */
    public static function getTeamNameByID($id){
        $db = Db::getConnection();
        $sql = "SELECT name FROM `teams` WHERE `teams`.`id`= ? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["name"]; 
    }

    /** Получить logo команды пo ID
    * @param int $id - номер команды
    * @return int Название команды 
    */
    public static function getTeamLogoByID($id){
        $db = Db::getConnection();
        $sql = "SELECT logo FROM `teams` WHERE `teams`.`id`= ? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["logo"]; 
    }




    
}


