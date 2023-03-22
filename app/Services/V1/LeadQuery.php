<?php

namespace App\Services\V1;

use App\Http\Resources\V1\AddressResource;
use App\Http\Resources\V1\LeadCollection;
use App\Http\Resources\V1\LeadResource;
use App\Models\Address;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Throwable;

/**
 * 
 * @package App\Services\V1
 */
class LeadQuery
{
    /**
     * @var int
     */
    protected $defaultThreshold = 250;

    /**
     * 
     * @var string[][]
     */
    protected $allowedFields = [
        'id' => ['=', '<', '>'],
        'firstName' => ['=', 'like'],
        'lastName' => ['=', 'like'],
        'email' => ['=', 'like'], // would like to add an 'ilike' operator but doesn't work on MySQL
        'phone' => ['='],
        'electricBill' => ['=', '<', '>'],
    ];

    /**
     * 
     * @var string[]
     */
    protected $columnMap = [
        'electricBill' => 'electric_bill',
        'firstName' => 'first_name',
        'lastName' => 'last_name',
    ];

    /**
     * @return int 
     */
    public function getDefaultThreshold(): int
    {
        return $this->defaultThreshold;
    }

    /**
     * @param int $threshold 
     * @return void 
     */
    public function setDefaultThreshold(int $threshold): void
    {
        $this->defaultThreshold = $threshold;
    }

    /**
     * @param Request $request 
     * @return array 
     */
    public function transform(Request $request): array
    {
        $eloQuery = [];

        foreach ($this->allowedFields as $field => $operators) {
            $query = $request->query($field);

            if(!isset($query)) continue;

            $column = $this->columnMap[$field] ?? $field;

            foreach ($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloQuery[] = [$column, $operator, $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }

    /**
     * @param Request $request 
     * @return LeadCollection 
     * @throws InvalidArgumentException 
     */
    public function getIndexResults(Request $request): LeadCollection
    {
        $queryItems = $this->transform($request);
        $quality = $request->query('quality');
        $leads = Lead::where($queryItems)
            ->whereNull('deleted_at')
            ->with('address');

        if ($quality) {
            $billThreshold = env('ELECTRIC_BILL_THRESHOLD', $this->getDefaultThreshold());

            if ($quality === 'premium') {
                $leads->where('electric_bill', '>=', $billThreshold);
            } elseif ($quality === 'standard') {
                $leads->where('electric_bill', '<', $billThreshold);
            }
        }

        return new LeadCollection($leads->paginate()->appends($request->query()));
    }

    /**
     * @param Request $request 
     * @return JsonResponse 
     * @throws BindingResolutionException 
     */
    public function createLeadFromApi(Request $request): JsonResponse
    {
        $request_params = $request->all();
        $lead = new LeadResource(Lead::create($request->all()));
        $request_params['lead_id'] = $lead->id;
        $address = new AddressResource(Address::create($request_params));

        return response()->json(['lead' => $lead, 'address' => $address]);
    }

    public function deleteLeadFromApi(Lead $lead)
    {
        $lead_id = $lead->id;
        $code = 200;
        $message = '';

        try {
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