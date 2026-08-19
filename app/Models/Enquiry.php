<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Enquiry extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'ticket_number',
        'name',
        'email',
        'phone',
        'company',
        'type',
        'service_id',
        'product_id',
        'subject',
        'message',
        'urgency',
        'preferred_contact',
        'status',
        'admin_notes',
        'ip_address',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Enquiry $enquiry): void {
            if (empty($enquiry->ticket_number)) {
                $enquiry->ticket_number = 'COM-'.strtoupper(Str::random(6));
            }
        });
    }

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
