<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Faq extends Model
{
    protected $table = 'faqs';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('faqs'));
    }

    public function getQuestionAttribute($value) {
        return $this->{'question_'.App::getLocale()};
    }

    public function getAnswerAttribute($value) {
        return $this->{'answer_'.App::getLocale()};
    }
}
