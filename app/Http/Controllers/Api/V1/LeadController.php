<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LeadRequest;
use App\Http\Requests\V1\LeadResource;
use App\Models\Lead;

class LeadController extends Controller 
{


    public function index()
    {
        return Lead::all();
    }

    public function show(Lead $lead)
    {
        return new LeadResource($lead);
    }

    public function createLead(LeadRequest $request) 
    {
        return new LeadResource(Lead::create($request->all()));
    }

}