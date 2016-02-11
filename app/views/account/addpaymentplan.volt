{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}
	<script type="text/javascript">
		var url = '{{urlManager.getBaseUrl(true)}}';
		var idAccount = '{{account.idAccount}}';
		var today = '{{date('d-m-Y H:m')}}';
		$(function(){
			var draggable = new DraggableItemSystem();
			draggable.setContainer('container');
			draggable.initialize();
		});
	</script>	
    {# Select 2#}
    {{ javascript_include('vendors/select2-3.5.1/select2.min.js')}}
    {{ stylesheet_link('vendors/select2-3.5.1/select2.css') }}
	
	{# Moment.js #}
    {{ javascript_include('vendors/moment/moment-2.8.4.js')}}
	
	{# date picker 2#}
    {{ stylesheet_link('vendors/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}
    {{ javascript_include('vendors/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js')}}
	
    {# Jquery UI#}
    {{ javascript_include('vendors/jquery-ui-1.11.2/jquery-ui.min.js')}}
    {{ stylesheet_link('vendors/jquery-ui-1.11.2/jquery-ui.min.css') }}
	
	{# Notifications #}
	{{ stylesheet_link('vendors/notification-styles/css/ns-default.css') }}
	{{ stylesheet_link('vendors/notification-styles/css/ns-style-growl.css') }}
	{{ javascript_include('vendors/notification-styles/js/modernizr.custom.js')}}
	{{ javascript_include('vendors/notification-styles/js/classie.js')}}
	{{ javascript_include('vendors/notification-styles/js/notificationFx.js')}}
	
	{{ partial('partials/draggable-item-system') }}
{% endblock %}
{% block body %}
	<div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Agregar planes de pago a la cuenta <strong>{{account.name}}</strong></h2>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('account')}}" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-arrow-left"></span> Regresar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="medium-space"></div>
            {{flashSession.output()}}
        </div>
    </div>
	
	<div id="container"></div>
{% endblock %}