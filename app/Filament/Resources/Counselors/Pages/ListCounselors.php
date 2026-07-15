<?php

namespace App\Filament\Resources\Counselors\Pages;

use App\Filament\Resources\Counselors\CounselorResource;
use App\Models\Counselor;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCounselors extends ListRecords
{
    protected static string $resource = CounselorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color('primary')
                ->validateUsing([
                    'full_name' => ['required', 'string', 'max:255'],
                    'registration_number' => ['required', 'max:255'],
                    'degree' => ['required', 'string', 'max:255'],
                    'province_id' => ['required', 'integer', 'exists:provinces,id'],
                    'regency_id' => ['required', 'integer', 'exists:regencies,id'],
                    'whatsapp_number' => ['required', 'string', 'max:20'],
                    'contact_email' => ['required', 'email', 'max:255'],
                    'instagram_link' => ['nullable', 'url'],
                    'tiktok_link' => ['nullable', 'url'],
                    'facebook_link' => ['nullable', 'url'],
                ])
                ->mutateAfterValidationUsing(function (array $data): array {
                    $email = strtolower(trim((string) $data['contact_email']));

                    $user = User::firstOrCreate(
                        ['email' => $email],
                        [
                            'name' => $data['full_name'],
                            'password' => bcrypt($data['whatsapp_number']),
                        ]
                    );

                    $data['contact_email'] = $email;
                    $data['user_id'] = $user->id;

                    unset($data['full_name']);

                    return $data;
                })
                ->processCollectionUsing(function ($model, $collection, $additionalData, $afterValidationMutator) {
                    foreach ($collection as $row) {
                        $data = $row->toArray();

                        if (filled($additionalData)) {
                            $data = array_merge($data, $additionalData);
                        }

                        if ($afterValidationMutator) {
                            $data = call_user_func($afterValidationMutator, $data);
                        }

                        $registrationNumber = trim((string) $data['registration_number']);
                        $data['registration_number'] = $registrationNumber;

                        $counselor = Counselor::withTrashed()->updateOrCreate(
                            ['registration_number' => $registrationNumber],
                            $data
                        );

                        if ($counselor->trashed()) {
                            $counselor->restore();
                        }
                    }

                    return $collection;
                })
                ->beforeImport(function ($data, $livewire, $excelImportAction) {
                    $excelImportAction->customImportData([
                        'validation_status' => 'pending',
                        'status_id' => 1,
                    ]);
                })
                ->sampleExcel(
                    sampleData: [
                        'full_name' => 'John Doe',
                        'registration_number' => '123456',
                        'degree' => 'PhD in Psychology',
                        'province_id' => 11,
                        'regency_id' => 1101,
                        'whatsapp_number' => '081234567890',
                        'contact_email' => 'john.doe@example.com',
                        'instagram_link' => 'https://www.instagram.com/johndoe',
                        'tiktok_link' => 'https://www.tiktok.com/@johndoe',
                        'facebook_link' => 'https://www.facebook.com/johndoe',
                    ],
                ),
            CreateAction::make(),
        ];
    }
}
