<?php

namespace App\Services;

class SurveyData
{
    public function __construct()
    {
        
    }

    /**
     * This function checks if data exists, whether it is not null or empty
     *
     * @param [type] $data
     * @return boolean
     */
    public function isNotNullData($data){
        if (isset($data) === true AND $data !== null AND $data !== "" AND $data !== []) {
            return true;
        } else 
        {
            return false;
        }
    }

    /**
     * This function checks if data exists and if data is a integer, whether it is not null or empty or not integer
     *
     * @param [type] $data
     * @return boolean
     */
    public function isNumExist($data){
        if (isset($data) === true AND $data !== null AND $data !== "" AND $data !== [] AND is_int($data) === true) {
            return true;
        } else 
        {
            return false;
        }
    }

}
