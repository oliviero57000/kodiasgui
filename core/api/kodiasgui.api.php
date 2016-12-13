<?php

require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";
	
//  192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=hello&UID=58089181cdc2b

function sendShortCuts()
{
	global $eqLogic,$cmd;
	echo '[';
	$shortcuts = $eqLogic->getConfiguration('shortcuts');
	$notfirst = false;
	foreach($shortcuts as $index => $shortcut)
	{
		foreach($shortcut as $key => $value)
		{
			if ( strncmp($key,"info",4)==0 )
			{
				$cmdid="";
				sscanf($value,"#%d#",$cmdid);

				if ($cmdid!="")
				{
					$cmd = cmd::byId($cmdid);
					$resultcmd = $cmd->execute();
					if ($resultcmd == "")
						$shortcut[$key]  = "0" ;
					else
						$shortcut[$key] = (string)$resultcmd ;
				}
			}
		}
		if ( $notfirst )
			echo (' , ');
		echo ( json_encode ($shortcut ));
		$notfirst = true;
	}	
	
	echo ' ] ';
	
}

function sendLights()
{
	global $eqLogic,$cmd;
	echo '[';
	$lights = $eqLogic->getConfiguration('lights');
	$notfirst = false;
	foreach($lights as $index => $light)
	{
		foreach($light as $key => $value)
		{
			if ( strncmp($key,"info",4)==0 )
			{
				$cmdid="";
				sscanf($value,"#%d#",$cmdid);

				if ($cmdid!="")
				{
					$cmd = cmd::byId($cmdid);
					$resultcmd = $cmd->execute();
					if ($resultcmd == "")
						$light[$key]  = "0" ;
					else
						$light[$key] = (string)$resultcmd ;
				}
			}
		}
		if ( $notfirst )
			echo (' , ');
		echo ( json_encode ($light ));
		$notfirst = true;
	}	
	
	echo ' ] ';
	
}

function sendAccess()
{
	global $eqLogic,$cmd;
	echo '[';

	$access = $eqLogic->getConfiguration('access');
	$notfirst = false;
	foreach($access as $index => $acces)
	{
		foreach($acces as $key => $value)
		{
			if ( strncmp($key,"info",4)==0 )
			{
				$cmdid="";
				sscanf($value,"#%d#",$cmdid);

				if ($cmdid!="")
				{
					$cmd = cmd::byId($cmdid);
					$resultcmd = $cmd->execute();
					if ($resultcmd == "")
						$acces[$key]  = "0" ;
					else
						$acces[$key] = (string)$resultcmd ;
				}
			}
		}
		if ( $notfirst )
			echo (' , ');
		echo ( json_encode ($acces ));
		$notfirst = true;
	}		


	echo ' ] ';
}

function sendTherms()
{
	global $eqLogic,$cmd;
	echo '[';

	$thermos = $eqLogic->getConfiguration('thermos');
	$notfirst = false;
	foreach($thermos as $index => $thermo)
	{
		foreach($thermo as $key => $value)
		{
			if ( strncmp($key,"info",4)==0 )
			{
				$cmdid="";
				sscanf($value,"#%d#",$cmdid);

				if ($cmdid!="")
				{
					$cmd = cmd::byId($cmdid);
					$resultcmd = $cmd->execute();
					if ($resultcmd == "")
						$thermo[$key]  = "0" ;
					else
						$thermo[$key] = (string)$resultcmd ;
				}
			}
		}
		if ( $notfirst )
			echo (' , ');
		echo ( json_encode ($thermo ));
		$notfirst = true;
	}	

	echo ' ] ';
}

