<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('topics', function (Blueprint $table) {
            $table->id('t_id');
            $table->integer('t_num')->unique();
            $table->text('t_text');
            $table->timestamps();
        });

        Schema::create('goals', function (Blueprint $table) {
            $table->id('g_id');
            $table->integer('g_num')->unique();
            $table->text('g_text');
            $table->unsignedBigInteger('t_id');
            $table->foreign('t_id')->references('t_id')->on('topics')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('objectives', function (Blueprint $table) {
            $table->id('o_id');
            $table->integer('o_num')->unique();
            $table->text('o_text');
            $table->unsignedBigInteger('g_id');
            $table->foreign('g_id')->references('g_id')->on('goals')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('indicators', function (Blueprint $table) {
            $table->id('i_id');
            $table->integer('i_num')->unique();
            $table->text('i_prompt');
            $table->integer('i_resp_num')->nullable();
            $table->text('i_resp_text')->nullable();
            $table->string('i_resp_file')->nullable();
            $table->unsignedBigInteger('o_id');
            $table->foreign('o_id')->references('o_id')->on('objectives')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id('t_id');
            $table->unsignedBigInteger('assigned_by');
            $table->unsignedBigInteger('assigned_to');
            $table->timestamp('assigned_on')->useCurrent();
            $table->timestamp('completed_on')->nullable();
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('indicators');
        Schema::dropIfExists('objectives');
        Schema::dropIfExists('goals');
        Schema::dropIfExists('topics');
    }
};
