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
        Schema::create('portals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->index();
            $table->string('url', 2048);
            $table->string('purpose')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active')->index();
            $table->date('opening_date')->nullable()->index();
            $table->date('closing_date')->nullable()->index();
            $table->string('icon')->nullable();
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('department_id')->index();
            $table->string('contact_person')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->json('tags')->nullable();
            $table->string('version')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();

            $table->foreign('category_id', 'fk_portals_category_id')->references('id')->on('categories')->nullOnDelete();
            $table->foreign('user_id', 'fk_portals_user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('department_id', 'fk_portals_department_id')->references('id')->on('departments')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portals');
    }
};
