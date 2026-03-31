<?php

namespace App\Models;

use App\Traits\Languageable;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Languageable;

    protected $guarded = ['id'];

    public function menus()
    {
        return $this->hasMany(Menu::class)->orderBy('ordering');
    }

    public function childrenmenus()
    {
        return $this->hasMany(Menu::class)->with('menus')->orderBy('ordering');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'menuable_id', 'id');
    }

    public function getFullTitleAttribute()
    {
        switch ($this->type) {
            case 'category': {
                    $title = $this->category->full_title . ' ( دسته بندی )';

                    break;
                }
            case 'static': {
                    $title = $this->title . ' ( منو ثابت )';

                    break;
                }
            case 'megamenu': {
                    $title = $this->title . ' ( مگامنو )';

                    break;
                }
            default: {
                    $title = $this->title;
                    break;
                }
        }

        return $title;
    }
}
