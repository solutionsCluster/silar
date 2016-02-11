{% extends "templates/index_2.volt" %}
{% block body %}
    <div class="big-space"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="page-header">Cambiar la contraseña del usuario <strong>{{user.userName}}</strong> de la cuenta <strong>{{account.name}}</strong></h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {{flashSession.output()}}
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form action = "{{url('account/changepassword')}}/{{account.idAccount}}/{{user.idUser}}" method="post" class="form-horizontal block block-default" role="form">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Escriba la nueva contraseña
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="password" name="pass1" class="form-control" placeholder="Escriba la nueva contraseña" required="required" autofocus="autofocus"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label">
                        <span class="required">*</span>Repita la nueva contraseña
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="password" name="pass2" class="form-control" placeholder="Repita la nueva contraseña" required="required"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11 text-right">
                        <a href="{{ url('account/showusers') }}/{{account.idAccount}}" class="btn btn-sm btn-default">Cancelar</a>
                        {{ submit_button("Guardar", 'class' : "btn btn-sm btn-success tooltip-b3", 'data-toggle': "tooltip", 'data-placement': "bottom", 'title': "Recuerda que los campos con asterisco (*) son obligatorios, por favor no los olvides") }}
                    </div>
                </div>
            </form>
        </div>
    </div>	
    <div class="big-space"></div>
{% endblock %}