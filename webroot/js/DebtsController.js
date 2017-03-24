/**
 * Created by offspring on 22.03.2017.
 */

function debitsController($http, $filter) {

    var ctrl = this;
    ctrl.debtList = [];
    ctrl.debtListTemp = [];
    ctrl.debtListFiltred = [];
    ctrl.form = {
        name: '',
        balance: '',
        interest: '',
        type: '',
    };

    //Load debt-list
    $http({
        method: 'GET',
        url: '/api/debts.json'
    }).then(function (response) {
        ctrl.debtList = response.data.debts;
    }, function (response) {
        console.log(response);
    });

    /**
     * Send request for new debt row
     */
    ctrl.addDebt = function () {
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

       if(ctrl.debtListTemp.length){
           ctrl.debtList = ctrl.debtListTemp;
       }

    }
}

app.component('debitComponent', {
    controller: debitsController,
    templateUrl: '/js/debt.html',
    bindings: {
        debtList: '@'
    }
});
