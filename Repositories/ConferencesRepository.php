<?php
declare(strict_types=1);

namespace Framework\Repositories;

use Framework\Database\Database;
use Framework\Exceptions\ApplicationException;
use Framework\Models\Conference;

class ConferencesRepository
{
    /**
     * @var ConferencesRepository
     */
    private static $inst = null;

    /**
     * @var Database
     */
    private $db;

    /**
     * ConferencesRepository constructor.
     * @param Database $db
     */
    private function __construct(Database $db){
        $this->db = $db;
    }

    /**
     * @return ConferencesRepository
     */
    public static function getInstance() : ConferencesRepository
    {
        if (self::$inst == null){
            self::$inst = new ConferencesRepository(Database::getInstance('app'));
        }

        return self::$inst;
    }

    /**
     * @param Conference $conference
     * @throws ApplicationException
     */
    public function create(Conference $conference){
        $query = "INSERT INTO conferences (title, description, start_time, end_time, owner_id, venue_id) VALUES (?, ?, ?, ?, ?, ?)";

        $result = $this->db->prepare($query);
        $result->execute([
            $conference->getTitle(),
            $conference->getDescription(),
            $conference->getStartTime(),
            $conference->getEndTime(),
            $conference->getOwnerId(),
            $conference->getVenueId()
        ]);

        if($result->rowCount() < 1 ){
            throw new ApplicationException("Couldn't create conference.");
        }
    }

    /**
     * @param int $id
     * @throws ApplicationException
     */
    public function getById(int $id){
        $query = "SELECT
          c.id,
          c.title,
          c.description,
          c.start_time as startTime,
          c.end_time as endTime,
          v.id as venueId,
          v.description as venueDescription,
          v.address as venueAddress,
          v.name as venueName
        FROM conferences AS c
        JOIN venues AS v
          ON v.id = c.venue_id
        WHERE c.id = ?";

        $result = $this->db->prepare($query);
        $result->execute([$id]);

        if($result->rowCount() < 1 ){
            throw new ApplicationException("Conference not found.");
        }

        return $result->fetch();
    }
}