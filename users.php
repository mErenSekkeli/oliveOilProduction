<?php
ob_start();
require_once 'header.php';
if(!$user['is_admin']){
    header('Location: 404');
    exit;
}
require_once 'controller/users_controller.php';
$con = new users_controller();
if(isset($_GET['search']) && isset($_SESSION['users']) && $_SESSION['users'] != "empty"){
    $users =$_SESSION['users'];
}else if(isset($_SESSION['users']) && $_SESSION['users'] == "empty"){
    $users = [];
}else{
$users = $con->getUsers();
$users =  $users->fetchAll(PDO::FETCH_ASSOC);
}
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Kullanıcılar</h1>
                    <form action="controller/users_controller.php" method="POST">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Arama İşlemi</label>
                                <input type="text" class="form-control form-control-user" name="search_key" placeholder="Kelime Giriniz">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                 <button type="submit" name="searchUser" class="btn btn-success"><i class="fas fa-search"></i> Ara</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Kullanıcı Listesi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kullanıcı Numarası</th>
                                            <th>Kullanıcı İsmi</th>
                                            <th>Mail</th>
                                            <th>Telefon</th>
                                            <th>Adres</th>
                                            <th>Kullanıcı Tipi</th>
                                            <th>Durum</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach($users as $row): ?>
                                        <tr>
                                            <td><?= ++$i; ?></td>
                                            <td><?=$row['user_id']; ?></td>
                                            <td><?= $row['user_name']." ".$row['user_surname']; ?></td>
                                            <td><?= $row['user_mail']; ?></td>
                                            <td><?= $row['phone_number']; ?></td>
                                            <td><?php
                                                if(empty($row['address'])){
                                                    echo "-";
                                                }else{
                                                    echo $row['address'];
                                                }
                                            ?></td>
                                            <td>
                                            <select id="is_admin_select_<?= $row['user_id']; ?>">
                                                <option value="1" <?php if($row['is_admin'] == 1){ echo "selected"; } ?>>Yönetici</option>
                                                <option value="0" <?php if($row['is_admin'] == 0){ echo "selected"; } ?>>Müşteri</option>
                                            </select>
                                            </td>
                                            <td><select id="is_active_select_<?= $row['user_id']; ?>">
                                                <option value="1" <?php if($row['is_active'] == 1){ echo "selected"; } ?>>Aktif</option>
                                                <option value="0" <?php if($row['is_active'] == 0){ echo "selected"; } ?>>Pasif</option>
                                            </select></td>
                                            <td><button onclick="changeRole('<?= $row['user_id']; ?>')" class="btn btn-primary">Düzenle</button></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
<script>
function changeRole(id){
    var id1 = "is_admin_select_"+id;
    var id2 = "is_active_select_"+id;
    var is_admin = document.getElementById(id1).value;
    var is_active = document.getElementById(id2).value;

    var str = "is_admin= "+ is_admin + "&is_active= " + is_active + "&changeRole=" + true + "&user_id=" + id;
    $.ajax({
        url: "controller/users_controller.php",
        type: "POST",
        data: str,
        success: function(data){
            var returned = JSON.parse(data);
            if(returned.status == "success"){
                swal("Başarılı", "Değişiklikler Yapıldı.", "success");
                setTimeout(function(){
                    if(window.location.href.includes("search")){
                        $("#usersTable").load("users.php #usersTable");
                    }
                    $("#usersTable").load("users.php #usersTable");
                }, 1000);
            }else if(returned.status == "error"){
                swal("Hata", "Değişiklikler Yapılamadı.", "error");
            }
        }
    });
}
</script>
<?php
ob_flush();
require_once 'footer.php'; ?>