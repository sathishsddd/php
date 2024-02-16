
myApp.controller('dt2Ctrl', ['$scope', '$location', '$http', '$timeout', function ($scope, $location, $http, $timeout) {

  $scope.initFunction = function () {
    $http({
      method: 'GET',
      url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php/getCustomerBookings',
      //  withCredentials: false,
      params: {
        id: localStorage.userId
      }
    }).then(function (response) {
      $scope.roomBookingData3 = response.data;
      initializeDataTable();
    }).catch(function (error) {
      $scope.roomBookingData3 = [];
      initializeDataTable();
      if (error.status == 401) {
        const message = error.data.message;
        $('#message').text(message);
        $('#signInModal').modal('show');
        $timeout(function () {
          $('.modal-backdrop').remove();
          $location.path('/login');
        }, 2000);
      }
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

myApp.controller('EditController', ['$http', function ($http) {
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
    $http({
      method: 'POST',
      url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php?action=updateCustomerBookings',
      data: updatedData,
      headers: {
        'Content-Type': 'application/json'
      },
      transformResponse: [function (data) {
        return data;
      }]
    }).then(function (response) {
      ctrl.onUpdate();
    }).catch(function (error) {
      console.log(error.data);
    });
  }

}]);