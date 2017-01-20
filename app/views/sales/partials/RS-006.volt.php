<?php if (!isset($index)) { ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 8px">
		<input type="text" id="branch" class="select2" />
	</div>
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 8px">
		<input type="text" id="line" class="select2" />
	</div>
		
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 8px"></div>
	
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
<?php } ?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="<?php echo $report->idReport; ?>" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
    </div>
</div>

<?php if (!isset($index)) { ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
		<div style="display: inline; margin-right: 10px;"><img src="<?php echo $this->url->get(''); ?>images/spinner.GIF" height="35" width="35" id="loading" style="display: none;"/></div>
		<button class="btn btn-sm btn-primary" onClick="downloadReport();">
			<i class="glyphicon glyphicon-download-alt"></i> Descargar reporte
		</button>
	</div>
</div>
<?php } ?>
<div class="big-space"></div>

<script type="text/javascript">
    $(function() {
		<?php $year = date('Y'); ?>
		<?php $month = date('m'); ?>
			
		$.getJSON('<?php echo $this->url->get('filter/getyears'); ?>',function(data){ 
			$("#year").select2({
				data: data
			}).select2('val', <?php echo $year; ?>);
			
			$.getJSON('<?php echo $this->url->get('filter/getbranches'); ?>',function(data){
				$("#branch").select2({
					data: data
				}).select2('val', 'all');
				$.getJSON('<?php echo $this->url->get('filter/getlines'); ?>',function(data){
					data.shift();
					$("#line").select2({
						data: data
					}).select2('val', data[0].id);
					refresh();
				});
			});
		});
    });

    function refresh() {
		var object = createObject(false);
        getData<?php echo $report->idReport; ?>(object);
    }
	
	function downloadReport() {
		var object = createObject(true);
		createReport(object);
    }

   function getData<?php echo $report->idReport; ?>(object) {
        $('#<?php echo $report->idReport; ?>').empty();
        $('#<?php echo $report->idReport; ?>').append('<div class="div-center"><img src="<?php echo $this->url->get(''); ?>/images/loading-bar1.GIF" /></div>');

        $.ajax({
            url: '<?php echo $this->url->get(''); ?>' + 'report/getdataforreport/' + <?php echo $report->idReport; ?>,
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
                $('#<?php echo $report->idReport; ?>').children().fadeOut(500, function() {
                    $('#<?php echo $report->idReport; ?>').empty();
						if (data.data.length == 0) {
							$('#<?php echo $report->idReport; ?>').append('<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\n\
																<div class="alert alert-warning">\n\
																	No existen datos con los filtros seleccionados\n\
																</div>\n\
															  </div>');
						}
						else {
							createBasicLine({
								container: '<?php echo $report->idReport; ?>',
								title: '<?php echo $report->name; ?>',
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
        var year = <?php echo $year; ?>;
		var branch = 'all';
		var line = 'all';
		
	<?php if (!isset($index)) { ?>
        year = $('#year').val();
		branch = $('#branch').val();
		line = $('#line').val();
	<?php } ?>
		
		var object = {
            idReport: <?php echo $report->idReport; ?>,
			module: '<?php echo $report->module; ?>',
            year: year,
            branch: branch,
            line: line,
            title: year,
			download: download
        };
		
		return object;
	}
</script>