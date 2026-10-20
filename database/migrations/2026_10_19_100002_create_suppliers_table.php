<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
            $table->string('code', 64)->unique();
            $table->string('name', 255);
            $table->string('phone', 32);
            $table->string('email', 255);
        });

        $now = now();

        DB::table('suppliers')->insert([
            ['created_at' => $now, 'updated_at' => $now, 'code' => 'SP001', 'name' => 'North IT Supply', 'phone' => '053-000-001', 'email' => 'sales@north-it.example'],
            ['created_at' => $now, 'updated_at' => $now, 'code' => 'SP002', 'name' => 'City Office Mart', 'phone' => '053-000-002', 'email' => 'orders@city-office.example'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
