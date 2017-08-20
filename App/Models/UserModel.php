<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 4:59 PM
 */

namespace App\Models;

class UserModel extends BaseModel
{
    const DEFAULT_DEPOSIT_LIMIT     = 100;
    const DEFAULT_WITHDRAWAL_LIMIT  = 100;

    protected $file = 'data/users.txt';

    public function create($data)
    {
        if (!file_exists('data')) {
            mkdir('data', 0777, true);
        }
        if( !file_exists($this->file) ) {
            $file = fopen($this->file, "w");
            fclose($file);
        }

        $lines = file($this->file, FILE_IGNORE_NEW_LINES);
        foreach ( $lines as $line ) {
            $user = json_decode($line, true);
            if( $data['id'] == $user['id'] ) {
                return ['code' => 422, 'message' => "Error, User already exist \n", 'data' => null];
            }
        }

        $data['deposit_limit']      = UserModel::DEFAULT_DEPOSIT_LIMIT;
        $data['withdrawal_limit']   = UserModel::DEFAULT_DEPOSIT_LIMIT;

        file_put_contents($this->file, json_encode($data).PHP_EOL , FILE_APPEND);

        return ['code' => 200, 'message' => "Successfully to create new User \n", 'data' => json_encode($data)];
    }

}