<?php
namespace DLD\Dld\Domain\Model;


class Page extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * page visibility
     *
     * @var \integer
     */
    protected $hidden;
    /**
     * @return $hidden
     */
    public function getHidden() {
        return $this->hidden;
    }
    /**
     * @param  bool $hidden
     */
    public function setHidden($hidden) {
        $this->hidden = $hidden;
    }

}