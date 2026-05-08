<?php

namespace App\Services;

use App\Models\Wheel;
use App\Models\WheelAssignment;
use Carbon\Carbon;

class WheelScheduleService
{
    public function generate(Wheel $wheel): void
    {
        $members = $wheel->primary_fosters()
            ->orderBy('position')
            ->get();

        if ($members->isEmpty()) {
            return;
        }

        $startDate = Carbon::parse($wheel->rotation_start_date);

        $daysAhead = $wheel->generate_days_ahead;

        $duration = $wheel->duration_days;

        $currentDate = $startDate;

        $sequence = 1;
        $i = 0;

        while (
            $currentDate->lte(
                now()->addDays($daysAhead)
            )
        ) {
            foreach ($members as $member) {

                $endDate = $currentDate
                    ->copy()
                    ->addDays($duration - 1);

                WheelAssignment::create([
                    'wheel_id' => $wheel->id,
                    'foster_id' => $member->foster_id,
                    'start_date' => $currentDate,
                    'position' => $i,
                    'generated_at' => Carbon::now(),
                    'source' => "auto",
                    'end_date' => $endDate,
                ]);

                $currentDate = $endDate
                    ->copy()
                    ->addDay();

                $sequence++;
                $i++;

                if (
                    $currentDate->gt(
                        now()->addDays($daysAhead)
                    )
                ) {
                    break;
                }
            }
        }
    }
}
