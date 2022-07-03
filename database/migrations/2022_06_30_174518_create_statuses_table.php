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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->char('status', 20);
            $table->timestamps();
        });

        \App\Models\Status::query()->create(['status'=>'WAIT']);
        \App\Models\Status::query()->create(['status'=>'CANCEL']);
        \App\Models\Status::query()->create(['status'=>'DONE']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
};
