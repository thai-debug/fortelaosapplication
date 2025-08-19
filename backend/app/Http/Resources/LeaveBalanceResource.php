<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveBalanceResource extends JsonResource
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
            'leave_type' => new LeaveTypeResource($this->whenLoaded('leaveType')),
            'year' => $this->year,
            'opening_balance' => $this->opening_balance,
            'accrued' => $this->accrued,
            'used' => $this->used,
            'adjusted' => $this->adjusted,
            'remaining' => $this->remaining,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
