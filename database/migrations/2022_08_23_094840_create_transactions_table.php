<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code',12);
            $table->string('resi_code',50)->nullable();
            $table->bigInteger('user_id');
            $table->string('kurir')->nullable();
            $table->text('destination')->nullable();
            $table->decimal('ongkir',15,2)->nullable();
            $table->enum('status_transaction',['waiting','pending','process','send'])->default('waiting');
            $table->timestamp('date_transaction')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('proof_of_payment')->nullable();
            $table->decimal('grandtotal');
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
        Schema::dropIfExists('transactions');
    }
}
