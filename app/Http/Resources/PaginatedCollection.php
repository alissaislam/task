<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedCollection extends ResourceCollection
{
    public function __construct(
        private mixed $data,
        private string $class,
        private mixed $extra = null,
    ) {
        parent::__construct($data);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = [
            'data' => $this->class::collection($this->data->items()),
            'from_item' => $this->data->firstItem(),
            'to_item' => $this->data->lastItem(),
            'total_items' => $this->data->total(),
            'current_page' => $this->data->currentPage(),
            'per_page' => $this->data->perPage(),
            'path' => $this->data->path(),
            'has_more_pages' => $this->data->hasMorePages(),
            'links' => $this->data->linkCollection(),
            'next_page_url' => $this->data->nextPageUrl(),
            'previous_page_url' => $this->data->previousPageUrl(),
            'last_page_number' => $this->data->lastPage(),
        ];
        if ($this->extra) {
            $resource = array_merge($resource, [
                'extra' => $this->extra,
            ]);
        }

        return $resource;
    }
}
