(function(){
    var app = angular.module('db', ['Column']);
    app.controller('ColumnsController', ['$http', 'Fetcher', function($http, Fetcher){
        var controller = this;
        controller.columns = [];
        controller.datas = {};
        controller.selected_column = "";
        controller.update = function(){
            controller.datas = {};
            Fetcher.get(this.selected_column).then(function(result){
                controller.datas = result;    
            });
        };

        $http.get('./bdd.php').
            success(function(data){
                controller.columns = data;   
                controller.selected_column = data[0];
                controller.update(this.selected_column);
            }).
            error(function(data, status){
             console.log('error ' + data + status);   
            });

    }]);

    app.factory('Fetcher', function($http){
        var fetcher = {};
        fetcher.test = "couc";
        fetcher.get = function(column){
            return $http.get('./bdd.php?column=' + column).
                then(function(response){
                    return response.data;   
                });
            };
        return fetcher;
    });

    var columns = [
        'education',
        'fulltime'
        ];
})();
