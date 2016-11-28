<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version. 
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
if (isset($_GET['id']))
{
	$arduino_board = '';
	if (isset($_GET['board'])) $arduino_board = trim($_GET['board']);
	
	include_file('core', 'jeedouino', 'config', 'jeedouino');
    global $ArduinoMODEpins,$Arduino328pins,$ArduinoMEGApins;
    global $PifaceMODEpinsIN,$PifaceMODEpinsOUT,$Pifacepins;
    global $PiGPIOpins,$PiGPIO26pins,$PiGPIO40pins;
	global $ESP8266pins,$ESP01pins,$ESP07pins,$espMCU01pins;
	global $PiPluspins,$PiPlus16pins;
    
	$arduino_id=$_GET['id'];
	$my_arduino = eqLogic::byid($arduino_id);		
	$ModeleArduino = $my_arduino->getConfiguration('arduino_board'); 
	$PortArduino = $my_arduino->getConfiguration('datasource'); 
	$LocalArduino = $my_arduino->getConfiguration('arduinoport'); 
	$IPArduino = $my_arduino->getConfiguration('iparduino'); 	
	
	// On verifie que l'utilisateur n'a pas changé de modèle de carte après la 1ère sauvegarde sans resauver derrière.
	if ($arduino_board != '')
	{
		if ($arduino_board != $ModeleArduino) $ModeleArduino = $arduino_board;
	}
	$non_defini=true;
	if ($ModeleArduino != '')
	{

		if ($PortArduino=='rj45arduino') $message_a=' réseau sur IP : '.$IPArduino.'. ';
		elseif ($PortArduino=='usbarduino')
		{
			$message_a=' USB ';
			if ($LocalArduino=='usblocal') $message_a.=' sur port local. ';
			elseif ($LocalArduino=='usbdeporte') $message_a.=' sur port déporté. ';
			else 
			{
				$non_defini=false;
				$message_a.=' NON DEFINI ! ';
			}
		}
		else 
		{
			$non_defini=false;
			$message_a=' NON DEFINI ! ';
		}
	}
	else 
	{
		$non_defini=false;
		$message_a=' NON DEFINI ! ';
	}
	
	
	if ($non_defini)
	{

?>

<div class="tab-content" id="backup_pins" >
			<div id='div_alertpins' style="display: none;"></div>
			<div class="form-group"  style="    ">	
				<label class="col-sm-4 control-label ">Paramétrage des pins de l'arduino/esp/rpi <?php echo $message_a; ?></label>
				<div class="col-sm-8">
					<a class="btn btn-success pull-right" id="bt_savebackup_pins" title="Pensez à sauver l'équipement pour envoyer la config à la carte">* Sauvegarde</a>
				</div>
			</div>	
				<div class="form-group col-sm-10">	 
				</div>		
				<?php if (substr($ModeleArduino,0,2)!='pi')
				{
				?>	
                <div class="form-group">	 
                    <label class="col-sm-4 control-label "><p class="hidden-xs"><br/>{{Choix de sauvegarde de l'état des pins suite a un redémarrage de l'Arduino/esp (Coupure de courant, reset,etc...)}}</p></label>
                    <div class="col-sm-8">
						<?php
							if (config::byKey($arduino_id.'_choix_boot', 'jeedouino', 'none')!='none') $message_a='';
							else $message_a=' selected ';
							
							echo '<br><br>';
							echo '<select class="form-control  configKeyPins" data-l1key="'.$arduino_id.'_choix_boot">';
							echo '<option value="0">{{Pas de sauvegarde - Toutes les pins sorties non modifiées au démarrage.}}</option>';
							echo '<option value="1">{{Pas de sauvegarde - Toutes les pins sorties mises à LOW au démarrage.}}</option>';
							echo '<option value="2">{{Pas de sauvegarde - Toutes les pins sorties mises à HIGH au démarrage.}}</option>';
							echo '<option value="3" class="text-success"'.$message_a.'>{{Sauvegarde sur JEEDOM - Toutes les pins sorties mises suivant leur sauvegarde dans Jeedom. Lent, Jeedom requis sinon pins mises à HIGH.}}</option>';
							echo '<option value="5" class="text-success">{{Sauvegarde sur JEEDOM - Toutes les pins sorties mises suivant leur sauvegarde dans Jeedom. Lent, Jeedom requis sinon pins mises à LOW.}}</option>';
							echo '<option value="4" class="text-danger">{{Sauvegarde sur EEPROM- Toutes les pins sorties mises suivant leur sauvegarde dans l\'EEPROM. Autonome, rapide mais durée de vie de l\'eeprom fortement réduite.}}</option>';

							echo '</select>';
						 ?>
					<br>
                    </div>
                </div>		
				<?php
				}
				elseif (substr($ModeleArduino,0,6)=='piGPIO')
				{
				?>	
                <div class="form-group">	 
                    <label class="col-sm-4 control-label "><p class="hidden-xs"><br/>{{Choix de l'état des pins sorties au démarrage du démon piGPIO. (En tests)}}</p></label>
                    <div class="col-sm-8">
						<?php
							if (config::byKey($arduino_id.'_piGPIO_boot', 'jeedouino', 'none')!='none') $message_a='';
							else $message_a=' selected ';
							
							echo '<br><br>';
							echo '<select class="form-control  configKeyPins" data-l1key="'.$arduino_id.'_piGPIO_boot">';
							echo '<option value="0" '.$message_a.'>{{Toutes les pins sorties mises à LOW au démarrage.du démon}}</option>';
							echo '<option value="1">{{Toutes les pins sorties mises à HIGH au démarrage.du démon}}</option>';
							echo '</select>';
						 ?>
					<br>
                    </div>
                </div>		
				<?php
				}
				?>
            <table class="table table-bordered table-condensed tablesorter">
                <thead>
                <tr>
                    <th>{{Arduino/ESP/RPI  Pins}}</th><th>{{Fonctions}}</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $Arduino_pins = '';
                switch ($ModeleArduino)
				{
                    case 'auno':
                    case 'a2009':
                    case 'anano':
                    case 'auno':
                        $Arduino_pins = $Arduino328pins;
                        break;
                    case 'a1280':
                    case 'a2560':
                        $Arduino_pins = $ArduinoMEGApins;
                        break;   
                    case 'piface':
                        $Arduino_pins = $Pifacepins;
                        break;  
                    case 'piGPIO26':
                        $Arduino_pins = $PiGPIO26pins;
                        break;   
                    case 'piGPIO40':
                        $Arduino_pins = $PiGPIO40pins;
                        break;  
					case 'piPlus':
						$Arduino_pins = $PiPlus16pins;
						break;  							
					case 'esp01':
						$Arduino_pins = $ESP01pins;
						break;   
					case 'esp07':
						$Arduino_pins = $ESP07pins;
						break;  		
					case 'espMCU01':
						$Arduino_pins = $espMCU01pins;
						break;  							
					default:	
						$Arduino_pins = '';
					break;		                        
                }


				foreach ($Arduino_pins as $pins_id => $pin_datas) 
				{
                    echo '<tr class="pinoche" data-logicalId="'.$pins_id.'">';
                    if ($pin_datas['option']!='') echo '<td>'.$pin_datas['Nom_pin'].' - ( '.$pin_datas['option'].' ) </td>';
                    else echo '<td>'.$pin_datas['Nom_pin'].'</td>';                    	                    
					
					// pins non disponibles
					if ($pin_datas['disable']=='1')
					{
						echo '<td><input disabled class="form-control configKeyPins" name="'.$arduino_id.'_'.$pins_id.'" value="{{Pin réservée !}}"></td>';    
						continue;
					}
					// pins reservee au pour la carte ethernet sur arduino
					if (($PortArduino=='rj45arduino') and ($pin_datas['ethernet']=='1')) 
					{
						echo '<td><input disabled class="form-control configKeyPins" name="'.$arduino_id.'_'.$pins_id.'" value="{{Pin réservée pour le shield ethernet !}}"></td>';    
						continue;						
					}
					
					$InfoPins = array();
					$ActionPins = array();
					$OtherPins = array();
					echo '<td>';
					echo '<select class="form-control  configKeyPins" data-l1key="'.$arduino_id.'_'.$pins_id.'">';
                    if ($ModeleArduino=='piface')
                    {
                        if ($pin_datas['option']!='IN')
                        {
                            foreach ($PifaceMODEpinsOUT as $mode_value => $mode_name) 
                            {
                                $ActionPins[] = '<option value="'.$mode_value.'">{{'.$mode_name.'}}</option>';
                            }                 
                        }   
                        else
                        {
                            foreach ($PifaceMODEpinsIN as $mode_value => $mode_name) 
                            {
                                $InfoPins[] = '<option value="'.$mode_value.'">{{'.$mode_name.'}}</option>';
                            }                 
                        }    
                    }
                    else if ($ModeleArduino=='piGPIO26' or $ModeleArduino=='piGPIO40' )
                    {              
						foreach ($PiGPIOpins as $mode_value => $mode_name) 
						{
							if (substr($mode_name,0,1)=='i') $InfoPins[] = '<option value="'.$mode_value.'">{{'.substr($mode_name,1).'}}</option>';
							elseif (substr($mode_name,0,1)=='o') $ActionPins[] = '<option value="'.$mode_value.'">{{'.substr($mode_name,1).'}}</option>';
							else $OtherPins[] = '<option value="'.$mode_value.'">{{'.$mode_name.'}}</option>';
						}
                    }
                    else if ($ModeleArduino=='piPlus')
                    {
						foreach ($PiPluspins as $mode_value => $mode_name) 
						{
							if (substr($mode_name,0,1)=='i') $InfoPins[] = '<option value="'.$mode_value.'">{{'.substr($mode_name,1).'}}</option>';
							elseif (substr($mode_name,0,1)=='o') $ActionPins[] = '<option value="'.$mode_value.'">{{'.substr($mode_name,1).'}}</option>';
							else $OtherPins[] = '<option value="'.$mode_value.'">{{'.$mode_name.'}}</option>';
						}                      
                    }					
                    else if ($ModeleArduino=='esp01' or $ModeleArduino=='esp07' or $ModeleArduino=='espMCU01' )
                    {
						if ($pin_datas['option']!='ANA')
						{
							foreach ($ESP8266pins as $mode_value => $mode_name) 
							{
								if (($pin_datas['option']=='R/W') and ($mode_value=='pwm_output')) continue;
								if (substr($mode_name,0,1)=='i') $InfoPins[] = '<option value="'.$mode_value.'">{{'.substr($mode_name,1).'}}</option>';
								elseif (substr($mode_name,0,1)=='o') $ActionPins[] = '<option value="'.$mode_value.'">{{'.substr($mode_name,1).'}}</option>';
								else $OtherPins[] = '<option value="'.$mode_value.'">{{'.$mode_name.'}}</option>';
							}
						}
						else
						{
							// pinoche analogique ADC = A0
							$OtherPins[] = '<option value="not_used">{{Non utilisée}}</option>';
							$OtherPins[] = '<option value="analog_input">{{Entrée Analogique}}</option>';			
						}							
					}   
                    else
                    {
						if ($pin_datas['option']!='ANA')
						{
							foreach ($ArduinoMODEpins as $mode_value => $mode_name) 
							{							
								if (substr($mode_name,0,1)=='i') $InfoPins[] = '<option value="'.$mode_value.'">{{'.substr($mode_name,1).'}}</option>';
								elseif (substr($mode_name,0,1)=='o') $ActionPins[] = '<option value="'.$mode_value.'">{{'.substr($mode_name,1).'}}</option>';
								else $OtherPins[] = '<option value="'.$mode_value.'">{{'.$mode_name.'}}</option>';						
							}
							if (substr($pin_datas['option'],0,3)=='PWM') $ActionPins[] ='<option value="pwm_output">{{Sortie PWM}}</option>';
						}
						else
						{
							// pinoches analogiques
							$OtherPins[] = '<option value="not_used">{{Non utilisée}}</option>';
							$OtherPins[] = '<option value="analog_input">{{Entrée Analogique}}</option>';
							$ActionPins[] = '<option value="output">{{Sortie Numérique}}</option>';								 								 
						}
                    }
					foreach ($OtherPins as $pins_option) echo $pins_option;
					$options = '';
					foreach ($ActionPins as $pins_option) $options .= $pins_option;
					if ($options != '')
					{
						echo '<optgroup label="{{Sorties Numériques (action)}}">';
						echo $options;
						echo '</optgroup>';
					}					
					$options = '';
					foreach ($InfoPins as $pins_option) $options .= $pins_option;
					if ($options != '')
					{
						echo '<optgroup label="{{Entrées Numériques (info)}}">';
						echo $options;
						echo '</optgroup>';
					}
					echo '</select>';
					echo '<span class="HC_trigger hide"><i class="fa fa-arrow-right"></i> {{Pensez à selectionner la pin Echo.}}</span>';
					echo '</td>';
                    echo '</tr>';
				}
                ?>
                </tbody>
            </table>
</div>
<script>
	$('.configKeyPins').on('change',function(){
		if ($(this).value()=='trigger')
		{
			$('.HC_trigger').show();
		}
		else
		{
			$('.HC_trigger').hide();
		}
	});
	// jeedom.backup_class.js
	$("#bt_savebackup_pins").on('click', function (event) {
		//$.hideAlert();
		jeedom.config.save({
			configuration: $('#backup_pins').getValues('.configKeyPins')[0],
			error: function (error) {
				$('#div_alertpins').showAlert({message: error.message, level: 'danger'});
			},
			success: function () {
				jeedom.config.load({
					configuration: $('#backup_pins').getValues('.configKeyPins')[0],
					plugin: 'jeedouino',
					error: function (error) {
						$('#div_alertpins').showAlert({message: error.message, level: 'danger'});
					},
					success: function (data) {
						$('#backup_pins').setValues(data, '.configKeyPins');
						modifyWithoutSave = false;
						$('#md_modal').dialog('close');
						$('#div_alert').showAlert({message: '{{Paramétrages réussis. /!\ Pensez à sauver l\'équipement ensuite pour envoyer la config à la carte et (re)générer les commandes).}}', level: 'warning'});
					}
				});
			}
		});
		$.ajax({// fonction permettant de faire de l'ajax
			type: "POST", // methode de transmission des données au fichier php
			url: "core/ajax/config.ajax.php", // url du fichier php
			data: {
				action: 'addKey',
				value: json_encode($('#backup_pins').getValues('.configKeyPins')[0]),
				plugin: 'jeedouino',
			},
			dataType: 'json',
			error: function (request, status, error) {
				handleAjaxError(request, status, error);
			},
			success: function (data) { // si l'appel a bien fonctionné
			if (data.state != 'ok') {
				$('#div_alertpins').showAlert({message: data.result, level: 'danger'});
				return;
			}
//			$('#md_modal').dialog('close');
			$('#jqueryLoadingDiv').hide();		// A surveiller, élimine la "roue" qui tourne mais laisse celle lors de la sauvegarde de équipement. bug ??
			
			modifyWithoutSave = false;
		}
		});		
		//$('#md_modal').dialog('close');
		//$('#jqueryLoadingDiv').hide();
	});
	
	jeedom.config.load({
		configuration: $('#backup_pins').getValues('.configKeyPins')[0],
		plugin: 'jeedouino',
		error: function (error) {
			$('#div_alertpins').showAlert({message: error.message, level: 'danger'});
		},
		success: function (data) {
			$('#backup_pins').setValues(data, '.configKeyPins');
			modifyWithoutSave = false;
			//$('#div_alertpins').showAlert({message: '{{Sauvegarde réussie}}', level: 'success'});
		}
	});
		
	
   initTableSorter();
</script>
<?php
	}
	else
	{
		?>
		<div class="alert alert-danger">
			<center><h4>{{Pré-requis}}</h4>
			{{Veuillez finir de configurer l'équipement et le sauvegarder avant de pouvoir configurer les pins de celui-ci}}
			</center>
		</div>
		<?php
	}
}
else echo " !!! Il y a eu un problème. Veuillez re-sauvegarder l'équipement puis réessayer.";
?>