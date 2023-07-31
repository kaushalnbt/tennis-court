<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('work_to_be_performed');
            $table->text('customer');
            $table->string('customer_name')->nullable();
            $table->string('construction_of')->nullable();
            $table->string('send_proposal_to')->nullable();
            $table->text('overseas_conditions')->nullable();
            $table->text('base')->nullable();
            $table->text('court_preparation')->nullable();
            $table->text('surfacing')->nullable();
            $table->text('fence')->nullable();
            $table->text('lights')->nullable();
            $table->text('court_accessories')->nullable();
            $table->text('fee')->nullable();
            $table->text('provisions')->nullable();
            $table->text('conditions')->nullable();
            $table->text('guarantee')->nullable();
            $table->text('credit')->nullable();
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
        Schema::dropIfExists('proposals');
    }
}
