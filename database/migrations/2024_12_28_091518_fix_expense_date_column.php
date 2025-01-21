<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->datetime('expense_date')->change();
        });
    }
    
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->date('expense_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
  
};
