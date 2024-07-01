<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function tableName(): string
    {
        $tableName = config('emailviewer.servers.database.table_name', 'email_viewer_emails');

        if (empty($tableName)) {
            throw new \RuntimeException('Error: config/emailviewer.php not loaded. Run [php artisan config:clear] and try again.');
        }

        return $tableName;
    }

    public function up(): void
    {
        Schema::create($this->tableName(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('subject')->nullable();
            $table->longText('raw');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop($this->tableName());
    }
};
