<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
            // restrictOnDelete: a category or supplier that still has items cannot be deleted
            // (the database throws a QueryException that the controller catches).
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();
            $table->string('sku', 64)->unique();
            $table->string('name', 255);
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('reorder_level')->default(0);
            $table->decimal('price', 10, 2)->default(0);
        });

        $now = now();
        $electronics = DB::table('categories')->where('code', 'CT001')->value('id');
        $office = DB::table('categories')->where('code', 'CT002')->value('id');
        $northIt = DB::table('suppliers')->where('code', 'SP001')->value('id');
        $cityOffice = DB::table('suppliers')->where('code', 'SP002')->value('id');

        DB::table('items')->insert([
            ['created_at' => $now, 'updated_at' => $now, 'category_id' => $electronics, 'supplier_id' => $northIt, 'sku' => 'ITM-001', 'name' => 'USB Keyboard', 'quantity' => 25, 'reorder_level' => 10, 'price' => 350.00],
            ['created_at' => $now, 'updated_at' => $now, 'category_id' => $electronics, 'supplier_id' => $northIt, 'sku' => 'ITM-002', 'name' => 'Wireless Mouse', 'quantity' => 4, 'reorder_level' => 10, 'price' => 250.00],
            ['created_at' => $now, 'updated_at' => $now, 'category_id' => $office, 'supplier_id' => $cityOffice, 'sku' => 'ITM-003', 'name' => 'A4 Paper (ream)', 'quantity' => 120, 'reorder_level' => 50, 'price' => 95.00],
            ['created_at' => $now, 'updated_at' => $now, 'category_id' => $office, 'supplier_id' => $cityOffice, 'sku' => 'ITM-004', 'name' => 'Ballpoint Pen (box)', 'quantity' => 0, 'reorder_level' => 5, 'price' => 60.00],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
