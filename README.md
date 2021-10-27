// Admin Login   ///POST

localhost:8000/api/user/login

// User Dashboard  ///POST

localhost:8000/api/user/dashboard

// Employee Login   ///POST

localhost:8000/api/admin/login

// Employee Dashboard  ///POST

localhost:8000/api/employee/dashboard

make sure in details api we will use following headers as listed bellow:
'headers' => [
    'Accept' => 'application/json',
    'Authorization' => 'Bearer '.$accessToken,
]
