<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 2:13 PM
 */

namespace App\Controllers;

interface WalletControllerInterface
{
    /**
     * Create new account with any currency
     *
     * @params  int     $userId
     *          string  $currency
     * @return  model   Account
     * */
    public function createNewAccount($userId, $currency);

    /**
     * Set default account for each User
     *
     * @params  int     $userId
     *          int     $accountId
     * @return  boolean
     * */
    public function setDefaultAccount($userId, $accountId);

    /**
     * Freeze account
     *
     * @params  int     $userId
     *          int     $accountId
     * @return  boolean
     * */
    public function freezeAccount($userId, $accountId);

    /**
     * Deposit
     *
     * @params  int     $userId
     *          int     $accountId
     *          int     $amount
     * @return  boolean
     * */
    public function deposit($userId, $accountId, $amount);

    /**
     * Withdrawal
     *
     * @params  int     $userId
     *          int     $accountId
     *          int     $amount
     * @return  boolean
     * */
    public function withdrawal($userId, $accountId, $amount);

    /**
     * Transfer balance between accounts
     *
     * @params  int     $accountSenderId
     *          int     $accountReceiverId
     *          int     $amount
     * @return  boolean
     * */
    public function transfer($accountSenderId, $accountReceiverId, $amount);
}