{% if index is not defined%}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-left" style="padding-top: 8px"">
			<select name="filter" id="filter" class="select2" >
                <option value="daily">Diario</option>
				<option value="accumulated">Acumulado</option>
            </select>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1"></div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 8px">
			<input type="text" id="branch" class="select2" />
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
			<input type="text" id="month" class="select2" />
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
			<input type="text" id="year" class="select2" />
		</div>
		<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right" style="padding-top: 8px">
			<button class="btn btn-xs btn-primary tooltip-b3" data-placement="top" title="Refrescar gráfica" onClick="refresh();">
				<i class="glyphicon glyphicon-refresh"></i>
			</button>
		</div>
    </div>
{% endif %}
<div class="big-space"></div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="{{report.idReport}}" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
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
	$(function () {
		$("#filter").select2({});
		$.getJSON('{{url('filter/getyears')}}', function(data) {
			$("#year").select2({
				data: data
			}).select2('val', {{year}});
			
			$.getJSON('{{url('filter/getmonths')}}', function(data) {
				$("#month").select2({
					data: data
				}).select2('val', {{month}});
			});
			
			$.getJSON('{{url('filter/getbranches')}}', function(data) {
				$("#branch").select2({
					data: data
				}).select2('val', 'all');
				refresh();
			});
		});
	});
{% else %}
	refresh();
{% endif %}
    
	function refresh() {
		var obj = createObject(false);
		getData{{report.idReport}}(obj);
	}
	
	function downloadReport() {
		var obj = createObject(true);
		createReport(obj);
	}
		
    function getData{{report.idReport}}(object) {
        $('#{{report.idReport}}').empty();
        $('#{{report.idReport}}').append('<div class="div-center"><img src="{{url('')}}/images/loading-bar1.GIF" /></div>');

        $.ajax({
            url: '{{url('')}}' + 'report/getdataforreport/' + {{report.idReport}},
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
				var title = {% if index is not defined%}'{{report.name}}'{% else %}''{% endif %};
                $('#{{report.idReport}}').children().fadeOut(500, function() {
                    $('#{{report.idReport}}').empty();
                        var array = convertObjectInArray(data.data);
						createBasicLine({
							container: '{{report.idReport}}',
							title: title,
							subtitle: object.title,
							x: ['01', '02', '03', '04', '05', '06','07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
							y: 'Pesos colombianos($)',
							data: [{
								name: 'Ventas',
								data: array
							}]
						});	
                });
            }
        });
    }
	
	function createObject(variable) {
		var download = (variable ? 'true' : 'false');
		var m = {{month}};
		var branch = 'all';
		var month = pad(m, 2);
		var year = {{year}};
		var filter = 'daily';
		
	{% if index is not defined%}
		m = $('#month').val();
		year = $('#year').val();
		branch = $('#branch').val();
		month = pad(m, 2);
		title = month + '/' + year;
		filter = $('#filter').val();
	{% endif %}	
		
		var title = month + '/' + year;
		filter = (variable ? 'accumulated' : filter);
		
		var obj = {
			idReport: {{report.idReport}},
			year: year,
			month: month,
			module: '{{report.module}}',
			branch: branch,
			title: title,
			filter: filter,
			download : download
		};
		
		return obj;
	}
</script>