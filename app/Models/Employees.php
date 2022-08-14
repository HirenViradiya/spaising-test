<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Employees extends Model
{
    use HasFactory;

    public function saveEmployees($data)
    {
        if (isset($data['id'])) {
            $empModel = Employees::find($data['id']);
        } else {
            $empModel = new Employees();
        }

        $empModel->first_name = $data['first_name'];
        $empModel->last_name = $data['last_name'];
        $empModel->address = $data['address'];
        $empModel->email = $data['email'];
        $empModel->phone = $data['phone'];
        $empModel->gender = $data['gender'];
        $empModel->department = $data['department'];
        $empModel->image = $data['image'] ? $data['image']->getClientOriginalName() : "";

        if ($empModel->save()) {
            return $empModel;
        } else {
            return false;
        }
    }

    public function showEmployees()
    {
        $employees = Employees::all()->toArray();
        $list = [];
        $i    = 0;

        foreach ($employees as $key) {
            if ($key['image']) {
                $key['image'] = URL::to('/uploads/images/') . '/' . $key['image'];
            }
            $list[$i] = $key;
            $i++;
        }
        return $list;
    }
}
