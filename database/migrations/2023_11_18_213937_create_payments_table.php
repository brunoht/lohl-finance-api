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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('billing_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->date('billing_expire_at');
            $table->float('amount'); // valor original da cobrança
            $table->float('fees'); // juros e mora
            $table->float('transaction_amount'); // total da cobrança (amount + fees)
            $table->string('description');
            $table->string('payment_method_id');
            $table->string('date_of_expiration');
            $table->string('payer_email');
            $table->string('payer_first_name');
            $table->string('payer_last_name');
            $table->string('payer_identification_type')->default('CPF');
            $table->string('payer_identification_number');
            $table->string('status')->nullable();
            $table->string('date_approved')->nullable();
            $table->string('mercadopago_payment_id')->nullable();
            $table->longText('mercadopago_qr_code')->nullable();
            $table->longText('mercadopago_qr_code_base64')->nullable();
            $table->string('mercadopago_ticket_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
