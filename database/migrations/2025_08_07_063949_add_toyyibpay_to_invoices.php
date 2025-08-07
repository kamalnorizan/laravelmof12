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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('fpxPaymentLink', 100)->nullable()->after('status');
            $table->string('fpxPaymentRef', 255)->nullable()->after('fpxPaymentLink');
            $table->timestamp('fpxPaymentDate')->nullable()->after('fpxPaymentRef');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('fpxPaymentLink');
            $table->dropColumn('fpxPaymentRef');
            $table->dropColumn('fpxPaymentDate');
        });
    }
};
