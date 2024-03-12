<?php

namespace App\Fhir;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class FhirService
{
    protected $fhirClient;
    protected $resourceType;

    public function __construct()
    {
        $this->fhirClient = new FhirClient();
        $this->resourceType = 'Location';
    }
    
    /**
     * sendToFhirServer
     *
     * @param  mixed $request
     * @return void
     */
    public function sendToFhirServer(Request $request)
    {
        $action = $request->action;

        switch ($action) {
            case 'create':
                return $this->createResource($request);
            case 'delete':
                return $this->deleteResource($request);
            case 'update':
                return $this->updateResource($request);
            case 'updateRestore':
                return $this->updateRestoreResource($request);
            default:
                return response()->json(['error' => 'Unknown action'], 400);
        }
    }
    
    /**
     * createResource
     *
     * @param  mixed $request
     * @return void
     */
    protected function createResource(Request $request)
    {
        $resourceData = $request->all();

        $resourceId = null;

        $locations = LocationResourceActiveSample::mapToLocationResource($resourceData, $resourceId);

        try {
            $response = $this->fhirClient->createResource($this->resourceType, $locations);
            return response()->json(['message' => 'Sample sent to FHIR server successfully'], 200);
        } catch (GuzzleException $e) {
            \Log::error('FHIR Server Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send sample to FHIR server'], 500);
        }
    }
    
    /**
     * deleteResource
     *
     * @param  mixed $request
     * @return void
     */
    protected function deleteResource(Request $request)
    {
        $identifier = $request->input('identifier');

        // Find the resource ID in FHIR based on the identifier
        $resourceId = $this->fhirClient->getResource($this->resourceType, $identifier);

        // If the resource ID is null, the resource was not found in FHIR
        if ($resourceId === null) {
            return response()->json(['error' => 'Resource not found in FHIR'], 404);
        }
        
        try {
            $response = $this->fhirClient->deleteResource($this->resourceType, $resourceId);
            return response()->json(['message' => 'Sample deleted from FHIR server successfully'], 200);
        } catch (GuzzleException $e) {
            \Log::error('FHIR Server Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete sample from FHIR server'], 500);
        }
    }
    
    /**
     * updateResource
     *
     * @param  mixed $request
     * @return void
     */
    protected function updateResource(Request $request)
    {
        $identifier = $request->input('identifier');

        // Find the resource ID in FHIR based on the identifier
        $resourceId = $this->fhirClient->getResource($this->resourceType, $identifier);
        
        // Get the updated resource data from the request
        $updatedData = $request->all();
        
        $locations = LocationResourceActiveSample::mapToLocationResourceUpdateShip($updatedData, $resourceId);

        try {
            // Call the FHIR client's updateResource method
            $response = $this->fhirClient->updateResource($this->resourceType, $resourceId, $locations);
            
            // Handle successful update response
            return response()->json(['message' => 'Resource updated in FHIR server successfully'], 200);
        } catch (GuzzleException $e) {
            \Log::error('FHIR Server Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update resource in FHIR server'], 500);
        }
    }
    
    /**
     * updateRestoreResource
     *
     * @param  mixed $request
     * @return void
     */
    protected function updateRestoreResource(Request $request)
    {
        $identifier = $request->input('identifier');

        // Find the resource ID in FHIR based on the identifier
        $resourceId = $this->fhirClient->getResource($this->resourceType, $identifier);

        // Get the updated resource data from the request
        $updatedData = $request->all();
        
        $locations = LocationResourceActiveSample::mapToLocationResource($updatedData, $resourceId);

        try {
            // Call the FHIR client's updateResource method
            $response = $this->fhirClient->updateResource($this->resourceType, $resourceId, $locations);
            
            // Handle successful update response
            return response()->json(['message' => 'Resource updated in FHIR server successfully'], 200);
        } catch (GuzzleException $e) {
            \Log::error('FHIR Server Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update resource in FHIR server'], 500);
        }
    }
    
}