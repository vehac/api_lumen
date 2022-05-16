<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Clients extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $tableName = 'clients';
        
        Schema::create($tableName, function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id()->autoIncrement();
            $table->string('name', 50)->nullable()->collation('utf8mb4_unicode_ci')->comment('nombre del cliente');
            $table->string('lastname', 100)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('image', 200)->nullable()->collation('utf8mb4_unicode_ci');
            $table->char('gender', 1)->nullable()->collation('utf8mb4_unicode_ci')->comment('F: femenino - M: masculino');
            $table->text('description')->collation('utf8mb4_unicode_ci')->comment('descripción para el cliente');
            $table->string('phone', 15)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('country', 50)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('address', 150)->nullable()->collation('utf8mb4_unicode_ci');
            $table->date('birth_date')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
        
        DB::statement("ALTER TABLE `$tableName` comment 'tabla de clientes'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        $tableName = 'clients';
        Schema::dropIfExists($tableName);
    }
}
