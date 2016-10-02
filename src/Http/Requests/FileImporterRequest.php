<?php
/**
 * Created by PhpStorm.
 * User: daniel.wilhelmsen
 * Date: 10/2/16
 * Time: 1:27 AM
 */

namespace Easel\Http\Requests;


class FileImporterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delimiter'        => 'required',
            'posts'       => 'required|mimes:txt'
        ];
    }
}