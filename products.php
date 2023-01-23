<?php
ob_start();
require_once 'header.php';
if($user['is_admin'] != 1){
    header('Location: 404.php');
    exit;
} 
require_once 'controller/products_controller.php';
$con = new products_controller();
$products = $con->getProducts();
?>
                <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <h1 class="h3 mb-4 text-gray-800">Şirket Ürünleri</h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <h4 class="h4 mb-4 text-gray-800">Ürün Ekle</h4>
            </div>
        </div>
        <form action="controller/products_controller.php" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="olive_type">Ürün İsmi</label>
                        <input type="text" class="form-control form-control-user"  name="product_name" placeholder="İsim">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="olive_type">Ürün Stoğu (Litre)</label>
                        <input type="number" class="form-control form-control-user"  name="product_stock" placeholder="Litre">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="olive_type">1 Litre Ücreti</label>
                        <input type="number" class="form-control form-control-user"  name="product_price" placeholder="Ücret">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="selectdiv" style="margin-top: 23px;">
                            <select class="form-select" name="product_status">
                                <option selected value="1">Aktif</option>
                                <option value="2">Stok Bitti</option>
                                <option value="3">Pasif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="button" onclick="addProduct()" class="btn btn-success"><i class="fas fa-plus"></i> Ekle</button>
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-md-12" id="productTable">
            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Ürünler</h6>
                        </div>
            <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ürün İsmi</th>
                            <th>Ürün Stoğu</th>
                            <th>Ürün Litre Ücreti</th>
                            <th>Ürün Durumu</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; while($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['product_name']; ?></td>
                            <td><?= $row['product_stock']; ?> Litre</td>
                            <td>₺<?= $row['product_price_per_kilo']?></td>
                            <td><?php
                                switch($row['product_status']){
                                    case 1:
                                        echo "Aktif";
                                        break;
                                    case 2:
                                        echo "Stok Bitti";
                                        break;
                                    case 3:
                                        echo "Pasif";
                                        break;
                                    
                                }
                            ?></td>
                            <td><button onclick="editProduct('<?= $row['product_id']; ?>')" class="btn btn-primary">Düzenle</button></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            </div>
            </div>
            </div>
        </div>

    </div>
    </div>

<script>
function addProduct(){
    var name = document.getElementsByName("product_name")[0].value;
    var stock = document.getElementsByName("product_stock")[0].value;
    var price = document.getElementsByName("product_price")[0].value;
    var status = document.getElementsByName("product_status")[0].value;

    var process = "controller/products_controller.php";
    var str = "product_name="+ name +
     "&product_stock=" + stock + "&product_price=" + price + 
     "&product_status=" + status + "&add_product=1";
    $.ajax({
        type: "POST",
        url: process,
        data: str,  
        success: function(data) {
            var returned = JSON.parse(data);
            if(returned.status == "success"){
                swal('Başarılı', 'Ürün Başarıyla Eklendi', 'success');
                setTimeout(function(){
                    $("#productTable").load("products.php #productTable");
                }, 1000);
                
            }else if(returned.status == "error"){
                swal('Hata!', 'Ürün Eklenemedi', 'error');
            }
        }
    });
}

function editProduct(id){
    window.location.href = "edit_product?id=" + id;
}
</script>
<?php require_once 'footer.php';
ob_flush();
?>