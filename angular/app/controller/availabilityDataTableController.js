myApp.controller('dtCtrl2', ['$scope','$rootScope','$location',function ($scope,$rootScope,$location) {

    $scope.roomData2=$rootScope.roomData2;

    $scope.goBack=function(){
    $location.path("/availability2")
    }

    var table;
    $(document).ready(function () {
      if (!$.fn.DataTable.isDataTable('#availability')) {
        table = $('#availability').DataTable({
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
            { "orderable": false, "targets": [3] }
          ],
          "lengthMenu": [5, 10, 25, 50, 100],
  
          "dom": '<"top">rt<"bottom"ilp><"clear">'
  
        });
  
      }
  
    });

}])