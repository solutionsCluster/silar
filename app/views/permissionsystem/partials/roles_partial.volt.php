<script type="text/x-handlebars" data-template-name="roles/index">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			<?php echo '{{#link-to "roles.new" class="btn btn-default btn-sm" }}<span class="glyphicon glyphicon-plus"></span> Crear nuevo role{{/link-to}}'; ?>
		</div>
	</div>

	<div class="medium-space"></div>

	<?php echo '{{#each model}}'; ?>
		<div class="row block block-default">
			<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
				<?php echo '{{id}}'; ?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
				<?php echo '{{name}}'; ?>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right">
				<?php echo '{{#link-to "roles.edit" this class="btn btn-default btn-xs"}}'; ?>
					<span class="glyphicon glyphicon-edit"></span>
				<?php echo '{{/link-to}}'; ?>
				
				<?php echo '{{#link-to "roles.delete" this class="btn btn-danger btn-xs"}}'; ?>
					<span class="glyphicon glyphicon-trash"></span>
				<?php echo '{{/link-to}}'; ?>
			</div>
		</div>
		<div class="medium-space"></div>
	<?php echo '{{else}}'; ?>
		<div class="row block block-default">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h5>
					No hay roles de usuario en el sistema, para crear uno haga 
					<?php echo '{{#link-to "roles.new"}}'; ?>
						clic aqui
					<?php echo '{{/link-to}}'; ?>
				</h5>
			</div>
		</div>
	<?php echo '{{/each}}'; ?>
</script>

<script type="text/x-handlebars" data-template-name="roles/new">
	<?php echo '{{#if App.error-message}}'; ?>
		<div class="alert alert-danger text-center" role="alert"><?php echo '{{App.error-message}}'; ?></div>
	<?php echo '{{/if}}'; ?>
	
	<div class="block">
		<form class="form-horizontal block block-default" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">
					<span class="required">*</span>Nombre del role: 
				</label>
				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
					<?php echo ' {{view Ember.TextField valueBinding="name" placeholder="Nombre del recurso" id="name" required="required" autofocus="autofocus" class="form-control"}} '; ?>
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

<script type="text/x-handlebars" data-template-name="roles/edit">
	<?php echo '{{#if App.error-message}}'; ?>
		<div class="alert alert-danger text-center" role="alert"><?php echo '{{App.error-message}}'; ?></div>
	<?php echo '{{/if}}'; ?>
		
	<div class="block">
		<form class="form-horizontal block block-default" role="form">
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">
					<span class="required">*</span>Nombre del role: 
				</label>
				<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
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

<script type="text/x-handlebars" data-template-name="roles/delete">
	<?php echo '{{#if App.error-message}}'; ?>
		<div class="alert alert-danger text-center" role="alert"><?php echo '{{App.error-message}}'; ?></div>
	<?php echo '{{/if}}'; ?>
		
	<div class="row block block-danger">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<p>
				¿Esta seguro que desea eliminar este role?, <br />recuerde que para eliminarlo, este no puede
				estar relacionado con ningún recurso, y por consiguiente ningún usuario
			</p>
			<button class="btn btn-default btn-xs" <?php echo '{{action "cancel" this}}'; ?>>Cancelar</button>
			<button class="btn btn-danger btn-xs" <?php echo '{{action "delete" this}}'; ?>>Eliminar</button>
		</div>
	</div>
</script>