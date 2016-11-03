<?php


require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";


/*
echo 'eqlogic';

$eqLogics = eqLogic::byType('virtual');

foreach ($eqLogics as $eqLogic) {
	echo '<br>' . $eqLogic->getId() . ' - ' . $eqLogic->getHumanName(true). ' - '. $eqLogic->getName();
	$eqlDisplay = $eqLogic->getDisplay();
	foreach ($eqlDisplay as $eDisplay) {
		echo '<br>  - ' . $eDisplay;
	}	
	
}
*/
	//  192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=hello&UID=58089181cdc2b
	
$accessgranted = false;	
	
$eqLogics = eqLogic::byType('kodiasgui');
$uniqueID =  init('uid');
$granted="unknown";

foreach ($eqLogics as $eqLogic) 
{
	if ( $eqLogic->getConfiguration('UID') == $uniqueID  )
	{
		$accessgranted = true;
		$granted=$eqLogic->getName();
		$ipgranted = $_SERVER['REMOTE_ADDR'];
		$eqLogic->setConfiguration('IP',$ipgranted) ;
		$eqLogic->save();
	}
}

if ( $accessgranted )
{
	if ( init('func') == 'hello' )
	{
		log::add('kodiasgui', 'info', 'Hello from '.$granted.' IP:'.$ipgranted);
		echo 'welcome '.$granted;
		return;
	}
}	
else
{
	log::add('kodiasgui', 'error', 'unauthorised access from '.$uniqueID);
	echo 'who are you '. $uniqueID.' ?';
	die();	
}


/*
if (init('apikey') != config::byKey('api') || config::byKey('api') == '') {
	connection::failed();
	echo 'Clef API non valide, vous n\'etes pas autorisé à effectuer cette action (jeeApi)';
	die();
}

*/

if ( init('func') == 'getcmds' )
{
	// http://192.168.0.38//plugins/kodi/core/api/kodi.api.php?func=getcmds&cmds=21,22

	//$view  = viewData::all();

	$cmdList = init('cmds');
	
	$Acmd = split(',',$cmdList);

	$retourOk = 'OK,';
	foreach ($Acmd as $cmdID) 
	{
		if ( ( $cmdID != "") & ( $cmdID != "0") )
			{
			$cmd = cmd::byId($cmdID);
			$resultcmd = $cmd->execute();
			if ($resultcmd == "")
				$retourOk .= '0,' ;
			else
				$retourOk .= $resultcmd.',' ;
			}
		else
			$retourOk .= '0,';
	}
	
	echo($retourOk);
//		echo(json_encode($view));

}	


return;
?>
