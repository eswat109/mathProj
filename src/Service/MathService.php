<?php

namespace App\Service;

class MathService
{
    function sqr($x){
        return $x * $x;
    }
    function sqrt($x){
        return sqrt($x);
    }
    function del($x){
        return 1 / $x;
    }
    function neg($x){
        return -1 * $x;
    }
}