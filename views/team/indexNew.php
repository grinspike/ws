<?php 
require_once(ROOT . '/views/layouts/header.php');
?>

<div id="infodiv">
<div id="regdiv">
<p class="title-page" id="filldata">СПИСОК КОМАНД НА УТВЕРЖДЕНИЕ</p>



<table id="teamlist">
<?php 
    foreach ($teamList as $row) {
        $id = $row['id'];
        echo "<tr><td teamid='".$row['id']."'>".$row['name']."</td></tr>";  
    }

    if (!isset($teamList[0]["id"])){
        echo "<h2>Нет команд для утверждения</h2>";
    };
?>
</table>
</div>
</div>

<?php
require_once(ROOT . '/views/layouts/footer.php');
?>
  
