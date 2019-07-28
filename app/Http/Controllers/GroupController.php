<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiParamException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Group::cacheGroupNames();
        return view('resources.groups.index', [
            'types' => Type::with('groups')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        $id_vk = explode('/', parse_url($request->get('id_vk'), PHP_URL_PATH))[1];
        $api = new VKApiClient;
        try {
            $id_vk = $api->groups()->getById(config('vkapi.access_token'), [
                'group_id' => $id_vk,
                'fields' => 'name'
            ])[0]['id'];
        } catch (VKApiParamException $e) {
            throw ValidationException::withMessages([
                'id_vk' => 'Group does not exists'
            ]);
        }
        if (Group::where('id_vk', $id_vk)->where('type_id', $request->get('type_id'))->count() > 0)
            throw ValidationException::withMessages([
                'id_vk' => 'This group is already added'
            ]);
        $request->merge(['id_vk' => $id_vk]);
        $group = new Group;
        $group->fill($request->all());
        $group->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('groups.index');
    }
}
