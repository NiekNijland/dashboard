<?php

namespace App\Integrations\MotorOccasion\Console\Commands;

use App\Integrations\MotorOccasion\Actions\GetBrands;
use App\Integrations\MotorOccasion\Actions\GetSessionId;
use App\Integrations\MotorOccasion\Actions\GetTypesForBrand;
use App\Models\MotorOccasion\Brand;
use Illuminate\Console\Command;
use JsonException;

class ImportBrandsAndTypes extends Command
{
    protected $signature = 'motor-occasion:import-brands-and-types';

    protected $description = 'Imports the brands and types from the MotorOccasion API';

    /**
     * @throws JsonException
     */
    public function handle(): void
    {
        $this->info('Importing brands and types from the MotorOccasion API');

        $sessionId = (new GetSessionId())->handle();

        $brands = (new GetBrands($sessionId))->handle();

        $this->info('Found ' . count($brands) . ' brands');

        $this->withProgressBar($brands, function ($brand) {
            $brandModel = Brand::updateOrCreate(
                [
                    'value' => $brand->value
                ],
                [
                    'name' => $brand->name
                ]
            );

            $types = (new GetTypesForBrand($brand))->handle();

            $this->newLine();
            $this->info('Found ' . $types->count() . ' types for ' . $brand->name);

            foreach ($types as $type) {
                $brandModel->types()->updateOrCreate(
                    [
                        'value' => $type->value
                    ],
                    [
                        'name' => $type->name
                    ]
                );
            }
        });

        $this->newLine();
        $this->info('Imported ' . count($brands) . ' brands and their types');
    }
}
