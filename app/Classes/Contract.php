<?php

namespace App\Classes;

class Contract
{
    public $fromWeight;
    public $toWeight;
    public $rate;
    public $charge;
    public $contractType;

    public function __construct($fromWeight, $toWeight, $rate, $charge, $contractType)
    {
        $this->fromWeight = $fromWeight;
        $this->toWeight = $toWeight;
        $this->rate = $rate;
        $this->charge = $charge;
        $this->contractType = $contractType;
    }
}