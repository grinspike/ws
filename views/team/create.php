<?php 
require_once(ROOT . '/views/layouts/header.php');
?>

<?php if($result): ?>
<div id="infodiv">
<div id="regdiv">
<br>  <br>  <br>  
<p class="title-page" id="filldata">КОМАНДА СОЗДАНА</p>

<img src="http://4.bp.blogspot.com/-9AaNWlomic4/UZmSgJdX7-I/AAAAAAAAASg/5DCr39E46W8/s1600/MLM1.jpg">
</div>
</div>
<?php else: ?>


<div id="infodiv">
<div id="regdiv">
<p class="title-page" id="filldata">СОЗДАНИЕ КОМАНДЫ</p>

<form style="background : #aaa;padding :3%; " action="#" method="post" enctype="multipart/form-data">
<p>
    <?php
        if (!($errors == false)){
            foreach ($errors as $value) {
            echo '<h3><font color="red">'.$value.'</font></h3>';            
            }
            
        }
    ?>
</p>


<p>
    <label style="font-size : 16px;">E-MAIL КАПИТАНА КОМАНДЫ:</label><br>
    <?php
        echo '<input id="email" name="email" type="email" size="22" maxlength="45" value="'.$email.'" required>'; 
    ?>
</p>

<p>
    <label style="font-size : 16px;">ПАРОЛЬ(для входа)<br><a style="color : #666;">(латинские символы, цифры, дефис, подчеркивание):</a></label><br>
    <?php
        echo '<input id="pass" name="password" type="text" size="22" maxlength="35" value="'.$password.'" required>'; 
    ?>
</p>

<p>
    <label style="font-size : 16px;">НАЗВАНИЕ КОМАНДЫ<br><a style="color : #666;">(любые символы):</a></label><br>
    <?php 
        echo '<input id="teamname" name="teamname" type="text" size="22" maxlength="35" value="'.$teamName.'" required>'; 
    ?>
</p>
  
<p><br>
    <label style="font-size : 16px;">Выберите логотип команды(jpg, gif или png):</label><br>
    <input type="file" name="fupload">    
</p>

  
<div style="background : #89a; padding : 10px; margin-top : 10px; ">
Введите код с картинки:<br>
<?php 
    $path = "/vendors/kcaptcha/captcha.php?" . session_name() . "=" . session_id();
?>

<p><img src=<?php echo $path; ?></p>
<p><input type="text" name="code"></p>
</div>

<p>
    <input type="submit" name="submit" value="ГОТОВО!">
</p></form>


</div>

</div> 
<?php endif; ?>

<?php
require_once(ROOT . '/views/layouts/footer.php');
?>
  
