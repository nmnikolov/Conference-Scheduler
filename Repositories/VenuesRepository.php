<?php
declare(strict_types=1);

namespace Framework\Repositories;

use Framework\Database\Database;
use Framework\Exceptions\ApplicationException;
use Framework\Models\Conference;
use Framework\Models\Venue;

class VenuesRepository
{
    /**
     * @var VenuesRepository
     */
    private static $inst = null;

    /**
     * @var Database
     */
    private $db;

    /**
     * VenuesRepository constructor.
     * @param Database $db
     */
    private function __construct(Database $db){
        $this->db = $db;
    }

    /**
     * @return VenuesRepository
     */
    public static function getInstance() : VenuesRepository
    {
        if (self::$inst == null){
            self::$inst = new VenuesRepository(Database::getInstance('app'));
        }

        return self::$inst;
    }

    /**
     * @param Venue $model
     * @return bool
     * @throws ApplicationException
     */
    public function create(Venue $model) : bool {
        if ($this->venueNameExists($model->getName())){
            throw new ApplicationException("Venue witn this name already exists!");
        }

        $query = "INSERT INTO venues(name, description, address) VALUES(?, ?, ?)";
        $result = $this->db->prepare($query);
        $result->execute([
            $model->getName(),
            $model->getDescription(),
            $model->getAddress()
        ]);

        return $result->rowCount() > 0;
    }

    /**
     * @return array
     */
    public function getActiveVenuesPreview(){
        $query = "SELECT
            v.id,
            v.name
        FROM venues AS v
        WHERE v.isActive = TRUE";

        $result = $this->db->prepare($query);
        $result->execute([]);

        return $result->fetchAll();
    }

    /**
     * @return array
     */
    public function getAllVenues(){
        $query = "SELECT
        v.id,
        v.name,
        v.description,
        v.address,
        v.isActive
        FROM venues AS v
        ORDER BY v.name";

        $result = $this->db->prepare($query);
        $result->execute([]);

        return $result->fetchAll();
    }

    /**
     * @param int $venueId
     */
    public function deactivateVenue(int $venueId) : bool{
        $query = "UPDATE venues SET isActive = FALSE WHERE id = ?";
        $result = $this->db->prepare($query);
        $result->execute([$venueId]);

        return $result->rowCount() > 0;
    }

    /**
     * @param string $venueName
     * @return bool
     */
    private function venueNameExists(string $venueName) : bool {
        $query = "SELECT id FROM venues WHERE name = ?";
        $result = $this->db->prepare($query);
        $result->execute([$venueName]);

        return $result->rowCount() > 0;
    }
}