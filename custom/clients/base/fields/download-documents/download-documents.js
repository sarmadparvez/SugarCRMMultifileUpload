/**
 * @class View.Fields.Base.DownloadDocumentsField
 * @alias SUGAR.App.view.fields.BaseDownloadDocumentsField
 * @extends View.Fields.Base.RowactionField
 */

({
    extendsFrom: 'RowactionField',

    /**
     * @inheritdoc
     */
    initialize: function (options)
    {
        this._super('initialize', [options]);
        this.type = 'rowaction';
    },


    /**
     * Function: rowActionSelect
     *
     * Click handler for the transfer_dealer_contacts action.
     *
     */
    rowActionSelect: function ()
    {
        this.downloadFiles();
    },

    /**
     * Function: downloadFiles
     *
     * @params model of selected record
     * call api to download selected files as zip
     */
    downloadFiles: function ()
    {
        var mass_collection = this.context.get('mass_collection'),
            parent_model = this.context.parent.get('model'),
            zip_name = !_.isEmpty(parent_model.get('name')) ? parent_model.get('name') : 'documents';

        if (mass_collection.models.length <1) {
            return;
        }
        var document_ids = _.pluck(this.context.get('mass_collection').models, 'id'),
            url = app.api.buildURL('storeRecordIds'),
            params = {
                record_ids : document_ids
            };
        app.alert.show('document_download_process', {
            level: 'process',
            title: app.lang.get('LBL_LOADING'),
            autoclose: false,
        });
        app.api.call('create', url, params, {
            success: _.bind(function (response) {
                app.alert.dismiss('document_download_process');
                if (response.id) {
                    var url = app.api.buildURL(
                        'downloadDocuments?platform=base&temp_id='+response.id+'&zip_name='+encodeURI(zip_name)
                    );
                    app.api.fileDownload(url, {
                        error: function(data) {
                            // refresh token if it has expired
                            app.error.handleHttpError(data, {});
                        }
                    });
                }
            }, this),
            error: _.bind(function (error) {
                app.alert.dismiss('document_download_process');
                app.alert.show('error',
                        {
                            level: 'error',
                            messages: error.message,
                            autoClose: false
                        });
            }, this),
        });
    },
})
