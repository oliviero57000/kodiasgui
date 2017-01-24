<?php

require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";


function getCmdInfo($cd)
{
	$resultcmd = $cd->execCmd(null,1,false);
	
	if ($resultcmd == null )
		$resultcmd = $cd->execute();
	
	if ( is_string($resultcmd) )
		return $resultcmd;
	else
		return (string)$resultcmd;
}	


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

function callKodi($kodiuser,$kodipwd,$kodiip,$kodiport,$method,$params,$id)
{
	$requestHeader = 'http://'.$kodiuser.':'.$kodipwd.'@'.$kodiip.':'.$kodiport;			
				
	$json = array(
			'id' => $id,
			'jsonrpc' => '2.0',
			'method' => $method,
			'params' => $params
	);			
				
	$request = json_encode($json);
	$url = $requestHeader . "/jsonrpc?request=".$request;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	$response = curl_exec($ch);
	
	if ($response === false) 
		return '';
	else
		return $response;
	
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

	echo ' , "planid" : "'.$planid.'" , "plan" : "'.$planHeader->getName().'" , "image" : "'.$filename.'" ';

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
			
			$eqparams = $plan->getLink()->getDisplay('parameters'); 
			
			switch ($eqparams['Kodi Type']){
				case "Thermometre":
				case "Hygrometre":
				
					if (($filter == '')|($filter == 'thermo'))
					{
						$thermo['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "TEMPéRATURE" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
								$thermo['Value']=getCmdInfo($cmd);
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
								$ginfo['Value']=getCmdInfo($cmd);
						}
						$ginfo['id']=$plan->getId();
						$ginfo['X']=$plan->getPosition("left");
						$ginfo['Y']=$plan->getPosition("top");
						$ginfo['Type']=$eqparams['Kodi Type'];
						$ginfos[$nbginfo++]=$ginfo;
					}
					break;
				case "Presence":
				case "Innondation":
				case "Feu":
				case "Luminosite":
					if (($filter == '')|($filter == 'alert'))
					{					
						$alert['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "LUMEN" ) | ( $cmdname == "FLOOD" ) | ( $cmdname == "FIRE" ) | ( $cmdname == "MOVE" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
								$alert['Value']= getCmdInfo($cmd);
						}
						$alert['id']=$plan->getId();
						$alert['X']=$plan->getPosition("left");
						$alert['Y']=$plan->getPosition("top");
						$alert['Type']=$eqparams['Kodi Type'];
						$alerts[$nbalert++]=$alert;
					}
					break;
				case "Lumiere":
				case "LumiereDimmer":
				case "LumiereRGB":
					if (($filter == '')|($filter == 'light'))
					{				
						$light['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						$Color_Red = 255;							
						$Color_Green = 255;							
						$Color_Blue = 255;							
						$nbmode=0;
						$light['Mode']="";
						$light['Modes']=[];
						$Intensity=100;
						
						foreach ($cmds as $cmd)
						{	
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "ETAT" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
								$light['Value']=getCmdInfo($cmd);							
							
							if (( $cmdname == "ON" ) | ( $cmdname == "ALLUMER" ))
								$light['On']=$cmd->getId();							

							if (( $cmdname == "OFF" ) | ( $cmdname == "ETEINDRE" ))
								$light['Off']=$cmd->getId();							

							if ( $cmdname == "COLORRED" )
								$Color_Red = getCmdInfo($cmd);							
							if ( $cmdname == "COLORGREEN" )
								$Color_Green = getCmdInfo($cmd);							
							if ( $cmdname == "COLORBLUE" )
								$Color_Blue = getCmdInfo($cmd);							
							if ( $cmdname == "INTENSITY" )
								$Intensity = getCmdInfo($cmd);							
							if ( $cmdname == "MODE" )
								$light['Mode']= getCmdInfo($cmd);							
							if ( substr($cmdname,0,5) == "MODE_" )
								$light['Modes'][$nbmode++] = substr($cmd->getName(),5);					
							
						}

						$light['Color'] = sprintf('0xFF%02X%02X%02X',$Color_Red,$Color_Green,$Color_Blue);
						$light['Intensity'] = $Intensity;
						$light['Type']=$eqparams['Kodi Type'];
						$light['id']=$plan->getId();
						$light['X']=$plan->getPosition("left");
						$light['Y']=$plan->getPosition("top");
						$lights[$nblight++]=$light;
					}
					break;
				case "Store":
				case "Porte":
				case "Fenetre":
				case "Velux":
					if (($filter == '')|($filter == 'acces'))
					{					
						$acces['name']=$eqparams['Kodi Alias'];
						$acces['StopClose']="";
						$acces['StopOpen']="";
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname  == "ETAT" ) | ( $cmdname  == "STATUS" ) | ( $cmdname  == "VALUE" ) )
								$acces['Value']=getCmdInfo($cmd);						
							
							if (( $cmdname == "ON" ) | ( $cmdname == "OUVRIR" )| ( $cmdname == "OPEN" ))
								$acces['Open']=$cmd->getId();							

							if (( $cmdname == "OFF" ) | ( $cmdname == "FERMER" ) | ( $cmdname == "CLOSE" ))
								$acces['Close']=$cmd->getId();							

							if (($cmdname == "STOPOUVRIR") | ( $cmdname == "STOPOPEN" ))
								$acces['StopOpen']=$cmd->getId();							

							if (($cmdname == "STOPFERMER" ) | ( $cmdname == "STOPCLOSE"))
								$acces['StopClose']=$cmd->getId();							
							
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
								$equip['Value']=getCmdInfo($cmd);							

							if (( $cmdname  == "PARAM1" ) | ( $cmdname  == "TEMPERATURE1" ) )
							{
								$equip['Value1']=getCmdInfo($cmd);	
								$equip['Param1']=$eqparams['Kodi Param1'];	
							}
							
							if (( $cmdname  == "PARAM2" ) | ( $cmdname  == "TEMPERATURE2" ) )
							{
								$equip['Value2']=getCmdInfo($cmd);							
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

				case "Thermostat":
					if (($filter == '')|($filter == 'heat'))
					{				
						$heat['name']=$eqparams['Kodi Alias'];
						$nbmode=0;
						$heatmodes= [];
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname  == "ETAT" ) | ( $cmdname  == "STATUT" ) | ( $cmdname  == "STATUS" ) )
								$heat['Value']=getCmdInfo($cmd);							
							else if ( $cmdname  == "MODE" ) 
								$heat['Mode']=getCmdInfo($cmd);							
							else if ( $cmdname == "CONSIGNE" ) 
								$heat['Consigne']= getCmdInfo($cmd);							
							else if ( $cmdname == "ON" )
								$heat['On']=$cmd->getId();							
							else if ( $cmdname == "OFF" )
								$heat['Off']=$cmd->getId();							
							else
							{
								$cmdeqlid = $cmd->getLogicalId();
							
								if ( $cmdeqlid == "modeAction")
									$heatmodes[$cmd->getName()]=$cmd->getId();	
							}
						}
						$heat['Type']=$eqparams['Kodi Type'];
						$heat['id']=$plan->getId();
						$heat['X']=$plan->getPosition("left");
						$heat['Y']=$plan->getPosition("top");
						$heat['Modes']=$heatmodes;
						$heats[$nbheat++]=$heat;
					}
					break;	
				case "Eau":
					if (($filter == '')|($filter == 'water'))
					{				
						$water['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "ETAT" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
							{
								$resultcmd = $cmd->execCmd();
								$water['Value']=$resultcmd;							
							}

							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "DEBIT" ) | ( $cmdname == "FLOW" ) )
							{
								$resultcmd = $cmd->execCmd();
								$water['Flow']=$resultcmd;							
							}

							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "COUNT" ) | ( $cmdname == "COMPTEUR" ) )
							{
								$resultcmd = $cmd->execCmd();
								$water['Count']=$resultcmd;							
							}
							
							if (( $cmdname == "ON" ) | ( $cmdname == "OUVRIR" ))
								$water['On']=$cmd->getId();							

							if (( $cmdname == "OFF" ) | ( $cmdname == "FERMER" ))
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

