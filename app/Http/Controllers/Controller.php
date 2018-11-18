<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function importTherapists()
    {
        $databaseDir = app_path() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database';
        $databaseFile = $databaseDir . DIRECTORY_SEPARATOR . 'db.json';
        // verify that the database file exists
        if (!is_file($databaseFile))
            throw new FileNotFoundException('database file not found');
        $database = file_get_contents($databaseFile);
        // verify that the database file is readable
        if (empty($database))
            throw new AccessDeniedException('cannot read database file');
        $therapists = json_decode($database, true);
        // verify that the database file is a valid JSON file
        if (empty($therapists))
            throw new \LogicException('wrong format for database file');
        return $therapists;
    }

    private function returnResponse(array $array)
    {
        return response(json_encode($array), 200)
            ->header('Content-Type', 'application/json');
    }

    public function getCities()
    {
        $therapists = $this->importTherapists();
        $cities = [];
        foreach ($therapists as $therapist)
            if (!empty($therapist['city']) && !in_array($therapist['city'], $cities))
                $cities[] = $therapist['city'];
        sort($cities);
        return $this->returnResponse($cities);
    }

    public function getCityPractices(string $city)
    {
        $therapists = $this->importTherapists();
        $practices = [];
        foreach ($therapists as $therapist)
            if (!empty($therapist['city'])
                && $therapist['city'] === $city
                && !empty($therapist['practices'])
                && is_array($therapist['practices']))
                foreach ($therapist['practices'] as $practice)
                    if (!in_array($practice, $practices, true))
                        $practices[] = $practice;
        sort($practices);
        return $this->returnResponse($practices);
    }

    public function getCityPracticeTherapists(string $city, string $practice)
    {
        $therapists = $this->importTherapists();
        // filter therapists by city and practice
        foreach ($therapists as $key => $therapist) {
            // filter by city
            if (empty($therapist['city']) || $therapist['city'] !== $city)
                unset($therapists[$key]);
            // filter by practice
            if (empty($therapist['practices'])
                || !is_array($therapist['practices'])
                || !in_array($practice, $therapist['practices']))
                unset($therapists[$key]);
        }
        $therapists = array_values($therapists);
        return $this->returnResponse($therapists);
    }
}
