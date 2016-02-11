{% extends "templates/index_1.volt" %}
{% block body %}
    <hr class="line-primary">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
            <div class="logo-page-error">
                <a href="http://www.i7group.com/" target="_blank">
                    <img src="{{url('')}}image-bank/silar-logo.jpg" class="app-logo" style="margin-bottom: 10px;"/>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-page-error">
                    <div class="avatar-page-error">
                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                    </div>
                    <div class="code-page-error">
                        401
                    </div>
                    <div class="text-page-error">
                        Sección no autorizada <a href="{{url('')}}"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="line-primary">
{% endblock %}