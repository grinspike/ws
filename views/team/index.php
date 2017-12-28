<?php 
require_once(ROOT . '/views/layouts/header.php');
?>

<div id="infodiv">
<div id="regdiv">
<p class="title-page" id="filldata">СПИСОК КОМАНД</p>
<table id="teamlist">
<?php 
foreach ($teamList as $row) {
  $id = $row['id'];
echo "<tr><td teamid='".$row['id']."'>".$row['name']."</td></tr>";  
}
?>
</table>
</div>
</div>

<?php
require_once(ROOT . '/views/layouts/footer.php');
?>
  
