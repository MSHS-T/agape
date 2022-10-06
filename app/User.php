<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'first_name', 'last_name', 'role', 'role_type_id', 'invited', 'phone'
    ];

    protected $appends = array('name');

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roleType()
    {
        return $this->belongsTo('App\ProjectCallType', 'role_type_id', 'id');
    }

    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . " " . strtoupper($this->last_name);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new Notifications\CustomVerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Notifications\CustomResetPassword($token));
    }

    public function isAdmin()
    {
        return $this->role == Enums\UserRole::Admin;
    }

    public function isExpert()
    {
        return $this->role == Enums\UserRole::Expert;
    }

    public function isCandidate()
    {
        return $this->role == Enums\UserRole::Candidate;
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', Enums\UserRole::Admin);
    }

    public function scopeExperts($query)
    {
        return $query->where('role', Enums\UserRole::Expert);
    }
}
