@extends('admin.layout.head')

<body>
    <div class="container-scroller">
    @include('admin.layout.sidebar')
      <!-- partial:partials/_sidebar.html -->
       

      <!-- partial:partials/_navbar.html -->
        <div class="container-fluid page-body-wrapper">
           
            @include('admin.layout.header')
      
            @extends('admin.layout.contect')   
    
           
            </div>
        </div> 
      
           @include('admin.layout.footer')
        </body>
        
