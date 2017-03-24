/**
 * Created by offspring on 22.03.2017.
 */

var app = angular.module('debit-app', []);


app.directive('formAdd', function ($http, $compile) {
    return {
        controller: function ($http) {
            var ctrl = this;
            ctrl.getResponse = $http({
                method: 'GET',
                url: '/api/debts/form'
            });
        },
        transclude:true,
        link: function ($scope, element, attrs, controller) {
            controller.getResponse.then(function (response) {
                element.html(response.data)
                $compile(element.contents())($scope);
            })
        }
    }
})