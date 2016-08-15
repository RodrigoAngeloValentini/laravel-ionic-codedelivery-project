angular.module('starter.controllers')
    .controller('DeliverymanViewOrderCtrl',[
        '$scope','$stateParams','DeliveymanOrder','$ionicLoading','$ionicPopup','$cordovaGeolocation',function($scope, $stateParams, DeliveymanOrder, $ionicLoading,$ionicPopup,$cordovaGeolocation){
            var watch, lat = null, long = null;
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

            $scope.goToDelivey = function(){
                $ionicPopup.alert({
                    title:'Advertência',
                    template:'Para parar a localização de OK.'
                }).then(function(){
                    stopWatchPosition();
                });
                DeliveymanOrder.updateStatus({id:$stateParams.id},{status:1},function(){
                    //geo localizacao
                    var watchOptions = {
                        timeout:3000,
                        enableHighAccuracy:false
                    };
                    watch = $cordovaGeolocation.watchPosition(watchOptions);
                    watch.then(null,
                        function(responseError){
                        //err
                        },function(position){
                            if(!lat){
                                lat = position.coords.latitude;
                                long = position.coords.longitude;
                            }else{
                                long -= 0.0444;
                            }

                            DeliveymanOrder.geo({id:$stateParams.id},{
                                lat:lat,
                                long:long
                            })
                        });
                });
            };

            function stopWatchPosition(){
                if(watch && typeof watch=='object' && watch.hasOwnProperty('watchID')){
                    $cordovaGeolocation.clearWatch(watch.watchId);
                }
            }

        }]);