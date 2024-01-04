
myApp.controller('dt2Ctrl', ['$scope', '$timeout', '$location', '$http', function ($scope, $timeout, $location, $http) {
  var userName = localStorage.storedUserName;
  $scope.userName = userName;

  $scope.initFunction = function () {
     $http({
         method: 'GET',
         url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php/getCustomerBookings',
         params:{
          id:6
         }
     }).then(function (response) {
      $scope.roomBookingData3 = response.data;
      initializeDataTable();
    }).catch(function (error) {
      $scope.roomBookingData3 = [];
      initializeDataTable();
      // const message = `No Bookings yet.`;
      // $('#message').text(message);
      // $('#signInModal').modal('show');
      // $timeout(function () {
      //   $('.modal-backdrop').remove();
      //   $location.path('/room');
      // }, 2000);
    });
  }
  $scope.initFunction();

  $scope.focusedRow = -1;

  $scope.focusImage = function (index) {
    $scope.focusedRow = index;
  };
  $scope.unfocusImage = function () {
    $scope.focusedRow = -1; // Unfocus when the mouse leaves the row
  };

  $scope.goToCreateBooking = function () {
    $location.path("/room");
  }

  $scope.goBack = function () {
    $location.path('/room');
  }

  $scope.data;
  $scope.showDetails = function (data) {
    $scope.data = data;
  }

  $scope.selectedUser;
  $scope.editDetails = function (data) {
    $scope.selectedUser = angular.copy(data);
    // $rootScope.temp = $scope.selectedUser;
    // console.log($rootScope.temp)
    // $scope.selectedUser = angular.data;
  };

  $scope.onUpdate = function () {
    $('#example').DataTable().destroy();
    $scope.initFunction();
    $('#editModal').modal('hide');
  }

  var table;
  function initializeDataTable() {
  $(document).ready(function () {
    if (!$.fn.DataTable.isDataTable('#example')) {
      table = $('#example').DataTable({
        "paging": true,
        "pagingType": "simple_numbers",
        language: {
          info: " _START_ - _END_ of _TOTAL_ ",
          sLengthMenu: 'Rows per page: _MENU_',
          "paginate": {
            "previous": "<",
            "next": "> "
          },
        },
        // "pageLength": 10,
        "drawCallback": function (settings) {
          var api = this.api();
          var pageInfo = api.page.info();
          var paginationDiv = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
          // Create a custom content for the pagination span
          var customPagination = '<span class="custom-pagination">' + '<span class="highlight">' + (pageInfo.page + 1) + '</span>' + '/' + pageInfo.pages + '</span>';
          // Replace the content of the existing span with the custom content
          paginationDiv.find('span').replaceWith(customPagination);
        },

        "columnDefs": [
          // {
          //   "targets": 1, // Target the second column
          //   "render": function (data, type, row, meta) {
          //     // Use meta.row to get the row index
          //     return '<span style="color: black;" >' + (meta.row + 1) + '</span>';
          //   }
          // },
          // {
          //   "targets": 0, // Target the first column
          //   "orderable": false, // Disable sorting on this column
          //   // "className": 'dt-body-center', // Center align the content
          //   "render": function (data, type, full, meta) {
          //     return '<input type="checkbox">';
          //   }
          // },
          { "orderable": false, "targets": [0, 7, 8] }
        ],
        "order": [[1, 'asc']],
        "lengthMenu": [5, 10, 25, 50, 100],
        "dom": '<"top">rt<"bottom"ilp><"clear">'
      });

      $('#custom_filter').on('keyup', function () {
        var searchValue = $('#custom_filter input[name="search"]').val();
        table.search(searchValue).draw();
      });
    }
  });
  }
}]);

myApp.component('viewModal2', {
  templateUrl: 'app/view/view.html',
  bindings: {
    data: '<'// Use one-way binding with '<' for read-only data
  },
});

myApp.component('editModal', {
  templateUrl: 'app/view/edit.html',

  bindings: {
    userDetail: '=',
    onUpdate: '&'
  },
  controller: 'EditController',
  controllerAs: '$ctrl'
});

myApp.filter('phoneNumber', function () {
  return function (input) {
    return '+91 ' + input;
  };
});

myApp.controller('EditController', function () {
  var ctrl = this;
  ctrl.openDatePicker = function () {
    $('#datepicker-modal').datepicker('show');
    $('#datepicker-modal2').datepicker('show');
  };

  $(document).ready(function () {
    $('#datepicker-modal').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
    $('#datepicker-modal2').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
  })

  ctrl.onSubmit = function (updatedData) {
    var roomBookingData3 = JSON.parse(localStorage.getItem('roomBookingData3'));
    var roomBookingData = JSON.parse(localStorage.getItem('roomBookingData'));
    var updatedData = updatedData;
    // console.log($rootScope.temp);
    // var temp=$rootScope.temp;


    // Find the index of the object with a matching 'id' in the array
    var index = roomBookingData3.findIndex(function (item) {
      return item.name === updatedData.name;
    });

    // If the object is found, update it
    if (index !== -1) {
      roomBookingData3[index] = updatedData;

      // Save the updated array back to local storage
      localStorage.setItem('roomBookingData3', JSON.stringify(roomBookingData3));
    } else {
      console.error("Object not found for update");
    }

    // Find the index of the object with a matching 'id' in the array
    var index = roomBookingData.findIndex(function (item) {
      return item.name === updatedData.name;
    });

    // If the object is found, update it
    if (index !== -1) {
      roomBookingData[index] = updatedData;

      // Save the updated array back to local storage
      localStorage.setItem('roomBookingData', JSON.stringify(roomBookingData));
    } else {
      console.error("Object not found for update");
    }
    ctrl.onUpdate();
  }
});