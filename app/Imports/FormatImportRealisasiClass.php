<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;


class FormatImportRealisasiClass implements WithValidation
{
    public function rules(): array
    {
        return [
            '0' => ['string'],
            '1' => ['string'],
            '2' => ['string'],
            '3' => ['string'],
            '4' => ['string'],
        ];
    }
}
