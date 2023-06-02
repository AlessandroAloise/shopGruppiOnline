<!DOCTYPE html>
<html lang="it">
   <style>
      .dropbtn {
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      }
      .dropbtn:hover, .dropbtn:focus {
      background-color: #ffffff;
      }
      .dropdown {
      position: relative;
      display: inline-block;
      }
      .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      overflow: auto;
      z-index: 1;
      }
      .dropdown-content a  {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      }
      .dropdown a:hover {background-color: #ddd;}
      .show {display: block;}
      .decoration ul {
      list-style: none;
      padding: 0;
      margin: 0;
      }
      .decoration ul li {
      margin-bottom: 10px;
      padding-right: 20px;
      }
      .decoration {
      top: 0;
      bottom: 0;
      z-index: 100;
      background-color: transparent;
      border-right: 1px solid #ddd;
      height: calc(100vh - 70px); 
      }
      .decoration ul li a {
      color: #888;
      text-decoration: none;
      display: block;
      padding: 5px 0 !important;
      position: relative;  
      }
      .decoration ul li a::after {  
      content: "";
      position: absolute;
      bottom: -2px;  
      left: 0;
      width: 100%;
      height: 1px;
      background-color: #ccc;
      }
      .decoration ul li a:hover {
      border-bottom-color: #777;
      }
      .image-container {
      position: relative;
      display: inline-block;
      }
      .zoom-image {
      transition: transform 0.3s;
      }
      .zoom-image:hover {
      transform: scale(6);
      }
   </style>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>ShopGruppo</title>
      <!-- CSS only -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
      <!-- JavaScript Bundle with Popper -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="shortcut icon" href="/storage//favicon.ico" />
   </head>
   <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <a class="navbar-brand"  href="{{ url('/') }}">    <img style="max-width: 30%; height: auto;" src="/storage//favicon.ico" alt="logo"> </a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            </ul>
            <ul class="navbar-nav ms-auto">
               @guest
               @if (Route::has('login'))
               <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">Accedi</a>
               </li>
               @endif
               @if (Route::has('register'))
               <li class="nav-item">
                  <a class="nav-link" href="{{ route('register') }}">Registrati</a>
               </li>
               @endif
               @else
               <li class="nav-item">
                  <a  class="nav-link" href="{{ route('user') }}"> 
                  @csrf {{auth()->user()->name}}
                  {{auth()->user()->surname}}
                  </a>
               </li>
               <li class="nav-item">
                  <a  class="nav-link" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                  {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                  </form>
               </li>
               @endguest
            </ul>
         </div>
      </nav>
      <div class="container-fluid">
         <div class="row flex-nowrap">
            <div class="col-auto px-sm-2 px-0 decoration">
               <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 ">
                  <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                     <li>
                        <a href="/" class=" nav-link px-0 align-middle">
                        <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Home</span> </a> 
                     </li>
                     <li>
                        <a href="{{ route('changeGroup') }}" class=" nav-link px-0 align-middle">
                        <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Gruppi Partecipanti</span> </a> 
                     </li>
                     <li>
                        <a href="{{ route('groupStart') }}" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Crea Gruppo </span> </a> 
                     </li>
                     <li>
                        <a href="{{ route('listGroup') }}" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Lista Gruppi</span> </a>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="col py-3">
               @yield('content')
            </div>
         </div>
      </div>
   </body>
</html>