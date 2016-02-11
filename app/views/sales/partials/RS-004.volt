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
			<input type="text" id="year1" class="select2" />
		</div>
		<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
			<input type="text" id="year2" class="select2" />
		</div>
		<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right" style="padding-top: 8px">
			<button class="btn btn-xs btn-primary tooltip-b3" data-placement="top" title="Refrescar gráfica" onClick="refresh();">
				<i class="glyphicon glyphicon-refresh"></i>
			</button>
		</div>
    </div>
    <div class="big-space"></div>
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
    $(function () {
		{% set year = date('Y')%}
		$("#filter").select2({});
		$.getJSON('{{url('filter/getyears')}}', function(data) {
			$("#year2").select2({
				data: data
			}).select2('val', {{year}});
			
			var year2 = {{year}} - 1;
			$("#year1").select2({
				data: data
			}).select2('val', year2);
		});

		$.getJSON('{{url('filter/getbranches')}}', function(data) {
			$("#branch").select2({
				data: data
			}).select2('val', 'all');
			refresh();
		});
    });
    
    function refresh() {
        var obj = createObject();
        getData{{report.idReport}}(obj);
    }
   
	function downloadReport() {
		var obj = createObject();
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
                $.gritter.add({class_name: 'gritter-error', title: '<i class="glyphicon glyphicon-exclamation-sign"></i> Error', text: data.responseJSON.message, sticky: false, time: 6000});
            },
            success: function(data){
                $('#{{report.idReport}}').children().fadeOut(500, function() {
                    $('#{{report.idReport}}').empty();
                        var year1 = convertObjectInArray(data.data[object.year1]);
                        var year2 = convertObjectInArray(data.data[object.year2]);
						
						createBasicLine({
                            container: '{{report.idReport}}',
                            title: '{{report.name}}',
                            subtitle: object.title,
                            x: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                            y: 'Pesos colombianos($)',
                            data: [{
                                name: object.year1,
                                data: year1,
								negativeColor: '#FF1300',
                            },{
								name: object.year2,
                                data: year2,
								negativeColor: '#FF1300',
							}]
                        });	
                });
            }
        });
    }
	
	function createObject() {
	{% set year = date('Y')%}
	{% if index is not defined%}
		var year1 = $('#year1').val();
		var year2 = $('#year2').val();
		var branch = $('#branch').val();
        var filter = $('#filter').val();
	{% else %}
		var year1 = {{year}} - 1;
		var year2 = {{year}};
		var branch = "all";
        var filter = 'daily';
	{% endif %}
		var obj = {
			idReport: {{report.idReport}},
			module: 'sales',
			year1: year1,
			year2: year2,
			branch: branch,
			title: year1 + ' y ' + year2,
			filter: filter
		};
		
		return obj;
	}
</script>