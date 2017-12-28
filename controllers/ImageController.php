<?php

class ImageController
{

        /** Изображение кубка с цифрами на нём
         * 
         * @param int $imgSize Размер изображения
         * @param int $fontSize Размер шрифта
         * @param string $num количество кубков заработано
         * @param string $type два варианта изображения :("league","offSeason")
         * @return boolean
         */
		public function actionCup($imgSize,$fontSize,$num,$type)
		{
            Image::cup($imgSize, $fontSize, $num, $type);
			return true;
		}


}