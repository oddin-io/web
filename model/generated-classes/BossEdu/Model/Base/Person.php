<?php

namespace BossEdu\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use BossEdu\Model\Contribution as ChildContribution;
use BossEdu\Model\ContributionQuery as ChildContributionQuery;
use BossEdu\Model\Doubt as ChildDoubt;
use BossEdu\Model\DoubtQuery as ChildDoubtQuery;
use BossEdu\Model\PdLike as ChildPdLike;
use BossEdu\Model\PdLikeQuery as ChildPdLikeQuery;
use BossEdu\Model\Person as ChildPerson;
use BossEdu\Model\PersonQuery as ChildPersonQuery;
use BossEdu\Model\PiLink as ChildPiLink;
use BossEdu\Model\PiLinkQuery as ChildPiLinkQuery;
use BossEdu\Model\Presentation as ChildPresentation;
use BossEdu\Model\PresentationQuery as ChildPresentationQuery;
use BossEdu\Model\Someone as ChildSomeone;
use BossEdu\Model\SomeoneQuery as ChildSomeoneQuery;
use BossEdu\Model\Map\ContributionTableMap;
use BossEdu\Model\Map\DoubtTableMap;
use BossEdu\Model\Map\PdLikeTableMap;
use BossEdu\Model\Map\PersonTableMap;
use BossEdu\Model\Map\PiLinkTableMap;
use BossEdu\Model\Map\PresentationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'person' table.
 *
 * 
 *
