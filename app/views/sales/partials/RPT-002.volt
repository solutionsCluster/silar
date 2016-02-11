{% if index is not defined%}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" style="padding-top: 8px">
        <input type="text" id="branch" class="select2" />
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"></div>
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

<script type="text/javascript">
	{% set year = date('Y')%}
	{% set month = date('m')%}
		
	{% if index is not defined%}
		$(function() {
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
				refresh();
			});
		});
	{% else %}
		refresh();
	{% endif %}
	
	function refresh() {
		var object = createObject();
		getData{{report.idReport}}(object);
	}
	
	function getData{{report.idReport}}(object) {
		$('#{{report.idReport}}').empty();
		$('#{{report.idReport}}').append('<div class="div-center"><img src="{{url('')}}/images/loading-bar1.GIF" /></div>');

		$.ajax({
			url: '{{url('')}}' + 'report/getdataforreport/' + {{report.idReport}},
			type: "POST",
			data: {object: object},
			error: function(data) {
				$.gritter.add({class_name: 'gritter-error', title: '<i class="glyphicon glyphicon-exclamation-sign"></i> Error', text: data.responseJSON.message, sticky: false, time: 6000});
			},
			success: function(data) {
				$('#{{report.idReport}}').children().fadeOut(500, function() {
					$('#{{report.idReport}}').empty();
					console.log(data);
					createTable({
						data: data.data,
						container: '{{report.idReport}}'
					});
				});
			}
		});
	}
	
	function createObject() {
	{% if index is not defined%}
		var m = $('#month').val();
		var branch = $('#branch').val();
		var month = pad(m, 2);
		var year = $('#year').val();
		var title = month + '/' + year;
	{% else %}
		var m = {{month}};
		var branch = 'all';
		var month = pad(m, 2);
		var year = {{year}};
		var title = month + '/' + year;
	{% endif %}
	
		var object = {
			idReport: {{report.idReport}},
			module: 'sales',
			year: year,
			month: month,
			branch: branch,
			title: title
		};
		
		return object;
	}
</script>