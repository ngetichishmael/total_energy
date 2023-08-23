<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_code' => $this->user_code,
            'email' => $this->email,
            'location' => $this->location,
            'fcm_token' => $this->fcm_token,
            'role' => $this->account_type,
            'status' => $this->status,
            'customers' => $this->customers_count,
            'number_visited' => $this->checkings_count,
            'target_sales' => $this->formatTargets($this->TargetSales),
            'target_leads' => $this->formatTargets($this->Targetleads),
            'target_order' => $this->formatTargets($this->TargetsOrder),
            'target_visit' => $this->formatTargets($this->TargetsVisit),
        ];
    }

    protected function formatTargets($targets)
    {
        $formattedTargets = [];

        foreach ($targets as $target) {
            $formattedTargets[] = [
                'id' => $target->id,
                'Target' => $target->SalesTarget, // Replace 'SalesTarget' with appropriate field
                'AchievedTarget' => $target->AchievedSalesTarget, // Replace 'AchievedSalesTarget' with appropriate field
                'Deadline' => $target->Deadline,
            ];
        }

        if (empty($formattedTargets)) {
            $formattedTargets[] = [
                'id' => 0,
                'Target' => '0',
                'AchievedTarget' => '0',
                'Deadline' => Carbon::now()->format('Y-d-m'),
            ];
        }

        return $formattedTargets;
    }
}
