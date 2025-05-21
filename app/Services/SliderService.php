<?php

namespace App\Services;

use Exception;
use App\Models\Slider;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\SliderRepository;
use App\Services\Interfaces\SliderServiceInterface;

class SliderService implements SliderServiceInterface
{
    protected $sliderRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    public function getSliders($request, $status = null)
    {
            return $this->sliderRepository->getSliders($request, $status);
    }
    public function getSlider($id)
    {

    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $slider = $this->sliderRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Slider Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create Slider'); 
        }
        DB::commit();
        return $slider;
    }
    public function update(Slider $slider, array $data)
    {
        DB::beginTransaction();
        try {
            $slider = $this->sliderRepository->update($slider,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Slider Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to Slider update'); 
        }
        DB::commit();
        return $slider;
    }
    public function destroy(Slider $slider)
    {
        DB::beginTransaction();
        try {
            $slider = $this->sliderRepository->destroy($slider);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Slider deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Slider'); 
        }
        DB::commit();
        return $slider;
    }
    public function changeStatus(Slider $slider)
    {
        DB::beginTransaction();
        try {
            $slider = $this->sliderRepository->changeStatus($slider);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Slider Status Change Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to change Slider status'); 
        }
        DB::commit();
        return $slider;
    }
    public function getSliderEloquent()
    {
        return $this->sliderRepository->getSliderEloquent();
    }
}