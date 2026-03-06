<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'department' => $this->whenLoaded('department', fn() => [
                'id' => $this->department->id,
                'name' => $this->department->name_en,
            ]),
            'position' => $this->whenLoaded('position', fn() => [
                'id' => $this->position->id,
                'name' => $this->position->name_en,
            ]),
            'salary' => (float) $this->salary,
            'hire_date' => $this->hire_date?->toDateString(),
            'birth_date' => $this->birth_date?->toDateString(),
            'status' => $this->status,
            'photo' => $this->photo,
            'national_id' => $this->national_id,
            'emergency_contact' => $this->when($this->emergency_contact_name, [
                'name' => $this->emergency_contact_name,
                'phone' => $this->emergency_contact_phone,
                'relation' => $this->emergency_contact_relation,
            ]),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
