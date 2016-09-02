{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}
    {# Switch master#}
    {{ javascript_include('vendors/bootstrap-switch-master/bootstrap-switch.min.js')}}
    {{ stylesheet_link('vendors/bootstrap-switch-master/bootstrap-switch.min.css') }}

    <script type="text/javascript">
        $(function () {
            $(".switch").bootstrapSwitch({
                size: 'mini',
                onColor: 'success',
                offColor: 'danger',
            });

            $('.switch').on('switchChange.bootstrapSwitch', function(event, state) {
                var idUser = $(this).data("id");
                
                console.log(idUser);

                $.ajax({
                    url: "{{url('account/changeuserstatus')}}/{{account.idAccount}}/" + idUser,
                    type: "POST",			
                    data: {},
                    error: function(msg){
                        var m = msg.responseJSON;
                        $.gritter.add({class_name: 'error', title: '<span class="glyphicon glyphicon-warning-sign"></span> Error', text: m.error, time: 30000});
                    },
                    success: function(msg){
                        $.gritter.add({class_name: 'success', title: '<span class="glyphicon glyphicon-ok-sign"></span> Exitoso', text: msg.success, time: 30000});
                    }
                });
            });
        });
    </script>
{% endblock %}
{% block body %}
    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Usuarios registrados en la cuenta <strong>{{account.name}}</strong></h2>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('account')}}" class="btn btn-sm btn-default">
                <span class="glyphicon glyphicon-step-backward"></span> regresar
            </a>
            <a href="{{url('account/newuser')}}/{{account.idAccount}}" class="btn btn-sm btn-primary">
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

    {% if page.items|length != 0%}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="text-center">
                    <ul class="pagination">
                        <li class="{{ (page.current == 1)?'disabled':'enabled' }}">
                            <a href="{{ url('account/showusers') }}/{{account.idAccount}}"><i class="glyphicon glyphicon-fast-backward"></i></a>
                        </li>
                        <li class="{{ (page.current == 1)?'disabled':'enabled' }}">
                            <a href="{{ url('account/showusers') }}/{{account.idAccount}}?page={{ page.before }}"><i class="glyphicon glyphicon-step-backward"></i></a>
                        </li>
                        <li>
                            <span><b>{{page.total_items}}</b> registros </span><span>Página <b>{{page.current}}</b> de <b>{{page.total_pages}}</b></span>
                        </li>
                        <li class="{{ (page.current >= page.total_pages)?'disabled':'enabled' }}">
                            <a href="{{ url('account/showusers') }}/{{account.idAccount}}?page={{page.next}}"><i class="glyphicon glyphicon-step-forward"></i></a>
                        </li>
                        <li class="{{ (page.current >= page.total_pages)?'disabled':'enabled' }}">
                            <a href="{{ url('account/showusers') }}/{{account.idAccount}}?page={{page.last}}"><i class="glyphicon glyphicon-fast-forward"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    
        {% for item in page.items %}
            <div class="block block-default">
                <div class="row">
                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                        {{item.idUser}}
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="block-title">
                            {{item.name}} {{item.lastName}}
                        </div>
                        <div class="block-detail">
                            {{item.role.name}}
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="block-title">
                            {{item.userName}}
                        </div>
                        <div class="block-detail">
                            {{item.email}}
                        </div>
                       
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right">
                        <input type="checkbox" data-id="{{item.idUser}}" class="switch tooltip-b3" {% if item.status == 1%} checked {% endif %} data-placement="top" title="Cambiar el estado de este usuario">
                        
						<a href="{{url('session/loginasroot')}}/{{item.idUser}}" class="btn btn-warning btn-xs tooltip-b3" data-placement="top" title="Ingresar como este usuario">
                            <span class="glyphicon glyphicon-sort"></span>
                        </a>
						
                        <a href="{{url('account/changepassword')}}/{{account.idAccount}}/{{item.idUser}}" class="btn btn-primary btn-xs tooltip-b3" data-placement="top" title="Cambiar la contraseña de este usuario">
                            <span class="glyphicon glyphicon-lock"></span>
                        </a>
                        
                        <a href="{{url('account/edituser')}}/{{account.idAccount}}/{{item.idUser}}" class="btn btn-primary btn-xs tooltip-b3" data-placement="top" title="Editar este usuario">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        
                        <button class="btn btn-info btn-xs tooltip-b3" data-toggle="collapse" data-target="#detail-{{item.idUser}}" data-placement="top" title="Ver detalles">
                            <span class="glyphicon glyphicon-collapse-down"></span>
                        </button>
                    </div>
                </div>
                
                <div id="detail-{{item.idUser}}" class="collapse row">
                    <hr class="line-primary">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <table class="table table-bordered table-white">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td><strong>Telefono:</strong></td>
                                    <td>{{item.phone}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        {% if item.status == 1%}
                                            Activo
                                        {% else %}
                                            Inactivo
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
                                    <td><strong>Fecha de creación:</strong></td>
                                    <td>{{date('d/M/Y H:i', item.created)}} </td>
                                </tr>
                                <tr>
                                    <td><strong>Última actualización:</strong></td>
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
                    <div class="text-center">
                        <ul class="pagination">
                            <li class="{{ (page.current == 1)?'disabled':'enabled' }}">
                                <a href="{{ url('account/showusers') }}/{{account.idAccount}}"><i class="glyphicon glyphicon-fast-backward"></i></a>
                            </li>
                            <li class="{{ (page.current == 1)?'disabled':'enabled' }}">
                                <a href="{{ url('account/showusers') }}/{{account.idAccount}}?page={{ page.before }}"><i class="glyphicon glyphicon-step-backward"></i></a>
                            </li>
                            <li>
                                <span><b>{{page.total_items}}</b> registros </span><span>Página <b>{{page.current}}</b> de <b>{{page.total_pages}}</b></span>
                            </li>
                            <li class="{{ (page.current >= page.total_pages)?'disabled':'enabled' }}">
                                <a href="{{ url('account/showusers') }}/{{account.idAccount}}?page={{page.next}}"><i class="glyphicon glyphicon-step-forward"></i></a>
                            </li>
                            <li class="{{ (page.current >= page.total_pages)?'disabled':'enabled' }}">
                                <a href="{{ url('account/showusers') }}/{{account.idAccount}}?page={{page.last}}"><i class="glyphicon glyphicon-fast-forward"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    {% else %}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                No hay usuarios registrados para agregar uno, haga <a href="{{url('account/newuser')}}/{{account.idAccount}}">click aqui</a>
            </div>
        </div>
    {% endif %}
{% endblock %}