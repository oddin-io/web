<?php

namespace BossEdu\Model\Map;

use BossEdu\Model\Person;
use BossEdu\Model\PersonQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'person' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PersonTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'BossEdu.Model.Map.PersonTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'person';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\BossEdu\\Model\\Person';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'BossEdu.Model.Person';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the id field
     */
    const COL_ID = 'person.id';

    /**
     * the column name for the document_name field
     */
    const COL_DOCUMENT_NAME = 'person.document_name';

    /**
     * the column name for the document_number field
     */
    const COL_DOCUMENT_NUMBER = 'person.document_number';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'person.name';

    /**
     * the column name for the birth_date field
     */
    const COL_BIRTH_DATE = 'person.birth_date';

    /**
     * the column name for the telephone field
     */
    const COL_TELEPHONE = 'person.telephone';

    /**
     * the column name for the country field
     */
    const COL_COUNTRY = 'person.country';

    /**
     * the column name for the state field
     */
    const COL_STATE = 'person.state';

    /**
     * the column name for the town field
     */
    const COL_TOWN = 'person.town';

    /**
     * the column name for the district field
     */
    const COL_DISTRICT = 'person.district';

    /**
     * the column name for the street field
     */
    const COL_STREET = 'person.street';

    /**
     * the column name for the number field
     */
    const COL_NUMBER = 'person.number';

    /**
     * the column name for the current_instruction field
     */
    const COL_CURRENT_INSTRUCTION = 'person.current_instruction';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'person.email';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'DocumentName', 'DocumentNumber', 'Name', 'BirthDate', 'Telephone', 'Country', 'State', 'Town', 'District', 'Street', 'Number', 'CurrentInstruction', 'Email', ),
        self::TYPE_CAMELNAME     => array('id', 'documentName', 'documentNumber', 'name', 'birthDate', 'telephone', 'country', 'state', 'town', 'district', 'street', 'number', 'currentInstruction', 'email', ),
        self::TYPE_COLNAME       => array(PersonTableMap::COL_ID, PersonTableMap::COL_DOCUMENT_NAME, PersonTableMap::COL_DOCUMENT_NUMBER, PersonTableMap::COL_NAME, PersonTableMap::COL_BIRTH_DATE, PersonTableMap::COL_TELEPHONE, PersonTableMap::COL_COUNTRY, PersonTableMap::COL_STATE, PersonTableMap::COL_TOWN, PersonTableMap::COL_DISTRICT, PersonTableMap::COL_STREET, PersonTableMap::COL_NUMBER, PersonTableMap::COL_CURRENT_INSTRUCTION, PersonTableMap::COL_EMAIL, ),
        self::TYPE_FIELDNAME     => array('id', 'document_name', 'document_number', 'name', 'birth_date', 'telephone', 'country', 'state', 'town', 'district', 'street', 'number', 'current_instruction', 'email', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'DocumentName' => 1, 'DocumentNumber' => 2, 'Name' => 3, 'BirthDate' => 4, 'Telephone' => 5, 'Country' => 6, 'State' => 7, 'Town' => 8, 'District' => 9, 'Street' => 10, 'Number' => 11, 'CurrentInstruction' => 12, 'Email' => 13, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'documentName' => 1, 'documentNumber' => 2, 'name' => 3, 'birthDate' => 4, 'telephone' => 5, 'country' => 6, 'state' => 7, 'town' => 8, 'district' => 9, 'street' => 10, 'number' => 11, 'currentInstruction' => 12, 'email' => 13, ),
        self::TYPE_COLNAME       => array(PersonTableMap::COL_ID => 0, PersonTableMap::COL_DOCUMENT_NAME => 1, PersonTableMap::COL_DOCUMENT_NUMBER => 2, PersonTableMap::COL_NAME => 3, PersonTableMap::COL_BIRTH_DATE => 4, PersonTableMap::COL_TELEPHONE => 5, PersonTableMap::COL_COUNTRY => 6, PersonTableMap::COL_STATE => 7, PersonTableMap::COL_TOWN => 8, PersonTableMap::COL_DISTRICT => 9, PersonTableMap::COL_STREET => 10, PersonTableMap::COL_NUMBER => 11, PersonTableMap::COL_CURRENT_INSTRUCTION => 12, PersonTableMap::COL_EMAIL => 13, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'document_name' => 1, 'document_number' => 2, 'name' => 3, 'birth_date' => 4, 'telephone' => 5, 'country' => 6, 'state' => 7, 'town' => 8, 'district' => 9, 'street' => 10, 'number' => 11, 'current_instruction' => 12, 'email' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('person');
        $this->setPhpName('Person');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\BossEdu\\Model\\Person');
        $this->setPackage('BossEdu.Model');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('person_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('document_name', 'DocumentName', 'VARCHAR', false, 30, null);
        $this->addColumn('document_number', 'DocumentNumber', 'VARCHAR', false, 30, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 100, null);
        $this->addColumn('birth_date', 'BirthDate', 'DATE', false, null, null);
        $this->addColumn('telephone', 'Telephone', 'VARCHAR', false, 30, null);
        $this->addColumn('country', 'Country', 'VARCHAR', false, 30, null);
        $this->addColumn('state', 'State', 'VARCHAR', false, 30, null);
        $this->addColumn('town', 'Town', 'VARCHAR', false, 100, null);
        $this->addColumn('district', 'District', 'VARCHAR', false, 100, null);
        $this->addColumn('street', 'Street', 'VARCHAR', false, 100, null);
        $this->addColumn('number', 'Number', 'VARCHAR', false, 10, null);
        $this->addForeignKey('current_instruction', 'CurrentInstruction', 'INTEGER', 'instruction', 'id', false, null, null);
        $this->addForeignKey('email', 'Email', 'VARCHAR', 'someone', 'email', true, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Someone', '\\BossEdu\\Model\\Someone', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':email',
    1 => ':email',
  ),
), null, null, null, false);
        $this->addRelation('Instruction', '\\BossEdu\\Model\\Instruction', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':current_instruction',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('PiLink', '\\BossEdu\\Model\\PiLink', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':person_id',
    1 => ':id',
  ),
), null, null, 'PiLinks', false);
        $this->addRelation('Presentation', '\\BossEdu\\Model\\Presentation', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':person_id',
    1 => ':id',
  ),
), null, null, 'Presentations', false);
        $this->addRelation('Doubt', '\\BossEdu\\Model\\Doubt', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':person_id',
    1 => ':id',
  ),
), null, null, 'Doubts', false);
        $this->addRelation('PdLike', '\\BossEdu\\Model\\PdLike', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':person_id',
    1 => ':id',
  ),
), null, null, 'PdLikes', false);
        $this->addRelation('Contribution', '\\BossEdu\\Model\\Contribution', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':person_id',
    1 => ':id',
  ),
), null, null, 'Contributions', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PersonTableMap::CLASS_DEFAULT : PersonTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Person object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PersonTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PersonTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PersonTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PersonTableMap::OM_CLASS;
            /** @var Person $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PersonTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PersonTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PersonTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Person $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PersonTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PersonTableMap::COL_ID);
            $criteria->addSelectColumn(PersonTableMap::COL_DOCUMENT_NAME);
            $criteria->addSelectColumn(PersonTableMap::COL_DOCUMENT_NUMBER);
            $criteria->addSelectColumn(PersonTableMap::COL_NAME);
            $criteria->addSelectColumn(PersonTableMap::COL_BIRTH_DATE);
            $criteria->addSelectColumn(PersonTableMap::COL_TELEPHONE);
            $criteria->addSelectColumn(PersonTableMap::COL_COUNTRY);
            $criteria->addSelectColumn(PersonTableMap::COL_STATE);
            $criteria->addSelectColumn(PersonTableMap::COL_TOWN);
            $criteria->addSelectColumn(PersonTableMap::COL_DISTRICT);
            $criteria->addSelectColumn(PersonTableMap::COL_STREET);
            $criteria->addSelectColumn(PersonTableMap::COL_NUMBER);
            $criteria->addSelectColumn(PersonTableMap::COL_CURRENT_INSTRUCTION);
            $criteria->addSelectColumn(PersonTableMap::COL_EMAIL);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.document_name');
            $criteria->addSelectColumn($alias . '.document_number');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.birth_date');
            $criteria->addSelectColumn($alias . '.telephone');
            $criteria->addSelectColumn($alias . '.country');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.town');
            $criteria->addSelectColumn($alias . '.district');
            $criteria->addSelectColumn($alias . '.street');
            $criteria->addSelectColumn($alias . '.number');
            $criteria->addSelectColumn($alias . '.current_instruction');
            $criteria->addSelectColumn($alias . '.email');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PersonTableMap::DATABASE_NAME)->getTable(PersonTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PersonTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PersonTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PersonTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Person or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Person object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \BossEdu\Model\Person) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PersonTableMap::DATABASE_NAME);
            $criteria->add(PersonTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PersonQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PersonTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PersonTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the person table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PersonQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Person or Criteria object.
     *
     * @param mixed               $criteria Criteria or Person object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Person object
        }

        if ($criteria->containsKey(PersonTableMap::COL_ID) && $criteria->keyContainsValue(PersonTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PersonTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PersonQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PersonTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PersonTableMap::buildTableMap();
