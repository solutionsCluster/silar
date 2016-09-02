{% extends "templates/index_1.volt" %}
{% block body %}
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default login-box">
                <div class="panel-sidebar">
                    <img src="{{url('')}}{{loginimage.loadImageDir()}}" class="principal-image" />
                </div>
                <div class="panel-body panel-content">
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

                    <div class="big-space"></div>

                    <form action="{{url('session/validatesession')}}" method="post">
                        <p>{{flashSession.output()}}</p>
                        <div class="small-space"></div>
                        
                        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}"/>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="userName" class="form-control" placeholder="Nombre de usuario">
                        </div>

                        <div class="small-space"></div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Contraseña">
                        </div>

                        <div class="small-space"></div>

                        <div class="input-group" style="width: 100%;">
                            <input type="submit" class="btn btn-primary pull-right" value="Iniciar sesión">
                        </div>
                        
						<div class="big-space"></div>
						
                        <div class="input-group" style="width: 100%;">
                            <p class="text-center">
                                <a href="{{url('session/recoverpassword')}}">¿Olvidaste tu contraseña?</a> - <a href="http://solutionscluster.net/silar" target="_blank">¿Qué es esto?</a>
                            </p>
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