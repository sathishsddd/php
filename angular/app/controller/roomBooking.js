

myApp.controller('MyCtrl', ['$scope', '$http', '$timeout', '$location','roomBookingDataService', function ($scope, $http, $timeout, $location,roomBookingDataService) {
  $scope.today = new Date();
  $scope.today.setDate($scope.today.getDate() + 1);

  $scope.room = {
    name: '',
    age: '',
    selectedGender: '',
    purpose: '',
    email: '',
    number: '',
    selectIdTypes: '',
    idnumber: '',
    roomType: 'AC',
    selectedRoomSize: '',
    checkInDate: '',
    checkInTime: '',
    checkOutDate: '',
    checkOutTime: '',
    selectCateringTypes: '',
    selectLaundryTypes: '',
  }

  // options for gender
  $scope.genders = ["Male", "Female", "Transgender"];

  // options for idType
  $scope.idTypes = ["Aadhar card", "Voter ID", "PAN Card", "Driving Licence"]

  // to show the additional requirement page
  $scope.showMainSub = true;
  $scope.showMain1 = false;

  $scope.goToAdditionalRequirements = function () {
    if ($scope.showMainSub && $scope.myForm.$valid) {
      $timeout(function () {
        $scope.showMainSub = false;
        $scope.showMain1 = true;
      }, 1000);
    } else {
      $scope.myForm.$setSubmitted();
    }
  };

  // for additional requirement page 
  // options for gender
  $scope.sizes = ["1 bed room", "2 bed room", "3 bed room", "4 bed room", "5 bed room"];


  // options for catering type
  $scope.cateringTypes = ["Up to 5 persons VEG", "Up to 10 persons VEG", "Up to 5 persons NON-VEG", "Up to 10 persons NON-VEG"];


  // // options for laundry type
  $scope.laundryTypes = ["Up to 10 clothes - Normal wash", "Up to 20 clothes - Normal wash", "Up to 10 clothes - Dry wash", "Up to 20 clothes - Dry wash"];

  $scope.saveRoomDetails = function () {
    if ($scope.myForm2.$valid) {
      $http({
        method: 'POST',
        url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php?action=insertBookingDetails',
        data: $scope.room,
        params: {
          id: localStorage.userId
        },
        headers: {
          'Content-Type': 'application/json'
        },
        transformResponse: [function (data) {
          return data;
        }]
      }).then(function (response) {
        if (response.data) {
          // Set the response data in the service
          // roomBookingDataService.setResponseData(JSON.parse(response.data).data);
          localStorage.setItem('responseData', response.data);
          $location.path('/showRooms');
        }
      }).catch(function (error) {
        console.log(error);
      });
    }
  };

  $scope.viewBooking = function () {
    $location.path('/dataTable2');
  };

  $scope.logout = function(){
    $http({
      method: 'GET',
      url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php/logout'
    }).then(function(response){
        $location.path('/login');
    }).catch(function(error){
       console.log(error.data.message);
    })
  }
}]);

// custom service to store the roomBookingData
myApp.service('roomBookingDataService', function () {
  var responseData = JSON.parse(localStorage.getItem('responseData')) || null;

  return {
    getResponseData: function () {
      return responseData;
    },
    setResponseData: function (data) {
      responseData = data;
      // localStorage.setItem('responseData', JSON.stringify(data));
    }
  };
});

// custom filter to validate the name input
// myApp.filter('isAlphabet', function() {
//   return function(input) {
//       if (/^[a-zA-Z]+$/.test(input)) {
//           return false;
//       } else {
//           return true;
//       }
//   };
// });

// custom filter to validate the age
// myApp.filter('ageFilter', function() {
//   return function(input) {
//           if (input >= 18 && input <= 120) {
//               return false;
//           }else{
//             return true;
//           }

//   };
// });

// custom service to validate email
// myApp.service('EmailValidationService', function () {
//   var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

//   // Function to validate an email address
//   this.validateEmail = function (email) {
//       return emailPattern.test(email);
//   };


// });


