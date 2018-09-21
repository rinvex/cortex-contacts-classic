<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContactsTableAddSocialColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('rinvex.contacts.tables.contacts'), function (Blueprint $table) {
            $table->schemalessAttributes('social')->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('rinvex.contacts.tables.contacts'), function (Blueprint $table) {
            $table->dropColumn('social');
        });
    }
}
