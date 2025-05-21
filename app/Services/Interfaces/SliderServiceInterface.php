<?php

namespace App\Services\Interfaces;

use App\Models\Slider;

interface SliderServiceInterface
{
    public function getSliders($request, $status = null);
    public function getSlider($id);
    public function create(array $request);
    public function update(Slider $slider, array $request);
    public function destroy(Slider $slider);
    public function changeStatus(Slider $slider);
    public function getSliderEloquent();
}