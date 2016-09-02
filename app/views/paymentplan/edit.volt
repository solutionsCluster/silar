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
            $(".select2").select2();
            
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
            {{flashSession.output()}}
            <h2 class="page-header">Editar plan de pago con código {{payment.idPaymentplan}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form action="{{url('paymentplan/edit')}}/{{payment.idPaymentplan}}" method="Post" class="form-horizontal block block-default" role="form">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
                        <span class="required">*</span>Código: 
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        {{ PaymentplanForm.render('code') }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
                        <span class="required">*</span>Nombre:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        {{ PaymentplanForm.render('name') }}
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
                        <span class="required">*</span>Descripción:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        {{ PaymentplanForm.render('description') }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
                        <span class="required">*</span>Reportes:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" style="margin-top: 3px;">
                        <select name="reports[]" class="select2" multiple="multiple">
                            {% for report in reports%}
                                <option value="{{report.idReport}}" {% for p in pxr %}{% if p.idReport == report.idReport%}selected{% endif %}{% endfor %}>
                                    {{report.name}}
                                </option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
                        <span class="required">*</span>Estado:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" style="margin-top: 3px;">
                        {{ PaymentplanForm.render('status') }}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                        <a href="{{ url('paymentplan') }}" class="btn btn-default btn-sm">Cancelar</a>
                        {{ submit_button("Grabar", 'class' : "btn btn-success tooltip-b3 btn-sm", 'data-toggle': "tooltip", 'data-placement': "left", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides", 'data-original-title': "Tooltip on left") }}
                    </div>
                </div>
            </form>
        </div>
    </div>
{% endblock %}