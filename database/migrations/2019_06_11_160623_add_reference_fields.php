<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenceFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_calls', function (Blueprint $table) {
            $table->string('reference')->nullable();
        });
        $results = DB::table('project_calls')->select('id', 'type', 'year')->get();
        $indexes = [];
        $references = [];
        foreach ($results as $result){
            $key = $result->type."-".$result->year;
            if(!array_key_exists($key, $indexes)){
                $indexes[$key] = 0;
            }
            $ref = sprintf(
                "%s-%s-%s",
                substr(strval($result->year), -2),
                __('vocabulary.calltype_reference.'.\App\Enums\CallType::getKey($result->type)),
                str_pad(strval(++$indexes[$key]), 2, "0", STR_PAD_LEFT)
            );
            DB::table('project_calls')
                ->where('id',$result->id)
                ->update([
                    "reference" => $ref
                ]);
            $references[$result->id] = $ref;
        }
        Schema::table('project_calls', function (Blueprint $table) {
            $table->string('reference')->nullable(false)->unique()->change();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->string('reference')->nullable();
        });
        $results = DB::table('applications')->select('id', 'projectcall_id')->get();
        $indexes = [];
        foreach ($results as $result){
            $key = $result->projectcall_id;
            if(!array_key_exists($key, $indexes)){
                $indexes[$key] = 0;
            }
            $ref = $references[$key] . '-' . str_pad(strval(++$indexes[$key]), 3, "0", STR_PAD_LEFT);
            DB::table('applications')
                ->where('id',$result->id)
                ->update([
                    "reference" => $ref
                ]);
        }
        Schema::table('applications', function (Blueprint $table) {
            $table->string('reference')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_calls', function (Blueprint $table) {
            $table->dropColumn('reference');
        });
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('reference');
        });
    }
}
