function Initializer() {
	
}

Initializer.prototype.initialize = function() {
    // there's the plans container and the plans account container
	var $out = $("#out");
	var $in = $("#in");

	// let the plans container items be draggable
	$("li", $out).draggable({
		cancel: "a.ui-icon", // clicking an icon won't initiate dragging
		revert: "invalid", // when not dropped, the item will revert back to its initial position
		containment: "document",
		helper: "clone",
		cursor: "move"
	});

	// let the plans container items be draggable
	$("li", $in).draggable({
		cancel: "a.ui-icon", // clicking an icon won't initiate dragging
		revert: "invalid", // when not dropped, the item will revert back to its initial position
		containment: "document",
		helper: "clone",
		cursor: "move"
	});
	
	$('.start').datetimepicker({
		format: 'DD/MM/YYYY HH:MM',
		minDate: today
	});

	$('.end').datetimepicker({
		format: 'DD/MM/YYYY HH:MM',
		minDate: today
	});

	$('.start').on("dp.change",function (e) {
		//$('.end').data("DateTimePicker").minDate(e.date);
	});
	
	$('.select2').select2({});
};
	
function convertObjectInArray(object, round) {
    var array = $.map(object, function(value, index) {
		if (round) {
			return [Math.round(value)];
		}
		
		return [value];
    });
    
    return array;
}