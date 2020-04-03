<?php

use Illuminate\Database\Migrations\Migration;

class FixesDefaultKeywordsValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('applications')
            ->where('keywords', '"[]"')
            ->update(['keywords' => '[]']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
