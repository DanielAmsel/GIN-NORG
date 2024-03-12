<?php

namespace App\Fhir;
use App\Models\Sample;
use App\Models\ShippedSample;
use App\Models\RemovedSample;
use Illuminate\Support\Facades\Auth;

class LocationResourceActiveSample
{
    /**
     * Erstellt eine FHIR Location Ressource aus einer aktiven Probe.
     */
     public static function mapToLocationResource($sample, $resourceId) {
        return [
            'resourceType' => 'Location',
            'id' => $resourceId,
            'status' => 'active',
            'identifier' => [
                [
                    'use' => 'official',
                    'value' => $sample['identifier'] 
                ],
            ],
            'name' => $sample['tank_pos'],
            'type' => [
                [
                    'text' => $sample['materialtyp'],
                ],
            ],
            'position' => [
                'longitude' => $sample['con_pos'], 
                'latitude' => $sample['tube_pos'], 
                'altitude' => $sample['sample_pos'] 
            ],
            'contact' => [
                [
                    'telecom' => [
                        [
                            'system' => 'email',
                            'value' => Auth::user()->email
                        ]
                    ]
                ]
            ],
            'address' => 
            [   
                'line' => ["Institut fuer Neuropathologie", "Arndtstr. 16"],
                'city' => "Giessen",
                'state' => "Hessen",
                'postalCode' => "35392",
                'country' => "Germany"
            ],
        ];
    }
    
    /**
     * mapToLocationResourceUpdateShip
     *
     * @param  mixed $sample
     * @param  mixed $resourceId
     * @return void
     */
    public static function mapToLocationResourceUpdateShip($sample, $resourceId) {
        return [
            'resourceType' => 'Location',
            'id' => $resourceId,
            'status' => 'inactive',
            'identifier' => [
                [
                    'use' => 'official',
                    'value' => $sample['identifier']
                ],
            ],
            'name' => null,
            'position' => [
                'longitude' => null, 
                'latitude' => null, 
                'altitude' => null 
            ],
            'contact' => [
                [
                    'telecom' => [
                        [
                            'system' => 'email',
                            'value' => Auth::user()->email
                        ]
                    ]
                ]
            ],
            'address' => 
            [   
                'line' => $sample['address'],
                'city' => null,
                'state' => null,
                'postalCode' => null,
                'country' => null
            ],
        ];
    }
}