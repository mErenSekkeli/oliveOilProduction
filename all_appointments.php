<?php
ob_start();
require_once 'header.php';
if(!$user['is_admin']){
    header('Location: 404.php');
    exit;
}
require_once 'controller/all_appointments_controller.php';
$con = new all_appointments_controller();
$allAppointments = $con->getAllAppointments();

?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Randevular</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Randevular</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="allApppointmentTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kullanıcı</th>
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
                                        <?php while($row = $allAppointments->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td><?= $row['user_name_surname']; ?></td>
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
                                            <td>
                                            <select id="status_<?= $row['appointment_id']; ?>">
                                                <option value="1" <?php if($row['status'] == 1){ echo "selected"; } ?>>Beklemede</option>
                                                <option value="2" <?php if($row['status'] == 2){ echo "selected"; } ?>>İşleniyor</option>
                                                <option value="3" <?php if($row['status'] == 3){ echo "selected"; } ?>>Tamamlandı</option>
                                                <option value="4" <?php if($row['status'] == 4){ echo "selected"; } ?>>İptal Edildi</option>

                                            </select>
                                            </td>
                                                
                                            <td>
                                                <button onclick="changeAppointment('<?= $row['appointment_id']; ?>')" class="btn btn-primary">Düzenle</button>
                                           </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
<script>
function changeAppointment(id){
    var selectId = "status_" + id;
    var status = document.getElementById(selectId).value;
    var str = "appointment_id=" + id + "&status=" + status + "&changeApp=" + true;
    $.ajax({
        type: "POST",
        url: "controller/all_appointments_controller.php",
        data: str,
        success: function(data){
            var returned = JSON.parse(data);
            if(returned.status == "success"){
                swal("Başarılı!", "Randevu durumu değiştirildi.", "success");
            }else if(returned.status == "error"){
                swal("Hata!", "Randevu Durumu Değiştirilemedi.", "error");
            }
        }
    });
}
</script>
<?php
ob_flush();
require_once 'footer.php'; ?>