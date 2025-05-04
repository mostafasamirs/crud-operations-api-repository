<?php

namespace App\Helpers\Database;

use Illuminate\Database\Schema\Blueprint;

class MigrationHelper
{
    /**
     * Generates columns required for SEO
     *
     * @param Blueprint $table
     */
    public static function seoColumns(Blueprint $table)
    {
        $table->text('meta_title')->nullable();
        $table->text('meta_keywords')->nullable();
        $table->text('meta_description')->nullable();
        $table->text('meta_tags')->nullable();
    }
}
