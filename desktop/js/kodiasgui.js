
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

 
 // Lumieres
 
 $("#table_cmdlight").delegate(".listEquipementAction", 'click', function () {
    var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'action', subType: 'other'}}, function (result) {
        var calcul = el.closest('tr').find('.eqcfg[cfg-name=' + el.attr('fct') + ']');
        calcul.atCaret('insert', result.human);
    });
});
 
 $("#table_cmdlight").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqcfg[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 
 
 $('#table_cmdlight tbody').delegate('tr .remove', 'click', function (event) {
    $(this).closest('tr').remove();
});
/*
$("#table_lightinfo").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
	 
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });

	jeedom.eqLogic.getSelectModal({eqLogic: {type: 'virtual'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
	
		
}); 
*/

 $("#bt_addlight").on('click', function (event) {
    	
	var el = $('#table_cmdlight tbody tr:last').attr('data-cfg_id');
	var ligthidx =1;
	
	if ( el != null )
	  ligthidx = parseInt(el)+1;

	addLight({index: ligthidx, name : 'Lumière', cmdON : 0 , cmdOFF : 0 , cmdSTATUS : 0});
});	


function addLight( _ligth ) {
	
	 var tr = '<tr class="trlight" data-cfg_id="' + _ligth.index + '" >';
	 tr += '<td>';
	 tr += _ligth.index;
	 tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_light'+_ligth.index+'_name" />';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_light'+_ligth.index+'_on" placeholder="{{Commande ON}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_light'+_ligth.index+'_on" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_light'+_ligth.index+'_off" placeholder="{{Commande OFF}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_light'+_ligth.index+'_off" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_light'+_ligth.index+'_status" placeholder="{{Info STATUS}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_light'+_ligth.index+'_status" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';	
	tr += '<td>';	
	tr += '<a class="btn btn-default btn-sm cursor remove" style="margin-left : 5px;"><i class="fa fa-minus-circle "></i> {{Supprimer}}</a>';	
	tr += '</td></tr>';	
   
   $('#table_cmdlight tbody').append(tr);
  
   $('#table_cmdlight tbody').find('.eqcfg[cfg-name=cfg_light'+_ligth.index+'_name]').val(_ligth.name);
   $('#table_cmdlight tbody').find('.eqcfg[cfg-name=cfg_light'+_ligth.index+'_on]').val(_ligth.cmdON);
   $('#table_cmdlight tbody').find('.eqcfg[cfg-name=cfg_light'+_ligth.index+'_off]').val(_ligth.cmdOFF);
   $('#table_cmdlight tbody').find('.eqcfg[cfg-name=cfg_light'+_ligth.index+'_status]').val(_ligth.cmdSTATUS);
}
 
// Acces 
 
 $("#table_cmdacces").delegate(".listEquipementAction", 'click', function () {
    var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'action', subType: 'other'}}, function (result) {
        var calcul = el.closest('tr').find('.eqcfg[cfg-name=' + el.attr('fct') + ']');
        calcul.atCaret('insert', result.human);
    });
});
 
 $("#table_cmdacces").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqcfg[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 
 
 $('#table_cmdacces tbody').delegate('tr .remove', 'click', function (event) {
    $(this).closest('tr').remove();
});

 $("#bt_addacces").on('click', function (event) {
    	
	var el = $('#table_cmdacces tbody tr:last').attr('data-cfg_id');
	var accesidx =1;
	
	if ( el != null )
	  accesidx = parseInt(el)+1;

	addAcces({index: accesidx, name : 'Porte', cmdOPEN : 0 , cmdCLOSE : 0 , cmdSTATUS : 0});
});	
 
function addAcces( _acces ) {
	
	 var tr = '<tr class="tracces" data-cfg_id="' + _acces.index + '" >';
	 tr += '<td>';
	 tr += _acces.index;
	 tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_acces'+_acces.index+'_name" />';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_acces'+_acces.index+'_open" placeholder="{{Commande OUVRIR}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_acces'+_acces.index+'_on" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_acces'+_acces.index+'_close" placeholder="{{Commande FERMER}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_acces'+_acces.index+'_off" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_acces'+_acces.index+'_status" placeholder="{{Info STATUS}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_acces'+_acces.index+'_status" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';	
	tr += '<td>';	
	tr += '<a class="btn btn-default btn-sm cursor remove" style="margin-left : 5px;"><i class="fa fa-minus-circle "></i> {{Supprimer}}</a>';	
	tr += '</td></tr>';	
   
   $('#table_cmdacces tbody').append(tr);
  
   $('#table_cmdacces tbody').find('.eqcfg[cfg-name=cfg_acces'+_acces.index+'_name]').val(_acces.name);
   $('#table_cmdacces tbody').find('.eqcfg[cfg-name=cfg_acces'+_acces.index+'_open]').val(_acces.cmdOPEN);
   $('#table_cmdacces tbody').find('.eqcfg[cfg-name=cfg_acces'+_acces.index+'_close]').val(_acces.cmdCLOSE);
   $('#table_cmdacces tbody').find('.eqcfg[cfg-name=cfg_acces'+_acces.index+'_status]').val(_acces.cmdSTATUS);
}

// Thermo


$("#table_therminfo").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 


// Infos

$("#table_cmdinfo").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 
 
 
function updateInfos(_infos) {
	 
	$('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_msgURGENT]').val(_infos.msgURGENT);
	$('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_msg]').val(_infos.msg);

	$('#table_lightinfo tbody').find('.eqinfos[cfg-name=eqinfos_lumen]').val(_eqLogic.configuration.ginfos.lumen);
	
	$('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_tempint]').val(_infos.tempint);
	$('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_tempext]').val(_infos.tempext);

 }


 function printEqLogic(_eqLogic) {

    $('#table_cmdlight tbody').empty();
    $('#table_cmdacces tbody').empty();

    if (isset(_eqLogic.configuration)) {

		if (isset(_eqLogic.configuration.lights)) {
            for (var i in _eqLogic.configuration.lights) {
                addLight(_eqLogic.configuration.lights[i]);
            }
        }

		
        if (isset(_eqLogic.configuration.access)) {
            for (var i in _eqLogic.configuration.access) {
                addAcces(_eqLogic.configuration.access[i]);
            }
        }
		
		if (isset(_eqLogic.configuration.ginfos)) {
			
			updateInfos(_eqLogic.configuration.ginfos);
		}
		/*
		else{
			
			$('#table_lightinfo tbody').find('.eqinfos[cfg-name=eqinfos_lumen]').val(_eqLogic.configuration.ginfos.lumen);
			
			
			updateInfos({msgURGENT: '', lumen : 0, tempint : 0, tempext : 0, waterHOT_flow : 0 , waterHOT_count : 0 , waterCOLD_flow : 0 , waterCOLD_count : 0 });
		}
		*/

    }

	
}

 function saveEqLogic(_eqLogic) {
    if (!isset(_eqLogic.configuration)) {
        _eqLogic.configuration = {};
    }
    _eqLogic.configuration.lights = [];
    $('#table_cmdlight tbody .trlight').each(function () {
		var light = { index : 0 , name : '', cmdON : 0 , cmdOFF : 0 , cmdSTATUS : 0 };

        light.index = $(this).attr('data-cfg_id');
		light.name = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_name]').value();
        light.cmdON = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_on]').value();
        light.cmdOFF = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_off]').value();
        light.cmdSTATUS = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_status]').value();
        _eqLogic.configuration.lights.push(light);
    });

    _eqLogic.configuration.access = [];
    $('#table_cmdacces tbody .trlight').each(function () {
		var acces = { index : 0 , name : '', cmdON : 0 , cmdOFF : 0 , cmdSTATUS : 0 };

        acces.index = $(this).attr('data-cfg_id');
		acces.name = $(this).find('.eqcfg[cfg-name=cfg_light'+acces.index+'_name]').value();
        acces.cmdOPEN = $(this).find('.eqcfg[cfg-name=cfg_light'+acces.index+'_open]').value();
        acces.cmdCLOSE = $(this).find('.eqcfg[cfg-name=cfg_light'+acces.index+'_close]').value();
        acces.cmdSTATUS = $(this).find('.eqcfg[cfg-name=cfg_light'+acces.index+'_status]').value();
        _eqLogic.configuration.access.push(acces);
    });
	
	_eqLogic.configuration.ginfos = {
		msgURGENT: '', 
		msg: '', 
		
		lumen : 0, 
		
		tempint : 0, 
		tempext : 0, 
		
		waterHOT_flow : 0 , waterHOT_count : 0 , waterCOLD_flow : 0 , waterCOLD_count : 0 
	};

	_eqLogic.configuration.ginfos.msgURGENT = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_msgURGENT]').value();
	_eqLogic.configuration.ginfos.msg = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_msg]').value();

	_eqLogic.configuration.ginfos.lumen = $('#table_lightinfo tbody').find('.eqinfos[cfg-name=eqinfos_lumen]').value();

	_eqLogic.configuration.ginfos.tempint = $('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_tempint]').value();
	_eqLogic.configuration.ginfos.tempext = $('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_tempext]').value();

	_eqLogic.configuration.ginfos.waterHOT_flow = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_waterHOT_flow]').value();
	_eqLogic.configuration.ginfos.waterHOT_count = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_waterHOT_count]').value();
	_eqLogic.configuration.ginfos.waterCOLD_flow = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_waterCOLD_flow]').value();
	_eqLogic.configuration.ginfos.waterCOLD_count = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_waterCOLD_count]').value();
	
    return _eqLogic;
}

function addCmdToTable(_cmd) {
   
}
