<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('screen_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('screen_overview_id');
            $table->string('request_by')->nullable();
            $table->string('approval_by')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('screen_overview_id')
                ->references('id')->on('screen_overviews')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screen_approvals');
    }
};
