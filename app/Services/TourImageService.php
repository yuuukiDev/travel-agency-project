<?php

namespace App\Services;

use App\Models\TourImage;
use Illuminate\Support\Facades\Storage;

class TourImageService
{
    /**
     * Create a new class instance.
     */
    private function createImage($image, $tourId)
    {
        $path = $image->store('tour_images', 'public');

        return TourImage::create([
            'tour_id' => $tourId,
            'image_path' => $path,
        ]);
    }

    private function updateImage(TourImage $tourImage, $image)
    {
        $newImagePath = $image->store('tour_images', 'public');

        $tourImage->update(['image_path' => $newImagePath]);

        return $tourImage;
    }

    private function findAndDeleteImage(array $data, $tourId): TourImage
    {
        $tourImage = TourImage::where('tour_id', $tourId)->findOrFail($data['tour_image_id']);

        Storage::disk('public')->delete($tourImage->image_path);

        return $tourImage;
    }

    public function upload($data, $tourId)
    {
        return $this->createImage($data['image'], $tourId);
    }

    public function update($data, $tour_id)
    {
        $tourImage = $this->findAndDeleteImage($data, $tour_id);

        return $this->updateImage($tourImage, $data['image']);
    }

    public function delete($data, $tourId)
    {
        $tourImage = $this->findAndDeleteImage($data, $tourId);

        $tourImage->delete();
    }
}
