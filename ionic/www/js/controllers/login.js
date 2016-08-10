angular.module('starter.controllers')
    .controller('LoginCtrl',[
        '$scope','OAuth','OAuthToken','$ionicPopup','$state','$q','UserData','User',function($scope, OAuth,OAuthToken,$ionicPopup,$state,$q,UserData,User){

        $scope.user = {
            username:'',
            password:''
        };

        $scope.login = function(){
            var promise = OAuth.getAccessToken($scope.user);
            promise
                .then(function(data){
                    return User.authenticated({incluse:'client'}).$promise;
                })
                .then(function(data){
                    UserData.set(data.data);
                    $state.go('client.view_products');
                },function(responseError){
                    UserData.set(null);
                    OAuthToken.removeToken();
                    $ionicPopup.alert({
                        title:'Advertência',
                        template:'Login ou senha inválidos'
                    })
                });
        }
    }]);