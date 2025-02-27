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
        Schema::create('news_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Author::class)->constrained('authors');
            $table->foreignIdFor(\App\Models\News::class)->constrained('news');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_authors');
    }
};
