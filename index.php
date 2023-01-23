<?php require_once 'header.php';
require_once 'controller/my_appointment_controller.php';
$con = new my_appointment_controller();
$appointments = $con->getAppointments();
$graph = $con->getGraphData();
$bestUsers = $con->getBestUsers();
$willPay = 0;
$allPayed = 0;
$allTaskCount = 0;
$completedTasks = 0;
while ($row = $appointments->fetch(PDO::FETCH_ASSOC)) {
    $allTaskCount++;
    if ($row['status'] == 1 || $row['status'] == 2) {
        $willPay += $row['processing_fee'];
    } else if ($row['status'] == 3) {
        $allPayed += $row['processing_fee'];
    }
    if ($row['status'] == 3) {
        $completedTasks++;
    }
}
if ($allTaskCount == 0) {
    $rate = 0;
} else {
    $rate = ($completedTasks / $allTaskCount) * 100;
}
$analysis = $con->getAnalysis();
$analysis = $analysis->fetch(PDO::FETCH_ASSOC);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Ödenecek Miktar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₺<?= $willPay ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ödenen Toplam Miktar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₺ <?= $allPayed ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tamamlanan Randevular
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= round($rate, 1) ?>%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $rate ?>%" aria-valuenow="<?= $rate ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Toplam Randevu Sayısı</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $allTaskCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($user['is_admin'] == 1) { ?>
        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Rafineden Kazanılan Toplam Gelir</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₺ <?= $analysis['totaloliveordermoney']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Zeytinyağı Satışından Gelen Toplam Gelir</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₺ <?= $analysis['totaluserordersmoney']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Toplam Kullanıcı Sayısı
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $analysis['totalcustomercount']; ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Beklenen Ödeme Miktarı</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₺<?= $analysis['totalmoneyawaiting']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Content Row -->
    <?php
    if ($user['is_admin'] == 1) { ?>
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Müşteri Harcamaları</h6>
                        Yöneticileri Dahil Et
                        <input type="checkbox" onclick="hasAdmin()" style="margin-right: 450px;" id="is_admins_includes" checked>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">En Yüksek Gelir Kaynakları</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <br />
                        <br />
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Content Row -->

</div>
</div>
<script>


<?php

$labels = "";
$data = "";
while ($row = $graph->fetch(PDO::FETCH_ASSOC)) {
    $labels .= "\"" . $row["product_name"] . "\",";
    $data .= $row["thesum"] . ",";
}

$best_users_labels = "";
$best_users_data = "";

while($row = $bestUsers->fetch(PDO::FETCH_ASSOC)) {
    $best_users_labels .= "\"" . $row["user_name_surname"] . "\",";
    $best_users_data .= $row["income"] . ",";
}


?>
var graph_labels = [<?= $labels ?>];
var graph_data = [<?= $data ?>];

var best_users_labels = [<?= $best_users_labels ?>];
var best_users_data = [<?= $best_users_data ?>];

function hasAdmin(){
    var is_checked = $("#is_admins_includes").is(':checked');

    if(is_checked){
        updateChartGraph("checked");
    }else{
        updateChartGraph("no");
    }
}

</script>

<!-- /.container-fluid -->
<!-- End of Main Content -->
<?php require_once 'footer.php'; ?>