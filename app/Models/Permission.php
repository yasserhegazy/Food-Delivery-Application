<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the roles that have this permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    /**
     * Common permission constants.
     */
    const VIEW_ORDERS = 'view-orders';
    const CREATE_ORDERS = 'create-orders';
    const MANAGE_MENU = 'manage-menu';
    const MANAGE_RESTAURANT = 'manage-restaurant';
    const ACCEPT_DELIVERIES = 'accept-deliveries';
    const MANAGE_USERS = 'manage-users';
    const VIEW_ANALYTICS = 'view-analytics';
    const MANAGE_SETTINGS = 'manage-settings';
}
