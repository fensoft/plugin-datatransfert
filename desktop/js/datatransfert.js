
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
 function prePrintEqLogic() {
    $('.eqLogicAttr[data-l1key=configuration][data-l2key=protocol]').off();
}


function  printEqLogic(_eqLogic) {
    $.showLoading();
    $('.eqLogicAttr[data-l1key=configuration][data-l2key=protocol]').off();
    if (isset(_eqLogic.configuration) && isset(_eqLogic.configuration.protocol)) {
        $('#div_protocolParameters').load('index.php?v=d&plugin=datatransfert&modal=' + _eqLogic.configuration.protocol + '.configuration', function () {
            $('body').setValues(_eqLogic, '.eqLogicAttr');
            initCheckBox();
            $('.eqLogicAttr[data-l1key=configuration][data-l2key=protocol]').off().on('change', function () {
                $('#div_protocolParameters').load('index.php?v=d&plugin=datatransfert&modal=' + $(this).val() + '.configuration',function(){
                    initCheckBox();
                });
            });
            modifyWithoutSave = false;
            $.hideLoading();
        });
    } else {
        $('.eqLogicAttr[data-l1key=configuration][data-l2key=protocol]').on('change', function () {
            $('#div_protocolParameters').load('index.php?v=d&plugin=datatransfert&modal=' + $(this).val() + '.configuration',function(){
                initCheckBox();
            });
        });
        $.hideLoading();
    }
}

function addCmdToTable(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }
    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
    tr += '<td>';
    tr += '<span class="cmdAttr" data-l1key="id"></span>';
    tr += '</td>';
    tr += '<td>';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="id" style="display : none;">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="name">';
    tr += '</td>';
    tr += '<td>';
    if (init(_cmd.eqType) != 'datatransfertInfo') {
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="source" placeholder="{{Source}}" value="' + backup_path + '">';
    }
    tr += '</td>';
    tr += '<td>';
    if (init(_cmd.eqType) != 'datatransfertInfo') {
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="cible" placeholder="{{Cible}}">';
    }
    tr += '</td>';
    tr += '<td>';
    if (init(_cmd.eqType) != 'datatransfertInfo') {
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="filter_file" placeholder="{{Filtre sur fichier}}">';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="filter_recentfile" placeholder="{{n\'envoyer que X fichiers + recent}}" style="margin-top : 5px;">';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="remove_old" placeholder="{{ne conserver que X fichiers + recent}}" style="margin-top : 5px;">';
    }
    tr += '</td>';
    tr += '<td>';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="type" value="action" style="display : none;">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="subType" value="other" style="display : none;">';
    if (is_numeric(_cmd.id)) {
        tr += '<a class="btn btn-default btn-xs cmdAction expertModeVisible" data-action="configure"><i class="fas fa-cogs"></i></a> ';
        if (init(_cmd.eqType) != 'datatransfertInfo')
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> {{Tester}}</a>';
    }
    tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
    tr += '</tr>';
    $('#table_cmd tbody').append(tr);
    $('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
}