function DraggableItemSystem() {
    this.in = [];
    this.out = [];
    this.serializerObject = [];
    this.container = '';
    this.base = '';
}

DraggableItemSystem.prototype.setContainer = function(container) {
    this.container = $('#' + container);
    this.base = $('<div class="row">\n\
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">\n\
						<h4 class="text-center" style="color: #6E6E6E;">Planes inscritos en la cuenta actualmente</h4>\n\
                        <div class="block block-bordered-blue">\n\
							<div id="in" class="in ui-widget-content ui-state-default"></div>\n\
						</div>\n\
                    </div>\n\
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">\n\
						<h4 class="text-center" style="color: #6E6E6E;">Planes que no estan inscritos en la cuenta</h4>\n\
                        <div class="block block-bordered-blue">\n\
							<ul id="out" class="out out-container ui-helper-reset ui-helper-clearfix"></ul>\n\
						</div>\n\
                    </div>\n\
					<div id="payment-config" class="modal fade">\n\
						<div class="modal-dialog">\n\
							<div class="modal-content">\n\
								<div class="modal-header">\n\
									 <button style="display: none;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n\
									<h3 class="modal-title">Configurar plan de pago <span id="payment-title"></span></h3>\n\
								</div>\n\
								<div class="modal-body">\n\
									<p style="text-align: justify; font-size: 1em;">\n\
										Debe configurar la vigencia del plan de pago que desea añadir a la cuenta,\n\
										agregando <strong>fecha de iniciación y fecha de finalización</strong>. Esto quiere decir que en estas fechas\n\
										el plan de pago y sus respectivos reportes <strong>estarán disponibles para dicha cuenta</strong>, siempre y cuando\n\
										este activo. (El plan de pago y sus reportes puede estar inactivo por falta de pago de dicha cuenta, esto\n\
										quiere decir que la cuenta no podrá visualizar dichos reportes).\n\
									</p>\n\
									<div class="big-space"></div>\n\
									<div class="form-horizontal">\n\
										<input type="hidden" name="id-payment" id="id-payment" >\n\
										<div class="form-group">\n\
											<label for="start" class="col-sm-3 control-label">Fecha de inicio</label>\n\
											<div class="col-sm-9">\n\
												<div class="input-group date start">\n\
													<input type="text" class="form-control" name="start" id="start" placeholder="Fecha de inicio">\n\
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>\n\
												</div>\n\
											</div>\n\
										</div>\n\
										<div class="form-group">\n\
											<label for="end" class="col-sm-3 control-label">Fecha de fin</label>\n\
											<div class="col-sm-9">\n\
												<div class="input-group date end">\n\
													<input type="text" class="form-control" name="end" id="end" placeholder="Fecha de fin">\n\
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>\n\
												</div>\n\
											</div>\n\
										</div>\n\
										<div class="form-group">\n\
											<label for="status" class="col-sm-3 control-label">Estado</label>\n\
											<div class="col-sm-9">\n\
												<select id="status-payment" name="status-payment" class="select2">\n\
													<option value="active">Activo</option>\n\
													<option value="inactive">Inactivo</option>\n\
													<option value="canceled">Cancelado</option>\n\
												</select>\n\
											</div>\n\
										</div>\n\
									</div>\n\
								</div>\n\
								<div class="modal-footer">\n\
									<button style="display: none;" class="btn btn-default" id="cancel" data-dismiss="modal">Cancelar</button>\n\
									<button class="btn btn-primary" id="add-payment" >Agregar</button>\n\
								</div>\n\
							</div>\n\
						</div>\n\
					</div>\n\
                  </div>');
};

DraggableItemSystem.prototype.initialize = function() {
	this.container.append(this.base);
	
	var self = this;
    return $.Deferred(function(dfd){
		var bridge = new Bridge();
		bridge.setUrl(url + 'account/getpaymentsplan/' + idAccount);
		bridge.search().then(function() {
			var data = bridge.getData();
			self.in = convertObjectInArray(data, false);
			
			return $.Deferred(function(dfd){
				bridge.setUrl(url + 'paymentplan/getpaymentsplan');
				bridge.search().then(function() {
					var data = bridge.getData();
					self.out = convertObjectInArray(data, false);
					
					self.selectData();
					self.fillContainers();
					dfd.resolve();
				});
			});

			dfd.resolve();
		});
	});
};

DraggableItemSystem.prototype.fillContainers = function() {
	var ins = new In();
	ins.setManager(this);
	ins.setContainer(this.base);
	ins.setData(this.in);
	ins.initialize();
	
	var outs = new Out();
	outs.setManager(this);
	outs.setContainer(this.base);
	outs.setData(this.out);
	outs.initialize();
	
	var initializer = new Initializer();
	initializer.initialize();
};

DraggableItemSystem.prototype.selectData = function() {
    for (var i = 0; i < this.out.length; i++) {
		for (var j = 0; j < this.in.length; j++) {
			if (this.out[i].id == this.in[j].id) {
				this.out.splice(i, 1);
			}
		}
	}
};


