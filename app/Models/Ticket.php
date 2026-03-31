<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = ['id'];

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priorityText()
    {
        switch ($this->priority) {
            case "low": {
                return 'کم';
            }
            case "medium": {
                return 'متوسط';
            }
            case "hight": {
                return 'زیاد';
            }
        }
    }

    public function statusText()
    {
        switch ($this->status) {
            case "pending": {
                return 'معلق';
            }
            case "open": {
                return 'باز';
            }
            case "close": {
                return 'بسته';
            }
        }
    }
}
