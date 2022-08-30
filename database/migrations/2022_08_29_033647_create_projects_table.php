<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('category_id')->constrained('project_categories')->restrictOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('picture_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();

            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_shown')->default(true);
            $table->boolean('is_ended')->default(false);
            $table->bigInteger('maintenance_fee')->default(0);
            $table->bigInteger('target_amount');
            $table->bigInteger('first_choice_amount')->default(0);
            $table->bigInteger('second_choice_amount')->default(0);
            $table->bigInteger('third_choice_amount')->default(0);
            $table->bigInteger('fourth_choice_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
