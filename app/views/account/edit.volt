{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}
    {# Switch master#}
    {{ javascript_include('vendors/bootstrap-switch-master/bootstrap-switch.min.js')}}
    {{ stylesheet_link('vendors/bootstrap-switch-master/bootstrap-switch.min.css') }}

    {# Select 2#}
    {{ javascript_include('vendors/select2-3.5.1/select2.min.js')}}
    {{ stylesheet_link('vendors/select2-3.5.1/select2.css') }}

    <script type="text/javascript">
        $(function () {
            $(".select2").select2({
            });

			$("#select2").select2({
				placeholder: "Select a state"
            }).on("select2-selecting", function(e) {
				$('#firebird-version').hide(800);
				if (e.val === 'firebird') {
					$('#firebird-version').show(800);
				}
			});

            $(".bootstrap-switch").bootstrapSwitch({
                size: 'mini',
                onColor: 'success',
                offColor: 'danger'
            });

            $('.bootstrap-switch').on('switchChange.bootstrapSwitch', function(event, state) {
                if (state) {
                    $('#status').val('1');
                    $('#status').attr('checked', 'checked');
                    $('#status2').val('1');
                }
                else {
                    $('#status').val('0');
                    $('#status').removeAttr('checked');
                    $('#status2').val('0');
                }
            });
        });
    </script>
{% endblock %}
{% block body %}
    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Editar la cuenta <strong>{{account.name}}</strong></h2>
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
	
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form action="{{url('account/edit')}}/{{account.idAccount}}" method="post" class="form-horizontal block block-default" role="form">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>NIT: 
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('nit') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Nombre de la cuenta:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('name') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Razón social:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('companyName') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Ciudad:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('city') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Dirección:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('address') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Télefono:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('phone') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        Fax:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('fax') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Dirección de correo corporativo:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('email') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Actividad economica:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        {{ AccountForm.render('idCiuu') }}
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
						<span class="required">*</span>Base de datos:
					</label> 
					<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
						{{ AccountForm.render('database', {'class': 'select2', 'id': 'select2'}) }}
					</div>
                </div>
					
				<div class="form-group" style="display: {% if account.database == 'firebird' %}block{% else %}none{% endif %};" id="firebird-version">
					<label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
						<span class="required">*</span>Versión de firebird:  
					</label> 
					<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
						{{ AccountForm.render('idFirebird') }}
					</div>
				</div>	
					
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Estado:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" style="margin-top: 6px;">
                        <input type="hidden" name="status2" id="status2" value="{{account.status}}"/>
                        {{ AccountForm.render('status') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                        <a href="{{ url('account') }}" class="btn btn-default btn-sm">Cancelar</a>
                        {{ submit_button("Editar", 'class' : "btn btn-success tooltip-b3 btn-sm", 'data-toggle': "tooltip", 'data-placement': "left", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides", 'data-original-title': "Tooltip on left") }}
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="big-space"></div>
{% endblock %}