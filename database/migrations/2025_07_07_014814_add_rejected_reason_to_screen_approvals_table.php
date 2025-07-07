<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('screen_approvals', function (Blueprint $table) {
            $table->string('rejected_reason')->nullable();
        });
    }

    public function down()
    {
        Schema::table('screen_approvals', function (Blueprint $table) {
            $table->dropColumn('rejected_reason');
        });
    }
};
