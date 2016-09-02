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
			$(".select").select2();
            $("#select2").select2({
				allowClear: true,
				placeholder: 'Seleccionar base de datos'
            }).on("select2-selecting", function(e) {
				$('#firebird-version').hide(800);
				if (e.val === 'firebird') {
					$('#firebird-version').show(800);
				}
			});
			
			$("#select2").select2("val", "");
			
            $(".bootstrap-switch").bootstrapSwitch({
                size: 'mini',
                onColor: 'success',
                offColor: 'danger'
            });

            $('.bootstrap-switch').on('switchChange.bootstrapSwitch', function(event, state) {
                if (state) {
                    $('#status').val('1');
                }
                else {
                    $('#status').val('0');
                }
            });
        });
    </script>
{% endblock %}
{% block body %}
    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Crear una nueva cuenta</h2>
        </div>
    </div>

    <div class="medium-space"></div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('account')}}" class="btn btn-default btn-sm">Regresar</a>
        </div>
    </div>
    
    <div class="medium-space"></div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {{flashSession.output()}}
        </div>
    </div>
    
    <div class="small-space"></div>
    
    <form action="{{url('account/new')}}" class="block block-default" method="post" role="form">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                   <span class="required">*</span>NIT:
                    {{ AccountForm.render('nit') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Nombre de la cuenta:
                    {{ AccountForm.render('aname') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Razón social:
                    {{ AccountForm.render('companyName') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Ciudad:    
                    {{ AccountForm.render('city') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Dirección:    
                    {{ AccountForm.render('address') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Télefono:    
                    {{ AccountForm.render('phone') }}
                </div>

                <div class="form-group">
                    Fax:  
                    {{ AccountForm.render('fax') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Dirección de correo corporativo:  
                    {{ AccountForm.render('email') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Actividad economica:  
                    {{ AccountForm.render('idCiuu') }}
                </div>
					
                <div class="form-group">
                    <span class="required">*</span>Base de datos:  
                    {{ AccountForm.render('database', {'class': 'select2', 'id': 'select2'}) }}
                </div>
					
				<div class="form-group" style="display: none;" id="firebird-version">
					<span class="required">*</span>Versión de firebird:  
					{{ AccountForm.render('idFirebird', {'data-placeholder': 'cawky parky'}) }}
				</div>

                <div class="form-group">
                    <span class="required">*</span>Estado:     
                    {{ AccountForm.render('astatus') }}
                </div>
            </div>
        
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-6">
                <div class="form-group">
                    <span class="required">*</span>Email     
                    {{ UserForm.render('email') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Nombres
                    {{ UserForm.render('name') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Apellidos
                    {{ UserForm.render('lastName') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Número de telefono o celular
                    {{ UserForm.render('phone') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Nombre de usuario
                    {{ UserForm.render('userName') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Contraseña
                    {{ UserForm.render('password1') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Repita la contraseña
                    {{ UserForm.render('password2') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Role
                    {{ UserForm.render('idRole') }}
                </div>

                <div class="form-group">
                    <span class="required">*</span>Estado
                    {{ UserForm.render('status') }}
                </div>
            </div>
        </div>  
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <a href="{{ url('account') }}" class="btn btn-default btn-sm">Cancelar</a>
                {{ submit_button("Grabar", 'class' : "btn btn-success tooltip-b3 btn-sm", 'data-toggle': "tooltip", 'data-placement': "left", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides", 'data-original-title': "Tooltip on left") }}
            </div>
        </div>
    </form>
    
    <div class="big-space"></div>
{% endblock %}