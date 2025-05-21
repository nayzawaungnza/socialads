<?php

namespace App\Services;

use App\Models\ConfigSetting;
use App\Repositories\Backend\ConfigSettingRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfigSettingService
{
    /**
     * @var ConfigSettingRepository
     */
    protected $configSettingRepository;

    /**
     * CustomerService constructor.
     *
     * @param ConfigSettingRepository $configSettingRepository
     */
    public function __construct(ConfigSettingRepository $configSettingRepository)
    {
        $this->configSettingRepository = $configSettingRepository;
    }

    /**
     * Get system configuration setting.
     * 
     * @return ConfigSetting
     */
    public function getSettings()
    {
        return $this->configSettingRepository->getSettings();
    }

    /**
     * Update config setting.
     *
     * @param ConfigSetting $config_setting
     * @param array $data
     * @return ConfigSetting $config_setting
     */
    public function update(ConfigSetting $config_setting, array $data)
    {

        DB::beginTransaction();
        try {
            $result = $this->configSettingRepository->update($config_setting, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update config setting');
        }
        DB::commit();
        return $result;
    }
}
