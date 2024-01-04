myApp.controller('roomSelectionCtrl', ['$scope', '$rootScope', '$http', '$location', '$timeout', function ($scope, $rootScope, $http, $location, $timeout) {
  var roomDatas = JSON.parse(localStorage.getItem('roomData')); // getting room data from localstorage
  $scope.room = $rootScope.room; // getting the user roombooking details from rommBooking.js
  $scope.roomData = [];

  $scope.booking = {
    "checkInDate": '',
    "checkOutDate": '',
    "name": '',
    "number": ''
  }

  // to show the rooms based on user selected roomsize and roomtype
  for (let index = 0; index < roomDatas.length; index++) {
    if (roomDatas[index].roomSize == $scope.room.selectedRoomSize && roomDatas[index].roomType == $scope.room.roomType) {
      $scope.roomData[$scope.roomData.length] = roomDatas[index];
    }
  }

  // to display popup when there is no room for user requirement
  if ($scope.roomData.length === 0) {
    const message = `Room Not Available.`;
    $('#message').text(message);
    $('#signInModal').modal('show');
    $timeout(function () {
      $('.modal-backdrop').remove();
      $location.path('/room');
    }, 2000);
  }

  $scope.bookRoom = function (room) {
    // setting the user room booking dates in room details array
    $scope.booking.checkInDate = $scope.room.checkInDate;
    $scope.booking.checkOutDate = $scope.room.checkOutDate;
    $scope.booking.name = $scope.room.name;
    $scope.booking.number = $scope.room.number;

    for (var i = 0; i < roomDatas.length; i++) {
      var room2 = roomDatas[i];
      if (room2.roomNumber == room.roomNumber) {
        if (room2.bookings) {
          const isAvailable = room2.bookings.every(booking => {
            const checkIn = new Date(booking.checkInDate);
            const checkOut = new Date(booking.checkOutDate);
            // Check if the booking doesn't overlap with the requested dates
            return (
              new Date($scope.room.checkOutDate) <= checkIn || // Check-out date is before or equal to the start date of the booking
              new Date($scope.room.checkInDate) >= checkOut // Check-in date is after or equal to the end date of the booking
            );
          });
          if (isAvailable) {
            // if room is available than save the roombooking details into storage
            $scope.room.userName = localStorage.storedUserName;
            var roomBookingData = JSON.parse(localStorage.getItem('roomBookingData')) || [];
            $scope.room = $rootScope.room;
            roomBookingData.push($scope.room);
            localStorage.setItem('roomBookingData', JSON.stringify(roomBookingData));

            // to fill the owner nane in user booking details based on room selected
            for (let index = 0; index < roomBookingData.length; index++) {
              if (roomBookingData[index].name == $scope.room.name && roomBookingData[index].number == $scope.room.number) {
                roomBookingData[index].ownerName = room.ownerName;
                localStorage.setItem('roomBookingData', JSON.stringify(roomBookingData));
              }
            }
            // to push the booking date and user details into room details
            roomDatas[i].bookings.push($scope.booking);
            localStorage.setItem('roomData', JSON.stringify(roomDatas));
            const message = `Room Booked.`;
            $('#message').text(message);
            $('#signInModal').modal('show');
            $rootScope.room = '';
            $timeout(function () {
              $('.modal-backdrop').remove();
              $location.path('/dataTable2');
            }, 2000);
          } else {
            const message = `Room Not Available.`;
            $('#message').text(message);
            $('#signInModal').modal('show');
            // localStorage.setItem('tempData', JSON.stringify($rootScope.room));
          }
        }
        else {
          // if room is available than save the roombooking details into storage
          $scope.room.userName = localStorage.storedUserName;
          var roomBookingData = JSON.parse(localStorage.getItem('roomBookingData')) || [];
          $scope.room = $rootScope.room;
          roomBookingData.push($scope.room);
          console.log($scope.room);
          localStorage.setItem('roomBookingData', JSON.stringify(roomBookingData));

          // to fill the owner nane in user booking details based on room selected
          for (let index = 0; index < roomBookingData.length; index++) {
            if (roomBookingData[index].name == $scope.room.name && roomBookingData[index].number == $scope.room.number) {
              roomBookingData[index].ownerName = room.ownerName;
              localStorage.setItem('roomBookingData', JSON.stringify(roomBookingData));
            }
          }
          // to push the booking date and user details into room details
          $rootScope.room = '';
          roomDatas[i].bookings.push($scope.booking);
          localStorage.setItem('roomData', JSON.stringify(roomDatas));
          const message = `Room Booked.`;
          $('#message').text(message);
          $('#signInModal').modal('show');
          $timeout(function () {
            $('.modal-backdrop').remove();
            $location.path('/dataTable2');
          }, 2000);

        }
      }
    }
  };

  $scope.editDetails = function () {
    $location.path('/room');
  }

}]);

