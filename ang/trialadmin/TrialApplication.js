(function(angular, $, _) {

  angular.module('trialadmin').config(function($routeProvider) {
      $routeProvider.when('/trialapplication', {
        controller: 'TrialadminTrialApplication',
        controllerAs: '$ctrl',
        templateUrl: '~/trialadmin/TrialApplication.html',

        // If you need to look up data when opening the page, list it out
        // under "resolve".
        resolve: {
          myContact: function(crmApi) {
            return crmApi('Contact', 'getsingle', {
              id: 'user_contact_id',
              return: ['first_name', 'last_name','contact_id']
            });
          },
          myStatus: function(crmApi) {
            return crmApi('Membership', 'get', {
              id: 'user_contact_id',
              return: ['status_id',]
            });
          },
        }
      });
    }
  );

  // The controller uses *injection*. This default injects a few things:
  //   $scope -- This is the set of variables shared between JS and HTML.
  //   crmApi, crmStatus, crmUiHelp -- These are services provided by civicrm-core.
  //   myContact -- The current contact, defined above in config().
  angular.module('trialadmin').controller('TrialadminTrialApplication', function($scope, crmApi, crmStatus, crmUiHelp, myContact) {
    // The ts() and hs() functions help load strings for this module.
    var ts = $scope.ts = CRM.ts('ca.sdda.trialadmin');
    var hs = $scope.hs = crmUiHelp({file: 'CRM/trialadmin/TrialApplication'}); // See: templates/CRM/trialadmin/TrialApplication.hlp
    // Local variable for this controller (needed when inside a callback fn where `this` is not available).
    var ctrl = this;

    // We have myContact available in JS. We also want to reference it in HTML.
    this.myContact = myContact;

    this.save = function() {
      return crmStatus(
        // Status messages. For defaults, just use "{}"
        {start: ts('Saving...'), success: ts('Saved')},
        // The save action. Note that crmApi() returns a promise.
        crmApi('Contact', 'create', {
          id: ctrl.myContact.id,
          first_name: ctrl.myContact.first_name,
          last_name: ctrl.myContact.last_name
        })
      );
    };
  });

})(angular, CRM.$, CRM._);
