<?php

declare(strict_types=1);

namespace MusheAbdulHakim\Paystack;

use Illuminate\Config\Repository;
use MusheAbdulHakim\Paystack\Exceptions\ConfigFileNotFoundException;

/**
 * Class Config
 *
 * @author  Mushe Abdul-Hakim  <musheabdulhakim99@gmail.com>
 */
class Config
{
    /**
     * Config file name
     */
    public const CONFIG_FILE_NAME = "paystack";


    private readonly Repository $config;


    public function __construct()
    {
        $configPath = $this->configurationPath();

        $config_file = $configPath . '/' . self::CONFIG_FILE_NAME . '.php';

        if (!file_exists($config_file)) {
            throw new ConfigFileNotFoundException();
        }

        $this->config = new Repository(require $config_file);
    }

    /**
     * return the correct config directory path
     *
     * @return  mixed|string
     */
    private function configurationPath()
    {
        // the config file of the package directory
        $config_path = __DIR__ . '/Config';

        // check if this laravel specific function `config_path()` exist (means this package is used inside
        // a laravel framework). If so then load then try to load the laravel config file if it exist.
        if (function_exists('config_path')) {
            $file = config_path() . '/' . self::CONFIG_FILE_NAME . '.php';
            if (file_exists($file)) {
                $config_path = config_path();
            }
        }

        return $config_path;
    }


    public function get(mixed $key): string
    {
        return $this->config->get($key);
    }
}
