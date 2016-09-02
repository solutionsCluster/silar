{% extends "templates/index_2.volt" %}
{% block body %}
    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Tabla de actividades economicas</h2>
        </div>
    </div>

    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('ciuucode/new')}}" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Agregar nueva actividad economica
            </a>
        </div>
    </div>
	
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="medium-space"></div>
            {{flashSession.output()}}
        </div>
    </div>

	<div class="medium-space"></div>
    {% if page.items|length != 0 %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {#   Paginador   #}
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'ciuucode/index']) }}
            </div>
        </div>

        {% for item in page.items %}
             <div class="block block-default">
                <div class="row">
                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                        {{item.idCiuu}}
                    </div>
                    
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="block-title">
                            {{item.description}}
                        </div>
                        <div class="block-detail">
                            Creado el {{date('d/M/Y H:i', item.created)}} 
                        </div>
                        <div class="block-detail">
                            Actualizado el {{date('d/M/Y H:i', item.updated)}}
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right">
                        <button class="delete-modal btn btn-danger btn-xs tooltip-b3" data-toggle="modal" href="#modal-simple" data-id="{{ url('ciuucode/delete') }}/{{item.idCiuu}}" data-placement="top" title="Eliminar actividad economica">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                        <a href="{{url('ciuucode/edit')}}/{{item.idCiuu}}" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="medium-space"></div>
        {% endfor %}

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {#   Paginador   #}
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'ciuucode/index']) }}
            </div>
        </div>

    {% else %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                No hay actividades economicas registradas para agregar una haga <a href="{{url('ciuucode/new')}}">click aqui</a>
            </div>
        </div>
    {% endif %}

    <div id="modal-simple" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar actividad economica</h4>
                </div>
                <div class="modal-body">
                    <p>
                        ¿Está seguro que desea esta actividad economica?
                    </p>
                    <p>
                        Recuerde que para poder eliminarla, ninguna cuenta debe estar inscrita con esta actividad economica, de lo
                        contrario no podrá eliminarlo
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="" id="delete-code" class="btn btn-danger" >Eliminar</a>
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