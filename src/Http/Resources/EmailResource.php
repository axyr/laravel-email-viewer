<?php

namespace Axyr\EmailViewer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \Axyr\EmailViewer\Contracts\EmailMessage $resource;
 */
class EmailResource extends JsonResource
{
    public function toArray($request): array
    {
        return $this->resource->toArray();
    }
}
