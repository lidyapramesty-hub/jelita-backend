<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('usaha', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('is_active');
            $table->index('status');
        });
        // Set all existing records to approved so dashboard still shows them
        DB::table('usaha')->update(['status' => 'approved']);
    }
    public function down(): void {
        Schema::table('usaha', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn('status');
        });
    }
};
