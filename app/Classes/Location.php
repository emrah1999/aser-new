<?php

namespace App\Classes;

class Location
{
    public $city;
    public $region;

    public function __construct($city, $region)
    {
        $this->city = $city;
        $this->region = $region;
    }

}