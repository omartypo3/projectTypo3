<?php
declare(strict_types=1);

namespace Emagineurs\ENews\Event;

use Emagineurs\ENews\Domain\Model\Enews;


final class BeforeGenerateMailContent
{
    private  $template;
    private array $assigns;

    public function __construct($template, array $assigns)
    {
        $this->template = $template;
        $this->assigns = $assigns;
    }



    /**
     * Get the value of template
     */ 
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set the value of template
     *
     * @return  self
     */ 
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get the value of assigns
     *
     * @return array
     */
    public function getAssigns(): array
    {
        return $this->assigns;
    }

    /**
     * Set the value of assigns
     *
     * @param array $assigns
     *
     * @return self
     */
    public function setAssigns(array $assigns): self
    {
        $this->assigns = $assigns;

        return $this;
    }
}

