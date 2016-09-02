{% extends "templates/index_2.volt" %}
{% block body %}
    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Tabla de planes de pago</h2>
        </div>
    </div>

    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('paymentplan/new')}}" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Agregar un nuevo plan de pago
            </a>
        </div>
    </div>

    <div class="medium-space"></div>
	
	<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {{flashSession.output()}}
        </div>
    </div>
	
	<div class="medium-space"></div>
	
    {% if page.items|length != 0 %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {#   Paginador   #}
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'paymentplan/index']) }}
            </div>
        </div>
    
	{% for item in page.items %}
            <div class="block block-default">
                <div class="row">
                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                        {{item.idPaymentplan}}
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="block-title">
                            {{item.name}}
                        </div>
                        <div class="block-detail">
                            {{item.code}}
                        </div>
                        <div class="block-detail" style="padding-bottom: 4px;">
                            {% if item.status == 1%}<span class="label label-success">Activo</span>{% else %}<span class="label label-default">Inactivo</span>{% endif %}
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                        {{item.description}}
                    </div>
                    
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-right">
                        <button class="delete-modal btn btn-danger btn-xs tooltip-b3" data-toggle="modal" href="#modal-simple" data-id="{{ url('paymentplan/delete') }}/{{item.idPaymentplan}}" data-placement="top" title="Eliminar este plan de pago">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                        <a href="{{url('paymentplan/edit')}}/{{item.idPaymentplan}}" class="btn btn-primary btn-xs tooltip-b3" data-placement="top" title="Editar este plan de pago">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <button class="btn btn-info btn-xs tooltip-b3" data-toggle="collapse" data-target="#detail-{{item.idPaymentplan}}" data-placement="top" title="Ver detalles">
                            <span class="glyphicon glyphicon-collapse-down"></span>
                        </button>
                    </div>
                </div>
                
                <div id="detail-{{item.idPaymentplan}}" class="collapse row">
                    <hr class="line-primary">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="font-strong">Reportes: </td>
                                    <td>
                                        {% if item.pxr|length == 0 %}
                                            <span class="label label-warning">No hay reportes asociados</span>
                                        {% else %}
                                            {% for r in item.pxr%}
                                                {% for report in reports%}
                                                    {% if r.idReport == report.idReport %}
                                                        <span class="label label-primary">{{report.name}}</span><br />
                                                    {% else %}{% endif %}
                                                {% endfor %}
                                            {% endfor %}
                                        {% endif %}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="font-strong">Fecha de creación: </td>
                                    <td>{{date('d/M/Y H:i', item.created)}} </td>
                                </tr>
                                <tr>
                                    <td class="font-strong">Última actualización:</td>
                                    <td>{{date('d/M/Y H:i', item.updated)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
            </div>
            
            <div class="medium-space"></div>
	{% endfor %}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {#   Paginador   #}
                    {{ partial('partials/volt_paginator_partial', ['pagination_url': 'paymentplan/index']) }}
                </div>
            </div>

	{% else %}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-warning">
                        No hay planes de pago registrados para agregar uno haga <a href="{{url('paymentplan/new')}}">click aqui</a>
                    </div>
                </div>
            </div>
	{% endif %}

    <div id="modal-simple" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar plan de pago</h4>
                </div>
                <div class="modal-body">
                    <p>
                        ¿Está seguro que desea eliminar este plan de pago?
                    </p>
                    <p>
                        Recuerde que para poder eliminarlo, ninguna cuenta debe estar inscrita con este plan de pago, de lo
                        contrario no podrá eliminarlo
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="" id="delete-payment" class="btn btn btn-sm btn-danger" >Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $(document).on("click", ".delete-modal", function () {
            var myURL = $(this).data('id');
            $("#delete-payment").attr('href', myURL );
        });
    </script>
{% endblock %}