/**
 * Created by offspring on 22.03.2017.
 */

function debitsController($http, $filter) {

    var ctrl = this;
    ctrl.debtList = [];
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

    ctrl.setFilter = function (data) {

        letter = ctrl.filter.id;
        items = ctrl.debtList

        $filter(
             function (items, letter) {
                var filtered = [];
                var letterMatch = new RegExp(letter, 'i');
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    if (letterMatch.test(item.name.substring(0, 1))) {
                        filtered.push(item);
                    }
                }
                return filtered;
            }
        );
    }
}

app.component('debitComponent', {
    controller: debitsController,
    templateUrl: '/js/debt.html',
    bindings: {
        debtList: '@'
    }
});
