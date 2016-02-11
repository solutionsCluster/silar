{% extends "templates/index_2.volt" %}
{% block body %}
    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Cambiar la contraseña del usuario <strong>{{user.userName}}</strong></h2>
        </div>
    </div>

    <div class="big-space"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('user')}}" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-arrow-left"></span> Regresar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="medium-space"></div>
            {{flashSession.output()}}
        </div>
    </div>
	
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form action="{{url('user/changepassword')}}/{{user.idUser}}" method="post" class="form-horizontal block block-default" role="form">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Contraseña: 
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <input type="password" name="pass1" class="form-control" required autofocus placeholder="Contraseña" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Repita la contraseña:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <input type="password" name="pass2" class="form-control" required placeholder="Repita la contraseña" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 text-right">
                        <a href="{{ url('user') }}" class="btn btn-default btn-sm">Cancelar</a>
                        {{ submit_button("Cambiar", 'class' : "btn btn-success tooltip-b3 btn-sm", 'data-toggle': "tooltip", 'data-placement': "left", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides", 'data-original-title': "Tooltip on left") }}
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="big-space"></div>
{% endblock %}
