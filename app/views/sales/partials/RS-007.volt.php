<?php if (!isset($index)) { ?>
    <div class="row">
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="padding-top: 8px">
			<input type="text" id="branch" class="select2" />
		</div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-left" style="padding-top: 8px"></div>
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
<?php } ?>
	
<?php if (!isset($index)) { ?>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
			<div style="display: inline; margin-right: 10px;"><img src="<?php echo $this->url->get(''); ?>images/spinner.GIF" height="35" width="35" id="loading" style="display: none;"/></div>
			<button class="btn btn-sm btn-primary" onClick="downloadReport();">
				<i class="glyphicon glyphicon-download-alt"></i> Descargar reporte
			</button>
		</div>
	</div>
	<div class="big-space"></div>
<?php } ?>
		
	<div class="row" id="<?php echo $report->idReport; ?>"></div>

<?php if (!isset($index)) { ?>
	<div class="big-space"></div>
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
<script src="<?php echo $this->url->get(''); ?>vendors/highcharts-4.0.4/js/highcharts-more.js"></script>
<script type="text/javascript">
    $(function () {
        <?php $year = date('Y'); ?>
		<?php $month = date('m'); ?>
		$("#filter").select2({});
		$.getJSON('<?php echo $this->url->get('filter/getyears'); ?>', function(data) {
			$("#year").select2({
				data: data
			}).select2('val', <?php echo $year; ?>);
			
			$.getJSON('<?php echo $this->url->get('filter/getmonths'); ?>', function(data) {
				$("#month").select2({
					data: data
				}).select2('val', <?php echo $month; ?>);
				
				$.getJSON('<?php echo $this->url->get('filter/getbranches'); ?>', function(data) {
					$("#branch").select2({
						data: data
					}).select2('val', 'all');
					refresh();
				});
			});
		});
    });
    
    function refresh() {
        var obj = createObject(false);
        getData<?php echo $report->idReport; ?>(obj);
    }
   
	function downloadReport() {
		var obj = createObject(true);
		createReport(obj);
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
                        var array = convertObjectInArray(data.data, false);
						
						if (array.length == 0) {
							$('#<?php echo $report->idReport; ?>').append('<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\n\
																<div class="alert alert-warning">\n\
																	No existen datos con los filtros seleccionados\n\
																</div>\n\
															  </div>');
						}
						else {
							for (var i = 0; i < array.length; i++) {
								$('#<?php echo $report->idReport; ?>').append('<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">\n\
																	<div class="panel panel-default">\n\
																		<div class="panel-body">\n\
																			<div id="speedo' + array[i].idSalesman + '" style="min-width: 230px; height: 280px; margin: 0 auto"></div>\n\
																		</div>\n\
																	</div>\n\
																  </div>');
								var value = Math.round(array[i].sales);
								var min = Math.round(array[i].min);
								createSpeedo({
									container: 'speedo' + array[i].idSalesman,
									title: array[i].name,
									min: 0,
									max: array[i].min,
									reference: ' Pesos colombianos($)',
									subtitle: min,
									value: value,
									seriesName: 'Ventas'
								});
							}
						}
                });
            }
        });
    }
	
	function createObject(variable) {
		var download = (variable ? 'true' : 'false');
		var m = <?php echo $month; ?>;
        var year = <?php echo $year; ?>;
        var branch = 'all';
        var month = pad(m, 2);
		
	<?php if (!isset($index)) { ?>
		m = $('#month').val();
        year = $('#year').val();
        branch = $('#branch').val();
        month = pad(m, 2);
	<?php } ?>
		
		var obj = {
			idReport: <?php echo $report->idReport; ?>,
			module: '<?php echo $report->module; ?>',
			year: year,
			month: month,
			branch: branch,
			title: month + '/' + year,
			download: download
		};
		
		return obj;
	}
</script>