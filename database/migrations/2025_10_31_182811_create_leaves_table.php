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
        Schema::create('leaves', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');
            $table->foreignUuid('user_id')->comment('ユーザーID');
            $table->foreignUuid('approver_id')->comment('承認者ID');
            $table->foreignUuid('type_id')->comment('承認者ID');
            $table->date('start_date')->comment('休暇開始日');
            $table->date('end_date')->comment('休暇終了日');
            $table->string('status', 191)->comment('申請状態');
            $table->text('reason')->comment('理由');
            $table->dateTimes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_id')->references('id')->on('leave_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
