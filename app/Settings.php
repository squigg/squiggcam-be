<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return static::where('key', 'like', $key . '%')->get();
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
        $array = [];
        foreach ($settings as $setting) {
            array_set($array, $setting->key, $setting->value);
        }
        return $array;
    }

}
