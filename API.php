<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\OpeniCompanyTracker;

use Piwik\DataTable;
use Piwik\DataTable\Row;

/**
 * API for plugin OpeniLocationTracker
 *
 * @method static \Piwik\Plugins\OpeniLocationTracker\API getInstance()
 */
class API extends \Piwik\Plugin\API
{

    /**
     * Another example method that returns a data table.
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function trackByCompany($idSite, $period, $date, $segment = false)
    {
        $data = \Piwik\Plugins\Live\API::getInstance()->getLastVisitsDetails(
          $idSite,
          $period,
          $date,
          $segment,
          $numLastVisitorsToFetch = 100,
          $minTimestamp = false,
          $flat = false,
          $doNotFetchActions = true
        );
        $data->applyQueuedFilters();


        $result = $data->getEmptyClone($keepFilters = false);

        foreach ($data->getRows() as $visitRow) {

            $companyName = $visitRow->getColumn('userId');
            $companyRow = $result->getRowFromLabel($companyName);

          if ($companyRow === false) {
            $result->addRowFromSimpleArray(array(
              'label' => $companyName,
              'nb_visits' => 1
            ));
          } else {
            $counter = $companyRow->getColumn('nb_visits');
            $companyRow->setColumn('nb_visits', $counter + 1);
          }
        }

        return $result;
    }
}
