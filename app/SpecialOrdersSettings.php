<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class SpecialOrdersSettings extends Model
{
    protected $table = 'special_orders_settings';

    public function getMessageAttribute($value) {
        return $this->{'message_'.App::getLocale()};
    }

    public function getCampaignAttribute($value) {
        return $this->{'campaign_'.App::getLocale()};
    }
}
