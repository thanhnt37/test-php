<?php
/**
 * Created by PhpStorm.
 * User: thanhnt
 * Date: 8/20/17
 * Time: 9:20 PM
 */

namespace App\Models;

class BaseModel
{
    protected $file = '';

    /**
     * Find by id
     *
     * @params  int     $id
     * @return  Model   $model
     * */
    public function findById($id)
    {
        if( !file_exists($this->file) ) {
            return ['code' => 204, 'message' => "Sorry, No data matching \n", 'data' => null];
        }

        $lines = file($this->file, FILE_IGNORE_NEW_LINES);
        foreach ( $lines as $line ) {
            $model = json_decode($line, true);
            if( $model['id'] == $id ) {
                return ['code' => 200, 'message' => "Successfully \n", 'data' => json_encode($model)];
            }
        }

        return ['code' => 204, 'message' => "Sorry, No data matching \n", 'data' => null];
    }
    
    /**
     * Get all data by UserId
     *
     * @params  int     $userId
     * @return  array   $data   list model
     * */
    public function getByUserId($userId)
    {
        if( !file_exists($this->file) ) {
            return ['code' => 204, 'message' => "Sorry, No data matching \n", 'data' => null];
        }

        $lines   = file($this->file, FILE_IGNORE_NEW_LINES);
        $data = [];
        foreach ( $lines as $line ) {
            $model = json_decode($line, true);
            if( $model['user_id'] == $userId ) {
                $data[] = $model;
            }
        }

        return ['code' => 200, 'message' => "Successfully \n", 'data' => json_encode($data)];
    }

    /**
     * create new record
     *
     * @params  json    $data
     * @return  Model
     * */
    public function create($data)
    {
        if (!file_exists('data')) {
            mkdir('data', 0777, true);
        }
        if( !file_exists($this->file) ) {
            $file = fopen($this->file, "w");
            fclose($file);
        }

        file_put_contents($this->file, json_encode($data).PHP_EOL , FILE_APPEND);

        return ['code' => 200, 'message' => "Successfully to create new User \n", 'data' => json_encode($data)];
    }

    public function update($model, $data)
    {
        if( !file_exists($this->file) ) {
            return ['code' => 204, 'message' => "Sorry, No data matching \n", 'data' => null];
        }

        $update = json_decode($model, true);
        foreach ( $data as $key => $value) {
            $update[$key] = $value;
        }

        file_put_contents($this->file,str_replace($model,json_encode($update),file_get_contents($this->file)));

        return ['code' => 200, 'message' => "Successfully to update data \n", 'data' => json_encode($update)];
    }
}