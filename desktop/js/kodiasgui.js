
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

	addLight({index: ligthidx, name : 'Lumière', type : '', cmdON : 0 , cmdOFF : 0 , infoSTATUS : 0});
});	


function addLight( _ligth ) {
	
	 var tr = '<tr class="trlight" data-cfg_id="' + _ligth.index + '" >';
	 tr += '<td>';
	 tr += _ligth.index;
	 tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_light'+_ligth.index+'_name" />';
	tr += '</td>';
	tr += '<td><select class="eqcfg form-control" cfg-name="cfg_light'+_ligth.index+'_type">';
	if ( _ligth.type == 'Uni' )
		tr += '<option selected>{{Uni}}</option>';
	else
		tr += '<option >{{Uni}}</option>';
	if ( _ligth.type == 'RGB' )
		tr += '<option selected>{{RGB}}</option>';
	else
		tr += '<option>{{RGB}}</option>';
	tr += '</select>';	
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
   $('#table_cmdlight tbody').find('.eqcfg[cfg-name=cfg_light'+_ligth.index+'_status]').val(_ligth.infoSTATUS);
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

	addAcces({index: accesidx, name : 'Porte', type : 'Porte', cmdOPEN : 0 , cmdCLOSE : 0 , infoSTATUS : 0});
});	
 
function addAcces( _acces ) {
	
	 var tr = '<tr class="tracces" data-cfg_id="' + _acces.index + '" >';
	 tr += '<td>';
	 tr += _acces.index;
	 tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_acces'+_acces.index+'_name" />';
	tr += '</td>';	 
	tr += '<td><select class="eqcfg form-control" cfg-name="cfg_acces'+_acces.index+'_type">';
	if ( _acces.type == 'Porte' )
		tr += '<option selected>{{Porte}}</option>';
	else
		tr += '<option >{{Porte}}</option>';
	if ( _acces.type == 'Store' )
		tr += '<option selected>{{Store}}</option>';
	else
		tr += '<option>{{Store}}</option>';
	if ( _acces.type == 'Velux' )
		tr += '<option selected>{{Velux}}</option>';
	else
		tr += '<option>{{Velux}}</option>';
	if ( _acces.type == 'Portail' )
		tr += '<option selected">{{Portail}}</option>';
	else
		tr += '<option">{{Portail}}</option>';
	tr += '</select>';
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
   $('#table_cmdacces tbody').find('.eqcfg[cfg-name=cfg_acces'+_acces.index+'_status]').val(_acces.infoSTATUS);
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

	addWater({index: wateridx , name : 'Eau', type : '', cmdOPEN : 0 , cmdCLOSE : 0 , infoDEBIT : 0, infoCONSO : 0, infoSTATUS : 0 });
});	
 
function addWater( _water ) {
	
	 var tr = '<tr class="trwater" data-cfg_id="' + _water.index + '" >';
	 tr += '<td>';
	 tr += _water.index;
	 tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_water'+_water.index+'_name" />';
	tr += '</td>';
	tr += '<td><select class="eqcfg form-control" cfg-name="cfg_water'+_water.index+'_type">';
	if ( _water.type == 'Froide' )
		tr += '<option selected>{{Froide}}</option>';
	else
		tr += '<option >{{Froide}}</option>';
	if ( _water.type == 'Chaude' )
		tr += '<option selected>{{Chaude}}</option>';
	else
		tr += '<option>{{Chaude}}</option>';
	tr += '</select>';	
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
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_conso]').val(_water.infoCONSO);
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_debit]').val(_water.infoDEBIT);
   $('#table_cmdwater tbody').find('.eqcfg[cfg-name=cfg_water'+_water.index+'_status]').val(_water.infoSTATUS);
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

	addThermo({index: thermoidx, name : 'Chauffage', cmdON : 0 , cmdOFF : 0 , infoSTATUS : 0 , infoCONSIGNE : 0 , cmdAUTO : 0 });
});	
 
