<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->double('price')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignIdFor(Category::class, 'category_id')->cascadeOnDelete()->nullable();
            $table->string('tags')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
