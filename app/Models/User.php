<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\CustomResetPassword;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable  implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // variables pour les roles des users


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role'
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


    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'user_formations')
            ->withPivot(['progression', 'path_attestation'])
            ->withTimestamps();
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * Override la notification d'email de vérification par défaut
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
    public function formationsAchetees()
    {
        return $this->belongsToMany(Formation::class, 'user_formations')
            ->withPivot('progression', 'path_attestation')
            ->withTimestamps();
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'user_lessons')
            ->withPivot(['terminee', 'terminee_at'])
            ->withTimestamps();
    }

    public function quizzs()
    {
        return $this->belongsToMany(Quizz::class, 'user__quizzs')
            ->withPivot(['score'])
            ->withTimestamps();
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
