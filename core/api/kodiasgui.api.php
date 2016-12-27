<?php

require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";
	
//  192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=hello&UID=58089181cdc2b
function array_orderby()
{

	$args = func_get_args();

	$data = array_shift($args);

	foreach ($args as $n => $field)
	{
		if (is_string($field))
		{
		$tmp = array();
		foreach ($data as $key => $row)
			$tmp[$key] = $row[$field];
		$args[$n] = $tmp;
		}
	}
	$args[] = &$data;
	call_user_func_array('array_multisort', $args);

	return array_pop($args);
}

function sendKodi($planid)
{
	global $eqLogic;
	
	echo ' {"name" : "'.$eqLogic->getName().'"';

	$planHeader = null;
	$planHeaders = planHeader::all();

	if ($planid != '') {
		foreach ($planHeaders as $planHeader_select) {
			if ($planHeader_select->getId() == $planid) {
				$planHeader = $planHeader_select;
				break;
			}
		}
		
	}	

	if ( $planHeader != null )
	{
    $filename = $planHeader->getImage('sha1') . '.' . $planHeader->getImage('type');

	echo ' , "plan" : "'.$planHeader->getName().'" , "image" : "'.$filename.'" ';

	$planconfig = getKodiConfig($planid,'');
	
	echo ' , "ginfos" : ';
	echo ( json_encode ($planconfig['ginfos']) );
	
	echo ' , "thermos" : ';
	$sorted = array_orderby($planconfig['thermos'], 'X', SORT_ASC, 'id', SORT_ASC);
	echo json_encode($sorted);

	echo ' , "access" : ';
	$sorted = array_orderby($planconfig['access'], 'Y', SORT_ASC, 'id', SORT_ASC);
	echo json_encode($sorted);

	echo ' , "lights" : ';
	$sorted = array_orderby($planconfig['lights'], 'Y', SORT_ASC, 'id', SORT_ASC);
	echo json_encode($sorted);

	echo ' , "alerts" : ';
	echo json_encode($planconfig['alerts']);

	echo ' , "equips" : ';
	$sorted = array_orderby($planconfig['equips'], 'Y', SORT_ASC, 'id', SORT_ASC);
	echo json_encode($sorted);

	echo ' , "heats" : ';
	$sorted = array_orderby($planconfig['heats'], 'X', SORT_ASC, 'id', SORT_ASC);
	echo json_encode($sorted);

	echo ' , "waters" : ';
	$sorted = array_orderby($planconfig['waters'], 'Y', SORT_ASC, 'id', SORT_ASC);
	echo json_encode($sorted);
	
	echo ' , "shortcuts" : ';
	$sorted = array_orderby($planconfig['shortcuts'], 'Y', SORT_ASC, 'id', SORT_ASC);
	echo json_encode($sorted);
	
	echo ' } ';

	
	}

}

