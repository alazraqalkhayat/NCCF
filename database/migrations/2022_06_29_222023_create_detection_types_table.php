<?php

use App\Models\DetectionType;
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
        Schema::create('detection_types', function (Blueprint $table) {
            $table->id();
            $table->char('name', 50);
            $table->timestamps();
        });

        DetectionType::query()->create([
            'name' => 'type1'
        ]);
        DetectionType::query()->create([
            'name' => 'type1'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detection_types');
    }
};
