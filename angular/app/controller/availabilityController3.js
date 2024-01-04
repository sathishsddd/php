myApp.controller('availabilityController3', ['$scope','$location','$rootScope', function ($scope,$location,$rootScope) {

    $scope.booking = {
        checkInDate: '',
        checkOutDate: '',
    }

    $scope.isRoomAvailable=true;
    $scope.showTable=false;
    $scope.checkAvailability = function () {
        if (!$scope.booking.checkInDate && !$scope.booking.checkOutDate) {
            $scope.roomData2='';
            $scope.isRoomAvailable=false;
            return;
        }
        if ($scope.booking.checkInDate > $scope.booking.checkOutDate) {
            $scope.roomData2='';
            $scope.isRoomAvailable=false;
            return;
        }
        var roomData = JSON.parse(localStorage.getItem('roomData'));
        var ownerName = localStorage.storedOwnerName;
        var roomData2 = [];
        for (let index = 0; index < roomData.length; index++) {
            var room = roomData[index];
            if (room.ownerName === ownerName) {
                room.availability = '';
                roomData2.push(roomData[index]);
            }
        }
        localStorage.setItem('roomData2', JSON.stringify(roomData2));
        // to get the details of booking from view
        var checkInDateTime = $scope.booking.checkInDate;
        var checkOutDateTime = $scope.booking.checkOutDate;
        var roomData2 = JSON.parse(localStorage.getItem('roomData2'));
        for (let index = 0; index < roomData2.length; index++) {
            var room = roomData2[index];
            if (room.bookings.length > 0) {
                const isAvailable = room.bookings.every(booking => {
                    const checkIn = new Date(booking.checkInDate);
                    const checkOut = new Date(booking.checkOutDate);
                    // Check if the booking doesn't overlap with the requested dates
                    return (
                        new Date(checkOutDateTime) <= checkIn || // Check-out date is before or equal to the start date of the booking
                        new Date(checkInDateTime) >= checkOut // Check-in date is after or equal to the end date of the booking
                    );
                });
                if (isAvailable) {
                    roomData2[index].availability = "YES";
                } else {
                    roomData2[index].availability = "NO";
                }
            } else {
                roomData2[index].availability = "YES";
            }
            localStorage.setItem('roomData2', JSON.stringify(roomData2));
        }
        $scope.isRoomAvailable=true;
        $scope.showTable=true;
        $rootScope.roomData2=roomData2;
        $location.path("/dataTable3");
    };
}]);
