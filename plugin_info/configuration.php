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
			<label class="col-lg-5 control-label">{{Télécharger les plug-in Kodi V16}}</label>
				<div class="form-group" >
					<a href="http://lijah.net/wp-content/uploads/2017/01/script.jeedomgui.zip" class="btn btn-success" ><i class='fa fa-floppy-o'></i>{{ Télécharger le script }}</a>
					<a href="http://lijah.net/wp-content/uploads/2017/01/skin.jeedomgui.zip" class="btn btn-success" ><i class='fa fa-floppy-o'></i>{{ Télécharger le skin }}</a>
				</div>   
		</div>   
		<div class="form-group" >
		<label class="col-lg-5 control-label">{{Télécharger les plug-in Kodi V17}}</label>
		</div>
		<li>
		<div class="form-group">
			<label class="col-lg-5 control-label">{{URL de push a enchainer}}</label>
			<div class="form-group" >
				<input type="text" class="configKey form-control"  data-l1key="PUSHURLFWD" placeholder=""/>
			</div>
		</div>	
		
    </fieldset>
</form>


