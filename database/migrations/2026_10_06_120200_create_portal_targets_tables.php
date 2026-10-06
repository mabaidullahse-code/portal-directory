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
        Schema::create('portal_department', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portal_id');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('portal_id', 'fk_p_dept_portal_id')->references('id')->on('portals')->cascadeOnDelete();
            $table->foreign('department_id', 'fk_p_dept_dept_id')->references('id')->on('departments')->cascadeOnDelete();
            $table->unique(['portal_id', 'department_id'], 'uq_p_dept');
        });

        Schema::create('portal_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portal_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('portal_id', 'fk_p_user_portal_id')->references('id')->on('portals')->cascadeOnDelete();
            $table->foreign('user_id', 'fk_p_user_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unique(['portal_id', 'user_id'], 'uq_p_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_user');
        Schema::dropIfExists('portal_department');
    }
};
