{% if index is not defined%}
    <div class="row">
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="padding-top: 8px">
			<input type="text" id="branch" class="select2" />
		</div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left" style="padding-top: 8px"></div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
			<input type="text" id="month" class="select2" />
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
			<input type="text" id="year" class="select2" />
		</div>
    </div>
    <div class="big-space"></div>
	<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			<div style="display: inline; margin-right: 10px;"><img src="{{url('')}}images/spinner.GIF" height="35" width="35" id="loading" style="display: none;"/></div>
			<button class="btn btn-sm btn-primary" onClick="downloadReport();">
				<i class="glyphicon glyphicon-download-alt"></i> Descargar reporte
			</button>
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
		});

		$.getJSON('{{url('filter/getmonths')}}', function(data) {
			$("#month").select2({
				data: data
			}).select2('val', {{month}});
		});

		$.getJSON('{{url('filter/getbranches')}}', function(data) {
			$("#branch").select2({
				data: data
			}).select2('val', 'all');
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
			module: 'sales',
			year: year,
			month: month,
			branch: branch,
			title: title
		};
		
		createReport(obj);
	}
</script>