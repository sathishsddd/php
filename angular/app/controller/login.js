myApp.controller('loginCtrl', ['$scope', 'EmailValidationService', '$timeout', '$location', '$http', function ($scope, EmailValidationService, $timeout, $location, $http) {
    // localStorage.clear();
    $scope.showError = true;
    $scope.showError2 = true;

    $scope.user = {
        userName: "",
        email: "",
        phoneNumber: "",
        password: "",
        rePassword: "",
        userType: "Owner"
    }
    $scope.login = {
        userName: "",
        password: "",
        userType: "Owner"
    }

    // function to clear forms
    $scope.clearRegFormFields = function () {
        $scope.user.userName = '';
        $scope.user.email = '';
        $scope.user.phoneNumber = '';
        $scope.user.password = '';
        $scope.user.rePassword = '';
    };
    $scope.clearLoginFormFields = function () {
        $scope.login.userName = '';
        $scope.login.password = '';
    };



    // to validate the email field
    $scope.user.email = ''; // Initialize the email field
    $scope.validateEmail = function () {
        if (!EmailValidationService.validateEmail($scope.user.email)) {
            $scope.validationMessage = 'Invalid email address.';
            $scope.myForm2.$valid = false;
        } else {
            $scope.validationMessage = '';
        }
        if (!$scope.user.email) {
            $scope.validationMessage = '';
        }
    };

    // function to validate password in register form
    $scope.validatePassword = function () {
        // console.log()
        if ($scope.user.password) {
            if ($scope.user.password == $scope.user.rePassword) {
                $scope.validationMessage2 = '';
                $scope.myForm2.password2.$setValidity('customValidation', true);
            } else {
                $scope.validationMessage2 = 'Password does not match.';
                $scope.myForm2.password2.$setValidity('customValidation', false);
            }
        }
        else {
            $scope.validationMessage2 = '';
        }
    };

    // to find the user type for register form
    $scope.toggleUser = function (userType) {
        $scope.user.userType = userType;
    };

    // // to validate register form after submit
    $scope.validateInputs = function () {
        $scope.validatePassword();
        const selectedRole = $scope.user.userType;
        const username = $scope.user.userName;
        if ($scope.myForm2.$valid) {
            console.log(1);
            $http({
                method: 'POST',
                url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php?action=insertUser',
                data: $scope.user,
                headers: {
                    'Content-Type': 'application/json'
                },
                // In AngularJS's $http service, the transformResponse property is used to specify an array 
                // of functions that will be applied to the raw response data before it is resolved in the promise. 
                // The default transformation function used by AngularJS is a function that parses the JSON data.
                // if the data returned from response is not proper json than it will throw bad data error,so
                // we overriding the transform response to return the actual data.
                transformResponse: [function (data) {
                    return data;
                }]
            }).then(function (response) {
                if (response.data) {
                    $scope.clearRegFormFields();
                    $scope.showError = "false";
                    var url = '/view/' + encodeURIComponent(response.data);
                    $location.path(url);
                    //   const signInMessage = `${selectedRole} - ${username} signed in`;
                    //   $('#signInModalMessage').text(signInMessage);
                    //   $('#signInModal').modal('show');
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
        else {
            $scope.myForm2.$submitted = true;
            $scope.showError = true;
        }
    };

    //function to rediect to login page(button in popup)
    $scope.redirectToLoginPage = function () {
        $('.modal-backdrop').remove();
        $location.path('/login');
    };
    // to find the user type for login form
    $scope.toggleUser2 = function (userType) {
        $scope.login.userType = userType;
    };

    // to validate login form after submit
    $scope.validateInput = function () {
        if ($scope.myForm3.$valid) {
            const username = $scope.login.userName;
            const selectedRole = $scope.login.userType;
            $http({
                method: 'POST',
                url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php?action=login',
                data: $scope.login,
                headers: {
                    'Content-Type': 'application/json'
                },
                transformResponse: [function (data) {
                    return data;
                }]
            }).then(function (response) {
                if (response.data) {
                    $scope.clearLoginFormFields();
                    $scope.showError = "false";
                    const signInMessage = `${selectedRole} - ${username} signed in`;
                    $('#signInModalMessage').text(signInMessage);
                    $('#signInModal').modal('show');
                    localStorage.userId = JSON.parse(response.data).data.id;
                    if (selectedRole == 'Owner') {
                        $timeout(function () {
                            $('.modal-backdrop').remove();
                            $location.path('/room2');
                        }, 2000);
                    } else {
                        $timeout(function () {
                            $('.modal-backdrop').remove();
                            $location.path('/room');
                        }, 2000);
                    }
                }
            }).catch(function (error) {
                var response = JSON.parse(error.data);
                alert(response.message);
            });
        } else {
            $scope.showError = true;
            $scope.showError2 = true;
            $scope.myForm3.$submitted = true;
        }
    };

    $scope.checkUserName = function () {
        if ($scope.user.userName) {
            console.log("inside");
            $http({
                method: 'GET',
                url: 'http://localhost/Mystudio_webapp/angular/API/Controller/controller.php/getCustomerByName',
                params: {
                    userName: $scope.user.userName,
                    role: $scope.user.userType
                }
            }).then(function (response) {
                if (response.data.data) {
                    $scope.myForm2.name.$setValidity('uniqueUsername', false);
                    // alert("user already exist");
                } else {
                    $scope.myForm2.name.$setValidity('uniqueUsername', true);
                    console.log("username available");
                }
            })
        } else {
            $scope.myForm2.name.$setValidity('uniqueUsername', true);
            console.log("invalid");
        }
    }

    // Initialize a property to track the active button
    $scope.activeButton = 'button1';

    // Function to toggle the active button and clear form fields(login form)
    $scope.toggleButton = function (buttonId) {
        $scope.activeButton = buttonId;
        $scope.clearLoginFormFields();
    };

    // Initialize a property to track the active button
    $scope.activeButton2 = 'button3';

    // Function to toggle the active button and clear form fields(reg form)
    $scope.toggleButton2 = function (buttonId) {
        $scope.activeButton2 = buttonId;
        $scope.clearRegFormFields();
    };


    // to handle errors in button toggling
    $scope.toggleError = function () {
        $scope.showError = false;
        $scope.showError2 = false;
        $scope.validationMessage = '';
        $scope.validationMessage2 = ''
    };

    // again need to show error in the field with error values
    $scope.$watch('user.userName', function (newValue) {
        if (newValue) {
            $scope.showError2 = true;
        }
    });
    $scope.$watch('login.userName', function (newValue) {
        if (newValue) {
            $scope.showError2 = true;
        }
    });

}]);


// custom filter to validate the name input
myApp.filter('isAlphabet', function () {
    return function (input) {
        if (/^[a-zA-Z]+$/.test(input)) {
            return true;
        } else {
            return false;
        }
    };
});

// custom service to validate email
myApp.service('EmailValidationService', function () {
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    // Function to validate an email address
    this.validateEmail = function (email) {
        return emailPattern.test(email);
    };
});

