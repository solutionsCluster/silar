
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
            <h2 class="page-header">Listado de reportes</h2>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="<?php echo $this->url->get('report/new'); ?>" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Agregar un nuevo reporte
            </a>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $this->flashSession->output(); ?>
        </div>
    </div>
    
    <?php if ($this->length($page->items) != 0) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                <?php echo $this->partial('partials/volt_paginator_partial', array('pagination_url' => 'report/index')); ?>
            </div>
        </div>

        <?php foreach ($page->items as $item) { ?>
            <div class="block block-primary">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="block-info">
                            <div class="block-title active-account">
                                <a href="<?php echo $this->url->get('report/edit'); ?>/<?php echo $item->idReport; ?>">
                                    <?php echo $item->name; ?>
                                </a>
                            </div>
                            <div class="block-detail">
                                <?php echo $item->code; ?>
                            </div>
                            <div class="block-detail">
                                Gráfico: <?php if ($item->graphic == 1) { ?>Si<?php } else { ?>No<?php } ?>
                            </div>
			</div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="pull-right">
                            <a href="<?php echo $this->url->get('report/edit'); ?>/<?php echo $item->idReport; ?>" class="btn btn-default btn-xs tooltip-b3" data-placement="top" title="Editar este reporte">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>

                            <button class="btn btn-info btn-xs tooltip-b3" data-toggle="collapse" data-target="#detail-<?php echo $item->idReport; ?>" data-placement="top" title="Ver detalles">
                                <span class="glyphicon glyphicon-collapse-down"></span>
                            </button>
                            
                            <button class="delete-modal btn btn-danger btn-xs tooltip-b3" data-toggle="modal" href="#modal-simple" data-id="<?php echo $this->url->get('report/delete'); ?>/<?php echo $item->idReport; ?>" data-placement="top" title="Eliminar este reporte">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>	
                        </div>
                    </div>
                </div>
					
                <div id="detail-<?php echo $item->idReport; ?>" class="collapse row">
                    <hr class="line-primary">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="font-strong">Descripción: </td>
                                    <td><?php echo $item->description; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-strong">Tipo:</td>
                                    <td><?php echo $item->type; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="font-strong">Creado el:</td>
                                    <td><?php echo date('d/M/Y H:i', $item->created); ?></td>
                                </tr>
                                
                                <tr>
                                    <td class="font-strong">Última actualización:</td>
                                    <td><?php echo date('d/M/Y H:i', $item->updated); ?></td>
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
                
                <?php echo $this->partial('partials/volt_paginator_partial', array('pagination_url' => 'report/index')); ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-warning" role="alert">
                    No hay reportes creados, para crear uno haga <a href="<?php echo $this->url->get('report/new'); ?>">click aqui</a>
                </div>
            </div>
        </div>
    <?php } ?>
    
    
    <div id="modal-simple" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar reporte</h4>
                </div>
                <div class="modal-body">
                    <p>
                        ¿Está seguro que desea eliminar este reporte?
                    </p>
                    <p>
                        Recuerde que si este reporte aún esta activo (en uso por alguna cuenta) no podrá eliminarlo, en caso
                        contrario se perderán todos los datos y no podrán recuperarse, ¿Está seguro?
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="" id="delete-report" class="btn btn-danger" >Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $(document).on("click", ".delete-modal", function () {
            var myURL = $(this).data('id');
            $("#delete-report").attr('href', myURL );
        });
    </script>

                </div>
            </div>
        </div>
    </body>
</html>
