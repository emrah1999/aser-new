<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Faq extends Model
{
    protected $table = 'faqs2';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeletedScope('faqs2'));
    }

    public function getQuestionAttribute($value) {
        return $this->{'question_'.App::getLocale()};
    }

    public function getAnswerAttribute($value) {
        return $this->{'answer_'.App::getLocale()};
    }
}
