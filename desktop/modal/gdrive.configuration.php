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

if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<div class="form-group">
    <label class="col-sm-2 control-label">{{Installation Google Drive}}</label>
    <div class="col-sm-6">
        <a class="btn btn-primary btn-xs" href='https://github.com/ivanvermeyen/laravel-google-drive-demo/tree/master/README' target="_blank">{{Lien}}</a>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{App client id}}</label>
    <div class="col-sm-6">
        <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="clientId"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{App client secret}}</label>
    <div class="col-sm-6">
        <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="clientSecret"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{Refresh token}}</label>
    <div class="col-sm-6">
        <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="accessToken"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{Supprimer fichiers dupliqués}}</label>
    <div class="col-sm-6">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="remove_dupes" checked/>{{Supprimer fichiers dupliqués}}</label>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{Type de cible}}</label>
    <div class="col-sm-6">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="truePath" checked/>{{Oui: chemin}}<br/>{{Non: folderid}}</label>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{Préfixer par le path dans le nom}}</label>
    <div class="col-sm-6">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="prefixPath"/>{{Oui: path_nom.txt}}<br/>{{Non: nom.txt}}</label>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{Progression précise}}</label>
    <div class="col-sm-6">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="preciseProgress"/>{{Progression précise}}</label>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{Vitesse limite (ko/s)}}</label>
    <div class="col-sm-6">
        <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="speed" value="" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">{{Scinder les logs}}</label>
    <div class="col-sm-6">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="splitLogs"/>{{Scinder les logs}}</label>
    </div>
</div>
