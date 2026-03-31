<?php

namespace App\Http\Resources\Api\V1\Product;

use App\Http\Resources\Api\V1\Gallery\GalleryCollection;
use App\Http\Resources\Api\V1\Price\PriceCollection;
use App\Http\Resources\Api\V1\SpecificationGroup\SpecificationGroupCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                   => $this->id,
            'title'                => $this->title,
            'title_en'             => $this->title_en,
            'category_id'          => $this->category_id,
            'slug'                 => $this->slug,
            'image'                => $this->image ? asset($this->image) : null,
            'unit'                 => $this->unit,
            'type'                 => $this->type,
            'price'                => $this->getLowestPrice(true),
            'regular_price'        => $this->getLowestDiscount(true),
            'sale_price'           => $this->getLowestPrice(true),
            'special'              => (bool) $this->special,
            'description'          => $this->prepareDescription($this->description),
            'short_description'    => $this->prepareShortDescription($this->short_description),
            'brand_id'             => $this->brand_id,
            'images'               => new GalleryCollection($this->gallery),
            'category'             => $this->category ? $this->category->title : null,
            'specificationGroups'  => (new SpecificationGroupCollection($this->specificationGroups->unique()))->additional(['product' => $this]),
            'link'                 => $this->link(),
            'is_available'         => $this->addableToCart(),
            'prices'               => new PriceCollection($this->prices)
        ];
    }

    private function prepareDescription($description)
    {
        $description = str_replace('src="/uploads/', 'src="' . url('/') . '/uploads/', $this->description);
        $description = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $description);
        $description = preg_replace('/<p>(<img[^>]*>)/', '$1<p>', $description);
        $description = preg_replace('/(<img[^>]*>)<\/p>/', '</p>$1', $description);
        $description = preg_replace("/<p[^>]*><\\/p[^>]*>/", '', $description);
        $description = str_replace("\n","",$description);;

        return $description;
    }

    private function prepareShortDescription($description)
    {
        $description = nl2br($description);

        return $description;
    }
}
