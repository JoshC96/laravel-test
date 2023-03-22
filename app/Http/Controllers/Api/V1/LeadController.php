<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreLeadRequest;
use App\Http\Requests\V1\UpdateLeadRequest;
use App\Models\Lead;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AddressResource;
use App\Http\Resources\V1\LeadResource;
use App\Services\V1\LeadQuery;
use Illuminate\Http\Request;

/**
 * @package App\Http\Controllers\Api\V1
 */
class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = new LeadQuery();
        return $query->getIndexResults($request);        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request)
    {
        $query = new LeadQuery();
        return $query->createLeadFromApi($request); 
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
        $query = new LeadQuery();
        return $query->deleteLeadFromApi($lead);
    }
}
