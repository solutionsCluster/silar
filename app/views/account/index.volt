{% extends "templates/index_2.volt" %}
{% block body %}
    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Listado de cuentas registradas</h2>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('account/new')}}" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Agregar una nueva cuenta
            </a>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {{flashSession.output()}}
        </div>
    </div>

    {% if page.items|length != 0 %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {#   Paginador   #}
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'account/index']) }}
            </div>
        </div>

        {% for item in page.items %}
            <div class="block block-primary">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <div>
                            {{item.idAccount}}
                        </div>
                    </div>

                    <div class="col-xs-11 col-sm-11 col-md-5 col-lg-5">
                        <div class="block-info">
                            <div class="block-title">
                                <a href="{{url('account/showusers')}}/{{item.idAccount}}">
                                    {{item.name}}
                                </a>
                            </div>
                            <div class="block-detail">
								{{item.ciuu.description}}	
                            </div>
                            <div class="block-detail">
                                {% if item.status == 1%}
                                    <span class="label label-success">Activa</span>
                                {% else %}
                                    <span class="label label-default">Inactiva</span>
                                {% endif %}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="block-info">
                            <div class="block-title">
                                {{item.companyName}}
                            </div>
                            <div class="block-detail">
                                {{item.nit}}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="pull-right">
                            {#
                            <button class="delete-modal btn btn-danger tooltip-b3" data-toggle="modal" href="#modal-simple" data-id="{{ url('ciuucode/delete') }}/{{item.idCiuu}}" data-placement="top" title="Eliminar actividad economica">
                                <span class="glyphicon glyphicon-trash"></span> Eliminar
                            </button>
                            #}
                            <a href="{{url('account/showusers')}}/{{item.idAccount}}" class="btn btn-default btn-xs tooltip-b3" data-placement="top" title="Ver los usuarios de esta cuenta">
                                <span class="glyphicon glyphicon-user"></span>
                            </a>
                            
                            <a href="{{url('account/edit')}}/{{item.idAccount}}" class="btn btn-default btn-xs tooltip-b3" data-placement="top" title="Editar esta cuenta">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            
                            <a href="{{url('account/addpaymentplan')}}/{{item.idAccount}}" class="btn btn-primary btn-xs tooltip-b3" data-placement="top" title="Añadir plan de pago">
                                <span class="glyphicon glyphicon-usd"></span>
                            </a>

                            <button class="btn btn-info btn-xs tooltip-b3" data-toggle="collapse" data-target="#detail-{{item.idAccount}}" data-placement="top" title="Ver detalles">
                                <span class="glyphicon glyphicon-collapse-down"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="detail-{{item.idAccount}}" class="collapse row">
                    <hr class="line-primary">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td>Ciudad: </td>
                                    <td><span class="lighter-medium">{{item.city}}</span></td>
                                </tr>
                                <tr>
                                    <td>Dirección:</td>
                                    <td><span class="lighter-medium">{{item.address}}</span></td>
                                </tr>
                                <tr>
                                    <td>Telefono:</td>
                                    <td><span class="lighter-medium">{{item.phone}}</span></td>
                                </tr>
                                <tr>
                                    <td>Correo corporativo:</td>
                                    <td><span class="lighter-medium">{{item.email}}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td>Fax:</td>
                                    <td><span class="lighter-medium">{{item.fax}}</span></td>
                                </tr>
								<tr>
                                    <td>Base de datos:</td>
                                    <td><span class="lighter-medium">{{item.database}} / Versión {{item.firebird.version}}</span></td>
                                </tr>
                                <tr>
                                    <td>Creada el:</td>
                                    <td><span class="lighter-medium">{{date('d/M/Y H:i', item.created)}}</span></td>
                                </tr>
                                <tr>
                                    <td>Última actualización:</td>
                                    <td><span class="lighter-medium">{{date('d/M/Y H:i', item.updated)}}</span></td>
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
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'account/index']) }}
            </div>
        </div>
    {% else %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-warning">
                    No hay cuentas registradas para agregar una haga <a href="{{url('account/new')}}">click aqui</a>
                </div>
            </div>
        </div>
    {% endif %}

    <div id="modal-simple" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar cuenta</h4>
                </div>
                <div class="modal-body">
                    <p>
                        ¿Está seguro que desea esta cuenta?
                    </p>
                    <p>
                        
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="" id="delete-code" class="btn btn-sm btn-danger" >Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $(document).on("click", ".delete-modal", function () {
            var myURL = $(this).data('id');
            $("#delete-code").attr('href', myURL );
        });
    </script>
{% endblock %}