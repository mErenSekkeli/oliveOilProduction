<?php require_once 'header.php'; ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Profilim</h1>
                    <!-- give me a user's info's input area -->
                    <?php if(isset($_GET['situation']) && $_GET['situation'] == "success"){ ?>
                    <div class="alert alert-success" role="alert">
                        Bilgileriniz başarıyla güncellendi!
                    </div>
                    <?php }else if (isset($_GET['situation']) && $_GET['situation'] == "error"){ ?>
                    <div class="alert alert-danger" role="alert">
                        Bilgileriniz güncellenemedi!
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-left">
                                    <h1 class="h5 text-gray-900 mb-3">İsim</h1>
                                </div>
                                <form class="user" action="controller/header_controller.php" method="POST">
                                    <div class="form-group">
                                        <input type="text" style="font-size: 16px;" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Ad" name="user_name" value="<?php echo $user['user_name']; ?>">
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-left">
                                    <h1 class="h5 text-gray-900 mb-3">Soyisim</h1>
                                </div>
                                    <div class="form-group">
                                        <input type="text" style="font-size: 16px;" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Ad" name="user_surname" value="<?php echo $user['user_surname']; ?>">
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-left">
                                    <h1 class="h5 text-gray-900 mb-3">E-Posta</h1>
                                </div>
                                    <div class="form-group">
                                        <input type="text" readonly style="font-size: 16px; cursor:not-allowed;" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Ad" name="user_mail" value="<?php echo $user['user_mail']; ?>">
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-left">
                                    <h1 class="h5 text-gray-900 mb-3">Telefon</h1>
                                </div>
                                    <div class="form-group">
                                        <input type="text" style="font-size: 16px;" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Ad" name="phone_number" value="<?php echo $user['phone_number']; ?>">
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-left">
                                    <h1 class="h5 text-gray-900 mb-3">Adres</h1>
                                </div>
                                    <div class="form-group">
                                        <textarea name="address" id="" cols="130" rows="10"><?php echo $user['address']; ?></textarea>
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="p-1">
                                    <div class="form-group">
                                        <button class="btn btn-primary" name="changeUserInfo" type="submit">Değiştir</button>
                                    </div>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
                <!-- /.container-fluid -->


<?php require_once 'footer.php'; ?>