{% if index is not defined%}
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
			<div class="form-horizontal block block-default">
				<div class="form-group">
					<label for="branch" class="col-sm-3 control-label">Elija una sucursal</label>
					<div class="col-sm-9">
						<input type="text" id="branch" class="select2" />
					</div>
				</div>
				<div class="form-group">
					<label for="month" class="col-sm-3 control-label">Elija un mes</label>
					<div class="col-sm-9">
						<input type="text" id="month" class="select2" />
					</div>
				</div>
				<div class="form-group">
					<label for="year" class="col-sm-3 control-label">Elija un año</label>
					<div class="col-sm-9">
						<input type="text" id="year" class="select2" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button class="btn btn-sm btn-primary" onClick="downloadReport();">
							<i class="glyphicon glyphicon-download-alt"></i> Descargar reporte
						</button>
						<div style="display: inline; margin-right: 10px;"><img src="{{url('')}}images/spinner.GIF" height="35" width="35" id="loading" style="display: none;"/></div>	
					</div>
				</div>
			 </div>
		</div>
	</div>
{% endif %}
	
<div class="big-space"></div>
<script src="{{url('')}}vendors/highcharts-4.0.4/js/highcharts-more.js"></script>
<script type="text/javascript">
    $(function () {
        {% set year = date('Y')%}
		{% set month = date('m')%}
		$("#filter").select2({});
		$.getJSON('{{url('filter/getyears')}}', function(data) {
			$("#year").select2({
				data: data
			}).select2('val', {{year}});
			
			$.getJSON('{{url('filter/getmonths')}}', function(data) {
				$("#month").select2({
					data: data
				}).select2('val', {{month}});
				
				$.getJSON('{{url('filter/getbranches')}}', function(data) {
					$("#branch").select2({
						data: data
					}).select2('val', 'all');
				});
			});
		});
    });
   
	function downloadReport() {
		var m = $('#month').val();
        var year = $('#year').val();
        var branch = $('#branch').val();
        var month = pad(m, 2);
        var title = month + '/' + year;
		
		var obj = {
			idReport: {{report.idReport}},
			module: '{{report.module}}',
			year: year,
			month: month,
			branch: branch,
			title: title
		};
		
		createReport(obj);
	}
</script>