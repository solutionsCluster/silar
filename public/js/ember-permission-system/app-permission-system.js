App = Ember.Application.create({
    rootElement: '#emberAppContainer'
});

// Adaptador
App.ApplicationAdapter = DS.RESTAdapter.extend();

App.ApplicationAdapter.reopen({
    namespace: url,
    serializer: App.AplicationSerializer
});

//Manejo de errores en la vista
App.set('error-message', '');
 
// Store (class)
App.Store = DS.Store.extend({});

App.Router.map(function() {
    this.resource('resources', function(){
        this.route('new'),
        this.resource('resources.edit', { path: '/edit/:resource_id'}),
        this.resource('resources.delete', { path: '/delete/:resource_id'});
    });
    
    this.resource('roles', function(){
        this.route('new'),
		this.resource('roles.edit', { path: '/edit/:role_id'}),
		this.resource('roles.delete', { path: '/delete/:resource_id'});
    });

    this.resource('actions', function(){
        this.route('new'),
		this.resource('actions.edit', { path: '/edit/:action_id'}),
		this.resource('actions.delete', { path: '/delete/:action_id'});
    });

    this.resource('relationships', function(){
        this.route('new'),
		this.resource('relationships.edit', { path: '/edit/:relationship_id'}),
		this.resource('relationships.delete', { path: '/delete/:relationship_id'});
    });
});

/**
 * Modelos
 */
App.Resource = DS.Model.extend({
    name: DS.attr('string'),    
	actions: DS.hasMany('action', {async: true})
});

App.Role = DS.Model.extend({
    name: DS.attr('string'),     
	Relationships: DS.hasMany('Relationship', {async: true})
});

App.Action = DS.Model.extend({
    name: DS.attr('string'),    
	resource: DS.belongsTo('Resource'),
	Relationships: DS.hasMany('Relationship', {async: true})
});

App.Relationship = DS.Model.extend({
	action: DS.belongsTo('Action'),
	role: DS.belongsTo('Role'),
});

/**
 * Rutas
 */

//************************    Resources   ******************************
App.ResourcesIndexRoute = Ember.Route.extend({
    model: function(){
        return this.store.find('resource');
    }
});

App.ResourcesNewRoute = Ember.Route.extend({
    model: function(){
        return this.store.createRecord('resource');
    },

    deactivate: function () {
        if (this.currentModel.get('isNew') && this.currentModel.get('isSaving') == false) {
                this.currentModel.rollback();
        }
    }
});

App.ResourcesEditRoute = Ember.Route.extend({
    deactivate: function () {
        this.doRollBack();
    },
    contextDidChange: function() {
        this.doRollBack();
        this._super();
    },
    doRollBack: function () {
        var model = this.get('currentModel');
        if (model && model.get('isDirty') && model.get('isSaving') == false) {
                model.get('transaction').rollback();
        }
    }
});

//************************    Roles   ******************************
App.RolesIndexRoute = Ember.Route.extend({
	model: function(){
        return this.store.find('role');
    }
});

App.RolesNewRoute = Ember.Route.extend({
    model: function(){
        return this.store.createRecord('role');
    },

    deactivate: function () {
        if (this.currentModel.get('isNew') && this.currentModel.get('isSaving') == false) {
                this.currentModel.rollback();
        }
    }
});

App.RolesEditRoute = Ember.Route.extend({
    deactivate: function () {
        this.doRollBack();
    },
    contextDidChange: function() {
        this.doRollBack();
        this._super();
    },
    doRollBack: function () {
        var model = this.get('currentModel');
        if (model && model.get('isDirty') && model.get('isSaving') == false) {
                model.get('transaction').rollback();
        }
    }
});

//************************    Actions   ******************************
App.ActionsIndexRoute = Ember.Route.extend({
//	model: function(){
//        return this.store.find('action');
//    }
});

App.ActionsNewRoute = Ember.Route.extend({
    model: function(){
        return this.store.createRecord('action');
    },

    deactivate: function () {
        if (this.currentModel.get('isNew') && this.currentModel.get('isSaving') == false) {
                this.currentModel.rollback();
        }
    }
});

App.ActionsEditRoute = Ember.Route.extend({
    deactivate: function () {
        this.doRollBack();
    },
    contextDidChange: function() {
        this.doRollBack();
        this._super();
    },
    doRollBack: function () {
        var model = this.get('currentModel');
        if (model && model.get('isDirty') && model.get('isSaving') == false) {
                model.get('transaction').rollback();
        }
    }
});

//************************    Relationships   ******************************
App.RelationshipsIndexRoute = Ember.Route.extend({
//	model: function(){
//        return this.store.find('relationship');
//    }
});

App.RelationshipsNewRoute = Ember.Route.extend({
    model: function(){
        return this.store.createRecord('Relationship');
    },

    deactivate: function () {
        if (this.currentModel.get('isNew') && this.currentModel.get('isSaving') == false) {
                this.currentModel.rollback();
        }
    }
});

/**
 * Controladores
 */

//************************* Resources *********************************
App.ResourcesIndexController = Ember.ArrayController.extend({
	actions : {
		newaction: function(resource) {
			App.set('resource', resource);
			cleanAppMessages();
			this.transitionToRoute("actions.new");
		}
	}
});