// custom directive for room size
myApp.directive('myTemplate', function () {
  return {
    restrict: 'E', // This directive is used as an element
    template: `<div class=" d-flex flex-column form1">
      <label for="roomSize" class="form-label">Room Size</label>
      <select class="custom-select select" id="roomSize" name="roomSize" ng-required="true" ng-model="room.selectedRoomSize" ng-style="{'color': room.selectedRoomSize ? 'black' : 'grey'}" apply-error-class>
          <option ng-style="{'color': 'grey'}" value="" disabled hidden>Choose Room Size</option>
          <option ng-style="{'color': 'black'}" ng-repeat="size in sizes">{{ size }}</option>
      </select>
      <span  class="error" ng-show="(myForm2.$submitted || myForm2.roomSize.$touched) && myForm2.roomSize.$error.required">Room size must be choosen.</span>
  </div>`
  };
});

// custom directive to apply error class to input box
myApp.directive('applyErrorClass', function () {
  return {
    restrict: 'A',
    require: '^form',
    link: function (scope, element, attrs, formCtrl) {
      scope.$watch(function () {
        // formCtrl[attrs.name].$setValidity('required', true);
        return (formCtrl.$submitted || formCtrl[attrs.name].$touched) && formCtrl[attrs.name].$error.required;
      }, function (hasError) {
        if (hasError) {
          element.addClass('error-msg');
        } else {
          element.removeClass('error-msg');
        }
        element.on('focus', function () {
          element.removeClass('error-msg');
        });
        element.on('blur', function () {
          if ((formCtrl[attrs.name].$touched) && formCtrl[attrs.name].$error.required) {
            element.addClass('error-msg');
          }
        });
      });
    }
  };
});

// custom directive to validate email
myApp.directive('emailValidator', function () {
  return {
    require: 'ngModel',
    link: function (scope, element, attrs, ngModelCtrl) {
      ngModelCtrl.$parsers.push(function (value) {
        // regular expressions to validate the email pattern
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (emailPattern.test(value)) {
          // If the email is valid, set validity to true
          ngModelCtrl.$setValidity('emailValidator', true);
        } else {
          // If the email is invalid, set validity to false
          ngModelCtrl.$setValidity('emailValidator', false);
        }
        return value;
      });
    }
  };
});

// custom directive to validate age
myApp.directive('ageValidator', function () {
  return {
    require: 'ngModel',
    link: function (scope, element, attrs, ngModelCtrl) {
      ngModelCtrl.$parsers.push(function (value) {
        if (value >= 18 && value <= 120) {
          ngModelCtrl.$setValidity('ageValidator', true);
        } else {
          ngModelCtrl.$setValidity('ageValidator', false);
        }
        return value;
      });
    }
  };
});

// custom directive to validate id number
myApp.directive('idValidator', function () {
  return {
    require: 'ngModel',
    link: function (scope, element, attrs, ngModelCtrl) {
      ngModelCtrl.$parsers.push(function (value) {
        var idPattern = /^[A-Za-z0-9]+$/;
        if (idPattern.test(value)) {
          ngModelCtrl.$setValidity('idValidator', true);
        } else {
          ngModelCtrl.$setValidity('idValidator', false);
        }
        return value;
      });
    }
  };
});

// custom directive to validate checkoutdate
myApp.directive('dateValidator', function () {
  return {
    require: 'ngModel',
    link: function (scope, element, attrs, ngModelCtrl) {
      ngModelCtrl.$parsers.push(function (value) {
        // regular expressions to validate the email pattern
        var checkInDate = scope.$eval(attrs.checkInDate);
        if (value > checkInDate) {
          // If the email is valid, set validity to true
          ngModelCtrl.$setValidity('dateValidator', true);
        } else {
          // If the email is invalid, set validity to false
          ngModelCtrl.$setValidity('dateValidator', false);
        }
        return value;
      });
    }
  };
});

// custom directive to validate checkInDate
//    myApp.directive('checkInDateValidator', function() {
//     return {
//         require: 'ngModel',
//         link: function(scope, element, attrs, ngModelCtrl) {
//             ngModelCtrl.$parsers.push(function(value) {
//                 // Transform the input value to a Date object
//                 var selectedDate = new Date(value);
//                 var today = new Date();
//                 today.setHours(0, 0, 0, 0); // Set hours to 0 for accurate date comparison

//                 // Check if the selected date is today or in the future
//                 if (selectedDate < today) {
//                     ngModelCtrl.$setValidity('checkInDateValidator', false);
//                 } else {
//                     ngModelCtrl.$setValidity('checkInDateValidator', true);
//                 }
//                 return value;
//             });
//         }
//     };
// });


