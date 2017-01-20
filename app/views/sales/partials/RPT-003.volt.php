<?php if (!isset($index)) { ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
        <input type="text" id="year" class="select2" />
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-right" style="padding-top: 8px">
        <input type="text" id="month" class="select2" />
    </div>
    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1" style="padding-top: 8px">
        <input type="text" id="days" class="select2" />
    </div> 
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"></div>


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

<script type="text/javascript">
	<?php $year = date('Y'); ?>
	<?php $month = date('m'); ?>
	<?php $day = date('d'); ?>
		
	<?php if (!isset($index)) { ?>
		$(function() {
			$.getJSON('<?php echo $this->url->get('filter/getyears'); ?>', function(data) {
				$("#year").select2({
					data: data
				}).select2('val', <?php echo $year; ?>);
				
				$.getJSON('<?php echo $this->url->get('filter/getmonths'); ?>', function(data) {
					$("#month").select2({
						data: data
					}).select2('val', <?php echo $month; ?>);
					refresh();	
					
					$.getJSON('<?php echo $this->url->get('filter/getdays'); ?>', function(data) {
						$("#days").select2({
							data: data
						}).select2('val', <?php echo $day; ?>);
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
	
	function getData<?php echo $report->idReport; ?>(object) {
		$('#<?php echo $report->idReport; ?>').empty();
		$('#<?php echo $report->idReport; ?>').append('<div class="div-center"><img src="<?php echo $this->url->get(''); ?>/images/loading-bar1.GIF" /></div>');

		$.ajax({
			url: '<?php echo $this->url->get(''); ?>' + 'report/getdataforreport/' + <?php echo $report->idReport; ?>,
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
				$('#<?php echo $report->idReport; ?>').children().fadeOut(500, function() {
					$('#<?php echo $report->idReport; ?>').empty();
					createTable1({
						data: data.data,
						container: '<?php echo $report->idReport; ?>'
					});
				});
			}
		});
	}
	
	function createObject() {
		var m = <?php echo $month; ?>;
		var day = <?php echo $day; ?>;
		var month = pad(m, 2);
		var year = <?php echo $year; ?>;
		
	<?php if (!isset($index)) { ?>
		m = $('#month').val();
		day = $('#day').val();
		month = pad(m, 2);
		year = $('#year').val();
	<?php } ?>
		
		var title = day + '/' +  month + '/' + year;
		var object = {
			idReport: <?php echo $report->idReport; ?>,
			module: '<?php echo $report->module; ?>',
			year: year,
			month: month,
			day: day,
			title: title
		};
		
		return object;
	}
</script>
