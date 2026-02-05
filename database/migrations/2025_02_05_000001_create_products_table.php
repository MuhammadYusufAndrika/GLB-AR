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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->unique(); // Unique identifier for QR code linking
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->string('model_url'); // Path to .glb/.gltf file
            $table->string('poster_url')->nullable(); // Preview image before model loads
            $table->string('qr_code_url')->nullable(); // Generated QR code image
            $table->string('category')->nullable();
            $table->json('metadata')->nullable(); // Additional product info
            $table->integer('view_count')->default(0); // Analytics: total views
            $table->integer('ar_activation_count')->default(0); // Analytics: AR activations
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Rollback the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
