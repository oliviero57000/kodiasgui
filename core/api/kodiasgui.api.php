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

function callKodi($kodiuser,$kodipwd,$kodiip,$kodiport,$method,$params,$id)
{
	$requestHeader = 'http://'.$kodiuser.':'.$kodipwd.'@'.$kodiip.':'.$kodiport;			
				
	$json = array(
			'id' => $id,
			'jsonrpc' => '2.0',
			'method' => $method,
			'params' => $params
	);			
				
	//$request = urlencode(json_encode($json));
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
								$alert['Value']= getCmdInfo($cmd);
						}
						$alert['id']=$plan->getId();
						$alert['X']=$plan->getPosition("left");
						$alert['Y']=$plan->getPosition("top");
						$alert['Type']=$eqparams['Kodi Type'];
						$alerts[$nbalert++]=$alert;
					}
					break;
				case "Light":
				case "LightDimmer":
				case "LightRGB":
					if (($filter == '')|($filter == 'light'))
					{				
						$light['name']=$eqparams['Kodi Alias'];
						
						$cmds = $plan->getLink()->getCmd();
						foreach ($cmds as $cmd)
						{		
							$cmdname = strtoupper($cmd->getName());
							if (( $cmdname == "ETAT" ) | ( $cmdname == "STATUS" ) | ( $cmdname == "VALUE" ) )
								$light['Value']=getCmdInfo($cmd);							
							
							if (( $cmdname == "ON" ) | ( $cmdname == "ALLUMER" ))
								$light['On']=$cmd->getId();							

							if (( $cmdname == "OFF" ) | ( $cmdname == "ETEINDRE" ))
								$light['Off']=$cmd->getId();							

							
						}
						$light['Type']=$eqparams['Kodi Type'];
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
							if (( $cmdname  == "ETAT" ) | ( $cmdname  == "STATUS" ) | ( $cmdname  == "VALUE" ) | ($cmdname  == "PORTE" ) )
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


if ( ( $uniqueID =='' )& ( init('func') == 'push' ) )
{
	// Internal function PUSH Command
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



if ( init('func') == 'getui' )
{
	sendKodi($eqLogic->getConfiguration('plan'));
}

if ( init('func') == 'getlights' )
{
	sendKodi($eqLogic->getConfiguration('plan_light'));
}

if ( init('func') == 'getacces' )
{
	sendKodi($eqLogic->getConfiguration('plan_security'));
}

if ( init('func') == 'gettherms' )
{
	sendKodi($eqLogic->getConfiguration('plan_thermo'));
}

if ( init('func') == 'getheatmodes' )
{
	$heatconfig = getKodiConfig($eqLogic->getConfiguration('plan'),'heat');
	echo json_encode($heatconfig);
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
		$resultcmd = $cmd->execCmd();
		 echo 'OK';
	}
}

if ( init('group') == 'acces' )
{
	// Get Kodi Config
	
		if ( init('mode') == 'global' )
			$planid = $eqLogic->getConfiguration('plan_security');
		else
			$planid = $eqLogic->getConfiguration('plan');

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
	
}

if ( init('group') == 'heat' )
{
	// log::add('kodiasgui', 'info', 'light command received.');
	
	// Get Kodi Config
	
		if ( init('mode') == 'global' )
			$planid = $eqLogic->getConfiguration('plan_thermo');
		else
			$planid = $eqLogic->getConfiguration('plan');

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
		
}


?>
