import '../bootstrap.js'
import axios from "axios";

function getFields() {
    return $('#checkout-form').serializeArray().reduce((obj, item) => {
       obj[item.name] = item.value
        return obj;
    },{});
}

function isEmptyFields() {
    const fields = getFields();

    return Object.values(fields).some((val) => val.length < 1);
}

paypal.Buttons({
    style: {
        layout: 'horizontal'
    },

    onInit: function (data, actions) {
        actions.disable();

        $('#checkout-form').change(() => {
           if(!isEmptyFields()) {
               actions.enable();
           }
        })
    },

    onClick: function (data, actions) {
        if(isEmptyFields()) {
            iziToast.warning({
                title: 'Please fill the form',
                position: 'topRight'
            });
        }
    },

    // Call your server to set up the transaction
    createOrder: function(data, actions) {
        return axios.post('/ajax/paypal/order/create/', getFields())
            .then(function(res) {
                console.log('create.res:', res)
                return res.data.vendor_order_id
        })
    },

    // Call your server to finalize the transaction
    onApprove: function(data, actions) {
        return axios.post(`/ajax/paypal/order/${data.orderID }/capture/`)
            .then(function(res) {
            return res.data;
        }).then(function(orderData) {
                iziToast.success({
                    title: 'Transaction success',
                    position: 'topRight',
                    onClosing: () => {
                        window.location.href = `/orders/${orderData.id}/paypal/thank-you`;
                    }
                })
        }).catch((orderData) => {
                const errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                    return actions.restart();
                }

                if (errorDetail) {
                    let msg = 'Sorry, your transaction could not be processed.';
                    if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                    if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                    iziToast.warning({
                        title: 'warning',
                        message: msg,
                        position: 'topRight'
                    });
                }
            });
    }
}).render('#paypal-button-container');
