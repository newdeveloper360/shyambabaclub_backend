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
        Schema::create('group_member_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable()->default(NULL);
            $table->text('link')->nullable()->default(NULL);
            $table->text('image')->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_member_messages');
    }
};
