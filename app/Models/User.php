<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\False_;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'email_verified_at'
    ];

    /**
     * @param array $userData
     * @return int
     */
   public static function addUser(array $userData): int
   {
       $password = password_hash($userData['password'], PASSWORD_DEFAULT);
       $userData['password'] = $password;

       return self::insert($userData);
   }

    /**
     * @param string $email
     * @return array
     */
   public static function getUserByEmail(string $email): array
   {
       return DB::table('users')->get()->where('email', '=', $email)->toArray();
   }

    /**
     * @param string $password
     * @param string $email
     * @return void
     */
   public static function setPassword(string $password, string $email)
   {
       $password = password_hash($password, PASSWORD_DEFAULT);

       DB::table('users')->where('email', '=', $email)->update(['password' => $password]);
   }
}
