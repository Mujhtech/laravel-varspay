<?php

/*
 * This file is part of the Laravel Paystack package.
 *
 * (c) Mujtech Mujeeb <mujeeb.muhideen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mujhtech\Varspay\Console;

use Illuminate\Console\Command;

class VarspayInstallCommand extends Command {

    protected $signature = 'laravel-varspay:install '.
        '{--force : Overwrite existing views by default}'.
        '{--type= : Installation type, Available type: none, enhanced & full.}'.
        '{--only= : Install only specific part, Available parts: assets, config, translations, auth_views, basic_views, basic_routes & main_views. This option can not used with the with option.}'.
        '{--with=* : Install basic assets with specific parts, Available parts: auth_views, basic_views, basic_routes & main_views}'.
        '{--interactive : The installation will guide you through the process}';

    protected $description = 'Install all the required files for Varspay';


    protected $package_path = __DIR__.'/../../';

    

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('only')) {
            switch ($this->option('only')) {
            case 'config':
                $this->exportConfig();
                break;

            default:
                $this->error('Invalid option!');
                break;
            }

            return;
        }

        if ($this->option('type') == 'basic' || $this->option('type') != 'none' || ! $this->option('type')) {
            $this->exportConfig();
        }

        $this->info('Laravel Varspay Installation complete.');
    }


    /**
     * Install the config file.
     */
    protected function exportConfig()
    {
        if ($this->option('interactive')) {
            if (! $this->confirm('Install the package config file?')) {
                return;
            }
        }
        if (file_exists(config_path('varspay-tech.php')) && ! $this->option('force')) {
            if (! $this->confirm('The Laravel Varspay configuration file already exists. Do you want to replace it?')) {
                return;
            }
        }
        copy(
            $this->packagePath('config/varspay-tech.php'),
            config_path('varspay-tech.php')
        );

        $this->comment('Configuration Files installed successfully.');
    }

    /**
     * Get Package Path.
     */
    protected function packagePath($path)
    {
        return $this->package_path.$path;
    }

    /**
     * Get Protected.
     *
     * @return array
     */
    public function getProtected($var)
    {
        return $this->{$var};
    }


}