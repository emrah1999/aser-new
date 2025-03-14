<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable= [
        'how_it_work_az',
        'how_it_work_en',
        'how_it_work_ru',
        'international_delivery_az',
        'international_delivery_en',
        'international_delivery_ru',
        'corporative_logistics_az',
        'corporative_logistics_en',
        'corporative_logistics_ru',
        'services_az',
        'services_en',
        'services_ru',
        'partners_az',
        'partners_en',
        'partners_ru',
        'blogs_az',
        'blogs_en',
        'blogs_ru',
        'feedback_az',
        'feedback_en',
        'feedback_ru',
        'faqs_az',
        'faqs_en',
        'faqs_ru',
        'contacts_az',
        'contacts_en',
        'contacts_ru',
        'tracking_search_az',
        'tracking_search_en',
        'tracking_search_ru',


        'branch_az',
        'branch_en',
        'branch_ru'

    ];
}
