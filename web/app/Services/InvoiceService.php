<?php

namespace App\Services;

use App\Exceptions\EntityCreateException;
use Facades\App\Invoice;
use App\Account;
use App\Lease;
use App\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
     * @throws EntityCreateException
     */
    public function createInvoiceByAccount(Account $account)
    {
        /** @var \App\Invoice $invoice */
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
        $invoice->addLineItem('Admin Fee', 1, 100, 5);

        // set calculated field value e.g. number, sub total, total
        $invoice->sub_total = $invoice->lineItems()->sum(DB::raw('quantity * price'));
        $invoice->total = $invoice->lineItems()->sum(DB::raw('quantity * price * tax / 100'));

        // set the status to due
        $invoice->status = 1;

        // save the entity
        if (!$invoice->save()) {
            throw new EntityCreateException();
        }

        return $invoice;
    }

    /**
     * Creates an Invoice by a Unit model.
     * @param Unit $unit
     * @return
     * @throws EntityCreateException
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

        // save the entity
        if (!$invoice->save()) {
            throw new EntityCreateException();
        }

        return $invoice;
    }

    /**
     * Creates an Invoice by a Lease model.
     * @param Lease $lease
     * @return
     * @throws EntityCreateException
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

        // save the entity
        if (!$invoice->save()) {
            throw new EntityCreateException();
        }

        return $invoice;
    }
}