<?php


namespace App\Helpers;


class ResponseHelper
{
    public static function validation($data, $title = 'The given data was invalid.')
    {
        $response = [
            'message' => $title,
        ];

        foreach ($data as $key => $value) {
            if (is_array($value)){
                $response['errors'][$key] = $value;
            } else {
                $response['errors'][$key] = [$value];
            }
        }
        return response($response, 422);
    }
}
