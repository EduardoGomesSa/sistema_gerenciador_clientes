<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birth_date' => Carbon::parse($this->birth_date)->format('d/m/Y'),
            'registration_date' => Carbon::parse($this->registration_date)->format('d/m/Y'),
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }
}
