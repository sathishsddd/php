myApp.controller('roomSelectionCtrl', ['$scope', '$http', '$location', '$timeout','roomBookingDataService', function ($scope, $http, $location, $timeout,roomBookingDataService) {

  $scope.roomData = [];
  // var data = roomBookingDataService.getResponseData();
  var data = JSON.parse(localStorage.getItem('responseData')) || null; 


  if(data){
    var roomSize = data.data.selectedRoomSize;
    var roomType = data.data.roomType;

    $http({
      method: 'GET',
      url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php/getRooms',
      params: {
        roomSize: roomSize,
        roomType: roomType
      }
    }).then(function (response) {
      $scope.roomData = response.data;
    }, function (error) {
      console.error('Error getting user:', error);
        const message = `Room Not Available.`;
        $('#message').text(message);
        $('#signInModal').modal('show');
        // $timeout(function () {
        //   $('.modal-backdrop').remove();
        //   $location.path('/room');
        // }, 2000);
    });
  }else{
    const message = `Room Not Available.`;
    $('#message').text(message);
    $('#signInModal').modal('show');
  }
   
  // $scope.booking = {
  //   "checkInDate": '',
  //   "checkOutDate": '',
  //   "name": '',
  //   "number": ''
  // }

  $scope.bookRoom = function (room) {
    console.log("inside");
    $http({
      method: 'POST',
      url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php?action=bookRoom',
      data: data.data,
      params: {
        roomId: room.room_id
      },
      headers: {
        'Content-Type': 'application/json'
      },
      transformResponse: [function (data) {
        return data;
      }]
    }).then(function (response) {
         $location.path('/dataTable2');
    }).catch(function (error) {
      console.log(error);
      const message = `Room Not Available.`;
      $('#message').text(message);
      $('#signInModal').modal('show');
       $timeout(function () {
          $('.modal-backdrop').remove();
          $location.path('/room');
        }, 2000);
    });
  };

  $scope.editDetails = function () {
    $location.path('/room');
  }

}]);

