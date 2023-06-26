<?php

Flight::route('GET /midterm/connection-check', function(){
    $dao = new MidtermDao();
    $message = $dao->getConnectionMessage();
    echo $message;
});

Flight::route('POST /midterm/investor', function(){
    $service = new MidtermService();

    $firstName = Flight::request()->data['first_name'];
    $lastName = Flight::request()->data['last_name'];
    $email = Flight::request()->data['email'];
    $company = Flight::request()->data['company'];
    $shareClassId = Flight::request()->data['share_class_id'];
    $shareClassCategoryId = Flight::request()->data['share_class_category_id'];
    $dilutedShares = Flight::request()->data['diluted_shares'];

    $result = $service->investor($firstName, $lastName, $email, $company, $shareClassId, $shareClassCategoryId, $dilutedShares);

    Flight::json(['message' => $result]);
});

Flight::route('GET /midterm/investor_email/@email', function($email){
    $service = new MidtermService();
    $result = $service->investor_email($email);

    Flight::json(['message' => $result]);
});

Flight::route("GET /midterm/investor/@share_class_id", function($share_class_id){
    $service = new MidtermService();
    $result = $service->investors($share_class_id);

    Flight::json($result);
});


?>
