<h1 style="box-sizing:border-box;
   font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color   Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
   Hemos generado el siguiente documento electrónico:
</h1>

<div style="box-sizing:border-box;
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe   UI Emoji','Segoe UI Symbol'">
   <p>Cliente:   {{ $Note['customer']['name'] }}  </p>
   <p>Tipo documento:  Nota crédito electrónica  </p>
   <p>Número documento:  {{  substr($FilePdf,0, strlen($FilePdf)-4) }}  </p>
   <p>CUFE:  {{ $Note['uuid'] }}    </p>
</div>
