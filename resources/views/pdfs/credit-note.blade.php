<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>BALQUIMIA S.A.S.</title>
   <style>
    @page           { size:1910pt 2467pt; }
    *               { margin:0; padding:0; }
    html            { margin:0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:20pt; line-height:20pt; }
    table, tr, td   { margin:0; padding:0; border:0; border-spacing:0; }
    .pagion         { padding:55pt 75pt 0 75pt; }
    .colorfff       { color:#fff; }
    .bAzul          { background-color:#1c3e87; }
    .h60            { height:60pt;}
    .taC            { text-align:center;}
    .taR            { text-align:right;}
    .tB             { font-weight:bold;}
    .t18            { font-size:18pt; line-height:18pt; }
    .t24            { font-size:24pt; line-height:24pt; }
    .t26            { font-size:26pt; line-height:26pt; }
    .t32            { font-size:32pt; line-height:32pt; }
    .t34            { font-size:34pt; line-height:34pt; }
    .t36            { font-size:36pt; line-height:36pt; }
    .t38            { font-size:38pt; line-height:38pt; }
    .mb3            { margin-bottom:3pt; }
    .mb10           { margin-bottom:10pt; }
    .mb15           { margin-bottom:15pt; }
    .mb40           { margin-bottom:40pt; }
    .p105           { padding:20pt 8pt; }
    .p128           { padding:12pt 8pt; }
    .p5             { padding:5pt 8pt; }
    .p8             { padding:8pt; }
    .p10            { padding:10pt; }
    .p20            { padding:20pt; }
    .linea          { height:5pt; }
    .bS1            { border:3pt solid #333; }
    .bRS1           { border-right:3pt solid #333; }
    .bBS1           { border-bottom:3pt solid #333; }
    .bTS1           { border-top:3pt solid #333; }
    .bB0            { border-bottom:none; }
    .bRad           { border-radius:10pt; }
    .bRad1          { border-radius:10pt 10pt 0 0; }
    .bRad2          { border-radius:0 0 10pt 10pt; }
    .vatop          { vertical-align:top;}
</style>

  </head>
  <body>
 
  
<div>
    <div class="pagion">
        <table width="100%" class="mb40">
            <tr>
                <td width="30%">
                   <img src="https://api.balquimia.com/storage/images/balquimia/logo.jpg" alt="">              
                </td>
              
                <td width="40%" class="taC">
                    <div class="t38 tB"> BALQUIMIA S.A.S </div>
                    <div class="t24">PBX: (+57-2) 488 1616</div>
                    <div class="t24 mb15">Calle 35 # 4-31 - Cali - Colombia</div>
                    <div >Visita nuestro sitio web:</div>
                    <div class="tB"> www.balquimia.com</a></div>
                </td>
                <td width="30%" class="taR">
                    <div class="t24">NIT: 900.755.214-4</div>
                    <div >RÉGIMEN IMPUESTOS SOBRE LAS VENTAS - IVA</div>
                    <div> &nbsp; </div>
                    <div>&nbsp; </div>  
                    <div> &nbsp;</div>
                    <div> &nbsp;</div>
                </td>
            </tr>
        </table>

        <div class="bAzul linea mb40"></div>

        <table width="100%" class="mb40">
            <tr>
                <td width="30%">
                    <div class="bAzul bS1 bRad1 bB0">
                        <table width="100%" class="taC colorfff tB">
                            <tr>
                                <td class="p8 bRS1">Fecha Nota crédito</td>
                            </tr>
                        </table>
                    </div>
                    <div class="bS1 bRad2">
                        <table width="100%" class="taC">
                            <tr>
                                <td width="33%" class="p5 bRS1">{{ $Fecha['FactDia'] }}</td>
                                <td width="33%" class="p5 bRS1">{{ $Fecha['FactMes'] }}</td>
                                <td width="34%" class="p5 bRS1">{{ $Fecha['Factyear'] }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td></td>

                <td width="30%">

                </td>

                <td></td>
                <td width="35%">
                    <div class="t26 taC mb3"><strong> NOTA CRÉDITO ELECTRÓNICA </strong> </div>
                    <div class="p8 bS1 bRad tB taC t32"> {{ $DocumentNumber  }}</div>
                </td>
            </tr>
        </table>

        <div class="bS1 bRad p20 mb40">
            <table width="100%"  >
                <tr >
                    <td width="10%" class="p5 tB">Cliente :</td>
                    <td width="35%" class="p5"> {{ $Customer['name'] }} </td>
                    <td width="10%" class="p5 tB">N.I.T.:</td>
                    <td width="25%" class="p5">{{ $Customer['identification_number'] }}</td>
                    <td width="10%" class="p5 tB">Firmado:</td>
                    <td width="20%" class="p5">{{ $Note['created_at'] }}</td>
                </tr>
                <tr>
                    <td width="10%" class="p5 tB">Dirección:</td>
                    <td width="25%" class="p5">{{ $Customer['address'] }}</td>
                    <td width="10%" class="p5 tB">Municipio:</td>
                    <td width="25%" class="p5">{{ $Additionals['mcipio'] . ' - '. $Additionals['dpto'] }}</td>
                    <td width="10%" class="p5 tB">Teléfono :</td>
                    <td width="20%" class="p5">{{ $Additionals['nro_tlfno'] }}</td>
                </tr>
                <tr>
                    <td width="10%" class="p5 tB">Email :</td>
                    <td width="25%" class="p5">{{ $Customer['email'] }}</td>
                    <td width="10%" class="p5 tB">Factura:</td>
                    <td width="25%" class="p5">{{ $Additionals['fctra_credit_note'] }} ( Documento cruce ) </td>

                </tr>

            </table>
        </div>

 

        <div class="bS1 bRad mb40">
            <table width="100%" class="bAzul taC colorfff tB">
                <tr>
                    <td width="15%" class="p8 bRS1">CANT</td>
                    <td width="55%" class="p8 bRS1">DESCRIPCIÓN</td>
                    <td width="15%" class="p8 bRS1">VR UNIT.</td>
                    <td width="15%" class="p8 bRS1">TOTAL</td>
                </tr>
            </table>
            <table width="100%">
                @foreach($Products as $Product )
                    <tr>
                        <td width="15%" class="p128 bRS1 taC">  {{ $Product['invoiced_quantity']                             }} </td>
                        <td width="55%" class="p128 bRS1">      {{ $Product['description']                                   }}</td>
                        <td width="15%" class="p128 bRS1 taR">  {{ Numbers::invoiceFormat($Product['price_amount'])          }}</td>
                        <td width="15%" class="p128 taR">       {{ Numbers::invoiceFormat($Product['line_extension_amount']) }}</td>
                    </tr>
                @endforeach
                {{ $CantFaltante= 32-$Product['CantProducts'] }}
                @for ($i = 1; $i <= $CantFaltante; $i++)
                     <tr>
                        <td width="15%" class="p128 bRS1"></td>
                        <td width="55%" class="p128 bRS1"></td>
                        <td width="15%" class="p128 bRS1 taR"></td>
                        <td width="15%" class="p128 taR"></td>
                    </tr>       
                @endfor 
            </table>
            <table class="bTS1" width="100%">
                <tr class="vatop">

                    <td width="70%" class="p128 bRS1">
                    <div class="mb15">
                            <strong>SON:</strong>
                            {{ $Additionals['vr_letras'] }}
                        </div>
                        <div class="mb15">
                            <strong>CUFE:</strong>
                            {{ $Note['uuid']}}
                        </div>

                        <div >
                            @if ( $Note['notes'] )
                                <strong>NOTAS:</strong>
                                {!! $Note['notes'] !!}
                            @endif
                        </div>
                    </td>

                    <td width="30%">
                        <table width="100%">
                            <tr>
                                <td width="50%" class="p105 tB bRS1 bBS1">SUBTOTAL :</td>
                                <td width="50%" class="t24 p105 bBS1 taR">{{ Numbers::invoiceFormat($Totals['line_extension_amount']) }}</td>
                            </tr>
                        </table>
                        <table width="100%">
                            <tr>
                                <td width="50%" class="p105 tB bRS1 bBS1">IVA</td>
                                <td width="50%" class="t24 p105 bBS1 taR">{{ Numbers::invoiceFormat($Additionals['vr_iva']) }}</td>
                            </tr>
                        </table>
                        <table width="100%">
                            <tr>
                                <td width="50%" class="p105 tB bRS1">TOTAL</td>
                                <td width="50%" class="t24 p105 taR">{{ Numbers::invoiceFormat($Totals['payable_amount']) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="bS1 bRad p10 mb40">
            <table width="100%">
                <tr>
                    <td width="70%" >
                        <div class="bS1 bRad">
                            <table class="bBS1 taC" width="100%">
                                <tr>
                                    <td width="40%" class="p5 bRS1">TIPO DE IMPUESTO</td>
                                    <td width="20%" class="p5 bRS1">BASE</td>
                                    <td width="20%" class="p5 bRS1">TARIFA</td>
                                    <td width="20%" class="p5">IMPUESTO</td>
                                </tr>
                            </table>
                            
                            <table width="100%">
                                <tr>
                                    <td width="40%" class="p5 bRS1">IVA</td>
                                    <td width="20%" class="p5 taR bRS1">{{ Numbers::invoiceFormat($Additionals['vr_base']) }}</td>
                                    <td width="20%" class="p5 taR bRS1">{{ Numbers::invoiceFormat($Additionals['pctje_iva']) .'%'}}</td>
                                    <td width="20%" class="p5 taR">{{ Numbers::invoiceFormat($Additionals['vr_iva']) }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td width="30%" class="taR">
                        <img src="data:image/png;base64,{{ base64_encode($CodigoQR) }}">
                          
                    </td>
                </tr>
            </table>
        </div>

        <div class="h60"></div>

        <div class="bS1 bRad p8 taC">
            <div class="t24 tB mb10"> </div>
            <div class="mb10">
 
            </div>
            <div class="tB"> 
            </div>
        </div>

    </div>
</div>



  </body>
</html>