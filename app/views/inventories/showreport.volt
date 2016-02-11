{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}

	<script type="text/javascript">
		var url = '{{urlManager.getBaseUrl(true)}}';
	</script>
    {# highcharts 2#}
    {{ javascript_include('vendors/highcharts-4.0.4/js/highcharts.js')}}
    {{ javascript_include('js/charts/highcharts.js')}}

    {# Select 2#}
    {{ javascript_include('vendors/select2-3.5.1/select2.min.js')}}
    {{ stylesheet_link('vendors/select2-3.5.1/select2.css') }}

    {# Moment.js #}
    {{ javascript_include('vendors/moment/moment-2.8.4.js')}}
	
	{# Notifications #}
	{{ stylesheet_link('vendors/notification-styles/css/ns-default.css') }}
	{{ stylesheet_link('vendors/notification-styles/css/ns-style-growl.css') }}
	{{ javascript_include('vendors/notification-styles/js/modernizr.custom.js')}}
	{{ javascript_include('vendors/notification-styles/js/classie.js')}}
	{{ javascript_include('vendors/notification-styles/js/notificationFx.js')}}
	
{% endblock %}
{% block body %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2 class="page-header"><strong>Reporte:</strong> {{report.name}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{flashSession.output()}}
		</div>
	</div>

	<div class="big-space"></div>

    {% if report.code == 'RI-001'%}
        {{ partial('inventories/partials/RI-001')}}
	{% elseif report.code == 'RI-002'%}
        {{ partial('inventories/partials/RI-002')}}
	{% elseif report.code == 'RI-003'%}
        {{ partial('inventories/partials/RI-003')}}
	{% elseif report.code == 'RI-004'%}
        {{ partial('inventories/partials/RI-004')}}
    {% endif %}
{% endblock %}