function addThermo( _thermo ) {
	
	 var tr = '<tr class="trtherm" data-cfg_id="' + _thermo.index + '" >';
	 tr += '<td>';
	 tr += _thermo.index;
	 tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_thermo'+_thermo.index+'_name" />';
	tr += '</td>';
	tr += '<td><select class="eqcfg form-control" cfg-name="cfg_thermo'+_thermo.index+'_type">';
	if ( _thermo.type == 'Radiateur' )
		tr += '<option selected>{{Radiateur}}</option>';
	else
		tr += '<option >{{Radiateur}}</option>';
	if ( _thermo.type == 'Climatiseur' )
		tr += '<option selected>{{Climatiseur}}</option>';
	else
		tr += '<option>{{Climatiseur}}</option>';
	tr += '</select>';	
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
   $('#table_cmdtherm tbody').find('.eqcfg[cfg-name=cfg_thermo'+_thermo.index+'_consigne]').val(_thermo.infoCONSIGNE);
   $('#table_cmdtherm tbody').find('.eqcfg[cfg-name=cfg_thermo'+_thermo.index+'_status]').val(_thermo.infoSTATUS);
}

// Equips
 
 $("#table_cmdequip").delegate(".listEquipementAction", 'click', function () {
    var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'action', subType: 'other'}}, function (result) {
        var calcul = el.closest('tr').find('.eqcfg[cfg-name=' + el.attr('fct') + ']');
        calcul.atCaret('insert', result.human);
    });
});
 
 $("#table_cmdequip").delegate(".listEquipementInfo", 'click', function () {
	 var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
		var calcul = el.closest('tr').find('.eqcfg[cfg-name='+el.attr('fct')+']');
		calcul.atCaret('insert', result.human);
    });
}); 

 $('#table_cmdequip tbody').delegate('tr .remove', 'click', function (event) {
    $(this).closest('tr').remove();
});

 $("#bt_addEquip").on('click', function (event) {
    	
	var el = $('#table_cmdequip tbody tr:last').attr('data-cfg_id');
	var equipidx =1;
	
	if ( el != null )
	  equipidx = parseInt(el)+1;

	addEquip({index: equipidx , name : 'Equipement', type : '', infoSTATUS : '', param1 : '',info1 : '', param2 : '',info2 : '' });
});	
 
