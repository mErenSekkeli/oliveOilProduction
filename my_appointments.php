<?php
require_once 'header.php';
require_once 'controller/my_appointment_controller.php';
$con = new my_appointment_controller();
$appointments = $con->getAppointments();
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tüm Randevularım</h1>
                    <?php if(isset($_GET['situation']) && $_GET['situation'] == "success") { ?>
                        <div class="alert alert-success" role="alert">
                            Randevu Alındı. updateOilWaitTime Trigger'ı Tetiklendi.
                        </div>
                    <?php } ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Randevular</h6>
                        </div>
                        <form action="controller/my_appointment_controller.php" method="POST">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="appointmentTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Zeytin Tipi</th>
                                            <th>Toplam Ağırlık</th>
                                            <th>Tahmini Yağ Miktarı</th>
                                            <th>Teslim Tarihi</th>
                                            <th>Toplam Ücret</th>
                                            <th>Randevu Durumu</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $appointments->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td>
                                                <?php
                                                switch($row['olive_type']){
                                                    case 1:
                                                        echo "Siyah Zeytin";
                                                        break;
                                                    case 2:
                                                        echo "Yeşil Zeytin";
                                                        break;
                                                    case 3:
                                                        echo "Karışık Zeytin";
                                                        break;
                                                    
                                                }
                                                ?>
                                            </td>
                                            <td><?= $row['olive_weight']; ?> Ton</td>
                                            <td><?= $row['oil_crop']; ?></td>
                                            <td><?php
                                            $date = date_create($row['appointment_date']);
                                            $i = $row['time_for_weight'];
                                            $date->modify("+$i hours");
                                            echo date_format($date, "Y/m/d H:i:s");
                                            ?></td>
                                            <td><?= "₺".$row['processing_fee']; ?></td>
                                            <td><?php
                                                switch($row['status']){
                                                    case 1:
                                                        echo "Beklemede";
                                                        break;
                                                    case 2:
                                                        echo "İşleniyor";
                                                        break;
                                                    case 3:
                                                        echo "Tamamlandı";
                                                        break;
                                                    case 4:
                                                        echo "Randevu İptal Edildi";
                                                        break;
                                                    
                                                }
                                            ?></td>
                                            <?php if($row['status'] == 1){ ?>
                                            <td><button onclick="cancelApp('<?= $row['appointment_id']; ?>')" type="button" class="btn btn-danger">İptal Et</button></td>
                                            <?php }else if($row['status'] == 4){ ?>
                                            <td><button onclick="deleteApp('<?= $row['appointment_id']; ?>')" class="btn btn-danger">Sil</button></td>    	
                                            <?php }else{ echo "<td>-</td>";}?>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
<script src="js/my_appointment.js"></script>
<?php require_once 'footer.php'; ?>