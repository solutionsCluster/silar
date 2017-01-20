{% extends "templates/index_2.volt" %}
{% block header %}
	{{ super() }}

	{# Notifications #}
	{{ stylesheet_link('vendors/notification-styles/css/ns-default.css') }}
	{{ stylesheet_link('vendors/notification-styles/css/ns-style-growl.css') }}
	{{ javascript_include('vendors/notification-styles/js/modernizr.custom.js')}}
	{{ javascript_include('vendors/notification-styles/js/classie.js')}}
	{{ javascript_include('vendors/notification-styles/js/notificationFx.js')}}

	<script type="text/javascript">
		function saveChanges() {
			var configData = $('#configData').val();
			$.ajax({
				data:  {configData: configData},
                url:   "{{url('system/configure')}}",
                type:  "post",
                error: function(msg){
					var notification = new NotificationFx({
						wrapper : document.body,
						message : '<p>' + msg.responseJSON.msg + '</p>',
						layout : 'growl',
						effect : 'slide',
						ttl : 15000,
					type : 'error'
					});
					// show the notification
					notification.show();
				},
				success: function(msg){
					var notification = new NotificationFx({
						wrapper : document.body,
						message : '<p>' + msg.msg + '</p>',
						layout : 'growl',
						effect : 'slide',
						ttl : 15000,
						type : 'success'
					});
					// show the notification
					notification.show();
				}
			});
		}
	</script>
{% endblock %}
{% block body %}
	<div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Editar <strong style="color: #d43f3a;">archivo de configuración del sistema</strong></h2>
			<div class="subtitle">
				El archivo de configuración del sistema, es el corazón de la aplicación. Aqui puede configurar el acceso a la base de
				datos, el estado del sistema, la ruta de los directorios del banco de imagenes, la ruta hacia las bases de datos de firebird, configuración
				del smtp, protocolos, hosts y mucho más. Por favor no realice cambios en este archivo si no esta seguro. 
			</div>
			<div class="big-space"></div>
        </div>
    </div>
	
	<div class="big-space"></div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<textarea class="form-control block block-danger" rows="10" id="configData">{{config}}</textarea>
		</div>
	</div>
	<div class="big-space"></div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			<a href="{{url('system')}}" class="btn btn-sm btn-default">Cancelar</a>
			<a href="#myModal" class="btn btn-sm btn-danger" data-toggle="modal" data-target="">Guardar</a>
		</div>
	</div>
	
	<div class="big-space"></div>
	
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Editar archivo de configuración del sistema</h4>
				</div>
				<div class="modal-body">
					<h5>
						Esta a punto de editar el archivo de configuración del sistema, recuerde que cualquier cambio efectuado
						en este archivo cambiará el funcionamiento de la plataforma. 
					</h5>
					
					<h4>
						<strong>¿Esta seguro de querer editarlo?</strong>
					</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-sm btn-danger" id="confirm-edit-button" data-dismiss="modal">Sí, estoy seguro</button>
				</div>
			</div>
		</div>
	</div>	
	
	<script type="text/javascript">
		$(function() {
			$('#confirm-edit-button').on('click', function() {
				saveChanges();
			});
		});
	</script>
{% endblock %}
