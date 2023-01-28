<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Adjustment::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Product::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->integer('opening_stock')->default(0);
            $table->integer('adjustment_stock')->default(0);
            $table->integer('ending_stock')->default(0);
            $table->timestamp('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjustment_products');
    }
};
