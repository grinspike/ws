<?php 
require_once(ROOT . '/views/layouts/header.php');
?>

<div id="infodiv">
<div id="regdiv">
<p class="title-page" id="filldata">РОЛИ</p>
<table id="teamroleslist">
    <tr>    
        <th>Команда</th>
        <th>E-mail</th>
        <th>Капитан</th>
        <th>Модер</th>
        <th>Админ</th>
    </tr>
<?php 
    foreach ($teamList as $row) {
        $id = $row['id'];
        $email = $row['email'];
        $name = $row['name'];
        $role = $row['role'];
        
        echo "<tr>\n";
        echo "<td>".$name."</td>\n";
        echo "<td>".$email."</td>\n";
        if ($role=="") {echo "<td role='kapitan' teamid='".$id."' style='color: green;'> X </td>\n";} else {echo "<td role='kapitan' teamid='".$id."' style='color: green;'></td>\n";}
        if ($role=="moder") {echo "<td role='moder' teamid='".$id."' style='color: green;'> X </td>\n";} else {echo "<td role='moder' teamid='".$id."' style='color: green;'></td>\n";}
        if ($role=="admin") {echo "<td role='admin' teamid='".$id."' style='color: green;'> X </td>\n";} else {echo "<td role='admin' teamid='".$id."' style='color: green;'></td>\n";}
        echo "</tr>\n";  
}
?>
</table>
</div>
</div>



<?php
require_once(ROOT . '/views/layouts/footer.php');
?>
  
