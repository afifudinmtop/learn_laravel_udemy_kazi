<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Login | Upcube - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      content="Premium Multipurpose Admin & Dashboard Template"
      name="description"
    />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/backend/assets/images/favicon.ico" />

    <!-- Bootstrap Css -->
    <link
      href="/backend/assets/css/bootstrap.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <!-- Icons Css -->
    <link
      href="/backend/assets/css/icons.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <!-- App Css-->
    <link
      href="/backend/assets/css/app.min.css"
      rel="stylesheet"
      type="text/css"
    />
  </head>

  <body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
      <div class="container-fluid p-0">
        <div class="card">
          <div class="card-body">
            <div class="text-center mt-4">
              <div class="mb-3">
                <a href="index.html" class="auth-logo">
                  <img
                    src="/backend/assets/images/logo-dark.png"
                    height="30"
                    class="logo-dark mx-auto"
                    alt=""
                  />
                  <img
                    src="/backend/assets/images/logo-light.png"
                    height="30"
                    class="logo-light mx-auto"
                    alt=""
                  />
                </a>
              </div>
            </div>

            <h4 class="text-muted text-center font-size-18"><b>Sign In</b></h4>

            {{-- error validation --}}
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger m-3">
                        <div>{{ $error }}</div>
                    </div>
                @endforeach
            @endif

            {{-- success message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- error message --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="p-3">
              <form class="form-horizontal mt-3" action="/login" method="POST">
                @csrf
                <div class="form-group mb-3 row">
                  <div class="col-12">
                    <input
                      class="form-control"
                      type="text"
                      placeholder="Username"
                      name="username"
                    />
                  </div>
                </div>

                <div class="form-group mb-3 row">
                  <div class="col-12">
                    <input
                      class="form-control"
                      type="password"
                      placeholder="Password"
                      name="password"
                    />
                  </div>
                </div>

                <div class="form-group mb-3 text-center row mt-3 pt-1">
                  <div class="col-12">
                    <button
                      class="btn btn-info w-100 waves-effect waves-light"
                      type="submit"
                    >
                      Log In
                    </button>
                  </div>
                </div>

                <div class="form-group mb-0 row mt-2">
                  
                  <div class="col-sm-12 mt-3">
                    <a href="/register" class="text-muted"
                      ><i class="mdi mdi-account-circle"></i> Create an
                      account</a
                    >
                  </div>
                </div>
              </form>
            </div>
            <!-- end -->
          </div>
          <!-- end cardbody -->
        </div>
        <!-- end card -->
      </div>
      <!-- end container -->
    </div>
    <!-- end -->

    <!-- JAVASCRIPT -->
    <script src="/backend/assets/libs/jquery/jquery.min.js"></script>
    <script src="/backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/backend/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/backend/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/backend/assets/libs/node-waves/waves.min.js"></script>

    <script src="/backend/assets/js/app.js"></script>
  </body>
</html>
