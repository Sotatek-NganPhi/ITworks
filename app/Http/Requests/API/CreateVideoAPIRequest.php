<?php

namespace App\Http\Requests\API;

use App\Models\Video;
use Illuminate\Validation\Factory as ValidationFactory;

class CreateVideoAPIRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'youtubeUrl',
            function ($attribute, $value, $parameters) {
                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $value, $matches);
                return $matches && strlen($matches[1]) === 11 ;
            },
            trans('validation.custom.video.youtube')
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->appendRequired('videos', Video::$rules);
        return $rules;
    }
}
