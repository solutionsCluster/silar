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
            <h2 class="page-header">Crear un nuevo usuario</h2>
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
            <form action = "{{url('user/new')}}" method="post" class="form-horizontal block block-default" role="form">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Email
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ UserForm.render('email') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Nombres
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                         {{ UserForm.render('name') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Apellidos
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ UserForm.render('lastName') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        Número de telefono o celular
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ UserForm.render('phone') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Nombre de usuario
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ UserForm.render('userName') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Contraseña
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ UserForm.render('password1') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Repita la contraseña
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            {{ UserForm.render('password2') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Role
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ UserForm.render('idRole') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                         <span class="required">*</span>Estado:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="margin-top: 6px;">
                         {{ UserForm.render('status') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 text-right">
                        <a href="{{ url('user') }}" class="btn btn-default">Cancelar</a>
                        {{ submit_button("Guardar", 'class' : "btn btn-sm btn-success", 'data-toggle': "tooltip", 'data-placement': "left", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides", 'data-original-title': "Tooltip on left") }}
                    </div>
                </div>
            </form>
        </div>
    </div>	
    <div class="big-space"></div>
{% endblock %}
