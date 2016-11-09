
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

// Infos

$("#table_cmdinfo").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 

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

$("#table_lightinfo").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
	 
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 



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
 
$("#table_accesinfo").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
	 
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
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
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_acces'+_acces.index+'_open" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_acces'+_acces.index+'_close" placeholder="{{Commande FERMER}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_acces'+_acces.index+'_close" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
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

 
// Waters
 
 $("#table_cmdwater").delegate(".listEquipementAction", 'click', function () {
    var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'action', subType: 'other'}}, function (result) {
        var calcul = el.closest('tr').find('.eqcfg[cfg-name=' + el.attr('fct') + ']');
        calcul.atCaret('insert', result.human);
    });
});
 
 $("#table_cmdwater").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqcfg[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 
 
 $("#table_waterinfo").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
	 
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
});  

 $('#table_cmdwater tbody').delegate('tr .remove', 'click', function (event) {
    $(this).closest('tr').remove();
});

 $("#bt_addWater").on('click', function (event) {
    	
	var el = $('#table_cmdwater tbody tr:last').attr('data-cfg_id');
	var wateridx =1;
	
	if ( el != null )
	  wateridx = parseInt(el)+1;

	addWater({index: wateridx , name : 'Eau', cmdOPEN : 0 , cmdCLOSE : 0 , cmdDEBIT : 0, cmdCONSO : 0, cmdSTATUS : 0 });
});	
 
function addWater( _water ) {
	
	 var tr = '<tr class="trwater" data-cfg_id="' + _water.index + '" >';
	 tr += '<td>';
	 tr += _water.index;
	 tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_water'+_water.index+'_name" />';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_water'+_water.index+'_status" placeholder="{{Info STATUS}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_water'+_water.index+'_status" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_water'+_water.index+'_open" placeholder="{{Commande OUVRIR}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_water'+_water.index+'_open" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_water'+_water.index+'_close" placeholder="{{Commande FERMER}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_water'+_water.index+'_close" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';	
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_water'+_water.index+'_debit" placeholder="{{Info DEBIT}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_water'+_water.index+'_debit" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_water'+_water.index+'_conso" placeholder="{{Info CONSO}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_water'+_water.index+'_conso" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';	
	tr += '<td>';	
	tr += '<a class="btn btn-default btn-sm cursor remove" style="margin-left : 5px;"><i class="fa fa-minus-circle "></i> {{Supprimer}}</a>';	
	tr += '</td></tr>';	
   
   $('#table_cmdwater tbody').append(tr);
  
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_name]').val(_water.name);
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_open]').val(_water.cmdOPEN);
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_close]').val(_water.cmdCLOSE);
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_conso]').val(_water.cmdCONSO);
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_debit]').val(_water.cmdDEBIT);
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_status]').val(_water.cmdSTATUS);
}

// Thermos
 
 $("#table_cmdtherm").delegate(".listEquipementAction", 'click', function () {
    var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'action', subType: 'other'}}, function (result) {
        var calcul = el.closest('tr').find('.eqcfg[cfg-name=' + el.attr('fct') + ']');
        calcul.atCaret('insert', result.human);
    });
});
 
 $("#table_cmdtherm").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqcfg[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 
 
 $("#table_therminfo").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
	 
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqinfos[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
});  

 $('#table_cmdtherm tbody').delegate('tr .remove', 'click', function (event) {
    $(this).closest('tr').remove();
});

 $("#bt_addtherm").on('click', function (event) {
    	
	var el = $('#table_cmdtherm tbody tr:last').attr('data-cfg_id');
	var thermoidx =1;
	
	if ( el != null )
	  thermoidx = parseInt(el)+1;

	addThermo({index: thermoidx, name : 'Chauffage', cmdON : 0 , cmdOFF : 0 , cmdSTATUS : 0 , cmdCONSIGNE : 0 , cmdAUTO : 0 });
});	
 
