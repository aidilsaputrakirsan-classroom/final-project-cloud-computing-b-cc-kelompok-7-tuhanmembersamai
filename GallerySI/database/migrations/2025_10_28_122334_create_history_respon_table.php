<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_respon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('response')->nullable();
            $table->bigInteger('likes_count')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable(); // reply ke komentar lain
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('history_respon')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_respon');
    }
};
