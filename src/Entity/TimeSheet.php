<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeSheetRepository")
 */
class TimeSheet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TimeSheetEntry", mappedBy="timeSheet")
     */
    private $timeSheetEntries;

    public function __construct()
    {
        $this->timeSheetEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|TimeSheetEntry[]
     */
    public function getTimeSheetEntries(): Collection
    {
        return $this->timeSheetEntries;
    }

    public function addTimeSheetEntry(TimeSheetEntry $timeSheetEntry): self
    {
        if (!$this->timeSheetEntries->contains($timeSheetEntry)) {
            $this->timeSheetEntries[] = $timeSheetEntry;
            $timeSheetEntry->setTimeSheet($this);
        }

        return $this;
    }

    public function removeTimeSheetEntry(TimeSheetEntry $timeSheetEntry): self
    {
        if ($this->timeSheetEntries->contains($timeSheetEntry)) {
            $this->timeSheetEntries->removeElement($timeSheetEntry);
            // set the owning side to null (unless already changed)
            if ($timeSheetEntry->getTimeSheet() === $this) {
                $timeSheetEntry->setTimeSheet(null);
            }
        }

        return $this;
    }

    public function __toString(): String 
    {
        return (string) $this->getId();
    }
}
