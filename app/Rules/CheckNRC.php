<?php

namespace App\Rules;

use App\Models\NrcState;
use App\Models\NrcTownship;
use App\Models\NrcType;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CheckNRC implements Rule
{
    public $nrc_state;
    public $nrc_township;
    public $nrc_type;
    public $nrc_number;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($nrc_state, $nrc_township, $nrc_type, $nrc_number)
    {
        $this->nrc_state = $nrc_state;
        $this->nrc_township = $nrc_township;
        $this->nrc_type = $nrc_type;
        $this->nrc_number = $nrc_number;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!preg_match('/^[0-9]{6}$/', $value)) {
            return false;
        }
        $state = NrcState::find($this->nrc_state);
        $township = NrcTownship::find($this->nrc_township);
        $type = NrcType::find($this->nrc_type);
        if ($this->nrc_state == null || $this->nrc_township == null || $this->nrc_type == null || $state == null || $township == null || $type == null || ($this->nrc_state != $township->nrc_state_id)) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'NRC format does not match.';
    }
}