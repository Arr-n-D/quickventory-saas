<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Domain as ModelsDomain;

/**
 * @property-read integer $id
 * @property string $domain
 * @property integer $customer_id
 *
 * @property-read Customer| $customer
 */
class CustomerDomain extends ModelsDomain
{
    use HasFactory;

    protected $table = 'customer_domains';

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
