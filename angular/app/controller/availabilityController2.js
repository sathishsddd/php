myApp.controller('availabilityController', ['$scope', function ($scope) {
    // Static array of rooms with availability status and booking information
    var totalRooms = [
        { room_number: 1, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 2, room_type: 'Suite', room_size: 4, booking: { checkIn: '2023-11-12 14:00', checkOut: '2023-11-15 12:00' } },
        { room_number: 3, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 4, room_type: 'Standard', room_size: 1, booking: { checkIn: '2023-08-18 15:00', checkOut: '2023-08-23 10:00' } },
        { room_number: 5, room_type: 'Deluxe', room_size: 3, booking: null },
        { room_number: 6, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 7, room_type: 'Suite', room_size: 4, booking: { checkIn: '2023-08-14 12:00', checkOut: '2023-08-18 10:00' } },
        { room_number: 8, room_type: 'Deluxe', room_size: 3, booking: null },
        { room_number: 9, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 10, room_type: 'Deluxe', room_size: 3, booking: null },
        { room_number: 11, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 12, room_type: 'Deluxe', room_size: 3, booking: null },
        { room_number: 13, room_type: 'Standard', room_size: 1, booking: { checkIn: '2023-08-25 14:00', checkOut: '2023-08-30 12:00' } },
        { room_number: 14, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 15, room_type: 'Deluxe', room_size: 2, booking: null },
        { room_number: 16, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 17, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 18, room_type: 'Deluxe', room_size: 3, booking: null },
        { room_number: 19, room_type: 'Standard', room_size: 1, booking: { checkIn: '2023-08-12 14:00', checkOut: '2023-08-17 12:00' } },
        { room_number: 20, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 21, room_type: 'Suite', room_size: 4, booking: null },
        { room_number: 22, room_type: 'Standard', room_size: 1, booking: null },
        { room_number: 23, room_type: 'Deluxe', room_size: 3, booking: null },
        { room_number: 24, room_type: 'Standard', room_size: 1, booking: { checkIn: '2023-08-22 14:00', checkOut: '2023-08-27 12:00' } },
        { room_number: 25, room_type: 'Deluxe', room_size: 3, booking: null }
    ];

    $scope.getRoomNumbers = function (rooms) {
        return rooms.map(function (room) {
            return room.room_number;
        }).join(', ');
    };

    $scope.checkAvailability = function () {
        $scope.availableRooms = []; 
        $scope.isRoomAvailable = true;

        var checkInDateTime = new Date($scope.booking.checkInDate );
        var checkOutDateTime = new Date($scope.booking.checkOutDate );
        var roomTypeSelected = $scope.booking.roomType;
        var roomSizeSelected = $scope.booking.roomSize;

        if (checkInDateTime > checkOutDateTime) {
            $scope.isRoomAvailable = false;
            $scope.availableRooms = [];
            return true;
        }

        // $scope.isRoomAvailable = true;
        // $scope.availableRooms = [];

        // for (var i = 0; i < $scope.availableRooms.length; i++) {
        //     var room = $scope.availableRooms[i];

        //     if (room.booking) {
        //         var bookedCheckIn = new Date(room.booking.checkIn);
        //         var bookedCheckOut = new Date(room.booking.checkOut);
        //         var roomType = room.room_type;
        //         var roomSize = room.room_size;
                
        //         if ((checkInDateTime < bookedCheckOut && checkOutDateTime > bookedCheckIn) && (roomType == roomTypeSelected) && (roomSize == roomSizeSelected)) {
        //             room.isAvailable = true;
        //         } else {
        //             room.isAvailable = false;
        //         }
        //     } else {
        //         room.isAvailable = true;
        //     }
        // }

        for (var i = 0; i < totalRooms.length; i++) {
            var room = totalRooms[i];
          
            var roomType = room.room_type;
            var roomSize = room.room_size;
            

            if (room.booking) {
                // var bookedCheckIn = new Date(room.booking.checkIn);
                var bookedCheckOut = new Date(room.booking.checkOut);
               
                if ((checkInDateTime > bookedCheckOut) && (roomType == roomTypeSelected) && (roomSize == roomSizeSelected)) {
                    $scope.isRoomAvailable = true;
                    $scope.availableRooms[$scope.availableRooms.length]=totalRooms[i];
                } 
            } else {
                if((roomType == roomTypeSelected) && (roomSize == roomSizeSelected)){
                    $scope.isRoomAvailable = true;
                $scope.availableRooms[$scope.availableRooms.length]=totalRooms[i];    
            }
            }
        }
        if($scope.availableRooms.length==0){
            $scope.isRoomAvailable = false;
        }
    };
}]);