function getKodiConfig($planid,$filter)
{
	global $cmd;
	
	$plans = plan::all();
	
	$nbthermo=0;
	$nblight=0;
	$nbacces=0;
	$nbalert=0;
	$nbequip=0;
	$nbginfo=0;
	$nbheat=0;
	$nbwater=0;
	$nbshortcut=0;

	$ginfos = [];
	$thermos= [];
	$access= [];
	$lights= [];
	$alerts= [];
	$lumens= [];
	$equips= [];
	$heats= [];
	$waters= [];
	$shortcuts= [];

	foreach ($plans as $plan) 
	{
		if ( $plan->getPlanHeader_id() == $planid ) 
		{
			if ( $plan->getLink_type() == "eqLogic" )
			{
			
			//&  ( $plan->getLink()->getEqType_name() == 'virtual' ))
			
			$eqparams = $plan->getLink()->getDisplay('parameters'); 
			
			switch ($eqparams['Kodi Type']){
				case "Thermo":
				case "Hygro":
				
					if (($filter == '')|($filter == 'thermo'))
					{
						$thermo['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "TEMPéRATURE" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
							{
								$resultcmd = $cmd->execute();
								$thermo['Value']=$resultcmd;							
							}
						}
						$thermo['id']=$plan->getId();
						$thermo['X']=$plan->getPosition("left");
						$thermo['Y']=$plan->getPosition("top");
						$thermo['Type']=$eqparams['Kodi Type'];
						$thermos[$nbthermo++]=$thermo;
					}
					break;
				
				case "Info":
				
					if (($filter == '')|($filter == 'info'))
					{				
						$ginfo['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
							{
								$resultcmd = $cmd->execute();
								$ginfo['Value']=$resultcmd;							
							}
						}
						$ginfo['id']=$plan->getId();
						$ginfo['X']=$plan->getPosition("left");
						$ginfo['Y']=$plan->getPosition("top");
						$ginfo['Type']=$eqparams['Kodi Type'];
						$ginfos[$nbginfo++]=$ginfo;
					}
					break;
				case "Move":
				case "Flood":
				case "Fire":
				case "Lumen":
					if (($filter == '')|($filter == 'alert'))
					{					
						$alert['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "LUMEN" ) | ( $cmdname == "FLOOD" ) | ( $cmdname == "FIRE" ) | ( $cmdname == "MOVE" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
							{
								$resultcmd = $cmd->execute();
								$alert['Value']= $resultcmd;
							}
						}
						$alert['id']=$plan->getId();
						$alert['X']=$plan->getPosition("left");
						$alert['Y']=$plan->getPosition("top");
						$alert['Type']=$eqparams['Kodi Type'];
						$alerts[$nbalert++]=$alert;
					}
					break;
				case "Light":
					if (($filter == '')|($filter == 'light'))
					{				
						$light['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "ETAT" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
							{
								$resultcmd = $cmd->execute();
								$light['Value']=$resultcmd;							
							}
							
							if (( $cmdname == "ON" ) | ( $cmdname == "ALLUMER" ))
								$light['On']=$cmd->getId();							

							if (( $cmdname == "OFF" ) | ( $cmdname == "ETEINDRE" ))
								$light['Off']=$cmd->getId();							

							
						}
						$light['id']=$plan->getId();
						$light['X']=$plan->getPosition("left");
						$light['Y']=$plan->getPosition("top");
						$lights[$nblight++]=$light;
					}
					break;
				case "Store":
				case "Door":
				case "Window":
				case "Velux":
					if (($filter == '')|($filter == 'acces'))
					{					
						$acces['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname  == "ETAT" ) | ( $cmdname  == "STATUS" ) | ( $cmdname  == "VALUE" ) )
							{
								$resultcmd = $cmd->execute();
								$acces['Value']=$resultcmd;							
							}
							
							if (( $cmdname == "ON" ) | ( $cmdname == "OUVRIR" )| ( $cmdname == "OPEN" ))
								$acces['On']=$cmd->getId();							

							if (( $cmdname == "OFF" ) | ( $cmdname == "FERMER" ) | ( $cmdname == "CLOSE" ))
								$acces['Off']=$cmd->getId();							

							
						}
						$acces['Type']=$eqparams['Kodi Type'];
						$acces['id']=$plan->getId();
						$acces['X']=$plan->getPosition("left");
						$acces['Y']=$plan->getPosition("top");
						$access[$nbacces++]=$acces;
					}
					break;
				case "Frigo":
				case "TV":
				case "Lave-Linge":
				case "Seche-Linge":
				case "Lave-Vaisselle":
				case "Hotte":
				case "Robot-Aspirateur":
				
				case "Equipment":
					if (($filter == '')|($filter == 'equip'))
					{				
						$equip['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname  == "ETAT" ) | ( $cmdname  == "STATUS" ) | ( $cmdname  == "VALUE" ) | ($cmdname  == "PORTE" ) )
							{
								$resultcmd = $cmd->execute();
								$equip['Value']=$resultcmd;							
							}

							if (( $cmdname  == "PARAM1" ) | ( $cmdname  == "TEMPERATURE1" ) )
							{
								$resultcmd = $cmd->execute();
								$equip['Value1']=$resultcmd;	
								$equip['Param1']=$eqparams['Kodi Param1'];	
							}
							
							if (( $cmdname  == "PARAM2" ) | ( $cmdname  == "TEMPERATURE2" ) )
							{
								$resultcmd = $cmd->execute();
								$equip['Value2']=$resultcmd;							
								$equip['Param2']=$eqparams['Kodi Param2'];	
							}						
							
							if (( $cmdname == "ON" )| ( $cmdname  == "START" ) )
								$equip['On']=$cmd->getId();							

							if (( $cmdname == "OFF" )| ( $cmdname  == "STOP" )| ( $cmdname  == "HOME" ) )
								$equip['Off']=$cmd->getId();							

							
						}
						$equip['Type']=$eqparams['Kodi Type'];
						$equip['id']=$plan->getId();
						$equip['X']=$plan->getPosition("left");
						$equip['Y']=$plan->getPosition("top");
						$equips[$nbequip++]=$equip;
					}
					break;
				case "Chauffage":
				case "Clim":
				case "Thermostat":
					if (($filter == '')|($filter == 'heat'))
					{				
						$heat['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname  == "ETAT" ) | ( $cmdname  == "STATUS" ) | ( $cmdname  == "VALUE" ) |( $cmdname == "TEMPéRATURE" ) | ( $cmdname == "CONSIGNE" ) )
							{
								$resultcmd = $cmd->execute();
								$equip['Value']=$resultcmd;							
							}

							if (( $cmdname == "PLUS" )| ( $cmdname  == "UP" ))
								$heat['Up']=$cmd->getId();							

							if (( $cmdname == "MOINS" )| ( $cmdname  == "DOWN" ))
								$heat['Down']=$cmd->getId();							
							
							if ( $cmdname == "ON" )
								$heat['On']=$cmd->getId();							

							if ( $cmdname == "OFF" )
								$heat['Off']=$cmd->getId();							

							
						}
						$heat['Type']=$eqparams['Kodi Type'];
						$heat['id']=$plan->getId();
						$heat['X']=$plan->getPosition("left");
						$heat['Y']=$plan->getPosition("top");
						$heats[$nbheat++]=$heat;
					}
					break;	
				case "Water":
					if (($filter == '')|($filter == 'water'))
					{				
						$water['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "ETAT" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
							{
								$resultcmd = $cmd->execute();
								$water['Value']=$resultcmd;							
							}

							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "DEBIT" ) | ( $cmdname == "FLOW" ) )
							{
								$resultcmd = $cmd->execute();
								$water['Flow']=$resultcmd;							
							}

							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "COUNT" ) | ( $cmdname == "COMPTEUR" ) )
							{
								$resultcmd = $cmd->execute();
								$water['Count']=$resultcmd;							
							}
							
							if (( $cmdname == "ON" ) | ( $cmdname == "ALLUMER" ))
								$water['On']=$cmd->getId();							

							if (( $cmdname == "OFF" ) | ( $cmdname == "ETEINDRE" ))
								$water['Off']=$cmd->getId();							

							
						}
						$water['id']=$plan->getId();
						$water['X']=$plan->getPosition("left");
						$water['Y']=$plan->getPosition("top");
						$waters[$nbwater++]=$water;
					}
					break;	
				
			}
		}
			else if ( $plan->getLink_type() == "scenario" )
			{
				$planscenar = $plan->getLink(); 
				$shortcut['name']=$planscenar->getName();
				$shortcut['run']=$planscenar->getId();
				$shortcut['icon']=$planscenar->getIcon();
				$shortcut['id']=$plan->getId();
				$shortcut['X']=$plan->getPosition("left");
				$shortcut['Y']=$plan->getPosition("top");
				$shortcuts[$nbshortcut++]=$shortcut;

			}
		}
	}

	$planconfig['ginfos'] = $ginfos;
	$planconfig['thermos'] = $thermos;
	$planconfig['access'] = $access;
	$planconfig['lights'] = $lights;
	$planconfig['alerts'] = $alerts;
	$planconfig['lumens'] = $lumens;
	$planconfig['equips'] = $equips;
	$planconfig['heats'] = $heats;
	$planconfig['waters'] = $waters;
	$planconfig['shortcuts'] = $shortcuts;
	
	return ($planconfig);
	
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
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getui&uid=5857b9ed851c3
	
	sendKodi($eqLogic->getConfiguration('plan'));
	
}