function sendWaters()
{
	global $eqLogic,$cmd;
	echo '[';
	
	$waters = $eqLogic->getConfiguration('waters');
	$notfirst = false;
	foreach($waters as $index => $water)
	{
		foreach($water as $key => $value)
		{
			if ( strncmp($key,"info",4)==0 )
			{
				$cmdid="";
				sscanf($value,"#%d#",$cmdid);

				if ($cmdid!="")
				{
					$cmd = cmd::byId($cmdid);
					$resultcmd = $cmd->execute();
					if ($resultcmd == "")
						$water[$key]  = "0" ;
					else
						$water[$key] = (string)$resultcmd ;
				}
			}
		}
		if ( $notfirst )
			echo (' , ');
		echo ( json_encode ($water ));
		$notfirst = true;
	}		
	
	echo ' ] ';
}

function sendEquips()
{
	global $eqLogic,$cmd;
	echo '[';
	
	$equips = $eqLogic->getConfiguration('equips');
	$notfirst = false;
	foreach($equips as $index => $equip)
	{
		foreach($equip as $key => $value)
		{
			if ( strncmp($key,"info",4)==0 )
			{
				$cmdid="";
				sscanf($value,"#%d#",$cmdid);

				if ($cmdid!="")
				{
					$cmd = cmd::byId($cmdid);
					$resultcmd = $cmd->execute();
					if ($resultcmd == "")
						$equip[$key]  = "0" ;
					else
						$equip[$key] = (string)$resultcmd ;
				}
			}

		}
		if ( $notfirst )
			echo (' , ');
		echo ( json_encode ($equip ));
		$notfirst = true;
	}	

	echo ' ] ';
}

function sendKodi()
{
	global $eqLogic,$cmd;
	
	echo ' {"name" : "'.$eqLogic->getName().'"';
	
	$ginfos = $eqLogic->getConfiguration('ginfos');

	foreach($ginfos as $key => $value)
	{
		if ( strncmp($key,"info",4)==0 )
		{
			$cmdid="";
			sscanf($value,"#%d#",$cmdid);

			if ($cmdid!="")
			{
				$cmd = cmd::byId($cmdid);
				$resultcmd = $cmd->execute();
				if ($resultcmd == "")
					$ginfos[$key] = '0' ;
				else
					$ginfos[$key] = (string)$resultcmd ;
			}
		}
	}

	echo ' , "ginfos":';
	echo ( json_encode ($ginfos) );
	
	echo ' ,"lights": ';
	
	sendLights();

	echo ',"access": ';
	
	sendAccess();

	echo ' ,"thermos": ';
	
	sendTherms();
	
	echo ' ,"waters": ';
	
	sendWaters();
	
	echo ' ,"equips": ';

	sendEquips();
	
	echo ' }';

}	


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
		break;
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


if ( init('func') == 'getdesign' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getdesign&plan=1&uid=58248a5a41c45

	//$plan = plan::byPlanHeaderId(init('plan'));
	
	$planHeader = null;
	$planHeaders = planHeader::all();
	$planid = init('plan');

	if (init('plan') != '') {
		foreach ($planHeaders as $planHeader_select) {
			if ($planHeader_select->getId() == init('plan')) {
				$planHeader = $planHeader_select;
				break;
			}
		}
		
	}	
	
    $filename = $planHeader->getImage('sha1') . '.' . $planHeader->getImage('type');
   //  $size = $this->getImage('size');
   // return '<img src="core/img/plan/' . $filename . '" data-sixe_y="' . $size[1] . '" data-sixe_x="' . $size[0] . '">';
	
	

	echo ' {"name" : "'.$planHeader->getName().'" , "image" : "'.$filename.'" , "plan" : [ ';
	
	$plans = plan::all();
	
	//$views->getName()
	foreach ($plans as $plan) 
	{
		if ( $plan->getPlanHeader_id() == $planid )
		{
			echo ' { "id" :"'.$plan->getId().'" , "x" : "'.$plan->getPosition("left").'" , "y" : "'.$plan->getPosition("top").'"  } ';
			
		//	echo $plan->getLink().'   '; 
			echo $plan->getLink_type().'   '; 
			echo $plan->getLink_id().'   '; 
			
			echo $plan->getLink()->getName().'   '; 
			echo $plan->getLink()->getEqType_name().'   '; 
			echo $plan->getLink()->getConfiguration('KodiType').'   '; 
	
		}

	}	


//echo($retourOk);
//		echo(json_encode($view));

}	


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


