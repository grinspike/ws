<?php 
require_once(ROOT . '/views/layouts/header.php');
?>

<p class="title-page"> ЛИГА WS </p>

<?php 
if(isset($_SESSION["admin"])){
    echo  "<a class='newCupOrLeague' id='newLeague' >Создать новую Лигу WS</a><br>";
    echo "<a href='/league/battles/1'>Добавить 1 бой</a><br>";
    echo "<a href='/league/battles/2'>Добавить 2 боя</a><br>";
    echo "<a href='/league/battles/4'>Добавить 4 боя</a><br>";
    echo "<a href='/league/battles/5'>Добавить 5 боев</a><br>";
    echo "<a href='/league/battles/10'>Добавить 10 боев</a><br>";
}
?>

<table id="teamroleslist">
    <tr>    
        <th>Команда</th>
        <th>Побед</th>
        <th>Поражений</th>
        <th>Всего</th>
    </tr>
<?php 
    foreach ($teamsOfLeague as $value) {
        $id = $value['name'];
        $email = $value['wins'];
        $name = $value['defeats'];
        $role = $value['battlesCount'];
        
        echo "<tr>\n";
        echo "<td>".$value['name']."</td>\n";
        echo "<td>".$value['wins']."</td>\n";   
        echo "<td>".$value['defeats']."</td>\n";
        echo "<td>".$value['battlesCount']."</td>\n";
        echo "</tr>\n";  
}
?>
</table>









<?php 
require_once(ROOT . '/views/layouts/footer.php');
?>
   
