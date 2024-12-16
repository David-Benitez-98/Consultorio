
<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="ionicons-2.0.1/css/ionicons.min.css">
<!-- jvectormap -->
<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">

<link rel="stylesheet" href="plugins/select2/select2.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="css/AdminLTE.min.css">
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">



<link rel="stylesheet" href="css/skins/skin-blue.min.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<style>
.skin-yellow .main-header .logo {
    /*background-color: #FFCF6E;*/
    /*background-color: #7F7BFF;*/
    background-color: #00ffcd;
    color: #fff;
    /*color:#425d69;*/
    border-bottom: 0 solid transparent;
}
.skin-yellow .main-header .logo:hover {
    /*background-color: #FFBB30;*/
    background-color: #00ffcd;
    color: #fff;
    /*color:#425d69;*/
    border-bottom: 0 solid transparent;
}
.skin-yellow .main-header .navbar .sidebar-toggle {
    color:#fff;
    /*color:#425d69;*/

}

.skin-yellow .main-header .navbar .sidebar-toggle:hover {
    /*background-color: #e08e0b;*/
    background-color: #00ffcd;
    /*color:#425d69;*/
    color:#fff;

}
.skin-yellow .main-header .navbar {
    background-color: #00ffcd; /* Cambia "#00aaff" por el color deseado */
}


.skin-yellow .main-header .navbar .nav>li>a {
    color: #fff;
    /*color: #425d69;*/
}


    .alert-info {
        color: #31708f !important;
        background-color: #d9edf7 !important;
        border-color: #bce8f1 !important;
    }
    .alert-warning {
        color: #8a6d3b !important;
        background-color: #fcf8e3 !important;
        border-color: #faebcc !important;
    }
    .alert-danger {
        color: #a94442 !important;
        background-color: #f2dede !important;
        border-color: #ebccd1 !important;
    }
    .alert-success {
        color: #3c763d !important;
        background-color: #dff0d8 !important;
        border-color: #d6e9c6 !important;
    }
.skin-yellow .main-header .logo {
    background-color: #28a745; /* Cambia el color de fondo del logo a verde */
    color: #fff;
}

.skin-yellow .main-header .logo:hover {
    background-color: #28a745; /* Cambia el color al pasar el ratón */
    color: #fff;
}

.skin-yellow .main-header .navbar {
    background-color: #28a745; /* Cambia el color de fondo de la barra de navegación a verde */
}

.skin-yellow .main-header .navbar .sidebar-toggle {
    color: #fff; /* Texto en blanco */
}

.skin-yellow .main-header .navbar .sidebar-toggle:hover {
    background-color: #28a745; /* Cambia el color de fondo del botón al pasar el ratón */
    color: #fff;
}
.alert-success {
    color: #155724 !important;
    background-color: #d4edda !important;
    border-color: #c3e6cb !important;
}

</style>

<style>
    .login-box{
        width: 360px;
        margin: 5% auto;
    }
    .login-page, .register-page {
        background: #d2d6de;
    }
</style>

<style>
    @media only screen and (max-width: 800px) {

        /* Force table to not be like tables anymore */
        #no-more-tables table, 
        #no-more-tables thead, 
        #no-more-tables tbody, 
        #no-more-tables th, 
        #no-more-tables td, 
        #no-more-tables tr { 
            display: block; 
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        #no-more-tables thead tr { 
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        #no-more-tables tr { border: 1px solid #ccc; }

        #no-more-tables td { 
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee; 
            position: relative;
            padding-left: 50%; 
            white-space: normal;
            text-align:left;
        }

        #no-more-tables td:before { 
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
            text-align:left;
            font-weight: bold;
        }

        /*
        Label the data
        */
        #no-more-tables td:before { content: attr(data-title); }
    }
</style>

<style>
    #IrArriba {
        position: fixed;
        bottom: 30px;
        right: 50%;
        background-color: transparent;
        opacity: 0.7;
    }
    #IrArriba a {
        text-decoration: none;
        color: #fff;
        text-shadow:none !important;
    }
    #IrArriba span {
        width: 66px;
        height: 66px;
        display: block;
        background: url(img/subir.png) no-repeat center center;
        cursor:pointer;
    }
#IrArriba span {
    background: url(img/subir-verde.png) no-repeat center center; /* Cambia el ícono si tienes uno verde */
    cursor: pointer;
}

</style>

<style>
    /***
Bootstrap Line Tabs by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
***/

    /* Tabs panel */
    .tabbable-panel {
        border:1px solid #eee;
        padding: 10px;
    }

    /* Default mode */
    .tabbable-line > .nav-tabs {
        border: none;
        margin: 0px;
    }
    .tabbable-line > .nav-tabs > li {
        margin-right: 2px;
    }
    .tabbable-line > .nav-tabs > li > a {
        border: 0;
        margin-right: 0;
        color: #737373;
    }
    .tabbable-line > .nav-tabs > li > a > i {
        color: #a6a6a6;
    }
    .tabbable-line > .nav-tabs > li.open, .tabbable-line > .nav-tabs > li:hover {
        border-bottom: 4px solid #fbcdcf;
    }
    .tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {
        border: 0;
        background: none !important;
        color: #333333;
    }
    .tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
        color: #a6a6a6;
    }
    .tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
        margin-top: 0px;
    }
    .tabbable-line > .nav-tabs > li.active {
        border-bottom: 4px solid #f3565d;
        position: relative;
    }
    .tabbable-line > .nav-tabs > li.active > a {
        border: 0;
        color: #333333;
    }
    .tabbable-line > .nav-tabs > li.active > a > i {
        color: #404040;
    }
    .tabbable-line > .tab-content {
        margin-top: -3px;
        background-color: #fff;
        border: 0;
        border-top: 1px solid #eee;
        padding: 15px 0;
    }
    .portlet .tabbable-line > .tab-content {
        padding-bottom: 0;
    }

    /* Below tabs mode */

    .tabbable-line.tabs-below > .nav-tabs > li {
        border-top: 4px solid transparent;
    }
    .tabbable-line.tabs-below > .nav-tabs > li > a {
        margin-top: 0;
    }
    .tabbable-line.tabs-below > .nav-tabs > li:hover {
        border-bottom: 0;
        border-top: 4px solid #fbcdcf;
    }
    .tabbable-line.tabs-below > .nav-tabs > li.active {
        margin-bottom: -2px;
        border-bottom: 0;
        border-top: 4px solid #f3565d;
    }
    .tabbable-line.tabs-below > .tab-content {
        margin-top: -10px;
        border-top: 0;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }
</style>