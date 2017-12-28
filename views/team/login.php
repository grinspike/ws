<?php 
require_once(ROOT . '/views/layouts/header.php');
?>




<div id="infodiv">
<div id="regdiv">
<p class="title-page" id="filldata">ВХОД В КОМАНДУ</p>

<?php   
if (!($errors==false)){
    echo '<h3><font color="red">Неверный пароль или логин</font></h3>';
}
?>
<form style="background : #aaa;padding :3%; " action="#" method="post" enctype="multipart/form-data">

<p>
    <label style="font-size : 16px;">E-MAIL</label>
    <input id="email" name="email" type="text" size="22" maxlength="35" required>
</p>

<p>
    <label style="font-size : 16px;">ПАРОЛЬ</label>
    <input id="pass" name="password" type="text" size="22" maxlength="35" required>
</p>

<p>
    <input type="submit" name="submit" value="ВОЙТИ!">
</p>
</form>


</div>

</div>  


<?php
require_once(ROOT . '/views/layouts/footer.php');
?>
  
