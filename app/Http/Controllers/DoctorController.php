<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    //
    public function consult()
{
    $doctors = User::where('role', 'doctor')
                   ->where('is_approved', 1)
                   ->get();

    return view('patient.consult', compact('doctors'));
}
}
