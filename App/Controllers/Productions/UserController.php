<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 2:59 PM
 */

namespace App\Controllers\Productions;

use App\Controllers\UserControllerInterface;
use App\Models\LogModel;
use App\Models\UserModel;
use App\Models\WalletModel;

class UserController implements UserControllerInterface
{
    /**
     * Create new User
     *
     * @params  json    $userInfo with escape data
     *                  ex: {\"id\":\"1\"\,\"name\":\"thanhnt\"}
     * @return  model   User
     * */
    public function create($userInfo)
    {
        $data = json_decode($userInfo, true);
        $userModel = new UserModel();

        if( !isset($data['id']) || !isset($data['name']) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $response = $userModel->create($data);

        echo $response['message'];
    }

    /**
     * List all account of User, include both virtual & real currency
     *
     * @params  int     $userId
     * @return  array
     * */
    public function getAllAccount($userId)
    {
        if( !isset($userId) ) {
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
        $wallets = $walletModel->getByUserId($userId);
        if( $wallets['code'] != 200 ) {
            echo $wallets['message'];
            return;
        }

        echo "User with id: $userId has total " . count(json_decode($wallets['data'], true)) . " account: \n";
        print_r($wallets['data'] . PHP_EOL);
    }

    /**
     * Set customer's top up limit (per day)
     *
     * @params  int     $userId
     *          int     $amount
     * @return  boolean
     * */
    public function setDepositLimit($userId, $amount)
    {
        if( !isset($userId) || !isset($amount) || !is_numeric($amount) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        if( $user['code'] != 200 ) {
            echo $user['message'];
            return;
        }

        $user = $userModel->update(
            $user['data'],
            [
                'deposit_limit' => $amount
            ]
        );

        echo "Successfully to set Deposit limit = $amount for user with id = $userId \n";

        $logModel = new LogModel();
        $logModel->create("User Id $userId change deposit limit to $amount");
        
        return;
    }

    /**
     * Set customer's withdrawal limit (per day)
     *
     * @params  int     $userId
     *          int     $amount
     * @return  boolean
     * */
    public function setWithdrawalLimit($userId, $amount)
    {
        if( !isset($userId) || !isset($amount) || !is_numeric($amount) ) {
            echo "Error, Parameters is invalid \n";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        if( $user['code'] != 200 ) {
            echo $user['message'];
            return;
        }

        $user = $userModel->update(
            $user['data'],
            [
                'withdrawal_limit' => $amount
            ]
        );

        echo "Successfully to set Withdrawal limit = $amount for user with id = $userId \n";

        $logModel = new LogModel();
        $logModel->create("User Id $userId change withdrawal limit to $amount");

        return;
    }
}