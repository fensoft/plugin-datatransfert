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
    <label class="col-sm-3 control-label">{{Installation RClone}}</label>
    <div class="col-sm-4">
        <a class="btn btn-primary btn-xs" href='https://rclone.org/' target="_blank">{{Lien}}</a>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{Configurateur automatique Windows}}</label>
    <div class="col-sm-4">
        <a class="btn btn-primary btn-xs" href='plugins/datatransfert/external/rclone_windows/jeedom-rclone-configurator.zip' target="_blank">{{Lien}}</a>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{Configurateur automatique Mac}}</label>
    <div class="col-sm-4">
        <a class="btn btn-primary btn-xs" href='plugins/datatransfert/external/rclone_mac/jeedom-rclone-configurator.zip' target="_blank">{{Lien}}</a>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{Configuration RClone}}</label>
    <div class="col-sm-4">
        <textarea rows="10" style="width: 300px;" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="rclone"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{Vitesse limite (ko/s)}}</label>
    <div class="col-sm-4">
        <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="speed" value="" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{Scinder les logs}}</label>
    <div class="col-sm-4">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="splitLogs"/>{{Scinder les logs}}</label>
    </div>
</div>