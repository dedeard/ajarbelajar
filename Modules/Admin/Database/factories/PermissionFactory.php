<?php

namespace Modules\Admin\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Entities\Permission;

class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->words(2, true),
            'display_name' => fake()->words(2, true),
            'description' => fake()->paragraph,
        ];
    }
}
