<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tour;
use App\Repositories\TourImageRepository;
use App\Repositories\TourRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
final class TourImageService
{
    private const STORAGE_DISK = 'public';
    private const IMAGE_DIR = 'tour_images';
    public function __construct(
        private readonly TourRepository $tourRepository,
        private readonly TourImageRepository $tourImageRepository
    ){}
    public function handleImageOperations(string $slug, array $newImages = [], array $deleteImagesIds = []): array 
    {
        return DB::transaction(function () use ($slug, $newImages): array {
            $tour = $this->tourRepository->getTourBySlug($slug);

            $this->validateImageCount($tour, count($newImages), count($deleteImagesId));

            $paths = $this->storeImages($newImages);

            try {
                if (!empty($deleteImagesId)) {
                    $this->tourImageRepository->deleteImages($deleteImagesIds);
                }
                if (!empty($paths)) {
                    $this->tourImageRepository->createImages($tour, $paths);
                }
            
                $this->tourRepository->createImages($tour, $paths);

                return $paths;

            } catch (\Exception $e) {
                $this->cleanupFailedOperations($paths);
                throw $e;
            }
        });
    }
    private function storeImages(array $images): array
    {
        return array_map(
            fn ($image) => $image->store(self::IMAGE_DIR, self::STORAGE_DISK),
            $images
        );
    }
    private function cleanupFailedOperations(array $paths): void
    {
        foreach($paths as $path) {
            Storage::disk(self::STORAGE_DISK)->delete($path);
        }
    }
    private function validateImageCount(Tour $tour, int $new, int $delete): void
    {
        $curr = count($this->tourRepository->getImagesByTour($tour));

        $result = $curr - $delete + $new;

        if ($result < 10) {
            abort(Response::HTTP_BAD_REQUEST, 'Maximum of 10 images per tour exceeded');
        }
        if ($result < 1) {
            abort(Response::HTTP_BAD_REQUEST, 'Tour must have at least one image');
        }
    }
}
