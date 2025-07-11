<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('screen_approvals', function (Blueprint $table) {
            $table->string('approved_by_username')->nullable()->after('approval_by');
        });
    }


    public function down(): void
    {
        Schema::table('screen_approvals', function (Blueprint $table) {
            $table->dropColumn('approved_by_username');
        });
    }
};
