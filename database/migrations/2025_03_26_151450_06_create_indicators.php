migrations/create_indicators

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('indicators', function (Blueprint $table) {
            $table->id('i_id');
            $table->integer('i_num');
            $table->text('i_text');
            $table->enum('i_type', ['integer', 'string', 'document']);
            $table->text('i_value')->nullable();
            $table->string('i_FY')->nullable();
            $table->unsignedBigInteger('o_id');
            $table->foreign('o_id')->references('o_id')->on('objectives')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('indicators');
    }
};
