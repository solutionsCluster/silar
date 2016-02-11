function Bridge() {
    this.url = '';
    this.data = null;
}

Bridge.prototype.setUrl = function(url) {
    this.url = url;
};

Bridge.prototype.search = function() {
    var self = this;
    
    return $.Deferred(function(dfd){
        $.ajax({
            url: self.url,
            type: "GET",
            error: function(error){
                console.log('Error: ');
                console.log(error);
            },
            success: function(data){
                self.data = data;
                dfd.resolve();
            }
        });
    });   
};

Bridge.prototype.getData = function() {
    return this.data;
};

