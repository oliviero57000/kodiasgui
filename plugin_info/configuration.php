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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
	include_file('desktop', '404', 'php');
	die();
}
?>
<form class="form-horizontal">
    <fieldset>
		<div class="form-group" >
			<label class="col-lg-5 control-label">{{Extension et thème KODIASGUI pour KODI V 16}}</label>
            <div class="col-lg-4">
			     <a class="btn btn-default" href="http://lijah.net/wp-content/uploads/2017/01/script.jeedomgui.zip"><i class="fa fa-cloud-download"></i> {{Télécharger l'extension pour installer dans KODI}}</a>
				 <a class="btn btn-default" href="http://lijah.net/wp-content/uploads/2017/01/skin.jeedomgui.zip"><i class="fa fa-cloud-download"></i> {{Télécharger le thème pour installer dans KODI}}</a>
				</div>   
		</div>   
		<div class="form-group" >
		<label class="col-lg-5 control-label">{{Extension et thème KODIASGUI pour KODI V 17}}</label>
		<div style="width: 100%; padding: 7px 35px 7px 15px; margin-bottom: 5px; overflow: auto; max-height: 576px; z-index: 9999;" id="div_alert" class="alert jqAlert alert-danger">
		<span class="displayError"><span id="span_errorMessage"></span>L'extension et le thème KODIASGUI pour KODI V 17 ne sont pas encore disponibles.</span>
		</div>
            <div class="col-lg-4">
				 <a class="btn btn-default" href="#"><i class="fa fa-cloud-download"></i> {{Télécharger l'extension pour installer dans KODI}}</a>
				 <a class="btn btn-default" href="#"><i class="fa fa-cloud-download"></i> {{Télécharger le thème pour installer dans KODI}}</a>
				</div>   
		</div>   
		
		<div class="form-group">
		<div class="col-lg-4">
			<label class="col-lg-5 control-label">{{URL de push à enchaîner}}</label>
			<div class="col-lg-4">
				<input type="text" class="configKey form-control"  data-l1key="PUSHURLFWD" placeholder=""/>
			</div>
		</div>	
		
    </fieldset>
</form>


