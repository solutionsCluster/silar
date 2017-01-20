
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
        var url = '<?php echo $this->urlManager->getAPIUrl1(); ?>';
    </script>
    <?php echo $this->partial('partials/ember_partial'); ?>
    <?php echo $this->tag->javascriptInclude('vendors/ember-1.7.0/mixin-save.js'); ?>
    <?php echo $this->tag->javascriptInclude('js/ember-permission-system/app-permission-system.js'); ?>

        
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
                    
    <div id="emberAppContainer">
		<script type="text/x-handlebars"> 
			<div class="big-space"></div>
            <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2 class="page-header">Sistema de permisos</h2>
				</div>
            </div>
            <div class="big-space"></div>
    
            <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-pills">
						<?php echo '{{#link-to "roles" tagName="li" href=false}}<a {{bind-attr href="view.href"}} class="pointer">Roles</a>{{/link-to}}'; ?>
						<?php echo '{{#link-to "resources" tagName="li" href=false}}<a {{bind-attr href="view.href"}} class="pointer">Recursos</a>{{/link-to}}'; ?>
						<?php echo '{{#link-to "actions" tagName="li" href=false}}<a {{bind-attr href="view.href"}} class="pointer">Acciones</a>{{/link-to}}'; ?>
						<?php echo '{{#link-to "relationships" tagName="li" href=false}}<a {{bind-attr href="view.href"}} class="pointer">Relaciones</a>{{/link-to}}'; ?>
					</ul>
                    
                    <div class="big-space"></div>
                    <?php echo '{{outlet}}'; ?>
                </div>
            </div>
        </script>
        
        <?php echo $this->partial('permissionsystem/partials/resources_partial'); ?>
        <?php echo $this->partial('permissionsystem/partials/roles_partial'); ?>
		<?php echo $this->partial('permissionsystem/partials/actions_partial'); ?>
		<?php echo $this->partial('permissionsystem/partials/relationships_partial'); ?>
		
		<div class="big-space"></div>
    </div>
	<div class="big-space"></div>
	<div class="big-space"></div>

                </div>
            </div>
        </div>
    </body>
</html>
