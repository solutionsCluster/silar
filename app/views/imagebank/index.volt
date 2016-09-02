{% extends "templates/index_2.volt" %}
{% block body %}
	<div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Banco de imágenes de inicio de sesión</h2>
        </div>
    </div>

    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('imagebank/newloginimage')}}" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Cargar nueva imagen
            </a>
        </div>
    </div>	
	
	<div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
             {{flashSession.output()}}
        </div>
    </div>
	
    <div class="big-space"></div>

    {% if page.items|length != 0 %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {#   Paginador   #}
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'imagebank/index']) }}
            </div>
        </div>
        
        {% for item in page.items %}
            <div class="block block-default">
                <div class="row">
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                        {% if item.base64 == null%}
                            <img src="{{url('')}}images/not-available.png" style="width: 50px;"/>
                        {% else %}
                            <img src="data: image/png;base64, {{item.base64}}" style="width: 50px;"/>
                        {% endif %}
                    </div>
                    
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="block-title">
                            {{item.name}}
                        </div>
                        <div class="block-detail">
                            creada el {{ date('d/M/Y H:i', item.created) }}
                        </div>    
                    </div>
                    
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-right">
                        <button class="delete-modal btn btn-danger btn-xs tooltip-b3" data-toggle="modal" href="#modal-simple" data-id="{{ url('imagebank/deleteloginimage') }}/{{item.idImagebank}}" data-placement="top" title="Eliminar imagen">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                    </div>
                </div>
            </div>  
    
            <div class="medium-space"></div>
        {% endfor %}
                    
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {#   Paginador   #}
                {{ partial('partials/volt_paginator_partial', ['pagination_url': 'imagebank/index']) }}
            </div>
        </div>
    {% else %}
		<div class="block block-default">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					No hay imágenes de inicio de sesión cargadas en el sistema, para cargar una haga <a href="{{url('imagebank/newloginimage')}}">click aqui</a>
				</div>
			</div>
		</div>
    {% endif %}

    <div id="modal-simple" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Eliminar imagen de inicio de sesión</h4>
                </div>
                <div class="modal-body">
                    <p>
                            ¿Está seguro que desea eliminar esta imagen?
                    </p>
                    <p>
                            Recuerde que si elimina no se podrá recuperar
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="" id="delete-img" class="btn btn-danger" >Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $(document).on("click", ".delete-modal", function () {
            var myURL = $(this).data('id');
            $("#delete-img").attr('href', myURL );
        });
    </script>
{% endblock %}