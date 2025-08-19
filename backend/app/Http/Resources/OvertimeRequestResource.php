<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OvertimeRequestResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'date' => $this->date,
            'hours' => $this->hours,
            'reason' => $this->reason,
            'status' => $this->status,
            'submitted_at' => $this->submitted_at,
            'approvals' => OvertimeApprovalResource::collection($this->whenLoaded('approvals')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
