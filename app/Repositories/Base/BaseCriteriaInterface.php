<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/13/2016
 * Time: 12:26 PM
 */

namespace App\Repositories\Base;

/**
 * Interface CriteriaInterface
 * @package App\Repositories
 */
interface BaseCriteriaInterface {
    /**
     * Push Criteria for filter the query
     *
     * @param $criteria
     *
     * @return $this
     */
    public function pushCriteria($criteria);

    /**
     * Pop Criteria
     *
     * @param $criteria
     *
     * @return $this
     */
    public function popCriteria($criteria);

    /**
     * Get Collection of Criteria
     *
     * @return Collection
     */
    public function getCriteria();

    /**
     * Find data by Criteria
     *
     * @param CriteriaInterface $criteria
     *
     * @return mixed
     */
    public function getByCriteria(CriteriaInterface $criteria);

    /**
     * Skip Criteria
     *
     * @param bool $status
     *
     * @return $this
     */
    public function skipCriteria($status = true);

    /**
     * Reset all Criterias
     *
     * @return $this
     */
    public function resetCriteria();
}