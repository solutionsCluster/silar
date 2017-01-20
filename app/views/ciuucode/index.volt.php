
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
		<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,200,300' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->url->get(''); ?>images/favicon.ico">
		
        <!-- Always force latest IE rendering engine or request Chrome Frame -->
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

        <?php echo $this->tag->getTitle(); ?>
        <?php echo $this->tag->javascriptInclude('js/jquery-1.11.1.min.js'); ?>
        <?php echo $this->tag->stylesheetLink('css/adjustments.css'); ?>
        <?php echo $this->tag->stylesheetLink('bootstrap-3.3.2/css/bootstrap.min.css'); ?>
        <?php echo $this->tag->javascriptInclude('bootstrap-3.3.2/js/bootstrap.min.js'); ?>
        
        
		<?php echo $this->tag->stylesheetLink('css/general-media-queries.css'); ?>
        
        
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
                <a class="navbar-brand navbar-brand-adjustment" href="<?php echo $this->url->get(''); ?>">
                    <img src="<?php echo $this->url->get(''); ?><?php echo $this->imgbnk->relativeappimages; ?>/app-logo.png" class="principal-logo"/>
                </a>
            </div>
            
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right user-options" style="background-color: #428bca !important;">
				<?php if ($this->userefective->enable) { ?>
					<li style="background-color: #f0ad4e !important;">
						<a href="<?php echo $this->url->get('session/logoutfromroot'); ?>">Volver a la sesión original </a>
					</li>
				<?php } ?>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->userObject->name; ?> <?php echo $this->userObject->lastName; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu options-open" role="menu">
                            <li><a href="<?php echo $this->url->get('user/editprofile'); ?>">Perfil</a></li>
                            <li><a href="<?php echo $this->url->get('session/logout'); ?>">Cerrar sesión</a></li>
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
                            <li class="<?php echo $item->class; ?>" <?php if ($this->length($item->child) > 0) { ?>onClick="openChild(<?php echo $item->idChild; ?>);"<?php } ?>>
                                <a href="<?php if (empty($item->url)) { ?>javascript:void(0);<?php } else { ?><?php echo $this->url->get($item->url); ?><?php } ?>"><i class="<?php echo $item->icon; ?> icon-2x"></i> <?php echo $item->title; ?> <?php if ($this->length($item->child) > 0) { ?><span class="<?php echo $item->idChild; ?> <?php echo $item->arrow; ?>"></span><?php } ?></a>
                                <?php if ($this->length($item->child) > 0) { ?>
                                    <ul class="child-menu child-<?php echo $item->idChild; ?>" style="<?php echo $item->childDisplay; ?>">
                                        <?php foreach ($item->child as $child) { ?> 
                                            <li class="<?php echo $child->class; ?>" onclick="location.href='<?php echo $this->url->get($child->url); ?>';">
                                                <a href="<?php echo $this->url->get($child->url); ?>"><i class="<?php echo $child->icon; ?> icon-2x"></i> <?php echo $child->title; ?></a>
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
            <h2 class="page-header">Tabla de actividades economicas</h2>
        </div>
    </div>

    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="<?php echo $this->url->get('ciuucode/new'); ?>" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Agregar nueva actividad economica
            </a>
        </div>
    </div>
	
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="medium-space"></div>
            <?php echo $this->flashSession->output(); ?>
        </div>
    </div>

	<div class="medium-space"></div>
    <?php if ($this->length($page->items) != 0) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                <?php echo $this->partial('partials/volt_paginator_partial', array('pagination_url' => 'ciuucode/index')); ?>
            </div>
        </div>

        <?php foreach ($page->items as $item) { ?>
             <div class="block block-default">
                <div class="row">
                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                        <?php echo $item->idCiuu; ?>
                    </div>
                    
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="block-title">
                            <?php echo $item->description; ?>
                        </div>
                        <div class="block-detail">
                            Creado el <?php echo date('d/M/Y H:i', $item->created); ?> 
                        </div>
                        <div class="block-detail">
                            Actualizado el <?php echo date('d/M/Y H:i', $item->updated); ?>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right">
                        <button class="delete-modal btn btn-danger btn-xs tooltip-b3" data-toggle="modal" href="#modal-simple" data-id="<?php echo $this->url->get('ciuucode/delete'); ?>/<?php echo $item->idCiuu; ?>" data-placement="top" title="Eliminar actividad economica">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                        <a href="<?php echo $this->url->get('ciuucode/edit'); ?>/<?php echo $item->idCiuu; ?>" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="medium-space"></div>
        <?php } ?>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                
                <?php echo $this->partial('partials/volt_paginator_partial', array('pagination_url' => 'ciuucode/index')); ?>
            </div>
        </div>

    <?php } else { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                No hay actividades economicas registradas para agregar una haga <a href="<?php echo $this->url->get('ciuucode/new'); ?>">click aqui</a>
            </div>
        </div>
    <?php } ?>

    <div id="modal-simple" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar actividad economica</h4>
                </div>
                <div class="modal-body">
                    <p>
                        ¿Está seguro que desea esta actividad economica?
                    </p>
                    <p>
                        Recuerde que para poder eliminarla, ninguna cuenta debe estar inscrita con esta actividad economica, de lo
                        contrario no podrá eliminarlo
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="" id="delete-code" class="btn btn-danger" >Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $(document).on("click", ".delete-modal", function () {
            var myURL = $(this).data('id');
            $("#delete-code").attr('href', myURL );
        });
    </script>

                </div>
            </div>
        </div>
    </body>
</html>
