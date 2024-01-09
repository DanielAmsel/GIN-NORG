<?php

namespace App\Fhir;
use App\Models\Sample;
use App\Models\ShippedSample;
use App\Models\RemovedSample;

class LocationResource
{
    /**
     * Sammelt alle Proben aus den verschiedenen Tabellen und führt ein FHIR Mapping durch.
     */
    public static function convertAllSamplesToFhirLocations()
    {
        $allSamples = collect(); // Sammlung für alle Proben

        // Aktive Proben
        $activeSamples = Sample::all(); 
        foreach ($activeSamples as $sample) {
            $allSamples->push(self::mapToLocationResource($sample, 'active', 'S'));
        }
 
        // Verschickte Proben
        $shippedSamples = ShippedSample::all();
        foreach ($shippedSamples as $shipped) {
            $allSamples->push(self::mapToLocationResource($shipped, 'inactive', 'Sh'));
        }

        // Entfernte Proben
        $removedSamples = RemovedSample::all();
        foreach ($removedSamples as $removed) {
            $allSamples->push(self::mapToLocationResource($removed, 'suspended', 'R'));
        }

        return $allSamples; // Gibt eine Sammlung von FHIR Locations zurück
    }

    /**
     * Erstellt eine FHIR Location Ressource aus einer Probe.
     */

    protected static function mapToLocationResource($sample, $status, $prefix) {
        return [
            'resourceType' => 'Location',
            'id' => $prefix . '-' . $sample->id, // combines prefix with id from active/shipped/removed sample table
            'status' => $status, // 'active', 'inactive', or 'suspended'
            'identifier' => [
                [
                    'use' => 'official',
                    'value' => $sample->identifier  // unique identifier of the sample
                ],
            ],
            'name' => ($status == 'active') ? $sample->pos_tank_nr : null,
            'type' => [
                [
                    'text' => $sample->type_of_material,
                ],
            ],
            'position' => ($status == 'active') ? [
                'longitude' => $sample->pos_insert, 
                'latitude' => $sample->pos_tube, 
                'altitude' => $sample->pos_smpl 
            ] : null,
            'contact' => [
                [
                    'telecom' => [
                        [
                            'system' => 'email',
                            'value' => $sample->responsible_person
                        ]
                    ]
                ]
            ],
            'address' => ($status == 'inactive') ? [
                'line' => [$sample->shipped_to] 
            ] : 
            [   // please replace address-data
                'line' => ["Institut fuer Neuropathologie", "Arndtstr. 16"],
                'city' => "Giessen",
                'state' => "Hessen",
                'postalCode' => "35392",
                'country' => "Germany"
            ],
        ];
    }
}