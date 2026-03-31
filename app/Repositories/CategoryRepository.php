<?php

namespace App\Repositories;


trait CategoryRepository
{
    public function getCategoriesCount()
    {
        return $this->categories()->published()->count();
    }

    public function getCategories()
    {
        return $this->categories()->published()->get();
    }
}
