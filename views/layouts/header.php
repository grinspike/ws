<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Турниры по Dota2!">
        <meta name="author" content="Prudnikov Sergey">
        <title>WolfShelter</title>
        <link href="/template/css/style.css?v=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css">

<?php 
// Подключение всех страниц, где будет использоваться диалог выбора датывремени
$pos = strpos($_SERVER["REQUEST_URI"], "/league/battles");
if(!($pos===false)){
    echo '        <link href="/template/css/jquery.simple-dtpicker.css" rel="stylesheet" type="text/css">'."\n";
}
$pos = strpos($_SERVER["REQUEST_URI"], "/league/editBattle");
if(!($pos===false)){
    echo '        <link href="/template/css/jquery.simple-dtpicker.css" rel="stylesheet" type="text/css">'."\n";
}
$pos = strpos($_SERVER["REQUEST_URI"], "/league/offSeasonView");
if(!($pos===false)){
    echo '        <link href="/template/css/jquery.simple-dtpicker.css" rel="stylesheet" type="text/css">'."\n";
}

?>
    <link href="/template/ico/favicon.ico" rel="shortcut icon">
    
    </head><!--/head-->
    <body>
        <div class="page-wrapper">
            <header><!--header-->
        
<?php 
if(isset($_SESSION["admin"])):  
    $rows = Team::getNewTeamList(); 
    if (count($rows)>0){ 
        $new = "&#9993;"; 
    } else {
        $new = "";
    }   
    
    $rows = Battle::getBattlesWithoutWinner(); 
    if (count($rows)>0){ 
        $noWinner = '<ul><li id="archive">W?</li>'."\n"; 
    } else {
        $noWinner = "";
    }    
    
?>
                
                <ul><li id="shedule">Расписание</li>
<?php   echo $noWinner; ?>
                <li id="offSeason">Кубок Межсезонья</li>
                <li id="league">Лига WS</li>
                <li id="contact">Контакты</li>
                <li>Команда <?php echo $new; ?>
                  <ul>
                    <li id="newteam">Новые<?php echo $new; ?></li>
                    <li id="listteam">Утверждённые</li> 
                    <li id="listteamdeleted">Скрытые</li> 
                    <li id="roles">Роли</li>
                    <li id="exitteam">Выйти</li>
                  </ul>
                </li>
                </ul>
            </header><!--/header-->  
<?php return true; endif;  ?>
    
<?php if(isset($_SESSION["teamId"])):?>
                <ul><li id="shedule">Расписание</li>
                <li id="offSeason">Кубок Межсезонья</li>
                <li id="league">Лига WS</li>
                <li id="contact">Контакты</li>
                <li>Команда 
                  <ul>
                    <li id="editteam">Редактировать</li>
                    <li id="exitteam">Выйти</li>
                    <li id="listteam">Список</li> 
                  </ul>
                </li>
                </ul>
            </header><!--/header-->  
<?php return true; endif;  ?>

        
                <ul><li id="shedule">Расписание</li>
                <li id="offSeason">Кубок Межсезонья</li>
                <li id="league">Лига WS</li>
                <li id="contact">Контакты</li>
                <li>Команда
                  <ul>
                    <li id="createteam">Создать</li>
                    <li id="enterteam">Войти</li>
                    <li id="listteam">Список</li> 
                  </ul>
                </li>
                </ul>
            </header><!--/header-->  
      




    