<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Contact extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'contact.name'      => 10,
            'contact.email'     => 10,
            'contact.mobile'    => 10,
            'contact.title'     => 10,
            'contact.message'   => 10,
        ]
    ];

    public function status() {
        return $this->status == 1 ? 'Read' : 'New';
    }
}
