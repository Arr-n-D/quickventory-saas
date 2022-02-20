<?php

namespace App\Models;

use App\Models\TenantDomain;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

/**
 * @property-read integer $id
 * @property string $tenant_db_name
 * @property integer $user_id
 * 
 * @property-read TenantDomain $domain
 * 
 */
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase, HasDomains;

    protected $table = 'tenants';

    public function getTenantKeyName(): string
    {
        return 'tenant_name';
    }

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'tenant_name',
            'user_id',
            'tenancy_db_username',
            'tenancy_db_password',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }

    public function getIncrementing()
    {
        return true;
    }

    public function getTenantKey()
    {
        return $this->getAttribute($this->getTenantKeyName());
    }

    public function domains() {
        return $this->hasMany(TenantDomain::class);
    }
}
