<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class represents an Invoice Line Item model.
 *
 * @property int $id
 * @property string $description
 * @property int $quantity
 * @property int $price
 * @property int $tax
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Invoice $invoice
 */
class InvoiceLineItem extends Model
{
    /**
     * Defines invoice relation.
     */
    public function invoice()
    {
        $this->belongsTo(Invoice::class);
    }
}
