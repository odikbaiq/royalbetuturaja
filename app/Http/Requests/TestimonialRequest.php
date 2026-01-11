<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'customer';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10|max:1000',
            'reservation_id' => 'required|exists:reservations,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'message.required' => 'Pesan testimoni wajib diisi.',
            'message.min' => 'Pesan testimoni minimal 10 karakter.',
            'message.max' => 'Pesan testimoni maksimal 1000 karakter.',
            'reservation_id.required' => 'Reservasi wajib dipilih.',
            'reservation_id.exists' => 'Reservasi tidak valid.',
        ];
    }
}
