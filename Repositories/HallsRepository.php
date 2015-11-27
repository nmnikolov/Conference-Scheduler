<?php
declare(strict_types=1);

namespace Framework\Repositories;

use Framework\Database\Database;
use Framework\Exceptions\ApplicationException;
use Framework\Models\Conference;
use Framework\Models\Hall;

class HallsRepository
{
    /**
     * @var HallsRepository
     */
    private static $inst = null;

    /**
     * @var Database
     */
    private $db;

    /**
     * HallsRepository constructor.
     * @param Database $db
     */
    private function __construct(Database $db){
        $this->db = $db;
    }

    /**
     * @return HallsRepository
     */
    public static function getInstance() : HallsRepository
    {
        if (self::$inst == null){
            self::$inst = new HallsRepository(Database::getInstance('app'));
        }

        return self::$inst;
    }

    /**
     * @param Hall $hall
     * @throws ApplicationException
     */
    public function create(Hall $hall){
        if ($this->hallNameExists($hall->getName())) {
            throw new ApplicationException("Hall with this name already exists!");
        }

        $query = "INSERT INTO halls (name, capacity, venue_id) VALUES (?, ?, ?)";

        $result = $this->db->prepare($query);
        $result->execute([
            $hall->getName(),
            $hall->getCapacity(),
            $hall->getVenueId()
        ]);

        if($result->rowCount() < 1 ){
            throw new ApplicationException("Couldn't create hall.");
        }
    }

    /**
     * @return array
     */
    public function getAllHalls(){
        $query = "SELECT
        h.id,
        h.name,
        h.capacity,
        h.isActive,
        v.name as venue
        FROM halls AS h
        JOIN venues AS v
          ON v.id = h.venue_id
        ORDER BY h.name";

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
          *
        FROM halls AS c
        JOIN venues AS v
          ON v.id = c.venue_id
        WHERE c.id = ?";

        $result = $this->db->prepare($query);
        $result->execute([$id]);

        if($result->rowCount() < 1 ){
            throw new ApplicationException("Hall not found.");
        }

        return $result->fetch();
    }

    /**
     * @param string $hallName
     * @return bool
     */
    private function hallNameExists(string $hallName) : bool {
        $query = "SELECT id FROM halls WHERE name = ?";
        $result = $this->db->prepare($query);
        $result->execute([$hallName]);

        return $result->rowCount() > 0;
    }
}