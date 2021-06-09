"use strict";
var woocs_loading_first_time = true;//simply flag var
var woocs_sumbit_currency_changing = true;//just a flag variable for drop-down redraws when prices redraws by AJAX

jQuery(function ($) {

 


    //to make price popup mobile friendly
    jQuery('body').on('click', '.woocs_price_info', function () {
        return false;
    });






    //for converter
    if (jQuery('.woocs_converter_shortcode').length) {
        jQuery('.woocs_converter_shortcode_button').on("click", function () {
            var amount = jQuery(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_amount').eq(0).val();
            var from = jQuery(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_from').eq(0).val();
            var to = jQuery(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_to').eq(0).val();
            var precision = jQuery(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_precision').eq(0).val();
            var results_obj = jQuery(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_results').eq(0);
            jQuery(results_obj).val(woocs_lang_loading + ' ...');
            var data = {
                action: "woocs_convert_currency",
                amount: amount,
                from: from,
                to: to,
                precision: precision
            };

            jQuery.post(woocs_ajaxurl, data, function (value) {
                jQuery(results_obj).val(value);
            });

            return false;

        });
    }

    //for rates
    if (jQuery('.woocs_rates_shortcode').length) {
        jQuery('body').on('change', '.woocs_rates_current_currency', function () {
            var _this = this;
            var data = {
                action: "woocs_rates_current_currency",
                current_currency: jQuery(this).val(),
                precision: jQuery(this).data('precision'),
                exclude: jQuery(this).data('exclude')
            };

            jQuery.post(woocs_ajaxurl, data, function (html) {
                jQuery(_this).parent('.woocs_rates_shortcode').html(html);
            });

            return false;

        });
    }

    //if we using js price update while the site is cached
    if (typeof woocs_shop_is_cached !== 'undefined') {
        if (woocs_shop_is_cached) {

            woocs_sumbit_currency_changing = false;
            if (typeof woocs_array_of_get.currency === 'undefined') {

                if (jQuery('body').hasClass('single')) {
                    jQuery('.woocs_price_info').remove();
                }

                /****/
                var custom_prices = [];
                jQuery.each(jQuery('.woocs_amount_custom_price'), function (index, item) {
                    custom_prices.push(jQuery(item).data('value'));
                });
                if (custom_prices.length != 0) {

                    var data = {
                        action: "woocs_get_custom_price_html",
                        custom_prices: custom_prices
                    };
                    jQuery.post(woocs_ajaxurl, data, function (data) {
                        data = jQuery.parseJSON(data);

                        if (!jQuery.isEmptyObject(data)) {
                            jQuery.each(data, function (val, price) {
                                jQuery(".woocs_amount_custom_price[data-value='" + val + "']").replaceWith(price);
                                //console.log(price);

                            });

                        }
                    });
                }


                /****/

                var variation_ids = [];
                var var_data = jQuery("form.variations_form").data("product_variations");
                if (typeof var_data != "undefined") {
                    jQuery.each(var_data, function (indx, attr) {
                        variation_ids.push(attr['variation_id']);
                    });
                    if (variation_ids.length != 0) {
                        var data_var = {
                            action: "woocs_get_variation_products_price_html",
                            var_products_ids: variation_ids
                        };

                        jQuery.post(woocs_ajaxurl, data_var, function (data) {
                            data = jQuery.parseJSON(data);

                            if (!jQuery.isEmptyObject(data)) {
                                jQuery.each(var_data, function (indx, attr) {
                                    if (typeof data[attr['variation_id']] != "undefined") {
                                        var_data[indx]['price_html'] = data[attr['variation_id']];
                                    }
                                });
                                jQuery("form.variations_form").data("product_variations", var_data);
                            }
                        });
                    }
                }

                //***
                var products_ids = [];
                jQuery.each(jQuery('.woocs_price_code'), function (index, item) {
                    products_ids.push(jQuery(item).data('product-id'));
                });

                //if no prices on the page - do nothing
                if (products_ids.length === 0) {
                    woocs_sumbit_currency_changing = true;
                    return;
                }


                var data = {
                    action: "woocs_get_products_price_html",
                    products_ids: products_ids,
                };
                jQuery.post(woocs_ajaxurl, data, function (data) {

                    data = jQuery.parseJSON(data);
                    if (!jQuery.isEmptyObject(data)) {
                        jQuery('.woocs_price_info').remove();
                        jQuery.each(jQuery('.woocs_price_code'), function (index, item) {

                            if (data.ids[jQuery(item).data('product-id')] != undefined) {
                                jQuery(item).replaceWith(data.ids[jQuery(item).data('product-id')]);
                            }

                        });
                        jQuery('.woocs_price_code').removeClass('woocs_preloader_ajax');
                        //***
                        jQuery('.woocommerce-currency-switcher').val(data.current_currency);
                        //***
                        if (woocs_drop_down_view == 'chosen' || woocs_drop_down_view == 'chosen_dark') {
                            try {
                                if (jQuery("select.woocommerce-currency-switcher").length) {
                                    jQuery("select.woocommerce-currency-switcher").chosen({
                                        disable_search_threshold: 10
                                    });
                                    jQuery('select.woocommerce-currency-switcher').trigger("chosen:updated");
                                }
                            } catch (e) {
                                console.log(e);
                            }
                        }
                        if (typeof data.currency_data != "undefined") {
                            woocs_current_currency = data.currency_data;
                            /* Price  slider */
                            var min = jQuery('.price_slider_amount #min_price').val();
                            var max = jQuery('.price_slider_amount #max_price').val();
                            if (typeof max != 'undefined' && typeof min != 'undefined') {
                                max = woocs_convert_price_slider(max);
                                min = woocs_convert_price_slider(min);
                                jQuery(document.body).trigger('price_slider_create', [min, max]);
                            }
                        }
                        //***
                        if (woocs_drop_down_view == 'ddslick') {
                            try {
                                jQuery('select.woocommerce-currency-switcher').ddslick('select', {index: data.current_currency, disableTrigger: true});
                            } catch (e) {
                                console.log(e);
                            }
                        }
                        //***
                        if (woocs_drop_down_view == 'wselect' && woocs_is_mobile != 1) {
                            //https://github.com/websanova/wSelect
                            try {
                                jQuery('select.woocommerce-currency-switcher').val(data.current_currency).change();
                            } catch (e) {
                                console.log(e);
                            }
                        }
                        //***
                        /* auto switcher*/

                        var auto_switcher = jQuery('.woocs_auto_switcher');
                        if (auto_switcher.length > 0) {
                            woocs_auto_switcher_redraw(data.current_currency, auto_switcher);
                        }
                        woocs_sumbit_currency_changing = true;


                        //***
                        //for another woocs switchers styles
                        document.dispatchEvent(new CustomEvent('after_woocs_get_products_price_html', {detail: {
                                current_currency: data.current_currency
                            }}));
                    }

                });

            } else {
                woocs_sumbit_currency_changing = true;
                jQuery('.woocs_price_code').removeClass('woocs_preloader_ajax');
            }
        }
    }

    //***
    //removing price info on single page near variation prices
    setTimeout(function () {
        //jQuery('body.single-product .woocommerce-variation-price').find('.woocs_price_info').remove();
    }, 300);
    //***


});


function woocs_redirect(currency) {
    if (!woocs_sumbit_currency_changing) {
        return;
    }

    //***
    var l = window.location.href;
    l = l.replace('#', '');

    //for #id navigation     l = l.replace(/(#.+$)/gi, '');

    l = l.split('?');
    l = l[0];
    var string_of_get = '?';
    woocs_array_of_get.currency = currency;

    /*
     l = l.replace(/(\?currency=[a-zA-Z]+)/g, '?');
     l = l.replace(/(&currency=[a-zA-Z]+)/g, '');
     */

    if (woocs_special_ajax_mode) {
        string_of_get = "";

        var data = {
            action: "woocs_set_currency_ajax",
            currency: currency
        };

        jQuery.post(woocs_ajaxurl, data, function (value) {
            location.reload();
        });

    } else {
        if (Object.keys(woocs_array_of_get).length > 0) {
            jQuery.each(woocs_array_of_get, function (index, value) {
                string_of_get = string_of_get + "&" + index + "=" + value;
            });
            //string_of_get+=decodeURIComponent(jQuery.param(woocs_array_of_get));        
        }
        window.location = l + string_of_get;
    }


}

function woocs_refresh_mini_cart(delay) {
    /** Cart Handling */
    setTimeout(function () {
        try {
            //for refreshing mini cart
            $fragment_refresh = {
                url: wc_cart_fragments_params.ajax_url,
                type: 'POST',
                data: {action: 'woocommerce_get_refreshed_fragments', woocs_woocommerce_before_mini_cart: 'mini_cart_refreshing'},
                success: function (data) {
                    if (data && data.fragments) {

                        jQuery.each(data.fragments, function (key, value) {
                            jQuery(key).replaceWith(value);
                        });

                        try {
                            if ($supports_html5_storage) {
                                sessionStorage.setItem(wc_cart_fragments_params.fragment_name, JSON.stringify(data.fragments));
                                sessionStorage.setItem('wc_cart_hash', data.cart_hash);
                            }
                        } catch (e) {

                        }

                        jQuery('body').trigger('wc_fragments_refreshed');
                    }
                }
            };

            jQuery.ajax($fragment_refresh);


            /* Cart hiding */
            try {
                //if (jQuery.cookie('woocommerce_items_in_cart') > 0)
                if (woocs_get_cookie('woocommerce_items_in_cart') > 0)
                {
                    jQuery('.hide_cart_widget_if_empty').closest('.widget_shopping_cart').show();
                } else {
                    jQuery('.hide_cart_widget_if_empty').closest('.widget_shopping_cart').hide();
                }
            } catch (e) {
                //***
            }


            jQuery('body').bind('adding_to_cart', function () {
                jQuery('.hide_cart_widget_if_empty').closest('.widget_shopping_cart').show();
            });

        } catch (e) {
            //***
        }

    }, delay);

}

function woocs_get_cookie(name) {
    var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

/*auto switcher*/

jQuery(function () {
    jQuery('.woocs_auto_switcher_link').on('click', function () {
        woocs_redirect(jQuery(this).data('currency'));
        return false;
    });

    jQuery('.woocs_auto_switcher li').on('click', function (e) {
        woocs_redirect(jQuery(this).find('a.woocs_auto_switcher_link').data('currency'));
        return false;
    });
});

function woocs_auto_switcher_redraw(curr_curr, switcher) {
    var view = switcher.data('view');
    switch (view) {
        case 'classic_blocks':
            switcher.find('a').removeClass('woocs_curr_curr');
            switcher.find('a[data-currency="' + curr_curr + '"]').addClass('woocs_curr_curr');
            break;
        case 'roll_blocks':
            switcher.find('a').removeClass('woocs_curr_curr');
            switcher.find('li').removeClass('woocs_auto_bg_woocs_curr_curr');
            var current_link = switcher.find('a[data-currency="' + curr_curr + '"]');
            current_link.addClass('woocs_curr_curr');
            current_link.parents('li').addClass('woocs_auto_bg_woocs_curr_curr');
            break;
        case 'round_select':
            switcher.find('a').removeClass('woocs_curr_curr');
            var current_link = switcher.find('a[data-currency="' + curr_curr + '"]');
            current_link.addClass('woocs_curr_curr');
            jQuery('.woocs_current_text').html(current_link.find('.woocs_base_text').html());
            break;
        default:
            break;
    }

}

function woocs_remove_link_param(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
            param,
            params_arr = [],
            queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}

