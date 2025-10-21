<!DOCTYPE html>
<html lang="fr">
@php
    $img = ($labonne != null && $labonne->logo != null) ? $labonne->logo : null;
    $libabonne = ($labonne != null) ? $labonne->designation : 'TITIRE ABONNE';
    //donneeimprim coltitre coldata
    $titres = $coltitre != '' ? explode('|', $coltitre) : array();
    $cols = $coldata != '' ? explode('|', $coldata) : array();

    //dd($cols);

    //dd($img);
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $letitre }}</title>
    @include('includes.css')

    <link href="{{ public_path('assets/css/bootstrap.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ public_path('pdf.css') }}" type="text/css">
    <style>
        .centrerGrille {
            display: grid;
            place-items: center;
        }

        .tableauto {
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
        }

        .L {
            text-align: left;
        }

        .R {
            text-align: right;
        }

        .C {
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 100px;
            text-align: center;
            line-height: 35px;
        }

        footer:after {
          
/* counter-increment: page; */
               /* content:"Page " counter(page) " / " ; */
               counter-reset: page 1;
               /* counter-increment: page; */
               content:"Page " counter(page) " / " counter(pages);
              
        }

    </style>

</head>

<body>


    <table class="bartitre">
        <tr>
            <td style="width: 10%; float: left;">
                @if($img != null)
                    <img class="logo" src="{{ public_path('storage/images/abonnements/' . $img)}}" alt="KK">

                @else

                @endif
            </td>
            <td style="width: 80%; float: left;">
                <center>
                    <h3>{{ $libabonne }} </h3>
                </center>
            </td>
            <td style="width: 10%; float: left;">
                <img class="logo" src="{{ public_path('assets/img/amoarite.png') }}" alt="Amoarite">
            </td>
        </tr>

    </table>

    <hr class="trait">

    <div class="letitre">
        {{ $letitre }}
    </div>

    @if(count($hautdoc) > 0)
        <table class="tableauto" style="font-size:1.5rem;">
            @foreach($hautdoc as $ln)
                <tr>
                    @foreach ($ln as $i => $e)
                        <td class="L">
                            @if($i % 2 == 0)
                                <b style="margin-right:none;">{{ $e }}</b>
                            @else
                                {{ $e }}
                            @endif
                        </td>
                    @endforeach
                </tr>

            @endforeach
        </table>
    @endif

    <!-- Saut de page -->
    <!-- <div style="page-break-after: always;" ></div> -->
    <br>

    <table id="letablo" class=" impression table table-bordered table-striped  " scrol>
        <thead>
            <tr>
                @foreach($titres as $t)
                    <th>{{ $t }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($donneeimprim as $i => $d)
                <tr class="items">
                    @foreach($cols as $c)
                        <td>{{ $d[$c] }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer> 
        <hr class="traitPied">
        Mon pied de page
    </footer>
    @php

        if (isset($pdf)) {
            if ($PAGE_COUNT > 1) {
                $font = $fontMetrics->get_font('Arial, Helvetica, sans-serif', 'normal');
                $size = 12;
                $pageText = 'Page ' . $PAGE_NUM . ' sur ' . $PAGE_COUNT;
                $y = 15;
                $x = 520;
                $pdf->text($x, $y, $pageText, $font, $size);
            }
        }
    @endphp

    @include('includes.js')
</body>

</html>