// -------------------------------------------- MAIN

$accessgranted = false;	
	
$eqLogics = eqLogic::byType('kodiasgui');
$uniqueID =  init('uid');
$granted="unknown";

// Internal function PUSH Command

if ( ( $uniqueID =='' )& ( init('func') == 'push' ) )
{
	
	$callargs['_function'] ='push';
	$callparam['wait'] = false;
	$callparam['addonid'] = 'script.jeedomgui';
	$callparam['params'] = $callargs;
	foreach ($eqLogics as $eqLogic) 
	{
		// TODO test if kodi is alive ..

		$result = callKodi($eqLogic->getConfiguration('Login'),$eqLogic->getConfiguration('Password'),$eqLogic->getConfiguration('IP'),$eqLogic->getConfiguration('Port'),'Addons.ExecuteAddon',$callparam,1);
	}
	
	echo $result;
	return;
}

// Authenticate Kodi

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
	// Manage Hello Test function 

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

// PROCESS API get Commands

switch (init('func')){
	case "getui":
		sendKodi($eqLogic->getConfiguration('plan_home'));
	break;

	case "getlights":
		sendKodi($eqLogic->getConfiguration('plan_light'));
	break;
	
	case "getacces":
		sendKodi($eqLogic->getConfiguration('plan_security'));
	break;

	case "gettherms":
		sendKodi($eqLogic->getConfiguration('plan_thermo'));
	break;
	
	case "getheatmodes":
		$heatconfig = getKodiConfig($eqLogic->getConfiguration('plan_home'),'heat');
		echo json_encode($heatconfig);
	break;
}

