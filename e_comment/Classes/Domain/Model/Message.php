<?php
namespace Emagineurs\EComment\Domain\Model;

use Emagineurs\EComment\Utility\FileUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use In2code\Femanager\Domain\Model\User;
class Message extends AbstractEntity
{
	/**
	 * bodytext
	 *
	 * @var string
	 */
	protected $bodytext;

    /**
     * title
     *
     * @var string
     */
    protected $title;

	/**
	 * feuser
	 *
	 * @var \In2code\Femanager\Domain\Model\User
	 */
	protected $feuser;

    /**
     * name
     *
     * @var string
     */
    protected $name;

    /**
     * firstname
     *
     * @var string
     */
    protected $firstname;

    /**
     * email
     *
     * @var string
     */
    protected $email;

    /**
     * A collection of files.
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $file;


     /**
     * Comment constructor
     */
	#[Extbase\ORM\Cascade(['value' => 'remove'])]
	/**
	 * children
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EComment\Domain\Model\Message>
	 */
	protected $children;
	
	/**
	 * parent
	 *
	 * @var \Emagineurs\EComment\Domain\Model\Message
	 */
	protected $parent;

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories;

    /**
     * Category
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\Category
     */
    protected $category;

    /**
     * validationtoken
     *
     * @var string
     */
    protected $validationtoken;

    /**
     * paramfilter
     *
     * @var string
     */
    protected $paramfilter;

    /**
     * paramvalue
     *
     * @var string
     */
    protected $paramvalue;

    /**
     * hidden
     *
     * @var boolean
     */
    protected $hidden;

    /**
     * crdate
     *
     * @var integer
     */
    protected $crdate;

    /**
     * Comment constructor
     */
    function __construct() {
        $this->crdate = time();
        $this->file = new ObjectStorage();
    }

    // /**
    //  * Called again with initialize object, as fetching an entity from the DB does not use the constructor
    //  */
    // public function initializeObject(): void
    // {
    //     $this->file = $this->file ?? new ObjectStorage();
    // }
    
  

    /**
     * @return ObjectStorage|FileReference[]
     */
    public function getFile(): ObjectStorage
    {
        return $this->file;
    }

   public function setFile(ObjectStorage $file): void
    {
        $this->file = $file;
    }





    /**
     * @return string
     */
    public function getBodytext()
    {
        return $this->bodytext;
    }

    /**
     * @param string $bodytext
     */
    public function setBodytext($bodytext)
    {
        $this->bodytext = $bodytext;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return User
     */
    public function getFeuser()
    {
        return $this->feuser;
    }

    /**
     * @param User $feuser
     */
    public function setFeuser($feuser)
    {
        $this->feuser = $feuser;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    // /**
    //  * Returns nothing > created because probably called if property mediainstancier used in a form
    //  *
    //  * @return void
    //  */
    // public function getFile()
    // {
    //     //empty
    // }

    // /**
    //  * Sets the media from $_FILES
    //  *
    //  * @param array $files
    //  * @return void
    //  */
    // public function setFile($files) {
    //     $this->setFileReferenceByFile($files, $this, 'file');
    // }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EComment\Domain\Model\Message>
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EComment\Domain\Model\Message> $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return \Emagineurs\EComment\Domain\Model\Message
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param \Emagineurs\EComment\Domain\Model\Message $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\Category
     */
    public function getCategory()
    {
        if(!empty($this->categories) AND $this->categories->count() > 0) {
            return $this->categories->getArray()[0];
        } else {
            return null;
        }
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categories
     */
    public function setCategory($category)
    {
        $this->category = $category;
        if(empty($this->categories)) {
            $this->categories = GeneralUtility::makeInstance(ObjectStorage::class);
        }
        $this->categories->attach($category);
    }

    /**
     * @return string
     */
    public function getValidationtoken()
    {
        return $this->validationtoken;
    }

    /**
     * @param string $validationtoken
     */
    public function setValidationtoken($validationtoken)
    {
        $this->validationtoken = $validationtoken;
    }

    /**
     * @return string
     */
    public function getParamfilter()
    {
        return $this->paramfilter;
    }

    /**
     * @param string $paramfilter
     */
    public function setParamfilter($paramfilter)
    {
        $this->paramfilter = $paramfilter;
    }

    /**
     * @return string
     */
    public function getParamvalue()
    {
        return $this->paramvalue;
    }

    /**
     * @param string $paramvalue
     */
    public function setParamvalue($paramvalue)
    {
        $this->paramvalue = $paramvalue;
    }

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return integer
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param integer $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    // /**
    //  * Sets the file from $_FILES
    //  *
    //  * @param array $currentFile
    //  * @param mixed $object
    //  * @return void
    //  */
    // public function setFileReferenceByFile($files, &$object, $field) {
    //     if(is_array($files)){
    //         $object->$field = !empty($object->$field) ? $object->$field : GeneralUtility::makeInstance(ObjectStorage::class);

    //         foreach($files as $currentFile) {
    //             debug($currentFile);
    //             if (!empty($currentFile->getClientFilename())) {
    //                 $file = FileUtility::generateFile($currentFile);

    //                 /** @var Filereference $fileRef */
    //                 $fileRef = GeneralUtility::makeInstance(Filereference::class);
    //                 $fileRef->setName($currentFile->getClientFilename());

    //                 if (!empty($currentFile['additional']) AND is_array($currentFile['additional'])) {
    //                     foreach ($currentFile['additional'] as $fileProperty => $propertyValue) {
    //                         if ($fileProperty != 'identifier') {
    //                             $setter = 'set' . ucFirst($fileProperty);
    //                             $fileRef->$setter($propertyValue);
    //                         }
    //                     }
    //                 }

    //                 $originalResource = FileUtility::createFileReference($file);
    //                 $fileRef->setOriginalResource($originalResource);

    //                 //$fileRef->setTableLocal('sys_file');
    //                 $fileRef->setShowinpreview(TRUE);

    //                 $object->$field->attach($fileRef);
    //             }
    //         }
    //     }
    // }
}