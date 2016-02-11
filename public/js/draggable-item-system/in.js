function In() {
    this.in = [];
	this.container = "";
	this.manager;
}

In.prototype.setManager = function(manager) {
    this.manager = manager;
};

In.prototype.setData = function(data) {
    this.in = data;
};

In.prototype.setContainer = function(container) {
    this.container = container;
};

In.prototype.initialize = function() {
	var content = $('<ul class="in ui-helper-reset"></ul>');
	this.container.find('#in').append(content);
	var self = this;
	for (var i = 0; i < this.in.length; i++) {
		this.recreateItem(this.in[i]);
	}	
	
	$('#in').droppable({
		accept: ".out > li",
		activeClass: "ui-state-highlight",
		drop: function(event, ui) {
			 self.manager.addElement(ui.draggable);
		}
	});
};

In.prototype.recreateItem = function(data) {
	var self = this;
	var status;
	
	if (data.status === 'active') {
		status = 'label-success';
	}
	else if (data.status === 'inactive'){
		status = 'label-default';
	}
	else if (data.status === 'canceled'){
		status = 'label-danger';
	}

	var item = $('<li class="ui-draggable ui-draggable-handle">\n\
					<input type="hidden" id="id-paymentplan" value="' + data.id + '" />\n\
					<input type="hidden" id="name-paymentplan" value="' + data.name + '" />\n\
					<input type="hidden" id="status-paymentplan" value="' + data.status + '" />\n\
					<span id="span" class="label ' + status +' big">\n\
						<span class="bold-text">' + data.name + '</span> \n\
						<span id="startDate">' + data.start + '</span> \n\
						<span id="endDate">' + data.end + '</span>\n\
						<span class="remove-item">\n\
							<i class="glyphicon glyphicon-minus-sign" style="padding-right: 5px;"></i>\n\
						</span>\n\
						<span class="set-time">\n\
							<i class="glyphicon glyphicon-time" style="padding-right: 8px;"></i>\n\
						</span>\n\
					</span>\n\
				  </li>');

	item.find('.set-time').unbind('click');
	item.find('.set-time').on('click', function (e) {
		self.manager.openModal(item);
	});

	item.find('.remove-item').unbind('click');
	item.find('.remove-item').on('click', function (e) {
		self.manager.quitPayment(item);;
	});

	this.container.find('#in ul').append(item);
};