if ( init('func') == 'getui' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getui&uid=58248a5a41c45
	
	sendKodi();
	
}

if ( init('func') == 'getlights' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getlights&uid=58248a5a41c45
	
	$masterid = $eqLogic->getConfiguration('MasterCfg');
	$eqLogic = eqLogic::byid($masterid);
	sendLights();
	
}

if ( init('func') == 'getacces' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getacces&uid=58248a5a41c45
	
	$masterid = $eqLogic->getConfiguration('MasterCfg');
	$eqLogic = eqLogic::byid($masterid);
	sendAccess();
	
}

if ( init('func') == 'gettherms' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=gettherms&uid=58248a5a41c45
	
	$masterid = $eqLogic->getConfiguration('MasterCfg');
	$eqLogic = eqLogic::byid($masterid);
	sendTherms();
	
}

if ( init('func') == 'getshortcuts' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getshortcuts&uid=58248a5a41c45
	
	$masterid = $eqLogic->getConfiguration('MasterCfg');
	$eqLogic = eqLogic::byid($masterid);
	sendShortCuts();
}


if ( init('group') == 'light' )
{
	// log::add('kodiasgui', 'info', 'light command received.');
	
	if ( init('func') == 'switch' )
	{
		if ( init('mode') == 'global' )
		{
			$masterid = $eqLogic->getConfiguration('MasterCfg');
			$eqLogic = eqLogic::byid($masterid);			
		}
		
		$lights = $eqLogic->getConfiguration('lights');
		$lightID = intval (init('obj')) - 1;
		
		$mylight = $lights[$lightID];
		$cmdetatid="";
		
		$etat = $mylight['infoSTATUS'];
		sscanf($etat,"#%d#",$cmdetatid);
		if ($cmdetatid!="")
		{
			$cmdetat = cmd::byId($cmdetatid);
			$resultcmd = $cmdetat->execute();
			if ($resultcmd == "")
			{
				$etat  = "0" ;
				$mylight['infoSTATUS'] = "1";
			}
			else
			{
				$etat = "1";
				$mylight['infoSTATUS'] = "0";
			}
		}
		$cmdid="";
		if ($etat =="1")
			sscanf($mylight['cmdOFF'],"#%d#",$cmdid);
		else
			sscanf($mylight['cmdON'],"#%d#",$cmdid);
		if ($cmdid!="")
		{
			$cmd = cmd::byId($cmdid);
			$resultcmd = $cmd->execute();
		}
		 
		echo ( json_encode ($mylight ));
	}
}

if ( init('group') == 'acces' )
{
	// log::add('kodiasgui', 'info', 'light command received.');
	
	if ( init('func') == 'switch' )
	{
		$access = $eqLogic->getConfiguration('access');
		
		$accesID = intval (init('obj')) - 1;
		
		$myacces = $lights[$accesID];
		$cmdetatid="";
		
		$etat = $myacces['infoSTATUS'];
		sscanf($etat,"#%d#",$cmdetatid);
		if ($cmdetatid!="")
		{
			$cmdetat = cmd::byId($cmdetatid);
			$resultcmd = $cmdetat->execute();
			if ($resultcmd == "")
			{
				$etat  = "0" ;
				$myacces['infoSTATUS'] = "1";
			}
			else
			{
				$etat = "1";
				$myacces['infoSTATUS'] = "0";
			}
		}
		$cmdid="";
		if ($etat =="1")
			sscanf($myacces['cmdCLOSE'],"#%d#",$cmdid);
		else
			sscanf($myacces['cmdOPEN'],"#%d#",$cmdid);
		if ($cmdid!="")
		{
			$cmd = cmd::byId($cmdid);
			$resultcmd = $cmd->execute();
		}
		 
		echo ( json_encode ($myacces ));
	}

	
}

if ( init('group') == 'thermo' )
{
	// log::add('kodiasgui', 'info', 'light command received.');
	


	
}


?>
