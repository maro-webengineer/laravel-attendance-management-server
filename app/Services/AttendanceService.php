<?php

namespace App\Services;

use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceService
{
    public function clockIn($user)
    {
        $today = Carbon::today();

        $existing_attendance = Attendance::where('user_id', $user->id)
            ->whereDate('clock_in', $today)
            ->first();

        if ($existing_attendance) {
            throw new \Exception('本日は既に出勤済みです。');
        }

        return Attendance::create([
            'user_id' => $user->id,
            'work_date' => now()->toDateString(),
            'clock_in' => now(),
            'break_started_at' => $today->copy()->setTime(12, 0, 0),
            'break_ended_at' => $today->copy()->setTime(13, 0, 0),
        ]);
    }

    public function clockOut($user)
    {
        $existing_attendance = Attendance::where('user_id', $user->id)
            ->whereNull('clock_out')
            ->orderByDesc('clock_in')
            ->first();

        if (!$existing_attendance) {
            throw new \Exception('退勤できる出勤レコードがありません。（既に退勤済みか、未出勤の可能性があります）');
        }

        $existing_attendance->clock_out = now();

        if (!$existing_attendance->save()) {
            throw new \Exception('退勤打刻の保存に失敗しました。');
        }

        return $existing_attendance;
    }
}
