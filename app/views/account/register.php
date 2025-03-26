<?php include 'app/views/share/header.php'; ?>

<div class="container py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg p-4">
                <div class="card-body text-center">
                    <h2 class="fw-bold mb-4">Đăng ký</h2>

                    <!-- Hiển thị lỗi nếu có -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/Account/processRegister" method="post">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user"
                                       id="username" name="username" placeholder="Tên đăng nhập"
                                       required autocomplete="off" aria-label="Tên đăng nhập">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user"
                                       id="fullname" name="fullname" placeholder="Họ và tên"
                                       required autocomplete="off" aria-label="Họ và tên">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user"
                                       id="password" name="password" placeholder="Mật khẩu"
                                       required aria-label="Mật khẩu">
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user"
                                       id="confirmpassword" name="confirmpassword" placeholder="Xác nhận mật khẩu"
                                       required aria-label="Xác nhận mật khẩu">
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-lg btn-block">
                                Đăng ký
                            </button>
                        </div>
                    </form>

                    <p class="mt-3">Bạn đã có tài khoản? <a href="/Account/login">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/share/footer.php'; ?>