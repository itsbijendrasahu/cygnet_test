// Admin Login   ///POST

localhost:8000/api/user/login

// User Dashboard  ///POST

localhost:8000/api/user/dashboard

// Employee Login   ///POST

localhost:8000/api/employee/login

// Employee Dashboard  ///POST

localhost:8000/api/employee/dashboard

make sure in details api we will use following headers as listed below:

'headers' => [
    'Accept' => 'application/json',
    'Authorization' => 'Bearer '.$accessToken,
]
