<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function colocation(){
        return $this->belongsToMany(Colocation::class, 'colocation_user')->withPivot('role');
    }
    public function expenses()
    {
        return $this->hasMany(Expence::class, 'paid_by');
    }

    public function paymentsSent()
    {
        return $this->hasMany(Payment::class, 'payer_id');
    }

    public function paymentsReceived()
    {
        return $this->hasMany(Payment::class, 'receiver_id');
    }
    public function whoshares(){
        return $this->belongsToMany(Expence::class, 'shares')->withPivot('amount');
    }

}
