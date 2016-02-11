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
    
    {% if report.code == 'RPT-001'%}
        {{ partial('sales/partials/RPT-001')}}
    {% elseif report.code == 'RPT-002'%}
        {{ partial('sales/partials/RPT-002')}}
    {% elseif report.code == 'RS-003'%}
        {{ partial('sales/partials/RS-003')}}
    {% elseif report.code == 'RS-004'%}
        {{ partial('sales/partials/RS-004')}}
    {% elseif report.code == 'RS-005'%}
        {{ partial('sales/partials/RS-005')}}
	{% elseif report.code == 'RS-006'%}
        {{ partial('sales/partials/RS-006')}}
	{% elseif report.code == 'RS-007'%}
        {{ partial('sales/partials/RS-007')}}
	{% elseif report.code == 'RS-008'%}
        {{ partial('sales/partials/RS-008')}}
    {% endif %}
{% endblock %}