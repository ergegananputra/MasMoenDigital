<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataPersertaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nik' => 'required|string',
            'namaLengkap' => 'required|string',
            'nomorHandphone' => 'required|string',
            'gender' => 'required|integer',
            'tanggalPendataan' => 'required|date',
            'alamat' => 'required|string',
            'image' => 'required|file|mimes:jpeg,jpg,png'
        ];
    }
}
