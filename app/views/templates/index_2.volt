{# La primer plantilla con boostrap 3.2.0 #}
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
		<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,200,300' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" type="image/x-icon" href="{{url('')}}images/favicon.ico">
		
        <!-- Always force latest IE rendering engine or request Chrome Frame -->
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

        {{ get_title() }}
        {{ javascript_include('js/jquery-1.11.1.min.js') }}
        {{ stylesheet_link('css/adjustments.css') }}
        {{ stylesheet_link('bootstrap-3.3.2/css/bootstrap.min.css') }}
        {{ javascript_include('bootstrap-3.3.2/js/bootstrap.min.js') }}
        {# Para cambiar el tema modificar la ruta en el siguiente enlace #}
        {#{{ stylesheet_link('bootstrap-3.2.0/css/bootstrap-theme.min.css') }}#}
		{{ stylesheet_link('css/general-media-queries.css') }}
        {% block header %}{% endblock %}
        
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
                <a class="navbar-brand navbar-brand-adjustment" href="{{url('')}}">
                    <img src="{{url('')}}{{imgbnk.relativeappimages}}/app-logo.png" class="principal-logo"/>
                </a>
            </div>
            
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right user-options" style="background-color: #428bca !important;">
				{% if userefective.enable %}
					<li style="background-color: #f0ad4e !important;">
						<a href="{{url('session/logoutfromroot')}}">Volver a la sesión original </a>
					</li>
				{% endif %}
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{userObject.name}} {{userObject.lastName}} <span class="caret"></span></a>
                        <ul class="dropdown-menu options-open" role="menu">
                            <li><a href="{{url('user/editprofile')}}">Perfil</a></li>
                            <li><a href="{{url('session/logout')}}">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
    	</div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 sidebar not-horizontal-scroll">
                    <ul class="nav nav-sidebar">
                        {% set arrow = '' %}
                        {% for item in menu.get() %} 
                            <li class="{{item.class}}" {% if item.child|length > 0%}onClick="openChild({{item.idChild}});"{% endif %}>
                                <a href="{%if item.url is empty%}javascript:void(0);{%else%}{{url(item.url)}}{%endif%}"><i class="{{item.icon}} icon-2x"></i> {{item.title}} {% if item.child|length > 0%}<span class="{{item.idChild}} {{item.arrow}}"></span>{% endif %}</a>
                                {% if item.child|length > 0%}
                                    <ul class="child-menu child-{{item.idChild}}" style="{{item.childDisplay}}">
                                        {% for child in item.child %} 
                                            <li class="{{child.class}}" onclick="location.href='{{url(child.url)}}';">
                                                <a href="{{url(child.url)}}"><i class="{{child.icon}} icon-2x"></i> {{child.title}}</a>
                                            </li>
                                        {% endfor %}
                                    </ul>
                                {% endif %}
                            </li>
                        {% endfor %}
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 col-lg-10 col-sm-offset-2 main">
                    {% block body %}
                            <!-- Aqui va el contenido -->
                    {% endblock %}
                </div>
            </div>
        </div>
    </body>
</html>
