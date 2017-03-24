/**
 * Created by offspring on 22.03.2017.
 */

function debitsController($scope, $compile, $http, $filter) {

    var ctrl = this;
    ctrl.debtList = [];
    ctrl.debtListTemp = [];
    ctrl.debtListFiltred = [];
    ctrl.debtIndex = null;
    ctrl.form = {
        name: '',
        balance: '',
        interest: '',
        type: '',
    };
    ctrl.formPayment = {
        debt_id: null,
        amount: null,
    };

    //Load debt-list
    $http({
        method: 'GET',
        url: '/api/debts.json'
    }).then(function (response) {
        if( response.data.debts.length){
            ctrl.debtList = response.data.debts;
        }

    }, function (response) {
        console.log(response);
    });

    /**
     * Send request for new debt row
     */
    ctrl.addDebt = function () {
        console.log(ctrl);
        $http({
            method: 'POST',
            url: '/api/debts.json',
            data: ctrl.form
        }).then(function (response) {
            ctrl.debtList.push(response.data.debt);
        }, function (response) {
            console.log(response);
        });
    }

    /**
     * Send request for new balance
     */
    ctrl.addPayment = function () {

        if (ctrl.formPayment.amount && ctrl.formPayment.debt_id) {
            $http({
                method: 'POST',
                url: '/api/payments.json',
                data: ctrl.formPayment
            }).then(function (response) {
                ctrl.debtList[ctrl.debtIndex] = response.data.debt;
                $compile($('body').contents())($scope);
                ctrl.formPayment = {
                    debt_id: null,
                    amount: null,
                };
                ctrl.debtIndex = null;
                ctrl.closeModal();
            }, function (response) {
                console.log(response);
            });
        }

    }

    /**
     * Live filter by the date
     */
    ctrl.setFilter = function () {

        var date = ctrl.filter.date;

        ctrl.debtList.forEach(function (val) {

            if (val.created) {
                var dateToFind = new Date(Date.parse(val.created));
                dateToFind.setHours(0, 0, 0, 0);

                if (Date.parse(dateToFind) == date.getTime()) {
                    ctrl.debtListFiltred.push(val);
                }
            }
        });
        ctrl.debtListTemp = angular.copy(ctrl.debtList);
        ctrl.debtList = ctrl.debtListFiltred;
    }

    /**
     * Reset current filter
     */
    ctrl.resetFilter = function () {

        if (ctrl.debtListTemp.length) {
            ctrl.debtList = ctrl.debtListTemp;
        }

    }

    /**
     * Process Action
     */
    ctrl.getAction = function (debtIndex) {

        //Set debt_id for future payment form
        ctrl.formPayment.debt_id = ctrl.debtList[debtIndex].id;
        //Save index of debtList Array
        ctrl.debtIndex = debtIndex;

        $http({
            method: 'GET',
            url: '/api/payments/add_payment',
        }).then(function (response) {

            
            $('body').append(response.data);
            $compile($('body').contents())($scope)

        }, function (response) {
            console.log(response);
        });
    }

    /**
     * Close  modal window
     * @param $event
     */
    ctrl.closeModal = function () {
        $('.modal-window,.bg-container').remove()
    }
    
    /**
     * Show Payments
     * @param $event
     */
    ctrl.showPayments = function (index, $event) {
        $event.stopPropagation();
        $('#payment-table-'+index).css({
            position:'absolute',
            top: '5%',
            left: '20%',
            zIndex: 99,
            width: '600',
        }).prependTo('body');

        $('body').append('<div class="bg-container"></div>');
        $('#payment-table-'+index).show();
    }

    /**
     * Hide Payments
     * @param $event
     */
    ctrl.hidePayments = function (index, $event) {
        $event.stopPropagation();
        $('#payment-table-'+index).css('display','none');
        $('.modal-window,.bg-container').remove();
    }
}

app.component('debitComponent', {
    controller: debitsController,
    templateUrl: '/js/debt.html',
});
