<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 4:59 PM
 */

namespace App\Models;

class WalletModel extends BaseModel
{
    const CURRENCY_VIRTUAL  = 'virtual';
    const CURRENCY_USD      = 'usd';
    const CURRENCY_EUR      = 'eur';

    protected $file = 'data/wallets.txt';

    public function create($data)
    {
        if (!file_exists('data')) {
            mkdir('data', 0777, true);
        }
        if( !file_exists($this->file) ) {
            $file = fopen($this->file, "w");
            fclose($file);
        }

        $model['id']         = rand(1, 99999);
        $model['user_id']    = $data['user_id'];
        $model['currency']   = $data['currency'];
        $model['amount']     = 0;
        $model['is_frozen']  = 0;
        $model['is_default'] = 0;

        file_put_contents($this->file, json_encode($model).PHP_EOL , FILE_APPEND);

        return ['code' => 200, 'message' => "Successfully to create new Wallet account \n", 'data' => json_encode($model)];
    }

    public function findByUserIdAndCurrency($userId, $currency)
    {
        if( !file_exists($this->file) ) {
            return ['code' => 204, 'message' => "Sorry, No data matching \n", 'data' => null];
        }

        $lines   = file($this->file, FILE_IGNORE_NEW_LINES);
        foreach ( $lines as $line ) {
            $model = json_decode($line, true);
            if( ($model['user_id'] == $userId) && ($model['currency'] == $currency) ) {
                return ['code' => 200, 'message' => "Successfully \n", 'data' => json_encode($model)];
            }
        }

        return ['code' => 204, 'message' => "Sorry, No data matching \n", 'data' => null];
    }
}