<?php

namespace App\Services;

use App\Models\TourImage;
use Illuminate\Support\Facades\Storage;

class TourImageService
{
    /**
     * Create a new class instance.
     */

     private function createImage($tourId, $image)
     {
        $path = $image->store('tour_images', 'public');

        return TourImage::create([
            'tour_id' => $tourId,
            'image_path' => $path
        ]);
     }

     private function updateImage(TourImage $tourImage, $image)
     {
        $newImagePath = $image->store('tour_images', 'public');

        $tourImage->update(['image_path' => $newImagePath]);

        return $tourImage;
     }

     private function findAndDeleteImage(array $data): TourImage
     {
         $tourImage = TourImage::findOrFail($data['tour_image_id']);

         Storage::disk('public')->delete($tourImage->image_path);

         return $tourImage;
     }
    public function upload($data)
    {
        return $this->createImage($data['tour_id'], $data['image']);
    }

    public function update($data)
    {
        $tourImage = $this->findAndDeleteImage($data['tour_image_id']);

        return $this->updateImage($tourImage, $data['image']);
    }

    public function delete($data)
    {
        $tourImage = $this->findAndDeleteImage($data);

        $tourImage->delete();
    }
}
