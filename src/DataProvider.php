<?php
/**
 * Created by PhpStorm.
 * User: alexunder
 * Date: 11/9/17
 * Time: 11:33 AM
 */

namespace Solo;

class DataProvider
{

    public $data;

    public function __construct()
    {
        $params = json_decode(file_get_contents('php://input'), true);
        $this->data = $params;
    }

    public function get(){
        // if no real data - load mock data for debug
        if(!isset($this->data)) {

            // SOLO
            $this->data = json_decode(
                file_get_contents('dict/results.json'),
                true
            );
        }

        return $this->data;
    }
}