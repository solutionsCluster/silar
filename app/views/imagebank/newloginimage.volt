{% extends "templates/index_2.volt" %}
{% block header %}
	<script type="text/javascript">
		function cleanInputFile(){
			$('#input-file-decorator').val('');
			$('#file').val('');
		}

		$(function () {
			$('input[type=file]').change(function () {
			    $('#input-file-decorator').val(this.files[0].name);
			});
		});

	</script>
{% endblock %}
{% block body %}
	<div class="big-space"></div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{flashSession.output()}}
			<h2 class="page-header">Cargar nueva imagen dinámica de inicio de sesión</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{flashSession.output()}}
		</div>
	</div>
	
	<div class="big-space"></div>

	<form action="{{url('imagebank/newloginimage')}}" class="block block-default" method="post" role="form" enctype="multipart/form-data">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-sm-6">
						<div class="input-group fileWrapper">
							<input type="text" class="fileInputText form-control" id="input-file-decorator" readonly="readonly">
							<span class="input-group-btn">
								<button type="button" class="fileInputButton btn btn-primary btn-no-rc">
									<span class="glyphicon glyphicon-folder-open"></span> Examinar
								</button>
							</span>
							<input type="file" name="file" id="file" class="input-file-style" />
						</div>
					</div>
				</div>

				<div class="small-space"></div>

				<div class="row">
					<div class="col-sm-12 text-left">
						<a href="{{url('imagebank')}}" class="btn btn-sm btn-default">Cancelar</a>
						<a href="javascript: void(0);" class="btn btn-sm btn-primary" onClick="cleanInputFile();">Limpiar</a>
						<input type="submit" name="submit" class="btn btn-sm btn-success" value="Cargar">
					</div>
				</div>
			</div>
		</div>
	</form>
{% endblock %}
