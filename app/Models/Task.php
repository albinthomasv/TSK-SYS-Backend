<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
   protected $fillable = [
       'title',
       'description',
       'status',
       'user_id',
   ];

    /**
     * Generate a unique slug for the task on creation.
     *
     * This will append a number to the end of the slug if it already exists.
     *
     * Example: hello-world, hello-world-1, hello-world-2, etc.
     */
   static function boot()
   {
       parent::boot();
       static::creating(function ($task) {
        $baseSlug = Str::slug(Str::lower($task->title)); 
        $slug = $baseSlug;
        $count = 1;

        // Check if the slug already exists in the database
        while (static::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $task->slug = $slug;
    });
   }

   public function user()
   {
       return $this->belongsTo(User::class, 'user_id');
   }
}
