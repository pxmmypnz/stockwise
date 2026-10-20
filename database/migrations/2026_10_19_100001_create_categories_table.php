<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
            $table->string('code', 64)->unique();
            $table->string('name', 255);
            $table->text('description')->nullable();
        });

        $now = now();

        DB::table('categories')->insert([
            ['created_at' => $now, 'updated_at' => $now, 'code' => 'CT001', 'name' => 'Electronics', 'description' => 'Computer and electronic accessories'],
            ['created_at' => $now, 'updated_at' => $now, 'code' => 'CT002', 'name' => 'Office Supplies', 'description' => 'Paper, pens and stationery'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
