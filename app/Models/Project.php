<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'client_name',
        'project_url',
        'project_date',
        'slug',
        'type_id',
        'user_id'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function getSimilarProjects()
    {
        return $this->type->projects()->where('id', '!=', $this->id)->get();
    }

    public function getTechsIds()
    {
        return $this->technologies->pluck('id')->all();
    }
}
