myApp.controller('image', ['$scope','$location','$http', function ($scope,$location,$http) {

    $scope.data = {
        namee:''
    }

    $scope.dataa = {
        image:''
    }

    $scope.fileChanged = function (element) {
        $scope.$apply(function () {
          $scope.dataa.image = element.files[0];
        });
      };
  

    $scope.upload = function(){ 
        var formData = new FormData();
      formData.append('data', angular.toJson($scope.data.namee, false));
      // The false parameter indicates that you don't want the output to be formatted for better human readability.
      formData.append('image', $scope.dataa.image);    
        $http({
            method: 'POST',
            url:'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php?action=image',
            data: formData,
            // htransformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
        }).then(function(response){
            console.log(response.data);
        }).catch(function(error){
             console.log(error);
        });
    }

    $scope.get = function(){
        $http({
            method: 'GET',
            url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php/getImage',
        }).then(function(response){
           $scope.image = response.data;

        }).catch(function(error){
           console.log(error);
        })
    }

}]);