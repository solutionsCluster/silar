{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}
    {{ partial('partials/ember_partial') }}
{% endblock %}
{% block body %}
	<div class="big-space"></div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2 class="page-header">Registrar una nueva cuenta</h2>
		</div>
	</div>

	<div class="big-space"></div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{flashSession.output()}}
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form action = "{{url('account/new')}}" method="post" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>NIT: 
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('nit') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Nombre de la cuenta:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('name') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Razón social:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('companyName') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Ciudad:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('city') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Dirección:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('address') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Télefono:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('phone') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						Fax:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('fax') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Dirección de correo corporativo:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('email') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Actividad economica:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('idCiuu') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Plan de pago:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						{{ AccountForm.render('idPaymentplan') }}
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
						<span class="required">*</span>Estado:
					</label>
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="margin-top: 6px;">
						{{ AccountForm.render('status') }}
					</div>
				</div>

				<div class="form-actions">
					<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 text-right">
						<a href="{{ url('account') }}" class="btn btn-default">Cancelar</a>

						{{ submit_button("Grabar", 'class' : "btn btn-success", 'data-toggle': "tooltip", 'data-placement': "left", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides", 'data-original-title': "Tooltip on left") }}
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="big-space"></div>
{% endblock %}