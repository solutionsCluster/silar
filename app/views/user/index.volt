{% extends "templates/index_2.volt" %}
{% block body %}
    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Tabla de usuarios</h2>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('user/new')}}" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Agregar un nuevo usuario
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
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'user/index']) }}
            </div>
        </div>

        {% for item in page.items %}
            {% if item.status == 1%}
                    {% set status = "Activo" %}
                    {% set statusClass = "active-account" %}
            {% else %}
                    {% set status = "Inactivo" %}
                    {% set statusClass = "inactive-account" %}
            {% endif %}
    
            <div class="block block-primary">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="block-info">
                            <div class="block-title {{statusClass}}">
                                <a href="{{url('user/edit')}}/{{item.idUser}}">
                                    {{item.name}} {{item.lastName}}
                                </a>
                            </div>
                            <div class="block-detail">
                                {{item.userName}}
                            </div>
                            <div class="block-detail">
                                Creado el: {{date('d/M/Y H:i', item.created)}}
                            </div>
                            <div class="block-detail">
                                Role: <span style="font-weight: 500;">{{item.role.name}}</span>
                            </div>
			</div>
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="pull-right">
                            <a href="{{url('user/changepassword')}}/{{item.idUser}}" class="btn btn-default btn-xs tooltip-b3" data-placement="top" title="Cambiar la contraseña de este usuario">
                                <span class="glyphicon glyphicon-lock"></span>
                            </a>
                            
                            <a href="{{url('user/edit')}}/{{item.idUser}}" class="btn btn-default btn-xs tooltip-b3" data-placement="top" title="Editar este usuario">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>

                            <button class="btn btn-info btn-xs tooltip-b3" data-toggle="collapse" data-target="#detail-{{item.idUser}}" data-placement="top" title="Ver detalles">
                                <span class="glyphicon glyphicon-collapse-down"></span>
                            </button>
                            
                            <button class="delete-modal btn btn-danger btn-xs tooltip-b3" data-toggle="modal" href="#modal-simple" data-id="{{ url('user/delete') }}/{{item.idUser}}" data-placement="top" title="Eliminar este usuario">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>	
                        </div>
                    </div>
                </div>
					
                <div id="detail-{{item.idUser}}" class="collapse row">
                    <hr class="line-primary">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td>Email: </td>
                                    <td><span class="lighter-medium">{{item.email}}</span></td>
                                </tr>
                                <tr>
                                    <td>Número de telefono/celular:</td>
                                    <td><span class="lighter-medium">{{item.phone}}</span></td>
                                </tr>
                                <tr>
                                    <td>Role:</td>
                                    <td><span class="lighter-medium">{{item.role.name}}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td>Estado:</td>
                                    <td class="{{statusClass}}">{{status}}</td>
                                </tr>
                                <tr>
                                    <td>Creado el:</td>
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
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'user/index']) }}
            </div>
        </div>
    {% else %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                No hay usuarios registrados para agregar uno haga <a href="{{url('user/new')}}">click aqui</a>
            </div>
        </div>
    {% endif %}
    
    
    <div id="modal-simple" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar usuario</h4>
                </div>
                <div class="modal-body">
                    <p>
                        ¿Está seguro que desea eliminar este usuario?
                    </p>
                    <p>
                        Recuerde que si elimina este usuario, se perderán todos los datos asociados a él y no se podrán recuperar, ¿Está seguro?
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="" id="delete-user" class="btn btn-danger" >Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $(document).on("click", ".delete-modal", function () {
            var myURL = $(this).data('id');
            $("#delete-user").attr('href', myURL );
        });
    </script>
{% endblock %}