* @package    propel.generator.BossEdu.Model.Base
*/
abstract class Person implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\BossEdu\\Model\\Map\\PersonTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * 
     * @var        int
     */
    protected $id;

    /**
     * The value for the document_name field.
     * 
     * @var        string
     */
    protected $document_name;

    /**
     * The value for the document_number field.
     * 
     * @var        string
     */
    protected $document_number;

    /**
     * The value for the name field.
     * 
     * @var        string
     */
    protected $name;

    /**
     * The value for the birth_date field.
     * 
     * @var        \DateTime
     */
    protected $birth_date;

    /**
     * The value for the telephone field.
     * 
     * @var        string
     */
    protected $telephone;

    /**
     * The value for the country field.
     * 
     * @var        string
     */
    protected $country;

    /**
     * The value for the state field.
     * 
     * @var        string
     */
    protected $state;

    /**
     * The value for the town field.
     * 
     * @var        string
     */
    protected $town;

    /**
     * The value for the district field.
     * 
     * @var        string
     */
    protected $district;

    /**
     * The value for the street field.
     * 
     * @var        string
     */
    protected $street;

    /**
     * The value for the number field.
     * 
     * @var        string
     */
    protected $number;

    /**
     * The value for the email field.
     * 
     * @var        string
     */
    protected $email;

    /**
     * @var        ChildSomeone
     */
    protected $aSomeone;

    /**
     * @var        ObjectCollection|ChildPiLink[] Collection to store aggregation of ChildPiLink objects.
     */
    protected $collPiLinks;
    protected $collPiLinksPartial;

    /**
     * @var        ObjectCollection|ChildPresentation[] Collection to store aggregation of ChildPresentation objects.
     */
    protected $collPresentations;
    protected $collPresentationsPartial;

    /**
     * @var        ObjectCollection|ChildDoubt[] Collection to store aggregation of ChildDoubt objects.
     */
    protected $collDoubts;
    protected $collDoubtsPartial;

    /**
     * @var        ObjectCollection|ChildPdLike[] Collection to store aggregation of ChildPdLike objects.
     */
    protected $collPdLikes;
    protected $collPdLikesPartial;

    /**
     * @var        ObjectCollection|ChildContribution[] Collection to store aggregation of ChildContribution objects.
     */
    protected $collContributions;
    protected $collContributionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPiLink[]
     */
    protected $piLinksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPresentation[]
     */
    protected $presentationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDoubt[]
     */
    protected $doubtsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPdLike[]
     */
    protected $pdLikesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildContribution[]
     */
    protected $contributionsScheduledForDeletion = null;

    /**
     * Initializes internal state of BossEdu\Model\Base\Person object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Person</code> instance.  If
     * <code>obj</code> is an instance of <code>Person</code>, delegates to
     * <code>equals(Person)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Person The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));
        
        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }
        
        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [document_name] column value.
     * 
     * @return string
     */
    public function getDocumentName()
    {
        return $this->document_name;
    }

    /**
     * Get the [document_number] column value.
     * 
     * @return string
     */
    public function getDocumentNumber()
    {
        return $this->document_number;
    }

    /**
     * Get the [name] column value.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [optionally formatted] temporal [birth_date] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getBirthDate($format = NULL)
    {
        if ($format === null) {
            return $this->birth_date;
        } else {
            return $this->birth_date instanceof \DateTime ? $this->birth_date->format($format) : null;
        }
    }

    /**
     * Get the [telephone] column value.
     * 
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get the [country] column value.
     * 
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get the [state] column value.
     * 
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the [town] column value.
     * 
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Get the [district] column value.
     * 
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Get the [street] column value.
     * 
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Get the [number] column value.
     * 
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get the [email] column value.
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PersonTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [document_name] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setDocumentName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->document_name !== $v) {
            $this->document_name = $v;
            $this->modifiedColumns[PersonTableMap::COL_DOCUMENT_NAME] = true;
        }

        return $this;
    } // setDocumentName()

    /**
     * Set the value of [document_number] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setDocumentNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->document_number !== $v) {
            $this->document_number = $v;
            $this->modifiedColumns[PersonTableMap::COL_DOCUMENT_NUMBER] = true;
        }

        return $this;
    } // setDocumentNumber()

    /**
     * Set the value of [name] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PersonTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Sets the value of [birth_date] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setBirthDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->birth_date !== null || $dt !== null) {
            if ($this->birth_date === null || $dt === null || $dt->format("Y-m-d") !== $this->birth_date->format("Y-m-d")) {
                $this->birth_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersonTableMap::COL_BIRTH_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setBirthDate()

    /**
     * Set the value of [telephone] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setTelephone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telephone !== $v) {
            $this->telephone = $v;
            $this->modifiedColumns[PersonTableMap::COL_TELEPHONE] = true;
        }

        return $this;
    } // setTelephone()

    /**
     * Set the value of [country] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setCountry($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->country !== $v) {
            $this->country = $v;
            $this->modifiedColumns[PersonTableMap::COL_COUNTRY] = true;
        }

        return $this;
    } // setCountry()

    /**
     * Set the value of [state] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->state !== $v) {
            $this->state = $v;
            $this->modifiedColumns[PersonTableMap::COL_STATE] = true;
        }

        return $this;
    } // setState()

    /**
     * Set the value of [town] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setTown($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->town !== $v) {
            $this->town = $v;
            $this->modifiedColumns[PersonTableMap::COL_TOWN] = true;
        }

        return $this;
    } // setTown()

    /**
     * Set the value of [district] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setDistrict($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->district !== $v) {
            $this->district = $v;
            $this->modifiedColumns[PersonTableMap::COL_DISTRICT] = true;
        }

        return $this;
    } // setDistrict()

    /**
     * Set the value of [street] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setStreet($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->street !== $v) {
            $this->street = $v;
            $this->modifiedColumns[PersonTableMap::COL_STREET] = true;
        }

        return $this;
    } // setStreet()

    /**
     * Set the value of [number] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->number !== $v) {
            $this->number = $v;
            $this->modifiedColumns[PersonTableMap::COL_NUMBER] = true;
        }

        return $this;
    } // setNumber()

    /**
     * Set the value of [email] column.
     * 
     * @param string $v new value
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[PersonTableMap::COL_EMAIL] = true;
        }

        if ($this->aSomeone !== null && $this->aSomeone->getEmail() !== $v) {
            $this->aSomeone = null;
        }

        return $this;
    } // setEmail()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PersonTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PersonTableMap::translateFieldName('DocumentName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->document_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PersonTableMap::translateFieldName('DocumentNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->document_number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PersonTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PersonTableMap::translateFieldName('BirthDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->birth_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PersonTableMap::translateFieldName('Telephone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->telephone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PersonTableMap::translateFieldName('Country', TableMap::TYPE_PHPNAME, $indexType)];
            $this->country = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PersonTableMap::translateFieldName('State', TableMap::TYPE_PHPNAME, $indexType)];
            $this->state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PersonTableMap::translateFieldName('Town', TableMap::TYPE_PHPNAME, $indexType)];
            $this->town = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PersonTableMap::translateFieldName('District', TableMap::TYPE_PHPNAME, $indexType)];
            $this->district = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PersonTableMap::translateFieldName('Street', TableMap::TYPE_PHPNAME, $indexType)];
            $this->street = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PersonTableMap::translateFieldName('Number', TableMap::TYPE_PHPNAME, $indexType)];
            $this->number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PersonTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = PersonTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\BossEdu\\Model\\Person'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aSomeone !== null && $this->email !== $this->aSomeone->getEmail()) {
            $this->aSomeone = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PersonTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPersonQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSomeone = null;
            $this->collPiLinks = null;

            $this->collPresentations = null;

            $this->collDoubts = null;

            $this->collPdLikes = null;

            $this->collContributions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Person::setDeleted()
     * @see Person::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPersonQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PersonTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aSomeone !== null) {
                if ($this->aSomeone->isModified() || $this->aSomeone->isNew()) {
                    $affectedRows += $this->aSomeone->save($con);
                }
                $this->setSomeone($this->aSomeone);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->piLinksScheduledForDeletion !== null) {
                if (!$this->piLinksScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\PiLinkQuery::create()
                        ->filterByPrimaryKeys($this->piLinksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->piLinksScheduledForDeletion = null;
                }
            }

            if ($this->collPiLinks !== null) {
                foreach ($this->collPiLinks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->presentationsScheduledForDeletion !== null) {
                if (!$this->presentationsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\PresentationQuery::create()
                        ->filterByPrimaryKeys($this->presentationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->presentationsScheduledForDeletion = null;
                }
            }

            if ($this->collPresentations !== null) {
                foreach ($this->collPresentations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->doubtsScheduledForDeletion !== null) {
                if (!$this->doubtsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\DoubtQuery::create()
                        ->filterByPrimaryKeys($this->doubtsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->doubtsScheduledForDeletion = null;
                }
            }

            if ($this->collDoubts !== null) {
                foreach ($this->collDoubts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pdLikesScheduledForDeletion !== null) {
                if (!$this->pdLikesScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\PdLikeQuery::create()
                        ->filterByPrimaryKeys($this->pdLikesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pdLikesScheduledForDeletion = null;
                }
            }

            if ($this->collPdLikes !== null) {
                foreach ($this->collPdLikes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contributionsScheduledForDeletion !== null) {
                if (!$this->contributionsScheduledForDeletion->isEmpty()) {
                    \BossEdu\Model\ContributionQuery::create()
                        ->filterByPrimaryKeys($this->contributionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contributionsScheduledForDeletion = null;
                }
            }

            if ($this->collContributions !== null) {
                foreach ($this->collContributions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PersonTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PersonTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {                
                $dataFetcher = $con->query("SELECT nextval('person_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PersonTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PersonTableMap::COL_DOCUMENT_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'document_name';
        }
        if ($this->isColumnModified(PersonTableMap::COL_DOCUMENT_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'document_number';
        }
        if ($this->isColumnModified(PersonTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(PersonTableMap::COL_BIRTH_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'birth_date';
        }
        if ($this->isColumnModified(PersonTableMap::COL_TELEPHONE)) {
            $modifiedColumns[':p' . $index++]  = 'telephone';
        }
        if ($this->isColumnModified(PersonTableMap::COL_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'country';
        }
        if ($this->isColumnModified(PersonTableMap::COL_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'state';
        }
        if ($this->isColumnModified(PersonTableMap::COL_TOWN)) {
            $modifiedColumns[':p' . $index++]  = 'town';
        }
        if ($this->isColumnModified(PersonTableMap::COL_DISTRICT)) {
            $modifiedColumns[':p' . $index++]  = 'district';
        }
        if ($this->isColumnModified(PersonTableMap::COL_STREET)) {
            $modifiedColumns[':p' . $index++]  = 'street';
        }
        if ($this->isColumnModified(PersonTableMap::COL_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'number';
        }
        if ($this->isColumnModified(PersonTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }

        $sql = sprintf(
            'INSERT INTO person (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'document_name':                        
                        $stmt->bindValue($identifier, $this->document_name, PDO::PARAM_STR);
                        break;
                    case 'document_number':                        
                        $stmt->bindValue($identifier, $this->document_number, PDO::PARAM_STR);
                        break;
                    case 'name':                        
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'birth_date':                        
                        $stmt->bindValue($identifier, $this->birth_date ? $this->birth_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'telephone':                        
                        $stmt->bindValue($identifier, $this->telephone, PDO::PARAM_STR);
                        break;
                    case 'country':                        
                        $stmt->bindValue($identifier, $this->country, PDO::PARAM_STR);
                        break;
                    case 'state':                        
                        $stmt->bindValue($identifier, $this->state, PDO::PARAM_STR);
                        break;
                    case 'town':                        
                        $stmt->bindValue($identifier, $this->town, PDO::PARAM_STR);
                        break;
                    case 'district':                        
                        $stmt->bindValue($identifier, $this->district, PDO::PARAM_STR);
                        break;
                    case 'street':                        
                        $stmt->bindValue($identifier, $this->street, PDO::PARAM_STR);
                        break;
                    case 'number':                        
                        $stmt->bindValue($identifier, $this->number, PDO::PARAM_STR);
                        break;
                    case 'email':                        
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PersonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getDocumentName();
                break;
            case 2:
                return $this->getDocumentNumber();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getBirthDate();
                break;
            case 5:
                return $this->getTelephone();
                break;
            case 6:
                return $this->getCountry();
                break;
            case 7:
                return $this->getState();
                break;
            case 8:
                return $this->getTown();
                break;
            case 9:
                return $this->getDistrict();
                break;
            case 10:
                return $this->getStreet();
                break;
            case 11:
                return $this->getNumber();
                break;
            case 12:
                return $this->getEmail();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Person'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Person'][$this->hashCode()] = true;
        $keys = PersonTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDocumentName(),
            $keys[2] => $this->getDocumentNumber(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getBirthDate(),
            $keys[5] => $this->getTelephone(),
            $keys[6] => $this->getCountry(),
            $keys[7] => $this->getState(),
            $keys[8] => $this->getTown(),
            $keys[9] => $this->getDistrict(),
            $keys[10] => $this->getStreet(),
            $keys[11] => $this->getNumber(),
            $keys[12] => $this->getEmail(),
        );
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aSomeone) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'someone';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'someone';
                        break;
                    default:
                        $key = 'Someone';
                }
        
                $result[$key] = $this->aSomeone->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPiLinks) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'piLinks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pi_links';
                        break;
                    default:
                        $key = 'PiLinks';
                }
        
                $result[$key] = $this->collPiLinks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPresentations) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'presentations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'presentations';
                        break;
                    default:
                        $key = 'Presentations';
                }
        
                $result[$key] = $this->collPresentations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDoubts) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'doubts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'doubts';
                        break;
                    default:
                        $key = 'Doubts';
                }
        
                $result[$key] = $this->collDoubts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPdLikes) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pdLikes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pd_likes';
                        break;
                    default:
                        $key = 'PdLikes';
                }
        
                $result[$key] = $this->collPdLikes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContributions) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contributions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'contributions';
                        break;
                    default:
                        $key = 'Contributions';
                }
        
                $result[$key] = $this->collContributions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\BossEdu\Model\Person
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PersonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\BossEdu\Model\Person
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDocumentName($value);
                break;
            case 2:
                $this->setDocumentNumber($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setBirthDate($value);
                break;
            case 5:
                $this->setTelephone($value);
                break;
            case 6:
                $this->setCountry($value);
                break;
            case 7:
                $this->setState($value);
                break;
            case 8:
                $this->setTown($value);
                break;
            case 9:
                $this->setDistrict($value);
                break;
            case 10:
                $this->setStreet($value);
                break;
            case 11:
                $this->setNumber($value);
                break;
            case 12:
                $this->setEmail($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PersonTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDocumentName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDocumentNumber($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setBirthDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTelephone($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCountry($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setState($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setTown($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setDistrict($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setStreet($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setNumber($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setEmail($arr[$keys[12]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\BossEdu\Model\Person The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PersonTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PersonTableMap::COL_ID)) {
            $criteria->add(PersonTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PersonTableMap::COL_DOCUMENT_NAME)) {
            $criteria->add(PersonTableMap::COL_DOCUMENT_NAME, $this->document_name);
        }
        if ($this->isColumnModified(PersonTableMap::COL_DOCUMENT_NUMBER)) {
            $criteria->add(PersonTableMap::COL_DOCUMENT_NUMBER, $this->document_number);
        }
        if ($this->isColumnModified(PersonTableMap::COL_NAME)) {
            $criteria->add(PersonTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PersonTableMap::COL_BIRTH_DATE)) {
            $criteria->add(PersonTableMap::COL_BIRTH_DATE, $this->birth_date);
        }
        if ($this->isColumnModified(PersonTableMap::COL_TELEPHONE)) {
            $criteria->add(PersonTableMap::COL_TELEPHONE, $this->telephone);
        }
        if ($this->isColumnModified(PersonTableMap::COL_COUNTRY)) {
            $criteria->add(PersonTableMap::COL_COUNTRY, $this->country);
        }
        if ($this->isColumnModified(PersonTableMap::COL_STATE)) {
            $criteria->add(PersonTableMap::COL_STATE, $this->state);
        }
        if ($this->isColumnModified(PersonTableMap::COL_TOWN)) {
            $criteria->add(PersonTableMap::COL_TOWN, $this->town);
        }
        if ($this->isColumnModified(PersonTableMap::COL_DISTRICT)) {
            $criteria->add(PersonTableMap::COL_DISTRICT, $this->district);
        }
        if ($this->isColumnModified(PersonTableMap::COL_STREET)) {
            $criteria->add(PersonTableMap::COL_STREET, $this->street);
        }
        if ($this->isColumnModified(PersonTableMap::COL_NUMBER)) {
            $criteria->add(PersonTableMap::COL_NUMBER, $this->number);
        }
        if ($this->isColumnModified(PersonTableMap::COL_EMAIL)) {
            $criteria->add(PersonTableMap::COL_EMAIL, $this->email);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPersonQuery::create();
        $criteria->add(PersonTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \BossEdu\Model\Person (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDocumentName($this->getDocumentName());
        $copyObj->setDocumentNumber($this->getDocumentNumber());
        $copyObj->setName($this->getName());
        $copyObj->setBirthDate($this->getBirthDate());
        $copyObj->setTelephone($this->getTelephone());
        $copyObj->setCountry($this->getCountry());
        $copyObj->setState($this->getState());
        $copyObj->setTown($this->getTown());
        $copyObj->setDistrict($this->getDistrict());
        $copyObj->setStreet($this->getStreet());
        $copyObj->setNumber($this->getNumber());
        $copyObj->setEmail($this->getEmail());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPiLinks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPiLink($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPresentations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPresentation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDoubts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDoubt($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPdLikes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPdLike($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContributions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContribution($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \BossEdu\Model\Person Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildSomeone object.
     *
     * @param  ChildSomeone $v
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSomeone(ChildSomeone $v = null)
    {
        if ($v === null) {
            $this->setEmail(NULL);
        } else {
            $this->setEmail($v->getEmail());
        }

        $this->aSomeone = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSomeone object, it will not be re-added.
        if ($v !== null) {
            $v->addPerson($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSomeone object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSomeone The associated ChildSomeone object.
     * @throws PropelException
     */
    public function getSomeone(ConnectionInterface $con = null)
    {
        if ($this->aSomeone === null && (($this->email !== "" && $this->email !== null))) {
            $this->aSomeone = ChildSomeoneQuery::create()->findPk($this->email, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSomeone->addPeople($this);
             */
        }

        return $this->aSomeone;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('PiLink' == $relationName) {
            return $this->initPiLinks();
        }
        if ('Presentation' == $relationName) {
            return $this->initPresentations();
        }
        if ('Doubt' == $relationName) {
            return $this->initDoubts();
        }
        if ('PdLike' == $relationName) {
            return $this->initPdLikes();
        }
        if ('Contribution' == $relationName) {
            return $this->initContributions();
        }
    }

    /**
     * Clears out the collPiLinks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPiLinks()
     */
    public function clearPiLinks()
    {
        $this->collPiLinks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPiLinks collection loaded partially.
     */
    public function resetPartialPiLinks($v = true)
    {
        $this->collPiLinksPartial = $v;
    }

    /**
     * Initializes the collPiLinks collection.
     *
     * By default this just sets the collPiLinks collection to an empty array (like clearcollPiLinks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPiLinks($overrideExisting = true)
    {
        if (null !== $this->collPiLinks && !$overrideExisting) {
            return;
        }

        $collectionClassName = PiLinkTableMap::getTableMap()->getCollectionClassName();

        $this->collPiLinks = new $collectionClassName;
        $this->collPiLinks->setModel('\BossEdu\Model\PiLink');
    }

    /**
     * Gets an array of ChildPiLink objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerson is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPiLink[] List of ChildPiLink objects
     * @throws PropelException
     */
    public function getPiLinks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPiLinksPartial && !$this->isNew();
        if (null === $this->collPiLinks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPiLinks) {
                // return empty collection
                $this->initPiLinks();
            } else {
                $collPiLinks = ChildPiLinkQuery::create(null, $criteria)
                    ->filterByPerson($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPiLinksPartial && count($collPiLinks)) {
                        $this->initPiLinks(false);

                        foreach ($collPiLinks as $obj) {
                            if (false == $this->collPiLinks->contains($obj)) {
                                $this->collPiLinks->append($obj);
                            }
                        }

                        $this->collPiLinksPartial = true;
                    }

                    return $collPiLinks;
                }

                if ($partial && $this->collPiLinks) {
                    foreach ($this->collPiLinks as $obj) {
                        if ($obj->isNew()) {
                            $collPiLinks[] = $obj;
                        }
                    }
                }

                $this->collPiLinks = $collPiLinks;
                $this->collPiLinksPartial = false;
            }
        }

        return $this->collPiLinks;
    }

    /**
     * Sets a collection of ChildPiLink objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $piLinks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function setPiLinks(Collection $piLinks, ConnectionInterface $con = null)
    {
        /** @var ChildPiLink[] $piLinksToDelete */
        $piLinksToDelete = $this->getPiLinks(new Criteria(), $con)->diff($piLinks);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->piLinksScheduledForDeletion = clone $piLinksToDelete;

        foreach ($piLinksToDelete as $piLinkRemoved) {
            $piLinkRemoved->setPerson(null);
        }

        $this->collPiLinks = null;
        foreach ($piLinks as $piLink) {
            $this->addPiLink($piLink);
        }

        $this->collPiLinks = $piLinks;
        $this->collPiLinksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PiLink objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PiLink objects.
     * @throws PropelException
     */
    public function countPiLinks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPiLinksPartial && !$this->isNew();
        if (null === $this->collPiLinks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPiLinks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPiLinks());
            }

            $query = ChildPiLinkQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerson($this)
                ->count($con);
        }

        return count($this->collPiLinks);
    }

    /**
     * Method called to associate a ChildPiLink object to this object
     * through the ChildPiLink foreign key attribute.
     *
     * @param  ChildPiLink $l ChildPiLink
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function addPiLink(ChildPiLink $l)
    {
        if ($this->collPiLinks === null) {
            $this->initPiLinks();
            $this->collPiLinksPartial = true;
        }

        if (!$this->collPiLinks->contains($l)) {
            $this->doAddPiLink($l);

            if ($this->piLinksScheduledForDeletion and $this->piLinksScheduledForDeletion->contains($l)) {
                $this->piLinksScheduledForDeletion->remove($this->piLinksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPiLink $piLink The ChildPiLink object to add.
     */
    protected function doAddPiLink(ChildPiLink $piLink)
    {
        $this->collPiLinks[]= $piLink;
        $piLink->setPerson($this);
    }

    /**
     * @param  ChildPiLink $piLink The ChildPiLink object to remove.
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function removePiLink(ChildPiLink $piLink)
    {
        if ($this->getPiLinks()->contains($piLink)) {
            $pos = $this->collPiLinks->search($piLink);
            $this->collPiLinks->remove($pos);
            if (null === $this->piLinksScheduledForDeletion) {
                $this->piLinksScheduledForDeletion = clone $this->collPiLinks;
                $this->piLinksScheduledForDeletion->clear();
            }
            $this->piLinksScheduledForDeletion[]= clone $piLink;
            $piLink->setPerson(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Person is new, it will return
     * an empty collection; or if this Person has previously
     * been saved, it will retrieve related PiLinks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Person.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPiLink[] List of ChildPiLink objects
     */
    public function getPiLinksJoinInstruction(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPiLinkQuery::create(null, $criteria);
        $query->joinWith('Instruction', $joinBehavior);

        return $this->getPiLinks($query, $con);
    }

    /**
     * Clears out the collPresentations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPresentations()
     */
    public function clearPresentations()
    {
        $this->collPresentations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPresentations collection loaded partially.
     */
    public function resetPartialPresentations($v = true)
    {
        $this->collPresentationsPartial = $v;
    }

    /**
     * Initializes the collPresentations collection.
     *
     * By default this just sets the collPresentations collection to an empty array (like clearcollPresentations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPresentations($overrideExisting = true)
    {
        if (null !== $this->collPresentations && !$overrideExisting) {
            return;
        }

        $collectionClassName = PresentationTableMap::getTableMap()->getCollectionClassName();

        $this->collPresentations = new $collectionClassName;
        $this->collPresentations->setModel('\BossEdu\Model\Presentation');
    }

    /**
     * Gets an array of ChildPresentation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerson is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPresentation[] List of ChildPresentation objects
     * @throws PropelException
     */
    public function getPresentations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPresentationsPartial && !$this->isNew();
        if (null === $this->collPresentations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPresentations) {
                // return empty collection
                $this->initPresentations();
            } else {
                $collPresentations = ChildPresentationQuery::create(null, $criteria)
                    ->filterByPerson($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPresentationsPartial && count($collPresentations)) {
                        $this->initPresentations(false);

                        foreach ($collPresentations as $obj) {
                            if (false == $this->collPresentations->contains($obj)) {
                                $this->collPresentations->append($obj);
                            }
                        }

                        $this->collPresentationsPartial = true;
                    }

                    return $collPresentations;
                }

                if ($partial && $this->collPresentations) {
                    foreach ($this->collPresentations as $obj) {
                        if ($obj->isNew()) {
                            $collPresentations[] = $obj;
                        }
                    }
                }

                $this->collPresentations = $collPresentations;
                $this->collPresentationsPartial = false;
            }
        }

        return $this->collPresentations;
    }

    /**
     * Sets a collection of ChildPresentation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $presentations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function setPresentations(Collection $presentations, ConnectionInterface $con = null)
    {
        /** @var ChildPresentation[] $presentationsToDelete */
        $presentationsToDelete = $this->getPresentations(new Criteria(), $con)->diff($presentations);

        
        $this->presentationsScheduledForDeletion = $presentationsToDelete;

        foreach ($presentationsToDelete as $presentationRemoved) {
            $presentationRemoved->setPerson(null);
        }

        $this->collPresentations = null;
        foreach ($presentations as $presentation) {
            $this->addPresentation($presentation);
        }

        $this->collPresentations = $presentations;
        $this->collPresentationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Presentation objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Presentation objects.
     * @throws PropelException
     */
    public function countPresentations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPresentationsPartial && !$this->isNew();
        if (null === $this->collPresentations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPresentations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPresentations());
            }

            $query = ChildPresentationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerson($this)
                ->count($con);
        }

        return count($this->collPresentations);
    }

    /**
     * Method called to associate a ChildPresentation object to this object
     * through the ChildPresentation foreign key attribute.
     *
     * @param  ChildPresentation $l ChildPresentation
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function addPresentation(ChildPresentation $l)
    {
        if ($this->collPresentations === null) {
            $this->initPresentations();
            $this->collPresentationsPartial = true;
        }

        if (!$this->collPresentations->contains($l)) {
            $this->doAddPresentation($l);

            if ($this->presentationsScheduledForDeletion and $this->presentationsScheduledForDeletion->contains($l)) {
                $this->presentationsScheduledForDeletion->remove($this->presentationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPresentation $presentation The ChildPresentation object to add.
     */
    protected function doAddPresentation(ChildPresentation $presentation)
    {
        $this->collPresentations[]= $presentation;
        $presentation->setPerson($this);
    }

    /**
     * @param  ChildPresentation $presentation The ChildPresentation object to remove.
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function removePresentation(ChildPresentation $presentation)
    {
        if ($this->getPresentations()->contains($presentation)) {
            $pos = $this->collPresentations->search($presentation);
            $this->collPresentations->remove($pos);
            if (null === $this->presentationsScheduledForDeletion) {
                $this->presentationsScheduledForDeletion = clone $this->collPresentations;
                $this->presentationsScheduledForDeletion->clear();
            }
            $this->presentationsScheduledForDeletion[]= clone $presentation;
            $presentation->setPerson(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Person is new, it will return
     * an empty collection; or if this Person has previously
     * been saved, it will retrieve related Presentations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Person.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPresentation[] List of ChildPresentation objects
     */
    public function getPresentationsJoinInstruction(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPresentationQuery::create(null, $criteria);
        $query->joinWith('Instruction', $joinBehavior);

        return $this->getPresentations($query, $con);
    }

    /**
     * Clears out the collDoubts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDoubts()
     */
    public function clearDoubts()
    {
        $this->collDoubts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDoubts collection loaded partially.
     */
    public function resetPartialDoubts($v = true)
    {
        $this->collDoubtsPartial = $v;
    }

    /**
     * Initializes the collDoubts collection.
     *
     * By default this just sets the collDoubts collection to an empty array (like clearcollDoubts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDoubts($overrideExisting = true)
    {
        if (null !== $this->collDoubts && !$overrideExisting) {
            return;
        }

        $collectionClassName = DoubtTableMap::getTableMap()->getCollectionClassName();

        $this->collDoubts = new $collectionClassName;
        $this->collDoubts->setModel('\BossEdu\Model\Doubt');
    }

    /**
     * Gets an array of ChildDoubt objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerson is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDoubt[] List of ChildDoubt objects
     * @throws PropelException
     */
    public function getDoubts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDoubtsPartial && !$this->isNew();
        if (null === $this->collDoubts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDoubts) {
                // return empty collection
                $this->initDoubts();
            } else {
                $collDoubts = ChildDoubtQuery::create(null, $criteria)
                    ->filterByPerson($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDoubtsPartial && count($collDoubts)) {
                        $this->initDoubts(false);

                        foreach ($collDoubts as $obj) {
                            if (false == $this->collDoubts->contains($obj)) {
                                $this->collDoubts->append($obj);
                            }
                        }

                        $this->collDoubtsPartial = true;
                    }

                    return $collDoubts;
                }

                if ($partial && $this->collDoubts) {
                    foreach ($this->collDoubts as $obj) {
                        if ($obj->isNew()) {
                            $collDoubts[] = $obj;
                        }
                    }
                }

                $this->collDoubts = $collDoubts;
                $this->collDoubtsPartial = false;
            }
        }

        return $this->collDoubts;
    }

    /**
     * Sets a collection of ChildDoubt objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $doubts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function setDoubts(Collection $doubts, ConnectionInterface $con = null)
    {
        /** @var ChildDoubt[] $doubtsToDelete */
        $doubtsToDelete = $this->getDoubts(new Criteria(), $con)->diff($doubts);

        
        $this->doubtsScheduledForDeletion = $doubtsToDelete;

        foreach ($doubtsToDelete as $doubtRemoved) {
            $doubtRemoved->setPerson(null);
        }

        $this->collDoubts = null;
        foreach ($doubts as $doubt) {
            $this->addDoubt($doubt);
        }

        $this->collDoubts = $doubts;
        $this->collDoubtsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Doubt objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Doubt objects.
     * @throws PropelException
     */
    public function countDoubts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDoubtsPartial && !$this->isNew();
        if (null === $this->collDoubts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDoubts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDoubts());
            }

            $query = ChildDoubtQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerson($this)
                ->count($con);
        }

        return count($this->collDoubts);
    }

    /**
     * Method called to associate a ChildDoubt object to this object
     * through the ChildDoubt foreign key attribute.
     *
     * @param  ChildDoubt $l ChildDoubt
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function addDoubt(ChildDoubt $l)
    {
        if ($this->collDoubts === null) {
            $this->initDoubts();
            $this->collDoubtsPartial = true;
        }

        if (!$this->collDoubts->contains($l)) {
            $this->doAddDoubt($l);

            if ($this->doubtsScheduledForDeletion and $this->doubtsScheduledForDeletion->contains($l)) {
                $this->doubtsScheduledForDeletion->remove($this->doubtsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDoubt $doubt The ChildDoubt object to add.
     */
    protected function doAddDoubt(ChildDoubt $doubt)
    {
        $this->collDoubts[]= $doubt;
        $doubt->setPerson($this);
    }

    /**
     * @param  ChildDoubt $doubt The ChildDoubt object to remove.
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function removeDoubt(ChildDoubt $doubt)
    {
        if ($this->getDoubts()->contains($doubt)) {
            $pos = $this->collDoubts->search($doubt);
            $this->collDoubts->remove($pos);
            if (null === $this->doubtsScheduledForDeletion) {
                $this->doubtsScheduledForDeletion = clone $this->collDoubts;
                $this->doubtsScheduledForDeletion->clear();
            }
            $this->doubtsScheduledForDeletion[]= clone $doubt;
            $doubt->setPerson(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Person is new, it will return
     * an empty collection; or if this Person has previously
     * been saved, it will retrieve related Doubts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Person.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDoubt[] List of ChildDoubt objects
     */
    public function getDoubtsJoinPresentation(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDoubtQuery::create(null, $criteria);
        $query->joinWith('Presentation', $joinBehavior);

        return $this->getDoubts($query, $con);
    }

    /**
     * Clears out the collPdLikes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPdLikes()
     */
    public function clearPdLikes()
    {
        $this->collPdLikes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPdLikes collection loaded partially.
     */
    public function resetPartialPdLikes($v = true)
    {
        $this->collPdLikesPartial = $v;
    }

    /**
     * Initializes the collPdLikes collection.
     *
     * By default this just sets the collPdLikes collection to an empty array (like clearcollPdLikes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPdLikes($overrideExisting = true)
    {
        if (null !== $this->collPdLikes && !$overrideExisting) {
            return;
        }

        $collectionClassName = PdLikeTableMap::getTableMap()->getCollectionClassName();

        $this->collPdLikes = new $collectionClassName;
        $this->collPdLikes->setModel('\BossEdu\Model\PdLike');
    }

    /**
     * Gets an array of ChildPdLike objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerson is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPdLike[] List of ChildPdLike objects
     * @throws PropelException
     */
    public function getPdLikes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPdLikesPartial && !$this->isNew();
        if (null === $this->collPdLikes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPdLikes) {
                // return empty collection
                $this->initPdLikes();
            } else {
                $collPdLikes = ChildPdLikeQuery::create(null, $criteria)
                    ->filterByPerson($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPdLikesPartial && count($collPdLikes)) {
                        $this->initPdLikes(false);

                        foreach ($collPdLikes as $obj) {
                            if (false == $this->collPdLikes->contains($obj)) {
                                $this->collPdLikes->append($obj);
                            }
                        }

                        $this->collPdLikesPartial = true;
                    }

                    return $collPdLikes;
                }

                if ($partial && $this->collPdLikes) {
                    foreach ($this->collPdLikes as $obj) {
                        if ($obj->isNew()) {
                            $collPdLikes[] = $obj;
                        }
                    }
                }

                $this->collPdLikes = $collPdLikes;
                $this->collPdLikesPartial = false;
            }
        }

        return $this->collPdLikes;
    }

    /**
     * Sets a collection of ChildPdLike objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pdLikes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function setPdLikes(Collection $pdLikes, ConnectionInterface $con = null)
    {
        /** @var ChildPdLike[] $pdLikesToDelete */
        $pdLikesToDelete = $this->getPdLikes(new Criteria(), $con)->diff($pdLikes);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->pdLikesScheduledForDeletion = clone $pdLikesToDelete;

        foreach ($pdLikesToDelete as $pdLikeRemoved) {
            $pdLikeRemoved->setPerson(null);
        }

        $this->collPdLikes = null;
        foreach ($pdLikes as $pdLike) {
            $this->addPdLike($pdLike);
        }

        $this->collPdLikes = $pdLikes;
        $this->collPdLikesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PdLike objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PdLike objects.
     * @throws PropelException
     */
    public function countPdLikes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPdLikesPartial && !$this->isNew();
        if (null === $this->collPdLikes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPdLikes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPdLikes());
            }

            $query = ChildPdLikeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerson($this)
                ->count($con);
        }

        return count($this->collPdLikes);
    }

    /**
     * Method called to associate a ChildPdLike object to this object
     * through the ChildPdLike foreign key attribute.
     *
     * @param  ChildPdLike $l ChildPdLike
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function addPdLike(ChildPdLike $l)
    {
        if ($this->collPdLikes === null) {
            $this->initPdLikes();
            $this->collPdLikesPartial = true;
        }

        if (!$this->collPdLikes->contains($l)) {
            $this->doAddPdLike($l);

            if ($this->pdLikesScheduledForDeletion and $this->pdLikesScheduledForDeletion->contains($l)) {
                $this->pdLikesScheduledForDeletion->remove($this->pdLikesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPdLike $pdLike The ChildPdLike object to add.
     */
    protected function doAddPdLike(ChildPdLike $pdLike)
    {
        $this->collPdLikes[]= $pdLike;
        $pdLike->setPerson($this);
    }

    /**
     * @param  ChildPdLike $pdLike The ChildPdLike object to remove.
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function removePdLike(ChildPdLike $pdLike)
    {
        if ($this->getPdLikes()->contains($pdLike)) {
            $pos = $this->collPdLikes->search($pdLike);
            $this->collPdLikes->remove($pos);
            if (null === $this->pdLikesScheduledForDeletion) {
                $this->pdLikesScheduledForDeletion = clone $this->collPdLikes;
                $this->pdLikesScheduledForDeletion->clear();
            }
            $this->pdLikesScheduledForDeletion[]= clone $pdLike;
            $pdLike->setPerson(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Person is new, it will return
     * an empty collection; or if this Person has previously
     * been saved, it will retrieve related PdLikes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Person.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPdLike[] List of ChildPdLike objects
     */
    public function getPdLikesJoinDoubt(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPdLikeQuery::create(null, $criteria);
        $query->joinWith('Doubt', $joinBehavior);

        return $this->getPdLikes($query, $con);
    }

    /**
     * Clears out the collContributions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContributions()
     */
    public function clearContributions()
    {
        $this->collContributions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collContributions collection loaded partially.
     */
    public function resetPartialContributions($v = true)
    {
        $this->collContributionsPartial = $v;
    }

    /**
     * Initializes the collContributions collection.
     *
     * By default this just sets the collContributions collection to an empty array (like clearcollContributions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContributions($overrideExisting = true)
    {
        if (null !== $this->collContributions && !$overrideExisting) {
            return;
        }

        $collectionClassName = ContributionTableMap::getTableMap()->getCollectionClassName();

        $this->collContributions = new $collectionClassName;
        $this->collContributions->setModel('\BossEdu\Model\Contribution');
    }

    /**
     * Gets an array of ChildContribution objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerson is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildContribution[] List of ChildContribution objects
     * @throws PropelException
     */
    public function getContributions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collContributionsPartial && !$this->isNew();
        if (null === $this->collContributions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContributions) {
                // return empty collection
                $this->initContributions();
            } else {
                $collContributions = ChildContributionQuery::create(null, $criteria)
                    ->filterByPerson($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContributionsPartial && count($collContributions)) {
                        $this->initContributions(false);

                        foreach ($collContributions as $obj) {
                            if (false == $this->collContributions->contains($obj)) {
                                $this->collContributions->append($obj);
                            }
                        }

                        $this->collContributionsPartial = true;
                    }

                    return $collContributions;
                }

                if ($partial && $this->collContributions) {
                    foreach ($this->collContributions as $obj) {
                        if ($obj->isNew()) {
                            $collContributions[] = $obj;
                        }
                    }
                }

                $this->collContributions = $collContributions;
                $this->collContributionsPartial = false;
            }
        }

        return $this->collContributions;
    }

    /**
     * Sets a collection of ChildContribution objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $contributions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function setContributions(Collection $contributions, ConnectionInterface $con = null)
    {
        /** @var ChildContribution[] $contributionsToDelete */
        $contributionsToDelete = $this->getContributions(new Criteria(), $con)->diff($contributions);

        
        $this->contributionsScheduledForDeletion = $contributionsToDelete;

        foreach ($contributionsToDelete as $contributionRemoved) {
            $contributionRemoved->setPerson(null);
        }

        $this->collContributions = null;
        foreach ($contributions as $contribution) {
            $this->addContribution($contribution);
        }

        $this->collContributions = $contributions;
        $this->collContributionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Contribution objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Contribution objects.
     * @throws PropelException
     */
    public function countContributions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collContributionsPartial && !$this->isNew();
        if (null === $this->collContributions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContributions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContributions());
            }

            $query = ChildContributionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerson($this)
                ->count($con);
        }

        return count($this->collContributions);
    }

    /**
     * Method called to associate a ChildContribution object to this object
     * through the ChildContribution foreign key attribute.
     *
     * @param  ChildContribution $l ChildContribution
     * @return $this|\BossEdu\Model\Person The current object (for fluent API support)
     */
    public function addContribution(ChildContribution $l)
    {
        if ($this->collContributions === null) {
            $this->initContributions();
            $this->collContributionsPartial = true;
        }

        if (!$this->collContributions->contains($l)) {
            $this->doAddContribution($l);

            if ($this->contributionsScheduledForDeletion and $this->contributionsScheduledForDeletion->contains($l)) {
                $this->contributionsScheduledForDeletion->remove($this->contributionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildContribution $contribution The ChildContribution object to add.
     */
    protected function doAddContribution(ChildContribution $contribution)
    {
        $this->collContributions[]= $contribution;
        $contribution->setPerson($this);
    }

    /**
     * @param  ChildContribution $contribution The ChildContribution object to remove.
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function removeContribution(ChildContribution $contribution)
    {
        if ($this->getContributions()->contains($contribution)) {
            $pos = $this->collContributions->search($contribution);
            $this->collContributions->remove($pos);
            if (null === $this->contributionsScheduledForDeletion) {
                $this->contributionsScheduledForDeletion = clone $this->collContributions;
                $this->contributionsScheduledForDeletion->clear();
            }
            $this->contributionsScheduledForDeletion[]= clone $contribution;
            $contribution->setPerson(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Person is new, it will return
     * an empty collection; or if this Person has previously
     * been saved, it will retrieve related Contributions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Person.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildContribution[] List of ChildContribution objects
     */
    public function getContributionsJoinDoubt(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContributionQuery::create(null, $criteria);
        $query->joinWith('Doubt', $joinBehavior);

        return $this->getContributions($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSomeone) {
            $this->aSomeone->removePerson($this);
        }
        $this->id = null;
        $this->document_name = null;
        $this->document_number = null;
        $this->name = null;
        $this->birth_date = null;
        $this->telephone = null;
        $this->country = null;
        $this->state = null;
        $this->town = null;
        $this->district = null;
        $this->street = null;
        $this->number = null;
        $this->email = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPiLinks) {
                foreach ($this->collPiLinks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPresentations) {
                foreach ($this->collPresentations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDoubts) {
                foreach ($this->collDoubts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPdLikes) {
                foreach ($this->collPdLikes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContributions) {
                foreach ($this->collContributions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPiLinks = null;
        $this->collPresentations = null;
        $this->collDoubts = null;
        $this->collPdLikes = null;
        $this->collContributions = null;
        $this->aSomeone = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PersonTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
