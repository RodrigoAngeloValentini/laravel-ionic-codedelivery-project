angular.module('starter.controllers')
    .controller('ClientViewOrderCtrl',[
        '$scope','$stateParams','ClientOrder','$ionicLoading',function($scope, $stateParams, ClientOrder, $ionicLoading){

            $scope.order = {};
            $ionicLoading.show({
                template:'Carregando...'
            });

            ClientOrder.get({id:$stateParams.id, include:"items,cupom"},function(data){
                console.log(data.data);
                $scope.order = data.data;
                $ionicLoading.hide();
            },function(dataError){
                $ionicLoading.hide();
            });

        }]);