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
            $(".select2").select2({});
			
            $(".bootstrap-switch").bootstrapSwitch({
                size: 'mini',
                onText: 'Si',
                offText: 'No',
                onColor: 'success',
                offColor: 'danger'
            });

            $('.bootstrap-switch').on('switchChange.bootstrapSwitch', function(event, state) {
                if (state) {
                    $('#graphics').val('1');
                }
                else {
                    $('#graphics').val('0');
                }
            });
        });
    </script>
{% endblock %}
{% block body %}
    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Crear un nuevo reporte</h2>
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
            <form action = "{{url('report/new')}}" method="post" class="form-horizontal block block-default" role="form">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Código
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ ReportForm.render('code') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Nombre de reporte
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ ReportForm.render('name') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Descripción del reporte
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ ReportForm.render('description') }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Tipo de reporte
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        {{ ReportForm.render('type') }}
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Módulo
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="padding-top: 3px;">
                        {{ ReportForm.render('module') }}
                    </div>
                </div>		
					
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>¿Contiene gráfico?
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="padding-top: 3px;">
                        {{ ReportForm.render('graphic') }}
						<input type="hidden" id="graphics" name="graphics" value="0" />
                    </div>
                </div>
					
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 text-right">
                        <a href="{{ url('report') }}" class="btn btn-sm btn-default">Cancelar</a>
                        {{ submit_button("Guardar", 'class' : "btn btn-sm btn-success", 'data-toggle': "tooltip-b3", 'data-placement': "bottom", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides", 'data-original-title': "Tooltip on left") }}
                    </div>
                </div>
            </form>
        </div>
    </div>	
    <div class="big-space"></div>
{% endblock %}