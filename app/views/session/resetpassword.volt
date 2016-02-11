{% extends "templates/index_1.volt" %}
{% block body %}
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="logo-header">
                        <div class="app-logo-container">
                            <a href="http://solutionscluster.net/" target="_blank">
                                <img src="{{url('')}}image-bank/silar-logo.jpg" class="app-logo"/>
                            </a>
                        </div>
                        <div class="client-logo-container">
                            <img src="{{url('')}}image-bank/your-logo.jpg" class="client-logo"/>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info" role="alert">
                        Puede restablecer la contraseña con el siguiente formulario, recuerde que la validez de este formulario
                        es de 30 minutos déspues de haber hecho la solicitud
                    </div>
                    <form action="{{ url('session/resetpassword') }}/{{uniq}}" method="post">
                        <div class="small-space"></div>
                        <p>{{flashSession.output()}}</p>
                        
                        <input type="hidden" name="uniq" value="{{uniq}}"/>
                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Nueva contraseña" required="required" autofocus="autofocus" />
                        </div>
                        
                        <div class="small-space"></div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Repita la contraseña" required="required" />
                        </div>
                        
                        <div class="small-space"></div>
                        <div class="input-group" style="width: 100%;">
                            {{ submit_button("Cambiar contraseña", 'class' : "btn btn-sm btn-primary pull-right") }}
                        </div>				
                    </form>
                </div>
                <div class="panel-footer" style="display: inline-block; width: 100%;">
                    <p class="text-center small-text">
                        Todos los derechos reservados <a href="http://solutionscluster.net/" target="_blank">Cluster Solutions</a> - Copyright &copy; 2013
                    </p>
                </div>
            </div>
        </div>
    </div>
{% endblock %}