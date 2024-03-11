<?php

namespace App\Service;

class RegistrationCodeService 
{
    public function generateCode()
    {
        $start = 0;
        $end = 10;
        $Strings = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle($Strings), $start, $end);
    }
}