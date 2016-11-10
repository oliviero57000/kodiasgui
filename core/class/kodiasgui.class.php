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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class kodiasgui extends eqLogic {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	public function generateCmds() {
		
	}

	public function preInsert() {
		$this->setConfiguration('UID',uniqid());
	}
	
	public function postSave() {

	}
	
	public function preRemove() {
	}	
		
	
	public function createCmd($cmdname,$eqlogic,$cmdlogic) {
		log::add('kodiasgui', 'debug', 'create Command '.$cmdlogic.' = '.$cmdname);
		$cmd = new kodiasguiCmd();
		$cmd->setLogicalId($cmdlogic);
		$cmd->setName($cmdname);
		$cmd->setTemplate('dashboard', 'tile');
		$cmd->setEqLogic_id($eqlogic);
		$cmd->setType('info');
		$cmd->setSubType('string');
		$cmd->save();
	}	


	/*     * **********************Getteur Setteur*************************** */
}

class kodiasguiCmd extends cmd {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */


	
	public function dontRemoveCmd() {
		return true;
	}

	public function execute($_options = array()) {
		return;
	}

	/*     * **********************Getteur Setteur*************************** */
}

?>
