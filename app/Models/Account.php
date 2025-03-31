<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Account",
 *     title="Account",
 *     description="Account model",
 *     @OA\Property(property="id", type="integer", description="Account ID"),
 *     @OA\Property(property="login", type="string", description="Login username"),
 *     @OA\Property(property="password", type="string", description="Hashed password"),
 *     @OA\Property(property="phone", type="string", description="Phone number"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp")
 * )
 */

class Account extends Model
{
    protected $guarded = [];

    protected $hidden = ['password'];
}
