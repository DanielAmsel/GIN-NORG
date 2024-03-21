<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\MaterialType;
use App\Models\User;

class SampleImportController extends Controller
{
    public function showForm()
    {
        return view('import_form');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $fileData = array_map('str_getcsv', file($file));


        // Überprüfung der Anzahl der Spalten
        $minColumnCount = 9; // Mindestanzahl erwarteter Spalten
        $maxColumnCount = 10; // Maximalanzahl erwarteter Spalten
        foreach ($fileData as $row) {
            $columnCount = count($row);
            if ($columnCount < $minColumnCount || $columnCount > $maxColumnCount) {
                $errorMessage = "Das CSV hat nicht die erwartete Anzahl an Spalten.";
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
        }

        $validData = [];
        $missingMaterials = [];
        $missingPersons = [];
        

        // Überspringe leere Zeilen und Kopfzeile
        foreach ($fileData as $key => $row) {
            if (empty(array_filter($row)) || $key === 0) {
                unset($fileData[$key]);
            } else {
                break; // Stop, wenn wir die erste nicht-leere Zeile erreichen
            }
        }

        foreach ($fileData as $row) {
            // Überprüfen, ob die Zeile genügend Elemente enthält
            if (count($row) >= 10) {
                // Formatierung des Datums
                $formattedDate = $this->formatStorageDate($row[9]);

                $validData[] = [
                    'pos_tank_nr' => $row[1],
                    'pos_insert' => $row[2],
                    'pos_tube' => $row[3],
                    'pos_smpl' => $row[4],
                    'identifier' => $row[5],
                    'type_of_material' => $row[6],
                    'responsible_person' => $row[7],
                    'commentary' => $row[8],
                    'storage_date' => $formattedDate,
                ];

                if (!MaterialType::where('type_of_material', $row[6])->exists()) {
                    $missingMaterials[] = $row[6];
                }
                
                if (!User::where('email', $row[7])->exists()) {
                    $missingPersons[] = $row[7];
                }

            } else {
                $validData[] = [
                    'pos_tank_nr' => $row[1],
                    'pos_insert' => $row[2],
                    'pos_tube' => $row[3],
                    'pos_smpl' => $row[4],
                    'identifier' => $row[5],
                    'type_of_material' => $row[6],
                    'responsible_person' => $row[7],
                    'commentary' => null,
                    'storage_date' => $this->formatStorageDate($row[8]),
                ];

                if (!MaterialType::where('type_of_material', $row[6])->exists()) {
                    $missingMaterials[] = $row[6];
                }
                
                if (!User::where('email', $row[7])->exists()) {
                    $missingPersons[] = $row[7];
                }
            }
        }

        $missingMaterialMessage = '';
        $missingPersonsMessage = '';
        $missingBoth = '';

        // var_dump($missingMaterials);
        // var_dump($missingPersons);

        // dd();

        // Alle Daten sind gültig, jetzt in die Datenbank einfügen
        try {
            DB::table('sample')->insert($validData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                $errorMessage = "Ein oder mehrere identische Datensätze sind bereits vorhanden.";
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            } elseif (isset($missingMaterials[0]) && isset($missingPersons[0])) {
                $missingMaterialMessage = "Materialtyp(en): '" . implode("', '", array_unique($missingMaterials)) . "' fehlt/fehlen und müssen erst noch angelegt werden. Daten konnten nicht importiert werden! ";
                $missingPersonsMessage = "Verantwortliche(r) Person(en): '" . implode("', '", array_unique($missingPersons)) . "' fehlt/fehlen. Daten konnten nicht importiert werden! ";
                $missingBoth = " ";
                return redirect()->back()->withErrors(['error' => $missingMaterialMessage . $missingBoth . $missingPersonsMessage]);
            } elseif (isset($missingMaterials[0]) && empty($missingPersons)) {
                $missingMaterialMessage = "Materialtyp(en): '" . implode("', '", array_unique($missingMaterials)) . "' fehlt/fehlen und müssen erst noch angelegt werden. Daten konnten nicht importiert werden! ";
                return redirect()->back()->withErrors(['error' => $missingMaterialMessage]);
            } elseif (empty($missingMaterials) && isset($missingPersons[0])) {
                $missingPersonsMessage = "Verantwortliche(r) Person(en): '" . implode("', '", array_unique($missingPersons)) . "' fehlt/fehlen. Daten konnten nicht importiert werden! ";
                return redirect()->back()->withErrors(['error' => $missingPersonsMessage]);
            } else {
                Log::error($e->getMessage());
                //return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                return redirect()->back()->withErrors(['error' => 'Ein unerwarteter Fehler ist aufgetreten.']);
            }
        }

        return redirect()->back()->with('success', 'Proben erfolgreich importiert.'); 
    }

    private function formatStorageDate($date) {
        // Überprüfe, ob das Datum im erwarteten Format vorliegt
        if (preg_match('/\d{2}\.\d{2}\.\d{4} \d{2}:\d{2}/', $date)) {
            // Konvertiere das Datum in das gewünschte Format mit Carbon
            $formattedDate = Carbon::createFromFormat('d.m.Y H:i', $date)->format('Y-m-d H:i:s');
            return $formattedDate;
        } else {
            // Wenn das Datum nicht im erwarteten Format vorliegt, gib es unverändert zurück
            return null; // oder eine sinnvolle Standardwert, je nach Bedarf
        }
    }

    private function isHeaderRow($row)
    {
        // Überprüfe, ob die Zeile die Kopfzeile mit den Spaltennamen enthält
        return in_array('Tank Nummer', $row) && in_array('Einsatz', $row) && in_array('Röhrchen', $row);
    }
}
