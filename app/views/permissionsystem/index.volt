{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}
    <script type="text/javascript">
        var url = '{{urlManager.getAPIUrl1()}}';
    </script>
    {{ partial('partials/ember_partial') }}
    {{ javascript_include('vendors/ember-1.7.0/mixin-save.js')}}
    {{ javascript_include('js/ember-permission-system/app-permission-system.js')}}
{% endblock %}
{% block body %}
    <div id="emberAppContainer">
		<script type="text/x-handlebars"> 
			<div class="big-space"></div>
            <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2 class="page-header">Sistema de permisos</h2>
				</div>
            </div>
            <div class="big-space"></div>
    
            <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-pills">
						{{'{{#link-to "roles" tagName="li" href=false}}<a {{bind-attr href="view.href"}} class="pointer">Roles</a>{{/link-to}}'}}
						{{'{{#link-to "resources" tagName="li" href=false}}<a {{bind-attr href="view.href"}} class="pointer">Recursos</a>{{/link-to}}'}}
						{{'{{#link-to "actions" tagName="li" href=false}}<a {{bind-attr href="view.href"}} class="pointer">Acciones</a>{{/link-to}}'}}
						{{'{{#link-to "relationships" tagName="li" href=false}}<a {{bind-attr href="view.href"}} class="pointer">Relaciones</a>{{/link-to}}'}}
					</ul>
                    
                    <div class="big-space"></div>
                    {{ "{{outlet}}" }}
                </div>
            </div>
        </script>
        
        {{ partial('permissionsystem/partials/resources_partial') }}
        {{ partial('permissionsystem/partials/roles_partial') }}
		{{ partial('permissionsystem/partials/actions_partial') }}
		{{ partial('permissionsystem/partials/relationships_partial') }}
		
		<div class="big-space"></div>
    </div>
	<div class="big-space"></div>
	<div class="big-space"></div>
{% endblock %}