function addEquip( _equip ) {
	
	var tr = '<tr class="trequip" data-cfg_id="' + _equip.index + '" >';
	tr += '<td>';
	tr += _equip.index;
	tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_equip'+_equip.index+'_name" />';
	tr += '</td>';
	tr += '<td><select class="eqcfg form-control" cfg-name="cfg_equip'+_equip.index+'_type">';
	if ( _equip.type == 'Refrigerateur' )
		tr += '<option selected>{{Refrigerateur}}</option>';
	else
		tr += '<option >{{Refrigerateur}}</option>';
	if ( _equip.type == 'TV' )
		tr += '<option selected>{{TV}}</option>';
	else
		tr += '<option>{{TV}}</option>';
	if ( _equip.type == 'Lave-Linge' )
		tr += '<option selected>{{Lave-Linge}}</option>';
	else
		tr += '<option>{{Lave-linge}}</option>';
	if ( _equip.type == 'Seche-Linge' )
		tr += '<option selected>{{Seche-Linge}}</option>';
	else
		tr += '<option>{{Seche-Linge}}</option>';
	if ( _equip.type == 'Lave-Vaisselle' )
		tr += '<option selected>{{Lave-Vaisselle}}</option>';
	else
		tr += '<option>{{Lave-Vaisselle}}</option>';
	if ( _equip.type == 'Hotte' )
		tr += '<option selected>{{Hotte}}</option>';
	else
		tr += '<option>{{Hotte}}</option>';	
	if ( _equip.type == 'Autre' )
		tr += '<option selected>{{Autre}}</option>';
	else
		tr += '<option>{{Autre}}</option>';	
	tr += '</select>';	
	tr += '</td>';		
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_equip'+_equip.index+'_status" placeholder="{{Info STATUS}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_equip'+_equip.index+'_status" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';	
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_equip'+_equip.index+'_param1" />';
	tr += '</td>';	
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_equip'+_equip.index+'_info1" placeholder="{{Info 1}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_equip'+_equip.index+'_info1" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="cfg_equip'+_equip.index+'_param2" />';
	tr += '</td>';	
	tr += '<td>';
	tr += '<input class="eqcfg form-control input-sm" cfg-name="cfg_equip'+_equip.index+'_info2" placeholder="{{Info 2}}" style="margin-bottom : 5px;width : 70%; display : inline-block;" />';
	tr += '<a class="btn btn-default btn-sm cursor listEquipementInfo" fct="cfg_equip'+_equip.index+'_info2" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>';
	tr += '</td>';
	tr += '<td>';	
	tr += '<a class="btn btn-default btn-sm cursor remove" style="margin-left : 5px;"><i class="fa fa-minus-circle "></i> {{Supprimer}}</a>';	
	tr += '</td></tr>';	
   
   $('#table_cmdequip tbody').append(tr);
  
   $('#table_cmdequip tbody').find('.eqcfg[cfg-name=cfg_equip'+_equip.index+'_name]').val(_equip.name);
   $('#table_cmdequip tbody').find('.eqcfg[cfg-name=cfg_equip'+_equip.index+'_status]').val(_equip.infoSTATUS);
   $('#table_cmdequip tbody').find('.eqcfg[cfg-name=cfg_equip'+_equip.index+'_param1]').val(_equip.param1);
   $('#table_cmdequip tbody').find('.eqcfg[cfg-name=cfg_equip'+_equip.index+'_info1]').val(_equip.info1);
   $('#table_cmdequip tbody').find('.eqcfg[cfg-name=cfg_equip'+_equip.index+'_param2]').val(_equip.param2);
   $('#table_cmdequip tbody').find('.eqcfg[cfg-name=cfg_equip'+_equip.index+'_info2]').val(_equip.info2);
}


// Global
 
function updateInfos(_infos) {
	 
	$('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoMSGURGENT]').val(_infos.infoMSGURGENT);
	$('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoMSG]').val(_infos.infoMSG);
	$('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoFIRE]').val(_infos.infoFIRE);

	$('#table_lightinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoLUMEN]').val(_infos.infoLUMEN);
	
	$('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_infotempint]').val(_infos.infotempint);
	$('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_infotempext]').val(_infos.infotempext);
	$('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_infohumint]').val(_infos.infohumint);
	$('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_infohumext]').val(_infos.infohumext);
	
	$('#table_accesinfo tbody').find('.eqinfos[cfg-name=eqinfos_infopresent]').val(_infos.infopresent);
	
	$('#table_waterinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoflood]').val(_infos.infoflood);
	
 }


 function printEqLogic(_eqLogic) {

    $('#table_cmdlight tbody').empty();
    $('#table_cmdacces tbody').empty();
	$('#table_cmdtherm tbody').empty();
	$('#table_cmdwater tbody').empty();
	$('#table_cmdequip tbody').empty();

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

        if (isset(_eqLogic.configuration.equips)) {
            for (var i in _eqLogic.configuration.equips) {
                addEquip(_eqLogic.configuration.equips[i]);
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
		var light = { index : 0 , name : '', type : '', cmdON : 0 , cmdOFF : 0 , infoSTATUS : 0 };
        light.index = $(this).attr('data-cfg_id');
		light.name = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_name]').value();
		light.type = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_type]').value();
        light.cmdON = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_on]').value();
        light.cmdOFF = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_off]').value();
        light.infoSTATUS = $(this).find('.eqcfg[cfg-name=cfg_light'+light.index+'_status]').value();
        _eqLogic.configuration.lights.push(light);
    });

    _eqLogic.configuration.access = [];
    $('#table_cmdacces tbody .tracces').each(function () {
		var acces = { index : 0 , name : '', type : '', cmdOPEN : 0 , cmdCLOSE : 0 , infoSTATUS : 0 };
        acces.index = $(this).attr('data-cfg_id');
		acces.name = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_name]').value();
		acces.type = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_type]').value();
        acces.cmdOPEN = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_open]').value();
        acces.cmdCLOSE = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_close]').value();
        acces.infoSTATUS = $(this).find('.eqcfg[cfg-name=cfg_acces'+acces.index+'_status]').value();
        _eqLogic.configuration.access.push(acces);
    });

    _eqLogic.configuration.thermos = [];
    $('#table_cmdtherm tbody .trtherm').each(function () {
		var thermo = { index : 0 , name : '', cmdON : 0 , cmdOFF : 0 , infoCONSIGNE : 0, cmdAUTO : 0, infoSTATUS : 0 };

        thermo.index = $(this).attr('data-cfg_id');
		thermo.name = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_name]').value();
		thermo.type = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_type]').value();		
        thermo.cmdON = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_on]').value();
        thermo.cmdOFF = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_off]').value();
        thermo.infoCONSIGNE = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_consigne]').value();
        thermo.cmdAUTO = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_auto]').value();
        thermo.infoSTATUS = $(this).find('.eqcfg[cfg-name=cfg_thermo'+thermo.index+'_status]').value();
        _eqLogic.configuration.thermos.push(thermo);
    });

    _eqLogic.configuration.waters = [];
    $('#table_cmdwater tbody .trwater').each(function () {
		var water = { index : 0 , name : '', type : '', cmdOPEN : 0 , cmdCLOSE : 0 , infoDEBIT : 0, infoCONSO : 0, infoSTATUS : 0 };

        water.index = $(this).attr('data-cfg_id');
		water.name = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_name]').value();
		water.type = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_type]').value();
        water.cmdOPEN = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_open]').value();
        water.cmdCLOSE = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_close]').value();
        water.infoDEBIT = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_debit]').value();
        water.infoCONSO = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_conso]').value();
        water.infoSTATUS = $(this).find('.eqcfg[cfg-name=cfg_water'+water.index+'_status]').value();
        _eqLogic.configuration.waters.push(water);
    });

    _eqLogic.configuration.equips = [];
    $('#table_cmdequip tbody .trequip').each(function () {
		var equip = { index : 0 , name : '', type : '', infoSTATUS : '', param1 : '', info1 : '', param2 : '', info2 : '' };

        equip.index = $(this).attr('data-cfg_id');
		equip.name = $(this).find('.eqcfg[cfg-name=cfg_equip'+equip.index+'_name]').value();
		equip.type = $(this).find('.eqcfg[cfg-name=cfg_equip'+equip.index+'_type]').value();
        equip.infoSTATUS = $(this).find('.eqcfg[cfg-name=cfg_equip'+equip.index+'_status]').value();
        equip.param1 = $(this).find('.eqcfg[cfg-name=cfg_equip'+equip.index+'_param1]').value();
        equip.info1 = $(this).find('.eqcfg[cfg-name=cfg_equip'+equip.index+'_info1]').value();
        equip.param2 = $(this).find('.eqcfg[cfg-name=cfg_equip'+equip.index+'_param2]').value();
        equip.info2 = $(this).find('.eqcfg[cfg-name=cfg_equip'+equip.index+'_info2]').value();
        _eqLogic.configuration.equips.push(equip);
    });
	
	_eqLogic.configuration.ginfos = {
		infoMSGURGENT: '', 
		infoMSG: '', 
		infoFIRE : 0, 
		
		infoLUMEN : 0, 
		
		infotempint : 0, 
		infotempext : 0, 
		infohumint : 0, 
		infohumext : 0, 
		
		infopresent : 0,
		
		infoflood : 0 
	};

	_eqLogic.configuration.ginfos.infoMSGURGENT = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoMSGURGENT]').value();
	_eqLogic.configuration.ginfos.infoMSG = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoMSG]').value();
	_eqLogic.configuration.ginfos.infoFIRE = $('#table_cmdinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoFIRE]').value();

	
	_eqLogic.configuration.ginfos.infoLUMEN = $('#table_lightinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoLUMEN]').value();

	_eqLogic.configuration.ginfos.infotempint = $('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_infotempint]').value();
	_eqLogic.configuration.ginfos.infotempext = $('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_infotempext]').value();
	_eqLogic.configuration.ginfos.infohumint = $('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_infohumint]').value();
	_eqLogic.configuration.ginfos.infohumext = $('#table_therminfo tbody').find('.eqinfos[cfg-name=eqinfos_infohumext]').value();

	_eqLogic.configuration.ginfos.infopresent = $('#table_accesinfo tbody').find('.eqinfos[cfg-name=eqinfos_infopresent]').value();
	
	_eqLogic.configuration.ginfos.infoflood = $('#table_waterinfo tbody').find('.eqinfos[cfg-name=eqinfos_infoflood]').value();

    return _eqLogic;
}

$('.eqLogicAttr[data-l1key=configuration][data-l2key=type]').on('change', function () {
    if($(this).value()=='shared'){
        $('.kodi_spec').hide();
    }
	if($(this).value()=='unshared'){
		$('.kodi_spec').show();
    }
	
});


function addCmdToTable(_cmd) {
   
}




