<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class AddressValidationController {

    public function test(Request $request)
    {
        // address_1, address_2, address_3
        // each line of address maximum 30 characters
        $validator = \Validator::make($request->all(), [
            'address_1' => 'required|max:30',
            'address_2' => 'max:30',
            'address_3' => 'max:30',
        ]);

        $validator->after(function (Validator $validator) {
            $formData = $validator->getData();

            // need to divide by characters and words
            // total is 90 characters
            $inputAddress = preg_replace('/\s+/', ' ',implode('        ', $formData));

            $explodedAddress = [
                'address_1' => null,
                'address_2' => null,
                'address_3' => null,
            ];

            for ( $i = 1; $i <= 3; $i ++ )
            {
                $trimmedAddress = \Str::limit($inputAddress, 30, null);

                $explodedAddress['address_' . $i] = $trimmedAddress;

                // remove $trimmedAddress from $address
                $inputAddress = trim(str_replace($trimmedAddress, '', $inputAddress));
            }

            $validator->errors()->add('acceptable_address_format', $explodedAddress);
        });

        if ($validator->fails()) {
            return response()->json(
                $validator->getMessageBag()->toArray(),
                422
            );
        }

        return 'success';
    }

}
