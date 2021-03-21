<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body style="box-sizing: border-box; 
         font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; 
         position: relative; 
         -webkit-text-size-adjust: none; 
         background-color: #ffffff; 
         color: #718096; 
         height: 100%; 
         line-height: 1.4; 
         margin: 0; 
         padding: 0; width: 100% !important;" >

   <div style="box-sizing:border-box;
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe   UI Emoji','Segoe UI Symbol';   
      background-color:#ffffff;     color:#718096;    height:100%;   line-height:1.4;   margin:0;      padding:0;     width:100%!important">
      <table width="100%" cellpadding="0" cellspacing="0" 
         style="height:100%; box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%">
         <tbody>
            <tr>
               <td  style="box-sizing:border-box;
                  font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                  <table width="100%" cellpadding="0" cellspacing="0" style="box-sizing:border-box;
                     font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,
                     Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
                     margin:0;padding:0;width:100%">
                     <tr> 
                        @include('mails.partials.TituloEmpresa') 
                     </tr>
                     <tr>
                        <td width="100%" cellpadding="0" cellspacing="0" style="box-sizing:border-box;
                           font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%">
                           <table align="center"  width="570" cellpadding="0" cellspacing="0" style="box-sizing:border-box;
                              font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:570px">
                              <tbody>
                                 <tr>
                                    <td style="box-sizing:border-box;
                                       font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';max-width:100vw;padding:32px">
                                       Ha recibido este correo electónico desde la página de balquimia.com <br>

                                       <p> {{ $comentario }} </p>
                                       <p>  Interesado(a) en :</p>
                                       <p> &nbsp;&nbsp;&nbsp; {{ $comentario }} </p>
                                       <p>  Empresa : </p>
                                       <p> &nbsp;&nbsp;&nbsp; {{ $comentario   }}    </p>
                                       <p> Números de contacto : </p>
                                       <p>  &nbsp;&nbsp;&nbsp; {{ $comentario  }} / {{ $comentario }} </p>
                                       
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                      <tr>
                         @include('mails.notes._Footer') 
                     </tr>
            </tbody>
         </table>
         </td>
      </tr>
   </tbody>
   </table>
</div>

</body>