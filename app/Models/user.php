<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
  
    //
    protected $table ='users';
    //


    //public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	/**
	 * Send the email verification notification.
	 * @return void
	 */
	public function resendEmailVerificationNotification() {
	}

    public function roles(){
        return $this->belongsToMany(role::class,'user_role','user_id','role_id') ->withPivot([
            'created_at',
            'updated_at',
        ]);
    
    }

    public function checkPermissionAccess($permissionCheck){
        $roles=Auth::user()->roles;//lấy danh sách vai trò của người dùng đang đăng nhập sau đó duyệt qua danh sách vai trò của người dùng
        foreach($roles as $role){
            $permissions=$role->permission;
            if($permissions->contains('key_code',$permissionCheck)){
                return true;
            }
        }
        return false;
    }

}
