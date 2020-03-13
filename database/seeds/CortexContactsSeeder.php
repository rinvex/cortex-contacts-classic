<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class CortexContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            ['name' => 'list', 'title' => 'List contacts', 'entity_type' => 'contact'],
            ['name' => 'import', 'title' => 'Import contacts', 'entity_type' => 'contact'],
            ['name' => 'create', 'title' => 'Create contacts', 'entity_type' => 'contact'],
            ['name' => 'update', 'title' => 'Update contacts', 'entity_type' => 'contact'],
            ['name' => 'delete', 'title' => 'Delete contacts', 'entity_type' => 'contact'],
            ['name' => 'audit', 'title' => 'Audit contacts', 'entity_type' => 'contact'],
        ];

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });
    }
}
