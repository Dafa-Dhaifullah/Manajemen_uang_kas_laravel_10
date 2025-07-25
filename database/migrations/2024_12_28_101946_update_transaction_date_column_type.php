<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionDateColumnType extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->datetime('transaction_date')->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_date')->change();
        });
    }
}