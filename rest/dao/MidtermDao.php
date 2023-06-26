<?php
require_once "BaseDao.php";

class MidtermDao extends BaseDao {

    public function __construct(){
        parent::__construct();
    }

    public function investor($firstName, $lastName, $email, $company, $shareClassId, $shareClassCategoryId, $dilutedShares){
        $query = "INSERT INTO investors (first_name, last_name, email, company) 
                  VALUES (?, ?, ?, ?)";
        $this->executeQuery($query, [$firstName, $lastName, $email, $company]);

        return "Investor added successfully";
    }

    public function investor_email($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format";
        }

        $query = "SELECT * FROM investors WHERE email = ?";
        $result = $this->fetchSingleResult($query, [$email]);

        if ($result) {
            $message = "Investor {$result['first_name']} {$result['last_name']} uses this email address";
        } else {
            $message = "Investor with this email does not exist in the database";
        }

        return $message;
    }

    public function investors($shareClassId){
        $query = "SELECT * FROM investors 
                  INNER JOIN cap_table ON investors.id = cap_table.investor_id
                  WHERE cap_table.share_class_id = ?";
        $result = $this->fetchAllResults($query, [$shareClassId]);

        return $result;
    }

}

?>
