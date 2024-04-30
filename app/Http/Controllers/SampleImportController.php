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
            'file' => ['required', 'file', 'max:2048', 'mimes:csv,txt'], // Maximalgröße der Datei 2MB
            // Nur CSV- und Textdateien zulassen
        ]);

        $file = $request->file('file');

        // Überprüfen, ob eine Datei hochgeladen wurde
        if (!$file) {
            return redirect()->back()->withErrors(['error' => __('messages.no_file_selected_error')]);
        }

        // Überprüfen, ob die Datei leer ist
        if ($file->getSize() === 0) {
            return redirect()->back()->withErrors(['error' => __('messages.empty_file_error')]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $fileData = array_map('str_getcsv', file($file));
            // Entferne leere Zeilen
            $fileData = $this->removeEmptyRows($fileData);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => __('messages.file_read_error')]);
        }

        // Überprüfung der Anzahl der Spalten
        $minColumnCount = 9; // Mindestanzahl erwarteter Spalten
        $maxColumnCount = 10; // Maximalanzahl erwarteter Spalten
        foreach ($fileData as $row) {
            $columnCount = count($row);
            if ($columnCount < $minColumnCount || $columnCount > $maxColumnCount) {
                //$errorMessage = "Das CSV hat nicht die erwartete Anzahl an Spalten.";
                $errorMessage = __('messages.csv_column_count_error');
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
        }

        // Entfernen der ersten Zeile (Spaltennamen) aus den Daten
        $columnNames = array_shift($fileData);

        // Überprüfen, ob die Spaltennamen den erwarteten entsprechen
        if (!$this->isHeaderRow($columnNames)) {
            return redirect()->back()->withErrors(['error' => __('messages.invalid_column_names_error')]);
        }

        $validData = [];
        $missingMaterials = [];
        $missingPersons = [];

        foreach ($fileData as $key => $row) {
            if (count($row) >= $minColumnCount && count($row) <= $maxColumnCount && !empty(array_filter($row))) {
                $validData[] = [
                    'pos_tank_nr' => $row[1],
                    'pos_insert' => $row[2],
                    'pos_tube' => $row[3],
                    'pos_smpl' => $row[4],
                    'identifier' => $row[5],
                    'type_of_material' => $row[6],
                    'responsible_person' => $row[7],
                    'storage_date' => $this->formatStorageDate($row[8]),
                    'commentary' => isset($row[9]) ? $row[9] : null,
                ];

                // Überprüfen, ob die B-Nummer vorhanden ist
                if (empty($row[5])) {
                    // B-Nummer fehlt, füge den Fehler zur Fehlermeldung hinzu
                    $missingBNumbers[] = $key + 1; // Zeilennummer (beginnend bei 1)
                }

                if (!MaterialType::where('type_of_material', $row[6])->exists()) {
                    $missingMaterials[] = $row[6];
                }
                
                if (!User::where('email', $row[7])->exists()) {
                    $missingPersons[] = $row[7];
                }

            } else {
                continue;
            }
        }

        // Überprüfen, ob fehlende B-Nummern vorhanden sind
        if (!empty($missingBNumbers)) {
            $missingBNumbersMessage = __('messages.missing_b_numbers_error', ['rows' => implode(', ', $missingBNumbers)]);
            return redirect()->back()->withErrors(['error' => $missingBNumbersMessage]);
        }

        $missingMaterialMessage = '';
        $missingPersonsMessage = '';
        $missingBoth = " ";

        // Alle Daten sind gültig, jetzt in die Datenbank einfügen
        try {
            DB::table('sample')->insert($validData);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { 
                // Identifiziere die doppelten Einträge
                $duplicateIdentifiersCSV = [];
                $uniqueCombinations = [];
                $duplicateCombinations = [];
                $uniqueIdentifiersCSV = [];
                $duplicateEntries = [];
                $duplicateIdentifiers = [];
        
                foreach ($validData as $data) {
                    // Erstelle eine eindeutige Kombination aus den relevanten Feldern
                    $combination = $data['pos_tank_nr'] . '_' . $data['pos_insert'] . '_' . $data['pos_tube'] . '_' . $data['pos_smpl'];
                
                    // Überprüfe, ob die Kombination bereits vorhanden ist
                    if (in_array($combination, $uniqueCombinations)) {
                        // Die Kombination wurde bereits gesehen, füge sie zur Liste der Duplikate hinzu
                        $duplicateCombinations[] = $combination;
                    } else {
                        // Die Kombination ist einzigartig, füge sie zur Liste der eindeutigen Kombinationen hinzu
                        $uniqueCombinations[] = $combination;
                    }
        
                    if (in_array($data['identifier'], $uniqueIdentifiersCSV)) {
                        // Der identifier wurde bereits gesehen, füge ihn zur Liste der Duplikate hinzu
                        $duplicateIdentifiersCSV[] = $data['identifier'];
                    } else {
                        // Der identifier ist einzigartig, füge ihn zur Liste der eindeutigen identifier hinzu
                        $uniqueIdentifiersCSV[] = $data['identifier'];
                    }

                    $duplicates = DB::table('sample')
                        ->where(function($query) use ($data) {
                            $query->where('pos_tank_nr', $data['pos_tank_nr'])
                                    ->where('pos_insert', $data['pos_insert'])
                                    ->where('pos_tube', $data['pos_tube'])
                                    ->where('pos_smpl', $data['pos_smpl']);
                        })
                        ->get();
                    
                    if ($duplicates->isNotEmpty()) {
                        // Überprüfe auf doppelte Einträge mit denselben Werten für pos_tank_nr, pos_insert, pos_tube und pos_smpl
                        $foundDuplicate = false;
                        foreach ($duplicates as $duplicate) {
                            if ($duplicate->identifier === $data['identifier']) {
                                // Wenn ein doppelter identifier gefunden wird, füge ihn zur Liste der doppelten identifier hinzu
                                if (count($duplicateIdentifiers) < 10) {
                                    $duplicateIdentifiers[] = $data['identifier'];
                                }
                                $foundDuplicate = true;
                            }
                        }
            
                        // Wenn kein doppelter identifier gefunden wurde, füge den gesamten Datensatz zur Liste der doppelten Einträge hinzu
                        if (!$foundDuplicate) {
                            $duplicateEntries[] = $duplicates->toArray();
                        }
                    }
                }
        
                $errorMessage = '';
        
                if (!empty($duplicateCombinations)) {
                    $errorMessage .= __('messages.position', ['positions' => implode(', ', $duplicateCombinations)]);
                }
        
                if (!empty($duplicateIdentifiersCSV)) {
                    // Füge dem Fehlermeldungs-String für wiederholende Kombinationen die Meldung für doppelte Identifier hinzu
                    $errorMessage .= "\n" . __('messages.duplicated_identifier', ['identifiers' => ' identifier: ' . implode(', ', $duplicateIdentifiersCSV)]);
                }

                if (!empty($duplicateIdentifiers)) {
                    $errorMessage = __('messages.duplicated_entry', ['duplicates' => ' identifier: ' . implode(', ', $duplicateIdentifiers)]);
                } elseif (!empty($duplicateEntries)) {
                    $duplicateEntriesString = '';
                    foreach ($duplicateEntries as $entries) {
                        foreach ($entries as $entry) {
                            $entryString = "pos_tank_nr: {$entry->pos_tank_nr}, pos_insert: {$entry->pos_insert}, pos_tube: {$entry->pos_tube}, pos_smpl: {$entry->pos_smpl}, identifier: {$entry->identifier}, type_of_material: {$entry->type_of_material}, responsible_person: {$entry->responsible_person}, storage_date: {$entry->storage_date}, commentary: {$entry->commentary}";
                            $duplicateEntriesString .= $entryString . " /// ";
                        }
                    }
                    $errorMessage = __('messages.duplicated_entry', ['duplicates' => $duplicateEntriesString]);
                }
        
                // Gib den Fehlermeldungs-String zurück
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            } elseif (isset($missingMaterials[0]) && isset($missingPersons[0])) {
                $missingMaterialMessage = __('messages.missing_material_error', ['materials' => implode("', '", array_unique($missingMaterials))]);
                $missingPersonsMessage = __('messages.missing_person_error', ['persons' => implode("', '", array_unique($missingPersons))]);
                return redirect()->back()->withErrors(['error' => $missingMaterialMessage . $missingBoth . $missingPersonsMessage]);
            } elseif (isset($missingMaterials[0]) && empty($missingPersons)) {
                $missingMaterialMessage = __('messages.missing_material_error', ['materials' => implode("', '", array_unique($missingMaterials))]);
                return redirect()->back()->withErrors(['error' => $missingMaterialMessage]);
            } elseif (empty($missingMaterials) && isset($missingPersons[0])) {
                $missingPersonsMessage = __('messages.missing_person_error', ['persons' => implode("', '", array_unique($missingPersons))]);
                return redirect()->back()->withErrors(['error' => $missingPersonsMessage]);
            } else {
                return redirect()->back()->withErrors(['error' => __('messages.unexpected_error')]);
            }
        }

        return redirect()->back()->with('success', __('messages.sample_import_success'));
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
        // Deutsche Spaltennamen
        $germanColumnNames = ['#', 'Tank Nummer', 'Einsatz', 'Röhrchen', 'Probenplatz', 'B-Nummer', 'Material', 'Verantwortlicher', 'Einlagerungsdatum'];
        
        // Englische Spaltennamen
        $englishColumnNames = ['#', 'tank name', 'container', 'tube', 'position', 'ID', 'material', 'responsible person', 'storage Date'];
        
        // Überprüfe, ob die Zeile die Kopfzeile mit den Spaltennamen enthält
        foreach ($row as $columnName) {
            if (in_array($columnName, $germanColumnNames) || in_array($columnName, $englishColumnNames)) {
                return true;
            }
        }
        
        return false;
    }

    private function removeEmptyRows($fileData)
    {
        foreach ($fileData as $key => $row) {
            if (count(array_filter($row)) === 0) {
                unset($fileData[$key]);
            }
        }
        return array_values($fileData);
    }

}
