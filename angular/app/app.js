// Initialize the AngularJS application
var myApp = angular.module('myApp', ['ngRoute']);

myApp.controller('mainCtrl', ['$scope','$rootScope', function ($scope,$rootScope) {
    $scope.sample = "data";
    // $rootScope.room={
    //     room:"1"
    // };
 
}]);

// Configure the routes
myApp.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        // .when('/home', {
        //     templateUrl: 'app/view/home.html',
        //     controller: 'homeController'
        // })
        .when('/room', {
            templateUrl: 'app/view/roomBooking.html',
            controller: 'MyCtrl'
        })

        .when('/login',{
            templateUrl: 'app/view/login.html',
            controller: 'loginCtrl'
        })

        .when('/register',{
            templateUrl: 'app/view/register.html',
            controller: 'loginCtrl' 
        })
        .when('/availability',{
            templateUrl: 'app/view/availabilityTemplate.html',
            controller: 'availabilityController' 
        })
        .when('/availability2',{
            templateUrl: 'app/view/availabilityTemplate2.html',
            controller: 'availabilityController3' 
        })
        .when('/room2',{
            templateUrl: 'app/view/room.html',
            controller: 'roomController' 
        })
        .when('/showRooms',{
            templateUrl: 'app/view/roomSelection.html',
            controller: 'roomSelectionCtrl' 
        })
        .when('/dataTable',{
            templateUrl: 'app/view/dataTable.html',
            controller: 'dtCtrl' 
        })
        .when('/dataTable2',{
            templateUrl: 'app/view/userDataTable.html',
            controller: 'dt2Ctrl' 
        })
        .when('/dataTable3',{
            templateUrl: 'app/view/availabilityDataTable.html',
            controller: 'dtCtrl2' 
        })
        .when('/view/:param',{
            templateUrl: 'app/view/view2.html',
            controller: 'ViewController' 
        })
        
        .otherwise({ redirectTo: '/login' });

}]);
