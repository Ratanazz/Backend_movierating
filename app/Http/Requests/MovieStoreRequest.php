<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule for advanced validation rules

class MovieStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Update authorization logic based on your application's requirements.
        // Here, we'll allow authenticated users to create movies:
        return auth()->check(); // Assuming you have an authentication system
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255', // Limit movie title length
            ],
            'summary' => [
                'required',
                'string',
            ],
            'genre' => [
                'required',
                'string',
            ],
            'release_date' => [
                'required',
                'date', // Validate format as a date
                'before_or_equal:today', // Ensure release date is not in the future
            ],
            'rating' => [
                'required',
                'integer',
                'min:1', // Minimum rating (adjust as needed)
                'max:10', // Maximum rating (adjust as needed)
            ],
            'runtime_minutes' => [
                'required',
                'integer',
                'min:1', // Minimum runtime (adjust as needed)
            ],
            'image_poster' => [
                'required',
                'string',
                // Add validation for image format or URL if applicable
            ],
        ];
    }

    /**
     * Get custom validation messages for attributes.
     *
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The movie title is required.',
            'name.string' => 'The movie title must be a string.',
            'name.max' => 'The movie title cannot be longer than 255 characters.',
            'summary.required' => 'The movie summary is required.',
            'summary.string' => 'The movie summary must be a string.',
            'genre.required' => 'The movie genre is required.',
            'genre.string' => 'The movie genre must be a string.',
            'release_date.required' => 'The movie release date is required.',
            'release_date.date' => 'The movie release date must be a valid date.',
            'release_date.before_or_equal' => 'The movie release date cannot be in the future.',
            'rating.required' => 'The movie rating is required.',
            'rating.integer' => 'The movie rating must be an integer.',
            'rating.min' => 'The movie rating must be at least :min.', // Adjust minimum rating message
            'rating.max' => 'The movie rating cannot be greater than :max.', // Adjust maximum rating message
            'runtime_minutes.required' => 'The movie runtime is required.',
            'runtime_minutes.integer' => 'The movie runtime must be an integer.',
            'runtime_minutes.min' => 'The movie runtime must be at least :min minutes.', // Adjust minimum runtime message
            'image_poster.required' => 'The movie poster image is required.',
            'image_poster.string' => 'The movie poster image must be a valid URL or image data.', // Adjust based on validation approach
        ];
    }
}
