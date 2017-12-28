<?php 
require_once(ROOT . '/views/layouts/header.php');
?>
<div id="infodiv">
    <div id="regdiv">
        <p class="title-page" id="filldata">РЕДАКТИРОВАНИЕ КОМАНДЫ</p>
        <form style="background : #aaa;padding :1vw; " action="#" method="post" enctype="multipart/form-data">
<?php
    $logoPath = "/" . $t_logo;

    if ((isset($errors))&&(!($errors == false))){
        foreach ($errors as $value) {
            echo '<h3><font color="red">'.$value.'</font></h3>';            
        }
    }
?>
            <p style="font-size:40px; color : #FFF;   "><strong><?php echo $t_name; ?> </strong></p>
            <p>
                <h1>Текущий логотип : </h1>
                <img src="<?php echo $logoPath; ?>" style = "margin : 0 auto;"> <br>
                <label style="font-size : 16px;">Выберите логотип команды(jpg, gif или png):<br></label>
                <input type="FILE" name="fupload">
            </p>

            <input name="name" style="display:none;" type="text" value="<?php echo $t_name; ?>">

            <table id="team_structure">
                <tr>
                    <td><label>КАПИТАН:</label></td>
                    <td><input name="kapitan" type="text" size="22" maxlength="45" value="<?php echo $t_kapitan; ?>"></td> 
                </tr>
                <tr>
                    <td><label>ОСНОВА:</label></td>
                    <td><input name="osnova1" type="text" size="22" maxlength="45" value="<?php echo $t_osnova1; ?>"></td> 
                </tr>
                <tr>
                    <td><label>ОСНОВА:</label></td>
                    <td><input name="osnova2" type="text" size="22" maxlength="45" value="<?php echo $t_osnova2; ?>"></td> 
                </tr>
                <tr>
                    <td><label>ОСНОВА:</label></td>
                    <td><input name="osnova3" type="text" size="22" maxlength="45" value="<?php echo $t_osnova3; ?>"></td> 
                </tr>
                <tr>
                    <td><label>ОСНОВА:</label></td>
                    <td><input name="osnova4" type="text" size="22" maxlength="45" value="<?php echo $t_osnova4; ?>"></td> 
                </tr>

                <tr>
                    <td><label>СТЕНДИН:</label></td>
                    <td><input name="standin1" type="text" size="22" maxlength="45" value="<?php echo $t_standin1; ?>"></td> 
                </tr>
                <tr>
                    <td><label>СТЕНДИН:</label></td>
                    <td><input name="standin2" type="text" size="22" maxlength="45" value="<?php echo $t_standin2; ?>"></td> 
                </tr>
                <tr>
                    <td><label>СТЕНДИН:</label></td>
                    <td><input name="standin3" type="text" size="22" maxlength="45" value="<?php echo $t_standin3; ?>"></td> 
                </tr>
                <tr>
                    <td><label>СТЕНДИН:</label></td>
                    <td><input name="standin4" type="text" size="22" maxlength="45" value="<?php echo $t_standin4; ?>"></td> 
                </tr>
                <tr>
                    <td><label>СТЕНДИН:</label></td>
                    <td><input name="standin5" type="text" size="22" maxlength="45" value="<?php echo $t_standin5; ?>"></td> 
                </tr>
                <tr>
                    <td><label>ТРЕНЕР:</label></td>
                    <td><input name="trainer" type="text" size="22" maxlength="45" value="<?php echo $t_trainer; ?>"></td> 
                </tr>        
            </table>
            <p>
                <input type="submit" name="submit" value="СОХРАНИТЬ">
            </p>
        </form>
    </div>
</div>



<?php
require_once(ROOT . '/views/layouts/footer.php');
?>
  
