{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}
    {# highcharts 2#}
    {{ javascript_include('vendors/highcharts-4.0.4/js/highcharts.js')}}
    {{ javascript_include('js/charts/highcharts.js')}}

	{# Moment.js #}
    {{ javascript_include('vendors/moment/moment-2.8.4.js')}}

    {# Select 2#}
    {{ javascript_include('vendors/select2-3.5.1/select2.min.js')}}
    {{ stylesheet_link('vendors/select2-3.5.1/select2.css') }}

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
            {{flashSession.output()}}
        </div>
    </div>
    <div class="big-space"></div>
    <div class="row">
		{% if reports|length == 0 %}
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="alert alert-warning">
					Estimado usuario, el plan de reportes en el que está inscrita la cuenta, ha vencido lo invitamos a contactarse
					con nosotros para renovarlo. Cordial saludo
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="alert alert-info">
					<div class="" style="text-align: center;">
						<img src="{{url('')}}images/ad-1.jpg" class="ad" />
					</div>
				</div>
			</div>
		{% else %}
			{% for report in reports%}
				{% if report.code == 'RPT-002'%}
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<a href="{{url('sales/showreport')}}/{{report.idReport}}" class="text-center"><h3>{{report.name}}</h3></a>
						{{ partial('sales/partials/RPT-002')}}
					</div>
				{% elseif report.code == 'RP-001'%}
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<a href="{{url('portfolio/showreport')}}/{{report.idReport}}" class="text-center"><h3>{{report.name}}</h3></a>
						{{ partial('portfolio/partials/RP-001')}}
						<hr class="line-primary" />
					</div>
				{% elseif report.code == 'RS-003'%}
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<a href="{{url('sales/showreport')}}/{{report.idReport}}" class="text-center"><h3>{{report.name}}</h3></a>
						{{ partial('sales/partials/RS-003')}}
						<hr class="line-primary" />
					</div>
				{% endif %}
			{% endfor %}
		{% endif %}
    </div>
    <div class="big-space"></div>
{% endblock %}