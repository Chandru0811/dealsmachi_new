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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned();
            $table->text('name')->nullable();
            $table->text('legal_name')->nullable();
            $table->string('slug', 200)->unique();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->longtext('description')->nullable();
            $table->string('external_url')->nullable();
            $table->text('street');
            $table->text('street2')->nullable();    
            $table->string('city');
            $table->string('zip_code');
            $table->string('country');
            $table->string('state');
            //$table->integer('timezone_id')->nullable();
            $table->string('current_billing_plan')->default('free');
            //bank transfer
            $table->text('account_holder')->nullable();
            $table->string('account_type')->nullable();
            $table->string('account_number')->nullable();  //account_number
            $table->string('bank_name')->nullable();
            $table->text('bank_address')->nullable();
            $table->string('bank_code')->nullable();
            //online transfer
            $table->string('payment_id')->nullable();
            $table->timestamp('trial_ends_at')->nullable(); 
            $table->boolean('active')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
