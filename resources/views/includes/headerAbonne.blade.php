<!-- Page Title -->
 <style>
    .imgAbonne{
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }

 </style>
@php
      
        $userEncours = (session('userEncours')!=null)? session('userEncours'):null;
        $anEncours = (session('anEncours')!=null)? session('anEncours'):null;
        $abonnementEncours = (session('abonnementEncours')!=null)? session('abonnementEncours'):null;
        $img =($abonnementEncours != null && $abonnementEncours->logo!= null )?$abonnementEncours->logo:null;
      
       
                //{{ $abonnementEncours->designation }}
                

 //echo $img;

  
 @endphp

<div class="page-title dark-background" >
    <div class="row">
        <div class="col-md-4" style="position:left;"> 
              @if($img != null)
                           <!-- <img src="assets/img/logo.webp" alt="KK"> -->
                    <img class="imgAbonne" src="../../storage/images/{{ $img }}" alt="KK" >
                    <!-- <img class="imgAbonne"  src="url({{ asset('storage/images/$img')}} )" alt="KK" > -->
                    @else
                    
                    @endif
            <span  class="btn btn-success">
               <b>{{ $abonnementEncours->designation  }}</b> 
               
            </span>
        </div>
        <div class="col-md-6"> </div>
        <div class="col-md-2" style="position:right;">
            <span  class="btn btn-success">
                <b>{{ ($anEncours)? $anEncours->libannee():''  }}</b> 
                
            </span>
            
        </div> 
    </div> 
    <!-- <div class="container position-relative">
        <div class="row">

        </div>       
    </div> -->
</div>
<!-- End Page Title -->