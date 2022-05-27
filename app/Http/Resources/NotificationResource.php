<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //return parent::toArray($request);
        return ['type' => $this->type,
                'post_id' => $this->post_id,
                'message' => $this->message,
                'created_at' => $this->created_at,
                'seen' => $this->updated_at,
                'app_name' => 'lsaap'];
    }
    // public function with($request){ //Not working
    //     return ['app_name' => 'lsaap'];
    // }
}
