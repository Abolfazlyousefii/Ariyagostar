<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class TaggableObserver
{
    public function saved(Model $model)
    {
        if (request()->tags) {
            //add tags and get id
            $tags = addTags(request()->tags);
            $model->tags()->sync($tags);
        }
    }
}
