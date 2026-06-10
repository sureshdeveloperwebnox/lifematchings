<?php

namespace App\Http\Resources\PublicProfile;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AstronomicInformation extends JsonResource
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
            'sun_sign' => $this->sun_sign,
            'sun_sign_id' => $this->sun_sign_id ?? null,
            'sun_sign_name' => $this->sun_sign_name ?? null,
            'sun_sign_data' => $this->sun_sign_id ? [
                'id' => $this->sun_sign_id,
                'name' => $this->sun_sign_name
            ] : null,
            'moon_sign' => $this->moon_sign,
            'moon_sign_id' => $this->moon_sign_id ?? null,
            'moon_sign_name' => $this->moon_sign_name ?? null,
            'moon_sign_data' => $this->moon_sign_id ? [
                'id' => $this->moon_sign_id,
                'name' => $this->moon_sign_name
            ] : null,
            'lagnam' => $this->lagnam,
            'lagnam_id' => $this->lagnam_id ?? null,
            'lagnam_name' => $this->lagnam_name ?? null,
            'lagnam_data' => $this->lagnam_id ? [
                'id' => $this->lagnam_id,
                'name' => $this->lagnam_name
            ] : null,
            'time_of_birth' => $this->time_of_birth,
            'city_of_birth' => $this->city_of_birth,
        ];
    }
}