DraggableItemSystem.prototype.openModal = function(item) {
	var self = this;
	var id = item.find('#id-paymentplan').val();
	var name = item.find('#name-paymentplan').val();
	var status = item.find('#status-paymentplan').val();
	var start = item.find('#startDate').text();
	var end = item.find('#endDate').text();

	this.base.find('#id-payment').val(id);
	this.base.find('#payment-title').empty();
	this.base.find('#payment-title').append(name);
	this.base.find('#start').val(start);
	this.base.find('#end').val(end);
	this.base.find('#status-payment').select2('val', status);
	
	
	this.base.find('#add-payment').unbind('click');
	
	this.base.find('#add-payment').on('click', function (e) {
		self.sendData(item);
	});
	
	this.base.find('#cancel').hide('slow');
	this.base.find('.close').show('slow');
	
	$('#payment-config').modal({});
};

DraggableItemSystem.prototype.openOutModal = function(item) {
	var self = this;
	var id = item.find('#id-paymentplan').val();
	var name = item.find('#name-paymentplan').val();

	this.base.find('#id-payment').val(id);
	this.base.find('#payment-title').empty();
	this.base.find('#payment-title').append(name);
	this.base.find('#start').val('');
	this.base.find('#end').val('');

	this.base.find('#add-payment').unbind('click');
	
	this.base.find('#add-payment').on('click', function (e) {
		self.sendData(item, true);
	});

	this.base.find('#cancel').show('slow');
	
	this.base.find('#cancel').unbind('click');
	
	this.base.find('#cancel').on('click', function (e) {
		self.quitElement(item);
	});

	this.base.find('.close').hide('slow');
	
	$('#payment-config').modal({});
};

DraggableItemSystem.prototype.quitPayment = function(item) {
	var self = this;
	var id = item.find('#id-paymentplan').val();

	var object = {
		id: id
	};

	$.ajax({
		url: url + 'account/quitpaymentplan/' + idAccount,
		type: "POST",			
		data: {object: object},
		error: function(msg){
			var notification = new NotificationFx({
				wrapper : document.body,
				message : '<p>' + msg.responseJSON.message + '</p>',
				layout : 'growl',
				effect : 'slide',
				ttl : 15000,
				type : 'error'
			});
			// show the notification
			notification.show();
		},
		success: function(msg){
			self.quitElement(item);
		}
	});
};

DraggableItemSystem.prototype.quitElement = function(item) {
	var $out = $("#out");
	var self = this;
	item.fadeOut(function() {
		item.appendTo($out).fadeIn();
		item.find('.set-time').hide();
		item.find('.remove-item').hide();
		item.find('#startDate').empty();
		item.find('#endDate').empty();
		item.find('#status-paymentplan').val('');
		self.changeLabel(item, 'label-primary');
	});
};

DraggableItemSystem.prototype.addElement = function(item) {
	var $in = $("#in");
	var self = this;
	
	item.fadeOut(function() {
		var $list = $("ul", $in).length ? $("ul", $in) : $("<ul class='in ui-helper-reset'/>").appendTo($in);
		item.append().appendTo($list).fadeIn(function() {
			//$item.animate({ width: "48px" });
		});

		item.find('.set-time').show('slow');
		item.find('.remove-item').show('slow');
		self.openOutModal(item);
	});
};

DraggableItemSystem.prototype.getData = function() {
	var id = this.base.find('#id-payment').val();
	var start = this.base.find('#start').val();
	var end = this.base.find('#end').val();
	var status = this.base.find('#status-payment').val();
	
	var object = {
		id: id,
		start: start,
		end: end,
		status: status
	};
	
	return object;
};

DraggableItemSystem.prototype.sendData = function(item, out) {
	var self = this;
	var data = this.getData();
	$.ajax({
		url: url + 'account/setpaymentplan/' + idAccount,
		type: "POST",			
		data: {object: data},
		error: function(msg){
			$('#payment-config').modal('hide');
			if (out) {
				self.quitElement(item);
			}
			var notification = new NotificationFx({
				wrapper : document.body,
				message : '<p>' + msg.responseJSON.message + '</p>',
				layout : 'growl',
				effect : 'slide',
				ttl : 15000,
				type : 'error'
			});
			// show the notification
			notification.show();
		},
		success: function(msg){
			$('#payment-config').modal('hide');
			item.find('#startDate').empty();
			item.find('#endDate').empty();
			item.find('#startDate').append(data.start);
			item.find('#endDate').append(data.end);
			item.find('#status-paymentplan').val(data.status);
			var label = self.getLabel(data.status);
			self.changeLabel(item, label);
		}
	});
};
	
DraggableItemSystem.prototype.changeLabel = function(item, label) {
	item.find('#span').removeClass('label-success');
	item.find('#span').removeClass('label-default');
	item.find('#span').removeClass('label-danger');
	item.find('#span').removeClass('label-primary');
	item.find('#span').addClass(label);
};	
	
DraggableItemSystem.prototype.getLabel = function(status) {
	var label = 'label-default';
	switch (status) {
		case 'active':
			label = 'label-success';
			break;
			
		case 'inactive':
			label = 'label-default';
			break;
			
		case 'canceled':
			label = 'label-danger';
			break;
	}
	
	return label;
};