<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 2:13 PM
 */

namespace App\Controllers\Productions;

use App\Controllers\WalletControllerInterface;
use App\Models\LogModel;
use App\Models\UserModel;
use App\Models\WalletModel;

class WalletController implements WalletControllerInterface
{
    /**
     * Create new account with any currency
     *
     * @params  int     $userId
     *          string  $currency
     * @return  model   Account
     * */
    public function createNewAccount($userId, $currency)
    {
        if( !isset($userId) || !isset($currency) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        if( $user['code'] != 200 ) {
            echo $user['message'];
            return;
        }

        $walletModel = new WalletModel();
        $check = $walletModel->findByUserIdAndCurrency($userId, $currency);
        if( $check['code'] == 200 ) {
            echo "Error, User already has account with currency '$currency' \n";
            return;
        }

        $response = $walletModel->create(
            [
                'user_id'  => $userId,
                'currency' => $currency
            ]
        );

        echo $response['message'];

        $logModel = new LogModel();
        $logModel->create("User Id $userId create new account " . json_decode($response['data'], true)['id']);
    }

    /**
     * Set default account for each User
     *
     * @params  int     $userId
     *          int     $accountId
     * @return  boolean
     * */
    public function setDefaultAccount($userId, $accountId)
    {
        if( !isset($userId) || !isset($accountId) || !is_numeric($accountId) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        if( $user['code'] != 200 ) {
            echo $user['message'];
            return;
        }

        $walletModel = new WalletModel();
        $wallet = $walletModel->findById($accountId);
        if( $wallet['code'] != 200 ) {
            echo $wallet['message'];
            return;
        }
        if( json_decode($wallet['data'], true)['currency'] == WalletModel::CURRENCY_VIRTUAL ) {
            echo "Error, Cannot set default account with Virtual Currency \n";
            return;
        }
        $response = $walletModel->update(
            $wallet['data'],
            [
                'is_default' => 1
            ]
        );

        echo "Successfully to set Default account with currency '" . json_decode($wallet['data'], true)['currency'] . "' for user id = $userId \n";

        $logModel = new LogModel();
        $logModel->create("User Id $userId set account with id = $accountId to default");

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
        if( !isset($userId) || !isset($accountId) || !is_numeric($accountId) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        if( $user['code'] != 200 ) {
            echo $user['message'];
            return;
        }

        $walletModel = new WalletModel();
        $wallet = $walletModel->findById($accountId);
        if( $wallet['code'] != 200 ) {
            echo $wallet['message'];
            return;
        }
        if( json_decode($wallet['data'], true)['currency'] == WalletModel::CURRENCY_VIRTUAL ) {
            echo "Error, Cannot Freeze account with Virtual Currency \n";
            return;
        }
        $response = $walletModel->update(
            $wallet['data'],
            [
                'is_default' => 1
            ]
        );

        echo "Successfully to Freeze account with currency '" . json_decode($wallet['data'], true)['currency'] . "' for user id = $userId \n";

        $logModel = new LogModel();
        $logModel->create("User Id $userId freeze account with id = $accountId");

        return;
    }

    /**
     * Deposit
     *
     * @params  int     $userId
     *          int     $accountId
     *          int     $amount
     * @return  boolean
     * */
    public function deposit($userId, $accountId, $amount)
    {
        if( !isset($userId) || !isset($accountId) || !is_numeric($accountId) || !isset($amount) || !is_numeric($amount) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        if( $user['code'] != 200 ) {
            echo $user['message'];
            return;
        }
        $user = json_decode($user['data'], true);
        if( $user['deposit_limit'] < $amount ) {
            echo "Sorry, Your deposit limit per day is " . $user['deposit_limit'] . " \n";
            return;
        }

        $walletModel = new WalletModel();
        $wallet = $walletModel->findById($accountId);
        if( $wallet['code'] != 200 ) {
            echo $wallet['message'];
            return;
        }
        $wallet = json_decode($wallet['data'], true);

        $response = $walletModel->update(
            json_encode($wallet),
            [
                'amount' => ($wallet['amount'] + $amount)
            ]
        );

        echo "Successfully to Deposit $amount " . $wallet['currency'] . " to Account $accountId \n";
        echo "Current balance: " . json_decode($response['data'], true)['amount'] . ' ' . json_decode($response['data'], true)['currency'] . " \n";

        $logModel = new LogModel();
        $logModel->create("User Id $userId deposit $amount to account with id = $accountId");

        return;
    }

    /**
     * Withdrawal
     *
     * @params  int     $userId
     *          int     $accountId
     *          int     $amount
     * @return  boolean
     * */
    public function withdrawal($userId, $accountId, $amount)
    {
        if( !isset($userId) || !isset($accountId) || !is_numeric($accountId) || !isset($amount) || !is_numeric($amount) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        if( $user['code'] != 200 ) {
            echo $user['message'];
            return;
        }
        $user = json_decode($user['data'], true);
        if( $user['withdrawal_limit'] < $amount ) {
            echo "Sorry, Your withdrawal limit per day is " . $user['withdrawal_limit'] . " \n";
            return;
        }

        $walletModel = new WalletModel();
        $wallet = $walletModel->findById($accountId);
        if( $wallet['code'] != 200 ) {
            echo $wallet['message'];
            return;
        }
        $wallet = json_decode($wallet['data'], true);
        if( $wallet['amount'] < $amount ) {
            echo "Sorry, Cannot withdrawal. Your current amount = " . $wallet['amount'] . ' ' . $wallet['currency'] . " \n";
            return;
        }

        $response = $walletModel->update(
            json_encode($wallet),
            [
                'amount' => ($wallet['amount'] - $amount)
            ]
        );

        echo "Successfully to Withdrawal $amount " . $wallet['currency'] . " from Account $accountId \n";
        echo "Current balance: " . json_decode($response['data'], true)['amount'] . ' ' . json_decode($response['data'], true)['currency'] . " \n";

        $logModel = new LogModel();
        $logModel->create("User Id $userId withdrawal $amount from account with id = $accountId");

        return;
    }

    /**
     * Transfer balance between accounts
     *
     * @params  int     $accountSenderId
     *          int     $accountReceiverId
     *          int     $amount
     * @return  boolean
     * */
    public function transfer($userId, $accountSenderId, $accountReceiverId, $amount)
    {
        if( !isset($userId) || !isset($accountSenderId) || !is_numeric($accountSenderId) || !isset($accountReceiverId) || !is_numeric($accountReceiverId) || !isset($amount) || !is_numeric($amount) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        if( $user['code'] != 200 ) {
            echo $user['message'];
            return;
        }
        $user = json_decode($user['data'], true);

        $walletModel = new WalletModel();
        $walletSender = $walletModel->findById($accountSenderId);
        if( $walletSender['code'] != 200 ) {
            echo $walletSender['message'];
            return;
        }
        $walletSender = json_decode($walletSender['data'], true);

        if( $walletSender['user_id'] != $user['id'] ) {
            echo "Sorry, User id $userId is not owner of account $accountSenderId\n";
        }

        $walletReceiver = $walletModel->findById($accountReceiverId);
        if( $walletReceiver['code'] != 200 ) {
            echo $walletReceiver['message'];
            return;
        }
        $walletReceiver = json_decode($walletReceiver['data'], true);

        if( $walletSender['currency'] != $walletReceiver['currency'] ) {
            echo "Sorry, Cannot transfer between 2 account with different currency \n";
        }

        if( $walletSender['amount'] < $amount ) {
            echo "Sorry, Cannot transfer. Your current amount = " . $walletSender['amount'] . ' ' . $walletSender['currency'] . " \n";
            return;
        }

        $sender = $walletModel->update(
            json_encode($walletSender),
            [
                'amount' => ($walletSender['amount'] - $amount)
            ]
        );
        $sender = json_decode($sender['data'], true);

        $receiver = $walletModel->update(
            json_encode($walletReceiver),
            [
                'amount' => ($walletReceiver['amount'] + $amount)
            ]
        );
        $receiver = json_decode($receiver['data'], true);

        echo "Successfully to transfer $amount " . $sender['currency'] . " from Account $accountSenderId to $accountReceiverId \n";
        echo "Current balance of Account $accountSenderId: " . $sender['amount'] . ' ' . $sender['currency'] . " \n";
        echo "Current balance of Account $accountReceiverId: " . $receiver['amount'] . ' ' . $receiver['currency'] . " \n";

        $logModel = new LogModel();
        $logModel->create("User Id $userId transfer $amount " . $sender['currency'] . " from account_id = $accountSenderId to account_id = $accountReceiverId");
        
        return;
    }
}