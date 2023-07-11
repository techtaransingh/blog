<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('details', function (Blueprint $table) {

            
            $table->biginteger('author_id')->unsigned()->change();
            $table->foreign('author_id')->references('id')->on('post')->onUpdate('cascade')->onDelete('cascade');
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('author_id');
        $table->dropColumn('author_id'); 
    }
};
