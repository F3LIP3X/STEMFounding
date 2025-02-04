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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->string('title');
            $table->text('description');
            $table->string('url_Img');
            $table->string('url_Video');
            $table->float('current_investment')->default(0);
            $table->decimal('min_investment');
            $table->decimal('max_investment');
            $table->date('limit_date');
            $table->enum('state', ['active', 'inactive', 'reject', 'pending'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
