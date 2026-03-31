<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Page\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($page)
    {
        $page = Page::findOrFail($page);

        return $this->respondWithResource(new PageResource($page));
    }
}
