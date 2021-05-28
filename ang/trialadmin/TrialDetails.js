(function(angular, $, _) {
console.error(this);

  angular.module('trialadmin').config(function($routeProvider) {
      $routeProvider.when('/trialadmin/trialdetails', {
        controller: 'TrialadminTrialDetails',
        controllerAs: '$ctrl',
        templateUrl: '~/trialadmin/TrialDetails.html',

        // If you need to look up data when opening the page, list it out
        // under "resolve".
        
        resolve: {
          myEvent: function(crmApi) {
            return crmApi('TrialAdmin', 'getsingle', {
              'event_id': CRM.trialEvent.event,
              return: [ ]
            })
          }
        }
      });
    } 
  );

  // The controller uses *injection*. This default injects a few things:
  //   $scope -- This is the set of variables shared between JS and HTML.
  //   crmApi, crmStatus, crmUiHelp -- These are services provided by civicrm-core.
  //   myContact -- The current contact, defined above in config().
  angular.module('trialadmin').controller('TrialadminTrialDetails', function($scope, crmApi, crmStatus, crmUiHelp, myEvent) {
    // The ts() and hs() functions help load strings for this module.
    var ts = $scope.ts = CRM.ts('ca.sdda.trialadmin');
    var hs = $scope.hs = crmUiHelp({file: 'CRM/trialadmin/TrialDetails'}); // See: templates/CRM/trialadmin/EditCtrl.hlp
    // Local variable for this controller (needed when inside a callback fn where `this` is not available).
    var ctrl = this;

    // We have myContact available in JS. We also want to reference it in HTML.
    this.myEvent = myEvent;

    this.save = function() {
      return crmStatus(
        // Status messages. For defaults, just use "{}"
        {start: ts('Saving...'), success: ts('Saved')},
        // The save action. Note that crmApi() returns a promise.
     
      );
    };
  });
  

})(angular, CRM.$, CRM._);
