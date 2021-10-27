<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = array();

    public function salary()
    {
        return $this->belongsTo('App\Salary', 'salary_id');
    }

    public function getData()
    {
        return static::with(['salary'])->orderBy('created_at', 'desc')->get();
    }

    public function storeData($input)
    {
        return static::create($input);
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function updateData($id, $input)
    {
        return static::find($id)->update($input);
    }

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}
