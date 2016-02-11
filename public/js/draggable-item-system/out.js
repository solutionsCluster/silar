function Out() {
    this.out = [];
	this.container = "";
	this.manager;
}

Out.prototype.setManager = function(manager) {
    this.manager = manager;
};

Out.prototype.setData = function(data) {
    this.out = data;
};

Out.prototype.setContainer = function(container) {
    this.container = container;
};

Out.prototype.initialize = function() {
	for (var i = 0; i < this.out.length; i++) {
		this.recreateItem(this.out[i]);
	}
};

Out.prototype.recreateItem = function(data) {
	var self = this;
	
	var item = $('<li>\n\
					<input type="hidden" id="id-paymentplan" value="' + data.id + '" />\n\
					<input type="hidden" id="name-paymentplan" value="' + data.name + '" />\n\
					<input type="hidden" id="status-paymentplan" value="" />\n\
					<span id="span" class="label label-primary big"> \n\
						<span class="bold-text">' + data.name + '</span> \n\
						<span id="startDate"></span> \n\
						<span id="endDate"></span>\n\
						<span class="remove-item" style="display: none;">\n\
							<i class="glyphicon glyphicon-minus-sign" style="padding-right: 5px;"></i>\n\
						</span>\n\
						<span class="set-time" style="display: none;">\n\
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
		self.manager.quitPayment(item);
	});

	this.container.find('#out').append(item);
};