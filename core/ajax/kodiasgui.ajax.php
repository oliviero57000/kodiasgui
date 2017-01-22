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

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
	
    include_file('core', 'authentification', 'php');

    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }
	


	// action qui permet d'obtenir l'ensemble des eqLogic d'un design
    if (init('action') == 'getKodiCfg') {
		$data=[];
		if (init('planid') !="" )
		{
		$plans = plan::all();
		$idx=0;
		foreach ($plans as $plan) 
			{
			if ( $plan->getPlanHeader_id() == init('planid') ) 
				{
				if ( $plan->getLink_type() == "eqLogic" )
					{
					$equip = $plan->getLink();
					$eq['id']=$equip->getId();
					$eq['name']=$equip->getName();
					$eqparams = $equip->getDisplay('parameters'); 
					$eq['type'] = $eqparams['Kodi Type'];
					$eq['alias'] = $eqparams['Kodi Alias'];
					}
				else if ( $plan->getLink_type() == "scenario" )
					{
					$eq['id']=$equip->getId();
					$eq['name']=$equip->getName();
					$eq['type'] = "Shortcut";
					$eq['alias'] = "";
					}
					
					$data[$idx++]=$eq;
				}			
			
			}
        }
        ajax::success($data);
    }

	// action qui permet de mettre a jours les equipements avec le parametrage kodi
    if (init('action') == 'setKodiCfg') {
		//log::add('kodiasgui', 'info', 'setKodiCfg command received.');
		
		$eqid = init('eqid');
		$eqalias = init('eqalias');
		$eqtype = init('eqtype');
		
        $eqLogic = eqLogic::byId($eqid);
		
		$eqparams = $eqLogic->getDisplay('parameters'); 
		$eqparams['Kodi Alias'] = $eqalias;
		$eqparams['Kodi Type'] = $eqtype;
		$eqLogic->setDisplay('parameters',$eqparams);
		$eqLogic->save();
        ajax::success('ok');
    }	
	
   // throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}

?>
