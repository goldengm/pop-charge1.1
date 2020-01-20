<div class="container" ng-controller="lendController">
	<h4>Lend Page</h4>
	<form>
		<div class="form-group" ng-if="pageStatus=='checking'">
			<div class="form-row">
				<div class="loader-description">Checking station now...</div>
				<div class="loader"></div>
			</div>			
		</div>
		<div ng-if="pageStatus=='loaded'">
			<div class="form-row">
				<div class="form-col1">
					<strong>Station Sn:&nbsp;</strong>
				</div>
				<div class="form-col2">
					<span><?php echo $stationSn?></span>
				</div>
			</div>
			<div class="form-row">
				<div class="form-col1">
					<h4>Slots</h4>
				</div>
			</div>
			<table style="width: 100%">
				<thead>
					<tr>
						<th>Power Bank No.</th>
						<th>Electric Quantity</th>
						<th>Lend</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="row in slots">
						<td ng-if="row.powerBankSn!='NULL'">
							<span class="text-primary">{{row.slotNum}}.&nbsp;{{row.powerBankSn}}</span>
						</td>
						<td ng-if="row.powerBankSn!='NULL'">
							<span class="text-success">{{row.electricQuantity}}</span>
						</td>
						<td ng-if="row.powerBankSn!='NULL'">
							<button type="button" class="btn btn-sm btn-primary" ng-click="lend(row.slotNum)">Lend</button>
						</td>
						<td ng-if="row.powerBankSn=='NULL'" colspan="3">
							<span class="text-danger">{{row.slotNum}}. ---Empty---</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="form-group" ng-if="pageStatus=='lending'">
			<div class="form-row">
				<div class="loader-description">Lending... Please wait.</div>
				<div class="loader"></div>
			</div>			
		</div>
	</form>
	
</div>

<script>
app.controller('lendController', function($scope, $http) {
	$scope.pageStatus = 'checking';
	$scope.slots = [];
	check_initial();
	function check_initial() {
		var requestData = {
			"sign": "<?php echo $sign?>",
			"body": {
				"stationSn": [
					"<?php echo $stationSn?>"
				]
			}
		}
		$http.post('http://localhost:8012/pop-charge/simulator/cabinetInfo', requestData).then(function(response) {
			var data = response.data;
			$scope.pageStatus = 'loaded';
			$scope.slots = data.body[0].list;
		})
	}	
	var intervalCheck = null;
	$scope.lend = function(slotNum){
		if (confirm('Are you sure to lend this battery?')){
			var requestData = {
				"sign": "<?php echo $sign?>",
				"body": {
					"stationSn": "<?php echo $stationSn?>",
					"tradeNo": "123456",
					"slotNum": slotNum,
					"url": "http://localhost:8012/pop-charge/lend/doLend",
					"timeout": 60
				}
			}
			$scope.pageStatus='lending';
			$http.post('http://localhost:8012/pop-charge/simulator/lend', requestData).then(function(response) {
				intervalCheck = setInterval(function() {
					checkDoneLend('123456');
				}, 2000);
				$scope.pageStatus='lending';
			}, function() {
				$scope.pageStatus='lending';
			})
			return true;
		}
		return false;
	}
	
	function checkDoneLend(tradeNo) {
		$http.post('http://localhost:8012/pop-charge/lend/checkDoneLend', {tradeNo}).then(function(response) {
			if (response.data.result) {
				clearInterval(intervalCheck);
				window.location.href='http://localhost:8012/pop-charge/lend/thankyou';
			}
		})
	}
})
</script>

<style>
.form-row {
	overflow: hidden;
}
.form-col1 {
	float: left;
	width: 180px;
}
.form-col2 {
	float: right;
	width: calc(100% - 190px);
}
.loader {
  border: 3px solid #f3f3f3; /* Light grey */
  border-top: 3px solid #555; /* Blue */
  border-radius: 50%;
  width: 30px;
  height: 30px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.loader-description {
	font-size: 16px; line-height: 30px;
	padding-right: 15px;
}
</style>
