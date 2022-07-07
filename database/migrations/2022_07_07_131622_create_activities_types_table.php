<?php

use App\Models\ActivitiesType;
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
        Schema::create('activities_types', function (Blueprint $table) {
            $table->id();
            $table->char('name',50);
            $table->timestamps();
        });

        ActivitiesType::query()->create([
            'name' => 'نشاط'
        ]);
        ActivitiesType::query()->create([
            'name' => 'فعالية'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities_types');
    }
};
