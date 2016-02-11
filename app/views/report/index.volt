{% extends "templates/index_2.volt" %}
{% block body %}
    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Listado de reportes</h2>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('report/new')}}" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Agregar un nuevo reporte
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
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'report/index']) }}
            </div>
        </div>

        {% for item in page.items %}
            <div class="block block-primary">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="block-info">
                            <div class="block-title">
                                <a href="{{url('report/edit')}}/{{item.idReport}}">
                                    <strong>{{item.name}}</strong>
                                </a>
                            </div>
                            <div class="block-detail">
                                {{item.code}}
                            </div>
                            <div class="block-detail">
                                Gráfico: {% if item.graphic == 1 %}Si{% else %}No{% endif %}
                            </div>
			</div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="pull-right">
                            <a href="{{url('report/edit')}}/{{item.idReport}}" class="btn btn-default btn-xs tooltip-b3" data-placement="top" title="Editar este reporte">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>

                            <button class="btn btn-info btn-xs tooltip-b3" data-toggle="collapse" data-target="#detail-{{item.idReport}}" data-placement="top" title="Ver detalles">
                                <span class="glyphicon glyphicon-collapse-down"></span>
                            </button>
                            
                            <button class="delete-modal btn btn-danger btn-xs tooltip-b3" data-toggle="modal" href="#modal-simple" data-id="{{ url('report/delete') }}/{{item.idReport}}" data-placement="top" title="Eliminar este reporte">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>	
                        </div>
                    </div>
                </div>
					
                <div id="detail-{{item.idReport}}" class="collapse row">
                    <hr class="line-primary">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="font-strong">Descripción: </td>
                                    <td>{{item.description}}</td>
                                </tr>
                                <tr>
                                    <td class="font-strong">Tipo:</td>
                                    <td>{{item.type}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="font-strong">Creado el:</td>
                                    <td>{{date('d/M/Y H:i', item.created)}}</td>
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
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'report/index']) }}
            </div>
        </div>
    {% else %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-warning" role="alert">
                    No hay reportes creados, para crear uno haga <a href="{{url('report/new')}}">click aqui</a>
                </div>
            </div>
        </div>
    {% endif %}
    
    
    <div id="modal-simple" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar reporte</h4>
                </div>
                <div class="modal-body">
                    <p>
                        ¿Está seguro que desea eliminar este reporte?
                    </p>
                    <p>
                        Recuerde que si este reporte aún esta activo (en uso por alguna cuenta) no podrá eliminarlo, en caso
                        contrario se perderán todos los datos y no podrán recuperarse, ¿Está seguro?
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="" id="delete-report" class="btn btn-danger" >Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $(document).on("click", ".delete-modal", function () {
            var myURL = $(this).data('id');
            $("#delete-report").attr('href', myURL );
        });
    </script>
{% endblock %}