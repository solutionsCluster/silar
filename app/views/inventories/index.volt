{% extends "templates/index_2.volt" %}
{% block header %}
	{{ super() }}
	{{ javascript_include('vendors/creative-link-effects/js/modernizr.custom.js')}}
{% endblock %}
{% block body %}
	<div class="big-space"></div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2 class="page-header">Módulo de reportes de inventario</h2>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{flashSession.output()}}
		</div>
	</div>
	
	<div class="big-space"></div>
    <div class="row">
		{% if reports|length == 0 %}
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="block block-default">
					No existen reportes de inventario asociados a esta cuenta, si desea asociar un reporte, le invitamos a que
					se comunique con soporte.
				</div>
			</div>
		{% else %}
			{% for report in reports %}
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<div class="cl-effect-12">
						<a href="{{url('inventories/showreport')}}/{{report.idReport}}">
							<div class="gr">
								<div class="title">{{report.name}}</div>
								<p>{{report.description}}</p>
							</div>
						</a>
					</div>			
				</div>
			{% endfor %}
		{% endif %}
    </div>
	<div class="big-space"></div>
{% endblock %}