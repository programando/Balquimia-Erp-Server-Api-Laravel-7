<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

 
</head>
<!--  -->
   <div style="max-width: 800px; font-family:Arial, Helvetica, sans-serif !important; width:90% !important; margin:0 auto !important; background:#F5F5F5 !important; padding:30px;" >

         <div style="text-align:center;  margin-bottom:30px;">                     
               <div style="font-weight:bold;font-size:20px; line-height:30px;"> BALQUIMIA S.A.S  </div>
               <div class="font-weight:bold;font-size:12px; line-height:15px;">PBX: (+57-2) 488 1616</div>
               <div class="font-weight:bold;font-size:12px; line-height:15px;">Calle 35 #4-31 - Cali - Colombia</div>
               <br>
               <div><h3>Hemos generado el siguiente documento electrónico:</h3></div>
         </div>

         <table width="100%" style="width:100%; margin:0 auto; border-collapse: collapse; ">
            <tr >
               <td style="width:100px;">Tipo :</td>
               <td> <strong> Factura electrónica</strong></td>      
            </tr>
            <tr>
               <td style="width:100px;">Número :</td>
               <td> <strong> {{ $Factura['document_number'] }} </strong></td>       
            </tr>
            <tr>
               <td style="width:100px;">CUFE :</td>
               <td><div style="font-weight:bold; word-wrap:break-word; width:220px; "> {{ $Factura['uuid'] }} </div></td>       
            </tr>
         </table>
         
         <table style="max-width: 800px; padding: 10px; margin:50px auto; border-collapse: collapse; ">
            <tr>
               <td colspan="2" style="text-align:center;">
                     <div style="width: 100%; text-align: center">
                        
                        <a href="https://www.google.com">
                           <div style="display:inline-block; text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #0BAD00">  
                              Aceptar documento 
                           </div>
                        </a>	
                           &nbsp;&nbsp;&nbsp;
                        <a href="#">
                           <div style="display:inline-block; text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #C91510">  
                              Rechazar documento 
                           </div>
                        </a>
 	
                     </div>
               </td>
            </tr>
            <tr> <td><hr></td> </tr>
            <tr>
               <td style="vertical-align:top;">
                  <div style="padding:0 30px; text-align:center; color: #999; font-size: 12px;">Si no acepta o rechaza el documento dentro de las siguientes 72 horas, éste será aceptado de manera automática por nuestro sistema de información.</div>
               </td>
               </tr>
         </table>

      </div>
  

</html>
