<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeavePolicyResource extends JsonResource
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
            'leave_type' => new LeaveTypeResource($this->whenLoaded('leaveType')),
            'employment_type' => new EmploymentTypeResource($this->whenLoaded('employmentType')),
            'entitlement_days' => $this->entitlement_days,
            'accrual_method' => $this->accrual_method,
            'carryover_max' => $this->carryover_max,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