// PROCESS API group Commands

switch (init('group')){
	case "light":
		// Get Kodi Config
		
			if ( init('mode') == 'global' )
				$planid = $eqLogic->getConfiguration('plan_light');
			else
				$planid = $eqLogic->getConfiguration('plan_home');

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
			$resultcmd = $cmd->execCmd();
			 echo 'OK';
		}
		
		if ( init('func') == 'on' )
		{
			$cmdid = $light['On'];
			$cmd = cmd::byId($cmdid);
			$resultcmd = $cmd->execCmd();
			 echo 'OK';
		}
		
		if ( init('func') == 'off' )
		{
			$cmdid = $light['Off'];
			$cmd = cmd::byId($cmdid);
			$resultcmd = $cmd->execCmd();
			 echo 'OK';
		}
		
		if ( init('func') == 'setcolor' )
		{
			
			// Set Light Color   -> Param = color in format 0xFFFFFFFF  argb
			$newcolor = init('param');
			//$cmdid = $heat['Modes'][init('param')];
			//$cmd = cmd::byId($cmdid);
			//$resultcmd = $cmd->execCmd();			
				
			echo 'OK';				
		}	

	
	break;
	
	case "acces":
		// Get Kodi Config
	
		if ( init('mode') == 'global' )
			$planid = $eqLogic->getConfiguration('plan_security');
		else
			$planid = $eqLogic->getConfiguration('plan_home');

		$planconfig = getKodiConfig($planid,'acces');

		$acces='';
		$access = $planconfig['access'];
	
		// Get Selected Access Object
	
		foreach ($access as $idxacces)
		{
			if ( $idxacces['id']== init('obj') )
			{
				$acces = $idxacces;
				break;
			}
		}
		
		if ($acces=='' )
		{
			echo 'Acces Object Not Found';
			return;
		}	
		
		if ( init('func') == 'switch' )
		{
			/* Possible Value
				0 = Open
				1 = Closed
				2 = Move to Open
				3 = Move to Close
			*/
 
			if ($acces['Value']=='0' )
				$cmdid = $acces['Close'];
			else if ($acces['Value']=='1' )
				$cmdid = $acces['Open'];
			else if ($acces['Value']=='2' )
				{
					if ($acces['StopOpen']!='')
					{
						$cmd = cmd::byId($cmdid);
						$resultcmd = $cmd->execCmd();
					}
					$cmdid = $acces['Close'];
				}
			else
				{
					if ($acces['StopClose']!='')
					{
						$cmd = cmd::byId($cmdid);
						$resultcmd = $cmd->execCmd();
					}
					$cmdid = $acces['Open'];
				}
			
			$cmd = cmd::byId($cmdid);
			$resultcmd = $cmd->execCmd();
			echo 'OK';
		}

	break;
	
	case "heat":

		// log::add('kodiasgui', 'info', 'light command received.');
	
		// Get Kodi Config
	
		if ( init('mode') == 'global' )
			$planid = $eqLogic->getConfiguration('plan_thermo');
		else
			$planid = $eqLogic->getConfiguration('plan_home');

		$planconfig = getKodiConfig($planid,'heat');

		$heats = $planconfig['heats'];
	
		// Get Selected Heat Object
	
		$idxheat = init('obj');
		$heat = $heats[$idxheat];
		
		if ($heat=='' )
		{
			echo 'Heat Object Not Found';
			return;
		}	
		
		if ( init('func') == 'setmode' )
		{
			
			// Set Thermostat Mode   -> Param = new mode
			$newmode = init('param');
			if ( $newmode != 'Manuel')
				{
				$cmdid = $heat['Modes'][init('param')];
				$cmd = cmd::byId($cmdid);
				$resultcmd = $cmd->execCmd();			
				}
		}

		if ( init('func') == 'off' )
		{
			// Stop
			$cmdid = $heat['Off'];
			$cmd = cmd::byId($cmdid);
			$resultcmd = $cmd->execCmd();			
		}
		
	break;
	
}


?>
