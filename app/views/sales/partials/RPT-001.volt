<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-right">
		<input type="text" id="branch" class="select2" />
	</div>
	<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 text-right"></div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right">
        <input type="text" id="year" class="select2" />
    </div>
	<div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right">
		<button class="btn btn-xs btn-primary tooltip-b3" data-placement="top" title="Refrescar gráfica" onClick="refresh();">
			<i class="glyphicon glyphicon-refresh"></i>
		</button>
	</div>
</div>
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

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
		<div style="display: inline; margin-right: 10px;"><img src="{{url('')}}images/spinner.GIF" height="35" width="35" id="loading" style="display: none;"/></div>
		<button class="btn btn-sm btn-primary" onClick="downloadReport();">
			<i class="glyphicon glyphicon-download-alt"></i> Descargar reporte
		</button>
	</div>
</div>

<div class="big-space"></div>
<script type="text/javascript">
    $(function () {
		{% set year = date('Y')%}
		$("#filter").select2({});
		$.getJSON('{{url('filter/getyears')}}', function(data) {
			$("#year").select2({
				data: data
			}).select2('val', {{year}});
		});

		$.getJSON('{{url('filter/getbranches')}}', function(data) {
			$("#branch").select2({
				data: data
			}).select2('val', 'all');
			refresh();
		});
    });
	
	function refresh() {
        var object = createObject();
        getData{{report.idReport}}(object);
    }
	
	function downloadReport() {
		var object = createObject();
		createReport(object);
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
                        createBasicLine({
                            container: '{{report.idReport}}',
                            title: '{{report.name}}',
                            subtitle: object.title,
                            x: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                            y: 'Pesos colombianos($)',
                            data: data.data
                        });	
                });
            }
        });
    }
	
	function createObject() {
	{% if index is not defined%}
		var year = $('#year').val();
		var branch = $('#branch').val();
	{% else %}
		var branch = 'all';
		var year = {{year}};
	{% endif %}	
		
		var object = {
			idReport: {{report.idReport}},
			module: 'sales',
			year: year,
			branch: branch,
			title: year
		};
		
		return object;
	}
</script>