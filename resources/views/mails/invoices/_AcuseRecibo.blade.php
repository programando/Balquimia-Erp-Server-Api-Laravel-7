<h4 style="box-sizing:border-box; 
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
      Acuse de recibido:
</h4>
<a 
   href="{{ url('invoices/accepted',$Factura['cstmer_token'] )}}" 
   style="box-sizing:border-box;
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#48bb78;border-bottom:8px solid #48bb78;border-left:18px solid #48bb78;border-right:18px solid #48bb78;border-top:8px solid #48bb78" target="_blank">
   Aceptar documento
</a>
&nbsp;&nbsp;&nbsp;
<a 
   href="{{ url('invoices/rejected',$Factura['cstmer_token'] )}}" 
   style="box-sizing:border-box; 
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#e53e3e;border-bottom:8px solid #e53e3e;border-left:18px solid #e53e3e;border-right:18px solid #e53e3e;border-top:8px solid #e53e3e" target="_blank">
   Rechazar documento
</a>
