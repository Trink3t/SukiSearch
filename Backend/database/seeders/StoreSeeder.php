<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $owners = User::query()->whereHas('roles', fn ($query) => $query->where('name', 'store_owner'))->orderBy('email')->get();
        $stores = [
            ['Nena\'s Sari-Sari Store', 'PH-0401', 'San Roque', 'Calamba', 14.21140000, 121.16570000],
            ['Kuya Jun\'s Tindahan', 'PH-0402', 'Poblacion', 'Los Baños', 14.17080000, 121.24250000],
            ['Aling Rosa Mini Mart', 'PH-0403', 'Maligaya', 'San Pablo', 14.06960000, 121.32410000],
            ['Maria\'s Neighborhood Store', 'PH-0404', 'Santa Cruz', 'Calamba', 14.23020000, 121.18030000],
        ];

        foreach ($stores as $index => [$name, $barangayExternalId, $barangay, $city, $latitude, $longitude]) {
            Store::query()->firstOrCreate(['name' => $name], [
                'user_id' => $owners[$index]->id, 'description' => 'A friendly local sari-sari store serving '.$barangay.'.',
                'barangay_external_id' => $barangayExternalId, 'barangay' => $barangay, 'city_municipality' => $city,
                'province' => 'Laguna', 'latitude' => $latitude, 'longitude' => $longitude, 'status' => 'active', 'is_open' => true,
            ]);
        }
    }
}
