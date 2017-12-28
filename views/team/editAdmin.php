<?php 
require_once(ROOT . '/views/layouts/header.php');
?>


<div id="infodiv">
    <div id="regdiv">
       <p class="title-page" id="filldata">РЕДАКТИРОВАНИЕ КОМАНДЫ АДМИНИСТРАТОРОМ</p>
        <form style="background : #aaa;padding :1vw; " action="#" method="post" enctype="multipart/form-data">

          
          
  
  
<?php
    $logoPath = "/" . $t_logo;

    if ((isset($errors))&&(!($errors == false))){
        foreach ($errors as $value) {
            echo '<h3><font color="red">'.$value.'</font></h3>';            
        }
    }


print <<<HERE
<p style="font-size:40px; color : #FFF;   "><strong> $t_name </strong></p>
<p>
<h1>Текущий логотип : </h1>
<img src="$logoPath" style = "margin : 0 auto;"> <br>
<label style="font-size : 16px;">Выберите логотип команды(jpg, gif или png):<br></label>
<input type="FILE" name="fupload">
</p>

        
<table id="team_structure">
<tr>
  <td><label>КОМАНДА:</label></td>
  <td><input name="name" type="text" size="22" maxlength="45" value="$t_name"></td> 
</tr>
<tr>
  <td><label>E-MAIL:</label></td>
  <td><input name="email" type="text" size="22" maxlength="45" value="$t_email"></td> 
</tr>
<tr>
  <td><label>ПАРОЛЬ:</label></td>
  <td><input name="password" type="text" size="22" maxlength="45" value=""></td> 
</tr>
</table>
<br>        
        
        
<table id="team_structure">
<tr>
  <td><label>КАПИТАН:</label></td>
  <td><input name="kapitan" type="text" size="22" maxlength="45" value="$t_kapitan"></td> 
</tr>
<tr>
  <td><label>ОСНОВА:</label></td>
  <td><input name="osnova1" type="text" size="22" maxlength="45" value="$t_osnova1"></td> 
</tr>
<tr>
  <td><label>ОСНОВА:</label></td>
  <td><input name="osnova2" type="text" size="22" maxlength="45" value="$t_osnova2"></td> 
</tr>
<tr>
  <td><label>ОСНОВА:</label></td>
  <td><input name="osnova3" type="text" size="22" maxlength="45" value="$t_osnova3"></td> 
</tr>
<tr>
  <td><label>ОСНОВА:</label></td>
  <td><input name="osnova4" type="text" size="22" maxlength="45" value="$t_osnova4"></td> 
</tr>
        
<tr>
  <td><label>СТЕНДИН:</label></td>
  <td><input name="standin1" type="text" size="22" maxlength="45" value="$t_standin1"></td> 
</tr>
<tr>
  <td><label>СТЕНДИН:</label></td>
  <td><input name="standin2" type="text" size="22" maxlength="45" value="$t_standin2"></td> 
</tr>
<tr>
  <td><label>СТЕНДИН:</label></td>
  <td><input name="standin3" type="text" size="22" maxlength="45" value="$t_standin3"></td> 
</tr>
<tr>
  <td><label>СТЕНДИН:</label></td>
  <td><input name="standin4" type="text" size="22" maxlength="45" value="$t_standin4"></td> 
</tr>
<tr>
  <td><label>СТЕНДИН:</label></td>
  <td><input name="standin5" type="text" size="22" maxlength="45" value="$t_standin5"></td> 
</tr>
        
<tr>
  <td><label>ТРЕНЕР:</label></td>
  <td><input name="trainer" type="text" size="22" maxlength="45" value="$t_trainer"></td> 
</tr>        
</table>
HERE;
?>
<p>
<input type="submit" name="submit" value="СОХРАНИТЬ">
</p></form>
</div>

</div>



<?php
require_once(ROOT . '/views/layouts/footer.php');
?>
  
