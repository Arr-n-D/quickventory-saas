<?php

namespace App\Models;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Domain as ModelsDomain;

/**
 * @property-read integer $id
 * @property string $domain
 * @property integer $tenant_id
 *
 * @property-read Tenant| $tenant
 */
class TenantDomain extends ModelsDomain
{
    use HasFactory;

    protected $table = 'tenant_domains';

    /**
     * @return BelongsTo|Tenant
     */
    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

}
