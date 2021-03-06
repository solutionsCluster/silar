{% if index is not defined%}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-right">
		<input type="text" id="branch" class="select2" />
	</div>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
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

<div class="big-space"></div>
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
    $(function() {
        {% set year = date('Y')%}
		{% set month = date('m')%}
			
		$.getJSON('{{url('filter/getyears')}}',function(data){ 
			$("#year").select2({
				data: data
			}).select2('val', {{year}});
			
			$.getJSON('{{url('filter/getmonths')}}',function(data){
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
            error: function(data) {
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
            success: function(data) {
				console.log(data.data);
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
						createPie({
							container: '{{report.idReport}}',
							title: object.title,
							subtitle: 'Ventas',
							data: data.data
						});
					}
                });
            }
        });
    }
	
	function createObject(variable) {
		var download = (variable ? 'true' : 'false');
		var m = {{month}};
        var month = pad(m, 2);
        var year = {{year}};
        var branch = 'all';
		
	{% if index is not defined%}
		m = $('#month').val();
        month = pad(m, 2);
        year = $('#year').val();
		branch = $('#branch').val();
	{% endif %}
		
		var title = month + '/' + year;
		
		 var object = {
            idReport: {{report.idReport}},
			module: '{{report.module}}',
            month: month,
            year: year,
            branch: branch,
            title: title,
			download: download
        };
		
		return object;
	}
</script>