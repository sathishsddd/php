
myApp.controller('dtCtrl', ['$scope', '$location', '$timeout', '$location','$rootScope', function ($scope, $location, $timeout, $location,$rootScope) {
  var ownerName = localStorage.storedOwnerName;
  $scope.ownerName = ownerName;
  var roomBookingData = JSON.parse(localStorage.getItem('roomBookingData'));
  // to check that user is booked any rooms
  if (!roomBookingData) {
    const message = `No Bookings yet.`;
    $('#message').text(message);
    $('#signInModal').modal('show');
    $timeout(function () {
      $('.modal-backdrop').remove();
      $location.path('/room2');
    }, 2000);

  } else {
    // to get user who booked the particular owner rooms
    $scope.roomBookingData2 = [];
    for (let index = 0; index < roomBookingData.length; index++) {
      var data = roomBookingData[index];
      if (data.ownerName == ownerName) {
        $scope.roomBookingData2.push(roomBookingData[index]);
      }
    }
  }

  // to ckeck any user booked that particular owner room
  if ($scope.roomBookingData2.length === 0) {
    const message = `No Bookings yet.`;
    $('#message').text(message);
    $('#signInModal').modal('show');
    $timeout(function () {
      $('.modal-backdrop').remove();
      $location.path('/room2');
    }, 2000);
  }

  localStorage.setItem('roomBookingData2', JSON.stringify($scope.roomBookingData2));
  $scope.roomBookingData2 = JSON.parse(localStorage.getItem('roomBookingData2'));

  $scope.focusedRow = -1;

  $scope.focusImage = function (index) {
    $scope.focusedRow = index;
  };
  $scope.unfocusImage = function () {
    $scope.focusedRow = -1; // Unfocus when the mouse leaves the row
  };

  $scope.goToCheckAvailability = function () {
    $location.path("/availability2");
  } 

  $scope.goBack = function () {
    console.log("inside");
    $location.path('/room2');
  }

  $scope.data;
  $scope.showDetails=function(data){
     $scope.data=data;
  }

  //  $scope.selectedUser;
  // $scope.editDetails = function (data) {
  //   $scope.selectedUser = angular.copy(data);
  //   // $scope.selectedUser = angular.data;
  // };

  // $scope.onUpdate = function () {
  //   $('#editModal').modal('hide');
  // }

  var table;
  $(document).ready(function () {
    if (!DataTable.isDataTable('#example')) {
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
          {
            "targets": 1, // Target the second column,
            "render": function (data, type, row, meta) {
              // Use meta.row to get the row index
              return '<span style="color: black;" >' + (meta.row + 1) + '</span>';
            }
          },
          {
            "targets": 0, // Target the first column
            "orderable": false, // Disable sorting on this column
            // "className": 'dt-body-center', // Center align the content
            "render": function (data, type, full, meta) {
              return '<input type="checkbox">';
            }
          },
          { "orderable": false, "targets": [0, 7, 8] }
        ],
        "order": [[1, 'asc']],
        "lengthMenu": [5, 10, 25, 50, 100],
        "dom": '<"top">rt<"bottom"ilp>'
        
      });

      $('#custom_filter').on('keyup', function () {
        var searchValue = $('#custom_filter input[name="search"]').val();
        table.search(searchValue).draw();
      });
    }
  });

}]);


myApp.component('viewModal', {
  templateUrl: 'app/view/view.html',
  bindings: {
    data: '<'// Use one-way binding with '<' for read-only data
  },
});

// myApp.component('editModal', {
//   templateUrl: 'app/view/edit.html',

//   bindings: {
//     userDetail: '=',
//     onUpdate: '&'
//   },
//   controller: 'EditController',
//   controllerAs: '$ctrl'
// });

myApp.filter('phoneNumber',function(){
  return function(input){
     return '+91 ' + input;
  };
});


// myApp.controller('EditController', function ($scope, $http, $timeout) {


//   var ctrl = this;

//   ctrl.openDatePicker = function () {
//     $('#datepicker-modal').datepicker('show');
//     $('#datepicker-modal2').datepicker('show');
//   };

//   $(document).ready(function () {
//     $('#datepicker-modal').datepicker({
//       format: 'yyyy-mm-dd',
//       autoclose: true,
//       todayHighlight: true,
//     });
//     $('#datepicker-modal2').datepicker({
//       format: 'yyyy-mm-dd',
//       autoclose: true,
//       todayHighlight: true,
//     });
//   })

//   ctrl.onSubmit=function(updatedData){
//     console.log(updatedData);
//     $timeout(function() {
//       $scope.selectedUser = updatedData;
//       ctrl.onUpdate();
//   });
//   }
// });