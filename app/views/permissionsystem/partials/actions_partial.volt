<script type="text/x-handlebars" data-template-name="actions/index">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			{{'{{#link-to "resources.index" class="btn btn-default btn-sm" }}Recursos{{/link-to}}'}}
		</div>
	</div>

	<div class="medium-space"></div>

	<div class="row block block-default">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			Para ver las acciones vaya a <strong>Recursos</strong> y haga clic en el botón <strong>"Ver acciones creadas en este recurso"</strong>
		</div>
	</div>
	{#
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			{{'{{#link-to "actions.new" class="btn btn-default btn-sm" }}<span class="glyphicon glyphicon-plus"></span> Crear nueva acción{{/link-to}}'}}
		</div>
	</div>

	<div class="medium-space"></div>

	{{'{{#each model}}'}}
		<div class="row block block-default">
			<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
				{{ '{{id}}' }}
			</div>
	
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				{{ '{{resource}}' }}
			</div>
	
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				{{ '{{name}}' }}
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right">
				{{ '{{#link-to "roles.edit" this class="btn btn-default btn-xs"}}' }}
					<span class="glyphicon glyphicon-edit"></span>
				{{'{{/link-to}}'}}
				
				{{ '{{#link-to "roles.delete" this class="btn btn-danger btn-xs"}}' }}
					<span class="glyphicon glyphicon-trash"></span>
				{{'{{/link-to}}'}}
			</div>
		</div>
		<div class="medium-space"></div>
	{{'{{else}}'}}
		<div class="row block block-default">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h5>
					No hay acciones sobre recursos en el sistema, para crear una haga 
					{{ '{{#link-to "actions.new"}}' }}
						clic aqui
					{{'{{/link-to}}'}}
				</h5>
			</div>
		</div>
	{{ '{{/each}}' }}
	#}
</script>

<script type="text/x-handlebars" data-template-name="actions/new">
	 <div class="big-space"></div>
		<div class="row block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h4 class="page-header" style="color: #777;">Agregar una acción al recurso <strong>{{ '{{App.resource.name}}' }}</strong></h4>
			</div>
		</div>
	</div>
	{{ '{{#if App.error-message}}' }}
		<div class="alert alert-danger text-center" role="alert">{{ '{{App.error-message}}' }}</div>
	{{ '{{/if}}' }}
		
	<div class="block">
		<form class="form-horizontal block block-default" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">
					<span class="required">*</span>Nombre de la acción: 
				</label>
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					{{' {{view Ember.TextField valueBinding="name" placeholder="Nombre de la acción" id="name" required="required" autofocus="autofocus" class="form-control"}} '}}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<button class="btn btn-default btn-sm" {{ '{{action "cancel" this}}' }}>Cancelar</button>
					<button class="btn btn-success btn-sm" {{' {{action "save" this}} '}}>Guardar</button>
				</div>
			</div>
		 </form>
	</div>
</script>

<script type="text/x-handlebars" data-template-name="actions/edit">
	{{ '{{#if App.error-message}}' }}
		<div class="alert alert-danger text-center" role="alert">{{ '{{App.error-message}}' }}</div>
	{{ '{{/if}}' }}
		
	<div class="block">
		<form class="form-horizontal block block-default" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">
					<span class="required">*</span>Nombre de la acción: 
				</label>
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					{{' {{view Ember.TextField valueBinding="name" placeholder="Nombre del recurso" id="name" required="required" autofocus="autofocus" class="form-control"}} '}}
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<button class="btn btn-default" {{ '{{action "cancel" this}}' }}>Cancelar</button>
					<button class="btn btn-success" {{' {{action "edit" this}} '}}>Guardar</button>
				</div>
			</div>
		 </form>
	</div>
</script>

<script type="text/x-handlebars" data-template-name="actions/delete">
	{{ '{{#if App.error-message}}' }}
		<div class="alert alert-danger text-center" role="alert">{{ '{{App.error-message}}' }}</div>
	{{ '{{/if}}' }}
		
	<div class="row block block-danger">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<p>
				¿Está seguro que desea eliminar esta acción?, <br />recuerde que para eliminarla, esta no puede
				estar relacionada con ningún usuario
			</p>
			<button class="btn btn-default btn-xs" {{ '{{action "cancel" this}}' }}>Cancelar</button>
			<button class="btn btn-danger btn-xs" {{'{{action "delete" this}}'}}>Eliminar</button>
		</div>
	</div>
</script>
