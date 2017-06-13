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
 * @property string type
 */
class Settings extends Model
{

    protected $fillable = ['key', 'value'];

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
        \Log::debug($value);
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

    public function getValueAttribute($value)
    {
        $type = $this->type;
        switch ($type) {
            case "bool":
                $value = $value == 1;
                break;
            case "int":
                $value = (int)$value;
                break;
            case "date":
                $value = is_null($value) || $value == '' ? $value : $this->asDateTime($value)->toIso8601String();
                break;
        }
        return $value;
    }

    public function setValueAttribute($value)
    {
        $type = $this->type;
        switch ($type) {
            case "bool":
                $value = ($value) ? 1 : 0;
                break;
            case "int":
                $value = (int)$value;
                break;
            case "date":
                $value = is_null($value) || $value == '' ? $value : $this->fromDateTime($value);
                break;
        }
        $this->attributes['value'] = $value;
    }

}
