'use strict';

(function ($, VCW, fx) {

    function logger(txt) {
        console.error('[VCW] ' + txt);
    }

    /* Check Data */

    if (!VCW || !VCW.rates || !VCW.cryptocurrencies) {
        return logger('Global data is corrupted');
    }

    var RATES = {};

    Object.keys(VCW.rates).forEach(function (code) {
        RATES[code] = VCW.rates[code].rate;
    });

    /* MoneyJS Setup */

    fx.rates = RATES;
    fx.base = 'BTC';

    var converter = {
        convert: function convert(from, to, value) {
            return fx(value).from(from).to(to);
        },
        priceFormat: function priceFormat(value, count) {
            var price = null;
            value = Number(value);

            if (!isNaN(value)) {
                var val_exp = value.toExponential(count),
                    parts = val_exp.split('e'),
                    exp = Number(parts[1]),
                    diff = count - exp - 1;

                if (diff <= 0) {
                    price = value.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                } else {
                    price = value.toFixed(diff);
                }
            }

            return price;
        },
        sanitizeNumber: function sanitizeNumber(number) {
            if (typeof number === 'number') {
                return number;
            } else if (typeof number === 'string') {
                return this.sanitizeNumber(parseFloat(number.replace(/,/g, '')));
            } else return 0;
        },
        convertFormatted: function convertFormatted(from, to, value, n) {
            var sanitized = this.sanitizeNumber(value);
            var val = this.convert(from, to, sanitized);

            return this.priceFormat(val, n || 5);
        }
    };

    VCW.compile = function () {
        $('.vcw-price-label, .vcw-change-label, .vcw-price-big-label, .vcw-change-big-label, .vcw-price-card, .vcw-change-card, .vcw-full-card').vcwLink();
        $('.vcw-converter').vcwConverter();
    };

    $.fn.extend({
        vcwLink: function vcwLink() {
            this.each(function () {
                var elem = $(this),
                    url = elem.data('url'),
                    target = elem.data('target');

                elem.click(function () {
                    return window.open(url, target);
                });
            });
        },
        vcwConverter: function vcwConverter() {
            this.each(function () {
                var elem = $(this),
                    currency_1 = elem.find('.vcw-currency-1'),
                    currency_2 = elem.find('.vcw-currency-2'),
                    value_1 = elem.find('.vcw-value-1'),
                    value_2 = elem.find('.vcw-value-2');

                currency_1.on("change paste keyup", function () {
                    var v = converter.convertFormatted(currency_2.val(), currency_1.val(), value_2.val());
                    value_1.val(v);
                });

                value_1.on("change paste keyup", function () {
                    var v = converter.convertFormatted(currency_1.val(), currency_2.val(), value_1.val());
                    value_2.val(v);
                });

                currency_2.on("change paste keyup", function () {
                    var v = converter.convertFormatted(currency_1.val(), currency_2.val(), value_1.val());
                    value_2.val(v);
                });

                value_2.on("change paste keyup", function () {
                    var v = converter.convertFormatted(currency_2.val(), currency_1.val(), value_2.val());
                    value_1.val(v);
                });

                value_2.val(converter.convertFormatted(currency_1.val(), currency_2.val(), value_1.val()));
            });
        }
    });

    $(function () {
        return VCW.compile();
    });
})(jQuery, VirtualCoinWidgets, fx);
