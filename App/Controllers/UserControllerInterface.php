<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 2:02 PM
 */

namespace App\Controllers;

interface UserControllerInterface
{
    /**
     * Create new User
     *
     * @params  json    $userInfo with escape data
     * @return  model   User
     * */
    public function create($userInfo);

    /**
     * List all account of User, include both virtual & real currency
     *
     * @params  int     $userId
     * @return  array
     * */
    public function getAllAccount($userId);

    /**
     * Set customer's top up limit (per day)
     *
     * @params  int     $userId
     *          int     $amount
     * @return  boolean
     * */
    public function setDepositLimit($userId, $amount);

    /**
     * Set customer's withdrawal limit (per day)
     *
     * @params  int     $userId
     *          int     $amount
     * @return  boolean
     * */
    public function setWithdrawalLimit($userId, $amount);
}