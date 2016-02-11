function createBasicLine(data) {
    $('#'+data.container).highcharts({
        title: {
            text: data.title,
            x: -20 //center
        },
        subtitle: {
            text: data.subtitle,
            x: -20
        },
        xAxis: {
            categories: data.x
        },
        yAxis: {
            title: {
                text: data.y
            }
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: data.data
    });
}

function createBasicLineWithLabels(data) {
    $('#'+data.container).highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: data.title
        },
        subtitle: {
            text: data.subtitle
        },
        xAxis: {
            categories: data.x
        },
        yAxis: {
            title: {
                text: data.y
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Ventas',
            data: data.data
        }]
    });
}

function createPie(data) {
	$('#' + data.container).highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            text: data.title
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: data.subtitle,
            data: data.data
        }]
    });
}

function createSpeedo(data) {
	var quarter1 = (data.max*35)/100;
	var quarter2 = (data.max*75)/100;
	
	$('#'+data.container).highcharts({
		chart: {
			type: 'gauge',
			plotBackgroundColor: null,
			plotBackgroundImage: null,
			plotBorderWidth: 0,
			plotShadow: false
		},

		title: {
			text: data.title
		},

		pane: {
			startAngle: -150,
			endAngle: 150,
			background: [{
				backgroundColor: {
					linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					stops: [
						[0, '#FFF'],
						[1, '#333']
					]
				},
				borderWidth: 0,
				outerRadius: '109%'
			}, {
				backgroundColor: {
					linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					stops: [
						[0, '#333'],
						[1, '#FFF']
					]
				},
				borderWidth: 1,
				outerRadius: '107%'
			}, {
				// default background
			}, {
				backgroundColor: '#DDD',
				borderWidth: 0,
				outerRadius: '105%',
				innerRadius: '103%'
			}]
		},

		// the value axis
		yAxis: {
			min: data.min,
			max: data.max,

			minorTickInterval: 'auto',
			minorTickWidth: 1,
			minorTickLength: 10,
			minorTickPosition: 'inside',
			minorTickColor: '#666',

			tickPixelInterval: 30,
			tickWidth: 2,
			tickPosition: 'inside',
			tickLength: 10,
			tickColor: '#666',
			labels: {
				step: 2,
				rotation: 'auto'
			},
			title: {
				text: data.subtitle
			},
			plotBands: [{
				from: 0,
				to: quarter1,
				color: '#DF5353'
			}, {
				from: quarter1,
				to: quarter2,
				color: '#DDDF0D' // yellow
			}, {
				from: quarter2,
				to: data.max,
				color: '#55BF3B' // red
			}]
		},

		series: [{
			name: data.seriesName,
			data: [data.value],
			tooltip: {
				valueSuffix: data.reference
			}
		}]

	},
		// Add some life
		function (chart) {
			if (!chart.renderer.forExport) {
				setInterval(function () {
					var point = chart.series[0].points[0],
						newVal,
						inc = Math.round((Math.random() - 0.5) * 20);

					newVal = point.y + inc;
					if (newVal < 0 || newVal > 200) {
						newVal = point.y - inc;
					}

					point.update(newVal);

				}, 3000);
			}
		});
}

function createBasicBar(data) {
	$('#' + data.container).highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: data.title
        },
        subtitle: {
            text: data.subtitle
        },
        xAxis: {
            categories: data.x,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: data.y,
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' ' + data.tooltip
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: data.data
    });
}

function createTable(data) {
    var table = $('<div class="table-responsive">\n\
                        <table class="table table-bordered">\n\
                          <thead></thead>\n\
                          <tbody>\n\
                                <tr>\n\
                                  <td><strong>Ventas netas</strong></td>\n\
                                  <td>$'+ data.data.netSales +'</td>\n\
                                </tr>\n\
                                <tr>\n\
                                  <td><strong>Utilidad de las ventas del mes</strong></td>\n\
                                  <td>$'+ data.data.utilv +'</td>\n\
                                </tr>\n\
                                <tr>\n\
                                  <td><strong>% Utilidad de las ventas del mes</strong></td>\n\
                                  <td>$' + data.data.util + '</td>\n\
                                </tr>\n\
                                <tr>\n\
                                  <td><strong>Total CXC</strong></td>\n\
                                  <td>$' + data.data.cxc + '</td>\n\
                                </tr>\n\
                                <tr>\n\
                                  <td><strong>Total CXP</strong></td>\n\
                                  <td>$' + data.data.cxp + '</td>\n\
                                </tr>\n\
                                <tr>\n\
                                  <td><strong>Saldo en caja</strong></td>\n\
                                  <td>$' + data.data.caja + '</td>\n\
                                </tr>\n\
                                <tr>\n\
                                  <td><strong>Saldo en bancos</strong></td>\n\
                                  <td>$' + data.data.banco + '</td>\n\
                                </tr>\n\
                                <tr>\n\
                                  <td><strong>Saldo en inventarios</strong></td>\n\
                                  <td>$' + data.data.saldo + '</td>\n\
                                </tr>\n\
                                <tr>\n\
                                  <td><strong>Gastos</strong></td>\n\
                                  <td>$' + data.data.gastos + '</td>\n\
                                </tr>\n\
                          </tbody>\n\
                        </table>\n\
                  </div>');

    $('#' + data.container).append(table);
}

function pad (str, max) {
	str = str.toString();
	return str.length < max ? pad("0" + str, max) : str;
}
	
function convertObjectInArray(object, round) {
    var array = $.map(object, function(value, index) {
		if (round) {
			return [Math.round(value)];
		}
		
		return [value];
    });
    
    return array;
}

function createReport(object) {
	$("#loading").show('slow');
	$.ajax({
		url: url + 'report/createreport',
		type: "POST",
		data: {object: object},
		error: function(data) {
			$("#loading").hide('slow');
			$.gritter.add({class_name: 'gritter-error', title: '<i class="glyphicon glyphicon-exclamation-sign"></i> Error', text: data.responseJSON.message, sticky: false, time: 6000});
		},
		success: function(data) {
			$("#loading").hide('slow');
			window.location = url + 'report/downloadreport/' + data.message;
		}
	});
}