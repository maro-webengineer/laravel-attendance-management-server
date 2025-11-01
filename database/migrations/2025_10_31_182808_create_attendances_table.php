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
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');
            $table->foreignUuid('user_id')->comment('ユーザーID');
            $table->date('work_date')->nullable()->comment('勤務日');
            $table->time('clock_in')->nullable()->comment('出勤時刻');
            $table->time('clock_out')->nullable()->comment('退勤時刻');
            $table->integer('break_minutes')->comment('休憩時間');
            $table->string('status', length: 191)->comment('退勤時刻');
            $table->dateTimes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
