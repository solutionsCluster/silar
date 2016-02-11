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
                    <label><span class="required">*</span>NIT:</label>
                    {{ AccountForm.render('nit') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Nombre de la cuenta:</label>
                    {{ AccountForm.render('aname') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Razón social:</label>
                    {{ AccountForm.render('companyName') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Ciudad:</label>    
                    {{ AccountForm.render('city') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Dirección:</label>    
                    {{ AccountForm.render('address') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Télefono:</label>    
                    {{ AccountForm.render('phone') }}
                </div>

                <div class="form-group">
                    <label>Fax:</label>  
                    {{ AccountForm.render('fax') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Dirección de correo corporativo:</label>  
                    {{ AccountForm.render('email') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Actividad economica:</label>  
                    {{ AccountForm.render('idCiuu') }}
                </div>
					
                <div class="form-group">
                    <label><span class="required">*</span>Base de datos:</label>  
                    {{ AccountForm.render('database', {'class': 'select2'}) }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Estado:</label>     
                    {{ AccountForm.render('astatus') }}
                </div>
            </div>
        
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-6">
                <div class="form-group">
                    <label><span class="required">*</span>Email</label>     
                    {{ UserForm.render('email') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Nombres</label>
                    {{ UserForm.render('name') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Apellidos</label>
                    {{ UserForm.render('lastName') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Número de telefono o celular</label>
                    {{ UserForm.render('phone') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Nombre de usuario</label>
                    {{ UserForm.render('userName') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Contraseña</label>
                    {{ UserForm.render('password1') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Repita la contraseña</label>
                    {{ UserForm.render('password2') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Role</label>
                    {{ UserForm.render('idRole') }}
                </div>

                <div class="form-group">
                    <label><span class="required">*</span>Estado</label>
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
