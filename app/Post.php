<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    //
    use Sluggable;

    protected $fillable = ['title','content','date','description'];
   
   public function category()
   {
   		return $this->belongsTo(Category::class, 'category_id');
   }

   public function author()
   {
   	    return $this->belongsTo(User::class,'user_id');
   }

   public function tags()
   {
   		return $this->belongsToMany(Tag::class, 'post_tags', 'post_id','tag_id');
   }

   public function comments()
   {
     return $this->hasMany(Comment::class, 'post_id');
   }

   public function sluggable()
      {
          return [
              'slug' => [
                  'source' => 'title'
              ]
          ];
      }

    public static function add($fields){
    	$post = new static;

    	$post->fill($fields);
    	$post->user_id = 1;
    	$post->save();

    	return $post;
    } 

    public function edit($fields)
    {
    	$this->fill($fields);
    	$this->save();
    }

    public function remove()
    {	
    	//remove image of post
    	 if($this->image != null){
            Storage::delete('uploads/'.$this->image);
        }

    	$this->delete();
    }

    public function uploadImage($image)
    {
    	if ($image == null){return;}

        if($this->image != null){
            Storage::delete('uploads/'.$this->image);
        }
    	
    	$filename=str_random(10).'.'.$image->extension();
    	$image->move('uploads',$filename);
    	$this->image = $filename;
    	$this->save();
    }

    public function setCategory($id)			
    {
    	if ($id == null){return;}
    	$this->category_id=$id;
    	$this->save();
    }

    public function setTags($ids)			
    {
    	if ($ids == null){return;}
    	$this->tags()->sync($ids);
    }

    public function setDraft()			
    {
    	//if ($id == null){return;}
    	
    	$this->status=0;
    	$this->save();
    }

    public function setPublic()			
    {
    	//if ($id == null){return;}
    	
    	$this->status=1;
    	$this->save();
    }

    public function toggleStatus($value)
    {
    	if($value==null){

    		return $this->setDraft();
    	}else{
    		return $this->setPublic();
    	}
    }

    public function setFeatured()			
    {
    	//if ($id == null){return;}
    	
    	$this->is_featured=1;
    	$this->save();
    }

    public function setStandart()			
    {
    	//if ($id == null){return;}
    	
    	$this->is_featured=0;
    	$this->save();
    }

    public function toggleFeatured($value)
    {
    	if($value==null){

    		return $this->setStandart();
    	}else{
    		return $this->setFeatured();
    	}
    }

    public function getImage()
    {
    	if($this->image == null) {return '/img/no-user-image.png';}
    	return '/uploads/'.$this->image;
    }


    public function setDateAttribute($value)
      {
          //$this->attributes['first_name'] = strtolower($value);
        //dd($value);
       //dd($value);
        
            $date= Carbon::createFromFormat('d/m/y',$value)->format('Y-m-d');
        
          $this->attributes['date']=$date;
      }

      public function getDateAttribute($value)
        {
          
            $date= Carbon::createFromFormat('Y-m-d',$value)->format('d/m/y');
          
            return $date;
        }

    public function getCategoryTitle(){
        if($this->category != null){
            return $this->category->title;
        }

        return 'Нет Категории';
    }

    public function getTagsTitles(){

        if(count($this->tags)!=0){
       return implode(', ',$this->tags->pluck('title')->all());
        }

        return 'Нет Тегов';

    }

    public function getDate(){
        $date= Carbon::createFromFormat('d/m/y',$this->date)->format('F d, Y');

        return $date;
    }

    public function hasPrevious()
      {
          return self::where('id','<',$this->id)->max('id');
      } 

    public function hasNext()
      {
          return self::where('id','>',$this->id)->min('id');
      }

    public function getPrevious()
      {
          return self::find($this->hasPrevious());
      } 

    public function getNext()
      {
          return self::find($this->hasNext());
      }
    
    public function related(){
        //return self::all()->except($this->id);
        return self::where('category_id','=',$this->category_id) ->get()->except($this->id); 

    }

    public function getLinkCategory(){
        if ($this->category != null)  return route('category.show',$this->category->slug); 
    }

    public function getComments()
    {
        return $this->comments()->where('status', 1)->get();
    }

             
}
