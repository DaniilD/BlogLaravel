<?php

namespace App;

use \Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function posts()
    {
        return  $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password=bcrypt($fields['password']);
        $user->save();

        return $user; 
    }

    public function edit($fields)
    {
        $this->fill($fields);
        if($fields['password'] != null){
           $this->password =bcrypt($fields['password']); 
       }
        $this->save();
    }

    public function remove(){
        Storage::delete('uploads/'.$this->image);
        $this->delete();
    }

    public function uploadImage($image)
    {
        if ($image == null){return;}

        if($this->image !=null){
             Storage::delete('/uploads/'.$this->image);
        }

        //echo($image->getPathname());
        //dd(get_class_methods($image));

        $filename=str_random(10).'.'.$image->extension();
        $image->move('uploads',$filename);
        $this->image = $filename;
        $this->save();
    }

    public function getImage()
    {
        if($this->image == null) {return '/img/no-user-image.png';}
        return '/uploads/'.$this->image;
    }

    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }

    public function makeNormal(){
       $this->is_admin = 0;
       $this->save(); 
    }

    public function toggleAdmin($value)
    {
            if ($value == null){
                return $this->makeNormal();
            }else{
                return $this->makeAdmin();
            }
    }

    public function ban()
    {
         $this->status = 1;
         $this->save();   
    }

    public function unban()
    {
         $this->status = 0;
         $this->save();   
    }

    public function toggleBan($value)
    {
            if ($value == null){
                return $this->ban();
            }else{
                return $this->unban();
            }
    }

}
