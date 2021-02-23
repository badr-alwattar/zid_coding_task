<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShipmentCreateRequest;
use App\Http\Requests\ShipmentFileUploadRequest;
use App\Http\Requests\StatusIdRequest;
use App\Http\Requests\ShipmentDeliveryRequest;
use Auth;
use Storage;
use App\Models\Shipment;
use App\Models\Document;

class ShipmentController extends Controller
{
    public function store(ShipmentCreateRequest $request) {
        Auth::user()->shipments()->create(array_merge($request->validated(),['tracking_number' => now()]));
        return response()->json(['message' => 'Successfully created shipment!'], 201);
    }

    public function printShipments(Request $request) {
        $shipments = Shipment::query();

        if(isset($request->shipments) && count($request->shipments) > 0)
            $shipments->whereIn('id', $request->shipments);

        return response()->json(['shipments' => $shipments->get()], 200);
    }

    public function file_upload(ShipmentFileUploadRequest $request) {
        $shipment = Shipment::findOrFail($request->shipment_id);

        $data = $request->validated();
        $data['file'] = Storage::disk('public')->put('shipments_documents', $data['file']);

        $shipment->documents()->create($data);

        return response()->json(['message' => 'Successfully added shipment document!'], 201);
    }

    public function get_status(Shipment $shipment) {
        return response()->json(['status' => $shipment->status], 200);
    }

    public function update_status(StatusIdRequest $request, Shipment $shipment) {
        $shipment->update($request->validated());
        return response()->json(['message' => 'Successfully updated shipment status!'], 200);
    }

    public function assign_shipment_driver(Shipment $shipment) {
        $shipment->update(['driver_id' => Auth::id()]);
        return response()->json(['message' => 'Successfully assigned shipment to driver!'], 200);
    }

    public function schedule_delivery(ShipmentDeliveryRequest $request, Shipment $shipment){
        $shipment->update($request->validated());
        return response()->json(['message' => 'Successfully scheduled shipment delivery!'], 200);
    }
}