App.ResourcesNewController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions : {
        save: function(resource) {
            if (resource.get('name') == "" || resource.get('name') == undefined) {
                App.set('error-message', 'El recurso debe tener un nombre');
            }
            else {
				cleanAppMessages();
                this.handleSavePromise(resource.save(), 'resources.index', 'Se ha creado el recurso exitosamente');
            }
        },
				
        cancel: function(){
			cleanAppMessages();
            this.transitionToRoute("resources.index");
        }
    }	
});

App.ResourcesEditController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions: {
        edit: function(resource) {
           if (resource.get('name') == "" || resource.get('name') == undefined) {
                App.set('error-message', 'El recurso debe tener un nombre');
            }
            this.handleSavePromise(resource.save(), 'resources.index', 'Se ha editado el recurso exitosamente exitosamente');
			cleanAppMessages();
        },
        cancel: function() {
			cleanAppMessages();
            this.get('model').rollback();
            this.transitionToRoute('resources.index');
        }
    }
});

App.ResourcesDeleteController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions: {
        delete: function(resource) {
            //borrando registro del store
            resource.deleteRecord();

            //haciendo persistencia en el cambio
            this.handleSavePromise(resource.save(), 'resources.index', 'Se ha eliminado el recurso exitosamente'),
			
            function (error) {
                resource.rollback();
            };
			
			cleanAppMessages();
        },

        cancel: function() {
            this.get("model").rollback();
			cleanAppMessages();
            this.transitionToRoute('resources.index');
        }
    }
});


//************************* Roles *********************************
App.RolesIndexController = Ember.ArrayController.extend({
});

App.RolesNewController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions : {
        save: function(role) {
            if (role.get('name') == "" || role.get('name') == undefined) {
                App.set('error-message', 'El role debe tener un nombre');
            }
            else {
				cleanAppMessages();
                this.handleSavePromise(role.save(), 'roles.index', 'Se ha creado el role exitosamente');
            }
        },

        cancel: function(){
            this.transitionToRoute("roles.index");
        }
    }	
});

App.RolesEditController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions: {
        edit: function(role) {
            if (role.get('name') == "" || role.get('name') == undefined) {
                App.set('error-message', 'El role debe tener un nombre');
            }
			cleanAppMessages();
            this.handleSavePromise(role.save(), 'roles.index', 'Se ha editado el role exitosamente exitosamente');
        },
        cancel: function() {
			cleanAppMessages();
            this.get('model').rollback();
            this.transitionToRoute('roles.index');
        }
    }
});

App.RolesDeleteController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions: {
        delete: function(role) {
            //borrando registro del store
            role.deleteRecord();

            //haciendo persistencia en el cambio
            this.handleSavePromise(role.save(), 'roles.index', 'Se ha eliminado el role exitosamente'),

            function (error) {
                role.rollback();
            };
			cleanAppMessages();
        },

        cancel: function() {
			cleanAppMessages();
            this.get("model").rollback();
            this.transitionToRoute('roles.index');
        }
    }
});

//************************* Actions *********************************
App.ActionsIndexController = Ember.ArrayController.extend({
});

App.ActionsNewController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions : {
        save: function(action) {
            if (action.get('name') == "" || action.get('name') == undefined) {
                App.set('error-message', 'La acción debe tener un nombre');
            }
            else {
				var resource = App.get('resource');
				if (resource !== undefined) {
					action.set('resource', resource);
					cleanAppMessages();
					this.handleSavePromise(action.save(), 'resources.index', 'Se ha creado la acción exitosamente');
				}
            }
        },

        cancel: function(){
			cleanAppMessages();
			this.get("model").rollback();
            this.transitionToRoute("resources.index");
        }
    }	
});

App.ActionsEditController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions: {
        edit: function(action) {
            if (action.get('name') == "" || action.get('name') == undefined) {
                App.set('error-message', 'El role debe tener un nombre');
            }
			else {
				cleanAppMessages();
				this.handleSavePromise(action.save(), 'resources.index', 'Se ha editado la acción exitosamente exitosamente');
			}
        },
        cancel: function() {
			cleanAppMessages();
            this.get('model').rollback();
            this.transitionToRoute('resources.index');
        }
    }
});

App.ActionsDeleteController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions: {
        delete: function(action) {
            //borrando registro del store
            action.deleteRecord();

            //haciendo persistencia en el cambio
            this.handleSavePromise(action.save(), 'resources.index', 'Se ha eliminado el role exitosamente'),

            function (error) {
                action.rollback();
            };
			
			cleanAppMessages();
        },

        cancel: function() {
			cleanAppMessages();
            this.get("model").rollback();
            this.transitionToRoute('resources.index');
        }
    }
});

//************************* Relationships *********************************
App.RelationshipsIndexController = Ember.ArrayController.extend({
});

App.RelationshipsNewController = Ember.ObjectController.extend(Ember.SaveHandlerMixin,{
    actions : {
        save: function(relationship) {
            this.handleSavePromise(relationship.save(), 'resources.index', 'Se ha creado el recurso exitosamente');
        },
				
        cancel: function(){
            this.transitionToRoute("resources.index");
        }
    }	
});



function cleanAppMessages() {
	App.set('error-message', '');
}

//App.Tooltip = Ember.View.extend({
//	templateName : 'resources/index',
//	didInsertElement: function() {
//		$('.tooltip-b3').tooltip({
//
//        });
//	}
//});

//App.TooltipButton = Ember.Button.extend({
//	didInsertElement: function() {
//		$('.tooltip-b3').tooltip({
//
//        });
//	}
//});
