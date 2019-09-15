<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'datatransfert');
$eqLogics = eqLogic::byType('datatransfert');
?>

<script type="text/javascript">
  var backup_path = "<?php echo realpath(calculPath(config::byKey('backup::path'))); ?>";
</script>

<div class="row row-overflow">
	<div class="col-xs-12 eqLogicThumbnailDisplay">
		<legend><i class="icon loisir-two28"></i> {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction logoPrimary" data-action="add" >
				<i class="fas fa-plus-circle"></i>
				<br/>
				<span>{{Ajouter}}</span>
			</div>
		</div>
		<legend><i class="fas fa-table"></i> {{Mes Equipements Datatransfert}}</legend>
		<input class="form-control" placeholder="{{Rechercher}}" id="in_searchEqlogic" />
		<div class="eqLogicThumbnailContainer">
			<?php
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '" >';
				echo '<img src="plugins/datatransfert/doc/images/datatransfert_icon.png"  />';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			?>
		</div>
	</div>
    <div class="col-xs-12 eqLogic" style="display: none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-default btn-sm eqLogicAction" data-action="configure"><i class="fas fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
        <ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
            <li role="presentation"><a href="#eqparatab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-wrench"></i> {{Paramètres}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-list-alt"></i> {{Commandes}}</a></li>
		</ul>
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<br/>
				<form class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<label class="col-sm-2 control-label">{{Nom de l'équipement virtuel}}</label>
							<div class="col-sm-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
								<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement virtuel}}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >{{Objet parent}}</label>
							<div class="col-sm-3">
								<select class="form-control eqLogicAttr" data-l1key="object_id">
									<option value="">{{Aucun}}</option>
									<?php
									foreach (jeeObject::all() as $object) {
										echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">{{Catégorie}}</label>
							<div class="col-sm-8">
								<?php
								foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
									echo '<label class="checkbox-inline">';
									echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
									echo '</label>';
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{Type}}</label>
                            <div class="col-sm-3">
                                <select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="protocol">
                                    <option disabled selected value>-- {{Choisir un type}} --</option>
                                    <?php
                                    foreach (datatransfert::supportedProtocol() as $protocol) {
                                        echo '<option value="' . $protocol . '">' . $protocol . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">

                        </div>
                    </fieldset>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="eqparatab">
                <br/>
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{Type}}</label>
                            <div class="col-sm-3">
                                <select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="protocol">
                                    <option disabled selected value>-- {{Choisir un type}} --</option>
                                    <?php
                                    foreach (datatransfert::supportedProtocol() as $protocol) {
                                        echo '<option value="' . $protocol . '">' . $protocol . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        
	<div class="form-group cancontrol">
		<label class="col-sm-6 control-label help" data-help="{{Utile pour savoir quelle antenne contrôlera l'équipement. Choisir Tous aura la conséquence de déclencher potentiellement l'action autant de fois qu'il y a d'antennes}}">{{Antenne d'émission}}</label>
		<div class="col-sm-4">
			<select class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="antenna">
				<?php
				if (config::byKey('noLocal', 'blea', 0) == 0){
					echo '<option value="local">{{Local}}</option>';
				}
				try{
					$hasblea = plugin::byId('blea');
					} catch (Exception $e) {
				}
				if ($hasblea != '' && $hasblea->isActive()){
					$remotes = blea_remote::all();
					foreach ($remotes as $remote) {
						echo '<option value="' . $remote->getId() . '">{{Remote : ' . $remote->getRemoteName() .'}}</option>';
					}
				}
				?>
				<option value="all">{{Tous}}</option>
			</select>
		</div>
	</div>
             <div class="row">
      <div class="col-sm-6">
        <form class="form-horizontal">
          <fieldset>
	<legend><i class="fab fa-bluetooth"></i>  {{Antennes}}</legend>
	
		</fieldset>
    </form>
  </div>

</div>
                                 
                        
                        
                        
                        
                        
                        
                        <div class="form-group">
                            <div id="div_protocolParameters"></div>
                        </div>
                    </fieldset>
                </form>
				
			</div>
            <div role="tabpanel" class="tab-pane" id="commandtab">
				<a class="btn btn-default btn-sm pull-right cmdAction" data-action="add" style="margin-top:5px;"><i class="fas fa-plus-circle"></i> {{Ajouter une commande Data transfert}}</a>
				<br/><br/>
				<table id="table_cmd" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th style="width: 330px;">{{Nom}}</th>
							<th style="width: 550px;">{{source}}</th>
                            <th style="width: 550px;">{{cible}}</th>
                            <th style="width: 210px;">{{filtre}}</th>
							<th>{{Valeur}}</th>
							<th style="width: 50px;"></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				
			</div>
            
    </div>
    
    

    
    
    
    
    
    
</div>































<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un équipement}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
?>
           </ul>
       </div>
   </div>

   <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
    <legend><i class="icon techno-memory"></i>  {{Mes Equipements Datatransfert}}
    </legend>
    <div class="eqLogicThumbnailContainer">
      <div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
            <i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
        <br>
        <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">Ajouter</span>
    </div>
    <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
	echo '<img src="plugins/datatransfert/doc/images/datatransfert_icon.png" height="105" width="95" />';
	echo "<br>";
	echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
	echo '</div>';
}
?>
</div>
</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
    <div class="row">
        <div class="col-sm-6">
            <form class="form-horizontal">
                <fieldset>
                    <legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}<i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{Nom de l'équipement Data transfert}}</label>
                        <div class="col-sm-4">
                            <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                            <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement Data transfert}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" >{{Objet parent}}</label>
                        <div class="col-sm-6">
                            <select class="eqLogicAttr form-control" data-l1key="object_id">
                                <option value="">{{Aucun}}</option>
                                <?php
foreach (jeeobject::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?>
                           </select>
                       </div>
                   </div>
                   <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                    	<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
			<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                   </div>
               </div>
               <div class="form-group">
                <label class="col-sm-3 control-label">{{Type}}</label>
                <div class="col-sm-4">
                    <select class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="protocol">
					    <option disabled selected value>-- {{Choisir un type}} --</option>
<?php
  foreach (datatransfert::supportedProtocol() as $protocol) {
    echo '<option value="' . $protocol . '">' . $protocol . '</option>';
  }
?>
                   </select>
               </div>
           </div>
       </fieldset>
   </form>
</div>
<div class="col-sm-6">
    <form class="form-horizontal">
        <fieldset>
            <legend><i class="fa fa-wrench"></i> {{Paramètres}}</legend>
            <div id="div_protocolParameters"></div>
        </fieldset>
    </form>
</div>
</div>
<legend><i class="fa fa-list-alt"></i> {{Data transfert}}</legend>


<a class="btn btn-success btn-sm cmdAction" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter une commande Data transfert}}</a><br/><br/>
<table id="table_cmd" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>{{Nom}}</th><th>{{Source}}</th><th>{{Cible}}</th><th>{{Filtre}}</th><th></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<form class="form-horizontal">
    <fieldset>
        <div class="form-actions">
            <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
            <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
        </div>
    </fieldset>
</form>

</div>
</div>

<?php include_file('desktop', 'datatransfert', 'js', 'datatransfert');?>
<?php include_file('core', 'plugin.template', 'js');?>