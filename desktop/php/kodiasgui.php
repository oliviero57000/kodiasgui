<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'kodiasgui');
$eqLogics = eqLogic::byType('kodiasgui');
 

?>

<div class="row row-overflow">
	<div class="col-lg-2 col-md-3 col-sm-4">
		<div class="bs-sidebar">
			<ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
				<a class="btn btn-warning " style="width : 100%;margin-top : 5px;margin-bottom: 5px;" href="<?php echo $cpl; ?>/index.php?v=d&p=plugin&id=kodiasgui">
						<i class="fa fa-cogs"></i> {{Configuration du plugin}} 
					</a>   
					<a class="btn btn-warning " style="width : 100%;margin-top : 5px;margin-bottom: 5px;" href="<?php echo $cpl; ?>/index.php?v=d&p=log&logfile=kodiasgui">
							<i class="fa fa-comment"></i> {{Logs du plugin}} 
						</a> 	  
						<a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un Kodi}}</a>
						<li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
						<legend><i class="fa fa-cog"></i> {{General}}</legend>
						<?php
						foreach ($eqLogics as $eqLogic) {
							if ( $eqLogic->getConfiguration('type') == 'shared'  )
							{	
							$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
							echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
							}
						}
						?>
						<legend><i class="fa fa-cog"></i> {{Spécifique}}</legend>
						<?php
						foreach ($eqLogics as $eqLogic) {
							if ( $eqLogic->getConfiguration('type') != 'shared'  )
							{	
							$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
							echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
							}
						}
						?>
						
			</ul>
		</div>
	</div>

			<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
				<legend><i class="fa fa-cog"></i> {{Gestion}}</legend> <!-- changer pour votre type d'équipement -->

				<div class="eqLogicThumbnailContainer">
					<div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
						<center>
							<i class="fa fa-plus-circle" style="font-size : 7em;color:#00979C;"></i>
						</center>
						<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#00979C"><center>Ajouter</center></span>
					</div>
					<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
						<center>
							<i class="fa fa-wrench" style="font-size : 7em;color:#00979C;"></i>
						</center>
						<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#00979C"><center>{{Configuration}}</center></span>
					</div>		
					<div class="cursor eqLogicAction" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
						<a target="_blank" style="text-decoration: none!important;" href="https://www.jeedom.fr/doc/documentation/plugins/kodiasgui/fr_FR/kodiasgui.html">
							<center>
								<i class="fa fa-book" style="font-size : 7em;color:#00979C;"></i>
							</center> 
							<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#00979C"><center>{{Documentation}}</center></span>
						</a>
					</div>			

				</div>

				<legend><i class="fa fa-table"></i> {{Configuration générale aux kodis}}
				</legend>
				<div class="eqLogicThumbnailContainer">
					<?php
				foreach ($eqLogics as $eqLogic) {
					
					if ( $eqLogic->getConfiguration('type') == 'shared'  )
					{
					$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
					echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
					echo "<center>";
					echo '<img src="plugins/kodiasgui/doc/images/kodiasgui_icon.png" height="105" width="95" />';
					echo "</center>";
					echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
					echo '</div>';
					}
				}
				?>
				</div>				
				
				<legend><i class="fa fa-table"></i> {{Configuration spécifique des kodi}}
				</legend>
				<div class="eqLogicThumbnailContainer">
					<?php
				foreach ($eqLogics as $eqLogic) {
					if ( $eqLogic->getConfiguration('type') != 'shared'  )
						{					
						$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
						echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
						echo "<center>";
						echo '<img src="plugins/kodiasgui/doc/images/kodiasgui_icon.png" height="105" width="95" />';
						echo "</center>";
						echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
						echo '</div>';
						}
				}
				?>
				</div>

			</div>

 <!-- Affichage de l'eqLogic sélectionné -->
			<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
								<legend>
									<i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}
									<i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i>
									<a class="btn btn-xs btn-default pull-right eqLogicAction" data-action="copy"><i class="fa fa-files-o"></i> {{Dupliquer}}</a>
								</legend>
		<a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder la configuration}}</a>
		<a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer l'équipement}}</a>
	
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Configuration}}</a></li>
			<li role="presentation"><a href="#cmdInfos" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Infos}}</a></li>
			<li role="presentation"><a href="#cmdLigths" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Lumières}}</a></li>
			<li role="presentation"><a href="#cmdAcces" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Sécurité}}</a></li>
			<li role="presentation"><a href="#cmdTherms" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Chauffages}}</a></li>
			<li role="presentation"><a href="#cmdWaters" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Eau}}</a></li>
			<li role="presentation"><a href="#cmdEquips" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Equipements}}</a></li>
			<li role="presentation"><a href="#cmdShortcuts" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Raccourci}}</a></li>
		</ul>
	
		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">	
			<br>								
								
								
								
        <form class="form-horizontal">
            <fieldset>								
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Nom de l'équipement Kodi}}</label>
									<div class="col-sm-3">
										<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
										<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement networks}}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label" >{{Objet parent}}</label>
									<div class="col-sm-3">
										<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
											<option value="">{{Aucun}}</option>
											<?php
											foreach (object::all() as $object) {
												echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Catégorie}}</label>
									<div class="col-sm-8">
										<?php
										foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
											echo '<label class="checkbox-inline">';
											echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
											echo '</label>';
										}
										?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"></label>
									<div class="col-sm-8">
										<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
										<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Type}}</label>
									<div class="col-sm-3">
										<select id="sel_type" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="type" >
											<option value="notshared">{{Configuration Specifique}}</option>
											<option value="shared">{{Configuration Générale}}</option>
										</select>									
									</div>
								</div>								
								
								<div class="kodi_spec">
								
									<div class="form-group">
										<label class="col-sm-3 control-label">{{UID}}</label>
										<div class="col-sm-3">
											<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="UID" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">{{IP}}</label>
										<div class="col-sm-3">
											<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="IP" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">{{Configuration générale}}</label>
										<div class="col-sm-3">
											<select id="sel_master" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="MasterCfg" >
												<?php
												foreach ($eqLogics as $eqLogic) {
													if ( $eqLogic->getConfiguration('type') == 'shared'  ) {
														echo '<option value="' . $eqLogic->getId() . '">' . $eqLogic->getHumanName() . '</option>';
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>

							</fieldset>
						</form>

					</div>
					
					<div role="tabpanel" class="tab-pane" id="cmdInfos" >
					<br>
					
					<table id="table_cmdinfo" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>{{Information}}</th>
							<th>{{Info STATUS}}</th>
						</tr>
					</thead>					
					<tbody>

					<tr style="background-color : lightgrey;" >
						<td colspan="2" >Messages</td>
					</tr>					
					
					<tr>
						<td>Message general Urgent</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infoMSGURGENT" placeholder="{{Message General URGENT}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infoMSGURGENT" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>
					
					<tr>
						<td>Message general</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infoMSG" placeholder="{{Message General}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infoMSG" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>

					<tr style="background-color : lightgrey;" >
						<td colspan="2" >Alarmes</td>
					</tr>					
					
					<tr>
						<td>Alarme Incendie</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infoFIRE" placeholder="{{Message General URGENT}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infoFIRE" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>					
					
					</tbody>
					</table>
					
					</div>
					
					<div role="tabpanel" class="tab-pane" id="cmdLigths" >
					<br>

					<table id="table_lightinfo" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>{{Information}}</th>
							<th>{{Info STATUS}}</th>
						</tr>
					</thead>					
					<tbody>

					<tr>
						<td>Luminositée</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infoLUMEN" placeholder="{{Capteur Lumen}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infoLUMEN" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>

					</tbody>
					</table>					
					
					<a class="btn btn-primary btn-sm  pull-left" id="bt_addlight"><i class="fa fa-plus-circle"></i> {{Ajouter une lumière}}</a>

					<br/><br/>
					<table id="table_cmdlight" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>{{Nom}}</th>
							<th>{{Type}}</th>
							<th>{{Commande ALLUMER}}</th>
							<th>{{Commande ETEINDRE}}</th>
							<th>{{Info STATUS}}</th>
							<th></th>
						</tr>
					</thead>					
					<tbody>

					</tbody>
					</table>
					
					</div>
					
					<div role="tabpanel" class="tab-pane" id="cmdAcces" >
					<br>

					<table id="table_accesinfo" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>{{Information}}</th>
							<th>{{Info STATUS}}</th>
						</tr>
					</thead>					
					<tbody>

					<tr>
						<td>Detection présence</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infopresent" placeholder="{{Capteur Présence}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infopresent" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>

					</tbody>
					</table>						

					<a class="btn btn-primary btn-sm  pull-left" id="bt_addacces"><i class="fa fa-plus-circle"></i> {{Ajouter un accès}}</a>
					<br/><br/>
					<table id="table_cmdacces" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>{{Nom}}</th>
							<th>{{Type}}</th>
							<th>{{Commande OUVRIR}}</th>
							<th>{{Commande FERMER}}</th>
							<th>{{Info STATUS}}</th>
							<th></th>
						</tr>
					</thead>					
					<tbody>

					</tbody>
					</table>					
					
					</div>
					
					<div role="tabpanel" class="tab-pane" id="cmdTherms" >
					<br>

					<table id="table_therminfo" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>{{Information}}</th>
							<th>{{Info STATUS}}</th>
						</tr>
					</thead>					
					<tbody>
					
					<tr style="background-color : lightgrey;" >
						<td colspan="2" >{{Températures}}</td>
					</tr>	
					
					<tr>
						<td>{{Température pièce}}</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infotempint" placeholder="{{Capteur Tempèrature Intérieur}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infotempint" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>

					<tr>
						<td>{{Température exterieure}}</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infotempext" placeholder="{{Capteur Tempèrature Extérieure}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infotempext" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>

					<tr style="background-color : lightgrey;" >
						<td colspan="2" >{{Humidités}}</td>
					</tr>	
					
					<tr>
						<td>{{Humidité pièce}}</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infohumint" placeholder="{{Capteur Tempèrature Intérieur}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infohumint" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>

					<tr>
						<td>{{Humidité exterieure}}</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infohumext" placeholder="{{Capteur Tempèrature Extérieure}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infohumext" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>
					
					</tbody>
					</table>					

					<a class="btn btn-primary btn-sm  pull-left" id="bt_addtherm"><i class="fa fa-plus-circle"></i> {{Ajouter un chauffage ou une climatisation}}</a>
					<br/><br/>
					<table id="table_cmdtherm" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>{{Nom}}</th>
							<th>{{Type}}</th>
							<th>{{Consigne}}</th>
							<th>{{Info STATUS}}</th>
							<th>{{Commande ON}}</th>
							<th>{{Commande OFF}}</th>
							<th>{{Commande AUTO}}</th>
							<th></th>
						</tr>
					</thead>					
					<tbody>

					</tbody>
					</table>	
					
					</div>					

					<div role="tabpanel" class="tab-pane" id="cmdWaters" >
					<br>

					<table id="table_waterinfo" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>{{Information}}</th>
							<th>{{Info STATUS}}</th>
						</tr>
					</thead>					
					<tbody>
					
					<tr>
						<td>{{Capteur Inondation pièce}}</td>
						<td>
						<input class="eqinfos form-control input-sm" cfg-name="eqinfos_infoflood" placeholder="{{Capteur Inondation pièce}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />
						<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="eqinfos_infoflood" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
						</td>
					</tr>
				
					</tbody>
					</table>					

					<a class="btn btn-primary btn-sm  pull-left" id="bt_addWater"><i class="fa fa-plus-circle"></i> {{Ajouter une alimentation}}</a>

					<br/><br/>
					<table id="table_cmdwater" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>{{Nom}}</th>
							<th>{{Type}}</th>
							<th>{{Info STATUS}}</th>
							<th>{{Commande OUVRIR}}</th>
							<th>{{Commande FERMER}}</th>
							<th>{{Info DEBIT}}</th>
							<th>{{Info CONSO}}</th>
							<th></th>
						</tr>
					</thead>					
					<tbody>

					</tbody>
					</table>	
					
					</div>	

					<div role="tabpanel" class="tab-pane" id="cmdEquips" >
					<br>

					<a class="btn btn-primary btn-sm  pull-left" id="bt_addEquip"><i class="fa fa-plus-circle"></i> {{Ajouter un objet connecté}}</a>
					
					<br/><br/>
					<table id="table_cmdequip" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>{{Nom}}</th>
							<th>{{Type}}</th>
							<th>{{Info STATUS}}</th>
							<th>{{Name 1}}</th>
							<th>{{Info 1}}</th>
							<th>{{Name 2}}</th>
							<th>{{Info 2}}</th>
							<th></th>
						</tr>
					</thead>					
					<tbody>

					</tbody>
					</table>	
					
					</div>	
					
					<div role="tabpanel" class="tab-pane" id="cmdShortcuts" >
					<br>

					<a class="btn btn-primary btn-sm  pull-left" id="bt_addShortcuts"><i class="fa fa-plus-circle"></i> {{Ajouter un raccourci}}</a>
					
					<br/><br/>
						<table id="table_cmdshort" class="table table-bordered table-condensed">
						<thead>
							<tr>
								<th>#</th>
								<th>{{Nom}}</th>
								<th>{{Menu}}</th>
								<th>{{Cmd}}</th>
								<th>{{Info}}</th>
								<th>{{Icon}}</th>
								<th></th>
							</tr>
						</thead>					
						<tbody>

						</tbody>
						</table>						
					</div>
					
				</div>

			</div>
		</div>
		<?php include_file('desktop', 'kodiasgui', 'js', 'kodiasgui');?>
		<?php include_file('core', 'plugin.template', 'js');?>