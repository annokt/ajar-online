<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class represents an Invoice model.
 *
 * @property int $id
 * @property int $entity_id
 * @property string $entity_type
 * @property int $billing_address_id
 * @property string $prefix
 * @property int $number
 * @property string $currency
 * @property int $due_at
 * @property int $status
 * @property string $note
 * @property string $language
 * @property int $sub_total
 * @property int $total
 * @property int $tax_registration_number
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Model entity
 * @property User user
 * @property Address billingAddress
 * @property InvoiceLineItem[] lineItems
 */
class Invoice extends Model
{
    const STATUS_NEW = 0;
    const STATUS_DUE = 1;
    const STATUS_OVERDUE = 2;
    const STATUS_CANCELLED = 3;

    /**
     * Defines the related entity relation.
     * Please note that the Invoice is generated against the entity
     * which can be a Lease, Unit, Account etc.
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Defines the user relation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines the billing address relation.
     */
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * Defines the line items relation.
     */
    public function lineItems()
    {
        return $this->hasMany(InvoiceLineItem::class);
    }

    /**
     * Creates a new line item.
     * @param $description
     * @param $quantity
     * @param $price
     * @param $tax
     */
    public function addLineItem($description, $quantity, $price, $tax = null)
    {
        $this->lineItems()->create(compact('description', 'quantity', 'price', 'tax'));
    }
}
