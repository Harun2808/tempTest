<?php
require_once __DIR__."/../dao/FinalDao.php";

class FinalService {
    protected $dao;

    public function __construct(){
        $this->dao = new FinalDao();
    }

    public function login($email, $password){
        return $this->dao->loginUser($email, $password);
    }

    public function investor($firstName, $lastName, $email, $company, $shareClassId, $shareClassCategoryId, $dilutedShares){
        return $this->dao->addInvestor($firstName, $lastName, $email, $company, $shareClassId, $shareClassCategoryId, $dilutedShares);
    }

    public function share_classes(){
        return $this->dao->getAllShareClasses();
    }

    public function share_class_categories(){
        return $this->dao->getAllShareClassCategories();
    }
}

?>
