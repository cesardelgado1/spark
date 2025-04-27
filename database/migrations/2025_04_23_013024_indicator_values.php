<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('indicator_values', function (Blueprint $table) {
            $table->id('iv_id');

            $table->unsignedBigInteger('iv_u_id');
            $table->foreign('iv_u_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('iv_ind_id');
            $table->foreign('iv_ind_id')->references('i_id')->on('indicators')->onDelete('cascade');

            $table->text('iv_value')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicator_values');
    }
};
