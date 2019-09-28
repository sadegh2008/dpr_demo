<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TicketMessage.
 *
 * @package namespace App\Entities;
 */
class TicketMessage extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message', 'ticket_id'];

    protected static function boot () {
        parent::boot();
        static::creating(function ($model) {
            $model->creator_id = auth()->id();
        });
    }

    public function creator () {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function ticket () {
        return $this->belongsTo(Ticket::class);
    }

}
