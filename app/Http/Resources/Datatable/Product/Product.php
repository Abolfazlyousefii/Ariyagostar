<?php

namespace App\Http\Resources\Datatable\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'image'            => $this->image ? asset($this->image) : asset('/empty.jpg'),
            'title'            => $this->title,
            'created_at'       => jdate($this->created_at)->format('%d %B %Y'),
            'admin_updated_at' => jdate($this->admin_updated_at)->format('%d %B %Y'),
            'addableToCart'    => $this->addableToCart(),
            'published'        => $this->isPublished(),
            'stock_count'      => $this->prices()->sum('stock'),

            'links' => [
                'edit'    => route('admin.products.edit', ['product' => $this]),
                'destroy' => route('admin.products.destroy', ['product' => $this]),
                'copy'    => route('admin.products.create', ['product' => $this]),
                'front'   => Route::has('front.products.show') ? route('front.products.show', ['product' => $this]) : '#',
            ]
        ];
    }
}
