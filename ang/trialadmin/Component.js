(function(angular, $, _) {
console.log("Got Here!")
  angular.module('trialadmin').config(function($routeProvider) {
      $routeProvider.when('/trialadmin/Component', {
        controller: 'TrialadminComponent',
        controllerAs: '$ctrl1',
        templateUrl: '~/trialadmin/Component.html',

        // If you need to look up data when opening the page, list it out
        // under "resolve".

      });
    }
  );

  // The controller uses *injection*. This default injects a few things:
  //   $scope -- This is the set of variables shared between JS and HTML.
  //   crmApi, crmStatus, crmUiHelp -- These are services provided by civicrm-core.
  //   myContact -- The current contact, defined above in config().
  angular.module('trialadmin').controller('TrialadminComponent', function($scope, crmApi, crmStatus, crmUiHelp,) {
    // The ts() and hs() functions help load strings for this module.
    var ts = $scope.ts = CRM.ts('ca.sdda.trialadmin');
    var hs = $scope.hs = crmUiHelp({file: 'CRM/trialadmin/Component'}); // See: templates/CRM/trialadmin/Component.hlp
    // Local variable for this controller (needed when inside a callback fn where `this` is not available).
    this.regComponents = [
      {"value": "containers", "label": "Containers"},
      {"value": "interior", "label": "Interior"},
      {"value": "exterior-vehicle", "label": "Exterior-Vehicle"},
      {"value": "exterior-area", "label": "exterior-area"}
    ];
    this.gameComponents = [
      {"value": "distance", "label": "Distance"},
      {"value": "speed", "label": "Speed"},
      {"value": "aerial", "label": "Aerial"},
      {"value": "team", "label": "Team"}
    ]
    var ctrl1 = this;

    // We have myContact available in JS. We also want to reference it in HTML.
    this.myCompnt = []
    
    this.save = function() {
      
      console.log(ctrl1)
      window.close
      CRM.refreshParent
      return ctrl1
    };
  });
  console.log("...and here!")
  
})(angular, CRM.$, CRM._);