function addThermo( _thermo ) {
	
	 var tr = '<tr class="trtherm" data-cfg_id="' + _thermo.index + '" >';
	 tr += '<td>';
	 tr += _thermo.index;
	 tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_thermo'+_thermo.index+'_name" />';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_thermo'+_thermo.index+'_consigne" placeholder="{{Info CONSIGNE}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_thermo'+_thermo.index+'_consigne" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_thermo'+_thermo.index+'_status" placeholder="{{Info STATUS}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_thermo'+_thermo.index+'_status" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_thermo'+_thermo.index+'_on" placeholder="{{Commande ON}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_thermo'+_thermo.index+'_on" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_thermo'+_thermo.index+'_off" placeholder="{{Commande OFF}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_thermo'+_thermo.index+'_off" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';	
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_thermo'+_thermo.index+'_auto" placeholder="{{Commande AUTO}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementAction" fct="cfg_thermo'+_thermo.index+'_auto" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';	
	tr += '<td>';	
	tr += '<a class="btn btn-default btn-sm cursor remove" style="margin-left : 5px;"><i class="fa fa-minus-circle "></i> {{Supprimer}}</a>';	
	tr += '</td></tr>';	
   
   $('#table_cmdtherm tbody').append(tr);
  
   $('#table_cmdtherm tbody').find('.eqcfg[cfg-name=cfg_thermo'+_thermo.index+'_name]').val(_thermo.name);
   $('#table_cmdtherm tbody').find('.eqcfg[cfg-name=cfg_thermo'+_thermo.index+'_on]').val(_thermo.cmdON);
   $('#table_cmdtherm tbody').find('.eqcfg[cfg-name=cfg_thermo'+_thermo.index+'_off]').val(_thermo.cmdOFF);
   $('#table_cmdtherm tbody').find('.eqcfg[cfg-name=cfg_thermo'+_thermo.index+'_auto]').val(_thermo.cmdAUTO);
   $('#table_cmdtherm tbody').find('.eqcfg[cfg-name=cfg_thermo'+_thermo.index+'_consigne]').val(_thermo.cmdCONSIGNE);
   $('#table_cmdtherm tbody').find('.eqcfg[cfg-name=cfg_thermo'+_thermo.index+'_status]').val(_thermo.cmdSTATUS);
}


// Global
 
function updateInfos(_infos) {
	 
	$('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_msgURGENT]').val(_infos.msgURGENT);
	$('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_msg]').val(_infos.msg);

	$('#table_lightinfo tbody').find('.eqinfos[cfg-name=eqinfos_lumen]').val(_infos.lumen);
	
	$('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_tempint]').val(_infos.tempint);
	$('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_tempext]').val(_infos.tempext);
	
	$('#table_accesinfo tbody').find('.eqinfos[cfg-name=eqinfos_present]').val(_infos.present);
	
	$('#table_waterinfo tbody').find('.eqinfos[cfg-name=eqinfos_flood]').val(_infos.flood);
	
 }


 function printEqLogic(_eqLogic) {

    $('#table_cmdlight tbody').empty();
    $('#table_cmdacces tbody').empty();
	$('#table_cmdtherm tbody').empty();
	$('#table_cmdwater tbody').empty();

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
		
        if (isset(_eqLogic.configuration.thermos)) {
            for (var i in _eqLogic.configuration.thermos) {
                addThermo(_eqLogic.configuration.thermos[i]);
            }
        }

        if (isset(_eqLogic.configuration.waters)) {
            for (var i in _eqLogic.configuration.waters) {
                addWater(_eqLogic.configuration.waters[i]);
            }
        }
		
		if (isset(_eqLogic.configuration.ginfos)) {
			
			updateInfos(_eqLogic.configuration.ginfos);
		}
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
    $('#table_cmdacces tbody .tracces').each(function () {
		var acces = { index : 0 , name : '', cmdOPEN : 0 , cmdCLOSE : 0 , cmdSTATUS : 0 };

        acces.index = $(this).attr('data-cfg_id');
		acces.name = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_name]').value();
        acces.cmdOPEN = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_open]').value();
        acces.cmdCLOSE = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_close]').value();
        acces.cmdSTATUS = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_status]').value();
        _eqLogic.configuration.access.push(acces);
    });

    _eqLogic.configuration.thermos = [];
    $('#table_cmdtherm tbody .trtherm').each(function () {
		var thermo = { index : 0 , name : '', cmdON : 0 , cmdOFF : 0 , cmdCONSIGNE : 0, cmdAUTO : 0, cmdSTATUS : 0 };

        thermo.index = $(this).attr('data-cfg_id');
		thermo.name = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_name]').value();
        thermo.cmdON = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_on]').value();
        thermo.cmdOFF = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_off]').value();
        thermo.cmdCONSIGNE = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_consigne]').value();
        thermo.cmdAUTO = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_auto]').value();
        thermo.cmdSTATUS = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_status]').value();
        _eqLogic.configuration.thermos.push(thermo);
    });

    _eqLogic.configuration.waters = [];
    $('#table_cmdwater tbody .trwater').each(function () {
		var water = { index : 0 , name : '', cmdOPEN : 0 , cmdCLOSE : 0 , cmdDEBIT : 0, cmdCONSO : 0, cmdSTATUS : 0 };

        water.index = $(this).attr('data-cfg_id');
		water.name = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_name]').value();
        water.cmdOPEN = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_open]').value();
        water.cmdCLOSE = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_close]').value();
        water.cmdDEBIT = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_debit]').value();
        water.cmdCONSO = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_conso]').value();
        water.cmdSTATUS = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_status]').value();
        _eqLogic.configuration.waters.push(water);
    });
	
	_eqLogic.configuration.ginfos = {
		msgURGENT: '', 
		msg: '', 
		
		lumen : 0, 
		
		tempint : 0, 
		tempext : 0, 
		
		present : 0,
		
		flood : 0 
	};

	_eqLogic.configuration.ginfos.msgURGENT = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_msgURGENT]').value();
	_eqLogic.configuration.ginfos.msg = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_msg]').value();

	_eqLogic.configuration.ginfos.lumen = $('#table_lightinfo tbody').find('.eqinfos[cfg-name=eqinfos_lumen]').value();

	_eqLogic.configuration.ginfos.tempint = $('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_tempint]').value();
	_eqLogic.configuration.ginfos.tempext = $('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_tempext]').value();

	_eqLogic.configuration.ginfos.present = $('#table_accesinfo tbody').find('.eqinfos[cfg-name=eqinfos_present]').value();
	
	_eqLogic.configuration.ginfos.flood = $('#table_waterinfo tbody').find('.eqinfos[cfg-name=eqinfos_flood]').value();

    return _eqLogic;
}



function addCmdToTable(_cmd) {
   
}
