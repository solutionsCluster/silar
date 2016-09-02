{% extends "templates/index_2.volt" %}
{% block body %}
	<div class="big-space"></div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{flashSession.output()}}
			<h2 class="page-header">Agregar una actividad economica</h2>
		</div>
	</div>

	<div class="big-space"></div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form action = "{{url('ciuucode/new/')}}" method="post" class="form-horizontal block block-default" role="form">
				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Código: 
					</label>
					<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
						{{ CiuuCodeForm.render('idCiuu') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Descripción:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
						{{ CiuuCodeForm.render('description') }}
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
						<a href="{{ url('ciuucode') }}" class="btn btn-default btn-sm">Cancelar</a>
						{{ submit_button("Grabar", 'class' : "btn btn-success tooltip-b3 btn-sm", 'data-toggle': "tooltip", 'data-placement': "left", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides", 'data-original-title': "Tooltip on left") }}
					</div>
				</div>
			</form>
		</div>
	</div>

{% endblock %}