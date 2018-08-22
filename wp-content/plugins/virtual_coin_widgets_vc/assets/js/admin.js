'use strict';

(function ($, VCW) {

    var builder = {
        hide_selector: '.symbol-row,.symbol1-row,.symbol2-row,.symbols-row,.currency-row,.currency1-row,.currency2-row,.currency3-row,.url-row,.target-row,.initial-row,.count-row',

        all_fields: ['shortcode', 'color', 'fullwidth', 'symbol', 'symbol1', 'symbol2', 'symbols', 'currency', 'currency1', 'currency2', 'currency3', 'url', 'target', 'initial', 'count'],

        fields: {
            'price-label': ['symbol', 'currency', 'url', 'target'],
            'change-label': ['symbol', 'url', 'target'],
            'price-big-label': ['symbol', 'currency1', 'currency2', 'currency3', 'url', 'target'],
            'change-big-label': ['symbol', 'url', 'target'],
            'price-card': ['symbol', 'currency1', 'currency2', 'currency3', 'url', 'target'],
            'change-card': ['symbol', 'url', 'target'],
            'full-card': ['symbol', 'currency1', 'currency2', 'currency3', 'url', 'target'],
            'converter': ['symbol1', 'symbol2', 'initial'],
            'table': ['currency', 'symbols', 'count'],
            'small-table': ['currency', 'symbols', 'count']
        },
        elements: null,

        attach: function attach(form, preview, code) {
            form.submit(false);

            var elements = builder.elements = {
                form: form,
                submit: form.find('.render-submit'),
                shortcode: form.find('[name=shortcode]'),
                preview: preview,
                code: code
            };

            elements.shortcode.on('change keyup paste', function () {
                return builder.refresh();
            });
            elements.submit.click(function () {
                return builder.render();
            });
        },
        hideFields: function hideFields() {
            builder.elements.form.find(this.hide_selector).hide();
        },
        showFields: function showFields() {
            var widget = builder.elements.shortcode.val(),
                fields = builder.fields[widget];

            var selector = fields.map(function (field, i) {
                return '.' + field + '-row';
            }).join(',');

            builder.elements.form.find(selector).show();
        },
        refresh: function refresh() {
            builder.hideFields();
            builder.showFields();
        },
        callRender: function callRender(cb) {
            var elements = builder.elements,
                req = {
                type: 'POST',
                url: VCW.ajax_url,
                data: {
                    action: 'vcw_render'
                }
            };

            builder.all_fields.forEach(function (field) {
                req.data[field] = elements.form.find('[name=' + field + ']').val();
            });

            $.ajax(req).done(function (response) {
                if (response && response.html && response.code) {
                    cb(response.html, response.code);
                }
            });
        },
        render: function render() {
            var element = builder.elements;

            builder.callRender(function (html, code) {
                element.preview.html(html);
                element.code.find('textarea').val(code);
                VCW.compile();
            });
        }
    };

    $(function () {
        if ($('#vcw-admin-page').length) {
            builder.attach($('#vcw-admin-builder'), $('#vcw-admin-preview'), $('#vcw-admin-code'));
            builder.refresh();
        }
    });
})(jQuery, VirtualCoinWidgets);
