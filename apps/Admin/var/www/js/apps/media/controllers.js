'use strict';

app.controller('MediaCtrl', function($scope, $rootScope) {
  $scope.menu = {};
  $scope.form = {};

  $scope.submit = function () {
    if ($scope.form.menu.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'Form not yet complete.', type: "danger"});
      return;
    }
    $scope.menus.post($scope.menu).then(function() {
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'Menu added.', type: "success"});
      $scope.menus.push($scope.menu);
      $scope.form.menu.$setPristine();
      $scope.menu = {};
    });
  };
});