<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Ticket.
 *
 * @package namespace App\Entities;
 */
class Ticket extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'status'];

    protected static function boot () {
        parent::boot();
        static::creating(function ($model) {
           $model->creator_id = auth()->id();
        });
    }

    public function creator () {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function users () {
        return $this->belongsToMany(User::class, 'ticket_user')->withTimestamps();
    }

    public function messages () {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }
}
