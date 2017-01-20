<?php if (!isset($index)) { ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="padding-top: 8px">
        <input type="text" id="branch" class="select2" />
    </div>
    
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="padding-top: 8px">
		<select id="cant" name="cant" class="select2">
			<option value="10" selected>10 Productos más vendidos</option>
			<option value="20">20 Productos más vendidos</option>
			<option value="50">50 Productos más vendidos</option>
			<option value="200">200 Productos más vendidos</option>
			<option value="500">500 Productos más vendidos</option>
			<option value="1000">1000 Productos más vendidos</option>
		</select> 
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

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="<?php echo $report->idReport; ?>" style="height:100%;
    width:100%;
    position:relative; margin: 0 auto"></div>
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
	<?php $year = date('Y'); ?>
	<?php $month = date('m'); ?>
		
	<?php if (!isset($index)) { ?>
		$(function() {
			$('#filter').select2();
			$('#cant').select2();
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
	<?php } else { ?>
		refresh();
	<?php } ?>
		
	function refresh() {
		var object = createObject();
		getData<?php echo $report->idReport; ?>(object);
	}
	
	function downloadReport() {
		var obj = createObject();
		createReport(obj);
	}
	
	function getData<?php echo $report->idReport; ?>(object) {
        $('#<?php echo $report->idReport; ?>').empty();
        $('#<?php echo $report->idReport; ?>').append('<div class="div-center"><img src="<?php echo $this->url->get(''); ?>/images/loading-bar1.GIF" /></div>');

        $.ajax({
            url: '<?php echo $this->url->get(''); ?>' + 'report/getdataforreport',
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
					var title = <?php if (!isset($index)) { ?>'<?php echo $report->name; ?>'<?php } else { ?>''<?php } ?>;
					var cant = convertObjectInArray(data.data.cant);
					var products = convertObjectInArray(data.data.products);
					if (cant.length == 0 || products.length == 0) {
						$('#<?php echo $report->idReport; ?>').append('<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">\n\
															<div class="alert alert-warning">\n\
																No existen datos con los filtros seleccionados\n\
															</div>\n\
														  </div>');
					}
					else {
						createBasicBar({
							container: <?php echo $report->idReport; ?>,
							title: title,
							subtitle: object.title,
							x: products,
							y: ' Unidades',
							tooltip: 'Unidades',
							data: [{
								name: 'Cantidad',
								data: cant
							}]
						});
					}
                });
            }
        });
    }
	
	function createObject() {
		var filter = $('#filter').val();
		var m = <?php echo $month; ?>;
		var branch = 'all';
		var cant = 10;
		var month = pad(m, 2);
		var year = <?php echo $year; ?>;
	<?php if (!isset($index)) { ?>
		m = $('#month').val();
		branch = $('#branch').val();
		cant = $('#cant').val();;
		month = pad(m, 2);
		year = $('#year').val();
	<?php } ?>
	
		var object = {
			idReport: <?php echo $report->idReport; ?>,
			filter: filter,
			cant: cant,
			module: '<?php echo $report->module; ?>',
			year: year,
			month: month,
			branch: branch,
			title: month + '/' + year
		};
		
		var height = (cant == 10 || cant == 20 ? cant*40: cant*20);
		adjustChartContainer({container: '<?php echo $report->idReport; ?>', height: height});
		
		return object;
	}	
</script>