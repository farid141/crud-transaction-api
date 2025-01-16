<?php

namespace App\Models;

use App\Events\TransactionCreated;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type',
        'customer_email',
        'customer_name',
        'total_amount',
        'supplier_name',
        'notes',
        'created_by_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:H:i:s - d M, Y',
            'updated_at' => 'datetime:H:i:s - d M, Y',
        ];
    }

    /**
     * The event map for the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'created' => TransactionCreated::class,
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function transaction_items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
