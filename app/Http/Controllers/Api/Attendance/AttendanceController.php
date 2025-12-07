<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AttendanceService;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AttendanceController extends Controller
{

    protected $authService;
    protected $attendanceService;

    public function __construct(AuthService $authService, AttendanceService $attendanceService)
    {
        $this->authService = $authService;
        $this->attendanceService = $attendanceService;
    }

    public function loginAndClockIn(LoginRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = $this->authService->authenticate(
                $validated['email'],
                $validated['password'],
            );

            $attendance = $this->attendanceService->clockIn($user);

            return response()->json([
                'message' => '出勤打刻が完了しました。',
                'user' => $user,
                'attendance' => $attendance,
            ]);
        } catch (ValidationException $e) {

            return response()->json([
                'message' => '認証に失敗しました。',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_CONFLICT);
        }
    }

    public function clockIn(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => '認証されていません。',
                ]);
            }

            $attendance = $this->attendanceService->clockIn($user);

            return response()->json([
                'message' => '出勤打刻が完了しました。',
                'attendance' => $attendance,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_CONFLICT);
        }
    }

    public function clockOut(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => '認証されていません。',
                ]);
            }

            $attendance = $this->attendanceService->clockOut($user);

            return response()->json([
                'message' => '退勤打刻が完了しました。',
                'attendance' => $attendance,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_CONFLICT);
        }
    }
}
