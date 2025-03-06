<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => [
                'id' => $this->status->id,
                'name' => $this->status->name,
            ],
            'approval' => $this->approvals->map(function ($approval) {
                return [
                    'id' => $approval->id,
                    'approver' => [
                        'id' => $approval->approver->id,
                        'name' => $approval->approver->name,
                    ],
                    'status' => [
                        'id' => $approval->status->id,
                        'name' => $approval->status->name,
                    ],
                ];
            }),
        ];
    }
}
