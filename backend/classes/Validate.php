<?php

class Validate{

    public static function escape($input){

        $input = trim($input); //remove white spaces both left and right like " Dhaka " => "Dhaka"
        $input = stripcslashes($input);//uncote cotted data like "Dhaka" => Dhaka
        $input = htmlentities($input,ENT_QUOTES);

        return $input;
    }
    public static function filterEmail($email){

        return filter_var($email,FILTER_VALIDATE_EMAIL); //validate email
    }

}