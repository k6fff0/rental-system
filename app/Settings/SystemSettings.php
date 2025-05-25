<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SystemSettings extends Settings
{
    public string $app_name;
    public string $system_email;
    public string $primary_color;
    public string $secondary_color;
    public ?string $app_logo;
    public ?string $favicon;
    public string $default_contract_terms;
	public bool $maintenance_mode;

    public static function group(): string
    {
        return 'system';
    }
}
