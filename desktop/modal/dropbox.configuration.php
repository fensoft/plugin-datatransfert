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
    <label class="col-sm-3 control-label">{{Installation Dropbox}}</label>
    <div class="col-sm-4">
        <a class="btn btn-primary btn-xs" href='https://www.dropbox.com/developers/apps' target="_blank">{{Lien}}</a>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{App key}}</label>
    <div class="col-sm-4">
        <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="clientId"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{App secret}}</label>
    <div class="col-sm-4">
        <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="clientSecret"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{Generated access token}}</label>
    <div class="col-sm-4">
        <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="accessToken"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">{{Scinder les logs}}</label>
    <div class="col-sm-4">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="splitLogs"/>{{Scinder les logs}}</label>
    </div>
</div>

