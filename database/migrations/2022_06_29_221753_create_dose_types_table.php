<?php

use App\Models\DoseType;
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
        Schema::create('dose_types', function (Blueprint $table) {
            $table->id();
            $table->char('name', 50);
            $table->timestamps();
        });

        DoseType::query()->create([
            'name' => 'Профилактическая',
        ]);
        DoseType::query()->create([
            'name' => 'Профилактическая',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dose_types');
    }
};
