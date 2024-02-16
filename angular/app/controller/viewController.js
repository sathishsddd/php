myApp.controller('ViewController',['$scope','$routeParams','$http', function($scope, $routeParams,$http) {
    
// Retrieve the path parameters
var paramValue = $routeParams.param; // param is the name of the path parameter

// Parse the JSON string back into an object
$scope.insertedData = JSON.parse(decodeURIComponent(paramValue));

$scope.generatePdf = function(userDetails){
    console.log(userDetails);
    const userDetailsHTML = `
    <div style="text-align: center;">
        <h1 style="color:#009A61">User Registration Details</h1>
    </div>
    <div
        <p><strong>Name:</strong> ${userDetails.user_name}</p>
        <p><strong>Email:</strong> ${userDetails.email}</p>
        <p><strong>Phone Number:</strong> ${userDetails.phone_number}</p>
        <p><strong>Password:</strong> ${userDetails.password}</p>
        <p><strong>Re-Password:</strong> ${userDetails.re_password}</p>
    </div>
`;
$http({
    method: 'POST',
    url: 'http://localhost/Mystudio_webapp/angular/API/Service/generatePdf.php',
    data: userDetailsHTML,
    responseType: 'blob',   
    headers: { 'Content-Type': 'text/html' },
}).then(function(response){
    // const blob = new Blob([response.data], { type: 'application/pdf' });
        const url = URL.createObjectURL(response.data);

        // Open the PDF in a new tab
        window.open(url,'_blank');
}).catch(function(error){
        console.log(error);
});
}

}]);