<?php

namespace App\Http\Controllers;

use App\Models\Wallet;

abstract class Controller
{
    public  function RandomNb(){
        do {
            $nb = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
            $exists = Wallet::where('number', $nb)->exists();
        } while ($exists);
        
        return $nb;
    }}
