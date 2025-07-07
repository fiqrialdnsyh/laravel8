<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('screen_overviews', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number');
            $table->string('contract_period');
            $table->string('contract_name');
            $table->string('contractor');
            $table->string('bring_in_out');

            $table->json('status_material')->nullable();
            $table->string('reason')->nullable();
            $table->string('destination')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('driver_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screen_overviews');
    }
};
