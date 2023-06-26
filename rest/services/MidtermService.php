<?php
require_once __DIR__."/../dao/MidtermDao.php";

class MidtermService {
    protected $dao;

    public function __construct(){
        $this->dao = new MidtermDao();
    }

    public function investor($firstName, $lastName, $email, $company, $shareClassId, $shareClassCategoryId, $dilutedShares){
        return $this->dao->addInvestor($firstName, $lastName, $email, $company, $shareClassId, $shareClassCategoryId, $dilutedShares);
    }

    public function investor_email($email){
        return $this->dao->validateInvestorEmail($email);
    }

    public function investors(){
        return $this->dao->getInvestors();
    }
}

?>
