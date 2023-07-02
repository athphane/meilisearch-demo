<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consolidations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Legislation::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consolidations');
    }
};
