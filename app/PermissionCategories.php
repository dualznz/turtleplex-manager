<?php

namespace App;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class PermissionCategories extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order', 'name', 'description'
    ];

    public function permissions()
    {
        return Permission::where('category_id', $this->id)->get();
    }

    public function countPermissions()
    {
        return Permission::where('category_id', $this->id)->count();
    }
}
