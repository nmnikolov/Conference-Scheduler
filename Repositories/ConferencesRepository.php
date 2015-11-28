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
     * @return int
     * @throws ApplicationException
     */
    public function create(Conference $conference) : int {
        if ($this->conferenceTitleExists($conference->getTitle())) {
            throw new ApplicationException("Conference with this title already exists!");
        }

        $query = "INSERT INTO conferences (title, description, start_time, end_time, owner_id) VALUES (?, ?, ?, ?, ?)";

        $result = $this->db->prepare($query);
        $result->execute([
            $conference->getTitle(),
            $conference->getDescription(),
            $conference->getStartTime(),
            $conference->getEndTime(),
            $conference->getOwnerId()
        ]);

        if($result->rowCount() < 1 ){
            throw new ApplicationException("Couldn't create conference.");
        }

        return intval($this->db->lastId());
    }

    /**
     * @return array
     */
    public function getAllConferences(){
        $query = "SELECT
          c.id,
          c.title,
          c.description,
          c.start_time AS startTime,
          c.end_time AS endTime,
          c.is_active AS isActive,
          v.id AS venueId,
          v.name as venueName
        FROM conferences AS c
        LEFT JOIN venues AS v
          on v.id = c.venue_id
        ORDER BY c.title";

        $result = $this->db->prepare($query);
        $result->execute([]);

        return $result->fetchAll();
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
          c.is_active as isActive,
          u.id as ownerId,
          u.username as ownerUsername,
          u.fullname as ownerFullname,
          v.id as venueId,
          v.description as venueDescription,
          v.address as venueAddress,
          v.name as venueName
        FROM conferences AS c
        JOIN users AS u
          ON u.id = c.owner_id
        LEFT JOIN venues AS v
            ON v.id = c.venue_id
        WHERE c.id = ?";

        $result = $this->db->prepare($query);
        $result->execute([$id]);

        if($result->rowCount() < 1 ){
            throw new ApplicationException("Conference not found.");
        }

        return $result->fetch();
    }

    /**
     * @param string $conferenceTitle
     * @return bool
     */
    private function conferenceTitleExists(string $conferenceTitle) : bool {
        $query = "SELECT id FROM conferences WHERE title = ?";
        $result = $this->db->prepare($query);
        $result->execute([$conferenceTitle]);

        return $result->rowCount() > 0;
    }
}