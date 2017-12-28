        
    </div>
     <script src="/template/js/jquery.min.js"></script> 
    <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
<?php 
// Подключение всех страниц, где будет использоваться диалог выбора датывремени
$pos = strpos($_SERVER["REQUEST_URI"], "/league/battles");
if(!($pos===false)){
    echo '        <script type="text/javascript" src="/template/js/jquery.simple-dtpicker.js"></script>'."\n";
}
$pos = strpos($_SERVER["REQUEST_URI"], "/league/editBattle");
if(!($pos===false)){
    echo '        <script type="text/javascript" src="/template/js/jquery.simple-dtpicker.js"></script>'."\n";
}
$pos = strpos($_SERVER["REQUEST_URI"], "/league/offSeasonView");
if(!($pos===false)){
    echo '        <script type="text/javascript" src="/template/js/jquery.simple-dtpicker.js"></script>'."\n";
}
?>
    <?php If(isset($_SESSION["admin"])): ?>
    <script src="/template/js/myscripts.js?random=<?php echo uniqid(); ?>"></script>
    <?php endif; ?>    
    
    <script src="/template/js/scripts.js?random=<?php echo uniqid(); ?>"></script>
  </body>
</html>
