var fetch = angular.module('myapp', ['infinite-scroll']);

fetch.controller('fetchCtrl', ['$scope', '$http', function ($scope, $http) {

    // Variables
    $scope.row = 0;
    $scope.rowperpage = 3;
    $scope.posts = [];
    $scope.busy = false;
    $scope.loading = false;

    // Fetch data
    $scope.getPosts = function(){

        if ($scope.busy) return;

        $scope.busy = true;

        // Fetch data
        $http({
            method: 'post',
            url: '?page=\' + page',
            data: {row:$scope.row,rowperpage:$scope.rowperpage}
        }).then(function successCallback(response) {

            if(response.data !='' ){
                // New row value
                $scope.row+=$scope.rowperpage;

                $scope.loading = true;
                setTimeout(function() {
                    $scope.$apply(function(){

                        // Assign response to posts Array
                        angular.forEach(response.data,function(item) {
                            $scope.posts.push(item);
                        });
                        $scope.busy = false;
                        $scope.loading = false;
                    });

                },500);
            }

        });
    }

    // Call function
    $scope.getPosts();

}]);
