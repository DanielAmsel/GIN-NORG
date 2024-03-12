<?php

namespace App\Fhir;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FhirClient
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://fhir-hapi-container:8080/fhir/';
        $this->client = new Client(['base_uri' => $this->baseUrl]);
    }
    
    /**
     * createResource
     *
     * @param  mixed $resourceType
     * @param  mixed $locations
     * @return void
     */
    public function createResource($resourceType, $locations)
    {
        try {
            $response = $this->client->request('POST', $resourceType, [
                'json' => $locations,
                'headers' => [
                    'Content-Type' => 'application/fhir+json',
                    'Accept' => 'application/fhir+json',
                ],
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
    
    /**
     * deleteResource
     *
     * @param  mixed $resourceType
     * @param  mixed $resourceId
     * @return void
     */
    public function deleteResource($resourceType, $resourceId)
    {

        try {
            $response = $this->client->request('DELETE', $resourceType . '/' . $resourceId, [
                'headers' => [
                    'Accept' => 'application/fhir+json',
                ],
        ]);
    
            return json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
    
    /**
     * updateResource
     *
     * @param  mixed $resourceType
     * @param  mixed $resourceId
     * @param  mixed $data
     * @return void
     */
    public function updateResource($resourceType, $resourceId, $data)
    {

        try {
            $response = $this->client->request('PUT', $resourceType . '/' . $resourceId, [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/fhir+json',
                    'Accept' => 'application/fhir+json',
                ],
        ]);

            return json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
    
    /**
     * getResource
     *
     * @param  mixed $resourceType
     * @param  mixed $identifier
     * @return void
     */
    public function getResource($resourceType, $identifier)
    {
        try {
            // Send a GET request to search for resources with the given identifier
            $response = $this->client->request('GET', $resourceType . '/_search', [
                'query' => ['identifier' => $identifier],
                'headers' => [
                    'Accept' => 'application/fhir+json',
                ],
            ]);
    
            // Decode the response body to extract the search results
            $data = json_decode((string) $response->getBody(), true);
    
            // Check if any resources were found
            if (isset($data['entry']) && is_array($data['entry']) && count($data['entry']) > 0) {
                // Return the ID of the first matching resource found
                return $data['entry'][0]['resource']['id'];
            } else {
                // No matching resource found
                return null;
            }
        } catch (GuzzleException $e) {
            // Handle any errors that occur during the request
            throw $e;
        }
    }    
}