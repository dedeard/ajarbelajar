<?php

namespace Modules\Admin\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Admin\Entities\Admin;
use Modules\Admin\Entities\Role;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'), // Default password for testing
            'is_active' => fake()->boolean(),
            'remember_token' => Str::random(10),
            'role_id' => fn () => Role::factory()->create()->id,
        ];
    }
}
