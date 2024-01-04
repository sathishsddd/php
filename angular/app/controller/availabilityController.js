myApp.controller('availabilityController', ['$scope', function ($scope) {
    console.log("inside1");
    // Static array of rooms with availability status and booking information
    var totalRooms = [
        { room_number: 1, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 2, room_type: 'Suite', room_size: 4, bookings: [
            { checkIn: '2023-11-10', checkOut: '2023-11-12' },
            { checkIn: '2023-11-15', checkOut: '2023-11-17' }
          ] },
        { room_number: 3, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 4, room_type: 'Standard', room_size: 1, bookings: [
            { checkIn: '2023-11-10', checkOut: '2023-11-12' },
            { checkIn: '2023-11-15', checkOut: '2023-11-18' }
          ] }, 
        { room_number: 5, room_type: 'Deluxe', room_size: 3, bookings: null },
        { room_number: 6, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 7, room_type: 'Suite', room_size: 4, bookings: [
            { checkIn: '2023-11-10', checkOut: '2023-11-12' },
            { checkIn: '2023-11-15', checkOut: '2023-11-18' }
          ] },
        { room_number: 8, room_type: 'Deluxe', room_size: 3, bookings: null },
        { room_number: 9, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 10, room_type: 'Deluxe', room_size: 3, bookings: null },
        { room_number: 11, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 12, room_type: 'Deluxe', room_size: 3, bookings: null },
        { room_number: 13, room_type: 'Standard', room_size: 1, bookings: [
            { checkIn: '2023-11-10', checkOut: '2023-11-12' },
            { checkIn: '2023-11-15', checkOut: '2023-11-18' }
          ] },
        { room_number: 14, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 15, room_type: 'Deluxe', room_size: 2, bookings: null },
        { room_number: 16, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 17, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 18, room_type: 'Deluxe', room_size: 3, bookings: null },
        { room_number: 19, room_type: 'Standard', room_size: 1, bookings: [
            { checkIn: '2023-11-10', checkOut: '2023-11-12' },
            { checkIn: '2023-11-15', checkOut: '2023-11-18' }
          ] },
        { room_number: 20, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 21, room_type: 'Suite', room_size: 4, bookings: null },
        { room_number: 22, room_type: 'Standard', room_size: 1, bookings: null },
        { room_number: 23, room_type: 'Deluxe', room_size: 3, bookings: null },
        { room_number: 24, room_type: 'Standard', room_size: 1, bookings: [
            { checkIn: '2023-11-10', checkOut: '2023-11-12' },
            { checkIn: '2023-11-15', checkOut: '2023-11-18' }
          ] },
        { room_number: 25, room_type: 'Deluxe', room_size: 3, bookings: null }
    ];

    $scope.getRoomNumbers = function (rooms) {
        return rooms.map(function (room) {
            return room.room_number;
        }).join(', ');
    };

    $scope.checkAvailability = function () {
        $scope.availableRooms = []; 
        $scope.isRoomAvailable = true;

        var checkInDateTime = $scope.booking.checkInDate ;
        var checkOutDateTime = $scope.booking.checkOutDate;
        var roomTypeSelected = $scope.booking.roomType;
        var roomSizeSelected = $scope.booking.roomSize;

        if (checkInDateTime > checkOutDateTime) {
            $scope.isRoomAvailable = false;
            $scope.availableRooms = [];
            return true;
        }
       
        for (var i = 0; i < totalRooms.length; i++) {
            var room = totalRooms[i];
          
            var roomType = room.room_type;
            var roomSize = room.room_size;
            

            if (room.bookings) {
           
              const isAvailable=  room.bookings.every(booking => {
                  
                    const checkIn = new Date(booking.checkIn);
                    const checkOut = new Date(booking.checkOut);
                
                    // Check if the booking doesn't overlap with the requested dates
                    return (
                        // checkOut >= new Date() && // Check if the booking is in the future
                        new Date(checkOutDateTime) <= checkIn || // Check-out date is before or equal to the start date of the booking
                        new Date(checkInDateTime) >= checkOut // Check-in date is after or equal to the end date of the booking
                    );
                });
               
                if (isAvailable && (roomType == roomTypeSelected) && (roomSize == roomSizeSelected)) {
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
