/**
 * @class View.Fields.Base.MultifileUpload
 * @alias SUGAR.App.view.fields.BaseMultifileUpload
 * @extends View.Fields.Base.BaseField
 * Field for uploading multiple files. Files are saved as indvidual document records
 */
({
	extendsFrom: 'FileField',

	
    /**
     * Called when initializing the field
     * @param options
     */
    initialize: function(options) {
        this._super('initialize', [options]);
    },

    /**
     * Called when rendering the field
     * @private
     */
    _render: function() {

        this._super('_render');
        if (
        	!_.isUndefined(this.$el.parent()) &&
        	!_.isUndefined(this.$el.parent().parent()) &&
        	this.$el.parent().parent().attr('data-name') == 'multifile_upload' &&
        	this.view.name != 'record') {
        	this.$el.parent().parent().remove();
        	this.dispose();
        } else {
        	$('#upload-status-list').html('');
	    	this.attachFileUploadPlugin();
	    }
    },

    /**
    * Override to prevent showing nodata template, we always need to show 'detail' template
    */
    showNoData: function()
    {
    	return false;
    },

    attachFileUploadPlugin: function()
    {
    	var url = app.api.buildURL('Documents', 'new_record/file/filename'),
    		self = this;
	    $('#fileupload').fileupload({
	        dataType: 'json',
			sequentialUploads: true,
			replaceFileInput:false,
			paramName: 'filename',
			beforeSend: function(xhr, data) {
        		xhr.setRequestHeader('OAuth-Token', app.api.getOAuthToken());
        		self.upload_complete = false;
    		},
			add: function (e, data) {
				if (!_.isUndefined(data.files) && !_.isUndefined(data.files[0])) {
					filename = data.files[0].name;
				}
	            data.context = $('<p/>').text(filename + ' uploading...').appendTo('#upload-status-list');
	            data.url = url;
	            data.formData = {
	            	parent_id : self.model.get('id'),
	            	parent_module : self.model.get('_module')
	            };
	            data.submit();
	        },
	        done: function (e, data) {
				// reload documents subpanel if all file are uploaded
				if (self.upload_complete) {
					self.reloadSubpanelData(self.getDocumentsSubpanel());
				}
				if (!_.isUndefined(data.files) && !_.isUndefined(data.files[0])) {
					filename = data.files[0].name;
				}
				data.context.text(filename +' uploading finished');
	        },
			fail: function (e, data) {
				var filename = '';
				if (!_.isUndefined(data.files) && !_.isUndefined(data.files[0])) {
					filename = data.files[0].name;
				}
				if (data.jqXHR.responseText) {
					var error = JSON.parse(data.jqXHR.responseText);
					if (!_.isUndefined(error.error_message)) {
						data.context.text(filename + ' failed to upload. ' + error.error_message);
					}
				} else {
					data.context.text(filename + ' failed to upload. ' + data.jqXHR.statusText);
				}
			},
		    progressall: function (e, data) {
		        var progress = parseInt(data.loaded / data.total * 100, 10);
		        $('#progress .upload-bar').css(
		            'width',
		            progress + '%'
		        );
		        if (progress >= 100) {
		        	self.upload_complete = true;
		        }
		    }
	    });
    },

    /**
    * Reload passed subpanel
    */
    reloadSubpanelData: function(reloadSubpanel)
    {
        if (!_.isUndefined(reloadSubpanel) && !_.isEmpty(reloadSubpanel)) {
            reloadSubpanel.get('collection').resetPagination();
            reloadSubpanel.set('collapsed', false);
            reloadSubpanel.get('collection').fetch({relate:true});
        }

    },

    /**
    * Get Documents subpanel object
    */
    getDocumentsSubpanel: function()
    {
    	if (_.isEmpty(this.context)) {
    		return false;
    	}
    	var metadata = App.metadata.getModule(this.module)
		var docs_subpanel = _.find(this.context.children, function(child) {
            if (child.get('isSubpanel') && !child.get('hidden')) {
                var link = child.get('link');
           		if (!_.isEmpty(link) && !_.isEmpty(metadata.fields[link]) &&
                    (metadata.fields[link]['module'] == 'Documents' || 
                    metadata.fields[link]['name'] == 'documents') 
                    ) {
					return true;
            	}
			}

        });
        return docs_subpanel;
    }
})
