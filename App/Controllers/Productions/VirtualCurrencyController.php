<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 2:19 PM
 */

namespace App\Controllers\Productions;

use App\Controllers\VirtualCurrencyControllerInterface;

class VirtualCurrencyController extends WalletController implements VirtualCurrencyControllerInterface
{

    /**
     * Set default account for each User
     *
     * @params  int     $userId
     *          int     $accountId
     * @return  boolean
     * */
    public function setDefaultAccount($userId, $accountId)
    {
        echo "Error, Cannot set default account with Virtual Currency \n";
        return;
    }

    /**
     * Freeze account
     *
     * @params  int     $userId
     *          int     $accountId
     * @return  boolean
     * */
    public function freezeAccount($userId, $accountId)
    {
        echo "Error, Cannot Freeze account with Virtual Currency \n";
        return;
    }
}