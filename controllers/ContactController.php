<?php

class ContactController {

    /** Контакты
    * @Show one team
    */
	public function actionView()
	{
        require_once(ROOT . '/views/contact/view.php');
		return true;
	}




    
    
}

