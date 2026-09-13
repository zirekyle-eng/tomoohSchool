<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_schedules', function (Blueprint $table): void {
            $table->string('bbb_attendee_password', 100)->nullable()->after('viva_z_join_url');
            $table->string('bbb_moderator_password', 100)->nullable()->after('bbb_attendee_password');
            $table->string('viva_z_moderator_join_url', 500)->nullable()->after('bbb_moderator_password');
        });
    }

    public function down(): void
    {
        Schema::table('class_schedules', function (Blueprint $table): void {
            $table->dropColumn(['bbb_attendee_password', 'bbb_moderator_password', 'viva_z_moderator_join_url']);
        });
    }
};
