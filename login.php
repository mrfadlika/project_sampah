<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Login Page</title>

    <link
      href="vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />
    <link href="css/page.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body class="bg-gradient-success">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <div class="p-5">
                <div class="text-center">
                  <img src="https://mtek3d.com/wp-content/uploads/2018/01/image-placeholder-500x500-300x300.jpg" alt="placeholder" style="width: 100px; height: 100px">
                  <h1 class="h4 text-gray-900 mb-4">Selamat datang</h1>
                </div>
                <form class="user" action="api/auth.php" method="post">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="username"
                      name="username"
                      aria-describedby="emailHelp"
                      placeholder="Username"
                    />
                  </div>
                  <div class="form-group">
                    <input
                      type="password"
                      class="form-control form-control-user"
                      id="password"
                      name="password"
                      placeholder="Password"
                    />
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="customCheck"
                      />
                      <label class="custom-control-label" for="customCheck"
                        >Remember Me</label
                      >
                    </div>
                  </div>
                  <button
                    type="submit"
                    class="btn btn-primary btn-user btn-block"
                  >
                    Login
                  </button>
                </form>
                <hr />
                <div class="text-center">
                  <a class="small" href="#">Dikelola Oleh ...</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo "
            <script>
            console.log('SweetAlert2 dipanggil');
                Swal.fire({
                    title: 'Error',
                    text: '" . $_SESSION['error'] . "',
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
        ";
        unset($_SESSION['error']);
    }
    ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
  </body>
</html>
