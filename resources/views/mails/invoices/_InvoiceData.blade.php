<h1 style="box-sizing:border-box;
   font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color   Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
   Hemos generado el siguiente documento electrónico:
</h1>

<div style="box-sizing:border-box;
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe   UI Emoji','Segoe UI Symbol'">
   <p>Cliente:   {{ $Factura['customer']['name'] }} </p>
   <p>Tipo documento:  Factura electrónica  </p>
   <p>Número documento:  {{ $Factura['document_number'] }} </p>
   <p>CUFE:  {{ $Factura['uuid'] }}  </p>
</div>
