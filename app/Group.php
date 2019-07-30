<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use VK\Client\VKApiClient;

/**
 * App\Group
 *
 * @property int $id
 * @property int $id_vk
 * @property int $type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name
 * @property-read \App\Type $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereIdVk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Group extends Model
{
    protected $table = 'groups';
    protected $fillable = ['id_vk', 'type_id'];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        if (Cache::store('memcached')->get('vk_group_name' . $this->id_vk)) {
            return Cache::store('memcached')->get('vk_group_name' . $this->id_vk);
        }
        $api = new VKApiClient();
        try {
            $name = $api->groups()->getById(config('vkapi.access_token'), [
                'group_id' => $this->id_vk,
                'fields' => 'name'
            ])[0]['name'];
            return $name;
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
        return 'None';
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public static function cacheGroupNames()
    {
        $groups = Group::all();
        $api = new VKApiClient;
        try {
            foreach ($api->groups()->getById(config('vkapi.access_token'), [
                'group_ids' => $groups->implode('id_vk', ','),
                'fields' => 'name'
            ]) as $group) {
                Cache::store('memcached')->set('vk_group_name' . $group['id'], $group['name'], 600);
            }
        } catch (\Throwable $e) {
            return;
        }

    }
}
