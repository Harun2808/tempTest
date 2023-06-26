<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getUserFromDatabase($email, $password) {
    $servername = 'localhost';
    $username = 'your_username';
    $password = 'your_password';
    $database = 'midterm-2023';

    $conn = new mysqli($servername, $username, $password, $database);

=    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ? AND password = ?');
    $stmt->bind_param('ss', $email, $password);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        return $user;
    } else {
        $stmt->close();
        $conn->close();

        return null;
    }
}

Flight::route('GET /final/connection-check', function(){
    /** TODO
    * This endpoint prints the message from constructor within MidtermDao class
    * Goal is to check whether connection is successfully established or not
    * This endpoint does not have to return output in JSON format
    */
    $dao = new MidtermDao();
    echo "Connection successfully established!";
});

Flight::route('GET /final/login', function(){
    /** TODO
    * This endpoint is used to login user to system
    * you can use email: demo.user@gmail.com and password: 123 to login
    * Output should be array containing success message and JWT for this user
    * Sample output is given in figure 7
    * This endpoint should return output in JSON format
    */
    $email = Flight::request()->query['email'];
    $password = Flight::request()->query['password'];

    // Check if the email and password match the user in the database
    $user = getUserFromDatabase($email, $password);

    if ($user !== null) {
        // Generate JWT token
        $key = Key::loadFromFilePath('path/to/private/key.pem');
        $payload = array(
            'user_id' => $user['id'],
            'email' => $user['email']
            // Add more data to the payload if needed
        );
        $jwt = JWT::encode($payload, $key, 'RS256');

        $response = array(
            'message' => 'Login successful',
            'jwt' => $jwt
        );
    } else {
        $response = array(
            'message' => 'Invalid email or password'
        );
    }

    Flight::json($response);
});

Flight::route('POST /final/investor', function(){
    $servername = 'localhost';
    $username = 'your_username';
    $password = 'your_password';
    $database = 'midterm-2023';

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $data = Flight::request()->data;

    $firstName = $data['first_name'];
    $lastName = $data['last_name'];
    $email = $data['email'];
    $company = $data['company'];

    $insertInvestorSql = 'INSERT INTO investors (first_name, last_name, email, company, created_at) VALUES (?, ?, ?, ?, NOW())';

    $insertCapTableSql = 'INSERT INTO cap_table (share_class_id, share_class_category_id, investor_id, diluted_shares) VALUES (?, ?, ?, ?)';

    $conn->begin_transaction();

    $error = '';

    try {
        $stmt = $conn->prepare($insertInvestorSql);
        $stmt->bind_param('ssss', $firstName, $lastName, $email, $company);
        $stmt->execute();
        $stmt->close();

        $investorId = $conn->insert_id;

        $stmt = $conn->prepare($insertCapTableSql);
        $stmt->bind_param('iiid', $shareClassId, $shareClassCategoryId, $investorId, $dilutedShares);

        foreach ($data['cap_table'] as $capTableData) {
            $shareClassId = $capTableData['share_class_id'];
            $shareClassCategoryId = $capTableData['share_class_category_id'];
            $dilutedShares = $capTableData['diluted_shares'];

            $stmt->execute();
        }

        $stmt->close();

        $conn->commit();

        $message = 'Investor created successfully.';
    } catch (Exception $e) {
        $conn->rollback();

        $message = 'Error creating investor: ' . $e->getMessage();
    }

    $conn->close();

    $response = [
        'message' => $message
    ];

    Flight::json($response);
});


Flight::route('GET /final/share_classes', function(){
    /** TODO
    * This endpoint is used to list all share classes from share_classes table
    * This endpoint should return output in JSON format
    */
    $servername = 'localhost';
    $username = 'your_username';
    $password = 'your_password';
    $database = 'midterm-2023';

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $selectShareClassesSql = 'SELECT * FROM share_classes';

    $result = $conn->query($selectShareClassesSql);

    $shareClasses = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $shareClasses[] = $row;
        }
    }

    $result->close();

    $conn->close();

    $response = [
        'share_classes' => $shareClasses
    ];

    Flight::json($response);
});

Flight::route('GET /final/share_class_categories', function(){
    /** TODO
    * This endpoint is used to list all share class categories from share_class_categories table
    * This endpoint should return output in JSON format
    */
    $servername = 'localhost';
    $username = 'your_username';
    $password = 'your_password';
    $database = 'midterm-2023';

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $selectCategoriesSql = 'SELECT * FROM share_class_categories';

    $result = $conn->query($selectCategoriesSql);

    $categories = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    $result->close();

    $conn->close();

    $response = [
        'share_class_categories' => $categories
    ];

    Flight::json($response);
});
?>
