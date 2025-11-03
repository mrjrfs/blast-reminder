<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Participant;
use App\Models\ParticipantImport;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class ExcelImportService
{
    public function import(string $filePath, Event $event, int $userId): ParticipantImport
    {
        $import = ParticipantImport::create([
            'event_id' => $event->id,
            'user_id' => $userId,
            'file_name' => basename($filePath),
            'status' => 'processing',
        ]);

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Skip header row
            $dataRows = array_slice($rows, 1);
            $import->update(['total_rows' => count($dataRows)]);

            $importedCount = 0;
            $failedData = [];

            foreach ($dataRows as $rowIndex => $row) {
                try {
                    $name = trim($row[0] ?? '');
                    $phoneNumber = trim($row[1] ?? '');

                    // Validation - both fields are required
                    if (empty($name) || empty($phoneNumber)) {
                        $failedData[] = [
                            'row' => $rowIndex + 2,
                            'data' => $row,
                            'error' => 'Nama dan No HP harus diisi',
                        ];
                        continue;
                    }

                    if (!$this->isValidPhoneNumber($phoneNumber)) {
                        $failedData[] = [
                            'row' => $rowIndex + 2,
                            'data' => $row,
                            'error' => 'Format No HP tidak valid. Gunakan format: 08xxx atau +628xxx',
                        ];
                        continue;
                    }

                    $exists = Participant::where('event_id', $event->id)
                        ->where('phone_number', $phoneNumber)
                        ->exists();

                    if ($exists) {
                        $failedData[] = [
                            'row' => $rowIndex + 2,
                            'data' => $row,
                            'error' => 'Partisipan dengan No HP ini sudah terdaftar',
                        ];
                        continue;
                    }

                    // Create participant
                    Participant::create([
                        'event_id' => $event->id,
                        'name' => $name,
                        'phone_number' => $phoneNumber,
                    ]);

                    $importedCount++;
                } catch (Exception $e) {
                    $failedData[] = [
                        'row' => $rowIndex + 2,
                        'data' => $row,
                        'error' => $e->getMessage(),
                    ];
                    continue;
                }
            }

            $import->update([
                'imported_rows' => $importedCount,
                'failed_rows' => count($failedData),
                'failed_data' => count($failedData) > 0 ? $failedData : null,
                'status' => 'completed',
            ]);

        } catch (Exception $e) {
            Log::error('Excel import failed: ' . $e->getMessage());
            $import->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }

        return $import;
    }

    private function isValidPhoneNumber(string $phone): bool
    {
        // Remove spaces and dashes
        $phone = str_replace([' ', '-'], '', $phone);

        // Check if starts with 08 or +628
        if (preg_match('/^(08|\+628)\d{8,11}$/', $phone)) {
            return true;
        }

        return false;
    }
}
