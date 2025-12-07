<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('clock_in');
            $table->dropColumn('clock_out');
            $table->dropColumn('status');
            $table->dropColumn('break_minutes');

            $table->dateTime('clock_in')->nullable()->comment('出勤時刻')->after('work_date');
            $table->dateTime('clock_out')->nullable()->comment('退勤時刻')->after('clock_in');
            $table->dateTime('break_started_at')->nullable()->comment('休憩開始時間')->after('clock_out');
            $table->dateTime('break_ended_at')->nullable()->comment('休憩終了時間')->after('break_started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('clock_in')->nullable()->comment('出勤時刻');
            $table->time('clock_out')->nullable()->comment('退勤時刻');
            $table->integer('break_minutes')->comment('休憩時間');
            $table->string('status', length: 191)->comment('退勤時刻');
        });
    }
};
