<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceRecordResource extends JsonResource
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
            'user_code' => $this->user_code,
            'user_name' => $this->user->full_name,
            'work_date' => $this->work_date->format('Y-m-d'),
            'morning_check_in' => $this->morning_check_in?->format('H:i'),
            'morning_check_out' => $this->morning_check_out?->format('H:i'),
            'afternoon_check_in' => $this->afternoon_check_in?->format('H:i'),
            'evening_check_out' => $this->evening_check_out?->format('H:i'),
            'total_hours' => $this->calculateTotalHours(),
            'status' => $this->determineStatus(),
            'submitted_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
