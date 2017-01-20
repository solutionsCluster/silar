{% if index is not defined%}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 8px">
		<input type="text" id="branch" class="select2" />
	</div>
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 8px">
		<input type="text" id="line" class="select2" />
	</div>
		
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 8px"></div>
	
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
	<input type="text" id="month" class="select2" /> 
        <input type="text" id="year" class="select2" />
    </div>
    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 text-right" style="padding-top: 8px">
        <button class="btn btn-xs btn-primary tooltip-b3" data-placement="top" title="Refrescar gráfica" onClick="refresh();">
            <i class="glyphicon glyphicon-refresh"></i>
        </button>
    </div>
</div>
<div class="big-space"></div>
{% endif %}

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
    $(function() {
		{% set year = date('Y')%}
		{% set month = date('m')%}
			
		$.getJSON('{{url('filter/getyears')}}',function(data){ 
			$("#year").select2({
				data: data
			}).select2('val', {{year}});
		
			$.getJSON('{{url('filter/getmonths')}}', function(data) {
				$("#month").select2({
					data: data
				}).select2('val', {{month}});
	
				$.getJSON('{{url('filter/getbranches')}}',function(data){
					$("#branch").select2({
						data: data
					}).select2('val', 'all');
					$.getJSON('{{url('filter/getlines')}}',function(data){
						data.shift();
						$("#line").select2({
							data: data
						}).select2('val', data[0].id);
						refresh();
					});	
				});
			});
		});
    });

    function refresh() {
		var object = createObject(false);
        getData{{report.idReport}}(object);
    }
	
	function downloadReport() {
		var object = createObject(true);
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
						if (data.data.length == 0) {
							$('#{{report.idReport}}').append('<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\n\
																<div class="alert alert-warning">\n\
																	No existen datos con los filtros seleccionados\n\
																</div>\n\
															  </div>');
						}
						else {
							createBasicLine({
								container: '{{report.idReport}}',
								title: '{{report.name}}',
								subtitle: object.title,
								x: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
								y: 'Pesos colombianos($)',
								data: data.data
							});	
						}
                });
            }
        });
    }
	
	function createObject(variable) {
		var download = (variable ? 'true' : 'false');
        var year = {{year}};
		var branch = 'all';
		var line = 'all';
		
	{% if index is not defined%}
        year = $('#year').val();
		branch = $('#branch').val();
		line = $('#line').val();
	{% endif %}
		
		var object = {
            idReport: {{report.idReport}},
			module: '{{report.module}}',
            year: year,
            branch: branch,
            line: line,
            title: year,
			download: download
        };
		
		return object;
	}
</script>
