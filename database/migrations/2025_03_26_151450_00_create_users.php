<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('u_fname');
            $table->string('u_lname');
            $table->string('email')->unique();
            $table->timestamp('u_signup_date')->nullable();
            $table->enum('u_type', ['Planner', 'Contributor', 'Assignee'])->default('Contributor');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
