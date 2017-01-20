<script type="text/x-handlebars" data-template-name="actions/index">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			<?php echo '{{#link-to "resources.index" class="btn btn-default btn-sm" }}Recursos{{/link-to}}'; ?>
		</div>
	</div>

	<div class="medium-space"></div>

	<div class="row block block-default">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			Para ver las acciones vaya a <strong>Recursos</strong> y haga clic en el botón <strong>"Ver acciones creadas en este recurso"</strong>
		</div>
	</div>
	
</script>

<script type="text/x-handlebars" data-template-name="actions/new">
	 <div class="big-space"></div>
		<div class="row block">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h4 class="page-header" style="color: #777;">Agregar una acción al recurso <strong><?php echo '{{App.resource.name}}'; ?></strong></h4>
			</div>
		</div>
	</div>
	<?php echo '{{#if App.error-message}}'; ?>
		<div class="alert alert-danger text-center" role="alert"><?php echo '{{App.error-message}}'; ?></div>
	<?php echo '{{/if}}'; ?>
		
	<div class="block">
		<form class="form-horizontal block block-default" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">
					<span class="required">*</span>Nombre de la acción: 
				</label>
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<?php echo ' {{view Ember.TextField valueBinding="name" placeholder="Nombre de la acción" id="name" required="required" autofocus="autofocus" class="form-control"}} '; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<button class="btn btn-default btn-sm" <?php echo '{{action "cancel" this}}'; ?>>Cancelar</button>
					<button class="btn btn-success btn-sm" <?php echo ' {{action "save" this}} '; ?>>Guardar</button>
				</div>
			</div>
		 </form>
	</div>
</script>

<script type="text/x-handlebars" data-template-name="actions/edit">
	<?php echo '{{#if App.error-message}}'; ?>
		<div class="alert alert-danger text-center" role="alert"><?php echo '{{App.error-message}}'; ?></div>
	<?php echo '{{/if}}'; ?>
		
	<div class="block">
		<form class="form-horizontal block block-default" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">
					<span class="required">*</span>Nombre de la acción: 
				</label>
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<?php echo ' {{view Ember.TextField valueBinding="name" placeholder="Nombre del recurso" id="name" required="required" autofocus="autofocus" class="form-control"}} '; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
					<button class="btn btn-default" <?php echo '{{action "cancel" this}}'; ?>>Cancelar</button>
					<button class="btn btn-success" <?php echo ' {{action "edit" this}} '; ?>>Guardar</button>
				</div>
			</div>
		 </form>
	</div>
</script>

<script type="text/x-handlebars" data-template-name="actions/delete">
	<?php echo '{{#if App.error-message}}'; ?>
		<div class="alert alert-danger text-center" role="alert"><?php echo '{{App.error-message}}'; ?></div>
	<?php echo '{{/if}}'; ?>
		
	<div class="row block block-danger">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<p>
				¿Está seguro que desea eliminar esta acción?, <br />recuerde que para eliminarla, esta no puede
				estar relacionada con ningún usuario
			</p>
			<button class="btn btn-default btn-xs" <?php echo '{{action "cancel" this}}'; ?>>Cancelar</button>
			<button class="btn btn-danger btn-xs" <?php echo '{{action "delete" this}}'; ?>>Eliminar</button>
		</div>
	</div>
</script>