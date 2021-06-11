(function(angular, $, _) {

  angular.module('trialadmin').config(function($routeProvider) {
      $routeProvider.when('/trial/admin/trialapp', {
        controller: 'TrialadminTrialApp',
        controllerAs: '$ctrl',
        templateUrl: '~/trialadmin/TrialApp.html',

        // If you need to look up data when opening the page, list it out
        // under "resolve".
        resolve: {
          myEvent: function(crmApi) {
            return crmApi('Contact', 'getsingle', {
              id: 'user_contact_id',
              return: ['first_name', 'last_name', 'email']
            });
          }
        }
      });
    }
  ); 

  // The controller uses *injection*. This default injects a few things:
  //   $scope -- This is the set of variables shared between JS and HTML.
  //   crmApi, crmStatus, crmUiHelp -- These are services provided by civicrm-core.
  //   myContact -- The current contact, defined above in config().
  angular.module('trialadmin').controller('TrialadminTrialApp', function($scope, crmApi, crmStatus, crmUiHelp, myEvent) {
    // The ts() and hs() functions help load strings for this module.
    var ts = $scope.ts = CRM.ts('ca.sdda.trialadmin');
    var hs = $scope.hs = crmUiHelp({file: 'CRM/trialadmin/TrialApp'}); // See: templates/CRM/trialadmin/TrialApp.hlp
    // Local variable for this controller (needed when inside a callback fn where `this` is not available).
    
    var ctrl = this;    
    this.myEvent = myEvent;
  
    this.addComponent = function() {
      url = CRM.url('civicrm\/a\/#/trialadmin/Component');
      console.log(url)
      // actual url is https://www.sportingdetectiondogs.ca/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fa%2F#/trialadmin/Component?angularDebug=1
      window.location.href = url;
      //CRM.loadPage(url);
      CRM.refreshParent
    }
    
    this.save = function() {
      return crmStatus(
        // Status messages. For defaults, just use "{}"
        {start: ts('Saving...'), success: ts('Saved')},
        // The save action. Note that crmApi() returns a promise.
        crmApi('TrialAdmin', 'create', {
          id: ctrl.myContact.id,
          first_name: ctrl.myContact.first_name,
          last_name: ctrl.myContact.last_name
        })
      );
    };
  });

})(angular, CRM.$, CRM._);
