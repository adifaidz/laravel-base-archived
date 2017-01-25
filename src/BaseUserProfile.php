<?php

namespace AdiFaidz\Base;

use Illuminate\Database\Eloquent\Model;
use AdiFaidz\Base\Traits\TableInfoTrait;

class BaseUserProfile extends Model
{
    use TableInfoTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('basetrust.userprofiles_table');
    }

    protected $dates = [
      'dob',
    ];

    public function user()
    {
        return $this->belongsTo(config('basetrust.user'), config('basetrust.user_foreign_key'));
    }
}
