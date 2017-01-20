
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
		<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,200,300' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" type="image/x-icon" href="<?= $this->url->get('') ?>images/favicon.ico">
		
        <!-- Always force latest IE rendering engine or request Chrome Frame -->
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

        <?= $this->tag->getTitle() ?>
        <?= $this->tag->javascriptInclude('js/jquery-1.11.1.min.js') ?>
        <?= $this->tag->stylesheetLink('css/adjustments.css') ?>
        <?= $this->tag->stylesheetLink('bootstrap-3.3.2/css/bootstrap.min.css') ?>
        <?= $this->tag->javascriptInclude('bootstrap-3.3.2/js/bootstrap.min.js') ?>
        
        
		<?= $this->tag->stylesheetLink('css/general-media-queries.css') ?>
        
    
    
    <?php echo $this->tag->javascriptInclude('vendors/bootstrap-switch-master/bootstrap-switch.min.js'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/bootstrap-switch-master/bootstrap-switch.min.css'); ?>

    
    <?php echo $this->tag->javascriptInclude('vendors/select2-3.5.1/select2.min.js'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/select2-3.5.1/select2.css'); ?>

    <script type="text/javascript">
        $(function () {
			$(".select").select2();
            $("#select2").select2({
				allowClear: true,
				placeholder: 'Seleccionar base de datos'
            }).on("select2-selecting", function(e) {
				$('#firebird-version').hide(800);
				if (e.val === 'firebird') {
					$('#firebird-version').show(800);
				}
			});
			
			$("#select2").select2("val", "");
			
            $(".bootstrap-switch").bootstrapSwitch({
                size: 'mini',
                onColor: 'success',
                offColor: 'danger'
            });

            $('.bootstrap-switch').on('switchChange.bootstrapSwitch', function(event, state) {
                if (state) {
                    $('#status').val('1');
                }
                else {
                    $('#status').val('0');
                }
            });
        });
    </script>

        
        <script type="text/javascript">
			$('.tooltip-b3').tooltip();
			function openChild(id) {
				$(".parent-style").removeClass("parent-arrow-down");
				$(".parent-style").addClass("parent-arrow-right");
				
                $(".child-menu").hide('slow');
                $('.child-' + id).show('slow');
				$("." + id).removeClass("parent-arrow-right");
                $("." + id).addClass("parent-arrow-down");
            }
        </script>    
    </head>
    <body>
	<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".sidebar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand navbar-brand-adjustment" href="<?= $this->url->get('') ?>">
                    <img src="<?= $this->url->get('') ?><?= $this->imgbnk->relativeappimages ?>/app-logo.png" class="principal-logo"/>
                </a>
            </div>
            
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right user-options" style="background-color: #428bca !important;">
				<?php if ($this->userefective->enable) { ?>
					<li style="background-color: #f0ad4e !important;">
						<a href="<?= $this->url->get('session/logoutfromroot') ?>">Volver a la sesión original </a>
					</li>
				<?php } ?>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $this->userObject->name ?> <?= $this->userObject->lastName ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu options-open" role="menu">
                            <li><a href="<?= $this->url->get('user/editprofile') ?>">Perfil</a></li>
                            <li><a href="<?= $this->url->get('session/logout') ?>">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
    	</div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 sidebar not-horizontal-scroll">
                    <ul class="nav nav-sidebar">
                        <?php $arrow = ''; ?>
                        <?php foreach ($this->menu->get() as $item) { ?> 
                            <li class="<?= $item->class ?>" <?php if ($this->length($item->child) > 0) { ?>onClick="openChild(<?= $item->idChild ?>);"<?php } ?>>
                                <a href="<?php if (empty($item->url)) { ?>javascript:void(0);<?php } else { ?><?= $this->url->get($item->url) ?><?php } ?>"><i class="<?= $item->icon ?> icon-2x"></i> <?= $item->title ?> <?php if ($this->length($item->child) > 0) { ?><span class="<?= $item->idChild ?> <?= $item->arrow ?>"></span><?php } ?></a>
                                <?php if ($this->length($item->child) > 0) { ?>
                                    <ul class="child-menu child-<?= $item->idChild ?>" style="<?= $item->childDisplay ?>">
                                        <?php foreach ($item->child as $child) { ?> 
                                            <li class="<?= $child->class ?>" onclick="location.href='<?= $this->url->get($child->url) ?>';">
                                                <a href="<?= $this->url->get($child->url) ?>"><i class="<?= $child->icon ?> icon-2x"></i> <?= $child->title ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 col-lg-10 col-sm-offset-2 main">
                    
    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Crear una nueva cuenta</h2>
        </div>
    </div>

    <div class="medium-space"></div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="<?php echo $this->url->get('account'); ?>" class="btn btn-default btn-sm">Regresar</a>
        </div>
    </div>
    
    <div class="medium-space"></div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $this->flashSession->output(); ?>
        </div>
    </div>
    
    <div class="small-space"></div>
    
    <form action="<?php echo $this->url->get('account/new'); ?>" class="block block-default" method="post" role="form">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                   <span class="required">*</span>NIT:
                    <?php echo $AccountForm->render('nit'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Nombre de la cuenta:
                    <?php echo $AccountForm->render('aname'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Razón social:
                    <?php echo $AccountForm->render('companyName'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Ciudad:    
                    <?php echo $AccountForm->render('city'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Dirección:    
                    <?php echo $AccountForm->render('address'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Télefono:    
                    <?php echo $AccountForm->render('phone'); ?>
                </div>

                <div class="form-group">
                    Fax:  
                    <?php echo $AccountForm->render('fax'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Dirección de correo corporativo:  
                    <?php echo $AccountForm->render('email'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Actividad economica:  
                    <?php echo $AccountForm->render('idCiuu'); ?>
                </div>
					
                <div class="form-group">
                    <span class="required">*</span>Base de datos:  
                    <?php echo $AccountForm->render('database', array('class' => 'select2', 'id' => 'select2')); ?>
                </div>
					
				<div class="form-group" style="display: none;" id="firebird-version">
					<span class="required">*</span>Versión de firebird:  
					<?php echo $AccountForm->render('idFirebird', array('data-placeholder' => 'cawky parky')); ?>
				</div>

                <div class="form-group">
                    <span class="required">*</span>Estado:     
                    <?php echo $AccountForm->render('astatus'); ?>
                </div>
            </div>
        
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-6">
                <div class="form-group">
                    <span class="required">*</span>Email     
                    <?php echo $UserForm->render('email'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Nombres
                    <?php echo $UserForm->render('name'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Apellidos
                    <?php echo $UserForm->render('lastName'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Número de telefono o celular
                    <?php echo $UserForm->render('phone'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Nombre de usuario
                    <?php echo $UserForm->render('userName'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Contraseña
                    <?php echo $UserForm->render('password1'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Repita la contraseña
                    <?php echo $UserForm->render('password2'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Role
                    <?php echo $UserForm->render('idRole'); ?>
                </div>

                <div class="form-group">
                    <span class="required">*</span>Estado
                    <?php echo $UserForm->render('status'); ?>
                </div>
            </div>
        </div>  
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <a href="<?php echo $this->url->get('account'); ?>" class="btn btn-default btn-sm">Cancelar</a>
                <?php echo $this->tag->submitButton(array('Grabar', 'class' => 'btn btn-success tooltip-b3 btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => 'Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides', 'data-original-title' => 'Tooltip on left')); ?>
            </div>
        </div>
    </form>
    
    <div class="big-space"></div>

                </div>
            </div>
        </div>
    </body>
</html>
