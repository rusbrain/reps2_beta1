<?php

namespace App;

use App\Traits\ModelRelations\UserActivityLogRelation;
use Illuminate\Database\Eloquent\Model;

class UserActivityLogEntry extends Model
{
    use UserActivityLogRelation;

    protected $table = 'user_activity_logs';

    protected $fillable = [
        'type', 'time', 'user_id', 'parameters'
    ];

    protected $casts = [
        'parameters' => 'array'
    ];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function getDescription()
    {
        return $this->parameters['description'] ?? '';
    }

    public function getDetails()
    {
        return $this->parameters['details'] ?? '';
    }
}

