<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShipmentCreateRequest;
use Auth;
class ShipmentController extends Controller
{
    public function store(ShipmentCreateRequest $request) {
        $request->validated()['tracking_number'] = now();
        dd($request->validated());
        Auth::user()->shipments()->create($request->validated());
    }
}
