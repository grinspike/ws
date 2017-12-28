<?php

class Image
{

    /** Draws a cup with number which represents the number of cup(league or off-season) team have won
     * 
     * @param integer $imgSize Size of image
     * @param integer $fontSize Size of font
     * @param integer $num Number of cups in the right bottom corner
     * @param string $type "league" or "offSeason" variables
     */
	public static function cup($imgSize,$fontSize,$num,$type = "league")
	{
        include_once ROOT .'/config/cupImage.php';
        if ($type=="league") { $imagePath = ROOT . '/template/images/logoLeague.png'; }
        if ($type=="offSeason") { $imagePath = ROOT . '/template/images/logoOffSeason.png'; }
        if ($num==1 or $num==0) {$num = "";}
        // Создаем экземпляр класса LImageHandler
        $ih = new LImageHandler;
        // Загружаем изображение
        $imgObj = $ih->load($imagePath);
        // Выполняем наложение текста с обводкой на изображение 
        $imgObj->textWithOutline($num, $cupFontPath, $fontSize, $cupColorText, $cupColorTextOutline, LImageHandler::CORNER_RIGHT_BOTTOM, 7, 7);
        // Выполняем изменение размера до нужной величины
        $imgObj->resize($imgSize, $imgSize, true);
        $imgObj->show(false, 100);
	}
    
}    