<?php

namespace App\Services;

use Facades\App\Invoice;
use App\Account;
use App\Lease;
use App\Unit;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use ReflectionClass;

class InvoiceService
{
    /**
     * The currency code of the default currency e.g. AED, KWD.
     * @var string
     */
    private $defaultCurrency;

    /**
     * The two-letter language code e.g. en, ar.
     * @var string
     */
    private $defaultLanguage;

    public function __construct()
    {
        $this->defaultCurrency = config('app.invoice.defaultCurrency');
        $this->defaultLanguage = config('app.defaultLanguage');
    }

    /**
     * Creates an Invoice by the given model.
     * @param Model $model
     * @return mixed
     * @throws \ReflectionException
     */
    function createInvoice(Model $model)
    {
        $class = (new ReflectionClass($model))->getShortName();

        $methodName = 'createInvoiceBy' . $class;
        if (!method_exists($this, $methodName)) {
            throw new InvalidArgumentException('Invoice generation by ' . $class . ' model is not supported.');
        }

        return call_user_func([$this, $methodName], $model);
    }

    /**
     * Creates an Invoice by an Account model.
     * @param Account $account
     * @return
     */
    public function createInvoiceByAccount(Account $account)
    {
        $invoice = Invoice::newInstance();
        $invoice->entity()->associate($account);
        $invoice->billing_address_id = 1;
        $invoice->currency = $this->defaultCurrency;
        $invoice->language = $this->defaultLanguage;
        $invoice->user_id = auth()->id();

        // calculate the invoice number
        $invoice->prefix = 'ACCNT';
        $invoice->number = Invoice::where('prefix', $invoice->prefix)->max('number') + 1;

        // add line items

        // set calculated field value e.g. number, sub total, total

        // set the status to due

        $invoice->save();

        return $invoice;
    }

    /**
     * Creates an Invoice by a Unit model.
     * @param Unit $unit
     * @return
     */
    public function createInvoiceByUnit(Unit $unit)
    {
        $invoice = Invoice::newInstance();
        $invoice->entity()->associate($unit);
        $invoice->billing_address_id = 1;
        $invoice->currency = $this->defaultCurrency;
        $invoice->language = $this->defaultLanguage;
        $invoice->user_id = auth()->id();

        // calculate the invoice number
        $invoice->prefix = 'UNT';
        $invoice->number = Invoice::where('prefix', $invoice->prefix)->max('number') + 1;

        // add line items

        // set calculated field value e.g. number, sub total, total

        // set the status to due

        return $invoice;
    }

    /**
     * Creates an Invoice by a Lease model.
     * @param Lease $lease
     * @return
     */
    public function createInvoiceByLease(Lease $lease)
    {
        $invoice = Invoice::newInstance();
        $invoice->entity()->associate($lease);
        $invoice->billing_address_id = 1;
        $invoice->currency = $this->defaultCurrency;
        $invoice->language = $this->defaultLanguage;
        $invoice->user_id = auth()->id();

        // calculate the invoice number
        $invoice->prefix = 'LS';
        $invoice->number = Invoice::where('prefix', $invoice->prefix)->max('number') + 1;

        // add line items

        // set calculated field value e.g. number, sub total, total

        // set the status to due

        return $invoice;
    }
}