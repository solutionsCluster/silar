<?php if (!isset($index)) { ?>
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
<?php } ?>
<div class="big-space"></div>

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
    $(function () {
		<?php $year = date('Y'); ?>
		$("#filter").select2({});
		$.getJSON('<?php echo $this->url->get('filter/getyears'); ?>', function(data) {
			$("#year2").select2({
				data: data
			}).select2('val', <?php echo $year; ?>);
			
			var year2 = <?php echo $year; ?> - 1;
			$("#year1").select2({
				data: data
			}).select2('val', year2);
			
			$.getJSON('<?php echo $this->url->get('filter/getbranches'); ?>', function(data) {
				$("#branch").select2({
					data: data
				}).select2('val', 'all');
				refresh();
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
                        var year1 = convertObjectInArray(data.data[object.year1]);
                        var year2 = convertObjectInArray(data.data[object.year2]);
						
						createBasicLine({
                            container: '<?php echo $report->idReport; ?>',
                            title: '<?php echo $report->name; ?>',
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
	
	function createObject(variable) {
		var download = (variable ? 'true' : 'false');
		var year1 = <?php echo $year; ?> - 1;
		var year2 = <?php echo $year; ?>;
		var branch = "all";
        var filter = 'daily';
	<?php $year = date('Y'); ?>
	<?php if (!isset($index)) { ?>
		year1 = $('#year1').val();
		year2 = $('#year2').val();
		branch = $('#branch').val();
        filter = $('#filter').val();
	<?php } ?>
		filter = (variable ? 'accumulated' : filter);
		var obj = {
			idReport: <?php echo $report->idReport; ?>,
			module: '<?php echo $report->module; ?>',
			year1: year1,
			year2: year2,
			branch: branch,
			title: year1 + ' y ' + year2,
			filter: filter,
			download: download
		};
		
		return obj;
	}
</script>