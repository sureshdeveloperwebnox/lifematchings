<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HappyStoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $photos = [];
        $images = explode(',', $this->photos);
        foreach ($images as  $value) {
            $photos[] = uploaded_asset($value);
        }
        $package_update_alert = auth()->check() ? is_profile_viewer_view_blocked(auth()->user()) : false;
        return [
            'id'                   => $this->id,
            'user_id'              => $this->user_id,
            'package_update_alert' => $package_update_alert,
            'user_first_name'      => $this->user->first_name,
            'user_last_name'       => $this->user->last_name,
            'partner_name'         => $this->partner_name,
            'title'                => $this->title,
            'details'              => str_replace('&amp;', '&', str_replace('&nbsp;', ' ', strip_tags($this->details))),
            'date'                 => $this->created_at->format('d F, Y'),
            'thumb_img'            => uploaded_asset($images[0]),
            'photos'               => $photos ?? static_asset('assets/img/placeholder.jpg'),
            'video_provider'       => $this->video_provider,
            'video_link'           => $this->video_link,
        ];
    }
}