if ( init('func') == 'getlights' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getlights&uid=58248a5a41c45
	
	sendKodi($eqLogic->getConfiguration('plan_light'));
	
}

if ( init('func') == 'getacces' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getacces&uid=58248a5a41c45
	
	sendKodi($eqLogic->getConfiguration('plan_security'));
	
}

if ( init('func') == 'gettherms' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=gettherms&uid=58248a5a41c45
	
	sendKodi($eqLogic->getConfiguration('plan_thermo'));
	
}


if ( init('group') == 'light' )
{
	// Get Kodi Config
	
		if ( init('mode') == 'global' )
			$planid = $eqLogic->getConfiguration('plan_light');
		else
			$planid = $eqLogic->getConfiguration('plan');

		$planconfig = getKodiConfig($planid,'light');

		$light='';
		$lights = $planconfig['lights'];
	
	// Get Selected Light
	
		foreach ($lights as $idxlight)
		{
			if ( $idxlight['id']== init('obj') )
			{
				$light = $idxlight;
				break;
			}
		}
		
		if ($light=='' )
		{
			echo 'Light Not Found';
			return;
		}
		
	if ( init('func') == 'switch' )
	{

		if ($light['Value']=='1' )
			$cmdid = $light['Off'];
		else
			$cmdid = $light['On'];

		$cmd = cmd::byId($cmdid);
		$resultcmd = $cmd->execute();
		 echo 'OK';
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
