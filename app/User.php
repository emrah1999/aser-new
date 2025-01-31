<?php

namespace App;

use App\Scopes\DeletedScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'referral_unconfirm',
			'name',
			'surname',
			'username',
			'email',
			'phone1',
			'phone2',
			'phone3',
			'birthday',
			'language',
			'city',
            'region',
			'address1',
			'address2',
			'address3',
			'location_longitude1',
			'location_latitude1',
			'passport_series',
			'passport_number',
			'passport_fin',
			'gender',
			'password',
			'role_id',
			'image',
			'is_legality',
			'is_partner',
			'fcm_token',
            'zip1',
            'zip2',
            'zip3',
            'is_external_user',
            'parent_email',
            'read_notification_count',
            'branch_id',
            'email_verified_at',
            'voen',
            'company_name',
            'sms_notification',
            'email_notification',

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
			'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
			'email_verified_at' => 'datetime',
	];

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new DeletedScope('users'));
	}

	public function deleted_value()
	{
		if ($this->deleted_by == null) {
			return 0;
		}

		return 1;
	}

	public function is_verified()
	{
		return !($this->email_verified_at === null);
	}

	public function username()
	{
		return $this->username;
	}

	public function language()
	{
		return $this->language;
	}

	public function role()
	{
		$role = $this->role_id;

		return $role;
	}

	public function gender()
	{
		$gender = $this->gender;

		return $gender;
	}

	public function name()
	{
		return $this->name;
	}

	public function full_name()
	{
		return $this->name . ' ' . $this->surname;
	}

	public function suite()
	{
		$id = $this->id;
		$suite = $this->suite;

		$id_len = strlen($id);

		if ($id_len < 6) {
			for ($i = 0; $i < 6 - $id_len; $i++) {
				$id = '0' . $id;
			}
		}

		return $id;
	}

	public function address()
	{
		return $this->address1;
	}

	public function phone()
	{
		return $this->phone1;
	}

	public function balance()
	{
		return $this->balance;
	}

	public function profile_image()
	{
		$image = $this->image;

		if ($image == null) {
			$image = asset("frontend/img/no-profile-photo.jpg");
		}

		return $image;
	}

	public function currency()
	{
		try {
			$location = $this->destination_id;

			$currency = Location::leftJoin('countries as c', 'locations.country_id', '=', 'c.id')
					->leftJoin('currency as cur', 'c.currency_id', '=', 'cur.id')
					->where('locations.id', $location)
					->select('cur.name')
					->first();

			if ($currency) {
				return $currency->name;
			} else {
				return "USD";
			}
		} catch (\Exception $exception) {
			return "USD";
		}
	}

	public function currency_id()
	{
		try {
			$location = $this->destination_id;

			$currency = Location::leftJoin('countries as c', 'locations.country_id', '=', 'c.id')
					->where('locations.id', $location)
					->select('c.currency_id')
					->first();

			if ($currency) {
				return $currency->currency_id;
			} else {
				return 0;
			}
		} catch (\Exception $exception) {
			return 0;
		}
	}

	public function contract_id()
	{
		return $this->contract_id;
	}
    
    public function branch_id()
    {
        return $this->branch_id;
    }
	public function sendEmailVerificationNotification()
	{
		$this->notify(new Notifications\VerifyEmail);
	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new Notifications\ResetPassword($token));
	}
}
