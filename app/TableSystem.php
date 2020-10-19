<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

class TableSystem extends Model
{
    protected $table    = 'table_system';

    protected $fillable =
    [
        'n_mesa',
        'id_atendente',
        'id_cliente',
        'n_pessoas',
        
    ];

    static public $images_storage_path = 'media/banner';

    private $validator;

    public function __construct(array $attributes = [])
    {
        $this->validator = Validator::make([], []);
    }


    /**

     * Returns the Path of the image or null in case the image_file attribute is not set or empty.

     * Internally, uses hasImage function to verify this question

     * @return string|null

     */

    /**

     * Returns the URL of the image or null in case the image_file attribute is not set or empty.

     * Internally, uses hasImage function to verify this question

     * @return string|null

     */


    public function validate($new = true)
    {
        // create a new Validator, as we need a fresh $validate->failed() errors on each call to validate()
        // for specific rule error check
        $rules = $new ? $this->validationRules() : $this->updateValidationRules();
        $this->validator = Validator::make($this->attributes, $rules);

        return !$this->validator->fails();
    }

    /**
     * Validator errors
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->validator->errors();
    }

    private function updateValidationRules()
    {
        $updateRules = $this->validationRules();

        $updateRules['n_mesa'] = 'required';
        $updateRules['id_atendente']     = 'required';
        $updateRules['id_cliente'] = 'required';
        $updateRules['n_pessoas'] = 'required'; 

        return $updateRules; 
    }

    private function validationRules()
    {
        return [
            'n_mesa' => 'required',
            'id_atendente'     => 'required',
            'id_cliente' => 'required',
            'n_pessoas' => 'required'
        ];
    }

}
