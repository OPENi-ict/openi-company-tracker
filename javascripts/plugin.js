$(document).ready(function() {
  setInterval(function() {
    var $dataTableRoot = $('.dataTable[data-report="OpeniCompanyTracker.trackByCompany"]');
    var dataTableInstance = $dataTableRoot.data('uiControlObject');
    dataTableInstance.resetAllFilters();
    dataTableInstance.reloadAjaxDataTable();
  }, 10 * 1000);
});