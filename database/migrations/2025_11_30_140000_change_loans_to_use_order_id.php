<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Delete existing loans since they're based on products, not orders
        DB::table('loans')->truncate();
        
        // Drop foreign keys using raw SQL if they exist
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'loans' 
            AND CONSTRAINT_NAME LIKE '%_foreign'
        ");
        
        foreach ($foreignKeys as $fk) {
            if (strpos($fk->CONSTRAINT_NAME, 'order_id') !== false || strpos($fk->CONSTRAINT_NAME, 'product_id') !== false) {
                DB::statement("ALTER TABLE `loans` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
            }
        }
        
        Schema::table('loans', function(Blueprint $table) {
            // Drop order_id column if it exists
            if (Schema::hasColumn('loans', 'order_id')) {
                $table->dropColumn('order_id');
            }
            
            // Drop old product_id column if it exists
            if (Schema::hasColumn('loans', 'product_id')) {
                $table->dropColumn('product_id');
            }
        });
        
        // Now add order_id properly
        Schema::table('loans', function(Blueprint $table) {
            $table->foreignId('order_id')->after('user_id')->constrained()->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::table('loans', function(Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
            $table->foreignId('product_id')->after('user_id')->constrained()->onDelete('cascade');
        });
    }
};

