{% if index is not defined%}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="padding-top: 8px">
        <input type="text" id="branch" class="select2" /> <br />
		<select id="cant" name="cant" class="select2" style="padding-top: 5px">
			<option value="10" selected>10 Primeros productos</option>
			<option value="20">20 Primeros productos</option>
			<option value="50">50 Primeros productos</option>
			<option value="200">200 Primeros productos</option>
			<option value="500">500 Primeros productos</option>
			<option value="1000">1000 Primeros productos</option>
		</select> 
    </div>
		
	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
        <select id="status" name="status" class="select2">
			<option value="worse">Peor utilidad</option>
			<option value="better" selected>Mejor utilidad</option>
		</select> 
    </div>
		
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right" style="padding-top: 8px">
        <input type="text" id="month" class="select2" /> <br />
		<input type="text" id="year" class="select2" />
    </div>
		
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
        <select id="rang1" name="rang1" class="select2">
			<option value="0" selected>0%</option>
			<option value="10">10%</option>
			<option value="20">20%</option>
			<option value="30">30%</option>
			<option value="40">40%</option>
			<option value="50">50%</option>
			<option value="60">60%</option>
			<option value="70">70%</option>
			<option value="80">80%</option>
			<option value="90">90%</option>
			<option value="100">100%</option>
		</select> <br />
		<select id="rang2" name="rang2" class="select2">
			<option value="10" selected>10%</option>
			<option value="20">20%</option>
			<option value="30">30%</option>
			<option value="40">40%</option>
			<option value="50">50%</option>
			<option value="60">60%</option>
			<option value="70">70%</option>
			<option value="80">80%</option>
			<option value="90">90%</option>
			<option value="100" selected>100%</option>
		</select> 
    </div>
		
    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right" style="padding-top: 8px">
        <button class="btn btn-xs btn-primary tooltip-b3" data-placement="top" title="Refrescar gráfica" onClick="refresh();">
            <i class="glyphicon glyphicon-refresh"></i>
        </button>
    </div>
</div>
<div class="big-space"></div>
{% endif %}

{% if index is not defined%}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
		<div style="display: inline; margin-right: 10px;"><img src="{{url('')}}images/spinner.GIF" height="35" width="35" id="loading" style="display: none;"/></div>
		<button class="btn btn-sm btn-primary" onClick="downloadReport();">
			<i class="glyphicon glyphicon-download-alt"></i> Descargar reporte
		</button>
	</div>
</div>
<div class="big-space"></div>
{% endif %}

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
				<div id="{{report.idReport}}" style="width:100%; margin: 0 auto"></div>
            </div>
        </div>
    </div>
</div>

{% if index is not defined%}
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

<script type="text/javascript">
	{% set year = date('Y')%}
	{% set month = date('m')%}
		
	{% if index is not defined%}
		$(function() {
			$('#filter').select2();
			$('#cant').select2();
			$('#rang1').select2();
			$('#rang2').select2();
			$('#status').select2();
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
						refresh();
					});
				});
			});
		});
	{% else %}
		refresh();
	{% endif %}
		
	function refresh() {
		var object = createObject();
		getData{{report.idReport}}(object);
	}
	
	function downloadReport() {
		var obj = createObject();
		createReport(obj);
	}
	
	function getData{{report.idReport}}(object) {
        $('#{{report.idReport}}').empty();
        $('#{{report.idReport}}').append('<div class="div-center"><img src="{{url('')}}/images/loading-bar1.GIF" /></div>');

        $.ajax({
            url: '{{url('')}}' + 'report/getdataforreport',
            type: "POST",			
            data: {object: object},
            error: function(data){
				var notification = new NotificationFx({
					wrapper : document.body,
					message : '<p>' + data.responseJSON.message + '</p>',
					layout : 'growl',
					effect : 'slide',
					ttl : 15000,
					type : 'error'
				});
				// show the notification
				notification.show();
            },
            success: function(data){
                $('#{{report.idReport}}').children().fadeOut(500, function() {
                    $('#{{report.idReport}}').empty();
					var title = {% if index is not defined%}'{{report.name}}'{% else %}''{% endif %};
					var util = convertObjectInArray(data.data.util);
					var products = convertObjectInArray(data.data.products);
					if (util.length == 0 || products.length == 0) {
						$('#{{report.idReport}}').append('<div class="alert alert-warning">\n\
																No existen datos con los filtros seleccionados\n\
															</div>');
					}
					else {
						createBasicBar({
							container: {{report.idReport}},
							title: title,
							subtitle: object.title,
							x: products,
							y: ' Utilidad',
							tooltip: '%',
							data: [{
								name: 'Utilidad',
								data: util
							}]
						});
					}
                });
            }
        });
    }
	
	function createObject() {
		var filter = $('#filter').val();
		var status = $('#status').val();
		var m = {{month}};
		var branch = 'all';
		var cant = 10;
		var month = pad(m, 2);
		var year = {{year}};
		var rang1 = '90';
		var rang2 = '100';
	{% if index is not defined%}
		m = $('#month').val();
		branch = $('#branch').val();
		cant = $('#cant').val();
		month = pad(m, 2);
		year = $('#year').val();
		rang1 = $('#rang1').val();
		rang2 = $('#rang2').val();
	{% endif %}
	
		var object = {
			idReport: {{report.idReport}},
			filter: filter,
			cant: cant,
			module: '{{report.module}}',
			year: year,
			month: month,
			branch: branch,
			title: month + '/' + year,
			rang2: rang2,
			rang1: rang1,
			status: status
		};
		
		var height = (cant == 10 || cant == 20 ? cant*40: cant*20);
		adjustChartContainer({container: '{{report.idReport}}', height: height});
		
		return object;
	}	
</script>