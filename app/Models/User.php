<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Portfolio;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    
  

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'google_id',
        'profile_image',
    ];
    protected $table = 'users';
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function follows() {
        return $this->hasMany(Follow::class);
    }
    public function isFollowing($target_id)
    {
        return (bool)$this->follows()->where('target_id', $target_id)->first(['id']);
    }
    public function portfolios()
    {
        return $this->hasOne(Portfolio::class);
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
   
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function comments(){
        return $this->hasMany(Comments::class);
    }
    public function getImageAttribute(){
        return $this->profile_image;
    }
   public function profile(){
       return $this->hasOne(Profile::class);
       }
}





