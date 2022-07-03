<?php

use App\Models\AnalysisType;
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
        Schema::create('analysis_types', function (Blueprint $table) {
            $table->Id();
            $table->char('name', 50);

            $table->timestamps();
        });

        AnalysisType::query()->create([
            'name' => 'type1'
        ]);
        AnalysisType::query()->create([
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
        Schema::dropIfExists('analysis_types');
    }
};
