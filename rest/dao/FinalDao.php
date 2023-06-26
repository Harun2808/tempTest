<?php
require_once "BaseDao.php";

class FinalDao extends BaseDao {

    public function __construct(){
        parent::__construct();
    }

    public function login($email, $password){
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $result = $this->fetchSingleResult($query, [$email, $password]);

        if ($result) {
            return "Login successful";
        } else {
            return "Invalid email or password";
        }
    }

    public function investor($firstName, $lastName, $email, $company, $shareClassId, $shareClassCategoryId, $dilutedShares){
        $query = "INSERT INTO investors (first_name, last_name, email, company) 
                  VALUES (?, ?, ?, ?)";
        $this->executeQuery($query, [$firstName, $lastName, $email, $company]);

        return "Investor added successfully";
    }

    public function share_classes(){
        $query = "SELECT * FROM share_classes";
        $result = $this->fetchAllResults($query);

        return $result;
    }

    public function share_class_categories(){
        $query = "SELECT * FROM share_class_categories";
        $result = $this->fetchAllResults($query);

        return $result;
    }

}

?>
