(function(){
    var app = angular.module('Column', []);
    app.directive('columnsSelect', function(){
        return {
           restrict: 'E',
           templateUrl: 'columns-select.html' 
        };
    });   

    app.directive('columnsTable', function(){
        return {
           restrict: 'E',
           templateUrl: 'columns-table.html' 
        };
        
    });   
})();
