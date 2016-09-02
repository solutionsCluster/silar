<script type="text/x-handlebars" data-template-name="relationships/index">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			{{'{{#link-to "roles.index" class="btn btn-default btn-sm" }}Roles{{/link-to}}'}}
		</div>
	</div>

	<div class="medium-space"></div>

	<div class="row block block-default">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			Para ver la relación role/recurso/acción vaya a <strong>Roles</strong> y haga clic en el botón <strong>"Ver relaciones"</strong>
		</div>
	</div>
	{#
	{{'{{#each model}}'}}
		<div class="block block-default">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
					{{ '{{id}}' }}
				</div>
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
					{{ '{{name}}' }}
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right">
					<button {{ '{{action "newaction" this}}' }} class="btn btn-primary btn-xs tooltip-b3" data-toggle="collapse" data-placement="top" title="Agregar nueva acción">
						<span class="glyphicon glyphicon-transfer"></span>
					</button>
			
					{{ '{{#link-to "resources.edit" this class="btn btn-primary btn-xs tooltip-b3" data-placement="top" title="Editar este recurso"}}' }}
						<span class="glyphicon glyphicon glyphicon-pencil"></span>
					{{'{{/link-to}}'}}
						
					<button class="btn btn-info btn-xs tooltip-b3" data-toggle="collapse" data-target="#detail-{{ '{{unbound id}}'}}" data-placement="top" title="Ver acciones creadas en este recurso">
						<span class="glyphicon glyphicon-collapse-down"></span>
					</button>

					{{ '{{#link-to "resources.delete" this class="btn btn-danger btn-xs tooltip-b3" data-placement="top" title="Eliminar este recurso"}}' }}
						<span class="glyphicon glyphicon-trash"></span>
					{{'{{/link-to}}'}}
				</div>
			</div>
	
			<div id="detail-{{'{{unbound id}}'}}" class="collapse row">
				<hr class="line-primary">
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
					<table class="table table-bordered table-white">
						<thead></thead>
						<tbody>
							{{'{{#each action}}'}}
								<tr>
									<td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
										{{ '{{id}}' }}
									</td>
									
									<td class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
										{{ '{{name}}' }}
									</td>
									
									<td class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
										{{ '{{#link-to "actions.edit" this class="btn btn-default btn-xs"}}' }}
											<span class="glyphicon glyphicon glyphicon-pencil"></span>
										{{'{{/link-to}}'}}
											
										{{ '{{#link-to "actions.delete" this class="btn btn-danger btn-xs"}}' }}
											<span class="glyphicon glyphicon-trash"></span>
										{{'{{/link-to}}'}}
									</td>
								</tr>
							{{'{{else}}'}}
								<tr>
									<td class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										No hay acciones creadas en este recurso, para crear una haga <span {{ '{{action "newaction" this}}' }} class="a-false">clic aqui</span>
									</td>
								</tr>
							{{ '{{/each}}' }}
						</tbody>
					</table>	
				</div>
			</div>
		</div>
		<div class="medium-space"></div>
	{{ '{{/each}}' }}
	#}
</script>