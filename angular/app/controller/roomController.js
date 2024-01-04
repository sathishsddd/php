myApp.controller('roomController',['$scope','$timeout','$location', function ($scope,$timeout,$location) {
    $scope.room={
        "roomNumber":'',
        "roomType":'',
        "roomSize":'',
        "ownerName":'',
        "bookings":[]
    };

    $scope.clearFormFields=function(){
      $scope.room={
        "roomNumber":'',
        "roomType":'',
        "roomSize":'',
    }
  };

    $scope.addRoom=function(){
      $scope.room.ownerName= localStorage.storedOwnerName;
      var roomData = JSON.parse(localStorage.getItem('roomData')) || [];
      roomData.push($scope.room);
       localStorage.setItem('roomData', JSON.stringify(roomData));
       $('#message').text('Room Added.');
       $('#signInModal').modal('show');
       $scope.clearFormFields();
       $timeout(function () {
         $('#signInModal').modal('hide');
           $('.modal-backdrop').remove();
           $location.path('/room2');
       }, 1000);
    };

    $scope.viewBooking=function(){
      $location.path('/dataTable');
  };

}]);