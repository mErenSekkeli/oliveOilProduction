<?php
require_once 'header.php';
require_once 'controller/order_oil_controller.php';
$con = new order_oil_controller();
$products = $con->getProducts();
?>
                <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <h1 class="h3 mb-4 text-gray-800">Yağ Satın Al</h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3">
            <div class="form-group">
                <div class="selectdiv" style="margin-top: 23px;">
                    <select class="form-select" name="product_name">
                        <?php while($product = $products->fetch(PDO::FETCH_ASSOC)){ ?>
                            <option value="<?php echo $product['product_id']; ?>" price="<?= $product['product_price_per_kilo']; ?>"><?php echo $product['product_name']; ?> (1 Litresi ₺<?= $product['product_price_per_kilo']; ?>)</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="olive_type">Kaç Litre Alacaksın?</label>
                    <input type="number" class="form-control form-control-user" name="order_liter" placeholder="Litre">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3" style="margin-top: 20px;">
                <div class="form-group">
                    <button type="button" onclick="oil_request()" class="btn btn-success"><i class="fas fa-plus"></i> Talep Et</button>
                </div>
            </div>
        </div>

    </div>
    </div>
<script>

    function oil_request(){
        var product_id = $("select[name='product_name']").val();
        var order_liter = $("input[name='order_liter']").val();
        var product_price = $("select[name='product_name']").find(':selected').attr('price') * order_liter;
        product_price = product_price.toFixed(2);

        swal({
                title: "Onay",
                text: "Bu Ürün İçin Toplam " + product_price + " TL Ödeme Yapmanız Gerekmektedir. Onaylıyor Musunuz?",
                icon: "info",
                buttons: true,
                buttons: ["Hayır", "Evet"],
                dangerMode: false
            }).then((willRequest) => {
                if (willRequest) {
                    $.ajax({
                        type: "POST",
                        url: "controller/order_oil_controller.php",
                        data: {
                            'product_id': product_id,
                            'order_liter': order_liter,
                            'product_price': product_price,
                            'oilRequest': true
                        },
                        success: function (data) {
                            var returned = JSON.parse(data);
                            if(returned.status == "EnoughStock"){
                                swal("Başarılı!", "Yağ Siparişiniz Başarıyla Alındı. Yönlendiriliyorsunuz...", "success");
                                setTimeout(function(){
                                    window.location.href = "my_orders?situation=success";
                                }, 2000);
                            }else if(returned.status == "notEnoughStock"){
                                swal("Başarısız!", "Yeterli Stok Yok. Lütfen " + returned.stock['checkifstockenough'] + " Litreden Daha Az Satın Alın.", "error");
                            }else if(returned.status == "error"){
                                swal("Başarısız!", "Bir Hata Oluştu. Lütfen Tekrar Deneyin.", "error");
                            }
                        }
                    });
                }
            });         
    }

</script>
<?php require_once 'footer.php'; ?>