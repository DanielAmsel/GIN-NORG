<?php

return [
    'fhir' => [
        'enabled' => true, // Set this to false to disable FHIR
         // The institute's own address information
         'institute_address' => [
            // Address lines, including the name of the institute and street address
            'line' => ["Institut fuer Neuropathologie", "Arndtstr. 16"],
            'city' => "Giessen", // The city where the institute is located
            'state' => "Hessen", // The state or region where the institute is located
            'postalCode' => "35392", // The postal code for the institute's location
            'country' => "Germany", // The country where the institute is located
        ],
    ],
];