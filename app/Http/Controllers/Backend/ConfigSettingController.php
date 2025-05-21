<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigSetting\UpdateConfigSettingRequest;
use App\Models\ConfigSetting;
use App\Services\ConfigSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConfigSettingController extends Controller
{
    /**
     * @var ConfigSettingService
     */
    protected $configSettingService;


    public function __construct(ConfigSettingService $configSettingService)
    {
        $this->configSettingService = $configSettingService;
        $this->middleware('permission:setting-list', ['only' => ['index', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = $this->configSettingService->getSettings();
        if (empty($setting)) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Something went wrong. Please try again later.');
        }
        $url = route('config_settings.update', $setting->id);
        return view('backend.settings.index', compact('setting','url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ConfigSetting $config_setting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConfigSettingRequest $request, ConfigSetting $config_setting)
    {
        $config_setting = $this->configSettingService->update($config_setting, $request->all());
        return redirect()->route('config_settings.index')->with('status', 'Config settings haves been updated successfully.');
    }

    /**
     * Confirm password.
     *
     * @return \Illuminate\Http\Response
     */
    public function passwordConfirm(Request $request)
    {
        $password_confirmed = Hash::check($request->password, auth()->user()->password);
        return response()->json([
            'status' => true,
            'password_confirmed' => $password_confirmed
        ]);
    }
}