
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
			
	<hr class="line-primary">
	<div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
			<div class="logo-page-error">
				<a href="http://solutionscluster.net/" target="_blank">
					<img src="<?php echo $this->url->get(''); ?><?php echo $this->imgbnk->relativeappimages; ?>/app-logo.png" class="app-logo" style="margin-bottom: 10px;"/>
				</a>
			</div>
		</div>
	</div>
	
	<div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
				<div class="panel-page-error">
					<div class="avatar-page-error">
						<span class="glyphicon glyphicon-exclamation-sign"></span>
					</div>
					<div class="code-page-error">
						404
					</div>
					<div class="text-page-error">
						Página no encontrada <a href="<?php echo $this->url->get(''); ?>"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr class="line-primary">

		</div>
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<?= $this->tag->javascriptInclude('bootstrap-3.3.2/js/bootstrap.min.js') ?>
	</body>
</html>
