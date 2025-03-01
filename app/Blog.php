<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'name_az',
        'name_en',
        'name_ru',
        'content_az',
        'content_en',
        'content_ru',
        'slug_az',
        'slug_en',
        'slug_ru',
        'icon',
        'page',
        'sub_category_id',
        'show',
        'internal_images'
    ];
    
    public function category(){
        if($this->page==1){
            return "Tariff";
        }else if($this->page==2){
            return "Yük daşıma";
        }else if($this->page==3){
            return "Xidmətlərimiz";
        }else{
            return "Seçilməyib";
        }
    }
    public function getSub(){
        if($this->page==1){
            $result =InternationalDelivery::select('name_az')->where('id',$this->sub_category_id)->first();
            if($result){
                return $result->name_az;
            }else{
                return "Seçilməyib";
            }
        }else if($this->page==2){
            $result =CorporativeLogistic::select('name_az')->where('id',$this->sub_category_id)->first();
            if($result){
                return $result->name_az;
            }else{
                return "Seçilməyib";
            }
        }else if($this->page==3){
            return "Seçilməyib";
        }else{
            return "Seçilməyib";
        }
    }
}
