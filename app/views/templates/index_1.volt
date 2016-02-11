{# La primer plantilla con boostrap 3.2.0 #}
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=1">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
		<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,200,300' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" type="image/x-icon" href="{{url('')}}images/favicon48x48.ico">
		<!-- Always force latest IE rendering engine or request Chrome Frame -->
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
		
		{{ stylesheet_link('css/adjustments.css') }}
		{{ stylesheet_link('bootstrap-3.2.0/css/bootstrap.min.css') }}
		
		{# Para cambiar el tema modificar la ruta en el siguiente enlace#}
        {{ stylesheet_link('bootstrap-3.2.0/css/bootstrap-theme.min.css') }}
		{{ stylesheet_link('css/login-page-media-queries.css') }}
		{% block header %}{% endblock %}
	</head>
	<body>
		<div class="container-fluid">
			{% block body %}
				<!-- Aqui va el contenido -->
			{% endblock %}
		</div>
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		{{ javascript_include('bootstrap-3.2.0/js/bootstrap.min.js') }}
	</body>
</html>
