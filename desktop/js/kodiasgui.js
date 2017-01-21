
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


// Global

$(document).ready(function() {  

    $('#sel_plan_home').change(function(){
		var isel= $(this).find("option:selected").attr('value');
  
		if ( isel != undefined )	
			updateEqTable(isel ,"cmdHome");
    });
	
    $('#sel_plan_info').change(function(){
		var isel= $(this).find("option:selected").attr('value');
  
		if ( isel != undefined )	
			updateEqTable(isel ,"cmdInfos");
    });	
	
    $('#sel_plan_light').change(function(){
		var isel= $(this).find("option:selected").attr('value');
  
		if ( isel != undefined )	
			updateEqTable(isel ,"cmdLigths");
    });
	
    $('#sel_plan_security').change(function(){
		var isel= $(this).find("option:selected").attr('value');
  
		if ( isel != undefined )	
			updateEqTable(isel ,"cmdAcces");
    });	
	
    $('#sel_plan_thermo').change(function(){
		var isel= $(this).find("option:selected").attr('value');
  
		if ( isel != undefined )	
			updateEqTable(isel ,"cmdTherms");
    });
	
    $('#sel_plan_equip').change(function(){
		var isel= $(this).find("option:selected").attr('value');
  
		if ( isel != undefined )	
			updateEqTable(isel ,"cmdEquip");
    });	

	
 });

	
function addRow( _equip,_index , _table) {


	if (_equip.type == 'Shortcut')
	{
		htmlshort = '';
		
	}
else
	{
	var tr = '<tr class="trequip" data-cfg_index="' + _index + '" >';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="'+ _table +'_'+ _index+'_id" readonly />'
	tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="'+ _table +'_'+ _index+'_name" readonly />'
	tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="'+ _table +'_'+ _index+'_alias" />';
	tr += '</td>';
	tr += '<td>';
	tr += '<input type="text" class="eqcfg form-control" cfg-name="'+ _table +'_'+ _index+'_type" />';
	tr += '</td>';
	tr += '</tr>';	

	
	if ( _table == 'cmdHome' )
		{
		$('#table_cmdhome tbody').append(tr);
		$('#table_cmdhome tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_id]').val(_equip.id);
		$('#table_cmdhome tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_name]').val(_equip.name);
		$('#table_cmdhome tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_alias]').val(_equip.alias);
		$('#table_cmdhome tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_type]').val(_equip.type);
		}
		
	if ( _table == 'cmdInfos' )
		{
		$('#table_cmdinfo tbody').append(tr);
		$('#table_cmdinfo tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_id]').val(_equip.id);
		$('#table_cmdinfo tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_name]').val(_equip.name);
		$('#table_cmdinfo tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_alias]').val(_equip.alias);
		$('#table_cmdinfo tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_type]').val(_equip.type);
		}		
	if ( _table == 'cmdLigths' )
		{
		$('#table_cmdlight tbody').append(tr);
		$('#table_cmdlight tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_id]').val(_equip.id);
		$('#table_cmdlight tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_name]').val(_equip.name);
		$('#table_cmdlight tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_alias]').val(_equip.alias);
		$('#table_cmdlight tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_type]').val(_equip.type);
		}
		
	if ( _table == 'cmdAcces' )
		{
		$('#table_cmdacces tbody').append(tr);
		$('#table_cmdacces tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_id]').val(_equip.id);
		$('#table_cmdacces tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_name]').val(_equip.name);
		$('#table_cmdacces tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_alias]').val(_equip.alias);
		$('#table_cmdacces tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_type]').val(_equip.type);
		}	
	if ( _table == 'cmdTherms' )
		{
		$('#table_cmdthermo tbody').append(tr);
		$('#table_cmdthermo tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_id]').val(_equip.id);
		$('#table_cmdthermo tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_name]').val(_equip.name);
		$('#table_cmdthermo tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_alias]').val(_equip.alias);
		$('#table_cmdthermo tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_type]').val(_equip.type);
		}
		
	if ( _table == 'cmdEquip' )
		{
		$('#table_cmdequip tbody').append(tr);
		$('#table_cmdequip tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_id]').val(_equip.id);
		$('#table_cmdequip tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_name]').val(_equip.name);
		$('#table_cmdequip tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_alias]').val(_equip.alias);
		$('#table_cmdequip tbody').find('.eqcfg[cfg-name='+ _table +'_'+ _index+'_type]').val(_equip.type);
		}			
		   
		
	}
}



function updateEqTable( _planid , _table) {
	
		if (_table == "cmdHome" )
			$('#table_cmdhome tbody').empty();
		if (_table == "cmdInfos" )
			$('#table_cmdinfo tbody').empty();
		if (_table == "cmdLigths" )
			$('#table_cmdlight tbody').empty();
		if (_table == "cmdAcces" )
			$('#table_cmdacces tbody').empty();	    
		if (_table == "cmdTherms" )
			$('#table_cmdthermo tbody').empty();
		if (_table == "cmdEquip" )
			$('#table_cmdequip tbody').empty();
		
		$.ajax({
		type: "POST",
		url: "plugins/kodiasgui/core/ajax/kodiasgui.ajax.php", 
		data: {
			action: "getKodiCfg",
			planid: _planid
		},
		dataType: 'json',
		error: function (request, status, error) {
			handleAjaxError(request, status, error);
		},
		success: function (data) {
			
			if (data.state !== 'ok') {
				$('#div_alert').showAlert({message: data.result, level: 'danger'});
				return;
			}
			// la liste des équipements
			var eqlist = data.result;
			var idx =0;
			for (var eq  in eqlist) {
				addRow(eqlist[eq],idx++,_table);
			}

		}
	});
	
	
}

