let mix = require("laravel-mix");

mix.combine(
    [
        // "public/dist/bootstrap/bootstrap.min.css",
        "public/dist/stisla/style.css",
        "public/dist/stisla/components.css",
        "public/dist/summernote/summernote-bs4.css",
        "public/dist/datatables/datatables.min.css",
        "public/dist/datatables/dataTables.bootstrap4.min.css",
        "public/dist/datatables/responsive.bootstrap4.min.css",
    ],
    "public/assets/mix/app.css"
);

mix.combine(
    [
        "public/dist/jquery/jquery.min.js",
        "public/dist/popper/popper.min.js",
        "public/dist/bootstrap/bootstrap.min.js",
        "public/dist/jquery/jquery.nicescroll.min.js",
        "public/dist/moment/moment.min.js",
        "public/dist/stisla/stisla.js",
        "public/dist/simpleweather/jquery.simpleWeather.min.js",
        "public/dist/jqvmap/jquery.vmap.min.js",
        "public/dist/jqvmap/jquery.vmap.world.js",
        "public/dist/summernote/summernote-bs4.js",
        "public/dist/jquery/jquery.chocolat.min.js",
        "public/dist/stisla/scripts.js",
        "public/dist/icon/awesome.js",
        "public/dist/sweetalert/sweetalert.min.js",

        "public/dist/datatables/jquery.dataTables.min.js",
        "public/dist/datatables/dataTables.bootstrap4.min.js",
        "public/dist/datatables/dataTables.responsive.min.js",
        "public/dist/datatables/responsive.bootstrap4.min.js",
        "public/dist/pdf-preview/pdfobject.min.js",
        "public/dist/bootstrap/loading.js",
    ],
    "public/assets/mix/app.js"
);
