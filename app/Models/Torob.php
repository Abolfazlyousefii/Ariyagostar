<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Torob extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function links()
    {
        return $this->hasMany(TorobLink::class);
    }

    public function link()
    {
        return $this->belongsTo(TorobLink::class, 'torob_link_id', 'id');
    }

    public function linksText()
    {
        $text = '';

        foreach ($this->links()->get() as $link) {
            $text .= $link->link . "\n";
        }

        return $text;
    }
}
