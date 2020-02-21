<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JourneeRepository")
 */
class Journee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $saison;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $journee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEquipeHome;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEquipeAway;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreHome;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreAway;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BPHome;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $BPAway;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $BDHome;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $BDAway;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Arbitre", inversedBy="journees")
     * @ORM\JoinColumn(nullable=true)
     */
    private $idArbitreCentral;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $jour;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $heure;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AssoJoueurJournee", mappedBy="journee")
     */
    private $assoJoueurJournees;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StatsMatch", mappedBy="journee")
     */
    private $statsMatches;

    public function __construct()
    {
        $this->assoJoueurJournees = new ArrayCollection();
        $this->statsMatches = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSaison()
    {
        return $this->saison;
    }

    public function setSaison(string $saison): self
    {
        $this->saison = $saison;

        return $this;
    }

    public function getJournee()
    {
        return $this->journee;
    }

    public function setJournee(string $journee)
    {
        $this->journee = $journee;

        return $this;
    }

    public function getIdEquipeHome()
    {
        return $this->idEquipeHome;
    }

    public function setIdEquipeHome(Equipe $idEquipeHome)
    {
        $this->idEquipeHome = $idEquipeHome;

        return $this;
    }

    public function getIdEquipeAway()
    {
        return $this->idEquipeAway;
    }

    public function setIdEquipeAway(Equipe $idEquipeAway): self
    {
        $this->idEquipeAway = $idEquipeAway;

        return $this;
    }

    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    public function setScoreHome(int $scoreHome): self
    {
        $this->scoreHome = $scoreHome;

        return $this;
    }

    public function getScoreAway()
    {
        return $this->scoreAway;
    }

    public function setScoreAway(int $scoreAway): self
    {
        $this->scoreAway = $scoreAway;

        return $this;
    }

    public function getBPHome()
    {
        return $this->BPHome;
    }

    public function setBPHome(string $BPHome): self
    {
        $this->BPHome = $BPHome;

        return $this;
    }

    public function getBPAway()
    {
        return $this->BPAway;
    }

    public function setBPAway(string $BPAway): self
    {
        $this->BPAway = $BPAway;

        return $this;
    }

    public function getBDHome()
    {
        return $this->BDHome;
    }

    public function setBDHome(string $BDHome): self
    {
        $this->BDHome = $BDHome;

        return $this;
    }

    public function getBDAway()
    {
        return $this->BDAway;
    }

    public function setBDAway(string $BDAway): self
    {
        $this->BDAway = $BDAway;

        return $this;
    }

    public function getIdArbitreCentral()
    {
        return $this->idArbitreCentral;
    }

    public function setIdArbitreCentral(Arbitre $idArbitreCentral): self
    {
        $this->idArbitreCentral = $idArbitreCentral;

        return $this;
    }

    public function getJour()
    {
        return $this->jour;
        //return date('d/m/Y',strtotime($this->jour));
    }

    public function setJour(?string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeure()
    {
        return $this->heure;
    }

    public function setHeure(string $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getLieu()
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection|AssoJoueurJournee[]
     */
    public function getAssoJoueurJournees(): Collection
    {
        return $this->assoJoueurJournees;
    }

    public function addAssoJoueurJournee(AssoJoueurJournee $assoJoueurJournee): self
    {
        if (!$this->assoJoueurJournees->contains($assoJoueurJournee)) {
            $this->assoJoueurJournees[] = $assoJoueurJournee;
            $assoJoueurJournee->setJournee($this);
        }

        return $this;
    }

    public function removeAssoJoueurJournee(AssoJoueurJournee $assoJoueurJournee): self
    {
        if ($this->assoJoueurJournees->contains($assoJoueurJournee)) {
            $this->assoJoueurJournees->removeElement($assoJoueurJournee);
            // set the owning side to null (unless already changed)
            if ($assoJoueurJournee->getJournee() === $this) {
                $assoJoueurJournee->setJournee(null);
            }
        }

        return $this;
    }
    
    public function getInfoJournee(){
        return sprintf('%s vs %s saison %s',$this->getIdEquipeHome()->getNom(),$this->getIdEquipeAway()->getNom(), $this->getSaison());
    }

    /**
     * @return Collection|StatsMatch[]
     */
    public function getStatsMatches(): Collection
    {
        return $this->statsMatches;
    }

    public function addStatsMatch(StatsMatch $statsMatch): self
    {
        if (!$this->statsMatches->contains($statsMatch)) {
            $this->statsMatches[] = $statsMatch;
            $statsMatch->setJournee($this);
        }

        return $this;
    }

    public function removeStatsMatch(StatsMatch $statsMatch): self
    {
        if ($this->statsMatches->contains($statsMatch)) {
            $this->statsMatches->removeElement($statsMatch);
            // set the owning side to null (unless already changed)
            if ($statsMatch->getJournee() === $this) {
                $statsMatch->setJournee(null);
            }
        }

        return $this;
    }
}
