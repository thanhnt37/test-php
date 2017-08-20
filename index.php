<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 1:29 PM
 */

// position [0] is the script's file name
array_shift($argv);
$routeName = array_shift($argv);

include_once 'App/Models/BaseModel.php';
include_once 'App/Models/UserModel.php';
include_once 'App/Models/WalletModel.php';
include_once 'App/Controllers/UserControllerInterface.php';
include_once 'App/Controllers/Productions/UserController.php';
include_once 'App/Controllers/WalletControllerInterface.php';
include_once 'App/Controllers/Productions/WalletController.php';
include_once 'App/Controllers/RealCurrencyControllerInterface.php';
include_once 'App/Controllers/Productions/RealCurrencyController.php';
include_once 'App/Controllers/VirtualCurrencyControllerInterface.php';
include_once 'App/Controllers/Productions/VirtualCurrencyController.php';

$routes = [
    'createNewUser'   => [
        'App\Controllers\Productions\UserController',
        'create'
    ],
    'getAllAccount'   => [
        'App\Controllers\Productions\UserController',
        'getAllAccount'
    ],
    'setDepositLimit'   => [
        'App\Controllers\Productions\UserController',
        'setDepositLimit'
    ],
    'setWithdrawalLimit'   => [
        'App\Controllers\Productions\UserController',
        'setWithdrawalLimit'
    ],
    'createNewAccount'   => [
        'App\Controllers\Productions\WalletController',
        'createNewAccount'
    ],
    'setDefaultAccount'   => [
        'App\Controllers\Productions\WalletController',
        'setDefaultAccount'
    ],
    'freezeAccount'   => [
        'App\Controllers\Productions\WalletController',
        'freezeAccount'
    ],
    'deposit'   => [
        'App\Controllers\Productions\WalletController',
        'deposit'
    ],
    'withdrawal'   => [
        'App\Controllers\Productions\WalletController',
        'withdrawal'
    ],
    'transfer'   => [
        'App\Controllers\Productions\WalletController',
        'transfer'
    ],
];

@call_user_func_array([$routes[$routeName][0], $routes[$routeName][1]], $argv);