<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreLeadRequest;
use App\Http\Requests\V1\UpdateLeadRequest;
use App\Models\Lead;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LeadResource;
use App\Http\Resources\V1\LeadCollection;
use App\Services\V1\LeadQuery;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new LeadQuery();
        $queryItems = $filter->transform($request); //return new LeadCollection(Lead::paginate());

        if(count($queryItems) === 0) {
            return new LeadCollection(Lead::paginate());
        } else {
            return new LeadCollection(Lead::where($queryItems)->paginate());
        }
        
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        //
        return new LeadResource($lead);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
