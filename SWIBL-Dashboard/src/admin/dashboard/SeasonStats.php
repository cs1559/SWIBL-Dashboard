<?php
namespace swibl\admin\dashboard;

class SeasonStats {
    
    var $seasonid;
    var $season;
    var $dataAsOf;
    var $totalTeams;
    var $totalDivisions;
    var $totalGamesScheduled;
    var $totalGamesPlayed;
    var $averageRunDifferential;
    var $averageRosterSize;
    /**
     * @return float $averageRosterSize
     */
    public function getAverageRosterSize()
    {
        return $this->averageRosterSize;
    }

    /**
     * @param float $averageRosterSize
     */
    public function setAverageRosterSize($averageRosterSize)
    {
        $this->averageRosterSize = $averageRosterSize;
    }

    /**
     * @return int $seasonid
     */
    public function getSeasonid()
    {
        return $this->seasonid;
    }

    /**
     * @return int $season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @return string $dataAsOf
     */
    public function getDataAsOf()
    {
        return $this->dataAsOf;
    }

    /**
     * @return int $totalTeams
     */
    public function getTotalTeams()
    {
        return $this->totalTeams;
    }

    /**
     * @return int $totalDivisions
     */
    public function getTotalDivisions()
    {
        return $this->totalDivisions;
    }

    /**
     * @return int $totalGamesScheduled
     */
    public function getTotalGamesScheduled()
    {
        return $this->totalGamesScheduled;
    }

    /**
     * @return int $totalGamesPlayed
     */
    public function getTotalGamesPlayed()
    {
        return $this->totalGamesPlayed;
    }

    /**
     * @return float $averageRunDifferential
     */
    public function getAverageRunDifferential()
    {
        return $this->averageRunDifferential;
    }

    /**
     * @param int $seasonid
     */
    public function setSeasonid($seasonid)
    {
        $this->seasonid = $seasonid;
    }

    /**
     * @param string $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }

    /**
     * @param string $dataAsOf
     */
    public function setDataAsOf($dataAsOf)
    {
        $this->dataAsOf = $dataAsOf;
    }

    /**
     * @param int $totalTeams
     */
    public function setTotalTeams($totalTeams)
    {
        $this->totalTeams = $totalTeams;
    }

    /**
     * @param int $totalDivisions
     */
    public function setTotalDivisions($totalDivisions)
    {
        $this->totalDivisions = $totalDivisions;
    }

    /**
     * @param int $totalGamesScheduled
     */
    public function setTotalGamesScheduled($totalGamesScheduled)
    {
        $this->totalGamesScheduled = $totalGamesScheduled;
    }

    /**
     * @param int $totalGamesPlayed
     */
    public function setTotalGamesPlayed($totalGamesPlayed)
    {
        $this->totalGamesPlayed = $totalGamesPlayed;
    }

    /**
     * @param float $averageRunDifferential
     */
    public function setAverageRunDifferential($averageRunDifferential)
    {
        $this->averageRunDifferential = $averageRunDifferential;
    }

    
    
}