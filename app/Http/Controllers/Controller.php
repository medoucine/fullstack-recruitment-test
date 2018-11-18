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

    public function getCities()
    {
        $therapists = $this->importTherapists();
        $cities = [];
        foreach ($therapists as $therapist)
            if (!empty($therapist['city']) && !in_array($therapist['city'], $cities))
                $cities[] = $therapist['city'];
        sort($cities);
        // return result as JSON
        $therapists = json_encode($cities);
        return response($therapists, 200)
            ->header('Content-Type', 'application/json');
    }

    public function getPracticies()
    {
        $therapists = $this->importTherapists();
        $practices = [];
        foreach ($therapists as $therapist)
            if (!empty($therapist['practices']) && is_array($therapist['practices']))
                foreach ($therapist['practices'] as $practice)
                    if (!in_array($practice, $practices))
                        $practices[] = $practice;
        sort($practices);
        // return result as JSON
        $therapists = json_encode($practices);
        return response($therapists, 200)
            ->header('Content-Type', 'application/json');
    }

    public function getTherapistsByCity(string $city)
    {
        return $this->getTherapistsByCityAndPractice($city, null);
    }

    public function getTherapistsByPractice(string $practice)
    {
        return $this->getTherapistsByCityAndPractice(null, $practice);
    }

    public function getTherapistsByCityAndPractice(?string $city, ?string $practice)
    {
        $therapists = $this->importTherapists();
        // filter therapists by city and practice
        foreach ($therapists as $key => $therapist) {
            // filter by city
            if (!is_null($city)) {
                if (empty($therapist['city']) || $therapist['city'] !== $city)
                    unset($therapists[$key]);
            }
            // filter by practice
            if (!is_null($practice)) {
                if (empty($therapist['practices'])
                    || !is_array($therapist['practices'])
                    || !in_array($practice, $therapist['practices']))
                    unset($therapists[$key]);
            }
        }
        // return result as JSON
        $therapists = json_encode($therapists);
        return response($therapists, 200)
            ->header('Content-Type', 'application/json');
    }
}
