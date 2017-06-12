<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Settings
 *
 * @mixin \Eloquent
 * @property string value
 * @property string key
 */
class Settings extends Model
{

    /**
     * @param string $key
     * @return mixed|string
     */
    static function get(string $key)
    {
        return static::where('key', $key)->firstOrFail()->value;
    }

    /**
     * @param string $key
     * @return mixed|string
     */
    static function getGroup(string $key)
    {
        /** @noinspection PhpParamsInspection */
        $settings = static::where('key', 'like', $key . '%')->get();
        $settings->map(function ($setting) use ($key) {
            $setting->key = str_replace($key . '.', '', $setting->key);
            return $setting;
        });
        return static::convertToArray($settings);
    }

    /**
     * @param string $key
     * @param string $value
     * @return Model
     */
    static function set(string $key, string $value = null)
    {
        /** @var Settings $setting */
        $setting = static::firstOrCreate(['key' => $key], ['value' => $value]);
        $setting->value = $value;
        $setting->save();
        return $setting;
    }

    /**
     * @return array
     */
    static function getAll()
    {
        $settings = Settings::all();
        return static::convertToArray($settings);

    }

    /**
     * @param Collection $settings
     * @return array
     */
    static function convertToArray(Collection $settings)
    {
        $array = [];
        foreach ($settings as $setting) {
            array_set($array, $setting->key, $setting->value);
        }
        return $array;
    }

}
