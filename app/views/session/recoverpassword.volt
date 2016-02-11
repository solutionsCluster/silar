{% extends "templates/index_1.volt" %}
{% block body %}
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="logo-header">
                        <div class="app-logo-container">
                            <a href="http://solutionscluster.net/" target="_blank">
                                <img src="{{url('')}}{{imgbnk.relativeappimages}}/app-logo.png" class="app-logo"/>
                            </a>
                        </div>
                        <div class="client-logo-container">
                            <img src="{{url('')}}{{imgbnk.relativeuserdir}}/your-logo.jpg" class="client-logo"/>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info" role="alert">
                        Podemos ayudarte a restablecer la contraseña para ingresar a tu cuenta, primero escribe la dirección
                        de correo eléctronico de tu usuario para recibir las instrucciones
                    </div>
                    <form action="{{url('session/recoverpassword')}}" method="post">
                        <div class="small-space"></div>
                        <p>{{flashSession.output()}}</p>
                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="email" class="form-control" placeholder="Dirección de correo eléctronico">
                        </div>

                        <div class="small-space"></div>
                        <div class="input-group" style="width: 100%;">
                            <button class="btn btn-sm btn-primary pull-right"><span class="glyphicon glyphicon-send"></span> Recuperar</button>
                            {#<input type="submit" class="btn btn-primary pull-right" value="Recuperar">#}
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