<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreLeadRequest;
use App\Http\Requests\V1\UpdateLeadRequest;
use App\Models\Lead;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AddressResource;
use App\Http\Resources\V1\LeadResource;
use App\Http\Resources\V1\LeadCollection;
use App\Models\Address;
use App\Services\V1\LeadQuery;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = new LeadQuery();
        $queryItems = $query->transform($request);
        $leads = Lead::where($queryItems)
            ->whereNull('deleted_at')
            ->with('address');

        $bill_threshold = env('ELECTRIC_BILL_THRESHOLD', 250);
        $quality = $request->query('quality');

        if ($quality) {
            if ($quality === 'premium') {
                $leads->where('electric_bill', '>=', $bill_threshold);
            } elseif ($quality === 'standard') {
                $leads->where('electric_bill', '<', $bill_threshold);
            }
        }

        return new LeadCollection($leads->paginate()->appends($request->query()));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request)
    {
        $request_params = $request->all();        
        $lead = new LeadResource(Lead::create($request->all()));
        $request_params['lead_id'] = $lead->id;
        $address = new AddressResource(Address::create($request_params));

        return response()->json(['lead' => $lead, 'address' => $address]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return response()->json([
            'lead' => new LeadResource($lead), 
            'address' => new AddressResource($lead->address)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpdateLeadRequest $request, Lead $lead)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $lead->update($request->all());
        return new LeadResource($lead);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead_id = $lead->id;
        $code = 200;
        $message = '';

        try{
            $lead->delete();
            $message = sprintf('Lead with ID: %d successfully deleted', $lead_id);
        } catch (Throwable $e) {
            $code = 500;
            $message = $e->getMessage();
        }

        return response()->json([
            'code' => $code,
            'message' => $message
        ]);
    }
}
