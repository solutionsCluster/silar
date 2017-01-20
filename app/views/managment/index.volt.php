
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
        
    
	
    <?= $this->tag->stylesheetLink('vendors/hover-effect-ideas/css/set2.css') ?>

        
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
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="<?= $this->url->get('account') ?>">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="<?= $this->url->get('') ?>images/company-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Perfiles de <span>Cuentas</span></div>
							<p>Administre todas las cuentas de la aplicación</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="<?= $this->url->get('user') ?>">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="<?= $this->url->get('') ?>images/user-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Perfiles de <span>usuarios</span></div>
							<p>Administre los usuarios de la cuenta</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="<?= $this->url->get('imagebank') ?>">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="<?= $this->url->get('') ?>images/bank-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Banco de <span>imágenes</span></div>
							<p>Administre las imágenes que aparecen en el inicio de sesión de la aplicación</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="<?= $this->url->get('paymentplan') ?>">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="<?= $this->url->get('') ?>images/payment-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Planes de <span>pago</span></div>
							<p>Administre los planes de pago que se ofrecen a los clientes</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="<?= $this->url->get('ciuucode') ?>">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="<?= $this->url->get('') ?>images/industry-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Actividades <span>economicas</span></div>
							<p>Administre las actividades economicas a las que pueden pertenecer las compañias</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			 <a href="<?= $this->url->get('') ?>permissionsystem#/resources">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="<?= $this->url->get('') ?>images/security-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Permisos de <span>usuario</span></div>
							<p>Administre los permisos de cada usuario en la aplicación</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
	
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="<?= $this->url->get('report') ?>">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="<?= $this->url->get('') ?>images/report-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Administración de <span>reportes</span></div>
							<p>Cree, edite o elimine reportes de la aplicación</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
	</div>
    <div class="big-space"></div>

                </div>
            </div>
        </div>
    </body>
</html>