function sendUpdateEquip(_eqLogic) {
	$.ajax({
		type: "POST",
		url: "plugins/kodiasgui/core/ajax/kodiasgui.ajax.php", 
		data: {
			action: "setKodiCfg",
			eqid: _eqLogic.id,
			eqalias: _eqLogic.alias,
			eqtype: _eqLogic.type
		},
		dataType: 'text',
		error: function (request, status, error) {
			handleAjaxError(request, status, error);
		},
		success: function (result) {}
	});	
	
}

function saveEqLogic(_eqLogic) {

//	console.log("debug ici");
	var equip = { index : 0 , name : '', id : '' , type : '' , alias : '' };
	
  $('#table_cmdhome tbody .trequip').each(function () {

        equip.index = $(this).attr('data-cfg_index');
		equip.id = $(this).find('.eqcfg[cfg-name=cmdHome_'+equip.index+'_id]').value();
		equip.name = $(this).find('.eqcfg[cfg-name=cmdHome_'+equip.index+'_name]').value();
        equip.alias = $(this).find('.eqcfg[cfg-name=cmdHome_'+equip.index+'_alias]').value();
        equip.type = $(this).find('.eqcfg[cfg-name=cmdHome_'+equip.index+'_type]').value();

       sendUpdateEquip(equip);

    });

  $('#table_cmdinfo tbody .trequip').each(function () {

        equip.index = $(this).attr('data-cfg_index');
		equip.id = $(this).find('.eqcfg[cfg-name=cmdInfos_'+equip.index+'_id]').value();
		equip.name = $(this).find('.eqcfg[cfg-name=cmdInfos_'+equip.index+'_name]').value();
        equip.alias = $(this).find('.eqcfg[cfg-name=cmdInfos_'+equip.index+'_alias]').value();
        equip.type = $(this).find('.eqcfg[cfg-name=cmdInfos_'+equip.index+'_type]').value();

       sendUpdateEquip(equip);

    });
	
  $('#table_cmdlight tbody .trequip').each(function () {

        equip.index = $(this).attr('data-cfg_index');
		equip.id = $(this).find('.eqcfg[cfg-name=cmdLigths_'+equip.index+'_id]').value();
		equip.name = $(this).find('.eqcfg[cfg-name=cmdLigths_'+equip.index+'_name]').value();
        equip.alias = $(this).find('.eqcfg[cfg-name=cmdLigths_'+equip.index+'_alias]').value();
        equip.type = $(this).find('.eqcfg[cfg-name=cmdLigths_'+equip.index+'_type]').value();

        sendUpdateEquip(equip);

    });

  $('#table_cmdacces tbody .trequip').each(function () {

        equip.index = $(this).attr('data-cfg_index');
		equip.id = $(this).find('.eqcfg[cfg-name=cmdAcces_'+equip.index+'_id]').value();
		equip.name = $(this).find('.eqcfg[cfg-name=cmdAcces_'+equip.index+'_name]').value();
        equip.alias = $(this).find('.eqcfg[cfg-name=cmdAcces_'+equip.index+'_alias]').value();
        equip.type = $(this).find('.eqcfg[cfg-name=cmdAcces_'+equip.index+'_type]').value();

        sendUpdateEquip(equip);

    });
  $('#table_cmdthermo tbody .trequip').each(function () {

        equip.index = $(this).attr('data-cfg_index');
		equip.id = $(this).find('.eqcfg[cfg-name=cmdTherms_'+equip.index+'_id]').value();
		equip.name = $(this).find('.eqcfg[cfg-name=cmdTherms_'+equip.index+'_name]').value();
        equip.alias = $(this).find('.eqcfg[cfg-name=cmdTherms_'+equip.index+'_alias]').value();
        equip.type = $(this).find('.eqcfg[cfg-name=cmdTherms_'+equip.index+'_type]').value();

        sendUpdateEquip(equip);

    });

  $('#table_cmdequip tbody .trequip').each(function () {

        equip.index = $(this).attr('data-cfg_index');
		equip.id = $(this).find('.eqcfg[cfg-name=ccmdEquip_'+equip.index+'_id]').value();
		equip.name = $(this).find('.eqcfg[cfg-name=cmdEquip_'+equip.index+'_name]').value();
        equip.alias = $(this).find('.eqcfg[cfg-name=cmdEquip_'+equip.index+'_alias]').value();
        equip.type = $(this).find('.eqcfg[cfg-name=cmdEquip_'+equip.index+'_type]').value();

        sendUpdateEquip(equip);

    });	
	
	return _eqLogic;
	
}
 

function printEqLogic(_eqLogic) {


}
 

function addCmdToTable(_cmd) {
   
}



