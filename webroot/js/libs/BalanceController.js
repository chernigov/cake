/**
 * Created by offspring on 22.03.2017.
 */

function debitsController($http) {

    var ctrl = this;
    ctrl.debtList = [];
    ctrl.form = {
        name: '',
        balance: '',
        interest: '',
        type: '',
    };

    $http({
        method: 'GET',
        url: '/api/debts.json'
    }).then(function (response) {
        ctrl.debtList = response.data.debts;
    }, function (response) {
        console.log(response);
    });

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
}

app.component('debitComponent', {
    controller: debitsController,
    templateUrl: '/js/debt.html',
    bindings: {
        debtList: '@'
    }
});
