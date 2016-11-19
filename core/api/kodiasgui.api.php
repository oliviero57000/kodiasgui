<?php


require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";

	
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


if ( init('func') == 'getui' )
{
	// http://192.168.0.38//plugins/kodiasgui/core/api/kodiasgui.api.php?func=getui&uid=58248a5a41c45

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
		else
		{
			
			
		}
	}

	echo ' , "ginfos":';
	echo ( json_encode ($ginfos) );
	
	echo ' ,"lights": [';
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
	
	echo ' ] ,"access": [';
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

	echo ' ] ,"thermos": [';
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
	
	echo ' ] ,"waters": [';
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
	

	echo ' ] }';

}	


return;
?>
