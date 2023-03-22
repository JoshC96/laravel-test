<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreLeadRequest;
use App\Http\Requests\V1\UpdateLeadRequest;
use App\Models\Lead;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AddressResource;
use App\Http\Resources\V1\LeadCollection;
use App\Http\Resources\V1\LeadResource;
use App\Services\V1\LeadQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Request;
use InvalidArgumentException;

/**
 * @package App\Http\Controllers\Api\V1
 */
class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request $request 
     * @return LeadCollection 
     * @throws InvalidArgumentException 
     */
    public function index(Request $request): LeadCollection
    {
        $query = new LeadQuery();
        return $query->getIndexResults($request);        
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param StoreLeadRequest $request 
     * @return JsonResponse 
     * @throws BindingResolutionException 
     */
    public function store(StoreLeadRequest $request): JsonResponse
    {
        $query = new LeadQuery();
        return $query->createLeadFromApi($request); 
    }

    /**
     * Display the specified resource.
     * 
     * @param Lead $lead 
     * @return JsonResponse 
     * @throws BindingResolutionException 
     */
    public function show(Lead $lead): JsonResponse
    {
        return response()->json([
            'lead' => new LeadResource($lead), 
            'address' => new AddressResource($lead->address)
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param UpdateLeadRequest $request 
     * @param Lead $lead 
     * @return LeadResource 
     * @throws MassAssignmentException 
     */
    public function update(UpdateLeadRequest $request, Lead $lead): LeadResource
    {
        $lead->update($request->all());
        return new LeadResource($lead);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param Lead $lead 
     * @return JsonResponse 
     * @throws BindingResolutionException 
     */
    public function destroy(Lead $lead): JsonResponse
    {
        $query = new LeadQuery();
        return $query->deleteLeadFromApi($lead);
    }
}
