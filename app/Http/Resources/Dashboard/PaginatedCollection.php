<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class PaginatedCollection extends ResourceCollection
{
    /**
     * @param  array<string, mixed>  $paginated
     * @param  array<string, mixed>  $default
     * @return array<string, mixed>
     */
    public function paginationInformation(Request $request, array $paginated, array $default): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'firstItem' => $this->resource->firstItem(),
                'lastItem' => $this->resource->lastItem(),
                'total' => $this->resource->total(),
                'perPage' => $this->resource->perPage(),
                'lastPage' => $this->resource->lastPage(),
                'totalPages' => $this->resource->lastPage(),
                'currentPage' => $this->resource->currentPage(),
                'isLastPage' => $this->resource->currentPage() === $this->resource->lastPage(),
                'isFirstPage' => $this->resource->currentPage() === 1,
            ],
        ];
    }
}
