<?php

namespace App\Http\Resources\Datatable\Order;

use App\Models\Order;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'page' => $this->currentPage(),
                'pages' => $this->lastPage(),
                'perpage' => $this->perPage(),
                'rowIds' => $this->collection->pluck('id')->toArray()
            ],
        ];
    }
}
