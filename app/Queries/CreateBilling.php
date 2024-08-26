<?php

namespace App\Queries;

use App\Models\Billing;
use App\Models\BillingItem;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CreateBilling extends Query
{
    private BillingById $billingById;

    public function __construct(BillingById $billingById)
    {
        $this->billingById = $billingById;
    }

    protected function query() : Builder
    {
        $product = $this->use('product');
        $contract = $this->use('contract');

        $billing = Billing::create([
            'uuid' => $this->uuid(),
            'description' => $this->description(),
            'contract_id' => $contract['id'],
            'expire_at' => $this->dbDate(day: $contract['expire_day']),
            'installment' => 1,
        ]);

        BillingItem::create([
            'billing_id' => $billing->id,
            'sku' => $product['sku'],
            'title' => $product['title'],
            'price' => $product['price'],
            'qty' => 1,
        ]);

        return $this->billingById->param('id', $billing->id)->run();
    }

    private function description() : string
    {
        $title = $this->use('product')['title'];
        $domain = $this->use('contract')['domain'];
        $expire = $this->brDate(day: $this->use('contract')['expire_day']);
        return "Fatura referente a assinatura {$title} com vencimento em {$expire} para o domínio {$domain}";
    }
}
