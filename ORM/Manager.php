<?php
declare(strict_types=1);

namespace Framework\ORM;

use Framework\Config\AppConfig;
use Framework\Database\Database;
use Framework\Helpers\Helpers;
use Framework\Identity\RoleManager;

class Manager
{
    /**
     * @var Manager
     */
    protected static $inst = null;

    /**
     * UserManager constructor.
     */
    private function __construct(){
    }

    /**
     * @return Manager
     */
    public static function getInstance() : Manager
    {
        if (self::$inst == null){
            self::$inst = new Manager();
        }

        return self::$inst;
    }

    public function start(){
        if (Helpers::needScan("Config/migrations.txt", "Identity/Tables/.")) {
            $this->updateDatabase();
        }

        $this->seedRoles();
    }

    private function seedRoles(){
        if (!$this->tableExists("roles")) {
            $this->updateDatabase();
        }

        if (!RoleManager::getInstance()->exists(AppConfig::DEFAULT_ADMIN_ROLE)) {
            RoleManager::getInstance()->createRole(AppConfig::DEFAULT_ADMIN_ROLE);
        }

        if (!RoleManager::getInstance()->exists(AppConfig::DEFAULT_REGISTRATION_ROLE)) {
            RoleManager::getInstance()->createRole(AppConfig::DEFAULT_REGISTRATION_ROLE);
        }
    }

    private function updateDatabase(){
        $tablesClasses = $this->getIdentityClasses();
        $this->processTableClasses($tablesClasses);
        Helpers::writeInFile("Config/migrations.txt", strval(time()));
    }

    private function processTableClasses(array $tableClasses){
        foreach ($tableClasses as $tableClass) {
            $tableName = $this->getTableName($tableClass);
            $classDoc =  $this->parseClassDoc($tableClass);
            $columns = $this->getTableColumns($tableClass);

            if (!$this->tableExists($tableName)) {
                $this->createTable($tableName, $columns, $classDoc);
            }
//            else {
//                $db = Database::getInstance('app');
//
//                $q = $db->query("DESCRIBE $tableName");
//                $table_fields = $q->fetchAll(\PDO::FETCH_ASSOC);
//
//                print_r("<strong>" . $tableName . "</strong><br>");
//
//                foreach ($table_fields as $table_field) {
//                    foreach ($table_field as $key => $value) {
//                        print_r($key . " => " . $value . "<br>");
//                    }
//
//                    print_r("<br>");
//                }
//            }
        }
    }

    /**
     * @param string $class
     * @return array
     */
    private function parseClassDoc(string $class) : array {
        $classDoc = array();
        $rc = new \ReflectionClass($class);

        if (preg_match_all('/@Primary\s*([^\s\n*]+)/', $rc->getDocComment(), $fieldMatch)) {
            $str = "PRIMARY KEY (" . implode(", ", $fieldMatch[1]) . ")";
            $classDoc[] = $str;
        }

        if (preg_match_all('/@Foreign\s*([^\n*]+)/', $rc->getDocComment(), $fieldMatch)) {
            foreach ($fieldMatch[1] as $item) {
                $classDoc[] = "FOREIGN KEY " . $item;
            }
        }

        return $classDoc;
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @param array $classDoc
     * @return bool
     * @throws \Exception
     */
    private function createTable(string $tableName, array $columns, array $classDoc) : bool {
        try {
            $db = Database::getInstance('app');
            $sql = "CREATE table $tableName (";
            $col = array();

            foreach ($columns as $column) {
                $colStr = $column["Field"] . " " .
                    $column["Type"];

                if ($column["Null"] === "NO" && $column["Key"] !== "PRI") {
                    $colStr .= " NOT NULL";
                }

                if ($column["Extra"] === "auto_increment") {
                    $colStr .= " AUTO_INCREMENT";
                }

                if ($column["Key"] === "PRI") {
                    $colStr .= " PRIMARY KEY";
                }

                if ($column["Key"] === "UNI") {
                    $colStr .= " UNIQUE";
                }

                $col[] = $colStr;
            }

            $sql .= implode(",\n", $col);

            if (count($classDoc) > 0) {
                $sql .= ", " . implode(", ", $classDoc);
            }

            $sql .= ");";
            $db->query($sql);
        } catch(\PDOException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param string $table
     * @return bool
     * @throws \Exception
     */
    private function tableExists(string $table) : bool {
        $db = Database::getInstance('app');

        $result = $db->prepare("SHOW TABLES LIKE ?");
        $result->execute([$table]);

        return $result->rowCount() > 0;
    }

    /**
     * @return array
     */
    private function getIdentityClasses() : array {
        $identityClasses = array();
        $path = "Identity\\Tables";
        $files = array_diff(scandir($path), array('..', '.'));

        foreach($files AS $file)
        {
            $fullFileName = "Framework\\" . $path . "\\" . substr($file, 0, strlen($file) - 4);
            $identityClasses[] = $fullFileName;
        }

        return $identityClasses;
    }

    /**
     * @param string $class
     * @return array
     */
    private function getTableColumns(string $class) : array {
        $properties = array();
        try {
            $rc = new \ReflectionClass($class);

            do {
                $rp = array();
                /* @var $p \ReflectionProperty */
                foreach ($rc->getProperties() as $p) {
                    $p->setAccessible(true);
                    preg_match('/@Field\s*([^\s\n*]+)/', $p->getDocComment(), $fieldMatch);
                    $field = $fieldMatch[1];
                    $rp[$field] = array();
                    $rp[$field]["Field"] = $field;

                    preg_match('/@Type\s*([^\s\n*]+)/', $p->getDocComment(), $typeMatch);
                    preg_match('/@Length\s*([^\s\n*]+)/', $p->getDocComment(), $lengthMatch);
                    $type = $typeMatch[1] . "(" . $lengthMatch[1] . ")";
                    $rp[$field]["Type"] = strtolower($type);
                    $rp[$field]["Null"] = preg_match('/@Null\s*/', $p->getDocComment(), $nullMatch) ? "YES" : "NO";

                    if (preg_match('/@Primary\s*/', $p->getDocComment(), $keyMatch)) {
                        $rp[$field]["Key"] = "PRI";
                    } else if (preg_match('/@Unique\s*/', $p->getDocComment(), $keyMatch)){
                        $rp[$field]["Key"] = "UNI";
                    } else {
                        $rp[$field]["Key"] = "";
                    }

                    $rp[$field]["Extra"] = preg_match('/@Increment\s*/', $p->getDocComment(), $incrementMatch) ? "auto_increment" : "";
                }

                $properties = array_merge($rp, $properties);
            } while ($rc = $rc->getParentClass());
        } catch (\ReflectionException $e) { }
        return $properties;
    }

    /**
     * @param string $class
     * @return string
     * @throws \Exception
     */
    private function getTableName(string $class) : string {
        $rc = new \ReflectionClass($class);
        if ($rc->getDocComment() && preg_match('/@Table\s*([^\s\n*]+)/', $rc->getDocComment(), $matches)) {
            $tableName = $matches[1];
        } else {
            throw new \Exception("No table name defined for this class!");
        }

        return $tableName;
    }
}