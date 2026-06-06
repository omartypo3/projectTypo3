<?php
namespace DslFactory\DslJobs\Domain\Model;

/***
 *
 * This file is part of the "Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * Jobs
 */
class Jobs extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected $crdate = null;

    /**
     * @var boolean
     */
    protected $hidden = null;

    /**
     * @var \DateTime
     */
    protected $starttime = null;

    /**
     * @var \DateTime
     */
    protected $endtime = null;

    /**
     * jobid
     *
     * @var string
     */
    protected $jobid = '';

    /**
     * jobtitle
     *
     * @var string
     */
    protected $jobtitle = '';

    /**
     * descriptionIntroHeading
     *
     * @var string
     */
    protected $descriptionIntroHeading = '';

    /**
     * descriptionIntroBody
     *
     * @var string
     */
    protected $descriptionIntroBody = '';

    /**
     * descriptionTasksHeading
     *
     * @var string
     */
    protected $descriptionTasksHeading = '';

    /**
     * descriptionTasksBody
     *
     * @var string
     */
    protected $descriptionTasksBody = '';

    /**
     * descriptionQualificationsHeading
     *
     * @var string
     */
    protected $descriptionQualificationsHeading = '';

    /**
     * descriptionQualificationsBody
     *
     * @var string
     */
    protected $descriptionQualificationsBody = '';

    /**
     * descriptionBenefitsHeading
     *
     * @var string
     */
    protected $descriptionBenefitsHeading = '';

    /**
     * descriptionBenefitsBody
     *
     * @var string
     */
    protected $descriptionBenefitsBody = '';

    /**
     * descriptionOutroBody
     *
     * @var string
     */
    protected $descriptionOutroBody = '';

    /**
     * applylinkLabel
     *
     * @var string
     */
    protected $applylinkLabel = '';

    /**
     * applylinkUrl
     *
     * @var string
     */
    protected $applylinkUrl = '';

    /**
     * jobSite
     *
     * @var \DslFactory\DslJobs\Domain\Model\JobSite
     */
    protected $jobSite = null;

    /**
     * jobLevel
     *
     * @var \DslFactory\DslJobs\Domain\Model\JobLevel
     */
    protected $jobLevel = null;

    /**
     * sysLanguageUid
     *
     * @var int
     */
    protected $sysLanguageUid;


    /**
     * Returns the jobid
     *
     * @return string $jobid
     */
    public function getJobid()
    {
        return $this->jobid;
    }

    /**
     * Sets the jobid
     *
     * @param string $jobid
     * @return void
     */
    public function setJobid($jobid)
    {
        $this->jobid = $jobid;
    }

    /**
     * Returns the jobtitle
     *
     * @return string $jobtitle
     */
    public function getJobtitle()
    {
        return $this->jobtitle;
    }

    /**
     * Sets the jobtitle
     *
     * @param string $jobtitle
     * @return void
     */
    public function setJobtitle($jobtitle)
    {
        $this->jobtitle = $jobtitle;
    }

    /**
     * Returns the descriptionIntroHeading
     *
     * @return string $descriptionIntroHeading
     */
    public function getDescriptionIntroHeading()
    {
        return $this->descriptionIntroHeading;
    }

    /**
     * Sets the descriptionIntroHeading
     *
     * @param string $descriptionIntroHeading
     * @return void
     */
    public function setDescriptionIntroHeading($descriptionIntroHeading)
    {
        $this->descriptionIntroHeading = $descriptionIntroHeading;
    }

    /**
     * Returns the descriptionIntroBody
     *
     * @return string $descriptionIntroBody
     */
    public function getDescriptionIntroBody()
    {
        return $this->descriptionIntroBody;
    }

    /**
     * Sets the descriptionIntroBody
     *
     * @param string $descriptionIntroBody
     * @return void
     */
    public function setDescriptionIntroBody($descriptionIntroBody)
    {
        $this->descriptionIntroBody = $descriptionIntroBody;
    }

    /**
     * Returns the descriptionTasksHeading
     *
     * @return string $descriptionTasksHeading
     */
    public function getDescriptionTasksHeading()
    {
        return $this->descriptionTasksHeading;
    }

    /**
     * Sets the descriptionTasksHeading
     *
     * @param string $descriptionTasksHeading
     * @return void
     */
    public function setDescriptionTasksHeading($descriptionTasksHeading)
    {
        $this->descriptionTasksHeading = $descriptionTasksHeading;
    }

    /**
     * Returns the descriptionTasksBody
     *
     * @return string $descriptionTasksBody
     */
    public function getDescriptionTasksBody()
    {
        return $this->descriptionTasksBody;
    }

    /**
     * Sets the descriptionTasksBody
     *
     * @param string $descriptionTasksBody
     * @return void
     */
    public function setDescriptionTasksBody($descriptionTasksBody)
    {
        $this->descriptionTasksBody = $descriptionTasksBody;
    }

    /**
     * Returns the descriptionQualificationsHeading
     *
     * @return string $descriptionQualificationsHeading
     */
    public function getDescriptionQualificationsHeading()
    {
        return $this->descriptionQualificationsHeading;
    }

    /**
     * Sets the descriptionQualificationsHeading
     *
     * @param string $descriptionQualificationsHeading
     * @return void
     */
    public function setDescriptionQualificationsHeading($descriptionQualificationsHeading)
    {
        $this->descriptionQualificationsHeading = $descriptionQualificationsHeading;
    }

    /**
     * Returns the descriptionQualificationsBody
     *
     * @return string $descriptionQualificationsBody
     */
    public function getDescriptionQualificationsBody()
    {
        return $this->descriptionQualificationsBody;
    }

    /**
     * Sets the descriptionQualificationsBody
     *
     * @param string $descriptionQualificationsBody
     * @return void
     */
    public function setDescriptionQualificationsBody($descriptionQualificationsBody)
    {
        $this->descriptionQualificationsBody = $descriptionQualificationsBody;
    }

    /**
     * Returns the descriptionBenefitsHeading
     *
     * @return string $descriptionBenefitsHeading
     */
    public function getDescriptionBenefitsHeading()
    {
        return $this->descriptionBenefitsHeading;
    }

    /**
     * Sets the descriptionBenefitsHeading
     *
     * @param string $descriptionBenefitsHeading
     * @return void
     */
    public function setDescriptionBenefitsHeading($descriptionBenefitsHeading)
    {
        $this->descriptionBenefitsHeading = $descriptionBenefitsHeading;
    }

    /**
     * Returns the descriptionBenefitsBody
     *
     * @return string $descriptionBenefitsBody
     */
    public function getDescriptionBenefitsBody()
    {
        return $this->descriptionBenefitsBody;
    }

    /**
     * Sets the descriptionBenefitsBody
     *
     * @param string $descriptionBenefitsBody
     * @return void
     */
    public function setDescriptionBenefitsBody($descriptionBenefitsBody)
    {
        $this->descriptionBenefitsBody = $descriptionBenefitsBody;
    }

    /**
     * Returns the descriptionOutroBody
     *
     * @return string $descriptionOutroBody
     */
    public function getDescriptionOutroBody()
    {
        return $this->descriptionOutroBody;
    }

    /**
     * Sets the descriptionOutroBody
     *
     * @param string $descriptionOutroBody
     * @return void
     */
    public function setDescriptionOutroBody($descriptionOutroBody)
    {
        $this->descriptionOutroBody = $descriptionOutroBody;
    }

    /**
     * Returns the jobSite
     *
     * @return \DslFactory\DslJobs\Domain\Model\JobSite $jobSite
     */
    public function getJobSite()
    {
        return $this->jobSite;
    }

    /**
     * Sets the jobSite
     *
     * @param \DslFactory\DslJobs\Domain\Model\JobSite $jobSite
     * @return void
     */
    public function setJobSite(\DslFactory\DslJobs\Domain\Model\JobSite $jobSite)
    {
        $this->jobSite = $jobSite;
    }

    /**
     * Returns the jobLevel
     *
     * @return \DslFactory\DslJobs\Domain\Model\JobLevel $jobLevel
     */
    public function getJobLevel()
    {
        return $this->jobLevel;
    }

    /**
     * Sets the jobLevel
     *
     * @param \DslFactory\DslJobs\Domain\Model\JobLevel $jobLevel
     * @return void
     */
    public function setJobLevel(\DslFactory\DslJobs\Domain\Model\JobLevel $jobLevel)
    {
        $this->jobLevel = $jobLevel;
    }

    /**
     * Returns the crdate
     *
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @return boolean $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @return boolean $hidden
     */
    public function isHidden()
    {
        return $this->getHidden();
    }

    /**
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Get start time
     *
     * @return \DateTime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set start time
     *
     * @param int $starttime start time
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    }

    /**
     * Get endtime
     *
     * @return \DateTime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set end time
     *
     * @param int $endtime end time
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }

    /**
     * Returns the applylinkLabel
     *
     * @return string $applylinkLabel
     */
    public function getApplylinkLabel()
    {
        return $this->applylinkLabel;
    }

    /**
     * Sets the applylinkLabel
     *
     * @param string $applylinkLabel
     * @return void
     */
    public function setApplylinkLabel($applylinkLabel)
    {
        $this->applylinkLabel = $applylinkLabel;
    }

    /**
     * Returns the applylinkUrl
     *
     * @return string $applylinkUrl
     */
    public function getApplylinkUrl()
    {
        return $this->applylinkUrl;
    }

    /**
     * Sets the applylinkUrl
     *
     * @param string $applylinkUrl
     * @return void
     */
    public function setApplylinkUrl($applylinkUrl)
    {
        $this->applylinkUrl = $applylinkUrl;
    }

    /**
     * @return int
     */
    public function getSysLanguageUid()
    {
        return $this->sysLanguageUid;
    }

    /**
     * @param int $sysLanguageUid
     */
    public function setSysLanguageUid($sysLanguageUid)
    {
        $this->sysLanguageUid = $sysLanguageUid;
    }
}
