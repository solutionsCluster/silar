
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
		
		<?= $this->tag->stylesheetLink('css/adjustments.css') ?>
		<?= $this->tag->stylesheetLink('bootstrap-3.3.2/css/bootstrap.min.css') ?>
		
		
        <?= $this->tag->stylesheetLink('bootstrap-3.3.2/css/bootstrap-theme.min.css') ?>
		<?= $this->tag->stylesheetLink('css/login-page-media-queries.css') ?>
		
	</head>
	<body>
		<div class="container-fluid">
			
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default login-box">
                <div class="panel-sidebar">
                    <img src="<?= $this->url->get('') ?><?= $this->loginimage->loadImageDir() ?>" class="principal-image" />
                </div>
                <div class="panel-body panel-content">
                    <div class="logo-header">
                        <div class="app-logo-container">
                            <a href="http://solutionscluster.net/" target="_blank">
                                <img src="<?= $this->url->get('') ?><?= $this->imgbnk->relativeappimages ?>/app-logo.png" class="app-logo"/>
                            </a>
                        </div>
                        <div class="client-logo-container">
                            <img src="<?= $this->url->get('') ?><?= $this->imgbnk->relativeuserdir ?>/your-logo.jpg" class="client-logo"/>
                        </div>
                    </div>

                    <div class="big-space"></div>

                    <form action="<?= $this->url->get('session/validatesession') ?>" method="post">
                        <p><?= $this->flashSession->output() ?></p>
                        <div class="small-space"></div>
                        
                        <input type="hidden" name="<?= $this->security->getTokenKey() ?>" value="<?= $this->security->getToken() ?>"/>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="userName" class="form-control" placeholder="Nombre de usuario">
                        </div>

                        <div class="small-space"></div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Contraseña">
                        </div>

                        <div class="small-space"></div>

                        <div class="input-group" style="width: 100%;">
                            <input type="submit" class="btn btn-primary pull-right" value="Iniciar sesión">
                        </div>
                        
						<div class="big-space"></div>
						
                        <div class="input-group" style="width: 100%;">
                            <p class="text-center">
                                <a href="<?= $this->url->get('session/recoverpassword') ?>">¿Olvidaste tu contraseña?</a> - <a href="http://solutionscluster.net/silar" target="_blank">¿Qué es esto?</a>
                            </p>
                        </div>
                    </form>
                </div>
                <div class="panel-footer" style="display: inline-block; width: 100%;">
                    <p class="text-center small-text">
                        Todos los derechos reservados <a href="http://solutionscluster.net/" target="_blank">Cluster Solutions</a> - Copyright &copy; 2013
                    </p>
                </div>
            </div>
        </div>
    </div>

		</div>
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<?= $this->tag->javascriptInclude('bootstrap-3.3.2/js/bootstrap.min.js') ?>
	</body>
</html>
