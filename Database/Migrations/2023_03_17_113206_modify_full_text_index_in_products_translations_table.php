<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $indexesFound = array_change_key_case($sm->listTableIndexes('icommerce__product_translations'), CASE_LOWER);
        \DB::statement('ALTER TABLE `icommerce__product_translations` DROP INDEX `full`;');
        \DB::statement('ALTER TABLE icommerce__product_translations ADD FULLTEXT full(name,description,summary)');
        if (! array_key_exists('fullname', $indexesFound)) {
            \DB::statement('ALTER TABLE icommerce__product_translations ADD FULLTEXT fullName(name)');
        }
        if (! array_key_exists('fullnamedescription', $indexesFound)) {
            \DB::statement('ALTER TABLE icommerce__product_translations ADD FULLTEXT fullNameDescription(name,description)');
        }
        if (! array_key_exists('fullnamesummary', $indexesFound)) {
            \DB::statement('ALTER TABLE icommerce__product_translations ADD FULLTEXT fullNameSummary(name,summary)');
        }
        if (! array_key_exists('fulldescription', $indexesFound)) {
            \DB::statement('ALTER TABLE icommerce__product_translations ADD FULLTEXT fullDescription(description)');
        }
        if (! array_key_exists('fulldescriptionsummary', $indexesFound)) {
            \DB::statement('ALTER TABLE icommerce__product_translations ADD FULLTEXT fullDescriptionSummary(description,summary)');
        }
        if (! array_key_exists('fullsummary', $indexesFound)) {
            \DB::statement('ALTER TABLE icommerce__product_translations ADD FULLTEXT fullSummary(summary)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
