angular.module('starter.controllers')
    .controller('DeliverymanViewOrderCtrl',[
        '$scope','$stateParams','DeliveymanOrder','$ionicLoading',function($scope, $stateParams, DeliveymanOrder, $ionicLoading){

            $scope.order = {};
            $ionicLoading.show({
                template:'Carregando...'
            });

            DeliveymanOrder.get({id:$stateParams.id, include:"items,cupom"},function(data){
                console.log(data.data);
                $scope.order = data.data;
                $ionicLoading.hide();
            },function(dataError){
                $ionicLoading.hide();
            });

        }]);