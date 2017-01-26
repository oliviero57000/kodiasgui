<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'kodiasgui');
$eqLogics = eqLogic::byType('kodiasgui');
$planHeaders = planHeader::all();

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
						<legend><i class="fa fa-cog"></i> {{Kodi}}</legend>
						<?php
						foreach ($eqLogics as $eqLogic) {
							$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
							echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
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

				<legend><i class="fa fa-table"></i> {{Configuration}}
				</legend>
				<div class="eqLogicThumbnailContainer">
					<?php
				foreach ($eqLogics as $eqLogic) {
						$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
						echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
						echo "<center>";
						echo '<img src="plugins/kodiasgui/doc/images/kodiasgui_icon.png" height="105" width="95" />';
						echo "</center>";
						echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
						echo '</div>';
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
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Configuration}}</a></li>
			<li role="presentation"><a href="#cmdHome" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Accueil}}</a></li>
			<li role="presentation"><a href="#cmdInfos" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Infos}}</a></li>
			<li role="presentation"><a href="#cmdLigths" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Lumières}}</a></li>
			<li role="presentation"><a href="#cmdAcces" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Sécurité}}</a></li>
			<li role="presentation"><a href="#cmdTherms" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Chauffages}}</a></li>
			<li role="presentation"><a href="#cmdEquip" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Machines}}</a></li>
		</ul>

		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">	
			<br>								
								
								
								
        <form class="form-horizontal">
            <fieldset>								
								<div class="form-group">
									<label class="col-sm-2 control-label">{{Nom de l'équipement Kodi}}</label>
									<div class="col-sm-2">
										<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
										<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement networks}}"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" >{{Objet parent}}</label>
									<div class="col-sm-2">
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
									<label class="col-sm-2 control-label">{{Catégorie}}</label>
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
									<label class="col-sm-2 control-label"></label>
									<div class="col-sm-8">
										<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
										<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
									</div>
								</div>
						
								
							<div class="form-group">
								<label class="col-sm-2 control-label">{{UID}}</label>
								<div class="col-sm-2">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="UID" readonly />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{{IP}}</label>
								<div class="col-sm-2">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="IP" readonly />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">{{Port}}</label>
								<div class="col-sm-2">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="Port" placeholder="{{Port}}" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">{{Login}}</label>
								<div class="col-sm-2">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="Login" placeholder="{{Login}}" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">{{Password}}</label>
								<div class="col-sm-2">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="Password" placeholder="{{Password}}" />
								</div>
							</div>							

						
						
							
							</fieldset>
						</form>

					</div>
	
			<div role="tabpanel" class="tab-pane" id="cmdHome" >

							
					<div class="form-group">
						<label class="col-sm-2 control-label">{{Design de configuration de l'acceuil}}</label>
						<div class="col-sm-2">
							<select id="sel_plan_home" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="plan_home" >
								<option value="" >{{Aucun}}</option>
								<?php
								foreach ($planHeaders as $plan) {
										echo '<option value="' . $plan->getId() . '">' . $plan->getName() . '</option>';
								}
								?>
							</select>
						</div>
					</div>

							
				<table id="table_cmdhome" class="table table-bordered table-condensed">

				<thead>
					<tr>
						<th>#</th>
						<th>{{Equipement}}</th>
						<th>{{Alias}}</th>
						<th>{{Type}}</th>
						<th></th>
					</tr>
				</thead>					

				<tbody>
				</tbody>

				</table>
							
			
			</div>
	
			<div role="tabpanel" class="tab-pane" id="cmdInfos" >
			
			
				<div class="form-group">
					<label class="col-sm-2 control-label">{{Design de configuration de l'écran infos}}</label>
					<div class="col-sm-2">
						<select id="sel_plan_info" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="plan_info" >
							<option value="" >{{Aucun}}</option>
							<?php
							foreach ($planHeaders as $plan) {
									echo '<option value="' . $plan->getId() . '">' . $plan->getName() . '</option>';
							}
							?>
						</select>
					</div>
				</div>
			
				<table id="table_cmdinfo" class="table table-bordered table-condensed">

				<thead>
					<tr>
						<th>#</th>
						<th>{{Equipement}}</th>
						<th>{{Alias}}</th>
						<th>{{Type}}</th>
						<th></th>
					</tr>
				</thead>					

				<tbody>
				</tbody>

				</table>
			
			</div>
	
			<div role="tabpanel" class="tab-pane" id="cmdLigths" >

				<div class="form-group">
					<label class="col-sm-2 control-label">{{Design de configuration de l'éclairages}}</label>
					<div class="col-sm-2">
						<select id="sel_plan_light" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="plan_light" >
							<option value="" >{{Aucun}}</option>
							<?php
							foreach ($planHeaders as $plan) {
									echo '<option value="' . $plan->getId() . '">' . $plan->getName() . '</option>';
							}
							?>
						</select>
					</div>
				</div>


				<table id="table_cmdlight" class="table table-bordered table-condensed">

				<thead>
					<tr>
						<th>#</th>
						<th>{{Equipement}}</th>
						<th>{{Alias}}</th>
						<th>{{Type}}</th>
						<th></th>
					</tr>
				</thead>					

				<tbody>
				</tbody>

				</table>

				
			</div>
	
			<div role="tabpanel" class="tab-pane" id="cmdAcces" >

				<div class="form-group">
								<label class="col-sm-2 control-label">{{Design de configuration de la sécurité}}</label>
								<div class="col-sm-2">
									<select id="sel_plan_security" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="plan_security" >
									<option value="" >{{Aucun}}</option>
										<?php
										foreach ($planHeaders as $plan) {
												echo '<option value="' . $plan->getId() . '">' . $plan->getName() . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							
				<table id="table_cmdacces" class="table table-bordered table-condensed">

				<thead>
					<tr>
						<th>#</th>
						<th>{{Equipement}}</th>
						<th>{{Alias}}</th>
						<th>{{Type}}</th>
						<th></th>
					</tr>
				</thead>					

				<tbody>
				</tbody>

				</table>			
			</div>
	
			<div role="tabpanel" class="tab-pane" id="cmdTherms" >

				<div class="form-group">
					<label class="col-sm-2 control-label">{{Design de configuration du chauffages}}</label>
					<div class="col-sm-2">
						<select id="sel_plan_thermo" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="plan_thermo" >
							<option value="" >{{Aucun}}</option>
							<?php
							foreach ($planHeaders as $plan) {
									echo '<option value="' . $plan->getId() . '">' . $plan->getName() . '</option>';
							}
							?>
						</select>
					</div>
				</div>

				<table id="table_cmdthermo" class="table table-bordered table-condensed">

				<thead>
					<tr>
						<th>#</th>
						<th>{{Equipement}}</th>
						<th>{{Alias}}</th>
						<th>{{Type}}</th>
						<th></th>
					</tr>
				</thead>					

				<tbody>
				</tbody>

				</table>	
			
			</div>
	
			<div role="tabpanel" class="tab-pane" id="cmdEquip" >
			
				<div class="form-group">
					<label class="col-sm-2 control-label">{{Design de configuration des équipements}}</label>
					<div class="col-sm-2">
						<select id="sel_plan_equip" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="plan_equip" >
							<option value="" >{{Aucun}}</option>
							<?php
							foreach ($planHeaders as $plan) {
									echo '<option value="' . $plan->getId() . '">' . $plan->getName() . '</option>';
							}
							?>
						</select>
					</div>
				</div>

				<table id="table_cmdequip" class="table table-bordered table-condensed">

				<thead>
					<tr>
						<th>#</th>
						<th>{{Equipement}}</th>
						<th>{{Alias}}</th>
						<th>{{Type}}</th>
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