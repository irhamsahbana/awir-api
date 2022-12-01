<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('company_id');
            $table->foreign('company_id')
            ->references('id')->on('companies');

            $table->index('branch_id');
            $table->foreign('branch_id')
            ->references('id')->on('branches');

            $table->index('person_id');
            $table->foreign('person_id')
            ->references('id')->on('people');

            $table->index('permission_group_id');
            $table->foreign('permission_group_id')
            ->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropIndex(['company_id']);

            $table->dropForeign(['branch_id']);
            $table->dropIndex(['branch_id']);

            $table->dropForeign(['person_id']);
            $table->dropIndex(['person_id']);

            $table->dropForeign(['permission_group_id']);
            $table->dropIndex(['permission_group_id']);
        });
    }
}
