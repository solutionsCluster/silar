
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
        
    
    
    <?= $this->tag->javascriptInclude('vendors/bootstrap-switch-master/bootstrap-switch.min.js') ?>
    <?= $this->tag->stylesheetLink('vendors/bootstrap-switch-master/bootstrap-switch.min.css') ?>

    <script type="text/javascript">
        $(function () {
            $(".switch").bootstrapSwitch({
                size: 'mini',
                onColor: 'success',
                offColor: 'danger',
            });

            $('.switch').on('switchChange.bootstrapSwitch', function(event, state) {
                var idUser = $(this).data("id");
                
                console.log(idUser);

                $.ajax({
                    url: "<?= $this->url->get('account/changeuserstatus') ?>/<?= $account->idAccount ?>/" + idUser,
                    type: "POST",			
                    data: {},
                    error: function(msg){
                        var m = msg.responseJSON;
                        $.gritter.add({class_name: 'error', title: '<span class="glyphicon glyphicon-warning-sign"></span> Error', text: m.error, time: 30000});
                    },
                    success: function(msg){
                        $.gritter.add({class_name: 'success', title: '<span class="glyphicon glyphicon-ok-sign"></span> Exitoso', text: msg.success, time: 30000});
                    }
                });
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
            <h2 class="page-header">Usuarios registrados en la cuenta <strong><?= $account->name ?></strong></h2>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="<?= $this->url->get('account') ?>" class="btn btn-sm btn-default">
                <span class="glyphicon glyphicon-step-backward"></span> regresar
            </a>
            <a href="<?= $this->url->get('account/newuser') ?>/<?= $account->idAccount ?>" class="btn btn-sm btn-primary">
                <span class="glyphicon glyphicon-plus"></span> Agregar un nuevo usuario
            </a>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?= $this->flashSession->output() ?>
        </div>
    </div>

    <?php if ($this->length($page->items) != 0) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="text-center">
                    <ul class="pagination">
                        <li class="<?= (($page->current == 1) ? 'disabled' : 'enabled') ?>">
                            <a href="<?= $this->url->get('account/showusers') ?>/<?= $account->idAccount ?>"><i class="glyphicon glyphicon-fast-backward"></i></a>
                        </li>
                        <li class="<?= (($page->current == 1) ? 'disabled' : 'enabled') ?>">
                            <a href="<?= $this->url->get('account/showusers') ?>/<?= $account->idAccount ?>?page=<?= $page->before ?>"><i class="glyphicon glyphicon-step-backward"></i></a>
                        </li>
                        <li>
                            <span><b><?= $page->total_items ?></b> registros </span><span>Página <b><?= $page->current ?></b> de <b><?= $page->total_pages ?></b></span>
                        </li>
                        <li class="<?= (($page->current >= $page->total_pages) ? 'disabled' : 'enabled') ?>">
                            <a href="<?= $this->url->get('account/showusers') ?>/<?= $account->idAccount ?>?page=<?= $page->next ?>"><i class="glyphicon glyphicon-step-forward"></i></a>
                        </li>
                        <li class="<?= (($page->current >= $page->total_pages) ? 'disabled' : 'enabled') ?>">
                            <a href="<?= $this->url->get('account/showusers') ?>/<?= $account->idAccount ?>?page=<?= $page->last ?>"><i class="glyphicon glyphicon-fast-forward"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    
        <?php foreach ($page->items as $item) { ?>
            <div class="block block-default">
                <div class="row">
                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                        <?= $item->idUser ?>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="block-title">
                            <?= $item->name ?> <?= $item->lastName ?>
                        </div>
                        <div class="block-detail">
                            <?= $item->role->name ?>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="block-title">
                            <?= $item->userName ?>
                        </div>
                        <div class="block-detail">
                            <?= $item->email ?>
                        </div>
                       
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right">
                        <input type="checkbox" data-id="<?= $item->idUser ?>" class="switch tooltip-b3" <?php if ($item->status == 1) { ?> checked <?php } ?> data-placement="top" title="Cambiar el estado de este usuario">
                        
						<a href="<?= $this->url->get('session/loginasroot') ?>/<?= $item->idUser ?>" class="btn btn-warning btn-xs tooltip-b3" data-placement="top" title="Ingresar como este usuario">
                            <span class="glyphicon glyphicon-sort"></span>
                        </a>
						
                        <a href="<?= $this->url->get('account/changepassword') ?>/<?= $account->idAccount ?>/<?= $item->idUser ?>" class="btn btn-primary btn-xs tooltip-b3" data-placement="top" title="Cambiar la contraseña de este usuario">
                            <span class="glyphicon glyphicon-lock"></span>
                        </a>
                        
                        <a href="<?= $this->url->get('account/edituser') ?>/<?= $account->idAccount ?>/<?= $item->idUser ?>" class="btn btn-primary btn-xs tooltip-b3" data-placement="top" title="Editar este usuario">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        
                        <button class="btn btn-info btn-xs tooltip-b3" data-toggle="collapse" data-target="#detail-<?= $item->idUser ?>" data-placement="top" title="Ver detalles">
                            <span class="glyphicon glyphicon-collapse-down"></span>
                        </button>
                    </div>
                </div>
                
                <div id="detail-<?= $item->idUser ?>" class="collapse row">
                    <hr class="line-primary">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td><strong>Telefono:</strong></td>
                                    <td><?= $item->phone ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        <?php if ($item->status == 1) { ?>
                                            Activo
                                        <?php } else { ?>
                                            Inactivo
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td><strong>Fecha de creación:</strong></td>
                                    <td><?= date('d/M/Y H:i', $item->created) ?> </td>
                                </tr>
                                <tr>
                                    <td><strong>Última actualización:</strong></td>
                                    <td><?= date('d/M/Y H:i', $item->updated) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                   
                </div>                  
            </div>  
            <div class="medium-space"></div>
            
            <?php } ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <ul class="pagination">
                            <li class="<?= (($page->current == 1) ? 'disabled' : 'enabled') ?>">
                                <a href="<?= $this->url->get('account/showusers') ?>/<?= $account->idAccount ?>"><i class="glyphicon glyphicon-fast-backward"></i></a>
                            </li>
                            <li class="<?= (($page->current == 1) ? 'disabled' : 'enabled') ?>">
                                <a href="<?= $this->url->get('account/showusers') ?>/<?= $account->idAccount ?>?page=<?= $page->before ?>"><i class="glyphicon glyphicon-step-backward"></i></a>
                            </li>
                            <li>
                                <span><b><?= $page->total_items ?></b> registros </span><span>Página <b><?= $page->current ?></b> de <b><?= $page->total_pages ?></b></span>
                            </li>
                            <li class="<?= (($page->current >= $page->total_pages) ? 'disabled' : 'enabled') ?>">
                                <a href="<?= $this->url->get('account/showusers') ?>/<?= $account->idAccount ?>?page=<?= $page->next ?>"><i class="glyphicon glyphicon-step-forward"></i></a>
                            </li>
                            <li class="<?= (($page->current >= $page->total_pages) ? 'disabled' : 'enabled') ?>">
                                <a href="<?= $this->url->get('account/showusers') ?>/<?= $account->idAccount ?>?page=<?= $page->last ?>"><i class="glyphicon glyphicon-fast-forward"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                No hay usuarios registrados para agregar uno, haga <a href="<?= $this->url->get('account/newuser') ?>/<?= $account->idAccount ?>">click aqui</a>
            </div>
        </div>
    <?php } ?>

                </div>
            </div>
        </div>
    </body>
</html>
