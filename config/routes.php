<?php
return array(
	//'test' => 'team/refreshStatisticsOfTeams',  // убрать. это временная проверка кода

	'contact' => 'contact/view', 
	'shedule/archive' => 'shedule/archive', 
	'shedule/deleteBattle' => 'shedule/deleteBattle', //ajax
	'shedule/defineWinner' => 'shedule/defineWinner', //ajax
	'shedule' => 'shedule/view', 
  
	'league/getTeamList' => 'league/getTeamList',     //ajax
	'league/battles/([0-9]+)' => 'league/battles/$1',     
    'league/editBattleAJAX' => 'league/editBattleAJAX',//ajax     
    'league/setWinnerUpdateParentBattleAJAX' => 'league/setWinnerUpdateParentBattleAJAX',//ajax    //пожалуй, нужно было не league, а battle 
    'league/editBattle/([0-9]+)' => 'league/editBattle/$1',     
	'league/declareBattle' => 'league/declareBattle',     //ajax
    'league/shuffle' => 'league/shuffle',     //ajax
	'league/addNew/([0-9]+)' => 'league/addNew/$1', //adding a cup or league 
	'league/offSeasonView' => 'league/offSeasonView', 
	'league' => 'league/view', 
  
	'image/cup/([0-9]+)/([0-9]+)/([0-9]+)/([A-Za-z0-9]+)' => 'image/cup/$1/$2/$3/$4',//image of cup
	'team/([0-9]+)' => 'team/view/$1', 
	'team/approve' => 'team/approve',       //ajax 
	'team/discard' => 'team/discard',       //ajax 
	'team/setRole' => 'team/setRole',       //ajax 
	'team/delete' => 'team/delete',     //ajax 
	'team/restore' => 'team/restore',   //ajax 
	'team/getAllTeamApproved' => 'team/getAllTeamApproved',   //ajax 
	'team/create' => 'team/create',
	'team/login' => 'team/login',
	'team/exit' => 'team/exit',
	'team/edit/([0-9]+)' => 'team/edit/$1',
	'team/editAdmin/([0-9]+)' => 'team/editAdmin/$1',
	'team/edit' => 'team/editOwnTeam',
	'team/indexNew' => 'team/indexNew',
	'team/indexDeleted' => 'team/indexDeleted',
    
	'team/teamCupLeagueChange' => 'team/teamCupLeagueChange',       //ajax
	'team/teamCupOffSeasonChange' => 'team/teamCupOffSeasonChange',     //ajax
	'team/winsTeamCountChange' => 'team/winsTeamCountChange',       //ajax
	'team/defeatsTeamCountChange' => 'team/defeatsTeamCountChange',     //ajax
	
    'team/roles' => 'team/roles',
	'team' => 'team/index',
    ''=>'shedule/view',


	);
	// Симпл текст